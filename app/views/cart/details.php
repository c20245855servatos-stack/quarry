<?php ob_start(); ?>

<style>
/* ========================
   SIMPLIFIED MATERIAL DETAILS PAGE
======================== */
:root {
  --primary: #1a1a1a;
  --secondary: #2d2d2d;
  --background: #1a1a1a;
  --accent: #FFD700;
  --text-primary: #ffffff;
  --text-secondary: rgba(255, 255, 255, 0.7);
  --text-light: #ffffff;
  --shadow-md: 0 8px 25px rgba(0, 0, 0, 0.7);
  --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.8);
}

body {
    background: #f8f9fa;
    color: var(--primary);
    min-height: 100vh;
}

.page-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    border-radius: 20px;
    padding: 24px 32px;
    margin-bottom: 32px;
    box-shadow: var(--shadow-md);
}

.page-header h2 {
    color: var(--text-light);
    margin: 0;
    font-weight: 900;
    font-size: 1.8rem;
}

.material-container {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 32px;
    margin-bottom: 32px;
    background: transparent;
    padding: 0;
    min-height: 70vh;
}

.material-image-section {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    border: 3px solid var(--accent);
    background: white;
    height: 100%;
    min-height: 500px;
}

.material-image {
    width: 100%;
    height: 100%;
    min-height: 500px;
    object-fit: cover;
    transition: 0.3s ease;
    display: block;
}

.material-image:hover {
    transform: scale(1.02);
}

.material-info-section {
    background: white;
    border-radius: 24px;
    padding: 32px;
    box-shadow: var(--shadow-lg);
    border: 3px solid var(--accent);
    color: var(--primary);
    height: fit-content;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 500px;
}

.material-title {
    font-size: 2.2rem;
    font-weight: 900;
    color: var(--primary);
    margin-bottom: 16px;
}

.material-price {
    font-size: 2.5rem;
    font-weight: 900;
    color: var(--primary);
    margin-bottom: 8px;
}

.material-unit {
    font-size: 1.1rem;
    color: var(--secondary);
    font-weight: 700;
    margin-bottom: 24px;
    background: rgba(255, 215, 0, 0.1);
    padding: 8px 16px;
    border-radius: 12px;
    display: inline-block;
}

.stock-info {
    background: rgba(255, 215, 0, 0.1);
    border: 2px solid var(--accent);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
}

.stock-icon {
    width: 50px;
    height: 50px;
    background: var(--accent);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--primary);
}

.stock-details h4 {
    margin: 0 0 8px;
    color: var(--primary);
    font-weight: 800;
}

.stock-amount {
    font-size: 1.2rem;
    font-weight: 900;
    color: var(--primary);
}

