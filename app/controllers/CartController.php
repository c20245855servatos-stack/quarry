<?php

declare(strict_types=1);

require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../core/Flash.php';
require_once __DIR__ . '/../core/Csrf.php';

class CartController
{
    public function __construct()
    {
        AuthMiddleware::check();
    }

    public function index(): void
    {
        $user = $_SESSION['user'] ?? null;
        $cart = [];
        
        if ($user && !empty($user['id'])) {
            // Load cart from database
            $materialModel = new Material();
            $dbCart = $materialModel->getUserCart((int)$user['id']);
            
            // Convert database format to session format for compatibility
            foreach ($dbCart as $item) {
                // Only skip if material is explicitly inactive (is_active = 0)
                // Don't skip if is_active is NULL (material join may have failed)
                if (isset($item['is_active']) && (int)$item['is_active'] === 0) {
                    continue;
                }

                $cart[] = [
                    'id'    => $item['material_id'],
                    'name'  => $item['material_name'],
                    'price' => (float)$item['unit_price'],
                    'unit'  => $item['unit_type'],
                    'qty'   => (int)$item['quantity'],
                    'stock' => (int)($item['stock_quantity'] ?? 0)
                ];
            }
            
            // Update session cart to match database
            $_SESSION['cart'] = $cart;
        } else {
            // Fallback to session cart for guests
            $cart = $_SESSION['cart'] ?? [];
        }
        
        require __DIR__ . '/../views/cart/index.php';
    }

