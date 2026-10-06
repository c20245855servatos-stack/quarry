<?php ob_start(); ?>

<?php require __DIR__ . '/admin_style.css.php'; ?>

<?php
$selectedYear  = (int)($selectedYear  ?? date('Y'));
$selectedMonth = (int)($selectedMonth ?? date('n'));

$allOrdersSorted = $allOrders ?? [];
usort($allOrdersSorted, fn($a, $b) => strtotime($b['created_at'] ?? '0') - strtotime($a['created_at'] ?? '0'));

// Filter completed orders by selected month
$completedOrders = array_filter($allOrders ?? [], fn($o) =>
    strtolower($o['order_status'] ?? '') === 'completed' &&
    (int)date('Y', strtotime($o['created_at'] ?? 'now')) === $selectedYear &&
    (int)date('n', strtotime($o['created_at'] ?? 'now')) === $selectedMonth
);
?>

<div class="adm-wrap">

  <!-- HEADER -->
  <div class="adm-header">
    <div>
      <h1 class="adm-title"><i class="bi bi-bar-chart-fill"></i> Sales Report</h1>
      <p class="adm-sub">Revenue overview, top materials, and order performance.</p>
    </div>
  </div>

  <!-- REVENUE BANNER + MONTH FILTER -->
  <style>
  .revenue-banner {
    background: rgba(255, 215, 0, 0.06);
    border: 1px solid rgba(255, 215, 0, 0.2);
    border-radius: 14px;
    padding: 28px 36px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    position: relative;
    overflow: hidden;
  }
  .revenue-banner::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #FFD700, #FFB000);
    border-radius: 14px 14px 0 0;
  }
  .revenue-banner-left { display: flex; flex-direction: column; gap: 6px; }
  .revenue-banner-label {
    font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 2px; color: rgba(255,255,255,0.4);
  }
  .revenue-banner-amount {
    font-size: 3rem; font-weight: 900; color: #FFD700;
    line-height: 1; letter-spacing: -2px;
  }
  .revenue-banner-sub { font-size: 0.8rem; color: rgba(255,255,255,0.35); font-weight: 600; }
  .revenue-banner-icon { font-size: 5rem; color: rgba(255,215,0,0.08); line-height: 1; flex-shrink: 0; }

  .rev-month-btn {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.75);
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    white-space: nowrap;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: 0.2s ease;
  }
  .rev-month-btn:hover { background: rgba(255,215,0,0.15); border-color: #FFD700; color: #FFD700; text-decoration: none; }
  .rev-month-btn.active { background: #FFD700; border-color: #FFD700; color: #1a1a1a; text-decoration: none; }

  @media (max-width: 480px) {
    .revenue-banner { padding: 20px; }
    .revenue-banner-amount { font-size: 2.2rem; }
    .revenue-banner-icon { display: none; }
  }
  </style>

  <div class="revenue-banner">
    <div class="revenue-banner-left">
      <div class="revenue-banner-label">Revenue — <?= date('F Y', mktime(0,0,0,$selectedMonth,1,$selectedYear)) ?></div>
      <div class="revenue-banner-amount">₱<?= number_format($totalRevenue ?? 0, 0) ?></div>
      <div class="revenue-banner-sub">From completed orders</div>
    </div>
    <i class="bi bi-graph-up-arrow revenue-banner-icon"></i>
  </div>

  <!-- MONTH FILTER PILLS -->
  <?php if (!empty($availableMonths)): ?>
  <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:24px; align-items:center;">
    <span style="font-size:0.75rem; font-weight:700; color:rgba(255,255,255,0.35); text-transform:uppercase; letter-spacing:1px; margin-right:4px;">Filter:</span>
    <?php foreach ($availableMonths as $m):
      $isActive = (int)$m['yr'] === $selectedYear && (int)$m['mo'] === $selectedMonth;
      $url = '?controller=admin&action=sales&rev_year=' . $m['yr'] . '&rev_month=' . $m['mo'];
    ?>
    <a href="<?= $url ?>" class="rev-month-btn <?= $isActive ? 'active' : '' ?>">
      <?= date('M Y', mktime(0,0,0,(int)$m['mo'],1,(int)$m['yr'])) ?>
    </a>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <!-- ALL ORDERS TABLE -->
  <div class="adm-card">
    <div class="adm-card-head">
      <span><i class="bi bi-table me-2"></i>Completed Orders</span>
    </div>
    <?php if (empty($completedOrders ?? [])): ?>
      <div class="adm-empty">No completed orders found.</div>
    <?php else: ?>
    <?php
    $salesPerPage    = 10;
    $salesSorted     = array_values($completedOrders);
    usort($salesSorted, fn($a, $b) => strtotime($b['created_at'] ?? '0') - strtotime($a['created_at'] ?? '0'));
    $salesTotal      = count($salesSorted);
    $salesTotalPages = max(1, (int)ceil($salesTotal / $salesPerPage));
    $salesPage       = max(1, min($salesTotalPages, (int)($_GET['sales_page'] ?? 1)));
    $salesOffset     = ($salesPage - 1) * $salesPerPage;
    $salesSlice      = array_slice($salesSorted, $salesOffset, $salesPerPage);
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
        ?>
        <tr>
          <td><strong style="color:var(--text-primary);"><?= $i + 1 ?></strong></td>
          <td style="color:var(--text-primary); font-weight:700;"><?= htmlspecialchars($o['full_name'] ?? 'N/A') ?></td>
          <td style="color:#22c55e; font-weight:900;">₱<?= number_format($o['total_amount'] ?? 0, 2) ?></td>
          <td>
            <span class="status-badge status-<?= $oStatus ?>">
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
        $salesBaseUrl = '?controller=admin&action=sales&rev_year=' . $selectedYear . '&rev_month=' . $selectedMonth;
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
