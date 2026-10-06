<?php ob_start(); ?>

<?php require __DIR__ . '/admin_style.css.php'; ?>

<div class="adm-wrap">

  <!-- HEADER -->
  <div class="adm-header">
    <div>
      <h1 class="adm-title"><i class="bi bi-clipboard-data-fill"></i> Order Management</h1>
      <p class="adm-sub">Track, update, and manage all customer orders with pagination and filtering.</p>
    </div>
    <div class="adm-header-actions">
      <a href="?controller=admin&action=calendar" class="adm-btn adm-btn-gray">
        <i class="bi bi-calendar3"></i> Delivery Calendar
      </a>
    </div>
  </div>

  <!-- STATUS FILTER TABS -->
  <?php
  $statuses = ['all','pending','confirmed','processing','out_for_delivery','completed','cancelled'];
  $filterStatus = $_GET['status'] ?? 'all';
  $currentPage = $_GET['page'] ?? 1;
  
  // Get all orders for counting
  require_once BASE_PATH . '/app/models/Material.php';
  $_materialForCount = new Material();
  $allOrders = $_materialForCount->allOrders();

  $statusIcons = [
    'all'              => 'bi-grid-fill',
    'pending'          => 'bi-hourglass-split',
    'confirmed'        => 'bi-check-circle',
    'processing'       => 'bi-gear',
    'out_for_delivery' => 'bi-truck',
    'completed'        => 'bi-check-circle-fill',
    'cancelled'        => 'bi-x-circle',
  ];
  ?>

  <style>
  .order-filter-btn {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.75);
    padding: 9px 18px;
    border-radius: 20px;
    font-size: 0.88rem;
    font-weight: 700;
    white-space: nowrap;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: 0.2s ease;
  }
  .order-filter-btn:hover {
    background: rgba(255,215,0,0.15);
    border-color: #FFD700;
    color: #FFD700;
    text-decoration: none;
  }
  .order-filter-btn.active {
    background: #FFD700;
    border-color: #FFD700;
    color: #1a1a1a;
    text-decoration: none;
  }
  .order-filter-btn .filter-count {
    background: rgba(0,0,0,0.15);
    padding: 1px 7px;
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 900;
  }
  .order-filter-btn.active .filter-count {
    background: rgba(0,0,0,0.2);
  }
  </style>

  <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px; align-items:center;">
    <?php foreach ($statuses as $s):
      $cnt = $s === 'all' ? count($allOrders) : count(array_filter($allOrders, fn($o) => ($o['order_status'] ?? '') === $s));
      $icon = $statusIcons[$s] ?? 'bi-circle';
      $label = ucfirst(str_replace('_', ' ', $s));
      $url = '?controller=admin&action=orders&status=' . $s . '&page=1';
      $isActive = $filterStatus === $s;
    ?>
    <a href="<?= $url ?>" class="order-filter-btn <?= $isActive ? 'active' : '' ?>">
      <i class="bi <?= $icon ?>"></i> <?= $label ?>
    </a>
    <?php endforeach; ?>
  </div>

  <!-- PAGINATION INFO -->
  <?php if (!empty($pagination)): ?>
  <div class="adm-card" style="margin-bottom:24px;">
    <div style="padding:16px 24px; display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); flex-wrap:wrap; gap:12px;">
      <div style="color:rgba(255,255,255,0.8); font-size:0.9rem; font-weight:600;">
        Showing <?= (($pagination['current_page'] - 1) * $pagination['per_page']) + 1 ?> to 
        <?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total_orders']) ?> 
        of <?= $pagination['total_orders'] ?> orders
      </div>
      
      <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
        <!-- Previous Button -->
        <?php if ($pagination['has_prev']): ?>
          <a href="?controller=admin&action=orders&status=<?= $filterStatus ?>&page=<?= $pagination['prev_page'] ?>" 
             class="adm-btn adm-btn-gray" style="padding:8px 16px; background:rgba(255,215,0,0.2); border:1px solid #FFD700; color:#FFD700; font-weight:700;">
            <i class="bi bi-chevron-left"></i> Previous
          </a>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php
        $start = max(1, $pagination['current_page'] - 2);
        $end = min($pagination['total_pages'], $pagination['current_page'] + 2);
        
        for ($i = $start; $i <= $end; $i++): ?>
          <a href="?controller=admin&action=orders&status=<?= $filterStatus ?>&page=<?= $i ?>" 
             style="padding:8px 12px; border-radius:6px; font-size:0.85rem; font-weight:700; text-decoration:none; transition:all 0.3s ease;
                    <?= $i == $pagination['current_page'] 
                        ? 'background:#FFD700; color:#1a1a1a; border:1px solid #FFD700;' 
                        : 'background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.8); border:1px solid rgba(255,255,255,0.2);' ?>">
            <?= $i ?>
          </a>
        <?php endfor; ?>

        <!-- Next Button -->
        <?php if ($pagination['has_next']): ?>
          <a href="?controller=admin&action=orders&status=<?= $filterStatus ?>&page=<?= $pagination['next_page'] ?>" 
             class="adm-btn adm-btn-gray" style="padding:8px 16px; background:rgba(255,215,0,0.2); border:1px solid #FFD700; color:#FFD700; font-weight:700;">
            Next <i class="bi bi-chevron-right"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- ORDERS TABLE -->
  <div class="adm-card">
    <div class="adm-card-head" style="background:linear-gradient(135deg, rgba(255,215,0,0.1), rgba(255,176,0,0.05)); border-bottom:2px solid rgba(255,215,0,0.2);">
      <span style="color:#FFD700; font-weight:900; font-size:1.1rem; text-shadow:0 2px 4px rgba(0,0,0,0.3); letter-spacing:0.5px;">
        <i class="bi bi-table me-2"></i>Orders 
        <?php if (!empty($pagination)): ?>
          (Page <?= $pagination['current_page'] ?> of <?= $pagination['total_pages'] ?>)
        <?php endif; ?>
      </span>
    </div>
    
    <?php if (empty($orders)): ?>
      <div class="adm-empty">
        <i class="bi bi-inbox" style="font-size: 3rem; color: rgba(255,255,255,0.3); margin-bottom: 16px; display: block;"></i>
        <h3 style="color: rgba(255,255,255,0.8); margin-bottom: 8px;">No Orders Found</h3>
        <p style="color: rgba(255,255,255,0.6); margin: 0;">No orders match the current filter criteria.</p>
      </div>
    <?php else: ?>
    <div style="padding:16px;">
      <div style="overflow-x: auto; scrollbar-width: none; -ms-overflow-style: none;">
      <style>
        .adm-table-wrap::-webkit-scrollbar { display: none; }
        .adm-table-wrap th, .adm-table-wrap td { padding: 8px 10px; font-size: 0.8rem; }
      </style>
      <table class="adm-table adm-table-wrap" style="width:100%;">
        <thead>
          <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Contact</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Delivery / Arrival</th>
            <th>Ordered</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $i => $o): ?>
          <tr onmouseover="this.style.background='rgba(255,255,255,0.05)';" onmouseout="this.style.background='';">
            <td><strong style="color:var(--text-primary);"><?= $i + 1 ?></strong></td>
            <td>
              <div style="font-weight:800; color:var(--text-primary); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:160px;"><?= htmlspecialchars($o['full_name'] ?? 'N/A') ?></div>
              <div style="color:var(--text-secondary); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:160px;"><?= htmlspecialchars($o['email'] ?? '') ?></div>
              <?php if (!empty($o['address'] ?? '')): ?>
              <div style="color:rgba(255,215,0,0.7); font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:160px;">
                <i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($o['address']) ?>
              </div>
              <?php endif; ?>
            </td>
            <td style="white-space:nowrap; color:var(--text-primary); font-weight:700;"><?= htmlspecialchars($o['contact_number'] ?? '—') ?></td>
            <td style="white-space:nowrap;"><strong style="color:#22c55e;">₱<?= number_format($o['total_amount'] ?? 0, 2) ?></strong></td>
            <td>
              <span class="status-badge status-<?= $o['order_status'] ?? 'pending' ?>" style="font-size:0.7rem; padding:3px 8px; white-space:nowrap;">
                <?= ucfirst(str_replace('_',' ',($o['order_status'] ?? 'pending'))) ?>
              </span>
            </td>
            <td style="white-space:nowrap;">
              <?php 
              $isCompleted = strtolower($o['order_status'] ?? '') === 'completed';
              $fallbackDate = !empty($o['created_at']) ? date('M d, Y', strtotime($o['created_at'])) : date('M d, Y');
              ?>
              <?php if (!empty($o['delivery_date'] ?? '')): ?>
                <div style="color:#16a34a; font-weight:700;"><i class="bi bi-truck me-1"></i><?= date('M d, Y', strtotime($o['delivery_date'])) ?></div>
              <?php elseif ($isCompleted): ?>
                <div style="color:#16a34a; font-weight:700;"><i class="bi bi-truck me-1"></i><?= $fallbackDate ?></div>
              <?php else: ?>
                <div style="color:#666; font-style:italic;">Not scheduled</div>
              <?php endif; ?>
              <?php if (!empty($o['arrival_date'] ?? '')): ?>
                <div style="color:#22c55e; font-weight:700; margin-top:2px;"><i class="bi bi-check2 me-1"></i><?= date('M d, Y', strtotime($o['arrival_date'])) ?></div>
              <?php elseif ($isCompleted): ?>
                <div style="color:#22c55e; font-weight:700; margin-top:2px;"><i class="bi bi-check2 me-1"></i><?= $fallbackDate ?></div>
              <?php else: ?>
                <div style="color:#666; font-style:italic;">Not arrived</div>
              <?php endif; ?>
              <?php if (!empty($o['user_confirmed_delivery'] ?? false)): ?>
                <div style="color:#22c55e; font-size:0.68rem; font-weight:800;"><i class="bi bi-check-circle-fill"></i> Confirmed</div>
              <?php endif; ?>
            </td>
            <td style="white-space:nowrap; color:var(--text-primary); font-weight:700;">
              <?= date('M d, Y', strtotime($o['created_at'] ?? '')) ?>
              <div style="color:var(--text-secondary);"><?= date('H:i', strtotime($o['created_at'] ?? '')) ?></div>
            </td>
            <td style="white-space:nowrap;">
              <?php
                $status = strtolower($o['order_status'] ?? 'pending');
                $locked = in_array($status, ['cancelled', 'completed']);
              ?>
              <?php if ($locked): ?>
                <span class="status-badge status-<?= $status ?>" style="padding:6px 12px; font-size:0.78rem;">
                  <?= $status === 'completed' ? '<i class="bi bi-check-circle-fill me-1"></i> Completed' : '<i class="bi bi-x-circle-fill me-1"></i> Cancelled' ?>
                </span>
              <?php else: ?>
              <button class="adm-btn adm-btn-blue" style="padding:6px 12px; font-size:0.78rem;"
                onclick="openUpdateModal(<?= $o['order_id'] ?? 0 ?>, '<?= $o['order_status'] ?? 'pending' ?>', '<?= $o['delivery_date'] ?? '' ?>', '<?= $o['arrival_date'] ?? '' ?>', '<?= $o['created_at'] ?? '' ?>')">
                <i class="bi bi-pencil-fill"></i> Update
              </button>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <!-- BOTTOM PAGINATION -->
  <?php if (!empty($pagination) && $pagination['total_pages'] > 1): ?>
  <div class="adm-card" style="margin-top:24px;">
    <div style="padding:16px 24px; display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); flex-wrap:wrap; gap:12px;">
      <div style="color:rgba(255,255,255,0.8); font-size:0.9rem; font-weight:600;">
        Page <?= $pagination['current_page'] ?> of <?= $pagination['total_pages'] ?>
      </div>
      
      <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
        <!-- Previous Button -->
        <?php if ($pagination['has_prev']): ?>
          <a href="?controller=admin&action=orders&status=<?= $filterStatus ?>&page=<?= $pagination['prev_page'] ?>" 
             class="adm-btn adm-btn-gray" style="padding:8px 16px; background:rgba(255,215,0,0.2); border:1px solid #FFD700; color:#FFD700; font-weight:700;">
            <i class="bi bi-chevron-left"></i> Previous
          </a>
        <?php endif; ?>

        <!-- Next Button -->
        <?php if ($pagination['has_next']): ?>
          <a href="?controller=admin&action=orders&status=<?= $filterStatus ?>&page=<?= $pagination['next_page'] ?>" 
             class="adm-btn adm-btn-gray" style="padding:8px 16px; background:rgba(255,215,0,0.2); border:1px solid #FFD700; color:#FFD700; font-weight:700;">
            Next <i class="bi bi-chevron-right"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>

