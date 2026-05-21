<?php

declare(strict_types=1);

class Material
{
    private PDO $db;

    public function __construct()
    {
        require_once __DIR__ . '/../config/database.php';
        $this->db = Database::getConnection();
        
        // Only run ensureTable once per session, not on every request
        if (empty($_SESSION['_db_tables_checked'])) {
            try {
                $this->ensureTable();
                $_SESSION['_db_tables_checked'] = true;
            } catch (Exception $e) {
                error_log("MATERIAL MODEL ERROR: Failed to ensure tables - " . $e->getMessage());
            }
        }
    }

    private function ensureTable(): void
    {
        // Create table with all columns at once
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS materials (
                material_id INT AUTO_INCREMENT PRIMARY KEY,
                material_name VARCHAR(150) NOT NULL,
                description TEXT,
                unit_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                unit_type VARCHAR(50) NOT NULL DEFAULT 'per cubic meter',
                stock_quantity INT NOT NULL DEFAULT 0,
                is_active TINYINT(1) NOT NULL DEFAULT 1,
                image VARCHAR(255),
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $this->db->exec("
            CREATE TABLE IF NOT EXISTS orders (
                order_id     INT AUTO_INCREMENT PRIMARY KEY,
                client_id    INT          NOT NULL,
                order_status VARCHAR(100) NOT NULL DEFAULT 'pending',
                total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                delivery_date DATE,
                arrival_date DATE,
                user_confirmed_delivery DATETIME,
                created_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $this->db->exec("
            CREATE TABLE IF NOT EXISTS order_items (
                order_item_id INT AUTO_INCREMENT PRIMARY KEY,
                order_id      INT          NOT NULL,
                material_id   INT          NOT NULL,
                name          VARCHAR(150),
                unit_price    DECIMAL(10,2) NOT NULL,
                quantity      INT          NOT NULL DEFAULT 1,
                subtotal      DECIMAL(10,2) NOT NULL DEFAULT 0.00
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $this->db->exec("
            CREATE TABLE IF NOT EXISTS activity_log (
                log_id      INT AUTO_INCREMENT PRIMARY KEY,
                client_id   INT,
                user_name   VARCHAR(150),
                action      VARCHAR(255) NOT NULL,
                details     TEXT,
                ip_address  VARCHAR(45),
                created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        // Create persistent cart table
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS user_cart (
                user_cart_id    INT AUTO_INCREMENT PRIMARY KEY,
                client_id       INT NOT NULL,
                material_id     INT NOT NULL,
                material_name   VARCHAR(150) NOT NULL,
                unit_price      DECIMAL(10,2) NOT NULL,
                unit_type       VARCHAR(50) NOT NULL,
                quantity        INT NOT NULL DEFAULT 1,
                added_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY unique_client_material (client_id, material_id),
                INDEX idx_client_id (client_id),
                INDEX idx_material_id (material_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        // Modify existing columns to be larger
        try {
            $this->db->exec("ALTER TABLE orders MODIFY COLUMN order_status VARCHAR(100)");
        } catch (PDOException $e) {
            // Column already correct size, ignore
        }

        // Add missing columns if they don't exist
        try {
            $this->db->exec("ALTER TABLE orders ADD COLUMN delivery_date DATE");
        } catch (PDOException $e) {
            // Column already exists, ignore
        }

        try {
            $this->db->exec("ALTER TABLE orders ADD COLUMN arrival_date DATE");
        } catch (PDOException $e) {
            // Column already exists, ignore
        }

        try {
            $this->db->exec("ALTER TABLE orders ADD COLUMN user_confirmed_delivery DATETIME");
        } catch (PDOException $e) {
            // Column already exists, ignore
        }

        try {
            $this->db->exec("ALTER TABLE order_items ADD COLUMN name VARCHAR(150)");
        } catch (PDOException $e) {
            // Column already exists, ignore
        }

        // Populate missing names for existing order items
        try {
            $this->db->exec("
                UPDATE order_items oi 
                JOIN materials m ON oi.material_id = m.material_id 
                SET oi.name = m.material_name 
                WHERE oi.name IS NULL OR oi.name = ''
            ");
        } catch (PDOException $e) {
            // Ignore if update fails
        }

        try {
            $this->db->exec("ALTER TABLE orders ADD COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
        } catch (PDOException $e) {
            // Column already exists, ignore
        }

        try {
            $this->db->exec("ALTER TABLE orders ADD COLUMN updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
        } catch (PDOException $e) {
            // Column already exists, ignore
        }

        try {
            $this->db->exec("ALTER TABLE materials ADD COLUMN image VARCHAR(255)");
        } catch (PDOException $e) {
            // Column already exists, ignore
        }
    }

    /* ─── MATERIALS CRUD ─── */

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM materials ORDER BY updated_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function active(): array
    {
        $stmt = $this->db->query("SELECT * FROM materials WHERE is_active = 1 ORDER BY updated_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM materials WHERE material_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function search(string $q): array
    {
        // Escape SQL wildcards to prevent injection
        $escaped = str_replace(['%', '_', '\\'], ['\\%', '\\_', '\\\\'], $q);
        $stmt = $this->db->prepare("SELECT * FROM materials WHERE is_active = 1 AND material_name LIKE ? ORDER BY material_name ASC");
        $stmt->execute(["%{$escaped}%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function create(string $name, string $description, float $price, string $unit, int $stock): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO materials (material_name, description, unit_price, unit_type, stock_quantity)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$name, $description, $price, $unit, $stock]);
    }

    public function createWithImage(string $name, string $description, float $price, string $unit, int $stock, ?string $image = null): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO materials (material_name, description, unit_price, unit_type, stock_quantity, image)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$name, $description, $price, $unit, $stock, $image]);
    }

    public function update(int $id, string $name, string $description, float $price, string $unit, int $stock, int $is_active, ?string $image = null): bool
    {
        if ($image !== null) {
            $stmt = $this->db->prepare("
                UPDATE materials SET material_name=?, description=?, unit_price=?, unit_type=?, stock_quantity=?, is_active=?, image=?
                WHERE material_id=?
            ");
            return $stmt->execute([$name, $description, $price, $unit, $stock, $is_active, $image, $id]);
        } else {
            $stmt = $this->db->prepare("
                UPDATE materials SET material_name=?, description=?, unit_price=?, unit_type=?, stock_quantity=?, is_active=?
                WHERE material_id=?
            ");
            return $stmt->execute([$name, $description, $price, $unit, $stock, $is_active, $id]);
        }
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM materials WHERE material_id = ?");
        return $stmt->execute([$id]);
    }

    public function count(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM materials WHERE is_active = 1")->fetchColumn();
    }

    /* ─── ORDERS ─── */

    public function allOrders(): array
    {
        $stmt = $this->db->query("
            SELECT o.*, u.full_name, u.email, u.contact_number, u.address,
                   o.created_at as order_date
            FROM orders o
            LEFT JOIN users u ON o.client_id = u.client_id
            ORDER BY o.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function getOrdersPaginated(int $page = 1, int $perPage = 10, string $status = 'all'): array
    {
        $offset = ($page - 1) * $perPage;
        
        // Build WHERE clause for status filter
        $whereClause = '';
        $params = [];
        if ($status !== 'all') {
            $whereClause = 'WHERE o.order_status = ?';
            $params[] = $status;
        }
        
        // Get total count for pagination
        $countSql = "SELECT COUNT(*) FROM orders o " . $whereClause;
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($params);
        $totalOrders = (int) $countStmt->fetchColumn();
        
        // Get orders for current page
        $ordersSql = "
            SELECT o.*, u.full_name, u.email, u.contact_number, u.address,
                   o.created_at as order_date
            FROM orders o
            LEFT JOIN users u ON o.client_id = u.client_id
            {$whereClause}
            ORDER BY o.created_at DESC
            LIMIT ? OFFSET ?
        ";
        
        $params[] = $perPage;
        $params[] = $offset;
        
        $ordersStmt = $this->db->prepare($ordersSql);
        $ordersStmt->execute($params);
        $orders = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Calculate pagination info
        $totalPages = ceil($totalOrders / $perPage);
        
        return [
            'orders' => $orders,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $perPage,
                'total_orders' => $totalOrders,
                'total_pages' => $totalPages,
                'has_prev' => $page > 1,
                'has_next' => $page < $totalPages,
                'prev_page' => $page > 1 ? $page - 1 : null,
                'next_page' => $page < $totalPages ? $page + 1 : null
            ]
        ];
    }

    public function findOrder(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT o.*, u.full_name, u.email, u.contact_number, u.address, u.address as user_address,
                   o.created_at as order_date
            FROM orders o
            LEFT JOIN users u ON o.client_id = u.client_id
            WHERE o.order_id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function orderItems(int $orderId): array
    {
        $stmt = $this->db->prepare("
            SELECT oi.*, 
                   COALESCE(oi.name, m.material_name, 'Unknown Material') as material_name
            FROM order_items oi
            LEFT JOIN materials m ON oi.material_id = m.material_id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function createOrder(int $clientId, float $totalAmount, array $items): ?int
    {
        try {
            // Insert order
            $stmt = $this->db->prepare("
                INSERT INTO orders (client_id, total_amount, order_status)
                VALUES (?, ?, 'pending')
            ");
            $stmt->execute([$clientId, $totalAmount]);
            $orderId = (int)$this->db->lastInsertId();

            // Get all material IDs to fetch names in one query
            $materialIds = array_column($items, 'material_id');
            $materialIds = array_filter($materialIds); // Remove empty values
            
            $materialNames = [];
            if (!empty($materialIds)) {
                $placeholders = str_repeat('?,', count($materialIds) - 1) . '?';
                $materialStmt = $this->db->prepare("SELECT material_id, material_name FROM materials WHERE material_id IN ($placeholders)");
                $materialStmt->execute($materialIds);
                $materialNames = $materialStmt->fetchAll(PDO::FETCH_KEY_PAIR);
            }

            // Insert order items with material names
            $itemStmt = $this->db->prepare("
                INSERT INTO order_items (order_id, material_id, name, quantity, unit_price, subtotal)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            foreach ($items as $item) {
                $materialId = $item['material_id'] ?? 0;
                $materialName = $materialNames[$materialId] ?? 'Unknown Material';

                $itemStmt->execute([
                    $orderId,
                    $materialId,
                    $materialName,
                    $item['qty'] ?? 1,
                    $item['price'] ?? 0,
                    ($item['price'] ?? 0) * ($item['qty'] ?? 1),
                ]);
            }

            return $orderId;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function countOrdersOnDate(string $date, int $excludeOrderId = 0): int
    {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) FROM orders 
                WHERE delivery_date = ? 
                AND order_id != ?
                AND order_status NOT IN ('cancelled')
            ");
            $stmt->execute([$date, $excludeOrderId]);
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("COUNT ORDERS ON DATE ERROR: " . $e->getMessage());
            return 0;
        }
    }

    public function updateOrderStatus(int $id, string $status, ?string $deliveryDate = null, ?string $arrivalDate = null): bool
    {
        $sql = "UPDATE orders SET order_status=?";
        $params = [$status];

        if ($deliveryDate !== null && $deliveryDate !== '') {
            $sql .= ", delivery_date=?";
            $params[] = $deliveryDate;
        }

        if ($arrivalDate !== null && $arrivalDate !== '') {
            $sql .= ", arrival_date=?";
            $params[] = $arrivalDate;
        }

        $sql .= " WHERE order_id=?";
        $params[] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function ordersCount(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
    }

    public function pendingOrdersCount(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM orders WHERE order_status='pending'")->fetchColumn();
    }

    public function totalRevenue(): float
    {
        $val = $this->db->query("SELECT SUM(total_amount) FROM orders WHERE order_status='completed' AND YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())")->fetchColumn();
        return (float) ($val ?? 0);
    }

    public function recentOrders(int $limit = 5): array
    {
        $stmt = $this->db->prepare("
            SELECT o.*, u.full_name
            FROM orders o
            LEFT JOIN users u ON o.client_id = u.client_id
            ORDER BY o.created_at DESC
            LIMIT " . (int)$limit . "
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function salesByMonth(): array
    {
        $stmt = $this->db->query("
            SELECT DATE_FORMAT(created_at, '%Y-%m') as month,
                   SUM(total_amount) as total,
                   COUNT(*) as count
            FROM orders
            WHERE order_status = 'completed'
            GROUP BY month
            ORDER BY month DESC
            LIMIT 12
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function topMaterials(): array
    {
        $stmt = $this->db->query("
            SELECT m.material_name, SUM(oi.quantity) as total_qty, SUM(oi.subtotal) as total_revenue
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.order_id
            JOIN materials m ON oi.material_id = m.material_id
            WHERE o.order_status = 'completed'
            GROUP BY m.material_name
            ORDER BY total_revenue DESC
            LIMIT 5
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function deliveryCalendar(): array
    {
        $stmt = $this->db->query("
            SELECT o.order_id, o.delivery_date, o.order_status, o.total_amount, u.full_name
            FROM orders o
            LEFT JOIN users u ON o.client_id = u.client_id
            ORDER BY o.delivery_date ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function confirmDelivery(int $orderId, int $userId): bool
    {
        // First check if the order belongs to the user and is in a deliverable state
        $stmt = $this->db->prepare("
            SELECT order_status, client_id 
            FROM orders 
            WHERE order_id = ?
        ");
        $stmt->execute([$orderId]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order || $order['client_id'] != $userId) {
            return false; // Order doesn't exist or doesn't belong to user
        }

        $allowedStatuses = ['out_for_delivery', 'completed'];
        if (!in_array(strtolower($order['order_status']), $allowedStatuses)) {
            return false; // Order is not in a state that can be confirmed
        }

        // Update the order with confirmation timestamp and set status to completed
        $stmt = $this->db->prepare("
            UPDATE orders 
            SET user_confirmed_delivery = NOW(), 
                order_status = 'completed'
            WHERE order_id = ?
        ");
        return $stmt->execute([$orderId]);
    }

    public function log(string $action, string $details = '', ?int $userId = null, ?string $userName = null): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO activity_log (client_id, user_name, action, details, ip_address)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $userId,
            $userName,
            $action,
            $details,
            $_SERVER['REMOTE_ADDR'] ?? null
        ]);
    }

    public function activityLog(int $limit = 50): array
    {
        $stmt = $this->db->prepare("SELECT * FROM activity_log ORDER BY created_at DESC LIMIT " . (int)$limit);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function activityLogPaginated(int $page = 1, int $perPage = 10, string $filter = ''): array
    {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $where  = '';

        if ($filter !== '') {
            $where    = 'WHERE action = ?';
            $params[] = $filter;
        }

        // Get total count with optional filter
        $countStmt = $this->db->prepare("SELECT COUNT(*) FROM activity_log {$where}");
        $countStmt->execute($params);
        $totalRecords = (int)$countStmt->fetchColumn();

        // Get paginated results
        $stmt = $this->db->prepare("
            SELECT * FROM activity_log
            {$where}
            ORDER BY log_id DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute(array_merge($params, [$perPage, $offset]));
        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

        $totalPages = max(1, (int)ceil($totalRecords / $perPage));

        return [
            'logs' => $logs,
            'pagination' => [
                'current_page'  => $page,
                'per_page'      => $perPage,
                'total_records' => $totalRecords,
                'total_pages'   => $totalPages,
                'has_previous'  => $page > 1,
                'has_next'      => $page < $totalPages,
                'previous_page' => $page > 1 ? $page - 1 : null,
                'next_page'     => $page < $totalPages ? $page + 1 : null,
                'offset'        => $offset,
            ]
        ];
    }

    /* ─── USERS ─── */

    public function usersCount(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    /* ─── PERSISTENT CART ─── */

    public function addToCart(int $userId, int $materialId, string $materialName, float $unitPrice, string $unitType, int $quantity): bool
    {
        try {
            // Get current stock
            $currentStock = $this->getStockQuantity($materialId);

            // Check if item already exists in cart
            $stmt = $this->db->prepare("
                SELECT quantity FROM user_cart 
                WHERE client_id = ? AND material_id = ?
            ");
            $stmt->execute([$userId, $materialId]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existing) {
                // Ensure combined quantity does not exceed stock
                $newQuantity = $existing['quantity'] + $quantity;
                if ($newQuantity > $currentStock) {
                    $newQuantity = $currentStock; // Cap at available stock
                }
                if ($newQuantity <= 0) {
                    return false;
                }
                $stmt = $this->db->prepare("
                    UPDATE user_cart 
                    SET quantity = ?, material_name = ?, unit_price = ?, unit_type = ?, updated_at = NOW()
                    WHERE client_id = ? AND material_id = ?
                ");
                return $stmt->execute([$newQuantity, $materialName, $unitPrice, $unitType, $userId, $materialId]);
            } else {
                // Cap quantity at available stock
                $quantity = min($quantity, $currentStock);
                if ($quantity <= 0) {
                    return false;
                }
                $stmt = $this->db->prepare("
                    INSERT INTO user_cart (client_id, material_id, material_name, unit_price, unit_type, quantity)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                return $stmt->execute([$userId, $materialId, $materialName, $unitPrice, $unitType, $quantity]);
            }
        } catch (Exception $e) {
            error_log("PERSISTENT CART ERROR: " . $e->getMessage());
            return false;
        }
    }

    public function getUserCart(int $userId): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT uc.*, m.stock_quantity, m.is_active
                FROM user_cart uc
                LEFT JOIN materials m ON uc.material_id = m.material_id
                WHERE uc.client_id = ?
                ORDER BY uc.updated_at DESC
            ");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
        } catch (Exception $e) {
            error_log("GET USER CART ERROR: " . $e->getMessage());
            return [];
        }
    }

    public function updateCartQuantity(int $userId, int $materialId, int $quantity): bool
    {
        try {
            if ($quantity <= 0) {
                return $this->removeFromCart($userId, $materialId);
            }
            
            $stmt = $this->db->prepare("
                UPDATE user_cart 
                SET quantity = ?, updated_at = NOW()
                WHERE client_id = ? AND material_id = ?
            ");
            return $stmt->execute([$quantity, $userId, $materialId]);
        } catch (Exception $e) {
            error_log("UPDATE CART QUANTITY ERROR: " . $e->getMessage());
            return false;
        }
    }

    public function removeFromCart(int $userId, int $materialId): bool
    {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM user_cart 
                WHERE client_id = ? AND material_id = ?
            ");
            return $stmt->execute([$userId, $materialId]);
        } catch (Exception $e) {
            error_log("REMOVE FROM CART ERROR: " . $e->getMessage());
            return false;
        }
    }

    public function clearUserCart(int $userId): bool
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM user_cart WHERE client_id = ?");
            return $stmt->execute([$userId]);
        } catch (Exception $e) {
            error_log("CLEAR CART ERROR: " . $e->getMessage());
            return false;
        }
    }

    public function getCartCount(int $userId): int
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM user_cart WHERE client_id = ?");
            $stmt->execute([$userId]);
            return (int)$stmt->fetchColumn();
        } catch (Exception $e) {
            return 0;
        }
    }

    public function syncSessionCartToDatabase(int $userId, array $sessionCart): bool
    {
        try {
            // Clear existing cart
            $this->clearUserCart($userId);
            
            // Add session items to database
            foreach ($sessionCart as $item) {
                $this->addToCart(
                    $userId,
                    (int)($item['id'] ?? 0),
                    $item['name'] ?? '',
                    (float)($item['price'] ?? 0),
                    $item['unit'] ?? '',
                    (int)($item['qty'] ?? 1)
                );
            }
            
            return true;
        } catch (Exception $e) {
            error_log("SYNC CART ERROR: " . $e->getMessage());
            return false;
        }
    }

    /* ─── STOCK MANAGEMENT ─── */

    public function updateStock(int $materialId, int $quantityToDeduct): bool
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE materials 
                SET stock_quantity = GREATEST(0, stock_quantity - ?) 
                WHERE material_id = ? AND stock_quantity >= ?
            ");
            
            $result = $stmt->execute([$quantityToDeduct, $materialId, $quantityToDeduct]);
            
            if ($result && $stmt->rowCount() > 0) {
                error_log("STOCK UPDATE: Deducted {$quantityToDeduct} from material {$materialId}");
                return true;
            } else {
                error_log("STOCK UPDATE FAILED: Insufficient stock for material {$materialId}");
                return false;
            }
        } catch (Exception $e) {
            error_log("STOCK UPDATE ERROR: " . $e->getMessage());
            return false;
        }
    }

    public function getStockQuantity(int $materialId): int
    {
        try {
            $stmt = $this->db->prepare("SELECT stock_quantity FROM materials WHERE material_id = ?");
            $stmt->execute([$materialId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return (int)($result['stock_quantity'] ?? 0);
        } catch (Exception $e) {
            error_log("GET STOCK ERROR: " . $e->getMessage());
            return 0;
        }
    }

    public function validateStockAvailability(array $cartItems): array
    {
        $errors = [];
        
        foreach ($cartItems as $item) {
            $materialId = (int)($item['id'] ?? $item['material_id'] ?? 0);
            $requestedQty = (int)($item['qty'] ?? $item['quantity'] ?? 0);
            
            $availableStock = $this->getStockQuantity($materialId);
            
            if ($availableStock < $requestedQty) {
                $material = $this->find($materialId);
                $materialName = $material['material_name'] ?? "Material ID {$materialId}";
                $errors[] = "{$materialName}: Only {$availableStock} units available, but {$requestedQty} requested.";
            }
        }
        
        return $errors;
    }

    public function cancelOrder(int $orderId): bool
    {
        try {
            // Get order items to restore stock
            $items = $this->orderItems($orderId);

            // Update order status to cancelled
            $stmt = $this->db->prepare("UPDATE orders SET order_status = 'cancelled' WHERE order_id = ?");
            if (!$stmt->execute([$orderId])) {
                return false;
            }

            // Restore stock for each item
            foreach ($items as $item) {
                $materialId = (int)($item['material_id'] ?? 0);
                $quantity   = (int)($item['quantity'] ?? 0);
                if ($materialId > 0 && $quantity > 0) {
                    $this->replenishStock($materialId, $quantity, "Order #{$orderId} cancelled");
                }
            }

            return true;
        } catch (PDOException $e) {
            error_log("CANCEL ORDER ERROR: " . $e->getMessage());
            return false;
        }
    }

    public function replenishStock(int $materialId, int $quantityToAdd, ?string $reason = null): bool
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE materials 
                SET stock_quantity = stock_quantity + ? 
                WHERE material_id = ?
            ");
            
            $result = $stmt->execute([$quantityToAdd, $materialId]);
            
            if ($result) {
                // Log the stock replenishment
                $material = $this->find($materialId);
                $materialName = $material['material_name'] ?? "Material ID {$materialId}";
                $details = "Added {$quantityToAdd} units to {$materialName}";
                if ($reason) {
                    $details .= " - Reason: {$reason}";
                }
                
                $this->log('Stock Replenished', $details);
                error_log("STOCK REPLENISH: Added {$quantityToAdd} to material {$materialId}");
                return true;
            }
            
            return false;
        } catch (Exception $e) {
            error_log("STOCK REPLENISH ERROR: " . $e->getMessage());
            return false;
        }
    }

    public function getLowStockMaterials(int $threshold = 10): array
    {
        try {
            $stmt = $this->db->prepare("
                SELECT * FROM materials 
                WHERE is_active = 1 AND stock_quantity <= ? AND stock_quantity > 0
                ORDER BY stock_quantity ASC
            ");
            $stmt->execute([$threshold]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
        } catch (Exception $e) {
            error_log("GET LOW STOCK ERROR: " . $e->getMessage());
            return [];
        }
    }

    public function getOutOfStockMaterials(): array
    {
        try {
            $stmt = $this->db->query("
                SELECT * FROM materials 
                WHERE is_active = 1 AND stock_quantity <= 0
                ORDER BY material_name ASC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
        } catch (Exception $e) {
            error_log("GET OUT OF STOCK ERROR: " . $e->getMessage());
            return [];
        }
    }

    public function getStockAlerts(): array
    {
        $alerts = [];
        
        // Get out of stock materials
        $outOfStock = $this->getOutOfStockMaterials();
        foreach ($outOfStock as $material) {
            $alerts[] = [
                'type' => 'danger',
                'icon' => 'exclamation-triangle-fill',
                'title' => 'Out of Stock',
                'message' => "{$material['material_name']} is completely out of stock",
                'material_id' => $material['material_id'],
                'priority' => 'high'
            ];
        }
        
        // Get low stock materials
        $lowStock = $this->getLowStockMaterials();
        foreach ($lowStock as $material) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => 'exclamation-circle-fill',
                'title' => 'Low Stock',
                'message' => "{$material['material_name']} has only {$material['stock_quantity']} units left",
                'material_id' => $material['material_id'],
                'priority' => 'medium'
            ];
        }
        
        return $alerts;
    }

    public function getStockSummary(): array
    {
        try {
            $stmt = $this->db->query("
                SELECT 
                    COUNT(*) as total_materials,
                    SUM(CASE WHEN stock_quantity > 10 THEN 1 ELSE 0 END) as well_stocked,
                    SUM(CASE WHEN stock_quantity > 0 AND stock_quantity <= 10 THEN 1 ELSE 0 END) as low_stock,
                    SUM(CASE WHEN stock_quantity <= 0 THEN 1 ELSE 0 END) as out_of_stock,
                    SUM(stock_quantity) as total_stock_units
                FROM materials 
                WHERE is_active = 1
            ");
            
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            error_log("GET STOCK SUMMARY ERROR: " . $e->getMessage());
            return [];
        }
    }
}
