<?php ob_start(); ?>

<style>
/* ========================
   CHECKOUT PAGE - CONSTRUCTION THEME
======================== */

/* Core Variables */
:root {
  --primary: #1a1a1a;         /* Deep black */
  --secondary: #2d2d2d;       /* Dark gray */
  --background: #1a1a1a;      /* Black background */
  --accent: #FFD700;          /* Gold/Yellow */
  --text-primary: #ffffff;
  --text-secondary: rgba(255, 255, 255, 0.7);
  --surface: #000000;
  --surface-alt: #2d2d2d;
  --border: #333333;
  --shadow-sm: 0 4px 15px rgba(0, 0, 0, 0.6);
  --shadow-md: 0 8px 25px rgba(0, 0, 0, 0.7);
  --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.8);
}

/* Animations */
@keyframes slideInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}

@keyframes shimmer {
    0% { background-position: -200px 0; }
    100% { background-position: calc(200px + 100%) 0; }
}

/* Page Container */
.checkout-container {
    padding: 24px;
    background: var(--background);
    color: var(--text-primary);
    min-height: calc(100vh - 60px);
}

/* Page Header */
.checkout-header {
    background: linear-gradient(135deg, rgba(255, 215, 0, 0.2), rgba(255, 215, 0, 0.1));
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 16px;
    padding: 32px;
    margin-bottom: 32px;
    box-shadow: var(--shadow-md);
    animation: slideInUp 0.6s ease;
    text-align: center;
}

.checkout-title {
    color: var(--accent);
    margin: 0 0 12px;
    font-weight: 900;
    font-size: 2.2rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.checkout-subtitle {
    color: var(--text-secondary);
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.5;
}

/* Main Grid Layout */
.checkout-grid {
    display: grid;
    grid-template-columns: 1fr 450px;
    gap: 32px;
    align-items: start;
}

/* Order Summary Card */
.order-summary-card {
    background: rgba(255, 255, 255, 0.03);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-md);
    animation: slideInUp 0.6s ease 0.1s both;
}

