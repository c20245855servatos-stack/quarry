<?php ob_start(); ?>

<style>
/* ========================
   MODERN CONSTRUCTION THEME - MATERIALS PAGE
======================== */
:root {
  /* Core Palette - Construction Style */
  --primary: #1a1a1a;         /* Deep black - Primary elements */
  --secondary: #2d2d2d;       /* Dark gray - Secondary elements */
  --background: #1a1a1a;      /* Black - Main background */
  --accent: #FFD700;          /* Gold/Yellow - Accent elements */
  
  /* Semantic Colors */
  --text-primary: #ffffff;
  --text-secondary: rgba(255, 255, 255, 0.7);
  --text-light: #ffffff;
  --surface: #000000;         /* Pure black surface */
  --surface-alt: #2d2d2d;     /* Dark gray surface */
  --border: #333333;
  --border-light: #FFD700;
  
  /* Interactive States */
  --hover-primary: #333333;
  --hover-secondary: #FFB000;
  --focus-ring: rgba(255, 215, 0, 0.3);
  
  /* Shadows */
  --shadow-sm: 0 4px 15px rgba(0, 0, 0, 0.6);
  --shadow-md: 0 8px 25px rgba(0, 0, 0, 0.7);
  --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.8);
}

@keyframes slideInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

body {
    background: var(--background);
    color: var(--text-primary);
    min-height: 100vh;
}

.carousel-container {
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 32px;
    box-shadow: var(--shadow-lg);
    animation: slideInUp 0.6s ease;
    transition: 0.3s ease;
}

.carousel-container:hover {
    box-shadow: 0 30px 80px rgba(255, 215, 0, 0.3);
    transform: translateY(-4px);
}

.carousel-container img {
    height: 300px;
    object-fit: cover;
    filter: brightness(0.7);
    transition: 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.carousel-container:hover img {
    filter: brightness(0.95);
    transform: scale(1.05);
}

.materials-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
    flex-wrap: gap-3;
    animation: slideInUp 0.6s ease;
}

.materials-header-left h4 {
    font-size: 1.6rem;
    font-weight: 900;
    margin: 0 0 6px;
    color: var(--text-light);
}

.materials-header-left p {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin: 0;
    font-weight: 700;
}

.search-form {
    display: flex;
    gap: 8px;
}

.search-form input {
    background: var(--surface);
    border: 2px solid var(--border);
    color: var(--text-light);
    border-radius: 10px;
    padding: 10px 16px;
    outline: none;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    width: 220px;
    font-weight: 500;
}

.search-form input:focus {
    border-color: var(--accent);
    background: var(--surface-alt);
    box-shadow: 0 0 0 4px var(--focus-ring);
    transform: scale(1.02);
}

.search-form input::placeholder {
    color: var(--text-secondary);
    font-weight: 700;
}

.search-form button {
    background: var(--accent);
    border: none;
    color: var(--primary);
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    overflow: hidden;
}

.search-form button::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    transition: 0.5s;
}

.search-form button:hover::before {
    left: 100%;
}

.search-form button:hover {
    background: var(--hover-secondary);
    transform: translateY(-3px) scale(1.05);
    box-shadow: var(--shadow-md);
}

.material-card {
    background: white;
    border-radius: 12px;
    padding: 12px;
    border: 3px solid var(--accent);
    transition: 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    height: 100%;
    animation: slideInUp 0.6s ease both;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
}

.material-card:nth-child(1) { animation-delay: 0.1s; }
.material-card:nth-child(2) { animation-delay: 0.2s; }
.material-card:nth-child(3) { animation-delay: 0.3s; }
.material-card:nth-child(4) { animation-delay: 0.4s; }
.material-card:nth-child(5) { animation-delay: 0.5s; }
.material-card:nth-child(6) { animation-delay: 0.6s; }

.material-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary);
    opacity: 0;
    transition: 0.3s;
    z-index: 1;
}

.material-card:hover {
    transform: translateY(-12px) scale(1.02);
    background: white;
    border-color: var(--primary);
    box-shadow: var(--shadow-md);
}

.material-card:hover::before { opacity: 1; }

