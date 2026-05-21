<?php ob_start(); ?>

<style>
/* ========================
   MODERN CONSTRUCTION THEME - SHOP PAGE
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

@keyframes slideInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes shimmer {
    0% { background-position: -1000px 0; }
    100% { background-position: 1000px 0; }
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

.shop-header {
    background: var(--primary);
    border-radius: 18px;
    padding: 32px;
    margin-bottom: 28px;
    box-shadow: var(--shadow-md);
    animation: slideInDown 0.6s ease;
    transition: 0.3s ease;
}

.shop-header:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-4px);
}

.shop-header h2 {
    font-size: 2rem;
    font-weight: 900;
    margin: 0 0 8px;
    color: var(--text-light);
}

.shop-header p {
    color: var(--text-secondary);
    margin: 0;
    font-size: 0.95rem;
    font-weight: 700;
}

.search-box {
    background: rgba(0, 0, 0, 0.3);
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 12px;
    padding: 10px 16px;
    color: var(--text-light);
    outline: none;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    width: 100%;
    max-width: 280px;
}

.search-box:focus {
    background: rgba(0, 0, 0, 0.5);
    border-color: var(--accent);
    box-shadow: 0 0 0 4px var(--focus-ring);
    transform: scale(1.02);
}

.search-box::placeholder {
    color: var(--text-secondary);
    font-weight: 700;
}

.cart-alert {
    background: var(--accent);
    border: 2px solid var(--secondary);
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    animation: slideInUp 0.6s ease;
    transition: 0.3s ease;
}

.cart-alert:hover {
    background: var(--accent);
    border-color: var(--primary);
    transform: translateX(4px);
}

.cart-alert span {
    color: var(--primary);
    font-weight: 900;
}

.shop-card {
    background: white;
    border: 3px solid var(--accent);
    border-radius: 16px;
    overflow: hidden;
    transition: 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    height: 100%;
    animation: slideInUp 0.6s ease both;
    position: relative;
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
}

.shop-card:nth-child(1) { animation-delay: 0.1s; }
.shop-card:nth-child(2) { animation-delay: 0.2s; }
.shop-card:nth-child(3) { animation-delay: 0.3s; }
.shop-card:nth-child(4) { animation-delay: 0.4s; }
.shop-card:nth-child(5) { animation-delay: 0.5s; }
.shop-card:nth-child(6) { animation-delay: 0.6s; }

.shop-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--secondary);
    opacity: 0;
    transition: 0.3s;
    z-index: 1;
}

.shop-card:hover { 
    transform: translateY(-12px) scale(1.02);
    background: white;
    border-color: var(--hover-secondary);
    box-shadow: var(--shadow-md);
}

.shop-card:hover::before { opacity: 1; }

.shop-card img   { 
    height: 120px; 
    width: 100%; 
    object-fit: cover;
    transition: 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.shop-card:hover img { transform: scale(1.12) rotate(1deg); }

.shop-card .card-body { 
    padding: 12px;
    position: relative;
    z-index: 2;
    background: white;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.shop-card-content {
    flex: 1;
}

.shop-card-footer {
    margin-top: auto;
    padding-top: 8px;
}

.shop-card h5    { 
    font-weight: 900; 
    margin-bottom: 4px;
    color: var(--primary);
    font-size: 0.95rem;
}

.shop-card .price { 
    color: var(--primary); 
    font-weight: 900; 
    font-size: 1.1rem;
    margin-bottom: 2px;
}

.shop-card .unit  { 
    color: var(--primary); 
    font-size: 0.75rem; 
    margin-bottom: 8px;
    font-weight: 800;
}

.shop-card .desc  { 
    color: var(--primary); 
    font-size: 0.8rem; 
    margin-bottom: 10px; 
    line-height: 1.4;
    font-weight: 700;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.empty-state {
    background: white;
    border: 3px dashed var(--secondary);
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

.empty-state {
    background: white;
    border: 3px dashed var(--secondary);
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

.stock-info {
    font-size: 0.7rem;
    color: var(--secondary);
    font-weight: 700;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.stock-info.low-stock {
    color: #f59e0b;
}

.stock-info.out-of-stock {
    color: #ef4444;
}

/* ========================
   MINIMAL ADD TO CART BUTTON
======================== */
.add-to-cart-btn {
    width: 100%;
    background: var(--accent);
    border: 2px solid var(--accent);
    color: var(--primary);
    padding: 8px 10px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.78rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    text-decoration: none;
    outline: none;
    position: relative;
    overflow: hidden;
    line-height: 1;
    white-space: nowrap;
}