    public function add(): void
    {
        $materialId    = (int)($_GET['id'] ?? 0);
        $quantity      = max(1, (int)($_GET['quantity'] ?? 1));
        $materialModel = new Material();
        $material      = $materialModel->find($materialId);

        if (!$material) {
            if ($this->isAjaxRequest()) {
                $this->jsonResponse(['success' => false, 'message' => 'Material not found.']);
            }
            Flash::set('error', 'Material not found.');
            redirect('dashboard', 'shop');
        }

        // Validate quantity against stock
        $stock = (int)($material['stock_quantity'] ?? 0);
        if ($quantity > $stock) {
            if ($this->isAjaxRequest()) {
                $this->jsonResponse(['success' => false, 'message' => "Only {$stock} units available in stock."]);
            }
            Flash::set('error', "Only {$stock} units available in stock.");
            redirect('dashboard', 'shop');
        }

        $user = $_SESSION['user'] ?? null;
        
        if ($user && !empty($user['id'])) {
            // Check how much is already in the cart for this material
            $dbCart = $materialModel->getUserCart((int)$user['id']);
            $alreadyInCart = 0;
            foreach ($dbCart as $cartItem) {
                if ((int)$cartItem['material_id'] === $materialId) {
                    $alreadyInCart = (int)$cartItem['quantity'];
                    break;
                }
            }
            $totalRequested = $alreadyInCart + $quantity;
            if ($totalRequested > $stock) {
                $canAdd = $stock - $alreadyInCart;
                if ($canAdd <= 0) {
                    if ($this->isAjaxRequest()) {
                        $this->jsonResponse(['success' => false, 'message' => "You already have the maximum available stock ({$stock}) in your cart."]);
                    }
                    Flash::set('error', "You already have the maximum available stock ({$stock}) in your cart.");
                    redirect('dashboard', 'shop');
                }
                if ($this->isAjaxRequest()) {
                    $this->jsonResponse(['success' => false, 'message' => "Only {$canAdd} more unit(s) can be added. You already have {$alreadyInCart} in your cart."]);
                }
                Flash::set('error', "Only {$canAdd} more unit(s) can be added. You already have {$alreadyInCart} in your cart.");
                redirect('dashboard', 'shop');
            }
            // Add to persistent database cart
            try {
                $result = $materialModel->addToCart(
                    (int)$user['id'],
                    $materialId,
                    $material['material_name'] ?? '',
                    (float)($material['unit_price'] ?? 0),
                    $material['unit_type'] ?? '',
                    $quantity
                );
                
                if ($result) {
                    // Update session cart to reflect database
                    $this->syncCartToSession((int)$user['id'], $materialModel);
                    
                    // Log the cart addition
                    $materialModel->log(
                        'Item Added to Cart',
                        "Added {$quantity} x {$material['material_name']} to cart",
                        (int)$user['id'],
                        $user['name'] ?? 'Unknown'
                    );
                    
                    $qtyText = $quantity > 1 ? "{$quantity} units of" : "";
                    $message = "{$qtyText} '{$material['material_name']}' added to cart.";
                    
                    if ($this->isAjaxRequest()) {
                        $cartCount = $materialModel->getCartCount((int)$user['id']);
                        $this->jsonResponse([
                            'success' => true, 
                            'message' => $message,
                            'material' => $material,
                            'quantity' => $quantity,
                            'cartCount' => $cartCount
                        ]);
                    }
                    
                    Flash::set('success', $message);
                } else {
                    if ($this->isAjaxRequest()) {
                        $this->jsonResponse(['success' => false, 'message' => 'Failed to add item to cart.']);
                    }
                    Flash::set('error', 'Failed to add item to cart.');
                }
            } catch (Exception $e) {
                error_log("CART ADD ERROR: " . $e->getMessage());
                if ($this->isAjaxRequest()) {
                    $this->jsonResponse(['success' => false, 'message' => 'Failed to add item to cart.']);
                }
                Flash::set('error', 'Failed to add item to cart.');
            }
        } else {
            // Fallback to session cart for guests
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ((int)$item['id'] === $materialId) {
                    $newQty = $item['qty'] + $quantity;
                    
                    // Check if new quantity exceeds stock
                    if ($newQty > $stock) {
                        if ($this->isAjaxRequest()) {
                            $this->jsonResponse(['success' => false, 'message' => "Cannot add {$quantity} more. Only {$stock} units available in stock."]);
                        }
                        Flash::set('error', "Cannot add {$quantity} more. Only {$stock} units available in stock.");
                        redirect('dashboard', 'shop');
                    }
                    
                    $item['qty'] = $newQty;
                    $found = true;
                    break;
                }
            }
            unset($item);

            if (!$found) {
                $_SESSION['cart'][] = [
                    'id'    => $materialId,
                    'name'  => $material['material_name'] ?? '',
                    'price' => (float)($material['unit_price'] ?? 0),
                    'unit'  => $material['unit_type'] ?? '',
                    'qty'   => $quantity,
                ];
            }
            
            $qtyText = $quantity > 1 ? "{$quantity} units of" : "";
            $message = "{$qtyText} '{$material['material_name']}' added to cart.";
            
            if ($this->isAjaxRequest()) {
                $cartCount = count($_SESSION['cart'] ?? []);
                $this->jsonResponse([
                    'success' => true, 
                    'message' => $message,
                    'material' => $material,
                    'quantity' => $quantity,
                    'cartCount' => $cartCount
                ]);
            }
            
            Flash::set('success', $message);
        }