</div>

<!-- UPDATE ORDER MODAL -->
<div class="adm-modal-overlay" id="updateModal">
  <div class="adm-modal">
    <button class="adm-modal-close" onclick="closeModal('updateModal')"><i class="bi bi-x-lg"></i></button>
    <h3 style="color:#FFD700; font-weight:900; font-size:1.3rem; text-shadow:0 2px 4px rgba(0,0,0,0.3); letter-spacing:0.5px;">
      <i class="bi bi-pencil-fill me-2"></i>Update Order
    </h3>
    <form method="POST" action="?controller=admin&action=updateOrder">
      <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">
      <input type="hidden" name="order_id" id="upd_order_id">

      <div class="adm-form-group">
        <label>Order Status</label>
        <select class="adm-input" name="status" id="upd_status"
                style="background:#1a1a1a;color:#fff;border:2px solid #FFD700;"
                onchange="toggleDateFields(this.value)">
          <option value="pending">Pending</option>
          <option value="confirmed">Confirmed</option>
          <option value="processing">Processing</option>
          <option value="out_for_delivery">Out for Delivery</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>
      </div>

      <!-- Date fields — only shown when Out for Delivery is selected -->
      <div id="upd_date_fields" style="display:none;">
        <div style="background:rgba(255,215,0,0.08);border:1px solid rgba(255,215,0,0.25);border-radius:8px;padding:10px 14px;margin-bottom:14px;font-size:0.8rem;font-weight:700;color:#FFD700;">
          <i class="bi bi-calendar-date me-2"></i>Set the scheduled delivery and arrival dates.
        </div>
        <div class="adm-form-group">
          <label>Delivery Date</label>
          <input class="adm-input" type="date" name="delivery_date" id="upd_delivery_date">
          <small id="delivery_hint" style="color:#FFD700;font-weight:700;font-size:0.78rem;margin-top:4px;display:block;"></small>
        </div>
        <div class="adm-form-group">
          <label>Arrival Date <small style="color:#666;">(When items actually arrived)</small></label>
          <input class="adm-input" type="date" name="arrival_date" id="upd_arrival_date">
          <small id="arrival_hint" style="color:#aaa;font-weight:600;font-size:0.78rem;margin-top:4px;display:block;"></small>
        </div>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px;">
        <button type="button" class="adm-btn adm-btn-gray" onclick="closeModal('updateModal')">Cancel</button>
        <button type="submit" class="adm-btn adm-btn-green"><i class="bi bi-check-lg"></i> Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

