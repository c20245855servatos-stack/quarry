<?php ob_start(); ?>

<?php require __DIR__ . '/admin_style.css.php'; ?>

<?php
$allOrdersSorted = $allOrders ?? [];
usort($allOrdersSorted, fn($a, $b) => strtotime($b['created_at'] ?? '0') - strtotime($a['created_at'] ?? '0'));

$completedOrders = array_filter($allOrders ?? [], fn($o) => strtolower($o['order_status'] ?? $o['status'] ?? '') === 'completed');
$cancelledOrders = array_filter($allOrders ?? [], fn($o) => strtolower($o['order_status'] ?? $o['status'] ?? '') === 'cancelled');
$pendingOrders   = array_filter($allOrders ?? [], fn($o) => strtolower($o['order_status'] ?? $o['status'] ?? '') === 'pending');
?>

<div class="adm-wrap">

  <!-- HEADER -->
  <div class="adm-header">
    <div>
      <h1 class="adm-title"><i class="bi bi-bar-chart-fill"></i> Sales Report</h1>
      <p class="adm-sub">Revenue overview, top materials, and order performance.</p>
    </div>
  </div>

  <!-- SUMMARY STATS -->
  <div class="adm-stats" style="margin-bottom:28px;">
    <div class="stat-card">
      <div class="stat-icon teal" style="font-size:1.4rem; font-weight:900;">₱</div>      <div class="stat-body">
        <div class="stat-num">₱<?= number_format($totalRevenue ?? 0, 0) ?></div>
        <div class="stat-lbl">Revenue (This Month)</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green"><i class="bi bi-check-circle-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= count($completedOrders) ?></div>
        <div class="stat-lbl">Completed Orders</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon yellow"><i class="bi bi-clock-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= count($pendingOrders) ?></div>
        <div class="stat-lbl">Pending Orders</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon red"><i class="bi bi-x-circle-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= count($cancelledOrders) ?></div>
        <div class="stat-lbl">Cancelled Orders</div>
      </div>
    </div>
  </div>

  <!-- ALL ORDERS TABLE -->
  <div class="adm-card">
    <div class="adm-card-head">
      <span><i class="bi bi-table me-2"></i>All Orders History</span>
    </div>
    <?php if (empty($allOrders ?? [])): ?>
      <div class="adm-empty">No orders found.</div>
    <?php else: ?>
    <?php
    $salesPerPage    = 10;
    $salesTotal      = count($allOrdersSorted);
    $salesTotalPages = max(1, (int)ceil($salesTotal / $salesPerPage));
    $salesPage       = max(1, min($salesTotalPages, (int)($_GET['sales_page'] ?? 1)));
    $salesOffset     = ($salesPage - 1) * $salesPerPage;
    $salesSlice      = array_slice($allOrdersSorted, $salesOffset, $salesPerPage);
    $salesFrom       = $salesTotal > 0 ? $salesOffset + 1 : 0;
    $salesTo         = min($salesOffset + $salesPerPage, $salesTotal);
    ?>
    <div style="overflow-x:auto;">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Order #</th>
          <th>Customer</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Delivery Date</th>
          <th>Order Date</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($salesSlice as $i => $o): ?>
        <?php
        $oStatus = strtolower($o['order_status'] ?? $o['status'] ?? 'pending');
        $statusColor = match($oStatus) {
            'completed'        => '#22c55e',
            'cancelled'        => '#ef4444',
            'confirmed'        => '#3b82f6',
            'processing'       => '#a855f7',
            'out_for_delivery' => '#f59e0b',
            default            => '#d97706',
        };
        ?>
        <tr>
          <td><strong style="color:var(--text-primary);"><?= $i + 1 ?></strong></td>
          <td style="color:var(--text-primary); font-weight:700;"><?= htmlspecialchars($o['full_name'] ?? 'N/A') ?></td>
          <td style="color:#22c55e; font-weight:900;">₱<?= number_format($o['total_amount'] ?? 0, 2) ?></td>
          <td>
            <span style="background:<?= $statusColor ?>22; border:1px solid <?= $statusColor ?>66; color:<?= $statusColor ?>; padding:4px 10px; border-radius:6px; font-size:0.78rem; font-weight:800; text-transform:uppercase; letter-spacing:0.5px;">
              <?= ucfirst(str_replace('_', ' ', $oStatus)) ?>
            </span>
          </td>
          <td style="font-size:0.85rem; color:var(--text-primary); font-weight:700;">
            <?= ($o['delivery_date'] ?? null) ? date('M d, Y', strtotime($o['delivery_date'])) : '<span style="color:var(--text-secondary);">—</span>' ?>
          </td>
          <td style="font-size:0.85rem; color:var(--text-secondary); font-weight:700;">
            <?= date('M d, Y', strtotime($o['created_at'] ?? 'now')) ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    </div>

    <!-- PAGINATION BAR -->
    <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 20px; background:rgba(255,255,255,0.03); border-top:1px solid rgba(255,215,0,0.15); flex-wrap:wrap; gap:12px;">
      <span style="color:var(--text-secondary); font-size:0.9rem; font-weight:600;">
        Showing <?= $salesFrom ?> to <?= $salesTo ?> of <?= $salesTotal ?> order<?= $salesTotal !== 1 ? 's' : '' ?>
      </span>
      <div style="display:flex; align-items:center; gap:6px;">
        <?php
        $salesBaseUrl = '?controller=admin&action=sales';
        $startPage = max(1, $salesPage - 2);
        $endPage   = min($salesTotalPages, $salesPage + 2);
        ?>
        <?php if ($salesPage > 1): ?>
          <a href="<?= $salesBaseUrl ?>&sales_page=<?= $salesPage - 1 ?>" style="padding:7px 14px; background:rgba(255,215,0,0.15); border:1px solid #FFD700; color:#FFD700; border-radius:6px; font-weight:700; font-size:0.85rem; text-decoration:none; display:flex; align-items:center; gap:4px;">
            <i class="bi bi-chevron-left"></i> Prev
          </a>
        <?php endif; ?>
        <?php if ($startPage > 1): ?>
          <a href="<?= $salesBaseUrl ?>&sales_page=1" style="padding:7px 12px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.15); color:var(--text-primary); border-radius:6px; font-weight:700; font-size:0.85rem; text-decoration:none;">1</a>
          <?php if ($startPage > 2): ?><span style="color:var(--text-secondary); padding:0 4px;">…</span><?php endif; ?>
        <?php endif; ?>
        <?php for ($p = $startPage; $p <= $endPage; $p++): ?>
          <a href="<?= $salesBaseUrl ?>&sales_page=<?= $p ?>" style="padding:7px 12px; background:<?= $p === $salesPage ? '#FFD700' : 'rgba(255,255,255,0.05)' ?>; border:1px solid <?= $p === $salesPage ? '#FFD700' : 'rgba(255,255,255,0.15)' ?>; color:<?= $p === $salesPage ? '#1a1a1a' : 'var(--text-primary)' ?>; border-radius:6px; font-weight:<?= $p === $salesPage ? '900' : '700' ?>; font-size:0.85rem; text-decoration:none;"><?= $p ?></a>
        <?php endfor; ?>
        <?php if ($endPage < $salesTotalPages): ?>
          <?php if ($endPage < $salesTotalPages - 1): ?><span style="color:var(--text-secondary); padding:0 4px;">…</span><?php endif; ?>
          <a href="<?= $salesBaseUrl ?>&sales_page=<?= $salesTotalPages ?>" style="padding:7px 12px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.15); color:var(--text-primary); border-radius:6px; font-weight:700; font-size:0.85rem; text-decoration:none;"><?= $salesTotalPages ?></a>
        <?php endif; ?>
        <?php if ($salesPage < $salesTotalPages): ?>
          <a href="<?= $salesBaseUrl ?>&sales_page=<?= $salesPage + 1 ?>" style="padding:7px 14px; background:rgba(255,215,0,0.15); border:1px solid #FFD700; color:#FFD700; border-radius:6px; font-weight:700; font-size:0.85rem; text-decoration:none; display:flex; align-items:center; gap:4px;">
            Next <i class="bi bi-chevron-right"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