        // Only redirect for non-AJAX requests
        if (!$this->isAjaxRequest()) {
            redirect('dashboard', 'shop');
        }
    }

    private function isAjaxRequest(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private function jsonResponse(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function details(): void
    {
        $materialId = (int)($_GET['id'] ?? 0);
        $materialModel = new Material();
        $material = $materialModel->find($materialId);

        if (!$material) {
            Flash::set('error', 'Material not found.');
            redirect('dashboard', 'shop');
        }

        require __DIR__ . '/../views/cart/details.php';
    }

    public function remove(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('cart', 'index');
        }

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('cart', 'index');
        }

        $user = $_SESSION['user'] ?? null;
        $materialId = (int)($_POST['id'] ?? 0);

        if ($materialId <= 0) {
            redirect('cart', 'index');
        }

        if ($user && !empty($user['id'])) {
            $materialModel = new Material();
            // Verify item belongs to this user's cart before removing
            $dbCart = $materialModel->getUserCart((int)$user['id']);
            $inCart = false;
            foreach ($dbCart as $cartItem) {
                if ((int)$cartItem['material_id'] === $materialId) {
                    $inCart = true;
                    break;
                }
            }
            if ($inCart) {
                $materialModel->removeFromCart((int)$user['id'], $materialId);
                $this->syncCartToSession((int)$user['id'], $materialModel);
            }
        } else {
            $_SESSION['cart'] = array_filter(
                $_SESSION['cart'] ?? [],
                fn($item) => (int)($item['id'] ?? 0) !== $materialId
            );
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }

        redirect('cart', 'index');
    }

    public function checkout(): void
    {
        $cart = $_SESSION['cart'] ?? [];
        require __DIR__ . '/../views/cart/checkout.php';
    }

    public function placeOrder(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('cart', 'index');
        }

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('cart', 'index');
        }

        if (empty($_SESSION['cart'])) {
            redirect('cart', 'index');
        }

        $user = $_SESSION['user'] ?? null;
        if (!$user) {
            redirect('auth', 'index');
        }

        $materialModel = new Material();

        // ── SECURITY: Re-fetch all prices and names from DB — never trust client-side values ──
        $verifiedItems = [];
        $stockErrors   = [];

        foreach ($_SESSION['cart'] as $item) {
            $materialId = (int)($item['id'] ?? $item['material_id'] ?? 0);
            $requestedQty = (int)($item['qty'] ?? $item['quantity'] ?? 1);

            // Hard server-side quantity bounds — reject anything outside 1–9999
            if ($materialId <= 0 || $requestedQty < 1 || $requestedQty > 9999) continue;

            // Always fetch fresh data from DB
            $dbMaterial = $materialModel->find($materialId);
            if (!$dbMaterial || !($dbMaterial['is_active'] ?? true)) {
                $stockErrors[] = "'{$item['name']}' is no longer available.";
                continue;
            }

            $availableStock = (int)($dbMaterial['stock_quantity'] ?? 0);
            if ($availableStock < $requestedQty) {
                $stockErrors[] = "{$dbMaterial['material_name']}: Only {$availableStock} units available, but {$requestedQty} requested.";
                continue;
            }

            $verifiedItems[] = [
                'id'           => $materialId,
                'material_id'  => $materialId,
                'name'         => $dbMaterial['material_name'],   // from DB
                'price'        => (float)$dbMaterial['unit_price'], // from DB — not from session
                'unit'         => $dbMaterial['unit_type'],        // from DB
                'qty'          => $requestedQty,
            ];
        }

        if (!empty($stockErrors)) {
            foreach ($stockErrors as $error) {
                Flash::set('error', $error);
            }
            redirect('cart', 'index');
        }

        if (empty($verifiedItems)) {
            Flash::set('error', 'No valid items in cart.');
            redirect('cart', 'index');
        }

        // Calculate total using DB prices only
        $total = 0;
        $items = [];
        foreach ($verifiedItems as $item) {
            $subtotal = $item['price'] * $item['qty'];
            $total   += $subtotal;
            $items[]  = [
                'material_id' => $item['material_id'],
                'price'       => $item['price'],
                'qty'         => $item['qty'],
            ];
        }

        // Save order to database
        $orderId = $materialModel->createOrder((int)($user['id'] ?? 0), $total, $items);

        if ($orderId) {
            $stockUpdateSuccess = true;
            foreach ($verifiedItems as $item) {
                if (!$materialModel->updateStock($item['material_id'], $item['qty'])) {
                    $stockUpdateSuccess = false;
                    error_log("STOCK UPDATE FAILED for material {$item['material_id']}, quantity {$item['qty']}");
                }
            }

            $materialModel->log('Order Placed', "Order #{$orderId} - Total: ₱{$total}",
                (int)($user['id'] ?? 0), $user['name'] ?? 'Unknown');

            $_SESSION['cart'] = [];
            if ($user && !empty($user['id'])) {
                $materialModel->clearUserCart((int)$user['id']);
            }

            Flash::set('success', 'Order placed successfully!');
        } else {
            Flash::set('error', 'Failed to place order. Please try again.');
        }

        redirect('dashboard', 'orders');
    }

    public function setDeliveryDate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('cart', 'index');
        }

        $date = trim($_POST['delivery_date'] ?? '');

        if ($date === '') {
            unset($_SESSION['preferred_delivery_date']);
            redirect('cart', 'index');
        }

        // Validate it's a real date
        $parsed = DateTime::createFromFormat('Y-m-d', $date);
        if (!$parsed || $parsed->format('Y-m-d') !== $date) {
            Flash::set('error', 'Invalid delivery date.');
            redirect('cart', 'index');
        }

        // Validate it's within the allowed range (tomorrow to +30 days)
        $tomorrow = new DateTime('+1 day');
        $tomorrow->setTime(0, 0, 0);
        $maxDate  = new DateTime('+30 days');
        $maxDate->setTime(23, 59, 59);

        if ($parsed < $tomorrow || $parsed > $maxDate) {
            Flash::set('error', 'Please select a date between tomorrow and 30 days from now.');
            redirect('cart', 'index');
        }

        $_SESSION['preferred_delivery_date'] = $date;
        redirect('cart', 'index');
    }

    public function updateQty(): void
    {
        // Require POST to prevent URL manipulation
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('cart', 'index');
        }

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('cart', 'index');
        }

        $materialId = (int)($_POST['id'] ?? 0);
        $qty        = (int)($_POST['qty'] ?? 0);
        $user       = $_SESSION['user'] ?? null;

        // Hard server-side bounds — reject manipulated quantities
        if ($materialId <= 0 || $qty < 1 || $qty > 9999) {
            Flash::set('error', 'Invalid request.');
            redirect('cart', 'index');
        }

        $materialModel = new Material();

        // Always fetch from DB — never trust client-supplied price/name
        $material = $materialModel->find($materialId);
        if (!$material || !($material['is_active'] ?? true)) {
            Flash::set('error', 'Material not found or unavailable.');
            redirect('cart', 'index');
        }

        $stock = (int)($material['stock_quantity'] ?? 0);
        if ($qty > $stock) {
            Flash::set('error', "Only {$stock} units available in stock.");
            redirect('cart', 'index');
        }

        if ($user && !empty($user['id'])) {
            // Verify this material is actually in the user's cart
            $dbCart = $materialModel->getUserCart((int)$user['id']);
            $inCart = false;
            foreach ($dbCart as $cartItem) {
                if ((int)$cartItem['material_id'] === $materialId) {
                    $inCart = true;
                    break;
                }
            }
            if (!$inCart) {
                Flash::set('error', 'Item not found in your cart.');
                redirect('cart', 'index');
            }

            $materialModel->updateCartQuantity((int)$user['id'], $materialId, $qty);
            $this->syncCartToSession((int)$user['id'], $materialModel);
        } else {
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ((int)($item['id'] ?? 0) === $materialId) {
                    $item['qty'] = $qty;
                    $found = true;
                    break;
                }
            }
            unset($item);
            if (!$found) {
                Flash::set('error', 'Item not found in your cart.');
                redirect('cart', 'index');
            }
        }

        Flash::set('success', 'Quantity updated.');
        redirect('cart', 'index');
    }

    public function getStock(): void
    {
        if (!$this->isAjaxRequest()) {
            http_response_code(403);
            exit;
        }
        $materialId    = (int)($_GET['id'] ?? 0);
        $materialModel = new Material();
        $stock         = $materialModel->getStockQuantity($materialId);
        $this->jsonResponse(['stock' => $stock]);
    }

    private function syncCartToSession(int $userId, Material $materialModel): void
    {
        try {
            $dbCart = $materialModel->getUserCart($userId);
            $sessionCart = [];
            
            foreach ($dbCart as $item) {
                // Only skip if material is explicitly inactive
                if (isset($item['is_active']) && (int)$item['is_active'] === 0) {
                    continue;
                }
                
                $sessionCart[] = [
                    'id'    => $item['material_id'],
                    'name'  => $item['material_name'],
                    'price' => (float)$item['unit_price'],
                    'unit'  => $item['unit_type'],
                    'qty'   => (int)$item['quantity'],
                ];
            }
            
            $_SESSION['cart'] = $sessionCart;
        } catch (Exception $e) {
            error_log("SYNC CART TO SESSION ERROR: " . $e->getMessage());
        }
    }
}