.material-card img {
    height: 120px;
    width: 100%;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 10px;
    transition: 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.material-card:hover img { transform: scale(1.12) rotate(1deg); }

.material-card-content {
    flex: 1;
}

.material-card-footer {
    margin-top: auto;
    padding-top: 8px;
}

.material-card h5 { 
    font-weight: 900; 
    margin-bottom: 4px;
    color: var(--primary);
    font-size: 0.95rem;
}

.material-card .price { 
    color: var(--primary); 
    font-weight: 900; 
    font-size: 1.1rem;
    margin-bottom: 2px;
}

.material-card .unit  { 
    color: var(--secondary); 
    font-size: 0.75rem; 
    margin-bottom: 8px;
    font-weight: 800;
}

.empty-state {
    background: white;
    border: 3px dashed var(--accent);
    border-radius: 16px;
    padding: 48px;
    text-align: center;
    color: var(--primary);
    font-weight: 700;
    box-shadow: var(--shadow-sm);
}

.empty-state i {
    font-size: 3rem;
    display: block;
    margin-bottom: 16px;
    color: var(--secondary);
}

/* ========================
   MINIMAL ADD TO CART BUTTON
======================== */
.add-to-cart-btn {
    width: 100%;
    background: var(--accent);
    border: 2px solid var(--accent);
    color: var(--primary);
    padding: 10px 12px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
    outline: none;
    position: relative;
    overflow: hidden;
    line-height: 1;
}

.add-to-cart-btn:hover:not(.disabled) {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--accent);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 215, 0, 0.3);
    text-decoration: none;
}

.add-to-cart-btn:active:not(.disabled) {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(255, 215, 0, 0.2);
}

.add-to-cart-btn.disabled {
    background: #6b7280;
    border-color: #6b7280;
    color: #9ca3af;
    cursor: not-allowed;
    opacity: 0.6;
}

