<?php
ob_start();
$user = $_SESSION['user'] ?? null;
?>

<style>
/* ========================
   MODERN CONSTRUCTION THEME - DASHBOARD PAGE
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

.dash-hero {
    padding: 20px 8px 16px;
    margin-bottom: 24px;
    animation: slideInUp 0.5s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0;
    background: transparent;
    border: none;
    box-shadow: none;
    border-radius: 0;
    overflow: visible;
    position: relative;
    text-align: center;
}

.dash-hero::before { display: none; }

.dash-hero-welcome {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 4px;
    color: rgba(255,255,255,0.3);
    margin-bottom: 8px;
}

.dash-hero-brand {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    margin-bottom: 8px;
}

.dash-hero-logo {
    width: 64px;
    height: 64px;
    flex-shrink: 0;
}

.dash-hero h1 { 
    font-size: 3.8rem; 
    font-weight: 900; 
    margin: 0; 
    color: #ffffff;
    letter-spacing: 5px;
    text-transform: uppercase;
    line-height: 1;
}

.dash-hero-sub {
    font-size: 0.7rem;
    font-weight: 600;
    color: rgba(255,255,255,0.25);
    letter-spacing: 2.5px;
    text-transform: uppercase;
}

.dash-hero p { display: none; }

/* ── STAT CARDS ── */
.glass-card {
    background: rgba(255,255,255,0.04);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.09);
    padding: 24px 20px;
    text-align: center;
    transition: 0.2s ease;
    position: relative;
    overflow: hidden;
    animation: slideInUp 0.5s ease both;
    cursor: pointer;
}

.glass-card::after {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: #FFD700;
    border-radius: 12px 12px 0 0;
    opacity: 0;
    transition: 0.2s ease;
}

.glass-card:hover {
    background: rgba(255,255,255,0.07);
    border-color: rgba(255,215,0,0.3);
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.4);
}

.glass-card:hover::after { opacity: 1; }

.glass-card::before { content: none; }

.glass-card:nth-child(1) { animation-delay: 0.05s; }
.glass-card:nth-child(2) { animation-delay: 0.1s; }
.glass-card:nth-child(3) { animation-delay: 0.15s; }
.glass-card:nth-child(4) { animation-delay: 0.2s; }

.glass-card h3 { 
    font-size: 2.4rem; 
    font-weight: 900; 
    color: #ffffff; 
    margin: 0 0 6px;
    line-height: 1;
    letter-spacing: -1px;
}

.glass-card p { 
    color: rgba(255,255,255,0.4); 
    font-size: 0.7rem; 
    text-transform: uppercase; 
    letter-spacing: 1.5px; 
    margin: 0;
    font-weight: 700;
}

.stat-card-link {
    text-decoration: none;
    display: block;
    height: 100%;
}

/* ── QUICK ACTIONS ── */
.dash-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 0.88rem;
    font-weight: 700;
    text-decoration: none;
    transition: 0.2s ease;
    border: 1px solid rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.8);
    background: rgba(255,255,255,0.05);
}

.dash-action-btn:hover {
    background: rgba(255,215,0,0.12);
    border-color: rgba(255,215,0,0.4);
    color: #FFD700;
    text-decoration: none;
}

/* ── ORDER HISTORY ── */
.section-title {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: rgba(255,255,255,0.35);
    margin-bottom: 14px;
    animation: slideInUp 0.5s ease;
}

.history-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 12px;
    overflow: hidden;
    animation: slideInUp 0.5s ease;
}

.history-header {
    background: rgba(255,255,255,0.04);
    padding: 14px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.07);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.history-header h6 {
    margin: 0;
    font-size: 0.78rem;
    font-weight: 700;
    color: rgba(255,255,255,0.5);
    text-transform: uppercase;
    letter-spacing: 1.5px;
}

.history-item {
    padding: 14px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: 0.15s ease;
    animation: fadeIn 0.4s ease both;
}

.history-item:last-child { border-bottom: none; }
.history-item:hover { background: rgba(255,255,255,0.03); }

.history-item-left {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.history-item-name {
    font-weight: 700;
    color: #ffffff;
    font-size: 0.9rem;
}

.history-item-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.75rem;
    color: rgba(255,255,255,0.35);
    font-weight: 600;
}

.history-item-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
}

.history-item-price {
    font-size: 0.95rem;
    font-weight: 800;
    color: #ffffff;
}

.history-item-qty {
    background: rgba(255,215,0,0.1);
    border: 1px solid rgba(255,215,0,0.2);
    color: #FFD700;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 0.68rem;
    font-weight: 700;
}

.history-footer {
    background: rgba(255,255,255,0.03);
    padding: 12px 20px;
    text-align: center;
    font-size: 0.78rem;
    font-weight: 700;
    border-top: 1px solid rgba(255,255,255,0.06);
}

.history-footer a {
    color: rgba(255,255,255,0.4);
    text-decoration: none;
    transition: 0.2s;
}