function toggleDateFields(status) {
  const show = status === 'pending' || status === 'confirmed';
  document.getElementById('upd_date_fields').style.display = show ? 'block' : 'none';
}

function openUpdateModal(orderId, status, deliveryDate, arrivalDate, orderDate) {
  document.getElementById('upd_order_id').value = orderId;
  document.getElementById('upd_status').value   = status;

  // Show date fields only if out_for_delivery
  toggleDateFields(status);

  // Calculate estimated arrival window (6–8 business days, skip Sundays)
  function addBusinessDays(startDate, days) {
    const d = new Date(startDate);
    let added = 0;
    while (added < days) {
      d.setDate(d.getDate() + 1);
      if (d.getDay() !== 0) added++; // skip Sunday
    }
    return d;
  }

  function toYMD(d) {
    return d.toISOString().split('T')[0];
  }

  function formatDate(d) {
    return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
  }

  const base = orderDate ? new Date(orderDate) : new Date();
  const estStart = addBusinessDays(base, 3);
  const estEnd   = addBusinessDays(base, 8);

  const estStartYMD = toYMD(estStart);
  const estEndYMD   = toYMD(estEnd);

  // Set delivery date: pre-fill with estimated start if not already set
  const deliveryInput = document.getElementById('upd_delivery_date');
  deliveryInput.value = deliveryDate || estStartYMD;
  deliveryInput.min   = estStartYMD;
  deliveryInput.max   = estEndYMD;

  document.getElementById('delivery_hint').textContent =
    `Estimated window: ${formatDate(estStart)} – ${formatDate(estEnd)} (Mon–Sat only)`;

  // Arrival date: same estimated window as delivery, min = estimated start
  const arrivalInput = document.getElementById('upd_arrival_date');
  arrivalInput.value = arrivalDate || estStartYMD;
  arrivalInput.min   = estStartYMD;
  arrivalInput.max   = estEndYMD;

  document.getElementById('arrival_hint').textContent =
    `Estimated window: ${formatDate(estStart)} – ${formatDate(estEnd)} (Mon–Sat only)`;

  // Keep arrival min in sync when delivery date changes
  deliveryInput.onchange = function() {
    arrivalInput.min = this.value || estStartYMD;
  };

  openModal('updateModal');
}

document.querySelectorAll('.adm-modal-overlay').forEach(o => {
  o.addEventListener('click', function(e) { if (e.target === this) this.classList.remove('open'); });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>