.add-to-cart-btn i {
    font-size: 1rem;
    transition: transform 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.add-to-cart-btn:hover:not(.disabled) i {
    transform: scale(1.1);
}

.add-to-cart-btn span {
    font-weight: 700;
    letter-spacing: 0.3px;
    display: flex;
    align-items: center;
}
</style>

<div class="container-fluid p-4">

    <!-- HERO CAROUSEL -->
    <div id="materialCarousel" class="carousel slide carousel-container" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.pexels.com/photos/31925745/pexels-photo-31925745.jpeg"
                     class="d-block w-100" alt="Sand materials">
            </div>
            <div class="carousel-item">
                <img src="https://images.pexels.com/photos/17727059/pexels-photo-17727059.jpeg"
                     class="d-block w-100" alt="Stone materials">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#materialCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#materialCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- TITLE + SEARCH -->
    <div class="materials-header">
        <div class="materials-header-left">
            <h4><i class="bi bi-box-seam-fill"></i> Available Materials</h4>
            <p><?= count($materials) ?> material<?= count($materials) !== 1 ? 's' : '' ?> found</p>
        </div>
        <form method="GET" class="search-form">
            <input type="hidden" name="controller" value="materials">
            <input type="hidden" name="action" value="index">
            <input type="search" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                   placeholder="Search materials...">
            <button type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <!-- GRID -->
    <?php if (empty($materials)): ?>
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            No materials found.
        </div>
    <?php else: ?>
    <div class="row">
        <?php foreach ($materials as $m): ?>
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="material-card">
                <?php 
                    $imagePath = '';
                    if (!empty($m['image'])) {
                        if (strpos($m['image'], 'http') === 0) {
                            $imagePath = htmlspecialchars($m['image'], ENT_QUOTES, 'UTF-8');
                        } else {
                            $imagePath = '/app/public/assets/imgs/materials/' . htmlspecialchars($m['image']);
                        }
                    } else {
                        $imagePath = 'https://images.pexels.com/photos/2219024/pexels-photo-2219024.jpeg?auto=compress&cs=tinysrgb&w=1200';
                    }
                ?>
                <img src="<?= $imagePath ?>"
                     alt="<?= htmlspecialchars($m['material_name'] ?? '') ?>"
                     onclick="document.getElementById('lightboxImg').src=this.src; document.getElementById('lightboxCaption').textContent='<?= htmlspecialchars($m['material_name'] ?? '', ENT_QUOTES) ?>'; document.getElementById('imageLightbox').style.display='flex'; document.body.style.overflow='hidden';"
                     style="cursor: pointer; transition: transform 0.3s ease;"
                     onmouseover="this.style.transform='scale(1.05)'"
                     onmouseout="this.style.transform='scale(1)'">
                <div class="material-card-content">
                    <h5><?= htmlspecialchars($m['material_name'] ?? '') ?></h5>
                    <div class="price">₱<?= number_format($m['unit_price'] ?? 0, 2) ?></div>
                    <div class="unit"><?= htmlspecialchars($m['unit_type'] ?? '') ?></div>
                </div>
                <div class="material-card-footer">
                    <?php if (($m['stock_quantity'] ?? 0) > 0): ?>
                        <button class="add-to-cart-btn" onclick="openAddToCartModal(<?= $m['material_id'] ?>, '<?= htmlspecialchars($m['material_name']) ?>', <?= $m['unit_price'] ?>, '<?= htmlspecialchars($m['unit_type']) ?>', <?= $m['stock_quantity'] ?>, '<?= $imagePath ?>')">
                            <i class="bi bi-cart-plus"></i>
                            <span>Add to Cart</span>
                        </button>
                    <?php else: ?>
                        <button class="add-to-cart-btn disabled" disabled>
                            <i class="bi bi-x-circle"></i>
                            <span>Out of Stock</span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>

<!-- ADD TO CART MODAL -->
<div class="adm-modal-overlay" id="addToCartModal" style="z-index: 9999;">
  <div class="adm-modal" style="max-width: 500px; background: #2d2d2d; color: #ffffff;">
    <button class="adm-modal-close" onclick="closeAddToCartModal()" style="color: #ffffff;">
      <i class="bi bi-x-lg"></i>
    </button>
    <h3 style="color: #FFD700; margin-bottom: 20px;">
      <i class="bi bi-cart-plus-fill me-2"></i>Add to Cart
    </h3>
    
    <div style="display: flex; gap: 20px; margin-bottom: 20px;">
      <!-- Material Image -->
      <div style="flex-shrink: 0;">
        <img id="modalMaterialImage" src="" alt="" 
             style="width: 120px; height: 120px; object-fit: cover; border-radius: 12px; border: 3px solid #FFD700;">
      </div>
      
      <!-- Material Info -->
      <div style="flex: 1;">
        <h4 id="modalMaterialName" style="color: #ffffff; margin-bottom: 8px; font-weight: 900;"></h4>
        <div id="modalMaterialPrice" style="color: #FFD700; font-size: 1.5rem; font-weight: 900; margin-bottom: 4px;"></div>
        <div id="modalMaterialUnit" style="color: #cccccc; font-size: 0.9rem; margin-bottom: 12px;"></div>
        <div id="modalStockInfo" style="color: #22c55e; font-size: 0.85rem; font-weight: 700;">
          <i class="bi bi-box-seam me-1"></i><span id="modalStockAmount"></span> available
        </div>
      </div>
    </div>
    
    <!-- Quantity Selection -->
    <div style="margin-bottom: 20px;">
      <label style="color: #ffffff; font-weight: 700; margin-bottom: 12px; display: block;">
        <i class="bi bi-plus-circle-fill me-2"></i>Select Quantity
        <span id="modalMaxLabel" style="color: #aaa; font-size: 0.8rem; font-weight: 500; margin-left: 8px;"></span>
      </label>
      
      <div style="display: flex; align-items: center; gap: 12px; justify-content: center;">
        <button type="button" onclick="decreaseQuantity()" 
                style="background: #FFD700; border: none; color: #1a1a1a; width: 40px; height: 40px; border-radius: 50%; font-size: 1.2rem; font-weight: 900; cursor: pointer;">
          <i class="bi bi-dash"></i>
        </button>
        
        <div style="background: rgba(255,255,255,0.1); border: 2px solid #FFD700; border-radius: 8px; padding: 0; min-width: 80px; height: 50px; display: flex; align-items: center; justify-content: center;">
          <input type="number" id="modalQuantity" value="1" min="1" 
                 style="background: transparent; border: none; color: #ffffff; font-size: 1.4rem; font-weight: 900; text-align: center; width: 100%; height: 100%; outline: none; line-height: 1; padding: 0; margin: 0; -webkit-appearance: none; -moz-appearance: textfield; box-sizing: border-box; display: flex; align-items: center; justify-content: center;"
                 onchange="updateModalTotal()" oninput="updateModalTotal()">
        </div>
        
        <button type="button" onclick="increaseQuantity()" 
                style="background: #FFD700; border: none; color: #1a1a1a; width: 40px; height: 40px; border-radius: 50%; font-size: 1.2rem; font-weight: 900; cursor: pointer;">
          <i class="bi bi-plus"></i>
        </button>
      </div>

      <!-- Stock limit warning -->
      <div id="stockLimitWarning" style="display:none; color: #ef4444; font-size: 0.8rem; font-weight: 700; text-align: center; margin-top: 8px;">
        <i class="bi bi-exclamation-triangle-fill me-1"></i>Maximum available stock reached
      </div>
    </div>
    
    <!-- Total Display -->
    <div style="background: rgba(255,215,0,0.1); border: 2px solid #FFD700; border-radius: 12px; padding: 16px; margin-bottom: 20px; text-align: center;">
      <div style="color: #cccccc; font-size: 0.9rem; margin-bottom: 4px;">Total Amount</div>
      <div id="modalTotal" style="color: #FFD700; font-size: 1.8rem; font-weight: 900;"></div>
    </div>
    
    <!-- Action Buttons -->
    <div style="display: flex; gap: 12px;">
      <button type="button" onclick="closeAddToCartModal()" 
              style="flex: 1; background: transparent; border: 2px solid #666; color: #cccccc; padding: 12px; border-radius: 8px; font-weight: 700; cursor: pointer;">
        Cancel
      </button>
      <button type="button" onclick="confirmAddToCart()" 
              style="flex: 2; background: linear-gradient(135deg, #FFD700, #FFB000); border: none; color: #1a1a1a; padding: 12px; border-radius: 8px; font-weight: 900; cursor: pointer;">
        <i class="bi bi-cart-plus-fill me-2"></i>Add to Cart
      </button>
    </div>
  </div>
</div>

<!-- IMAGE LIGHTBOX MODAL -->
<div id="imageLightbox" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.95); display: none; align-items: center; justify-content: center; z-index: 99999; cursor: pointer;" onclick="this.style.display='none'; document.body.style.overflow='auto';">
  <div style="position: relative; max-width: 95vw; max-height: 95vh; text-align: center;" onclick="event.stopPropagation()">
    <button onclick="document.getElementById('imageLightbox').style.display='none'; document.body.style.overflow='auto';" style="position: absolute; top: -60px; right: 0; background: rgba(255,255,255,0.2); border: none; color: white; font-size: 30px; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold;">×</button>
    <img id="lightboxImg" src="" alt="" style="max-width: 100%; max-height: 85vh; object-fit: contain; border-radius: 8px; box-shadow: 0 20px 60px rgba(0,0,0,0.8);">
    <div id="lightboxCaption" style="color: white; font-size: 18px; font-weight: bold; margin-top: 15px; padding: 10px 20px; background: rgba(0,0,0,0.7); border-radius: 8px; display: inline-block;"></div>
  </div>
