<?php ob_start(); ?>

<?php require __DIR__ . '/admin_style.css.php'; ?>

<div class="adm-wrap">

  <!-- PAGE HEADER -->
  <div class="adm-header">
    <div>
      <h1 class="adm-title"><i class="bi bi-speedometer2"></i> Admin Dashboard</h1>
      <p class="adm-sub">Welcome back, <?= htmlspecialchars($sessionUser['name'] ?? ($user['name'] ?? 'Admin')) ?> — here's what's happening today.</p>
    </div>
    <div class="adm-header-actions">
      <span class="adm-date"><?= date('l, F j, Y') ?></span>
    </div>
  </div>

  <!-- STAT CARDS -->
  <div class="adm-stats">
    <a href="?controller=admin&action=users" class="stat-card" style="text-decoration:none; cursor:pointer;">
      <div class="stat-icon green"><i class="bi bi-people-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= number_format($stats['users']) ?></div>
        <div class="stat-lbl">Total Users</div>
      </div>
    </a>
    <a href="?controller=admin&action=materials" class="stat-card" style="text-decoration:none; cursor:pointer;">
      <div class="stat-icon blue"><i class="bi bi-layers-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= number_format($stats['materials']) ?></div>
        <div class="stat-lbl">Materials</div>
      </div>
    </a>
    <a href="?controller=admin&action=orders" class="stat-card" style="text-decoration:none; cursor:pointer;">
      <div class="stat-icon yellow"><i class="bi bi-box-seam-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= number_format($stats['orders']) ?></div>
        <div class="stat-lbl">Total Orders</div>
      </div>
    </a>
    <a href="?controller=admin&action=orders&status=pending" class="stat-card" style="text-decoration:none; cursor:pointer;">
      <div class="stat-icon orange"><i class="bi bi-clock-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= number_format($stats['pending']) ?></div>
        <div class="stat-lbl">Pending Orders</div>
      </div>
    </a>
    <a href="?controller=admin&action=sales" class="stat-card" style="text-decoration:none; cursor:pointer;">
      <div class="stat-icon teal" style="font-size:1.4rem; font-weight:900;">₱</div>
      <div class="stat-body">
        <div class="stat-num">₱<?= number_format($stats['revenue'], 0) ?></div>
        <div class="stat-lbl">Revenue (This Month)</div>
      </div>
    </a>
  </div>



  <!-- STOCK ALERTS -->
  <?php if (!empty($stockAlerts)): ?>
  <div class="adm-section-title">Stock Alerts</div>
  <div class="adm-card" style="margin-bottom: 30px;">
    <div class="adm-card-head">
      <span><i class="bi bi-exclamation-triangle-fill me-2"></i>Stock Alerts (<?= count($stockAlerts) ?>)</span>
      <a href="?controller=admin&action=stockManagement" class="adm-link">Manage Stock →</a>
    </div>
    <div style="padding: 20px;">
      <?php foreach (array_slice($stockAlerts, 0, 5) as $alert): ?>
      <div style="display: flex; align-items: center; gap: 12px; padding: 12px; margin-bottom: 8px; border-radius: 8px; 
                  background: <?= $alert['type'] === 'danger' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(245, 158, 11, 0.1)' ?>;
                  border: 1px solid <?= $alert['type'] === 'danger' ? 'rgba(239, 68, 68, 0.3)' : 'rgba(245, 158, 11, 0.3)' ?>;
                  color: <?= $alert['type'] === 'danger' ? '#dc2626' : '#d97706' ?>;">
        <i class="bi bi-<?= $alert['icon'] ?>"></i>
        <div style="font-weight: 700;">
          <strong><?= $alert['title'] ?>:</strong> <?= htmlspecialchars($alert['message']) ?>
        </div>
      </div>
      <?php endforeach; ?>
      <?php if (count($stockAlerts) > 5): ?>
      <div style="text-align: center; margin-top: 16px;">
        <a href="?controller=admin&action=stockManagement" style="color: var(--primary); font-weight: 700;">
          View all <?= count($stockAlerts) ?> alerts →
        </a>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <?php endif; ?>

  <!-- BOTTOM GRID -->
  <div class="adm-grid-2">

    <!-- RECENT ORDERS -->
    <div class="adm-card">
      <div class="adm-card-head">
        <span><i class="bi bi-box-seam me-2"></i>Recent Orders</span>
        <a href="?controller=admin&action=orders" class="adm-link">View All →</a>
      </div>
      <?php if (empty($recentOrders)): ?>
        <div class="adm-empty">No orders yet.</div>
      <?php else: ?>
        <div>
        <table class="adm-table">
          <thead><tr><th>#</th><th>Customer</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
          <tbody>
          <?php foreach ($recentOrders as $i => $o): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($o['full_name'] ?? $o['customer_name'] ?? 'N/A') ?></td>
              <td>₱<?= number_format($o['total_amount'] ?? 0, 2) ?></td>
              <td><span class="status-badge status-<?= strtolower($o['order_status'] ?? 'pending') ?>"><?= ucfirst(str_replace('_',' ', $o['order_status'] ?? 'pending')) ?></span></td>
              <td><?= date('M d', strtotime($o['created_at'] ?? 'now')) ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        </div>
      <?php endif; ?>
    </div>

    <!-- RECENT ACTIVITY -->
    <div class="adm-card">
      <div class="adm-card-head">
        <span><i class="bi bi-journal-text me-2"></i>Recent Activity</span>
        <a href="?controller=admin&action=log" class="adm-link">View All →</a>
      </div>
      <?php if (empty($recentLog)): ?>
        <div class="adm-empty">No activity yet.</div>
      <?php else: ?>
        <div class="log-list">
          <?php foreach ($recentLog as $l): ?>
            <div class="log-item">
              <div class="log-dot"></div>
              <div class="log-body">
                <div class="log-action"><?= htmlspecialchars($l['action'] ?? 'Unknown Action') ?></div>
                <div class="log-detail"><?= htmlspecialchars($l['details'] ?? 'No details available') ?></div>
                <div class="log-time"><?= date('M d, Y H:i', strtotime($l['created_at'] ?? 'now')) ?> · <?= htmlspecialchars($l['user_name'] ?? 'System') ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

  </div>



</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
