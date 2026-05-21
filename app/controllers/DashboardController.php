<?php

declare(strict_types=1);

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../core/Flash.php';
require_once __DIR__ . '/../core/Csrf.php';

class DashboardController
{
    public function __construct()
    {
        AuthMiddleware::check();
    }

    public function index(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!empty($user['is_admin'])) {
            redirect('admin', 'index');
        }

        $materialModel     = new Material();
        // Load orders from database instead of session
        $allOrders         = $materialModel->allOrders();
        $myOrders          = array_filter($allOrders, fn($o) => $o['client_id'] == ($user['id'] ?? 0));
        $pendingCount      = count(array_filter($myOrders, fn($o) => strtolower($o['order_status'] ?? '') === 'pending'));
        $completedCount    = count(array_filter($myOrders, fn($o) => strtolower($o['order_status'] ?? '') === 'completed'));
        $featuredMaterials = array_slice($materialModel->active(), 0, 3);

        require __DIR__ . '/../views/dashboard/index.php';
    }

    public function shop(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!empty($user['is_admin'])) {
            redirect('admin', 'index');
        }

        $materialModel = new Material();
        $search        = trim($_GET['search'] ?? '');
        $materials     = $search !== '' ? $materialModel->search($search) : $materialModel->active();
        require __DIR__ . '/../views/dashboard/shop.php';
    }

    public function orders(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!empty($user['is_admin'])) {
            redirect('admin', 'index');
        }

        $materialModel = new Material();
        // Load orders from database instead of session
        $allOrders = $materialModel->allOrders();
        $orders = array_filter($allOrders, fn($o) => $o['client_id'] == ($user['id'] ?? 0));
        
        // Sort orders by date - newest first (descending order)
        usort($orders, function($a, $b) {
            $dateA = strtotime($a['order_date'] ?? '0');
            $dateB = strtotime($b['order_date'] ?? '0');
            return $dateB - $dateA; // Descending order (newest first)
        });
        
        require __DIR__ . '/../views/dashboard/myOrder.php';
    }

    public function settings(): void
    {
        $user = $_SESSION['user'] ?? null;

        if (!empty($user['is_admin'])) {
            redirect('admin', 'index');
        }

        require __DIR__ . '/../views/dashboard/settings.php';
    }

    public function confirmDelivery(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('dashboard', 'orders');
        }

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('dashboard', 'orders');
        }

        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            redirect('auth', 'index');
        }

        $orderId = (int)($_POST['order_id'] ?? 0);
        if ($orderId <= 0) {
            Flash::set('error', 'Invalid order ID.');
            redirect('dashboard', 'orders');
        }

        $materialModel = new Material();
        
        if ($materialModel->confirmDelivery($orderId, (int)($user['id'] ?? 0))) {
            $materialModel->log('Delivery Confirmed', "Order #{$orderId} delivery confirmed by user",
                (int)($user['id'] ?? 0), $user['name'] ?? 'Unknown');
            Flash::set('success', 'Delivery confirmed successfully! Thank you for your confirmation.');
        } else {
            Flash::set('error', 'Unable to confirm delivery. Please contact support if this order was delivered.');
        }

        redirect('dashboard', 'orders');
    }

    public function cancelOrder(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('dashboard', 'orders');
        }

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('dashboard', 'orders');
        }

        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            redirect('auth', 'index');
        }

        $orderId = (int)($_POST['order_id'] ?? 0);
        if ($orderId <= 0) {
            Flash::set('error', 'Invalid order ID.');
            redirect('dashboard', 'orders');
        }

        $materialModel = new Material();

        // Verify order belongs to this user
        $order = $materialModel->findOrder($orderId);
        if (!$order || (int)$order['client_id'] !== (int)($user['id'] ?? 0)) {
            Flash::set('error', 'Order not found.');
            redirect('dashboard', 'orders');
        }

        // Block cancellation if out for delivery, completed, or already cancelled
        $status = strtolower($order['order_status'] ?? '');
        $nonCancellable = ['out_for_delivery', 'completed', 'cancelled'];
        if (in_array($status, $nonCancellable)) {
            Flash::set('error', 'This order cannot be cancelled — it is already ' . str_replace('_', ' ', $status) . '.');
            redirect('dashboard', 'orders');
        }

        // Cancel the order and restore stock
        if ($materialModel->cancelOrder($orderId)) {
            $materialModel->log('Order Cancelled', "Order #{$orderId} cancelled by user",
                (int)($user['id'] ?? 0), $user['name'] ?? 'Unknown');
            Flash::set('success', "Order #{$orderId} has been cancelled successfully.");
        } else {
            Flash::set('error', 'Failed to cancel order. Please try again.');
        }

        redirect('dashboard', 'orders');
    }

}