</div>

<script>
let currentMaterial = {};

function openAddToCartModal(materialId, name, price, unit, stock, imagePath) {
  currentMaterial = {
    id: materialId,
    name: name,
    price: parseFloat(price),
    unit: unit,
    stock: parseInt(stock),
    image: imagePath
  };
  
  // Populate modal with material data
  document.getElementById('modalMaterialImage').src = imagePath || 'https://images.pexels.com/photos/21854544/pexels-photo-21854544.jpeg?auto=compress&cs=tinysrgb&w=1200';
  document.getElementById('modalMaterialName').textContent = name;
  document.getElementById('modalMaterialPrice').textContent = '₱' + parseFloat(price).toFixed(2);
  document.getElementById('modalMaterialUnit').textContent = unit;
  document.getElementById('modalStockAmount').textContent = stock;
  document.getElementById('modalMaxLabel').textContent = '(max: ' + stock + ')';

  // Reset quantity with proper min/max
  const qtyInput = document.getElementById('modalQuantity');
  qtyInput.min = 1;
  qtyInput.max = stock;
  qtyInput.value = 1;

  document.getElementById('stockLimitWarning').style.display = 'none';
  updateModalTotal();
  
  // Show modal
  document.getElementById('addToCartModal').classList.add('open');
}

function closeAddToCartModal() {
  document.getElementById('addToCartModal').classList.remove('open');
}

function decreaseQuantity() {
  const input = document.getElementById('modalQuantity');
  const currentValue = parseInt(input.value) || 1;
  if (currentValue > 1) {
    input.value = currentValue - 1;
    document.getElementById('stockLimitWarning').style.display = 'none';
    updateModalTotal();
  }
}

function increaseQuantity() {
  const input = document.getElementById('modalQuantity');
  const currentValue = parseInt(input.value) || 1;
  const maxStock = parseInt(input.max) || currentMaterial.stock;
  if (currentValue < maxStock) {
    input.value = currentValue + 1;
    document.getElementById('stockLimitWarning').style.display = 'none';
    updateModalTotal();
  } else {
    input.style.borderColor = '#ef4444';
    document.getElementById('stockLimitWarning').style.display = 'block';
    setTimeout(() => { input.style.borderColor = '#FFD700'; }, 1500);
  }
}

