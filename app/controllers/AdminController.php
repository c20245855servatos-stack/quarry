<?php

declare(strict_types=1);

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Flash.php';
require_once __DIR__ . '/../core/Csrf.php';

class AdminController
{
    private Material $material;
    private User $user;
    private array $sessionUser;

    public function __construct()
    {
        AuthMiddleware::check();

        if (empty($_SESSION['user']['is_admin'])) {
            redirect('dashboard', 'index');
        }

        $this->material    = new Material();
        $this->user        = new User();
        $this->sessionUser = $_SESSION['user'];
    }

    public function index(): void
    {
        try {
            $stats = [
                'users'     => $this->material->usersCount() ?? 0,
                'materials' => $this->material->count() ?? 0,
                'orders'    => $this->material->ordersCount() ?? 0,
                'pending'   => $this->material->pendingOrdersCount() ?? 0,
                'revenue'   => $this->material->totalRevenue() ?? 0,
            ];
            $recentOrders = $this->material->recentOrders(6) ?? [];
            $recentLog    = $this->material->activityLog(5) ?? [];
            $salesByMonth = $this->material->salesByMonth() ?? [];
            $topMaterials = $this->material->topMaterials() ?? [];
            
            // Get stock alerts for dashboard
            $stockAlerts = $this->material->getStockAlerts();
            $stockSummary = $this->material->getStockSummary();
            
        } catch (Exception $e) {
            // Fallback data if database queries fail
            $stats = [
                'users'        => 0,
                'materials'    => 0,
                'orders'       => 0,
                'pending'      => 0,
                'revenue'      => 0,
            ];
            $recentOrders = [];
            $recentLog    = [];
            $salesByMonth = [];
            $topMaterials = [];
            $stockAlerts = [];
            $stockSummary = [];
            
            error_log("Admin dashboard error: " . $e->getMessage());
        }
        
        require __DIR__ . '/../views/admin/index.php';
    }

    public function materials(): void
    {
        $materials = $this->material->all();
        require __DIR__ . '/../views/admin/materials.php';
    }

