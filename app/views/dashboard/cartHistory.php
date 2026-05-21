<?php ob_start(); ?>

<style>
/* ========================
   MODERN CONSTRUCTION THEME - CART HISTORY PAGE
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

.page-header {
    background: var(--accent);
    border-radius: 16px;
    padding: 28px 32px;
    margin-bottom: 28px;
    box-shadow: var(--shadow-md);
    animation: slideInUp 0.6s ease;
}

.page-header h2 {
    color: var(--primary);
    margin: 0 0 8px;
    font-weight: 900;
    font-size: 1.8rem;
}

.page-header p {
    color: var(--primary);
    margin: 0;
    font-size: 0.95rem;
    font-weight: 700;
}

.history-card {
    background: var(--surface);
    border: 3px solid var(--accent);
    border-radius: 16px;
    overflow: hidden;
    animation: slideInUp 0.6s ease;
    transition: 0.3s ease;
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.15);
    margin-bottom: 24px;
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

.empty-state {
    background: white;
    border: 3px dashed var(--accent);
    border-radius: 16px;
    padding: 60px;
    text-align: center;
    color: var(--primary);
    font-weight: 700;
    animation: fadeIn 0.6s ease;
    box-shadow: var(--shadow-sm);
}

.empty-state i {
    font-size: 3rem;
    display: block;
    margin-bottom: 16px;
    color: var(--secondary);
}

.empty-state p {
    font-size: 1.1rem !important;
    color: var(--primary) !important;
    font-weight: 800 !important;
}

.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}

.stat-card {
    background: rgba(255, 215, 0, 0.1);
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    transition: 0.3s ease;
}

.stat-card:hover {
    background: rgba(255, 215, 0, 0.2);
    border-color: var(--accent);
    transform: translateY(-2px);
}

.stat-number {
    font-size: 2rem;
    font-weight: 900;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.stat-label {
    font-size: 0.8rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
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

    .stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .stats-row {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="container-fluid p-4">

    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h2><i class="bi bi-clock-history me-2"></i>Cart History</h2>
                <p>Your complete cart activity history</p>
            </div>
            <a href="?controller=dashboard&action=shop" class="btn btn-light fw-bold px-4">
                <i class="bi bi-shop me-1"></i> Continue Shopping
            </a>
        </div>
    </div>

    <?php if (empty($cartHistory)): ?>
        <div class="empty-state">
            <i class="bi bi-cart-x"></i>
            <p style="font-size:1rem;margin:0 0 8px;">No cart history yet</p>
            <p style="font-size:0.9rem;margin:0 0 20px;opacity:0.7;">Start shopping to build your cart history.</p>
            <a href="?controller=dashboard&action=shop" class="btn btn-warning fw-bold px-4">Browse Materials</a>
        </div>
    <?php else: ?>
        
        <!-- Statistics -->
        <div class="stats-row">
            <?php 
            $totalItems = count($cartHistory);
            $totalQuantity = array_sum(array_column($cartHistory, 'quantity'));
            $totalValue = array_sum(array_map(fn($item) => $item['unit_price'] * $item['quantity'], $cartHistory));
            $uniqueMaterials = count(array_unique(array_column($cartHistory, 'material_id')));
            ?>
            <div class="stat-card">
                <div class="stat-number"><?= $totalItems ?></div>
                <div class="stat-label">Total Additions</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $totalQuantity ?></div>
                <div class="stat-label">Items Added</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $uniqueMaterials ?></div>
                <div class="stat-label">Unique Materials</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">₱<?= number_format($totalValue, 0) ?></div>
                <div class="stat-label">Total Value</div>
            </div>
        </div>

        <!-- History List -->
        <div class="history-card">
            <div class="history-header">
                <h6><i class="bi bi-list-ul me-2"></i>Complete History</h6>
                <span style="font-size: 0.8rem; color: #334443; font-weight: 700;">
                    <?= count($cartHistory) ?> item<?= count($cartHistory) !== 1 ? 's' : '' ?>
                </span>
            </div>
            <div>
                <?php foreach ($cartHistory as $item): ?>
                <div class="history-item">
                    <div class="history-item-left">
                        <div class="history-item-name">
                            <?= htmlspecialchars($item['material_name'] ?? '') ?>
                        </div>
                        <div class="history-item-meta">
                            <span>
                                <i class="bi bi-tag-fill"></i>
                                <?= htmlspecialchars($item['unit_type'] ?? '') ?>
                            </span>
                            <span>
                                <i class="bi bi-clock"></i>
                                <?= date('M d, Y H:i', strtotime($item['added_at'] ?? '')) ?>
                            </span>
                            <span>
                                <i class="bi bi-calendar3"></i>
                                <?= date('l', strtotime($item['added_at'] ?? '')) ?>
                            </span>
                        </div>
                    </div>
                    <div class="history-item-right">
                        <div class="history-item-price">
                            ₱<?= number_format($item['unit_price'] ?? 0, 2) ?>
                        </div>
                        <div class="history-item-qty">
                            Qty: <?= $item['quantity'] ?? 1 ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>