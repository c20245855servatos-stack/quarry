<?php ob_start(); ?>

<?php require __DIR__ . '/admin_style.css.php'; ?>

<style>
.stock-alert {
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 700;
}

.stock-alert.danger {
    background: rgba(239, 68, 68, 0.1);
    border: 2px solid rgba(239, 68, 68, 0.3);
    color: #dc2626;
}

.stock-alert.warning {
    background: rgba(245, 158, 11, 0.1);
    border: 2px solid rgba(245, 158, 11, 0.3);
    color: #d97706;
}

.stock-summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 14px;
    margin-bottom: 24px;
}

.stock-summary-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 16px 18px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    border: 2px solid rgba(255, 215, 0, 0.25);
    transition: 0.25s ease;
    cursor: pointer;
    user-select: none;
}

.stock-summary-card:hover {
    background: rgba(255, 215, 0, 0.08);
    border-color: #FFD700;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(255, 215, 0, 0.15);
}

.stock-summary-card.filter-active {
    border-color: #FFD700;
    background: rgba(255, 215, 0, 0.1);
    box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
}

.stock-summary-card h3 {
    font-size: 1.8rem;
    font-weight: 900;
    margin: 0 0 4px;
    color: #ffffff;
    line-height: 1;
}

.stock-summary-card p {
    margin: 0;
    color: rgba(255, 255, 255, 0.55);
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.72rem;
    letter-spacing: 0.05rem;
}

.stock-summary-card .card-icon {
    font-size: 1.3rem;
    margin-bottom: 8px;
    display: block;
}

