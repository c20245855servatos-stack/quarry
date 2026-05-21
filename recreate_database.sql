-- Drop and recreate database with users table
DROP DATABASE IF EXISTS quarry_system_db;
CREATE DATABASE quarry_system_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quarry_system_db;

-- Users table
CREATE TABLE users (
    client_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    contact_number VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_is_admin (is_admin)
);

-- Materials table
CREATE TABLE materials (
    material_id INT AUTO_INCREMENT PRIMARY KEY,
    material_name VARCHAR(255) NOT NULL,
    description TEXT,
    unit_price DECIMAL(10,2) NOT NULL,
    unit_type VARCHAR(50) DEFAULT 'per cubic meter',
    stock_quantity INT DEFAULT 0,
    image VARCHAR(500),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active (is_active),
    INDEX idx_name (material_name)
);

-- Orders table
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    order_status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    total_amount DECIMAL(12,2) NOT NULL,
    delivery_address TEXT,
    delivery_date DATE,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES users(client_id) ON DELETE CASCADE,
    INDEX idx_client (client_id),
    INDEX idx_status (order_status),
    INDEX idx_date (created_at)
);

-- Order Items table
CREATE TABLE order_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    material_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES materials(material_id) ON DELETE CASCADE,
    INDEX idx_order (order_id),
    INDEX idx_material (material_id)
);

-- Activity Log table
CREATE TABLE activity_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    user_name VARCHAR(255),
    action VARCHAR(255) NOT NULL,
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(client_id) ON DELETE SET NULL,
    INDEX idx_user (user_id),
    INDEX idx_action (action),
    INDEX idx_date (created_at)
);

-- Insert default admin user (password: admin123)
INSERT INTO users (full_name, email, password, is_admin) VALUES 
('System Administrator', 'admin@quarry.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE);

-- Insert sample regular user (password: user123)
INSERT INTO users (full_name, email, password, is_admin, contact_number, address) VALUES 
('John Doe', 'user@quarry.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', FALSE, '09123456789', '123 Main St, City');

-- Insert sample materials
INSERT INTO materials (material_name, description, unit_price, unit_type, stock_quantity) VALUES 
('Crushed Stone', 'High-quality crushed stone for construction', 850.00, 'per cubic meter', 500),
('Sand', 'Fine construction sand', 650.00, 'per cubic meter', 300),
('Gravel', 'Mixed gravel for concrete and drainage', 750.00, 'per cubic meter', 400),
('Limestone', 'Premium limestone blocks', 950.00, 'per cubic meter', 200),
('Concrete Mix', 'Ready-to-use concrete mixture', 1200.00, 'per cubic meter', 150);

-- Create indexes for better performance
CREATE INDEX idx_orders_date_status ON orders(created_at, order_status);
CREATE INDEX idx_materials_price ON materials(unit_price);
CREATE INDEX idx_activity_log_date_user ON activity_log(created_at, user_id);

COMMIT;