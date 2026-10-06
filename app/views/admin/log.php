<?php ob_start(); ?>

<?php require __DIR__ . '/admin_style.css.php'; ?>

<style>
/* Pagination Styles */
.pagination-wrapper {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
  padding: 20px;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 12px;
}

.pagination-info {
  color: var(--text-secondary);
  font-size: 0.9rem;
  font-weight: 700;
}

.pagination-controls {
  display: flex;
  gap: 8px;
  align-items: center;
}

.pagination-btn {
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  color: #ffffff;
  padding: 8px 16px;
  border-radius: 6px;
  text-decoration: none;
  font-size: 0.85rem;
  font-weight: 700;
  transition: 0.3s ease;
  display: flex;
  align-items: center;
  gap: 6px;
}

.pagination-btn:hover:not(.disabled) {
  background: rgba(255, 215, 0, 0.2);
  border-color: #FFD700;
  color: #FFD700;
  text-decoration: none;
}

.pagination-btn.active {
  background: #FFD700;
  border-color: #FFD700;
  color: #1a1a1a;
}

.pagination-btn.disabled {
  opacity: 0.4;
  cursor: not-allowed;
  pointer-events: none;
}

.pagination-pages {
  display: flex;
  gap: 4px;
}

.page-select {
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  color: #ffffff;
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 0.85rem;
  font-weight: 700;
}

.page-select:focus {
  outline: none;
  border-color: #FFD700;
  background: rgba(255, 215, 0, 0.1);
}

@media (max-width: 768px) {
  .pagination-wrapper {
    flex-direction: column;
    gap: 16px;
    text-align: center;
  }
  
  .pagination-controls {
    flex-wrap: wrap;
    justify-content: center;
  }
}
</style>