.stock-summary-card.well-stocked h3 { color: #22c55e; }
.stock-summary-card.well-stocked .card-icon { color: #22c55e; }
.stock-summary-card.low-stock h3 { color: #f59e0b; }
.stock-summary-card.low-stock .card-icon { color: #f59e0b; }
.stock-summary-card.out-of-stock h3 { color: #ef4444; }
.stock-summary-card.out-of-stock .card-icon { color: #ef4444; }

.replenish-form {
    background: rgba(255, 215, 0, 0.05);
    border: 2px solid #FFD700;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
}

.replenish-form h4 {
    color: var(--accent);
    margin-bottom: 20px;
    font-weight: 900;
}

.form-row {
    display: grid;
    grid-template-columns: 2fr 1fr 2fr 1fr;
    gap: 16px;
    align-items: end;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 700;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 8px;
    font-size: 0.9rem;
    text-transform: uppercase;
}

.form-group select,
.form-group input {
    padding: 10px 14px;
    border: 1px solid rgba(255, 215, 0, 0.25);
    border-radius: 8px;
    font-size: 0.88rem;
    font-weight: 600;
    transition: 0.2s ease;
    background: rgba(0, 0, 0, 0.5);
    color: #ffffff;
}

.form-group select option {
    background: #1a1a1a;
    color: #ffffff;
    padding: 8px;
    font-weight: 600;
}

.form-group select:focus,
.form-group input:focus {
    outline: none;
    border-color: #FFD700;
    box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
}

.btn-replenish {
    background: linear-gradient(135deg, #FFD700, #FFB000);
    color: var(--primary);
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 900;
    cursor: pointer;
    transition: 0.3s ease;
    text-transform: uppercase;
}

.btn-replenish:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
}

.materials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.material-stock-card {
    background: rgba(255, 255, 255, 0.04);
    border-radius: 16px;
    padding: 22px 24px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    transition: 0.3s ease;
    position: relative;
    overflow: hidden;
}

.material-stock-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    border-radius: 16px 16px 0 0;
}

.material-stock-card.well-stocked::before { background: #FFD700; }
.material-stock-card.low-stock::before    { background: #f59e0b; }
.material-stock-card.out-of-stock::before { background: #ef4444; }
.material-stock-card.inactive::before     { background: #6b7280; }

.material-stock-card:hover {
    background: rgba(255, 255, 255, 0.07);
    border-color: rgba(255, 255, 255, 0.15);
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
}

.material-stock-card h5 {
    margin: 0 0 14px;
    font-weight: 800;
    font-size: 1rem;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.stock-level {
    font-size: 2rem;
    font-weight: 900;
    margin-bottom: 10px;
    line-height: 1;
}

.stock-level.well-stocked { color: #FFD700; }
.stock-level.low-stock    { color: #f59e0b; }
.stock-level.out-of-stock { color: #ef4444; }
.stock-level.inactive     { color: #9ca3af; }

.stock-level span {
    font-size: 0.9rem;
    font-weight: 700;
    color: rgba(255,255,255,0.45);
    margin-left: 4px;
}

.stock-status {
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-block;
    margin-bottom: 14px;
}

.stock-status.well-stocked {
    background: rgba(255, 215, 0, 0.12);
    color: #FFD700;
    border: 1px solid rgba(255, 215, 0, 0.25);
}

.stock-status.low-stock {
    background: rgba(245, 158, 11, 0.12);
    color: #fbbf24;
    border: 1px solid rgba(245, 158, 11, 0.25);
}

.stock-status.out-of-stock {
    background: rgba(239, 68, 68, 0.12);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.25);
}

.stock-status.inactive {
    background: rgba(107, 114, 128, 0.12);
    color: #9ca3af;
    border: 1px solid rgba(107, 114, 128, 0.25);
}

.stock-card-meta {
    font-size: 0.82rem;
    color: rgba(255, 255, 255, 0.45);
    font-weight: 600;
    border-top: 1px solid rgba(255, 255, 255, 0.07);
    padding-top: 12px;
    margin-top: 4px;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .stock-summary-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .materials-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 575px) {
    .stock-summary-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .stock-summary-card {
        padding: 12px 14px;
    }

    .stock-summary-card h3 {
        font-size: 1.5rem;
    }

    .replenish-form {
        padding: 16px;
    }
}
</style>

<div class="adm-wrap">

    <!-- HEADER -->
    <div class="adm-header">
        <div>
            <h1 class="adm-title"><i class="bi bi-boxes"></i> Stock Management</h1>
            <p class="adm-sub">Monitor and manage inventory levels across all materials.</p>
        </div>
        <div class="adm-header-actions">
            <button onclick="refreshStockAlerts()" class="adm-btn adm-btn-blue">
                <i class="bi bi-arrow-clockwise"></i> Refresh Alerts
            </button>
        </div>
    </div>

    <!-- STOCK ALERTS -->
    <?php if (!empty($stockAlerts)): ?>
    <div class="adm-card" style="margin-bottom: 30px;">
        <div class="adm-card-head">
            <span><i class="bi bi-exclamation-triangle-fill me-2"></i>Stock Alerts (<?= count($stockAlerts) ?>)</span>
        </div>
        <div style="padding: 20px;">
            <?php foreach ($stockAlerts as $alert): ?>
            <div class="stock-alert <?= $alert['type'] ?>">
                <i class="bi bi-<?= $alert['icon'] ?>" style="font-size: 1.2rem;"></i>
                <div>
                    <strong><?= $alert['title'] ?>:</strong> <?= htmlspecialchars($alert['message']) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- STOCK SUMMARY -->
    <div class="stock-summary-grid">
        <div class="stock-summary-card filter-active" id="scard-all" onclick="filterStockCards('all', this)">
            <i class="bi bi-box-seam-fill card-icon"></i>
            <h3><?= $stockSummary['total_materials'] ?? 0 ?></h3>
            <p>Total Materials</p>
        </div>
        <div class="stock-summary-card well-stocked" id="scard-well" onclick="filterStockCards('well-stocked', this)">
            <i class="bi bi-check-circle-fill card-icon"></i>
            <h3><?= $stockSummary['well_stocked'] ?? 0 ?></h3>
            <p>Well Stocked</p>
        </div>
        <div class="stock-summary-card low-stock" id="scard-low" onclick="filterStockCards('low-stock', this)">
            <i class="bi bi-exclamation-triangle-fill card-icon"></i>
            <h3><?= $stockSummary['low_stock'] ?? 0 ?></h3>
            <p>Low Stock</p>
        </div>
        <div class="stock-summary-card out-of-stock" id="scard-out" onclick="filterStockCards('out-of-stock', this)">
            <i class="bi bi-x-circle-fill card-icon"></i>
            <h3><?= $stockSummary['out_of_stock'] ?? 0 ?></h3>
            <p>Out of Stock</p>
        </div>
        <div class="stock-summary-card" id="scard-inactive" onclick="filterStockCards('inactive', this)" style="border-color:rgba(107,114,128,0.4);">
            <i class="bi bi-archive-fill card-icon" style="color:#9ca3af;"></i>
            <h3 style="color:#9ca3af;"><?= $stockSummary['inactive'] ?? 0 ?></h3>
            <p>Inactive</p>
        </div>
    </div>

    <!-- STOCK REPLENISHMENT FORM -->
    <div class="replenish-form">
        <h4><i class="bi bi-plus-circle-fill me-2"></i>Replenish Stock</h4>
        <form method="POST" action="?controller=admin&action=replenishStock">
            <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="material_id">Material</label>
                    <select name="material_id" id="material_id" required>
                        <option value="">Select Material</option>
                        <?php foreach ($allMaterials as $material): ?>
                        <option value="<?= $material['material_id'] ?>">
                            <?= htmlspecialchars($material['material_name']) ?> — <?= number_format($material['stock_quantity']) ?> units
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" min="1" max="999" maxlength="3" required placeholder="1–999"
                           oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,3); if(parseInt(this.value)>999)this.value=999;">
                </div>
                <div class="form-group">
                    <label for="reason">Reason (Optional)</label>
                    <input type="text" name="reason" id="reason" placeholder="e.g., New shipment, Restock">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-replenish">
                        <i class="bi bi-plus-lg me-1"></i>Add Stock
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- MATERIALS STOCK STATUS -->
    <div class="adm-card">
        <div class="adm-card-head">
            <span><i class="bi bi-grid-3x3-gap-fill me-2"></i>All Materials Stock Status <span id="stockFilterLabel" style="font-size:0.8rem; color:var(--text-secondary); font-weight:600;"></span></span>
        </div>
        <div style="padding: 20px;">
            <div class="materials-grid">
                <?php foreach ($allMaterials as $material): ?>
                <?php 
                $stock = (int)($material['stock_quantity'] ?? 0);
                $isActive = (bool)($material['is_active'] ?? true);
                $maxStock = 600;
                $canAdd = max(0, $maxStock - $stock);
                if (!$isActive) {
                    $stockClass = 'inactive';
                    $statusText = 'Inactive';
                } elseif ($stock <= 0) {
                    $stockClass = 'out-of-stock';
                    $statusText = 'Out of Stock';
                } elseif ($stock < 50) {
                    $stockClass = 'low-stock';
                    $statusText = 'Low Stock';
                } else {
                    $stockClass = 'well-stocked';
                    $statusText = 'Well Stocked';
                }
                ?>
                <div class="material-stock-card <?= $stockClass ?>" data-stock="<?= $stockClass ?>">
                    <h5><?= htmlspecialchars($material['material_name']) ?></h5>
                    <div class="stock-level <?= $stockClass ?>"><?= number_format($stock) ?><span>/ <?= $maxStock ?> units</span></div>
                    <div class="stock-status <?= $stockClass ?>"><?= $statusText ?></div>
                    <div class="stock-card-meta">
                        ₱<?= number_format($material['unit_price'] ?? 0, 2) ?> &nbsp;·&nbsp; <?= htmlspecialchars($material['unit_type'] ?? '') ?>
                    </div>
                    <?php if ($isActive && $stock < $maxStock): ?>
                    <button onclick="openQuickReplenish(<?= $material['material_id'] ?>, '<?= htmlspecialchars(addslashes($material['material_name']), ENT_QUOTES) ?>', <?= $canAdd ?>)"
                            class="btn-replenish" style="margin-top: 14px; padding: 8px 16px; font-size: 0.8rem; width:100%;">
                        <i class="bi bi-plus-lg me-1"></i>Quick Replenish <?= $stock < 50 ? '(can add up to '.$canAdd.')' : '' ?>
                    </button>
                    <?php elseif ($isActive && $stock >= $maxStock): ?>
                    <div style="margin-top:14px; padding:8px; background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:6px; font-size:0.78rem; font-weight:700; color:#4ade80; text-align:center;">
                        <i class="bi bi-check-circle-fill me-1"></i> At Maximum Stock
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

<!-- Quick Replenish Modal -->
<div class="sys-modal-overlay" id="quickReplenishModal">
  <div class="sys-modal" style="max-width:460px; text-align:left; padding:28px;">
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:18px;">
      <div class="sys-modal-icon yellow" style="width:48px;height:48px;font-size:1.3rem;margin:0;flex-shrink:0;">
        <i class="bi bi-plus-circle-fill"></i>
      </div>
      <div>
        <div class="sys-modal-title" style="text-align:left; margin:0 0 3px;">Quick Replenish</div>
        <div style="font-size:0.82rem; color:rgba(255,255,255,0.5); font-weight:600;" id="qrMaterialName"></div>
      </div>
    </div>
    <div style="margin-bottom:14px;">
      <label style="display:block; font-size:0.75rem; font-weight:800; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.8px; margin-bottom:6px;">Quantity to Add</label>
      <input type="number" id="qrQuantity" min="1" max="999" value="50"
             style="width:100%; padding:10px 13px; background:rgba(0,0,0,0.35); border:1px solid rgba(255,215,0,0.3); border-radius:7px; color:#fff; font-size:0.95rem; font-weight:700; outline:none;"
             onfocus="this.style.borderColor='#FFD700'" onblur="this.style.borderColor='rgba(255,215,0,0.3)'"
             oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,3); if(parseInt(this.value)>999)this.value=999;">
    </div>
    <div style="margin-bottom:22px;">
      <label style="display:block; font-size:0.75rem; font-weight:800; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.8px; margin-bottom:6px;">Reason <span style="opacity:0.5;">(optional)</span></label>
      <input type="text" id="qrReason" placeholder="e.g. New shipment, Restock"
             style="width:100%; padding:10px 13px; background:rgba(0,0,0,0.35); border:1px solid rgba(255,255,255,0.12); border-radius:7px; color:#fff; font-size:0.88rem; font-weight:600; outline:none;"
             onfocus="this.style.borderColor='#FFD700'" onblur="this.style.borderColor='rgba(255,255,255,0.12)'">
    </div>
    <div class="sys-modal-btns">
      <button class="sys-btn-cancel" onclick="closeQuickReplenish()">Cancel</button>
      <button class="sys-btn-yellow" onclick="submitQuickReplenish()">
        <i class="bi bi-plus-lg"></i> Add Stock
      </button>
    </div>
  </div>
</div>

<script>
function refreshStockAlerts() {
    fetch('?controller=admin&action=getStockAlerts')
        .then(r => r.json())
        .then(data => { if (data.success) location.reload(); })
        .catch(() => {});
}

let _qrMaterialId = null;
let _qrMaxAdd = 999;

function openQuickReplenish(materialId, materialName, canAdd) {
    _qrMaterialId = materialId;
    _qrMaxAdd = Math.min(canAdd ?? 999, 999);
    document.getElementById('qrMaterialName').textContent = materialName;
    const defaultQty = Math.min(50, _qrMaxAdd);
    document.getElementById('qrQuantity').value = defaultQty;
    document.getElementById('qrQuantity').max = _qrMaxAdd;
    document.getElementById('qrReason').value = '';
    document.getElementById('quickReplenishModal').classList.add('open');
    setTimeout(() => document.getElementById('qrQuantity').focus(), 150);
}

function closeQuickReplenish() {
    document.getElementById('quickReplenishModal').classList.remove('open');
    _qrMaterialId = null;
}

function submitQuickReplenish() {
    const qty = parseInt(document.getElementById('qrQuantity').value);
    if (!qty || qty < 1) { document.getElementById('qrQuantity').focus(); return; }
    if (qty > _qrMaxAdd) {
        document.getElementById('qrQuantity').value = _qrMaxAdd;
        document.getElementById('qrQuantity').style.borderColor = '#ef4444';
        return;
    }
    const reason = document.getElementById('qrReason').value.trim();
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '?controller=admin&action=replenishStock';
    [['material_id', _qrMaterialId], ['quantity', qty],
     ['reason', reason || 'Quick replenishment'], ['_csrf', '<?= Csrf::generate() ?>']
    ].forEach(([n, v]) => {
        const i = document.createElement('input');
        i.type = 'hidden'; i.name = n; i.value = v;
        form.appendChild(i);
    });
    document.body.appendChild(form);
    form.submit();
}

document.getElementById('quickReplenishModal').addEventListener('click', function(e) {
    if (e.target === this) closeQuickReplenish();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeQuickReplenish();
    if (e.key === 'Enter' && document.getElementById('quickReplenishModal').classList.contains('open')) {
        submitQuickReplenish();
    }
});

setInterval(refreshStockAlerts, 5 * 60 * 1000);

function filterStockCards(filter, clickedEl) {
    document.querySelectorAll('.stock-summary-card').forEach(c => c.classList.remove('filter-active'));
    clickedEl.classList.add('filter-active');
    const labels = {
        'all': '', 'well-stocked': '— Well Stocked',
        'low-stock': '— Low Stock', 'out-of-stock': '— Out of Stock', 'inactive': '— Inactive'
    };
    const labelEl = document.getElementById('stockFilterLabel');
    if (labelEl) labelEl.textContent = labels[filter] || '';
    document.querySelectorAll('.material-stock-card').forEach(card => {
        card.style.display = (filter === 'all' || card.dataset.stock === filter) ? '' : 'none';
    });
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>