.stock-amount.low-stock { color: #f59e0b; }
.stock-amount.out-of-stock { color: #ef4444; }

.quantity-cart-section {
    background: rgba(255, 215, 0, 0.05);
    border: 3px solid var(--accent);
    border-radius: 20px;
    padding: 28px;
    margin-bottom: 24px;
}

.quantity-label {
    font-size: 1.2rem;
    font-weight: 900;
    color: var(--primary);
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.quantity-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    margin-bottom: 20px;
}

.quantity-btn {
    background: var(--accent);
    border: none;
    color: var(--primary);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-size: 1.3rem;
    font-weight: 900;
    cursor: pointer;
    transition: 0.3s ease;
}

.quantity-btn:hover:not(:disabled) {
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(255, 215, 0, 0.4);
}

.quantity-btn:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.quantity-display {
    background: white;
    border: 3px solid var(--accent);
    border-radius: 16px;
    padding: 12px 20px;
    min-width: 100px;
    text-align: center;
}

.quantity-input {
    background: transparent;
    border: none;
    font-size: 1.8rem;
    font-weight: 900;
    color: var(--primary);
    text-align: center;
    outline: none;
    width: 100%;
}

.total-display {
    background: white;
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    margin-bottom: 20px;
    border: 2px dashed var(--accent);
}

.total-label {
    font-size: 0.9rem;
    color: var(--secondary);
    font-weight: 700;
    margin-bottom: 8px;
    text-transform: uppercase;
}

.total-amount {
    font-size: 1.8rem;
    font-weight: 900;
    color: var(--primary);
}

.add-to-cart-btn {
    width: 100%;
    background: linear-gradient(135deg, var(--accent), #FFB000);
    color: var(--primary);
    border: none;
    padding: 18px 24px;
    border-radius: 16px;
    font-size: 1.2rem;
    font-weight: 900;
    cursor: pointer;
    transition: 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
}

.add-to-cart-btn:hover:not(:disabled) {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(255, 215, 0, 0.6);
}

.add-to-cart-btn:disabled {
    background: #6b7280;
    cursor: not-allowed;
    opacity: 0.6;
}

.back-btn {
    background: transparent;
    color: var(--primary);
    border: 2px solid var(--primary);
    padding: 12px 24px;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: 0.3s ease;
}

.back-btn:hover {
    background: var(--primary);
    color: white;
    text-decoration: none;
}

.stock-warning {
    background: rgba(239, 68, 68, 0.1);
    border: 2px solid rgba(239, 68, 68, 0.3);
    color: #dc2626;
    padding: 12px 16px;
    border-radius: 12px;
    font-weight: 700;
    margin-top: 12px;
    display: none;
    text-align: center;
}

.stock-warning.show {
    display: block;
}

/* Popup Styles */
.cart-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.cart-popup-overlay.show {
    opacity: 1;
    visibility: visible;
}

.cart-popup {
    background: white;
    border-radius: 20px;
    max-width: 450px;
    width: 90%;
    box-shadow: 0 30px 80px rgba(255, 215, 0, 0.4);
    border: 3px solid var(--accent);
    transform: scale(0.8);
    transition: 0.3s ease;
}

.cart-popup-overlay.show .cart-popup {
    transform: scale(1);
}

.cart-popup-header {
    background: linear-gradient(135deg, var(--accent), #FFB000);
    padding: 24px;
    border-radius: 17px 17px 0 0;
    text-align: center;
}

.cart-popup-icon {
    width: 60px;
    height: 60px;
    background: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: var(--accent);
    margin: 0 auto 16px;
}

.cart-popup-title {
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--primary);
    margin: 0;
}

.cart-popup-content {
    padding: 24px;
    text-align: center;
}

.cart-popup-item {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
}

.cart-popup-item-image {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid var(--accent);
}

.cart-popup-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cart-popup-item-details {
    flex: 1;
    text-align: left;
}

.cart-popup-item-details h4 {
    margin: 0 0 8px;
    font-weight: 900;
    color: var(--primary);
}

.cart-popup-item-price {
    color: var(--secondary);
    font-weight: 700;
}

.cart-popup-actions {
    display: flex;
    gap: 12px;
    padding: 0 24px 24px;
}

.btn-continue, .btn-view-cart {
    flex: 1;
    padding: 12px 16px;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    text-align: center;
    transition: 0.3s ease;
}

.btn-continue {
    background: transparent;
    color: var(--primary);
    border: 2px solid var(--primary);
}

.btn-continue:hover {
    background: var(--primary);
    color: white;
    text-decoration: none;
}

.btn-view-cart {
    background: var(--accent);
    color: var(--primary);
    border: 2px solid var(--accent);
}

.btn-view-cart:hover {
    background: var(--primary);
    color: var(--accent);
    text-decoration: none;
}

.container-fluid {
    background: #f8f9fa;
    min-height: 100vh;
}

@media (max-width: 768px) {
    .material-container {
        grid-template-columns: 1fr;
        gap: 24px;
        min-height: auto;
    }
    
    .material-image {
        height: 350px;
        min-height: 350px;
    }
    
    .material-image-section {
        min-height: 350px;
    }
    
    .material-info-section {
        padding: 24px 20px;
        min-height: auto;
    }
    
    .material-title {
        font-size: 1.8rem;
    }
    
    .material-price {
        font-size: 2rem;
    }
    
    .cart-popup-item {
        flex-direction: column;
        text-align: center;
    }
    
    .cart-popup-actions {
        flex-direction: column;
    }
}
</style>

<div class="container-fluid p-4">

    <!-- Header -->
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <h2><i class="bi bi-info-circle me-2"></i>Material Details</h2>
            <a href="?controller=dashboard&action=shop" class="btn btn-light fw-bold px-4">
                <i class="bi bi-arrow-left me-1"></i> Back to Shop
            </a>
        </div>
    </div>

    <!-- Material Details -->
    <div class="material-container">
        <!-- Image -->
        <div class="material-image-section">
            <?php 
                $imagePath = '';
                if (!empty($material['image'])) {
                    if (strpos($material['image'], 'http') === 0) {
                        $imagePath = $material['image'];
                    } else {
                        $imagePath = '/app/public/assets/imgs/materials/' . htmlspecialchars($material['image']);
                    }
                } else {
                    $imagePath = 'https://images.pexels.com/photos/21854544/pexels-photo-21854544.jpeg?auto=compress&cs=tinysrgb&w=1200';
                }
            ?>
            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($material['material_name'] ?? '') ?>" class="material-image">
        </div>

        <!-- Info & Controls -->
        <div class="material-info-section">
            <h1 class="material-title"><?= htmlspecialchars($material['material_name'] ?? '') ?></h1>
            <div class="material-price">₱<?= number_format($material['unit_price'] ?? 0, 2) ?></div>
            <div class="material-unit"><?= htmlspecialchars($material['unit_type'] ?? '') ?></div>

            <!-- Stock Info -->
            <?php 
            $stock = (int)($material['stock_quantity'] ?? 0);
            $stockClass = $stock <= 0 ? 'out-of-stock' : ($stock <= 10 ? 'low-stock' : '');
            ?>
            <div class="stock-info">
                <div class="stock-icon">
                    <i class="bi bi-<?= $stock <= 0 ? 'x-circle' : 'check-circle' ?>"></i>
                </div>
                <div class="stock-details">
                    <h4>Stock Availability</h4>
                    <div class="stock-amount <?= $stockClass ?>">
                        <?php if ($stock <= 0): ?>
                            Out of Stock
                        <?php elseif ($stock <= 10): ?>
                            <?= $stock ?> units available (Low Stock)
                        <?php else: ?>
                            <?= $stock ?> units available
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if ($stock > 0): ?>
            <!-- Quantity & Add to Cart -->
            <div class="quantity-cart-section">
                <div class="quantity-label">
                    <i class="bi bi-plus-circle-fill me-2"></i>Select Quantity
                </div>
                
                <div class="quantity-controls">
                    <button type="button" class="quantity-btn" onclick="decreaseQuantity()">
                        <i class="bi bi-dash"></i>
                    </button>
                    
                    <div class="quantity-display">
                        <input type="number" 
                               class="quantity-input" 
                               id="quantity" 
                               value="1" 
                               min="1" 
                               max="<?= $stock ?>"
                               onchange="updateTotal()"
                               oninput="updateTotal()">
                    </div>
                    
                    <button type="button" class="quantity-btn" onclick="increaseQuantity()">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
                
                <div class="total-display">
                    <div class="total-label">Total Amount</div>
                    <div class="total-amount" id="totalAmount">₱<?= number_format($material['unit_price'] ?? 0, 2) ?></div>
                </div>
                
                <div class="stock-warning" id="stockWarning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Maximum quantity reached!
                </div>

                <button type="button" onclick="addToCartWithPopup()" class="add-to-cart-btn">
                    <i class="bi bi-cart-plus-fill me-2"></i>Add to Cart
                </button>
            </div>
            <?php else: ?>
            <!-- Out of Stock -->
            <div class="quantity-cart-section">
                <button class="add-to-cart-btn" disabled>
                    <i class="bi bi-x-circle-fill me-2"></i>Out of Stock
                </button>
            </div>
            <?php endif; ?>

            <!-- Back Button -->
            <a href="?controller=dashboard&action=shop" class="back-btn">
                <i class="bi bi-arrow-left"></i>
                <span>Continue Shopping</span>
            </a>
        </div>
    </div>

</div>

<!-- Success Popup -->
<div id="cartPopupOverlay" class="cart-popup-overlay">
    <div class="cart-popup">
        <div class="cart-popup-header">
            <div class="cart-popup-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h3 class="cart-popup-title">Added to Cart!</h3>
        </div>
        
        <div class="cart-popup-content">
            <div class="cart-popup-item">
                <div class="cart-popup-item-image">
                    <img id="popupItemImage" src="" alt="">
                </div>
                <div class="cart-popup-item-details">
                    <h4 id="popupItemName"></h4>
                    <div class="cart-popup-item-price">
                        <span id="popupItemQuantity"></span> × <span id="popupItemPrice"></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="cart-popup-actions">
            <button onclick="closeCartPopup()" class="btn-continue">Continue Shopping</button>
            <a href="?controller=cart&action=index" class="btn-view-cart">View Cart (<span id="popupCartCount">0</span>)</a>
        </div>
    </div>
</div>

<script>
const maxStock = <?= $stock ?>;
const unitPrice = <?= $material['unit_price'] ?? 0 ?>;
const materialId = <?= $material['material_id'] ?>;
const materialImage = '<?= $imagePath ?>';

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value) || 1;
    
    if (currentValue > 1) {
        input.value = currentValue - 1;
        updateTotal();
        hideStockWarning();
    }
}

function increaseQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value) || 1;
    
    if (currentValue < maxStock) {
        input.value = currentValue + 1;
        updateTotal();
        hideStockWarning();
    } else {
        showStockWarning();
    }
}

