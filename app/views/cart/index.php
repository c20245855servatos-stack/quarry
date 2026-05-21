<?php ob_start(); ?>

<style>
/* ========================
   MODERN CONSTRUCTION THEME - CART PAGE
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

body {
    background: var(--background);
    color: var(--text-primary);
    min-height: 100vh;
}

.page-header {
    background: var(--surface-alt);
    border-radius: 16px;
    padding: 28px 32px;
    margin-bottom: 28px;
    box-shadow: var(--shadow-md);
    animation: slideInUp 0.6s ease;
}

.page-header h2 {
    color: var(--text-light);
    margin: 0 0 8px;
    font-weight: 900;
    font-size: 1.8rem;
}

.page-header p {
    color: var(--text-secondary);
    margin: 0;
    font-size: 0.95rem;
    font-weight: 700;
}

.cart-items-container {
    background: white;
    border: 3px solid var(--accent);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 24px;
    animation: slideInUp 0.6s ease 0.1s both;
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.15);
}

/* Remove number input spinners so text stays centered */
#editQtyInput::-webkit-outer-spin-button,
#editQtyInput::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.cart-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid var(--accent);
    gap: 16px;
    transition: 0.2s ease;
    animation: fadeIn 0.4s ease both;
}

.cart-item:nth-child(1) { animation-delay: 0.1s; }
.cart-item:nth-child(2) { animation-delay: 0.15s; }
.cart-item:nth-child(3) { animation-delay: 0.2s; }
.cart-item:nth-child(4) { animation-delay: 0.25s; }
.cart-item:nth-child(5) { animation-delay: 0.3s; }

.cart-item:last-child {
    border-bottom: none;
}

.cart-item:hover {
    background: rgba(255, 215, 0, 0.1);
}

.cart-item-icon {
    width: 48px;
    height: 48px;
    background: var(--accent);
    border: 2px solid var(--primary);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: var(--primary);
    flex-shrink: 0;
}

.cart-item-details {
    flex: 1;
    min-width: 0;
}

.cart-item-name {
    font-weight: 900;
    color: var(--primary);
    font-size: 1rem;
    margin-bottom: 4px;
}

.cart-item-unit {
    color: var(--secondary);
    font-size: 0.8rem;
    font-weight: 700;
    opacity: 0.7;
}

.cart-item-qty {
    background: var(--accent);
    border: 2px solid var(--primary);
    color: var(--primary);
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 800;
    white-space: nowrap;
}

.cart-item-price {
    font-size: 1.1rem;
    font-weight: 900;
    color: var(--primary);
    white-space: nowrap;
}

.cart-item-remove {
    background: rgba(239, 68, 68, 0.15);
    border: 2px solid rgba(239, 68, 68, 0.3);
    color: #dc2626;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 700;
}

.cart-item-remove:hover {
    background: rgba(239, 68, 68, 0.25);
    border-color: rgba(239, 68, 68, 0.5);
    color: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
}

.cart-item-edit {
    background: rgba(255, 215, 0, 0.15);
    border: 2px solid rgba(255, 215, 0, 0.5);
    color: var(--primary);
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-weight: 700;
}

.cart-item-edit:hover {
    background: var(--accent);
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
}

.cart-summary {
    background: white;
    border: 3px solid var(--accent);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
    animation: slideInUp 0.6s ease 0.2s both;
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.15);
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 0.95rem;
    color: var(--primary);
    font-weight: 700;
}

.summary-divider {
    border-top: 2px solid var(--accent);
    padding-top: 16px;
    margin-top: 8px;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 1.3rem;
    font-weight: 900;
    color: var(--primary);
}

.summary-total-amount {
    color: var(--primary);
    font-size: 1.5rem;
}

.checkout-button-container {
    background: var(--surface-alt);
    border: 2px solid var(--accent);
    border-radius: 16px;
    padding: 24px;
    text-align: center;
    animation: slideInUp 0.6s ease 0.3s both;
}

.btn-checkout {
    background: var(--accent);
    color: var(--primary);
    border: none;
    padding: 16px 48px;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 900;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 8px 24px rgba(255, 215, 0, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-checkout::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.3);
    transition: 0.5s;
}

.btn-checkout:hover::before {
    left: 100%;
}

.btn-checkout:hover {
    background: var(--hover-secondary);
    color: var(--primary);
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 16px 40px rgba(255, 215, 0, 0.5);
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
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.15);
}

.empty-state i {
    font-size: 3rem;
    display: block;
    margin-bottom: 16px;
    color: var(--secondary);
}

