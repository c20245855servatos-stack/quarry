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
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stock-summary-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    padding: 24px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    border: 2px solid rgba(255, 215, 0, 0.4);
    transition: 0.3s ease;
}

.stock-summary-card:hover {
    background: rgba(255, 215, 0, 0.08);
    border-color: #FFD700;
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.2);
}

.stock-summary-card h3 {
    font-size: 2.5rem;
    font-weight: 900;
    margin: 0 0 8px;
    color: #ffffff;
}

.stock-summary-card p {
    margin: 0;
    color: rgba(255, 255, 255, 0.6);
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.05rem;
}

.stock-summary-card .card-icon {
    font-size: 1.8rem;
    margin-bottom: 12px;
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
    padding: 12px 16px;
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 600;
    transition: 0.3s ease;
    background: rgba(0, 0, 0, 0.4);
    color: #ffffff;
}

.form-group select option {
    background: #1a1a1a;
    color: #ffffff;
    padding: 10px;
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
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.material-stock-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-left: 6px solid #e5e7eb;
}

.material-stock-card.well-stocked {
    border-left-color: #22c55e;
}

.material-stock-card.low-stock {
    border-left-color: #f59e0b;
}

.material-stock-card.out-of-stock {
    border-left-color: #ef4444;
}

.material-stock-card h5 {
    margin: 0 0 12px;
    font-weight: 900;
    color: var(--primary);
}

.stock-level {
    font-size: 1.5rem;
    font-weight: 900;
    margin-bottom: 8px;
}

.stock-level.well-stocked { color: #22c55e; }
.stock-level.low-stock { color: #f59e0b; }
.stock-level.out-of-stock { color: #ef4444; }

.stock-status {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    padding: 4px 8px;
    border-radius: 6px;
    display: inline-block;
}

.stock-status.well-stocked {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.stock-status.low-stock {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.stock-status.out-of-stock {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
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
        gap: 12px;
    }

    .stock-summary-card {
        padding: 16px;
    }

    .stock-summary-card h3 {
        font-size: 2rem;
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
        <div class="stock-summary-card">
            <i class="bi bi-box-seam-fill card-icon"></i>
            <h3><?= $stockSummary['total_materials'] ?? 0 ?></h3>
            <p>Total Materials</p>
        </div>
        <div class="stock-summary-card well-stocked">
            <i class="bi bi-check-circle-fill card-icon"></i>
            <h3><?= $stockSummary['well_stocked'] ?? 0 ?></h3>
            <p>Well Stocked</p>
        </div>
        <div class="stock-summary-card low-stock">
            <i class="bi bi-exclamation-triangle-fill card-icon"></i>
            <h3><?= $stockSummary['low_stock'] ?? 0 ?></h3>
            <p>Low Stock</p>
        </div>
        <div class="stock-summary-card out-of-stock">
            <i class="bi bi-x-circle-fill card-icon"></i>
            <h3><?= $stockSummary['out_of_stock'] ?? 0 ?></h3>
            <p>Out of Stock</p>
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
                            <?= htmlspecialchars($material['material_name']) ?> 
                            (Current: <?= $material['stock_quantity'] ?> units)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" min="1" required placeholder="Enter quantity">
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
            <span><i class="bi bi-grid-3x3-gap-fill me-2"></i>All Materials Stock Status</span>
        </div>
        <div style="padding: 20px;">
            <div class="materials-grid">
                <?php foreach ($allMaterials as $material): ?>
                <?php 
                $stock = (int)($material['stock_quantity'] ?? 0);
                $stockClass = $stock <= 0 ? 'out-of-stock' : ($stock <= 10 ? 'low-stock' : 'well-stocked');
                $statusText = $stock <= 0 ? 'Out of Stock' : ($stock <= 10 ? 'Low Stock' : 'Well Stocked');
                ?>
                <div class="material-stock-card <?= $stockClass ?>">
                    <h5><?= htmlspecialchars($material['material_name']) ?></h5>
                    <div class="stock-level <?= $stockClass ?>"><?= $stock ?> units</div>
                    <div class="stock-status <?= $stockClass ?>"><?= $statusText ?></div>
                    <div style="margin-top: 12px; font-size: 0.9rem; color: var(--text-secondary);">
                        <strong>Price:</strong> ₱<?= number_format($material['unit_price'] ?? 0, 2) ?> <?= htmlspecialchars($material['unit_type'] ?? '') ?>
                    </div>
                    <?php if ($stock <= 10): ?>
                    <button onclick="quickReplenish(<?= $material['material_id'] ?>, '<?= htmlspecialchars($material['material_name']) ?>')" 
                            class="btn-replenish" style="margin-top: 12px; padding: 8px 16px; font-size: 0.8rem;">
                        <i class="bi bi-plus-lg me-1"></i>Quick Replenish
                    </button>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>

<script>
function refreshStockAlerts() {
    fetch('?controller=admin&action=getStockAlerts')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Simple refresh for now
            } else {
                alert('Failed to refresh alerts: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to refresh alerts');
        });
}

function quickReplenish(materialId, materialName) {
    const quantity = prompt(`How many units would you like to add to "${materialName}"?`, '50');
    
    if (quantity && parseInt(quantity) > 0) {
        const reason = prompt('Reason for replenishment (optional):', 'Quick replenishment');
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '?controller=admin&action=replenishStock';
        
        const materialIdInput = document.createElement('input');
        materialIdInput.type = 'hidden';
        materialIdInput.name = 'material_id';
        materialIdInput.value = materialId;
        
        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantity';
        quantityInput.value = quantity;
        
        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'reason';
        reasonInput.value = reason || '';
        
        form.appendChild(materialIdInput);
        form.appendChild(quantityInput);
        form.appendChild(reasonInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Auto-refresh alerts every 5 minutes
setInterval(refreshStockAlerts, 5 * 60 * 1000);
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>