function updateTotal() {
    const input = document.getElementById('quantity');
    const totalElement = document.getElementById('totalAmount');
    let quantity = parseInt(input.value) || 1;
    
    if (quantity < 1) {
        quantity = 1;
        input.value = quantity;
    } else if (quantity > maxStock) {
        quantity = maxStock;
        input.value = quantity;
        showStockWarning();
    } else {
        hideStockWarning();
    }
    
    const total = quantity * unitPrice;
    totalElement.textContent = '₱' + total.toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function showStockWarning() {
    document.getElementById('stockWarning').classList.add('show');
    setTimeout(() => hideStockWarning(), 3000);
}

function hideStockWarning() {
    document.getElementById('stockWarning').classList.remove('show');
}

function addToCartWithPopup() {
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    const button = document.querySelector('.add-to-cart-btn');
    const originalContent = button.innerHTML;
    
    button.innerHTML = '<i class="bi bi-arrow-repeat" style="animation: spin 1s linear infinite;"></i> Adding...';
    button.disabled = true;
    
    fetch(`?controller=cart&action=add&id=${materialId}&quantity=${quantity}`, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        button.innerHTML = originalContent;
        button.disabled = false;
        
        if (data.success) {
            showCartPopup(data);
            updateCartCount(data.cartCount);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        button.innerHTML = originalContent;
        button.disabled = false;
        alert('Failed to add item to cart. Please try again.');
    });
}

function showCartPopup(data) {
    document.getElementById('popupItemImage').src = materialImage;
    document.getElementById('popupItemName').textContent = data.material.material_name;
    document.getElementById('popupItemQuantity').textContent = data.quantity;
    document.getElementById('popupItemPrice').textContent = '₱' + parseFloat(data.material.unit_price).toFixed(2);
    document.getElementById('popupCartCount').textContent = data.cartCount;
    
    document.getElementById('cartPopupOverlay').classList.add('show');
    setTimeout(() => closeCartPopup(), 4000);
}

function closeCartPopup() {
    document.getElementById('cartPopupOverlay').classList.remove('show');
}

function updateCartCount(count) {
    const cartBadges = document.querySelectorAll('.cart-badge');
    cartBadges.forEach(badge => {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'inline' : 'none';
    });
}

// Close popup on outside click or Escape key
document.addEventListener('click', function(e) {
    if (e.target.id === 'cartPopupOverlay') closeCartPopup();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeCartPopup();
});

// Add spin animation
const style = document.createElement('style');
style.textContent = '@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }';
document.head.appendChild(style);
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>