.history-footer a:hover { color: #FFD700; }

.empty-state {
    background: rgba(255,255,255,0.03);
    border: 1px dashed rgba(255,255,255,0.1);
    border-radius: 12px;
    padding: 48px;
    text-align: center;
    color: rgba(255,255,255,0.4);
    font-weight: 600;
}

.empty-state i {
    font-size: 2.5rem;
    display: block;
    margin-bottom: 12px;
    opacity: 0.3;
}

@media (max-width: 768px) {
    .history-item { flex-direction: column; align-items: flex-start; gap: 10px; }
    .history-item-right { width: 100%; flex-direction: row; justify-content: space-between; }
    .dash-hero { padding: 24px 8px 20px; }
    .dash-hero h1 { font-size: 2.2rem; letter-spacing: 2px; }
    .dash-hero-logo { width: 52px; height: 52px; }
}

@media (max-width: 991px) {
    .row .col-3 { flex: 0 0 auto; width: 50%; }
}

@media (max-width: 575px) {
    .row .col-3 { flex: 0 0 auto; width: 100%; margin-bottom: 12px; }
}

@media (min-width: 992px) {
    .row .col-3 { flex: 0 0 auto; width: 25%; }
}
</style>

<div class="container-fluid p-4">

    <!-- FEATURED BANNER -->
    <div id="dashCarousel" class="carousel slide mb-4" data-bs-ride="carousel" style="border-radius:16px; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,0.6); border:2px solid rgba(255,215,0,0.3);">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#dashCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#dashCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#dashCarousel" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#dashCarousel" data-bs-slide-to="3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.pexels.com/photos/1029604/pexels-photo-1029604.jpeg?auto=compress&cs=tinysrgb&w=1400" class="d-block w-100" alt="Crushed Stone" style="height:240px; object-fit:cover; filter:brightness(0.5);">
                <div class="carousel-caption" style="bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%); padding:30px 24px 20px; text-align:left;">
                    <h5 style="font-weight:900; font-size:1.3rem; color:#FFD700; margin:0 0 4px;">Premium Crushed Stone</h5>
                    <p style="font-weight:700; color:#ffffff; margin:0; font-size:0.9rem;">High-quality aggregates for construction</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.pexels.com/photos/13838908/pexels-photo-13838908.png?auto=compress&cs=tinysrgb&w=1400" class="d-block w-100" alt="Gravel" style="height:240px; object-fit:cover; filter:brightness(0.5);">
                <div class="carousel-caption" style="bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%); padding:30px 24px 20px; text-align:left;">
                    <h5 style="font-weight:900; font-size:1.3rem; color:#FFD700; margin:0 0 4px;">Construction Gravel</h5>
                    <p style="font-weight:700; color:#ffffff; margin:0; font-size:0.9rem;">Ideal for drainage and road base</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.pexels.com/photos/27523355/pexels-photo-27523355.jpeg?auto=compress&cs=tinysrgb&w=1400" class="d-block w-100" alt="Fine Sand" style="height:240px; object-fit:cover; filter:brightness(0.5);">
                <div class="carousel-caption" style="bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%); padding:30px 24px 20px; text-align:left;">
                    <h5 style="font-weight:900; font-size:1.3rem; color:#FFD700; margin:0 0 4px;">Fine Sand</h5>
                    <p style="font-weight:700; color:#ffffff; margin:0; font-size:0.9rem;">Perfect for concrete and plastering</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.pexels.com/photos/31925745/pexels-photo-31925745.jpeg?auto=compress&cs=tinysrgb&w=1400" class="d-block w-100" alt="Quarry Materials" style="height:240px; object-fit:cover; filter:brightness(0.5);">
                <div class="carousel-caption" style="bottom:0; left:0; right:0; background:linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%); padding:30px 24px 20px; text-align:left;">
                    <h5 style="font-weight:900; font-size:1.3rem; color:#FFD700; margin:0 0 4px;">Quarry Materials</h5>
                    <p style="font-weight:700; color:#ffffff; margin:0; font-size:0.9rem;">Direct from quarry to your site</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#dashCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
        <button class="carousel-control-next" type="button" data-bs-target="#dashCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
    </div>

    <!-- STATS -->
    <div class="row mb-4">
        <div class="col-3 mb-3">
            <a href="?controller=dashboard&action=orders" class="stat-card-link">
                <div class="glass-card">
                    <h3><?= count($myOrders ?? []) ?></h3>
                    <p>Total Orders</p>
                </div>
            </a>
        </div>
        <div class="col-3 mb-3">
            <a href="?controller=dashboard&action=orders&status=pending" class="stat-card-link">
                <div class="glass-card">
                    <h3><?= $pendingCount ?? 0 ?></h3>
                    <p>Pending Orders</p>
                </div>
            </a>
        </div>
        <div class="col-3 mb-3">
            <a href="?controller=dashboard&action=orders&status=completed" class="stat-card-link">
                <div class="glass-card">
                    <h3><?= $completedCount ?? 0 ?></h3>
                    <p>Completed Orders</p>
                </div>
            </a>
        </div>
        <div class="col-3 mb-3">
            <a href="?controller=cart&action=index" class="stat-card-link">
                <div class="glass-card">
                    <h3 style="color:#FFD700;">
                        <?php 
                        $cartCount = 0;
                        if (!empty($user['id'])) {
                            try { $cartCount = $materialModel->getCartCount((int)$user['id']); }
                            catch (Exception $e) { $cartCount = count($_SESSION['cart'] ?? []); }
                        } else {
                            $cartCount = count($_SESSION['cart'] ?? []);
                        }
                        echo $cartCount;
                        ?>
                    </h3>
                    <p>Items in Cart</p>
                </div>
            </a>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="d-flex gap-2 mb-4 flex-wrap">
        <a href="?controller=materials&action=index" class="dash-action-btn">
            <i class="bi bi-shop"></i> Browse Shop
        </a>
        <a href="?controller=cart&action=index" class="dash-action-btn">
            <i class="bi bi-cart3"></i> My Cart
        </a>
        <a href="?controller=dashboard&action=orders" class="dash-action-btn">
            <i class="bi bi-box-seam"></i> My Orders
        </a>
    </div>

    <!-- CART HISTORY -->

</div>

<script>
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