    public function addMaterial(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF validation
            if (!Csrf::validate($_POST['_csrf'] ?? '')) {
                Flash::set('error', 'Invalid request. Please try again.');
                redirect('admin', 'materials');
            }

            $name        = trim($_POST['name']        ?? '');
            $description = trim($_POST['description'] ?? '');
            $price       = (float)($_POST['price']    ?? 0);
            $unit        = trim($_POST['unit']         ?? 'per cubic meter');
            $stock       = (int)($_POST['stock']       ?? 0);
            $image       = null;

            if ($name === '' || $price <= 0 || $stock < 0) {
                Flash::set('error', 'Name, valid price (>0), and non-negative stock are required.');
                redirect('admin', 'materials');
            }

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $file    = $_FILES['image'];
                $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (in_array($file['type'], $allowed) && $file['size'] <= 5 * 1024 * 1024) {
                    $ext       = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $filename  = 'material_new_' . time() . '.' . $ext;
                    $uploadDir = BASE_PATH . '/app/public/assets/imgs/materials/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                    if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
                        $image = $filename;
                    }
                }
            }
            // Handle image URL
            elseif (!empty($_POST['image_url'])) {
                $url = trim($_POST['image_url']);
                if (filter_var($url, FILTER_VALIDATE_URL)) {
                    $image = $url;
                }
            }

            if ($this->material->createWithImage($name, $description, $price, $unit, $stock, $image)) {
                $this->material->log('Material Added', "Added: {$name} @ ₱{$price}",
                    $this->sessionUser['id'] ?? null, $this->sessionUser['name'] ?? null);
                Flash::set('success', "Material '{$name}' added.");
            } else {
                Flash::set('error', 'Failed to add material.');
            }
        }
        redirect('admin', 'materials');
    }

    public function editMaterial(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF validation
            if (!Csrf::validate($_POST['_csrf'] ?? '')) {
                Flash::set('error', 'Invalid request. Please try again.');
                redirect('admin', 'materials');
            }

            $name        = trim($_POST['name']        ?? '');
            $description = trim($_POST['description'] ?? '');
            $price       = (float)($_POST['price']    ?? 0);
            $unit        = trim($_POST['unit']         ?? 'per cubic meter');
            $stock       = (int)($_POST['stock']       ?? 0);
            $is_active   = (int)($_POST['is_active']   ?? 1);
            $image       = null;

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $file = $_FILES['image'];
                $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                
                if (!in_array($file['type'], $allowed)) {
                    Flash::set('error', 'Only image files are allowed (JPG, PNG, GIF, WebP).');
                    redirect('admin', 'materials');
                }

                if ($file['size'] > 5 * 1024 * 1024) { // 5MB limit
                    Flash::set('error', 'Image size must be less than 5MB.');
                    redirect('admin', 'materials');
                }

                $filename = 'material_' . $id . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                $uploadDir  = BASE_PATH . '/app/public/assets/imgs/materials/';
                $uploadPath = $uploadDir . $filename;
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    $image = $filename;
                } else {
                    Flash::set('error', 'Failed to upload image.');
                    redirect('admin', 'materials');
                }
            }
            // Handle image URL
            elseif (!empty($_POST['image_url'])) {
                $imageUrl = trim($_POST['image_url']);
                if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                    $image = $imageUrl;
                } else {
                    Flash::set('error', 'Invalid image URL.');
                    redirect('admin', 'materials');
                }
            }

            if ($this->material->update($id, $name, $description, $price, $unit, $stock, $is_active, $image)) {
                $this->material->log('Material Updated', "Updated ID {$id}: {$name}",
                    $this->sessionUser['id'] ?? null, $this->sessionUser['name'] ?? null);
                Flash::set('success', 'Material updated.');
            } else {
                Flash::set('error', 'Failed to update material.');
            }
            redirect('admin', 'materials');
        }

        $editMaterial = $this->material->find($id);
        if (!$editMaterial) {
            redirect('admin', 'materials');
        }

        $materials = $this->material->all();
        require __DIR__ . '/../views/admin/materials.php';
    }

    public function deleteMaterial(): void
    {
        $id  = (int)($_GET['id'] ?? 0);
        $mat = $this->material->find($id);

        if ($mat && $this->material->delete($id)) {
            $this->material->log('Material Deleted', "Deleted: {$mat['material_name']}",
                $this->sessionUser['id'] ?? null, $this->sessionUser['name'] ?? null);
            Flash::set('success', 'Material deleted.');
        } else {
            Flash::set('error', 'Failed to delete material.');
        }
        redirect('admin', 'materials');
    }

    public function archiveMaterial(): void
    {
        $id  = (int)($_GET['id'] ?? 0);
        $mat = $this->material->find($id);

        if (!$mat) {
            Flash::set('error', 'Material not found.');
            redirect('admin', 'materials');
        }

        // Set is_active = 0 (archive) instead of deleting
        if ($this->material->update(
            $id,
            $mat['material_name'],
            $mat['description'] ?? '',
            (float)$mat['unit_price'],
            $mat['unit_type'] ?? 'per cubic meter',
            (int)$mat['stock_quantity'],
            0, // is_active = 0
            null
        )) {
            $this->material->log('Material Archived', "Archived: {$mat['material_name']}",
                $this->sessionUser['id'] ?? null, $this->sessionUser['name'] ?? null);
            Flash::set('success', "'{$mat['material_name']}' has been archived and hidden from the shop.");
        } else {
            Flash::set('error', 'Failed to archive material.');
        }
        redirect('admin', 'materials');
    }

    public function restoreMaterial(): void
    {
        $id  = (int)($_GET['id'] ?? 0);
        $mat = $this->material->find($id);

        if (!$mat) {
            Flash::set('error', 'Material not found.');
            redirect('admin', 'materials');
        }

        // Set is_active = 1 (restore)
        if ($this->material->update(
            $id,
            $mat['material_name'],
            $mat['description'] ?? '',
            (float)$mat['unit_price'],
            $mat['unit_type'] ?? 'per cubic meter',
            (int)$mat['stock_quantity'],
            1, // is_active = 1
            null
        )) {
            $this->material->log('Material Restored', "Restored: {$mat['material_name']}",
                $this->sessionUser['id'] ?? null, $this->sessionUser['name'] ?? null);
            Flash::set('success', "'{$mat['material_name']}' has been restored to the shop.");
        } else {
            Flash::set('error', 'Failed to restore material.');
        }
        redirect('admin', 'materials');
    }

    public function orders(): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10; // Orders per page
        $status = $_GET['status'] ?? 'all';
        
        // Get paginated orders
        $result = $this->material->getOrdersPaginated($page, $perPage, $status);
        $orders = $result['orders'];
        $pagination = $result['pagination'];
        
        require __DIR__ . '/../views/admin/orders.php';
    }

    public function updateOrder(): void
    {
        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('admin', 'orders');
        }

        $id           = (int)($_POST['order_id']     ?? 0);
        $status       = trim($_POST['status']         ?? 'pending');
        $deliveryDate = trim($_POST['delivery_date']  ?? '') ?: null;
        $arrivalDate  = trim($_POST['arrival_date']   ?? '') ?: null;

        $allowed = ['pending','confirmed','processing','out_for_delivery','completed','cancelled'];
        if (!in_array($status, $allowed, true)) {
            $status = 'pending';
        }

        // When marking as completed, auto-fill today's date for any missing dates
        if ($status === 'completed') {
            $today = date('Y-m-d');
            if ($deliveryDate === null) $deliveryDate = $today;
            if ($arrivalDate  === null) $arrivalDate  = $today;
        }

        // Check daily delivery limit (max 5 per day)
        if ($deliveryDate !== null) {
            $existingOnDate = $this->material->countOrdersOnDate($deliveryDate, $id);
            if ($existingOnDate >= 5) {
                Flash::set('error', "Cannot assign delivery on {$deliveryDate} — the daily limit of 5 orders has been reached.");
                redirect('admin', 'orders');
            }
        }

        // Fetch current status before updating to avoid double-restoring stock
        $existingOrder = $this->material->findOrder($id);
        $previousStatus = strtolower($existingOrder['order_status'] ?? '');

        if ($this->material->updateOrderStatus($id, $status, $deliveryDate, $arrivalDate)) {
            // Restore stock only when transitioning TO cancelled (not already cancelled)
            if ($status === 'cancelled' && $previousStatus !== 'cancelled') {
                $items = $this->material->orderItems($id);
                foreach ($items as $item) {
                    $materialId = (int)($item['material_id'] ?? 0);
                    $quantity   = (int)($item['quantity'] ?? 0);
                    if ($materialId > 0 && $quantity > 0) {
                        $this->material->replenishStock($materialId, $quantity, "Order #{$id} cancelled by admin");
                    }
                }
            }

            $logDetails = "Order #{$id} → {$status}";
            if ($deliveryDate) $logDetails .= ", delivery: {$deliveryDate}";
            if ($arrivalDate) $logDetails .= ", arrived: {$arrivalDate}";
            
            $this->material->log('Order Updated', $logDetails,
                $this->sessionUser['id'] ?? null, $this->sessionUser['name'] ?? null);
            Flash::set('success', "Order #{$id} updated.");
        } else {
            Flash::set('error', 'Failed to update order.');
        }
        redirect('admin', 'orders');
    }

    public function sales(): void
    {
        $salesByMonth = $this->material->salesByMonth();
        $topMaterials = $this->material->topMaterials();
        $totalRevenue = $this->material->totalRevenue();
        $allOrders    = $this->material->allOrders();
        require __DIR__ . '/../views/admin/sales.php';
    }

    public function log(): void
    {
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $filter  = trim($_GET['filter'] ?? '');

        $result     = $this->material->activityLogPaginated($page, $perPage, $filter);
        $logs       = $result['logs'];
        $pagination = $result['pagination'];

        require __DIR__ . '/../views/admin/log.php';
    }

    public function calendar(): void
    {
        $deliveries = $this->material->deliveryCalendar();
        require __DIR__ . '/../views/admin/calendar.php';
    }

    public function users(): void
    {
        $users = $this->user->all();
        require __DIR__ . '/../views/admin/users.php';
    }

    public function deleteUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin', 'users');
        }

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('admin', 'users');
        }

        $id = (int)($_POST['id'] ?? 0);
        $u  = $this->user->find($id);

        if ($u && $this->user->delete($id)) {
            $this->material->log('User Deleted', "Deleted: {$u['full_name']} ({$u['email']})",
                $this->sessionUser['id'] ?? null, $this->sessionUser['name'] ?? null);
            Flash::set('success', 'User deleted.');
        } else {
            Flash::set('error', 'Failed to delete user.');
        }
        redirect('admin', 'users');
    }

    public function manageImages(): void
    {
        $materials = $this->material->all();
        require __DIR__ . '/../views/admin/manage_images.php';
    }

    public function uploadImage(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin', 'manageImages');
        }

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('admin', 'manageImages');
        }

        $id = (int)($_POST['material_id'] ?? 0);
        $mat = $this->material->find($id);

        if (!$mat) {
            Flash::set('error', 'Material not found.');
            redirect('admin', 'manageImages');
        }

        if (empty($_FILES['image']['name'])) {
            Flash::set('error', 'Please select an image.');
            redirect('admin', 'manageImages');
        }

        $file = $_FILES['image'];
        $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        
        if (!in_array($file['type'], $allowed)) {
            Flash::set('error', 'Only image files are allowed (JPG, PNG, GIF, WebP).');
            redirect('admin', 'manageImages');
        }

        if ($file['size'] > 5 * 1024 * 1024) { // 5MB limit
            Flash::set('error', 'Image size must be less than 5MB.');
            redirect('admin', 'manageImages');
        }

        $filename = 'material_' . $id . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $uploadDir  = BASE_PATH . '/app/public/assets/imgs/materials/';
        $uploadPath = $uploadDir . $filename;
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            if ($this->material->update($id, $mat['material_name'], $mat['description'], $mat['unit_price'], $mat['unit_type'], $mat['stock_quantity'], $mat['is_active'], $filename)) {
                $this->material->log('Material Image Updated', "Updated image for: {$mat['material_name']}",
                    $this->sessionUser['id'] ?? null, $this->sessionUser['name'] ?? null);
                Flash::set('success', 'Image uploaded successfully!');
            } else {
                Flash::set('error', 'Failed to save image to database.');
            }
        } else {
            Flash::set('error', 'Failed to upload image.');
        }
        redirect('admin', 'manageImages');
    }

    // ===== STOCK MANAGEMENT METHODS =====

    public function stockManagement(): void
    {
        $stockSummary = $this->material->getStockSummary();
        $lowStockMaterials = $this->material->getLowStockMaterials();
        $outOfStockMaterials = $this->material->getOutOfStockMaterials();
        $stockAlerts = $this->material->getStockAlerts();
        $allMaterials = $this->material->all();
        
        require __DIR__ . '/../views/admin/stock_management.php';
    }

    public function replenishStock(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin', 'stockManagement');
        }

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('admin', 'stockManagement');
        }

        $materialId = (int)($_POST['material_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 0);
        $reason = trim($_POST['reason'] ?? '');

        if ($materialId <= 0 || $quantity <= 0) {
            Flash::set('error', 'Invalid material ID or quantity.');
            redirect('admin', 'stockManagement');
        }

        $material = $this->material->find($materialId);
        if (!$material) {
            Flash::set('error', 'Material not found.');
            redirect('admin', 'stockManagement');
        }

        if ($this->material->replenishStock($materialId, $quantity, $reason)) {
            $materialName = $material['material_name'];
            $newStock = $this->material->getStockQuantity($materialId);
            
            Flash::set('success', "Successfully added {$quantity} units to '{$materialName}'. New stock: {$newStock} units.");
            
            // Log the action
            $this->material->log(
                'Stock Replenished',
                "Added {$quantity} units to {$materialName} (New total: {$newStock})" . ($reason ? " - {$reason}" : ""),
                $this->sessionUser['id'] ?? null,
                $this->sessionUser['name'] ?? null
            );
        } else {
            Flash::set('error', 'Failed to replenish stock.');
        }

        redirect('admin', 'stockManagement');
    }

    public function getStockAlerts(): void
    {
        header('Content-Type: application/json');
        
        try {
            $alerts = $this->material->getStockAlerts();
            echo json_encode([
                'success' => true,
                'alerts' => $alerts,
                'count' => count($alerts)
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to fetch stock alerts',
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }

    public function settings(): void
    {
        require __DIR__ . '/../views/admin/settings.php';
    }

    public function changePassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin', 'settings');
        }

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('admin', 'settings');
        }

        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            Flash::set('error', 'User not found.');
            redirect('auth', 'index');
        }

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validation
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            Flash::set('error', 'All password fields are required.');
            redirect('admin', 'settings');
        }

        if (strlen($newPassword) < 6) {
            Flash::set('error', 'New password must be at least 6 characters long.');
            redirect('admin', 'settings');
        }

        if ($newPassword !== $confirmPassword) {
            Flash::set('error', 'New password and confirmation do not match.');
            redirect('admin', 'settings');
        }

        // Verify current password
        $user = $this->user->find($userId);
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            Flash::set('error', 'Current password is incorrect.');
            redirect('admin', 'settings');
        }

        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        if ($this->user->updatePassword($userId, $hashedPassword)) {
            Flash::set('success', 'Password changed successfully.');
        } else {
            Flash::set('error', 'Failed to change password. Please try again.');
        }

        redirect('admin', 'settings');
    }
}