<div class="adm-wrap">

  <!-- HEADER -->
  <div class="adm-header">
    <div>
      <h1 class="adm-title"><i class="bi bi-journal-text"></i> Activity Log</h1>
      <p class="adm-sub">Full history of all admin actions and system events.</p>
    </div>
    <div class="adm-header-actions">
      <span class="adm-date">
        <?= number_format($pagination['total_records'] ?? 0) ?> total entries
      </span>
    </div>
  </div>

  <!-- FILTER -->

  <!-- FILTER BUTTONS -->
  <?php $activeFilter = $_GET['filter'] ?? ''; ?>
  <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px;">
    <?php
    $filters = [
      ''                   => ['icon' => 'bi-grid-fill',      'label' => 'All'],
      'Order Placed'       => ['icon' => 'bi-bag-check',      'label' => 'Order Placed'],
      'Order Updated'      => ['icon' => 'bi-pencil',         'label' => 'Order Updated'],
      'Order Cancelled'    => ['icon' => 'bi-x-circle',       'label' => 'Order Cancelled'],
      'Delivery Confirmed' => ['icon' => 'bi-check-circle',   'label' => 'Delivery Confirmed'],
      'Item Added to Cart' => ['icon' => 'bi-cart-plus',      'label' => 'Item Added to Cart'],
      'Stock Replenished'  => ['icon' => 'bi-boxes',          'label' => 'Stock Replenished'],
      'Material Added'     => ['icon' => 'bi-plus-square',    'label' => 'Material Added'],
      'Material Updated'   => ['icon' => 'bi-pencil-square',  'label' => 'Material Updated'],
      'Material Deleted'   => ['icon' => 'bi-trash',          'label' => 'Material Deleted'],
      'User Deleted'       => ['icon' => 'bi-person-x',       'label' => 'User Deleted'],
    ];
    foreach ($filters as $key => $f):
      $isActive = $activeFilter === $key;
      $url = '?controller=admin&action=log&page=1' . ($key !== '' ? '&filter=' . urlencode($key) : '');
    ?>
    <a href="<?= $url ?>" class="log-filter-btn <?= $isActive ? 'active' : '' ?>">
      <i class="bi <?= $f['icon'] ?> me-1"></i> <?= $f['label'] ?>
    </a>
    <?php endforeach; ?>
  </div>

  <style>
  .log-filter-btn {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.75);
    padding: 9px 18px;
    border-radius: 20px;
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    transition: 0.2s ease;
    white-space: nowrap;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
  }
  .log-filter-btn:hover {
    background: rgba(255,215,0,0.15);
    border-color: #FFD700;
    color: #FFD700;
    text-decoration: none;
  }
  .log-filter-btn.active {
    background: #FFD700;
    border-color: #FFD700;
    color: #1a1a1a;
  }
  </style>

  <!-- LOG TABLE -->
  <div class="adm-card">
    <div class="adm-card-head">
      <span><i class="bi bi-list-ul me-2"></i>Activity Log - Page <?= $pagination['current_page'] ?? 1 ?> of <?= $pagination['total_pages'] ?? 1 ?></span>
    </div>
    
    <?php if (empty($logs ?? [])): ?>
      <div class="adm-empty">No activity recorded yet.</div>
    <?php else: ?>
    <div style="overflow-x:auto;">
    <table class="adm-table" id="logTable" style="width:100%;">
      <thead>
        <tr>
          <th style="width:60px;">#</th>
          <th style="width:160px;">Action</th>
          <th>Details</th>
          <th style="width:180px;">Performed By</th>
          <th style="width:160px;">Date & Time</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($logs ?? [] as $i => $l): ?>
        <?php $seq = ($pagination['offset'] ?? 0) + $i + 1; ?>
        <tr class="log-row" data-action="<?= htmlspecialchars($l['action'] ?? '') ?>">
          <td style="color:var(--text-primary); font-weight:700;"><?= $seq ?></td>
          <td>
            <?php
              $action = $l['action'] ?? 'Unknown';
              $badgeStyle = match(true) {
                str_contains($action, 'Order Placed')       => 'background:rgba(59,130,246,0.15);border:1px solid rgba(59,130,246,0.4);color:#60a5fa;',
                str_contains($action, 'Order Updated')      => 'background:rgba(139,92,246,0.15);border:1px solid rgba(139,92,246,0.4);color:#a78bfa;',
                str_contains($action, 'Order Cancelled')    => 'background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.4);color:#f87171;',
                str_contains($action, 'Delivery Confirmed') => 'background:rgba(34,197,94,0.15);border:1px solid rgba(34,197,94,0.4);color:#4ade80;',
                str_contains($action, 'Stock Replenished')  => 'background:rgba(20,184,166,0.15);border:1px solid rgba(20,184,166,0.4);color:#2dd4bf;',
                str_contains($action, 'Material Added')     => 'background:rgba(34,197,94,0.15);border:1px solid rgba(34,197,94,0.4);color:#4ade80;',
                str_contains($action, 'Material Updated')   => 'background:rgba(234,179,8,0.15);border:1px solid rgba(234,179,8,0.4);color:#facc15;',
                str_contains($action, 'Material Deleted')   => 'background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.4);color:#f87171;',
                str_contains($action, 'Material Archived')  => 'background:rgba(107,114,128,0.15);border:1px solid rgba(107,114,128,0.4);color:#9ca3af;',
                str_contains($action, 'Material Restored')  => 'background:rgba(34,197,94,0.15);border:1px solid rgba(34,197,94,0.4);color:#4ade80;',
                str_contains($action, 'Item Added to Cart') => 'background:rgba(249,115,22,0.15);border:1px solid rgba(249,115,22,0.4);color:#fb923c;',
                str_contains($action, 'User Deleted')       => 'background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.4);color:#f87171;',
                str_contains($action, 'Login')              => 'background:rgba(59,130,246,0.15);border:1px solid rgba(59,130,246,0.4);color:#60a5fa;',
                default                                     => 'background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.15);color:rgba(255,255,255,0.7);',
              };
            ?>
            <span style="display:inline-block; padding:3px 9px; border-radius:5px; font-size:0.72rem; font-weight:700; white-space:nowrap; <?= $badgeStyle ?>">
              <?= htmlspecialchars($action) ?>
            </span>
          </td>
          <td style="color:var(--text-secondary); font-size:0.82rem; font-weight:600; word-break:break-word;">
            <?= htmlspecialchars($l['details'] ?? '') ?>
          </td>
          <td>
            <div style="font-weight:900; font-size:0.85rem; color:var(--text-primary);"><?= htmlspecialchars($l['user_name'] ?? 'System') ?></div>
            <?php if (!empty($l['client_id'])): ?>
              <div style="font-size:0.7rem; color:var(--text-secondary); font-weight:600;">ID #<?= $l['client_id'] ?></div>
            <?php endif; ?>
          </td>
          <td style="font-size:0.8rem; color:var(--text-primary); font-weight:600; white-space:nowrap;">
            <?= date('M d, Y', strtotime($l['created_at'] ?? 'now')) ?><br>
            <span style="color:var(--text-secondary);"><?= date('H:i:s', strtotime($l['created_at'] ?? 'now')) ?></span>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </div>
    
    <!-- PAGINATION -->
    <?php
    $filterParam = $activeFilter !== '' ? '&filter=' . urlencode($activeFilter) : '';
    if (($pagination['total_pages'] ?? 1) > 1): ?>
    <div class="pagination-wrapper">
      <div class="pagination-info">
        Showing <?= (($pagination['current_page'] - 1) * $pagination['per_page']) + 1 ?> to 
        <?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total_records']) ?> 
        of <?= number_format($pagination['total_records']) ?> entries
      </div>
      
      <div class="pagination-controls">
        <?php if ($pagination['has_previous']): ?>
          <a href="?controller=admin&action=log&page=<?= $pagination['previous_page'] ?><?= $filterParam ?>" class="pagination-btn">
            <i class="bi bi-chevron-left"></i> Previous
          </a>
        <?php else: ?>
          <span class="pagination-btn disabled"><i class="bi bi-chevron-left"></i> Previous</span>
        <?php endif; ?>
        
        <div class="pagination-pages">
          <?php
          $currentPage = $pagination['current_page'];
          $totalPages  = $pagination['total_pages'];
          $startPage   = max(1, $currentPage - 2);
          $endPage     = min($totalPages, $currentPage + 2);
          if ($startPage > 1): ?>
            <a href="?controller=admin&action=log&page=1<?= $filterParam ?>" class="pagination-btn">1</a>
            <?php if ($startPage > 2): ?><span class="pagination-btn disabled">...</span><?php endif; ?>
          <?php endif; ?>
          <?php for ($p = $startPage; $p <= $endPage; $p++): ?>
            <a href="?controller=admin&action=log&page=<?= $p ?><?= $filterParam ?>"
               class="pagination-btn <?= $p === $currentPage ? 'active' : '' ?>"><?= $p ?></a>
          <?php endfor; ?>
          <?php if ($endPage < $totalPages): ?>
            <?php if ($endPage < $totalPages - 1): ?><span class="pagination-btn disabled">...</span><?php endif; ?>
            <a href="?controller=admin&action=log&page=<?= $totalPages ?><?= $filterParam ?>" class="pagination-btn"><?= $totalPages ?></a>
          <?php endif; ?>
        </div>
        
        <?php if ($pagination['has_next']): ?>
          <a href="?controller=admin&action=log&page=<?= $pagination['next_page'] ?><?= $filterParam ?>" class="pagination-btn">
            Next <i class="bi bi-chevron-right"></i>
          </a>
        <?php else: ?>
          <span class="pagination-btn disabled">Next <i class="bi bi-chevron-right"></i></span>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
    
    <?php endif; ?>
  </div>

</div>

<script>
function filterLogs() {
  const q = document.getElementById('logSearch').value.toLowerCase();
  document.querySelectorAll('#logTable tbody .log-row').forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
  if (e.ctrlKey || e.metaKey) {
    <?php if ($pagination['has_previous'] ?? false): ?>
    if (e.key === 'ArrowLeft') {
      e.preventDefault();
      window.location.href = '?controller=admin&action=log&page=<?= $pagination['previous_page'] ?>';
    }
    <?php endif; ?>
    
    <?php if ($pagination['has_next'] ?? false): ?>
    if (e.key === 'ArrowRight') {
      e.preventDefault();
      window.location.href = '?controller=admin&action=log&page=<?= $pagination['next_page'] ?>';
    }
    <?php endif; ?>
  }
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