.add-to-cart-btn:hover:not(.disabled) {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--accent);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 215, 0, 0.3);
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
    font-size: 0.85rem;
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

/* ========================
   RESPONSIVE
======================== */
@media (max-width: 991px) {
    .shop-header h2 {
        font-size: 1.6rem;
    }
}

@media (max-width: 768px) {
    .shop-header {
        padding: 20px;
    }

    .shop-header h2 {
        font-size: 1.4rem;
    }

    .shop-header .d-flex {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .search-box {
        max-width: 100%;
    }

    .shop-header form {
        width: 100%;
    }

    .shop-header form .search-box {
        flex: 1;
    }
}

@media (max-width: 575px) {
    .shop-header {
        padding: 16px;
        border-radius: 12px;
    }

    .shop-header h2 {
        font-size: 1.2rem;
    }

    .cart-alert {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 14px;
    }

    .empty-state {
        padding: 32px 16px;
    }
}
</style>

<div class="container-fluid p-4">

    <!-- SHOP CAROUSEL -->
    <div id="shopCarousel" class="carousel slide mb-4" data-bs-ride="carousel" style="
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.6);
        border: 3px solid #FFD700;
    ">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#shopCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#shopCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#shopCarousel" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#shopCarousel" data-bs-slide-to="3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.pexels.com/photos/1029604/pexels-photo-1029604.jpeg?auto=compress&cs=tinysrgb&w=1400"
                     class="d-block w-100" alt="Crushed Stone"
                     style="height:260px; object-fit:cover; filter:brightness(0.5);">
                <div class="carousel-caption" style="bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%); padding:30px 24px 20px; text-align:left;">
                    <h5 style="font-weight:900; font-size:1.3rem; color:#FFD700; margin:0 0 4px;">Premium Crushed Stone</h5>
                    <p style="font-weight:700; color:#ffffff; margin:0; font-size:0.9rem;">High-quality aggregates for construction</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.pexels.com/photos/13838908/pexels-photo-13838908.png?auto=compress&cs=tinysrgb&w=1400"
                     class="d-block w-100" alt="Gravel"
                     style="height:260px; object-fit:cover; filter:brightness(0.5);">
                <div class="carousel-caption" style="bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%); padding:30px 24px 20px; text-align:left;">
                    <h5 style="font-weight:900; font-size:1.3rem; color:#FFD700; margin:0 0 4px;">Construction Gravel</h5>
                    <p style="font-weight:700; color:#ffffff; margin:0; font-size:0.9rem;">Ideal for drainage and road base</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.pexels.com/photos/27523355/pexels-photo-27523355.jpeg?auto=compress&cs=tinysrgb&w=1400"
                     class="d-block w-100" alt="Fine Sand"
                     style="height:260px; object-fit:cover; filter:brightness(0.5);">
                <div class="carousel-caption" style="bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%); padding:30px 24px 20px; text-align:left;">
                    <h5 style="font-weight:900; font-size:1.3rem; color:#FFD700; margin:0 0 4px;">Fine Sand</h5>
                    <p style="font-weight:700; color:#ffffff; margin:0; font-size:0.9rem;">Perfect for concrete and plastering</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.pexels.com/photos/31925745/pexels-photo-31925745.jpeg?auto=compress&cs=tinysrgb&w=1400"
                     class="d-block w-100" alt="Quarry Materials"
                     style="height:260px; object-fit:cover; filter:brightness(0.5);">
                <div class="carousel-caption" style="bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%); padding:30px 24px 20px; text-align:left;">
                    <h5 style="font-weight:900; font-size:1.3rem; color:#FFD700; margin:0 0 4px;">Quarry Materials</h5>
                    <p style="font-weight:700; color:#ffffff; margin:0; font-size:0.9rem;">Direct from quarry to your site</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#shopCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#shopCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- HEADER -->
    <div class="shop-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h2><i class="bi bi-shop me-2"></i>Shop Materials</h2>
                <p><?= count($materials) ?> material<?= count($materials) !== 1 ? 's' : '' ?> available</p>
            </div>
            <form method="GET" class="d-flex gap-2">
                <input type="hidden" name="controller" value="dashboard">
                <input type="hidden" name="action" value="shop">
                <input type="search" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                       placeholder="Search materials..."
                       class="search-box">
                <button type="submit" class="btn btn-light fw-bold px-4">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- CART LINK -->
    <?php $cartCount = count($_SESSION['cart'] ?? []); ?>
    <?php if ($cartCount > 0): ?>
    <div class="cart-alert">
        <span><i class="bi bi-cart-check me-2"></i><?= $cartCount ?> item<?= $cartCount !== 1 ? 's' : '' ?> in your cart</span>
        <a href="?controller=cart&action=index" class="btn btn-sm btn-light fw-bold">View Cart →</a>
    </div>
    <?php endif; ?>

    <!-- GRID -->
    <?php if (empty($materials)): ?>
        <div class="empty-state">
            <i class="bi bi-search"></i>
            No materials found<?= !empty($_GET['search']) ? ' for "'.htmlspecialchars($_GET['search']).'"' : '' ?>.
        </div>
    <?php else: ?>
    <div class="row">
        <?php foreach ($materials as $m): ?>
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="shop-card">
                <?php 
                    $imagePath = '';
                    if (!empty($m['image'])) {
                        if (strpos($m['image'], 'http') === 0) {
                            $imagePath = $m['image'];
                        } else {
                            $imagePath = '/app/public/assets/imgs/materials/' . htmlspecialchars($m['image']);
                        }
                    } else {
                        $imagePath = 'https://images.pexels.com/photos/21854544/pexels-photo-21854544.jpeg?auto=compress&cs=tinysrgb&w=1200';
                    }
                ?>
                <img src="<?= $imagePath ?>"
                     alt="<?= htmlspecialchars($m['material_name'] ?? '') ?>"
                     loading="lazy"
                     onclick="document.getElementById('lightboxImg').src=this.src; document.getElementById('lightboxCaption').textContent='<?= htmlspecialchars($m['material_name'] ?? '', ENT_QUOTES) ?>'; document.getElementById('imageLightbox').style.display='flex'; document.body.style.overflow='hidden';"
                     style="cursor: pointer; transition: transform 0.3s ease;"
                     onmouseover="this.style.transform='scale(1.05)'"
                     onmouseout="this.style.transform='scale(1)'">
                <div class="card-body">
                    <div class="shop-card-content">
                        <h5><?= htmlspecialchars($m['material_name'] ?? '') ?></h5>
                        <div class="price">₱<?= number_format($m['unit_price'] ?? 0, 2) ?></div>
                        <div class="unit"><?= htmlspecialchars($m['unit_type'] ?? '') ?></div>
                        <?php if (!empty($m['description'])): ?>
                        <div class="desc"><?= htmlspecialchars($m['description']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="shop-card-footer">
                        <?php 
                        $stock = $m['stock_quantity'] ?? 0;
                        $materialId = $m['material_id'];
                        ?>
                        
                        <?php if ($stock > 0): ?>
                            <!-- Stock Info -->
                            <div class="stock-info <?= $stock <= 10 ? 'low-stock' : '' ?>">
                                <i class="bi bi-box-seam"></i>
                                <span><?= $stock ?> available</span>
                            </div>
                            
                            <div style="display:flex; gap:8px;">
                                <button class="add-to-cart-btn" style="flex:1;" onclick="openAddToCartModal(<?= $materialId ?>, '<?= htmlspecialchars($m['material_name'], ENT_QUOTES) ?>', <?= $m['unit_price'] ?>, '<?= htmlspecialchars($m['unit_type'], ENT_QUOTES) ?>', <?= $stock ?>, '<?= $imagePath ?>')">
                                    <span>Add to Cart</span>
                                </button>
                                <button class="add-to-cart-btn" style="flex:1; background:#1a1a1a; color:#FFD700; border-color:#1a1a1a;" onclick="buyNow(<?= $materialId ?>, '<?= htmlspecialchars($m['material_name'], ENT_QUOTES) ?>', <?= $m['unit_price'] ?>, '<?= htmlspecialchars($m['unit_type'], ENT_QUOTES) ?>', <?= $stock ?>, '<?= $imagePath ?>')">
                                    <span>Buy Now</span>
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="stock-info out-of-stock">
                                <i class="bi bi-x-circle-fill"></i>
                                <span>Out of Stock</span>
                            </div>
                            <button class="add-to-cart-btn disabled" disabled>
                                <i class="bi bi-x-circle"></i>
                                <span>Out of Stock</span>
                            </button>
                        <?php endif; ?>
                    </div>
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
          <input type="number" id="modalQuantity" value="1" min="1" step="1"
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
  // Reset confirm button back to Add to Cart
  const confirmBtn = document.querySelector('#addToCartModal button[onclick="confirmBuyNow()"]');
  if (confirmBtn) {
    confirmBtn.innerHTML = '<i class="bi bi-cart-plus-fill me-2"></i>Add to Cart';
    confirmBtn.setAttribute('onclick', 'confirmAddToCart()');
  }
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
    // Visual feedback that max is reached
    input.style.borderColor = '#ef4444';
    document.getElementById('stockLimitWarning').style.display = 'block';
    setTimeout(() => { input.style.borderColor = '#FFD700'; }, 1500);
  }
}

