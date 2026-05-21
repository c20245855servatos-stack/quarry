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

@keyframes pulse-glow {
    0%, 100% { box-shadow: 0 0 0 0 rgba(202, 170, 152, 0.7); }
    50% { box-shadow: 0 0 0 10px rgba(202, 170, 152, 0); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.dash-hero {
    padding: 40px 36px;
    border-radius: 20px;
    background: var(--accent);
    border: 2px solid var(--primary);
    margin-bottom: 32px;
    box-shadow: var(--shadow-lg);
    animation: slideInUp 0.6s ease;
    position: relative;
    overflow: hidden;
    transition: 0.3s ease;
}

.dash-hero:hover {
    border-color: var(--primary);
    box-shadow: var(--shadow-lg);
    transform: translateY(-4px);
}

.dash-hero::before {
    content: "";
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(26, 26, 26, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.dash-hero h1 { 
    font-size: 2.2rem; 
    font-weight: 900; 
    margin: 0 0 8px; 
    color: var(--primary);
    position: relative;
    z-index: 1;
}

.dash-hero p  { 
    color: var(--primary); 
    margin: 0; 
    font-size: 1rem;
    position: relative;
    z-index: 1;
    font-weight: 600;
}

.glass-card {
    background: var(--surface);
    border-radius: 18px;
    border: 3px solid var(--accent);
    padding: 28px 22px;
    text-align: center;
    transition: 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    overflow: hidden;
    animation: slideInUp 0.6s ease both;
    box-shadow: var(--shadow-sm);
}

.glass-card:nth-child(1) { animation-delay: 0.1s; }
.glass-card:nth-child(2) { animation-delay: 0.2s; }
.glass-card:nth-child(3) { animation-delay: 0.3s; }
.glass-card:nth-child(4) { animation-delay: 0.4s; }

.glass-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--primary);
    opacity: 0;
    transition: 0.3s;
}

.glass-card:hover { 
    background: var(--surface-alt);
    transform: translateY(-12px) scale(1.03);
    border-color: var(--accent);
    box-shadow: var(--shadow-md);
}

.glass-card:hover::before { opacity: 1; }

.stat-card-link {
    -webkit-tap-highlight-color: transparent;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    user-select: none;
    outline: none;
    display: block;
}

.stat-card-link:focus,
.stat-card-link:focus-visible {
    outline: none;
    box-shadow: none;
}

.glass-card:active {
    transform: translateY(-4px) scale(0.98);
    background: var(--accent);
    border-color: var(--primary);
    box-shadow: var(--shadow-sm);
}

.glass-card:active h3 {
    color: var(--primary);
    transform: scale(1.05);
}

.glass-card:active p {
    color: var(--primary);
}

.glass-card h3 { 
    font-size: 2.8rem; 
    font-weight: 900; 
    color: var(--text-primary); 
    margin: 0 0 6px;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
}

.glass-card h3::before {
    content: none;
}

.glass-card:hover h3 {
    transform: scale(1.15);
}

.glass-card:hover h3::before {
    opacity: 0;
}

.glass-card p  { 
    color: var(--text-secondary); 
    font-size: 0.85rem; 
    text-transform: uppercase; 
    letter-spacing: 1px; 
    margin: 0;
    font-weight: 800;
}

.section-title {
    font-size: 1.4rem;
    font-weight: 900;
    margin-bottom: 20px;
    color: var(--text-light);
    display: flex;
    align-items: center;
    gap: 10px;
    animation: slideInUp 0.6s ease;
}

.empty-state {
    background: var(--surface);
    border: 2px dashed var(--accent);
    border-radius: 16px;
    padding: 48px;
    text-align: center;
    color: var(--text-primary);
    font-weight: 700;
}

.empty-state i {
    font-size: 3rem;
    display: block;
    margin-bottom: 16px;
    color: var(--text-secondary);
}

.history-card {
    background: var(--surface);
    border: 3px solid var(--accent);
    border-radius: 16px;
    overflow: hidden;
    animation: slideInUp 0.6s ease;
    transition: 0.3s ease;
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.15);
}

.history-card:hover {
    border-color: var(--accent);
    box-shadow: 0 12px 40px rgba(255, 215, 0, 0.25);
}

.history-header {
    background: var(--accent);
    padding: 16px 20px;
    border-bottom: 2px solid var(--primary);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.history-header h6 {
    margin: 0;
    font-size: 0.85rem;
    font-weight: 900;
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.history-item {
    padding: 16px 20px;
    border-bottom: 1px solid var(--accent);
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: 0.2s ease;
    animation: fadeIn 0.4s ease both;
}

.history-item:nth-child(1) { animation-delay: 0.1s; }
.history-item:nth-child(2) { animation-delay: 0.15s; }
.history-item:nth-child(3) { animation-delay: 0.2s; }
.history-item:nth-child(4) { animation-delay: 0.25s; }
.history-item:nth-child(5) { animation-delay: 0.3s; }

.history-item:last-child {
    border-bottom: none;
}

.history-item:hover {
    background: rgba(255, 215, 0, 0.1);
}

.history-item-left {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.history-item-name {
    font-weight: 900;
    color: var(--text-primary);
    font-size: 0.95rem;
}

.history-item-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.8rem;
    color: var(--text-secondary);
    font-weight: 700;
}

.history-item-meta span {
    display: flex;
    align-items: center;
    gap: 4px;
}

.history-item-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
}

.history-item-price {
    font-size: 1.1rem;
    font-weight: 900;
    color: var(--text-primary);
}

.history-item-qty {
    background: var(--accent);
    border: 1px solid var(--primary);
    color: var(--primary);
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 800;
}

.history-footer {
    background: var(--accent);
    padding: 12px 20px;
    text-align: center;
    color: var(--primary);
    font-size: 0.8rem;
    font-weight: 700;
    border-top: 1px solid var(--primary);
}

@media (max-width: 768px) {
    .history-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .history-item-right {
        width: 100%;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }

    .history-item-meta {
        flex-wrap: wrap;
    }

    .dash-hero {
        padding: 28px 20px;
    }

    .dash-hero h1 {
        font-size: 1.6rem;
    }
}

/* Stat cards: 2 columns on tablet, 1 on small mobile */
@media (max-width: 991px) {
    .row .col-3 {
        flex: 0 0 auto;
        width: 50%;
    }
}

@media (max-width: 575px) {
    .row .col-3 {
        flex: 0 0 auto;
        width: 100%;
        margin-bottom: 12px;
    }

    .dash-hero {
        padding: 20px 16px;
    }

    .dash-hero h1 {
        font-size: 1.4rem;
    }
}

/* Ensure stats cards stay in one line on larger screens */
@media (min-width: 992px) {
    .row .col-3 {
        flex: 0 0 auto;
        width: 25%;
    }
}
</style>

<div class="container-fluid p-4">

    <!-- HERO -->
    <div class="dash-hero">
        <h1>Welcome back, <?= htmlspecialchars($user['name'] ?? 'Guest') ?> <i class="bi bi-hand-wave-fill"></i></h1>
        <p>Your premium sand, stone & gravel supply dashboard</p>
    </div>

    <!-- STATS -->
    <div class="row mb-4">
        <div class="col-3 mb-3">
            <a href="?controller=dashboard&action=orders" class="stat-card-link" style="text-decoration:none;display:block;height:100%;">
                <div class="glass-card" style="cursor:pointer;">
                    <h3><?= count($myOrders ?? []) ?></h3>
                    <p>Total Orders</p>
                </div>
            </a>
        </div>
        <div class="col-3 mb-3">
            <a href="?controller=dashboard&action=orders" class="stat-card-link" style="text-decoration:none;display:block;height:100%;">
                <div class="glass-card" style="cursor:pointer;">
                    <h3><?= $pendingCount ?? 0 ?></h3>
                    <p>Pending Orders</p>
                </div>
            </a>
        </div>
        <div class="col-3 mb-3">
            <a href="?controller=dashboard&action=orders" class="stat-card-link" style="text-decoration:none;display:block;height:100%;">
                <div class="glass-card" style="cursor:pointer;">
                    <h3><?= $completedCount ?? 0 ?></h3>
                    <p>Completed Orders</p>
                </div>
            </a>
        </div>
        <div class="col-3 mb-3">
            <a href="?controller=cart&action=index" class="stat-card-link" style="text-decoration:none;display:block;height:100%;">
                <div class="glass-card" style="height:100%;display:flex;flex-direction:column;justify-content:center;background:linear-gradient(135deg,rgba(255,193,7,0.2),rgba(255,193,7,0.1));border-color:rgba(255,193,7,0.3);cursor:pointer;">
                    <h3 style="color:#ffc107;margin:0 0 4px;">
                        <i class="bi bi-cart3"></i> 
                        <?php 
                        $cartCount = 0;
                        if (!empty($user['id'])) {
                            try {
                                $cartCount = $materialModel->getCartCount((int)$user['id']);
                            } catch (Exception $e) {
                                $cartCount = count($_SESSION['cart'] ?? []);
                            }
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
    <div class="d-flex gap-3 mb-4 flex-wrap">
        <a href="?controller=materials&action=index" class="btn fw-bold px-4" style="background:#6b7280; border-color:#4b5563; color:#ffffff; transition:all 0.3s ease;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">
            <i class="bi bi-shop me-1"></i> Browse Shop
        </a>
        <a href="?controller=cart&action=index" class="btn fw-bold px-4" style="background:transparent; border:2px solid #6b7280; color:#ffffff; transition:all 0.3s ease;" onmouseover="this.style.background='rgba(107,114,128,0.1)'; this.style.borderColor='#4b5563'" onmouseout="this.style.background='transparent'; this.style.borderColor='#6b7280'">
            <i class="bi bi-cart3 me-1"></i> My Cart
        </a>
        <a href="?controller=dashboard&action=orders" class="btn fw-bold px-4" style="background:transparent; border:2px solid #6b7280; color:#ffffff; transition:all 0.3s ease;" onmouseover="this.style.background='rgba(107,114,128,0.1)'; this.style.borderColor='#4b5563'" onmouseout="this.style.background='transparent'; this.style.borderColor='#6b7280'">
            <i class="bi bi-box-seam me-1"></i> My Orders
        </a>
    </div>

    <!-- CART HISTORY -->

</div>

<script>
// Clear click feedback on stat cards
document.querySelectorAll('.stat-card-link').forEach(link => {
    link.addEventListener('mousedown', function() {
        const card = this.querySelector('.glass-card');
        card.style.transition = 'all 0.1s ease';
        card.style.transform = 'translateY(2px) scale(0.95)';
        card.style.background = '#FFD700';
        card.style.borderColor = '#1a1a1a';
        const h3 = card.querySelector('h3');
        const p = card.querySelector('p');
        if (h3) { h3.style.color = '#1a1a1a'; h3.style.fontSize = '3.2rem'; }
        if (p)  { p.style.color = '#1a1a1a'; }
    });

    link.addEventListener('mouseup', function() {
        const card = this.querySelector('.glass-card');
        card.style.transition = 'all 0.3s ease';
        card.style.transform = '';
        card.style.background = '';
        card.style.borderColor = '';
        const h3 = card.querySelector('h3');
        const p = card.querySelector('p');
        if (h3) { h3.style.color = ''; h3.style.fontSize = ''; }
        if (p)  { p.style.color = ''; }
    });

    // Touch support
    link.addEventListener('touchstart', function() {
        this.dispatchEvent(new Event('mousedown'));
    }, { passive: true });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