.summary-header {
    background: linear-gradient(135deg, rgba(255, 215, 0, 0.2), rgba(255, 215, 0, 0.1));
    padding: 24px 28px;
    border-bottom: 2px solid rgba(255, 215, 0, 0.3);
    font-weight: 900;
    font-size: 1.2rem;
    color: var(--accent);
    display: flex;
    align-items: center;
    gap: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.summary-content {
    padding: 0;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 28px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
    animation: fadeIn 0.4s ease both;
}

.summary-item:hover {
    background: rgba(255, 255, 255, 0.05);
    transform: translateX(4px);
}

.summary-item-details {
    flex: 1;
}

.summary-item-name {
    font-weight: 900;
    color: var(--text-primary);
    margin-bottom: 6px;
    font-size: 1rem;
}

.summary-item-meta {
    color: var(--text-secondary);
    font-size: 0.85rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
}

.summary-item-price {
    font-weight: 900;
    color: var(--accent);
    font-size: 1.1rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

/* Summary Totals */
.summary-totals {
    padding: 28px;
    background: rgba(0, 0, 0, 0.3);
    border-top: 2px solid rgba(255, 215, 0, 0.2);
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 16px;
    font-size: 1rem;
    color: var(--text-primary);
    font-weight: 700;
}

.summary-divider {
    border-top: 2px solid var(--accent);
    padding-top: 20px;
    margin-top: 12px;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 1.3rem;
    font-weight: 900;
    color: var(--text-primary);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.summary-total-amount {
    color: var(--accent);
    font-size: 1.6rem;
    text-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
}

/* Confirm Order Card */
.confirm-order-card {
    background: rgba(255, 255, 255, 0.03);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 32px;
    animation: slideInUp 0.6s ease 0.2s both;
    position: sticky;
    top: 20px;
    box-shadow: var(--shadow-md);
}

.confirm-title {
    font-weight: 900;
    margin-bottom: 20px;
    color: var(--accent);
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.confirm-description {
    color: var(--text-secondary);
    font-size: 0.95rem;
    margin-bottom: 28px;
    line-height: 1.6;
    font-weight: 600;
}

/* Buttons */
.btn-place-order {
    background: linear-gradient(135deg, var(--accent), #FFB000);
    color: var(--primary);
    border: none;
    padding: 18px 28px;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 900;
    width: 100%;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.btn-place-order::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: 0.6s;
}

.btn-place-order:hover::before {
    left: 100%;
}

.btn-place-order:hover {
    background: linear-gradient(135deg, #FFB000, #FF8C00);
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 12px 35px rgba(255, 215, 0, 0.5);
}

.btn-place-order:active {
    transform: translateY(-1px) scale(0.98);
}

.btn-edit-cart {
    background: transparent;
    color: var(--text-primary);
    border: 2px solid rgba(255, 255, 255, 0.2);
    padding: 14px 24px;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 700;
    width: 100%;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 16px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-edit-cart:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.4);
    color: var(--text-primary);
    transform: translateY(-2px);
}

/* Security Badge */
.security-badge {
    background: rgba(34, 197, 94, 0.15);
    border: 2px solid rgba(34, 197, 94, 0.3);
    color: #22c55e;
    padding: 16px 20px;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 700;
    margin-top: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    justify-content: center;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Empty State */
.empty-state {
    background: rgba(255, 255, 255, 0.03);
    border: 2px dashed rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 80px 40px;
    text-align: center;
    color: var(--text-primary);
    animation: fadeIn 0.6s ease;
    max-width: 600px;
    margin: 0 auto;
}

.empty-state i {
    font-size: 4rem;
    display: block;
    margin-bottom: 24px;
    color: rgba(255, 255, 255, 0.3);
}

.empty-state h4 {
    color: var(--text-primary);
    font-weight: 900;
    margin-bottom: 12px;
    font-size: 1.4rem;
}

.empty-state p {
    color: var(--text-secondary);
    margin-bottom: 28px;
    font-size: 1rem;
    line-height: 1.5;
}

.btn-browse {
    background: linear-gradient(135deg, var(--accent), #FFB000);
    color: var(--primary);
    border: none;
    padding: 14px 28px;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 900;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 6px 20px rgba(255, 215, 0, 0.3);
}

.btn-browse:hover {
    background: linear-gradient(135deg, #FFB000, #FF8C00);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
    color: var(--primary);
}

/* Responsive Design */
@media (max-width: 1200px) {
    .checkout-grid {
        grid-template-columns: 1fr 400px;
        gap: 28px;
    }
}

@media (max-width: 992px) {
    .checkout-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .confirm-order-card {
        position: static;
        order: -1;
    }
}

@media (max-width: 768px) {
    .checkout-container {
        padding: 16px;
    }

    .checkout-header {
        padding: 24px 20px;
    }

    .checkout-title {
        font-size: 1.8rem;
        flex-direction: column;
        gap: 8px;
    }

    .summary-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
        padding: 16px 20px;
    }

    .summary-item-price {
        align-self: flex-end;
    }

    .summary-totals {
        padding: 20px;
    }

    .confirm-order-card {
        padding: 24px 20px;
    }
}

@media (max-width: 480px) {
    .checkout-title {
        font-size: 1.5rem;
    }

    .summary-header {
        padding: 20px;
        font-size: 1rem;
    }

    .summary-item {
        padding: 14px 16px;
    }

    .summary-totals {
        padding: 16px;
    }

    .confirm-order-card {
        padding: 20px 16px;
    }
}
</style>

<div class="checkout-container">

    <!-- Page Header -->
    <div class="checkout-header">
        <h1 class="checkout-title">
            <i class="bi bi-credit-card"></i>
            Checkout
        </h1>
        <p class="checkout-subtitle">Review your order and complete your purchase with our secure checkout system</p>
    </div>

    <?php if (empty($cart)): ?>
        <div class="empty-state">
            <i class="bi bi-cart-x"></i>
            <h4>Your Cart is Empty</h4>
            <p>Add some construction materials to your cart to proceed with checkout and start building your project.</p>
            <a href="?controller=materials&action=index" class="btn-browse">
                <i class="bi bi-shop"></i>Browse Materials
            </a>
        </div>
    <?php else: ?>

    <div class="checkout-grid">

        <!-- ORDER SUMMARY -->
        <div class="order-summary-card">
            <div class="summary-header">
                <i class="bi bi-list-check"></i>
                Order Summary (<?= count($cart) ?> items)
            </div>
            <div class="summary-content">
                <?php $subtotal = 0; ?>
                <?php foreach ($cart as $index => $item): ?>
                    <?php $itemTotal = (float)($item['price'] ?? 0) * (int)($item['qty'] ?? 1); $subtotal += $itemTotal; ?>
                    <div class="summary-item" style="animation-delay: <?= ($index + 1) * 0.05 ?>s;">
                        <div class="summary-item-details">
                            <div class="summary-item-name"><?= htmlspecialchars($item['name'] ?? $item['material_name'] ?? '') ?></div>
                            <div class="summary-item-meta">
                                <i class="bi bi-box"></i>
                                × <?= (int)($item['qty'] ?? 1) ?> <?= htmlspecialchars($item['unit'] ?? $item['unit_type'] ?? '') ?>
                            </div>
                        </div>
                        <div class="summary-item-price">₱<?= number_format($itemTotal, 2) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php 
            $vat = $subtotal * 0.12;
            $total = $subtotal + $vat;
            ?>
            <div class="summary-totals">
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
                        <span>Total</span>
                        <span class="summary-total-amount">₱<?= number_format($total, 2) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONFIRM ORDER -->
        <div class="confirm-order-card">
            <h2 class="confirm-title">
                <i class="bi bi-check-circle"></i>
                Confirm Order
            </h2>
            <p class="confirm-description">
                Review your construction materials and click "Place Order" to confirm your purchase. 
                Our team will contact you within 24 hours for delivery scheduling and payment arrangements.
            </p>

            <?php
            // Load user address
            require_once BASE_PATH . '/app/models/User.php';
            $userModel = new User();
            $currentUser = $userModel->find((int)($_SESSION['user']['id'] ?? 0)) ?? [];
            $userAddress = $currentUser['address'] ?? '';
            ?>

            <!-- DELIVERY ADDRESS -->
            <div style="background:rgba(255,255,255,0.05);border:2px solid rgba(255,215,0,0.3);border-radius:12px;padding:16px 20px;margin-bottom:20px;">
                <div style="font-size:0.75rem;color:rgba(255,255,255,0.5);font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;">
                    <i class="bi bi-geo-alt-fill me-1" style="color:#FFD700;"></i>Delivery Address
                </div>
                <?php if (!empty($userAddress)): ?>
                    <div style="font-size:0.95rem;font-weight:700;color:#ffffff;"><?= htmlspecialchars($userAddress) ?></div>
                <?php else: ?>
                    <div style="font-size:0.88rem;color:#ef4444;font-weight:700;">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        No address set. <a href="?controller=dashboard&action=settings" style="color:#FFD700;">Update in Settings →</a>
                    </div>
                <?php endif; ?> 
            </div>

            <?php
            // Calculate estimated arrival: 6-8 business days from today, skipping Sundays
            function getEstimatedArrival(int $minDays, int $maxDays): array {
                $dates = [];
                foreach ([$minDays, $maxDays] as $days) {
                    $date = new DateTime();
                    $added = 0;
                    while ($added < $days) {
                        $date->modify('+1 day');
                        // Skip Sundays (0 = Sunday)
                        if ((int)$date->format('w') !== 0) {
                            $added++;
                        }
                    }
                    $dates[] = $date;
                }
                return $dates;
            }
            [$arrivalStart, $arrivalEnd] = getEstimatedArrival(6, 8);
            $sameMonth = $arrivalStart->format('M') === $arrivalEnd->format('M');
            $arrivalLabel = $sameMonth
                ? $arrivalStart->format('M') . ' ' . $arrivalStart->format('d') . '–' . $arrivalEnd->format('d') . ', ' . $arrivalEnd->format('Y')
                : $arrivalStart->format('M d') . ' – ' . $arrivalEnd->format('M d, Y');
            ?>

            <!-- ESTIMATED ARRIVAL -->
            <div style="
                background: rgba(255,215,0,0.1);
                border: 2px solid rgba(255,215,0,0.4);
                border-radius: 12px;
                padding: 16px 20px;
                margin-bottom: 24px;
                display: flex;
                align-items: center;
                gap: 14px;
            ">
                <div style="width:44px; height:44px; background:#FFD700; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="bi bi-truck" style="color:#1a1a1a; font-size:1.3rem;"></i>
                </div>
                <div>
                    <div style="font-size:0.78rem; color:rgba(255,255,255,0.6); font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:3px;">
                        Estimated Arrival
                    </div>
                    <div style="font-size:1.1rem; font-weight:900; color:#FFD700;">
                        <?= $arrivalLabel ?>
                    </div>
                    <div style="font-size:0.75rem; color:rgba(255,255,255,0.5); font-weight:600; margin-top:2px;">
                        Mon–Sat delivery only · No Sunday deliveries
                    </div>
                </div>
            </div>
            
            <form method="POST" action="?controller=cart&action=placeOrder">
                <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">
                <button type="submit" class="btn-place-order">
                    <i class="bi bi-credit-card"></i>
                    Place Order
                </button>
            </form>
            
            <a href="?controller=cart&action=index" class="btn-edit-cart">
                <i class="bi bi-pencil"></i>
                Edit Cart
            </a>
            
            <div class="security-badge">
                <i class="bi bi-shield-check"></i>
                Secure & Safe Transaction
            </div>
        </div>

    </div>

    <?php endif; ?>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>