function updateModalTotal() {
  const input = document.getElementById('modalQuantity');
  const maxStock = parseInt(input.max) || currentMaterial.stock;

  // Strip decimals and enforce whole number ≥ 1
  let raw = input.value.replace(/[^0-9]/g, ''); // remove non-digits
  let quantity = parseInt(raw) || 1;
  if (quantity < 1) quantity = 1;
  if (quantity > maxStock) {
    quantity = maxStock;
    input.style.borderColor = '#ef4444';
    document.getElementById('stockLimitWarning').style.display = 'block';
    setTimeout(() => { input.style.borderColor = '#FFD700'; }, 1500);
  } else {
    document.getElementById('stockLimitWarning').style.display = 'none';
  }
  input.value = quantity;

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

// Simple redirect to cart controller for adding items (fallback)
function addToCart(materialId) {
    window.location.href = '?controller=cart&action=add&id=' + materialId;
}

// Buy Now: add to cart then redirect to checkout
function buyNow(materialId, name, price, unit, stock, imagePath) {
    openAddToCartModal(materialId, name, price, unit, stock, imagePath);
    // Override the confirm button to redirect to checkout after adding
    const confirmBtn = document.querySelector('#addToCartModal button[onclick="confirmAddToCart()"]');
    if (confirmBtn) {
        confirmBtn.innerHTML = '<i class="bi bi-lightning-charge-fill me-2"></i>Buy Now';
        confirmBtn.setAttribute('onclick', 'confirmBuyNow()');
    }
}

function confirmBuyNow() {
    const quantity = parseInt(document.getElementById('modalQuantity').value) || 1;
    const button = document.querySelector('#addToCartModal button[onclick="confirmBuyNow()"]');
    const originalContent = button.innerHTML;

    button.disabled = true;
    button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Processing...';

    fetch(`?controller=cart&action=add&id=${currentMaterial.id}&quantity=${quantity}`, {
        method: 'GET',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            closeAddToCartModal();
            window.location.href = '?controller=cart&action=checkout';
        } else {
            button.disabled = false;
            button.innerHTML = originalContent;
            showSuccessMessage(data.message || 'Failed to add item.', true);
        }
    })
    .catch(() => {
        button.disabled = false;
        button.innerHTML = originalContent;
    });
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
