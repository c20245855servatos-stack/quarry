<?php ob_start(); ?>

<style>
/* ========================
   MODERN CONSTRUCTION THEME - MY ORDERS PAGE
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

.order-card {
    background: white;
    border: 2px solid var(--accent);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 14px;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    animation: slideInUp 0.4s ease both;
    box-shadow: var(--shadow-sm);
}

.order-card:nth-child(1) { animation-delay: 0.05s; }
.order-card:nth-child(2) { animation-delay: 0.1s; }
.order-card:nth-child(3) { animation-delay: 0.15s; }
.order-card:nth-child(4) { animation-delay: 0.2s; }
.order-card:nth-child(5) { animation-delay: 0.25s; }

.order-card:hover { 
    background: white;
    border-color: var(--primary);
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
}

.order-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 2px solid var(--accent);
    flex-wrap: wrap;
    gap: 12px;
}

.order-id-section {
    display: flex;
    align-items: center;
    gap: 12px;
}

.order-icon {
    width: 36px;
    height: 36px;
    background: var(--accent);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: var(--primary);
    flex-shrink: 0;
}

.order-num {
    font-weight: 900;
    font-size: 1rem;
    color: var(--primary);
    margin-bottom: 4px;
    letter-spacing: 0.5px;
}

.order-date {
    color: var(--secondary);
    font-size: 0.78rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 6px;
}

.arrival-date {
    color: #15803d;
    font-size: 0.82rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 4px;
    padding: 4px 10px;
    background: rgba(34, 197, 94, 0.18);
    border-radius: 6px;
    border: 1px solid rgba(34, 197, 94, 0.5);
}

.delivery-confirmation-section {
    margin-top: 8px;
    padding: 8px 0;
}

.btn-confirm-delivery {
    background: var(--accent);
    color: var(--primary);
    border: 2px solid var(--primary);
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 800;
    cursor: pointer;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}

.btn-confirm-delivery:hover {
    background: var(--hover-secondary);
    color: var(--primary);
    transform: translateY(-2px) scale(1.02);
    box-shadow: var(--shadow-sm);
}

.delivery-confirmed {
    color: #15803d;
    font-size: 0.82rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    padding: 6px 12px;
    background: rgba(34, 197, 94, 0.18);
    border-radius: 8px;
    border: 2px solid rgba(34, 197, 94, 0.5);
}

.order-items {
    margin: 0 0 12px;
    padding: 10px 14px;
    list-style: none;
    background: rgba(255, 215, 0, 0.08);
    border-radius: 8px;
}

.order-items li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid rgba(255, 215, 0, 0.3);
    font-size: 0.85rem;
    color: var(--primary);
    font-weight: 700;
}

.order-items li:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.order-item-name {
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
    font-size: 0.88rem;
    font-weight: 800;
}

.order-item-qty {
    background: var(--accent);
    border: 1px solid var(--primary);
    color: var(--primary);
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 900;
    margin: 0 10px;
}

.order-item-price {
    color: var(--primary);
    font-weight: 900;
    font-size: 0.88rem;
}

.order-footer {
    display: block;
    padding-top: 10px;
    border-top: 1px solid rgba(255, 215, 0, 0.4);
}

.order-total {
    font-weight: 900;
    color: var(--primary);
    font-size: 0.95rem;
}

.order-total-amount {
    color: var(--primary);
    font-size: 1.05rem;
    font-weight: 900;
}

.badge-pending {
    background: rgba(255, 193, 7, 0.25);
    color: #d97706;
    border: 2px solid rgba(255, 193, 7, 0.5);
    padding: 4px 12px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.badge-confirmed {
    background: rgba(59, 130, 246, 0.25);
    color: #2563eb;
    border: 2px solid rgba(59, 130, 246, 0.5);
    padding: 4px 12px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.badge-processing {
    background: rgba(168, 85, 247, 0.25);
    color: #7c3aed;
    border: 2px solid rgba(168, 85, 247, 0.5);
    padding: 4px 12px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.badge-completed {
    background: rgba(34, 197, 94, 0.25);
    color: #059669;
    border: 2px solid rgba(34, 197, 94, 0.5);
    padding: 4px 12px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.badge-cancelled {
    background: rgba(239, 68, 68, 0.25);
    color: #dc2626;
    border: 2px solid rgba(239, 68, 68, 0.5);
    padding: 4px 12px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
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

/* ========================
   PAGINATION
======================== */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 40px;
    animation: slideInUp 0.6s ease;
}

.pagination-controls {
    display: flex;
    align-items: center;
    gap: 12px;
    background: white;
    border: 2px solid var(--accent);
    border-radius: 12px;
    padding: 16px 20px;
    box-shadow: var(--shadow-sm);
    flex-wrap: wrap;
    justify-content: center;
}