/* ========================
   DELIVERY DATE SECTION
======================== */
.delivery-date-container {
    background: white;
    border: 3px solid var(--accent);
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
    animation: slideInUp 0.6s ease 0.25s both;
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.15);
}

.delivery-date-header {
    display: flex;
    align-items: center;
    margin-bottom: 16px;
    font-size: 1.1rem;
    font-weight: 900;
    color: var(--primary);
}

.delivery-date-field {
    margin-bottom: 16px;
}

.delivery-date-field label {
    display: block;
    margin-bottom: 8px;
    font-weight: 700;
    color: var(--primary);
    font-size: 0.9rem;
}

.delivery-date-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid var(--accent);
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--primary);
    background: rgba(255, 215, 0, 0.1);
    transition: 0.3s ease;
}

.delivery-date-input:focus {
    outline: none;
    border-color: var(--primary);
    background: rgba(255, 215, 0, 0.2);
    box-shadow: 0 0 0 4px var(--focus-ring);
}

.delivery-date-note {
    display: block;
    margin-top: 6px;
    font-size: 0.8rem;
    color: var(--secondary);
    font-weight: 600;
}

.delivery-date-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.btn-save-date {
    background: var(--accent);
    color: var(--primary);
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-save-date:hover {
    background: var(--hover-secondary);
    transform: translateY(-2px);
}

.btn-clear-date {
    background: transparent;
    color: var(--secondary);
    border: 2px solid var(--secondary);
    padding: 8px 18px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-clear-date:hover {
    background: var(--secondary);
    color: white;
    transform: translateY(-2px);
}

.truck-date-btn {
    background: white;
    color: var(--primary);
    border: 2px solid var(--accent);
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 800;
    font-size: 0.9rem;
    cursor: pointer;
    transition: 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.truck-date-btn:hover {
    background: rgba(255, 215, 0, 0.2);
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
}

.truck-date-btn.selected {
    background: var(--primary);
    color: var(--accent);
    border-color: var(--primary);
}

.truck-date-btn.selected:hover {
    background: #333;
    border-color: #333;
    transform: translateY(-2px);
}

.delivery-date-selected {
    background: rgba(255, 215, 0, 0.2);
    border: 2px solid var(--accent);
    border-radius: 10px;
    padding: 12px 16px;
    margin-top: 12px;
    display: flex;
    align-items: center;
    color: var(--primary);
    font-weight: 700;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .cart-item {
        flex-wrap: wrap;
        gap: 12px;
    }

    .cart-item-details {
        flex: 1 1 100%;
        order: 1;
    }

    .cart-item-icon {
        order: 0;
    }

    .cart-item-qty {
        order: 2;
    }

    .cart-item-price {
        order: 3;
    }

    .cart-item-remove {
        order: 4;
        width: 100%;
        justify-content: center;
    }

    .page-header {
        padding: 20px 24px;
    }

    .page-header h2 {
        font-size: 1.5rem;
    }
}

@media (max-width: 575px) {
    .page-header {
        padding: 16px;
        border-radius: 12px;
    }

    .page-header h2 {
        font-size: 1.3rem;
    }

    .cart-item {
        padding: 14px 16px;
    }

    .cart-summary {
        padding: 16px;
    }

    .summary-total {
        font-size: 1.1rem;
    }

    .summary-total-amount {
        font-size: 1.2rem;
    }

    .checkout-button-container {
        padding: 16px;
    }

    .btn-checkout {
        padding: 14px 24px;
        font-size: 1rem;
        width: 100%;
        justify-content: center;
    }

    .empty-state {
        padding: 36px 16px;
    }

    .delivery-date-container {
        padding: 16px;
    }
}
</style>

<div class="container-fluid p-4">

    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h2><i class="bi bi-cart3 me-2"></i>My Cart</h2>
                <p><?= count($cart) ?> item<?= count($cart) !== 1 ? 's' : '' ?> in your cart</p>
            </div>
            <a href="?controller=dashboard&action=shop" class="btn btn-light fw-bold px-4">
                <i class="bi bi-arrow-left me-1"></i> Continue Shopping
            </a>
        </div>
    </div>

    <?php if (empty($cart)): ?>
        <div class="empty-state">
            <i class="bi bi-cart-x"></i>
            <p style="font-size:1rem;margin:0 0 8px;">Your cart is empty</p>
            <p style="font-size:0.9rem;margin:0 0 20px;opacity:0.7;">Add some materials to get started.</p>
            <a href="?controller=dashboard&action=shop" class="btn btn-warning fw-bold px-4">Browse Materials</a>
        </div>
    <?php else: ?>

    <div class="cart-items-container">
        <?php $subtotal = 0; ?>
        <?php foreach ($cart as $i => $item): ?>
            <?php $itemTotal = (float)($item['price'] ?? 0) * (int)($item['qty'] ?? 1); $subtotal += $itemTotal; ?>
            <div class="cart-item">
                <div class="cart-item-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="cart-item-details">
                    <div class="cart-item-name"><?= htmlspecialchars($item['name'] ?? $item['material_name'] ?? '') ?></div>
                    <div class="cart-item-unit"><?= htmlspecialchars($item['unit'] ?? $item['unit_type'] ?? '') ?></div>
                </div>
                <div class="cart-item-qty">Qty: <?= (int)($item['qty'] ?? 1) ?></div>
                <div class="cart-item-price">₱<?= number_format($itemTotal, 2) ?></div>
                <button class="cart-item-edit"
                        onclick="openEditQty(<?= (int)($item['id'] ?? $item['material_id'] ?? 0) ?>, '<?= htmlspecialchars($item['name'] ?? $item['material_name'] ?? '', ENT_QUOTES) ?>', <?= (int)($item['qty'] ?? 1) ?>, <?= (float)($item['price'] ?? 0) ?>)">
                    <i class="bi bi-pencil-fill"></i>
                    Edit
                </button>
                <form method="POST" action="?controller=cart&action=remove" style="margin:0;"
                      onsubmit="return confirm('Remove this item from cart?')">
                    <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">
                    <input type="hidden" name="id" value="<?= (int)($item['id'] ?? $item['material_id'] ?? 0) ?>">
                    <button type="submit" class="cart-item-remove">
                        <i class="bi bi-trash"></i>
                        Remove
                    </button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <?php 
    $vat = $subtotal * 0.12;
    $total = $subtotal + $vat;
    ?>

    <div class="cart-summary">
        <div class="summary-row">
            <span>Subtotal:</span>
            <span>₱<?= number_format($subtotal, 2) ?></span>
        </div>
        <div class="summary-row">
            <span>VAT (12%):</span>
            <span>₱<?= number_format($vat, 2) ?></span>
        </div>
        <div class="summary-divider">
            <div class="summary-total">
                <span>Total Amount:</span>
                <span class="summary-total-amount">₱<?= number_format($total, 2) ?></span>
            </div>
        </div>
    </div>

    <div class="checkout-button-container">
        <a href="?controller=cart&action=checkout" class="btn-checkout">
            Proceed to Checkout
            <i class="bi bi-arrow-right-circle-fill"></i>
        </a>
    </div>

    <?php endif; ?>

</div>

<script>
// Cart JS
</script>

<!-- EDIT QUANTITY MODAL -->
<div id="editQtyModal" style="
    position: fixed; top:0; left:0; width:100%; height:100%;
    background: rgba(0,0,0,0.7); display:none; align-items:center;
    justify-content:center; z-index:9999; backdrop-filter:blur(4px);">
  <div style="background:#2d2d2d; border:3px solid #FFD700; border-radius:20px; padding:32px; max-width:420px; width:90%; position:relative;">
    <button onclick="closeEditQty()" style="position:absolute;top:12px;right:16px;background:none;border:none;color:#fff;font-size:1.4rem;cursor:pointer;">×</button>
    <h4 style="color:#FFD700; margin:0 0 6px; font-weight:900;"><i class="bi bi-pencil-fill me-2"></i>Edit Quantity</h4>
    <p id="editItemName" style="color:#ccc; font-size:0.9rem; margin:0 0 24px;"></p>

    <div style="display:flex; align-items:center; justify-content:center; gap:16px; margin-bottom:20px;">
      <button onclick="editDecrease()" style="background:#FFD700;border:none;color:#1a1a1a;width:44px;height:44px;border-radius:50%;font-size:1.3rem;font-weight:900;cursor:pointer;">−</button>
      <input type="number" id="editQtyInput" min="1" step="1" value="1"
             style="background:rgba(255,255,255,0.1);border:2px solid #FFD700;color:#fff;font-size:1.6rem;font-weight:900;text-align:center;width:90px;height:50px;border-radius:10px;outline:none;-webkit-appearance:none;-moz-appearance:textfield;appearance:textfield;"
             oninput="updateEditTotal()">
      <button onclick="editIncrease()" style="background:#FFD700;border:none;color:#1a1a1a;width:44px;height:44px;border-radius:50%;font-size:1.3rem;font-weight:900;cursor:pointer;">+</button>
    </div>

    <div style="background:rgba(255,215,0,0.1);border:2px solid #FFD700;border-radius:10px;padding:12px;text-align:center;margin-bottom:20px;">
      <div style="color:#aaa;font-size:0.8rem;margin-bottom:4px;">Total</div>
      <div id="editTotal" style="color:#FFD700;font-size:1.6rem;font-weight:900;"></div>
    </div>

    <div id="editStockWarn" style="display:none;color:#ef4444;font-size:0.82rem;font-weight:700;text-align:center;margin-bottom:12px;">
      <i class="bi bi-exclamation-triangle-fill me-1"></i>Maximum available stock reached
    </div>

    <div style="display:flex;gap:10px;">
      <button onclick="closeEditQty()" style="flex:1;background:transparent;border:2px solid #666;color:#ccc;padding:12px;border-radius:8px;font-weight:700;cursor:pointer;">Cancel</button>
      <button onclick="saveEditQty()" style="flex:2;background:linear-gradient(135deg,#FFD700,#FFB000);border:none;color:#1a1a1a;padding:12px;border-radius:8px;font-weight:900;cursor:pointer;">
        <i class="bi bi-check-circle-fill me-2"></i>Save Changes
      </button>
    </div>
  </div>
</div>

<script>
let editMaterialId = 0;
let editUnitPrice  = 0;
let editMaxStock   = 999;

// Fetch stock for a material via a quick AJAX call
function openEditQty(materialId, name, currentQty, unitPrice) {
    editMaterialId = materialId;
    editUnitPrice  = unitPrice;

    document.getElementById('editItemName').textContent = name;
    document.getElementById('editQtyInput').value = currentQty;
    document.getElementById('editStockWarn').style.display = 'none';

    // Fetch current stock from server
    fetch(`?controller=cart&action=getStock&id=${materialId}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        editMaxStock = data.stock || 999;
        document.getElementById('editQtyInput').max = editMaxStock;
        updateEditTotal();
    })
    .catch(() => {
        editMaxStock = 999;
        updateEditTotal();
    });

    document.getElementById('editQtyModal').style.display = 'flex';
}

function closeEditQty() {
    document.getElementById('editQtyModal').style.display = 'none';
}

function editDecrease() {
    const input = document.getElementById('editQtyInput');
    const val = parseInt(input.value) || 1;
    if (val > 1) { input.value = val - 1; updateEditTotal(); }
    document.getElementById('editStockWarn').style.display = 'none';
}

function editIncrease() {
    const input = document.getElementById('editQtyInput');
    const val = parseInt(input.value) || 1;
    if (val < editMaxStock) { input.value = val + 1; updateEditTotal(); }
    else {
        document.getElementById('editStockWarn').style.display = 'block';
    }
}

function updateEditTotal() {
    const input = document.getElementById('editQtyInput');
    let raw = input.value.replace(/[^0-9]/g, '');
    let qty = parseInt(raw) || 1;
    if (qty < 1) qty = 1;
    if (qty > editMaxStock) {
        qty = editMaxStock;
        document.getElementById('editStockWarn').style.display = 'block';
    } else {
        document.getElementById('editStockWarn').style.display = 'none';
    }
    input.value = qty;
    const total = qty * editUnitPrice;
    document.getElementById('editTotal').textContent = '₱' + total.toLocaleString('en-US', { minimumFractionDigits:2, maximumFractionDigits:2 });
}

function saveEditQty() {
    const qty = parseInt(document.getElementById('editQtyInput').value) || 1;
    // Use a hidden form to POST — prevents URL manipulation
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '?controller=cart&action=updateQty';
    const idInput = document.createElement('input');
    idInput.type = 'hidden'; idInput.name = 'id'; idInput.value = editMaterialId;
    const qtyInput = document.createElement('input');
    qtyInput.type = 'hidden'; qtyInput.name = 'qty'; qtyInput.value = qty;
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden'; csrfInput.name = '_csrf'; csrfInput.value = '<?= Csrf::generate() ?>';
    form.appendChild(idInput);
    form.appendChild(qtyInput);
    form.appendChild(csrfInput);
    document.body.appendChild(form);
    form.submit();
}

// Close on backdrop click
document.getElementById('editQtyModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditQty();
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