function updateModalTotal() {
  const input = document.getElementById('modalQuantity');
  let quantity = parseInt(input.value) || 1;
  const maxStock = parseInt(input.max) || currentMaterial.stock;

  if (quantity < 1) { quantity = 1; input.value = 1; }
  if (quantity > maxStock) {
    quantity = maxStock;
    input.value = maxStock;
    input.style.borderColor = '#ef4444';
    document.getElementById('stockLimitWarning').style.display = 'block';
    setTimeout(() => { input.style.borderColor = '#FFD700'; }, 1500);
  } else {
    document.getElementById('stockLimitWarning').style.display = 'none';
  }

  const total = quantity * currentMaterial.price;
  document.getElementById('modalTotal').textContent = '₱' + total.toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });

  // Update stock info color
  const stockInfo = document.getElementById('modalStockInfo');
  const remaining = maxStock - quantity;
  if (remaining === 0) {
    stockInfo.style.color = '#ef4444';
  } else if (remaining <= 5) {
    stockInfo.style.color = '#f59e0b';
  } else {
    stockInfo.style.color = '#22c55e';
  }
}

function confirmAddToCart() {
  const quantity = parseInt(document.getElementById('modalQuantity').value) || 1;
  const button = document.querySelector('#addToCartModal button[onclick="confirmAddToCart()"]');
  const originalContent = button.innerHTML;
  
  // Show loading state
  button.innerHTML = '<i class="bi bi-arrow-repeat" style="animation: spin 1s linear infinite;"></i> Adding...';
  button.disabled = true;
  
  // Add to cart via AJAX
  fetch(`?controller=cart&action=add&id=${currentMaterial.id}&quantity=${quantity}`, {
    method: 'GET',
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(response => response.json())
  .then(data => {
    button.innerHTML = originalContent;
    button.disabled = false;
    
    if (data.success) {
      // Show success message
      showSuccessMessage(`Added ${quantity} x ${currentMaterial.name} to cart!`);
      closeAddToCartModal();
      
      // Update cart count if there's a cart indicator
      updateCartCount(data.cartCount);
      
      // Refresh page to show updated cart alert
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    } else {
      alert(data.message || 'Failed to add item to cart');
    }
  })
  .catch(error => {
    console.error('AJAX Error:', error);
    button.innerHTML = originalContent;
    button.disabled = false;
    alert('Failed to add item to cart. Please try again.');
  });
}

function showSuccessMessage(message) {
  // Create and show a temporary success message
  const successDiv = document.createElement('div');
  successDiv.style.cssText = `
    position: fixed;
    top: 20px;
    right: 20px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    font-weight: 700;
    z-index: 10000;
    box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
    animation: slideInRight 0.3s ease;
  `;
  successDiv.innerHTML = `<i class="bi bi-check-circle-fill me-2"></i>${message}`;
  
  document.body.appendChild(successDiv);
  
  setTimeout(() => {
    successDiv.remove();
  }, 3000);
}

function updateCartCount(count) {
  const cartBadges = document.querySelectorAll('.cart-badge');
  cartBadges.forEach(badge => {
    badge.textContent = count;
    badge.style.display = count > 0 ? 'inline' : 'none';
  });
}

// Close modal on outside click
document.addEventListener('click', function(e) {
  if (e.target.id === 'addToCartModal') {
    closeAddToCartModal();
  }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeAddToCartModal();
    // Close lightbox on ESC
    document.getElementById('imageLightbox').style.display = 'none';
    document.body.style.overflow = 'auto';
  }
});

// Add CSS for animations and modal
const style = document.createElement('style');
style.textContent = `
  @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
  @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
  
  /* Remove number input spinners */
  input[type="number"]::-webkit-outer-spin-button,
  input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  
  input[type="number"] {
    -moz-appearance: textfield;
  }
  
  /* Force center alignment for number inputs */
  #modalQuantity {
    text-align: center !important;
    vertical-align: middle !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
  }
  
  /* Modal Styles */
  .adm-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: 0.3s ease;
  }
  
  .adm-modal-overlay.open {
    opacity: 1;
    visibility: visible;
  }
  
  .adm-modal {
    background: #2d2d2d;
    border-radius: 16px;
    padding: 24px;
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    z-index: 10000;
    transform: scale(0.8);
    transition: 0.3s ease;
  }
  
  .adm-modal-overlay.open .adm-modal {
    transform: scale(1);
  }
  
  .adm-modal-close {
    position: absolute;
    top: 16px;
    right: 16px;
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.7);
    font-size: 1.2rem;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: 0.3s ease;
  }
  
  .adm-modal-close:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.1);
  }
`;
document.head.appendChild(style);
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