.pagination-numbers {
    display: flex;
    gap: 8px;
    align-items: center;
}

.pagination-number,
.pagination-btn {
    background: white;
    border: 2px solid var(--accent);
    color: var(--primary);
    padding: 10px 14px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    letter-spacing: 0.3px;
}

.pagination-number:hover:not(.active):not(:disabled),
.pagination-btn:hover:not(:disabled) {
    background: var(--accent);
    color: var(--primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.pagination-number.active {
    background: var(--accent);
    color: var(--primary);
    border-color: var(--primary);
    box-shadow: var(--shadow-sm);
}

.pagination-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination-ellipsis {
    color: var(--secondary);
    font-weight: 700;
    padding: 0 4px;
}

.pagination-prev,
.pagination-next {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.pagination-prev:hover:not(:disabled),
.pagination-next:hover:not(:disabled) {
    background: var(--hover-primary);
    color: white;
    border-color: var(--hover-primary);
}

@media (max-width: 768px) {
    .order-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .order-items li {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .order-item-qty {
        margin: 0;
    }

    .order-footer {
        padding-top: 16px;
    }
    
    .order-footer > div[style*="display: flex"] {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 8px !important;
    }

    .pagination-numbers {
        gap: 4px !important;
    }

    .pagination-number {
        padding: 8px 10px !important;
        font-size: 0.85rem !important;
    }

    .pagination-btn {
        padding: 8px 12px !important;
        font-size: 0.85rem !important;
    }
}
</style>

<div class="container-fluid p-4">

    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h2><i class="bi bi-box-seam me-2"></i>My Orders</h2>
                <p><?= count($orders) ?> order<?= count($orders) !== 1 ? 's' : '' ?> total</p>
            </div>
            <a href="?controller=dashboard&action=shop" class="btn btn-light fw-bold px-4">
                <i class="bi bi-shop me-1"></i> Continue Shopping
            </a>
        </div>
    </div>

    <?php if (empty($orders)): ?>
        <div class="empty-state">
            <i class="bi bi-box-seam"></i>
            <p style="font-size:1rem;margin:0 0 8px;">No orders yet</p>
            <p style="font-size:0.9rem;margin:0 0 20px;opacity:0.7;">Start shopping to place your first order.</p>
            <a href="?controller=dashboard&action=shop" class="btn btn-warning fw-bold px-4">Browse Materials</a>
        </div>
    <?php else: ?>
        <?php 
        // Pagination setup
        $ordersPerPage = 5;
        $totalOrders = count($orders);
        $totalPages = ceil($totalOrders / $ordersPerPage);
        $currentPage = max(1, (int)($_GET['page'] ?? 1));
        $currentPage = min($currentPage, $totalPages);
        
        $startIndex = ($currentPage - 1) * $ordersPerPage;
        $paginatedOrders = array_slice($orders, $startIndex, $ordersPerPage);
        ?>
        
        <?php foreach ($paginatedOrders as $order): ?>
        <div class="order-card">
            <div class="order-header">
                <div class="order-id-section">
                    <div class="order-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <div class="order-date">
                            <i class="bi bi-calendar3"></i>
                            <?= date('M d, Y', strtotime($order['order_date'] ?? '')) ?> at <?= date('H:i', strtotime($order['order_date'] ?? '')) ?>
                        </div>
                        <?php if (!empty($order['arrival_date'])): ?>
                        <div class="arrival-date">
                            <i class="bi bi-truck"></i>
                            <span>Arrived: <?= date('M d, Y', strtotime($order['arrival_date'])) ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php 
                        // Show delivery confirmation for orders that are out_for_delivery or completed but not confirmed by user
                        $needsConfirmation = in_array(strtolower($order['order_status'] ?? ''), ['out_for_delivery', 'completed']) 
                                           && empty($order['user_confirmed_delivery']);
                        ?>
                        <?php if ($needsConfirmation): ?>
                        <div class="delivery-confirmation-section">
                            <button class="btn-confirm-delivery" onclick="confirmDelivery(<?= $order['order_id'] ?>)">
                                <i class="bi bi-check-circle me-2"></i>Confirm Delivery Received
                            </button>
                        </div>
                        <?php elseif (!empty($order['user_confirmed_delivery'])): ?>
                        <div class="delivery-confirmed">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <span>Delivery confirmed on <?= date('M d, Y', strtotime($order['user_confirmed_delivery'])) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                $status = strtolower($order['order_status'] ?? 'pending');
                $badgeClass = match($status) {
                    'completed' => 'badge-completed',
                    'cancelled' => 'badge-cancelled',
                    'confirmed' => 'badge-confirmed',
                    'processing' => 'badge-processing',
                    default     => 'badge-pending',
                };
                $statusIcon = match($status) {
                    'completed' => 'check-circle-fill',
                    'cancelled' => 'x-circle-fill',
                    'confirmed' => 'check-circle',
                    'processing' => 'arrow-repeat',
                    default     => 'clock-fill',
                };
                // Cancellable statuses — cannot cancel if out_for_delivery, completed, or already cancelled
                $cancellable = $status === 'pending';
                ?>
                <div style="display:flex; flex-direction:column; align-items:flex-end; gap:8px;">
                    <span class="<?= $badgeClass ?>">
                        <i class="bi bi-<?= $statusIcon ?>"></i>
                        <?= ucfirst(str_replace('_', ' ', $order['order_status'] ?? 'Pending')) ?>
                    </span>
                    <?php if ($cancellable): ?>
                    <button onclick="openCancelModal(<?= $order['order_id'] ?>)"
                        style="background:rgba(239,68,68,0.1); border:2px solid rgba(239,68,68,0.4); color:#dc2626;
                               padding:6px 14px; border-radius:8px; font-size:0.8rem; font-weight:800;
                               cursor:pointer; transition:0.2s ease; display:flex; align-items:center; gap:6px;"
                        onmouseover="this.style.background='rgba(239,68,68,0.2)'"
                        onmouseout="this.style.background='rgba(239,68,68,0.1)'">
                        <i class="bi bi-x-circle-fill"></i> Cancel Order
                    </button>
                    <?php elseif ($status === 'out_for_delivery'): ?>
                    <span style="font-size:0.75rem; color:#f59e0b; font-weight:700;">
                        <i class="bi bi-truck me-1"></i>Cannot cancel — out for delivery
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <ul class="order-items">
                <?php 
                $materialModel = new Material();
                $orderItems = $materialModel->orderItems($order['order_id']);
                $calculatedSubtotal = 0;
                foreach ($orderItems as $item): 
                    $itemTotal = (float)($item['unit_price'] ?? 0) * (int)($item['quantity'] ?? 1);
                    $calculatedSubtotal += $itemTotal;
                ?>
                <li>
                    <div class="order-item-name">
                        <i class="bi bi-box" style="color: rgba(52, 101, 109, 0.6);"></i>
                        <span><?= htmlspecialchars($item['material_name'] ?? 'Unknown') ?></span>
                    </div>
                    <div class="order-item-qty">
                        Qty: <?= (int)($item['quantity'] ?? 1) ?>
                    </div>
                    <div class="order-item-price">
                        ₱<?= number_format($itemTotal, 2) ?>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>

            <div class="order-footer">
                <?php 
                // Calculate VAT and total
                $vat = $calculatedSubtotal * 0.12;
                $totalWithVat = $calculatedSubtotal + $vat;
                ?>
                
                <?php if ($calculatedSubtotal > 0): ?>
                <!-- Subtotal and VAT Breakdown -->
                <div style="width: 100%; margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.95rem; color: #2d2d2d; font-weight: 700;">
                        <span>Subtotal:</span>
                        <span>₱<?= number_format($calculatedSubtotal, 2) ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; color: #2d2d2d; font-weight: 700;">
                        <span>VAT (12%):</span>
                        <span>₱<?= number_format($vat, 2) ?></span>
                    </div>
                    <div style="border-top: 2px solid rgba(52, 101, 109, 0.2); padding-top: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div class="order-total">Total Amount:</div>
                            <div class="order-total-amount">₱<?= number_format($totalWithVat, 2) ?></div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <!-- Fallback to database total if no items calculated -->
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <div class="order-total">Total Amount:</div>
                    <?php if (!empty($order['total_amount'])): ?>
                    <div class="order-total-amount">₱<?= number_format($order['total_amount'], 2) ?></div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if (strtolower($order['order_status'] ?? '') === 'completed'): ?>
                <!-- ORDER COMPLETION CONFIRMATION -->
                <div style="
                    margin-top: 10px;
                    background: linear-gradient(135deg, rgba(34,197,94,0.1), rgba(22,163,74,0.06));
                    border: 1px solid rgba(34,197,94,0.4);
                    border-radius: 8px;
                    padding: 12px 14px;
                ">
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:10px;">
                        <div style="width:28px; height:28px; background:#16a34a; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="bi bi-check-lg" style="color:white; font-size:0.9rem;"></i>
                        </div>
                        <div>
                            <div style="font-weight:900; font-size:0.88rem; color:#15803d;">Order Completed!</div>
                            <div style="font-size:0.75rem; color:#166534; font-weight:700;">Thank you for your purchase</div>
                        </div>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:6px; font-size:0.78rem;">
                        <div style="background:rgba(255,255,255,0.6); border-radius:6px; padding:6px 10px;">
                            <div style="color:#6b7280; font-weight:700; margin-bottom:1px;">Order #</div>
                            <div style="font-weight:900; color:#1a1a1a;"><?= $order['order_id'] ?></div>
                        </div>
                        <div style="background:rgba(255,255,255,0.6); border-radius:6px; padding:6px 10px;">
                            <div style="color:#6b7280; font-weight:700; margin-bottom:1px;">Order Date</div>
                            <div style="font-weight:900; color:#1a1a1a;"><?= date('M d, Y', strtotime($order['order_date'] ?? '')) ?></div>
                        </div>
                        <div style="background:rgba(255,255,255,0.6); border-radius:6px; padding:6px 10px;">
                            <div style="color:#6b7280; font-weight:700; margin-bottom:1px;">Items</div>
                            <div style="font-weight:900; color:#1a1a1a;"><?= count($orderItems) ?> item<?= count($orderItems) !== 1 ? 's' : '' ?></div>
                        </div>
                        <div style="background:rgba(255,255,255,0.6); border-radius:6px; padding:6px 10px;">
                            <div style="color:#6b7280; font-weight:700; margin-bottom:1px;">Total Paid</div>
                            <div style="font-weight:900; color:#15803d;">₱<?= number_format($totalWithVat ?: (float)($order['total_amount'] ?? 0), 2) ?></div>
                        </div>
                    </div>
                    <?php if (!empty($order['arrival_date'])): ?>
                    <div style="margin-top:6px; background:rgba(255,255,255,0.6); border-radius:6px; padding:6px 10px; font-size:0.82rem;">
                        <div style="color:#374151; font-weight:700; margin-bottom:1px;">Delivered On</div>
                        <div style="font-weight:900; color:#1a1a1a;"><?= date('M d, Y', strtotime($order['arrival_date'])) ?></div>
                    </div>
                    <?php endif; ?>
                    <div style="margin-top:8px; text-align:center; font-size:0.75rem; color:#15803d; font-weight:700;">
                        <i class="bi bi-heart-fill me-1"></i>We appreciate your business. Order again anytime!
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- PAGINATION -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination-container">
            <div class="pagination-controls">
                <!-- Previous Button -->
                <?php if ($currentPage > 1): ?>
                    <a href="?controller=dashboard&action=orders&page=<?= $currentPage - 1 ?>" class="pagination-btn pagination-prev">
                        <i class="bi bi-chevron-left"></i> Previous
                    </a>
                <?php else: ?>
                    <button class="pagination-btn pagination-prev" disabled>
                        <i class="bi bi-chevron-left"></i> Previous
                    </button>
                <?php endif; ?>
                
                <!-- Page Numbers -->
                <div class="pagination-numbers">
                    <?php 
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($totalPages, $currentPage + 2);
                    
                    if ($startPage > 1): ?>
                        <a href="?controller=dashboard&action=orders&page=1" class="pagination-number">1</a>
                        <?php if ($startPage > 2): ?>
                            <span class="pagination-ellipsis">...</span>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <?php if ($i === $currentPage): ?>
                            <button class="pagination-number active"><?= $i ?></button>
                        <?php else: ?>
                            <a href="?controller=dashboard&action=orders&page=<?= $i ?>" class="pagination-number"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($endPage < $totalPages): ?>
                        <?php if ($endPage < $totalPages - 1): ?>
                            <span class="pagination-ellipsis">...</span>
                        <?php endif; ?>
                        <a href="?controller=dashboard&action=orders&page=<?= $totalPages ?>" class="pagination-number"><?= $totalPages ?></a>
                    <?php endif; ?>
                </div>
                
                <!-- Next Button -->
                <?php if ($currentPage < $totalPages): ?>
                    <a href="?controller=dashboard&action=orders&page=<?= $currentPage + 1 ?>" class="pagination-btn pagination-next">
                        Next <i class="bi bi-chevron-right"></i>
                    </a>
                <?php else: ?>
                    <button class="pagination-btn pagination-next" disabled>
                        Next <i class="bi bi-chevron-right"></i>
                    </button>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>

</div>

<!-- Delivery Confirmation Modal -->
<div class="confirmation-modal-overlay" id="confirmationModal">
    <div class="confirmation-modal">
        <div class="confirmation-modal-header">
            <h4><i class="bi bi-check-circle me-2" style="color: #16a34a;"></i>Confirm Delivery</h4>
            <button class="confirmation-modal-close" onclick="closeConfirmationModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="confirmation-modal-body">
            <p>Have you received all the materials for this order?</p>
            <p><small style="color: #666;">This action will mark the order as delivered and completed.</small></p>
        </div>
        <div class="confirmation-modal-footer">
            <button class="btn-cancel" onclick="closeConfirmationModal()">Cancel</button>
            <button class="btn-confirm" onclick="submitDeliveryConfirmation()">
                <i class="bi bi-check-circle me-2"></i>Yes, Confirm Delivery
            </button>
        </div>
    </div>
</div>

<style>
.confirmation-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: 0.3s ease;
}

.confirmation-modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.confirmation-modal {
    background: white;
    border-radius: 16px;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    transform: translateY(20px);
    transition: 0.3s ease;
}

.confirmation-modal-overlay.show .confirmation-modal {
    transform: translateY(0);
}

.confirmation-modal-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid #e5e5e5;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.confirmation-modal-header h4 {
    margin: 0;
    font-weight: 800;
    color: #1a1a1a;
    display: flex;
    align-items: center;
}

.confirmation-modal-close {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: #666;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: 0.2s ease;
}

.confirmation-modal-close:hover {
    background: #f5f5f5;
    color: #333;
}

.confirmation-modal-body {
    padding: 20px 24px;
}

.confirmation-modal-body p {
    margin: 0 0 12px;
    color: #333;
    font-weight: 600;
}

.confirmation-modal-footer {
    padding: 16px 24px 20px;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}

.btn-cancel {
    background: #f5f5f5;
    color: #666;
    border: 2px solid #e5e5e5;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.2s ease;
}

.btn-cancel:hover {
    background: #e5e5e5;
    color: #333;
}

.btn-confirm {
    background: linear-gradient(135deg, #16a34a, #15803d);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.3s ease;
    display: flex;
    align-items: center;
}

.btn-confirm:hover {
    background: linear-gradient(135deg, #15803d, #166534);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
}
</style>

<script>
let currentOrderId = null;

function confirmDelivery(orderId) {
    currentOrderId = orderId;
    document.getElementById('confirmationModal').classList.add('show');
}

function closeConfirmationModal() {
    document.getElementById('confirmationModal').classList.remove('show');
    currentOrderId = null;
}

function submitDeliveryConfirmation() {
    if (currentOrderId) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '?controller=dashboard&action=confirmDelivery';
        
        const orderIdInput = document.createElement('input');
        orderIdInput.type = 'hidden';
        orderIdInput.name = 'order_id';
        orderIdInput.value = currentOrderId;

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_csrf';
        csrfInput.value = '<?= Csrf::generate() ?>';
        
        form.appendChild(orderIdInput);
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Close modal when clicking outside
document.getElementById('confirmationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeConfirmationModal();
    }
});

// Cancel order
let cancelOrderId = null;

function openCancelModal(orderId) {
    cancelOrderId = orderId;
    document.getElementById('cancelModal').classList.add('show');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.remove('show');
    cancelOrderId = null;
}

function submitCancelOrder() {
    if (cancelOrderId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '?controller=dashboard&action=cancelOrder';
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'order_id';
        input.value = cancelOrderId;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_csrf';
        csrfInput.value = '<?= Csrf::generate() ?>';
        form.appendChild(input);
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}

document.getElementById('cancelModal').addEventListener('click', function(e) {
    if (e.target === this) closeCancelModal();
});
</script>

<!-- Cancel Order Modal -->
<div class="confirmation-modal-overlay" id="cancelModal">
    <div class="confirmation-modal">
        <div class="confirmation-modal-header">
            <h4><i class="bi bi-x-circle-fill me-2" style="color:#dc2626;"></i>Cancel Order</h4>
            <button class="confirmation-modal-close" onclick="closeCancelModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="confirmation-modal-body">
            <p>Are you sure you want to cancel this order?</p>
            <p><small style="color:#666;">This action cannot be undone. Stock will be restored.</small></p>
        </div>
        <div class="confirmation-modal-footer">
            <button class="btn-cancel" onclick="closeCancelModal()">Keep Order</button>
            <button onclick="submitCancelOrder()"
                style="background:linear-gradient(135deg,#dc2626,#b91c1c); color:white; border:none;
                       padding:10px 20px; border-radius:8px; font-weight:700; cursor:pointer;
                       transition:0.3s ease; display:flex; align-items:center; gap:6px;">
                <i class="bi bi-x-circle-fill"></i> Yes, Cancel Order
            </button>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
