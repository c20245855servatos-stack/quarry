<?php ob_start();

// Build calendar data
$month = (int) ($_GET['month'] ?? date('n'));
$year  = (int) ($_GET['year']  ?? date('Y'));

if ($month < 1)  { $month = 12; $year--; }
if ($month > 12) { $month = 1;  $year++; }

$prevMonth = $month - 1; $prevYear = $year;
if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }
$nextMonth = $month + 1; $nextYear = $year;
if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }

$firstDay   = (int) date('w', mktime(0,0,0,$month,1,$year));
$daysInMonth = (int) date('t', mktime(0,0,0,$month,1,$year));

// Index deliveries by date
$deliveryMap = [];
foreach ($deliveries ?? [] as $d) {
    if (!empty($d['delivery_date'] ?? '')) {
        $deliveryMap[$d['delivery_date']][] = $d;
    }
}

// Daily limit
define('DAILY_DELIVERY_LIMIT', 5);
?>

<?php require __DIR__ . '/admin_style.css.php'; ?>

<div class="adm-wrap">

  <!-- HEADER -->
  <div class="adm-header">
    <div>
      <h1 class="adm-title"><i class="bi bi-calendar3"></i> Delivery Calendar</h1>
      <p class="adm-sub">Visual overview of all scheduled deliveries.</p>
    </div>
    <div class="adm-header-actions">
      <a href="?controller=admin&action=orders" class="adm-btn adm-btn-gray">
        <i class="bi bi-arrow-left"></i> Back to Orders
      </a>
    </div>
  </div>

  <!-- LEGEND -->
  <div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:24px; padding:16px; background:rgba(255,255,255,0.05); border-radius:12px; border:1px solid rgba(255,215,0,0.2);">
    <span style="display:flex;align-items:center;gap:8px;font-size:0.9rem;color:var(--text-primary);font-weight:700;">
      <span style="width:16px;height:16px;border-radius:4px;background:linear-gradient(135deg, #3b82f6, #2563eb);border:1px solid #2563eb;display:inline-block;box-shadow:0 2px 4px rgba(59,130,246,0.3);"></span> Active
    </span>
    <span style="display:flex;align-items:center;gap:8px;font-size:0.9rem;color:var(--text-primary);font-weight:700;">
      <span style="width:16px;height:16px;border-radius:4px;background:linear-gradient(135deg, #22c55e, #16a34a);border:1px solid #16a34a;display:inline-block;box-shadow:0 2px 4px rgba(34,197,94,0.3);"></span> Completed
    </span>
  </div>

  <!-- CALENDAR CARD -->
  <div class="adm-card">
    <!-- NAV -->
    <div class="adm-card-head" style="background:linear-gradient(135deg, rgba(255,215,0,0.1), rgba(255,176,0,0.05)); border-bottom:2px solid rgba(255,215,0,0.2); flex-wrap:nowrap; align-items:center;">
      <a href="?controller=admin&action=calendar&month=<?= $prevMonth ?>&year=<?= $prevYear ?>"
         class="adm-btn adm-btn-gray" style="padding:8px 12px; background:rgba(255,215,0,0.2); border:1px solid #FFD700; color:#FFD700; font-weight:700; flex-shrink:0;">
        <i class="bi bi-chevron-left"></i>
      </a>
      <h3 style="margin:0; font-size:clamp(1rem,4vw,1.3rem); font-weight:900; color:#FFD700; text-shadow:0 2px 4px rgba(0,0,0,0.3); letter-spacing:0.5px; text-align:center; flex:1;">
        <?= date('F Y', mktime(0,0,0,$month,1,$year)) ?>
      </h3>
      <a href="?controller=admin&action=calendar&month=<?= $nextMonth ?>&year=<?= $nextYear ?>"
         class="adm-btn adm-btn-gray" style="padding:8px 12px; background:rgba(255,215,0,0.2); border:1px solid #FFD700; color:#FFD700; font-weight:700; flex-shrink:0;">
        <i class="bi bi-chevron-right"></i>
      </a>
    </div>

    <div style="padding:16px; overflow-x:auto; -webkit-overflow-scrolling:touch;">
      <div class="cal-grid" style="min-width:560px;">
        <?php foreach (['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d): ?>
          <div class="cal-day-header"><?= $d ?></div>
        <?php endforeach; ?>

        <!-- EMPTY CELLS BEFORE FIRST DAY -->
        <?php for ($i = 0; $i < $firstDay; $i++): ?>
          <div class="cal-day other-month"></div>
        <?php endfor; ?>

        <!-- DAYS -->
        <?php
        $today = date('Y-m-d');
        for ($day = 1; $day <= $daysInMonth; $day++):
          $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
          $isToday = $dateStr === $today;
          $dayDeliveries = $deliveryMap[$dateStr] ?? [];
          $count = count($dayDeliveries);
          $isFull = $count >= DAILY_DELIVERY_LIMIT;
        ?>
          <div class="cal-day <?= $isToday ? 'today' : '' ?> <?= $count > 0 ? 'has-events' : '' ?>"
               <?php if ($count > 0): ?>
               onclick="showDayModal('<?= $dateStr ?>', <?= htmlspecialchars(json_encode(array_map(fn($d) => [
                 'id'     => $d['order_id'] ?? $d['id'] ?? 'N/A',
                 'name'   => $d['full_name'] ?? 'N/A',
                 'amount' => number_format($d['total_amount'] ?? 0, 2),
                 'status' => $d['order_status'] ?? $d['status'] ?? 'pending',
               ], $dayDeliveries)), ENT_QUOTES) ?>)"
               style="cursor:pointer;"
               <?php endif; ?>>
            <div class="cal-day-num"><?= $day ?></div>
            <?php if ($count > 0): ?>
            <div style="
                font-size:0.65rem; font-weight:900; text-align:center; margin-bottom:3px;
                color: <?= $isFull ? '#dc2626' : '#16a34a' ?>;
                background: <?= $isFull ? 'rgba(239,68,68,0.15)' : 'rgba(34,197,94,0.15)' ?>;
                border-radius:4px; padding:1px 4px;
            ">
                <?= $count ?>/<?= DAILY_DELIVERY_LIMIT ?> <?= $isFull ? '<i class="bi bi-x-circle-fill text-danger"></i> FULL' : '<i class="bi bi-check-circle-fill text-success"></i>' ?>
            </div>
            <?php endif; ?>
            <?php foreach ($dayDeliveries as $del): ?>
              <div class="cal-event status-<?= $del['order_status'] ?? $del['status'] ?? 'pending' ?>"
                   title="Order #<?= $del['order_id'] ?? $del['id'] ?? 'N/A' ?> — <?= htmlspecialchars($del['full_name'] ?? '') ?> — ₱<?= number_format($del['total_amount'] ?? 0,2) ?>">
                #<?= $del['order_id'] ?? $del['id'] ?? 'N/A' ?> <?= htmlspecialchars(mb_strimwidth($del['full_name'] ?? '', 0, 10, '…')) ?>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endfor; ?>

        <!-- FILL REMAINING CELLS -->
        <?php
        $totalCells = $firstDay + $daysInMonth;
        $remainder  = $totalCells % 7;
        if ($remainder > 0):
          for ($i = 0; $i < (7 - $remainder); $i++):
        ?>
          <div class="cal-day other-month"></div>
        <?php endfor; endif; ?>
      </div>
    </div>
  </div>

  <!-- UPCOMING DELIVERIES LIST -->
  <div class="adm-card" style="margin-top:24px;">
    <div class="adm-card-head">
      <span><i class="bi bi-list-check me-2"></i>Upcoming Deliveries</span>
      <span style="font-size:0.8rem; color:var(--text-secondary); font-weight:700;">
        <i class="bi bi-info-circle me-1"></i>Max <?= DAILY_DELIVERY_LIMIT ?> orders per day
      </span>
    </div>
    <?php
    $upcoming = array_filter($deliveries ?? [], function($d) {
        return !empty($d['delivery_date'] ?? '') && ($d['delivery_date'] ?? '') >= date('Y-m-d') && (($d['status'] ?? null) !== 'cancelled');
    });
    usort($upcoming, fn($a,$b) => strcmp($b['delivery_date'] ?? '', $a['delivery_date'] ?? ''));
    $upcoming = array_values($upcoming);

    // Pagination
    $upPerPage   = 10;
    $upTotal     = count($upcoming);
    $upTotalPages = max(1, (int)ceil($upTotal / $upPerPage));
    $upPage      = max(1, min($upTotalPages, (int)($_GET['up_page'] ?? 1)));
    $upOffset    = ($upPage - 1) * $upPerPage;
    $upSlice     = array_slice($upcoming, $upOffset, $upPerPage);
    $upFrom      = $upTotal > 0 ? $upOffset + 1 : 0;
    $upTo        = min($upOffset + $upPerPage, $upTotal);
    ?>
    <?php if (empty($upcoming)): ?>
      <div class="adm-empty">No upcoming deliveries scheduled.</div>
    <?php else: ?>
    <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
    <table class="adm-table" style="min-width:480px;">
      <thead><tr><th>Order #</th><th>Customer</th><th>Amount</th><th>Status</th><th>Delivery Date</th></tr></thead>
      <tbody>
      <?php foreach ($upSlice as $i => $d): ?>
        <tr>
          <td><strong><?= $i + 1 ?></strong></td>
          <td style="color:var(--text-primary); font-weight:700;"><?= htmlspecialchars($d['full_name'] ?? 'N/A') ?></td>
          <td style="color:#22c55e; font-weight:900;">₱<?= number_format($d['total_amount'] ?? 0, 2) ?></td>
          <td><span class="status-badge status-<?= $d['order_status'] ?? $d['status'] ?? 'pending' ?>"><?= ucfirst(str_replace('_',' ', $d['order_status'] ?? $d['status'] ?? 'pending')) ?></span></td>
          <td style="color:#ffffff; font-weight:900;">
            <?php
            $dDate = strtotime($d['delivery_date'] ?? 'now');
            $diff  = (int) floor(($dDate - time()) / 86400);
            $label = $diff === 0 ? '<span style="color:#fbbf24;font-weight:900;">Today</span>'
                   : ($diff === 1 ? '<span style="color:#ef4444;font-weight:900;">Tomorrow</span>'
                   : '<span style="color:#ffffff;font-weight:700;">'.date('M d, Y', $dDate).'</span>');
            echo $label;
            ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <div style="display:flex; align-items:center; justify-content:space-between; padding:14px 20px; background:rgba(255,255,255,0.03); border-top:1px solid rgba(255,215,0,0.15); flex-wrap:wrap; gap:12px;">
      <span style="color:var(--text-secondary); font-size:0.9rem; font-weight:600;">
        Showing <?= $upFrom ?> to <?= $upTo ?> of <?= $upTotal ?> order<?= $upTotal !== 1 ? 's' : '' ?>
      </span>
      <div style="display:flex; align-items:center; gap:6px;">
        <?php
        $baseUrl = '?controller=admin&action=calendar&month=' . $month . '&year=' . $year;
        $startPage = max(1, $upPage - 2);
        $endPage   = min($upTotalPages, $upPage + 2);
        ?>

        <?php if ($upPage > 1): ?>
          <a href="<?= $baseUrl ?>&up_page=<?= $upPage - 1 ?>"
             style="padding:7px 14px; background:rgba(255,215,0,0.15); border:1px solid #FFD700; color:#FFD700; border-radius:6px; font-weight:700; font-size:0.85rem; text-decoration:none; display:flex; align-items:center; gap:4px;">
            <i class="bi bi-chevron-left"></i> Prev
          </a>
        <?php endif; ?>

        <?php if ($startPage > 1): ?>
          <a href="<?= $baseUrl ?>&up_page=1" style="padding:7px 12px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.15); color:var(--text-primary); border-radius:6px; font-weight:700; font-size:0.85rem; text-decoration:none;">1</a>
          <?php if ($startPage > 2): ?><span style="color:var(--text-secondary); padding:0 4px;">…</span><?php endif; ?>
        <?php endif; ?>

        <?php for ($p = $startPage; $p <= $endPage; $p++): ?>
          <a href="<?= $baseUrl ?>&up_page=<?= $p ?>"
             style="padding:7px 12px; background:<?= $p === $upPage ? '#FFD700' : 'rgba(255,255,255,0.05)' ?>; border:1px solid <?= $p === $upPage ? '#FFD700' : 'rgba(255,255,255,0.15)' ?>; color:<?= $p === $upPage ? '#1a1a1a' : 'var(--text-primary)' ?>; border-radius:6px; font-weight:<?= $p === $upPage ? '900' : '700' ?>; font-size:0.85rem; text-decoration:none;">
            <?= $p ?>
          </a>
        <?php endfor; ?>

        <?php if ($endPage < $upTotalPages): ?>
          <?php if ($endPage < $upTotalPages - 1): ?><span style="color:var(--text-secondary); padding:0 4px;">…</span><?php endif; ?>
          <a href="<?= $baseUrl ?>&up_page=<?= $upTotalPages ?>" style="padding:7px 12px; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.15); color:var(--text-primary); border-radius:6px; font-weight:700; font-size:0.85rem; text-decoration:none;"><?= $upTotalPages ?></a>
        <?php endif; ?>

        <?php if ($upPage < $upTotalPages): ?>
          <a href="<?= $baseUrl ?>&up_page=<?= $upPage + 1 ?>"
             style="padding:7px 14px; background:rgba(255,215,0,0.15); border:1px solid #FFD700; color:#FFD700; border-radius:6px; font-weight:700; font-size:0.85rem; text-decoration:none; display:flex; align-items:center; gap:4px;">
            Next <i class="bi bi-chevron-right"></i>
          </a>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>

</div>

<!-- DAY EVENTS MODAL -->
<div id="dayModal" style="
  display:none; position:fixed; inset:0; z-index:9999;
  background:rgba(0,0,0,0.7); backdrop-filter:blur(4px);
  align-items:center; justify-content:center;
" onclick="if(event.target===this) closeDayModal()">
  <div style="
    background:#1a1a1a; border:2px solid #FFD700; border-radius:16px;
    padding:28px; width:90%; max-width:480px; max-height:80vh;
    overflow-y:auto; position:relative;
    animation: modalPop 0.25s cubic-bezier(0.34,1.56,0.64,1);
  ">
    <button onclick="closeDayModal()" style="
      position:absolute; top:14px; right:14px;
      background:rgba(255,255,255,0.1); border:none; color:#fff;
      width:30px; height:30px; border-radius:50%; cursor:pointer;
      font-size:1rem; display:flex; align-items:center; justify-content:center;
    "><i class="bi bi-x"></i></button>

    <h5 id="modalDate" style="color:#FFD700; font-weight:900; margin:0 0 16px; font-size:1.1rem;">
      <i class="bi bi-calendar3 me-2"></i>
    </h5>

    <div id="modalBody"></div>
  </div>
</div>

<style>
@keyframes modalPop {
  from { opacity:0; transform:scale(0.85) translateY(20px); }
  to   { opacity:1; transform:scale(1) translateY(0); }
}
.cal-day.has-events:hover {
  border-color: #FFD700 !important;
}
.modal-order-row {
  display:flex; align-items:center; justify-content:space-between;
  padding:10px 14px; border-radius:10px; margin-bottom:8px;
  border:1px solid rgba(255,255,255,0.1);
  background:rgba(255,255,255,0.05);
  transition:0.2s ease;
}
.modal-order-row:hover { background:rgba(255,215,0,0.08); border-color:rgba(255,215,0,0.3); }
.modal-status { padding:3px 10px; border-radius:20px; font-size:0.72rem; font-weight:900; text-transform:uppercase; }
.modal-status.pending   { background:rgba(251,191,36,0.2);  color:#fbbf24; }
.modal-status.active    { background:rgba(59,130,246,0.2);  color:#60a5fa; }
.modal-status.completed { background:rgba(34,197,94,0.2);   color:#4ade80; }
.modal-status.cancelled { background:rgba(239,68,68,0.2);   color:#f87171; }
</style>

<script>
const statusColors = {
  pending:   'pending',
  active:    'active',
  completed: 'completed',
  cancelled: 'cancelled',
};

function showDayModal(dateStr, orders) {
  const modal = document.getElementById('dayModal');
  const modalDate = document.getElementById('modalDate');
  const modalBody = document.getElementById('modalBody');

  // Format date nicely
  const d = new Date(dateStr + 'T00:00:00');
  const formatted = d.toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
  modalDate.innerHTML = `<i class="bi bi-calendar3 me-2"></i>${formatted} <span style="color:rgba(255,255,255,0.5); font-size:0.85rem;">(${orders.length} order${orders.length !== 1 ? 's' : ''})</span>`;

  // Build order rows
  modalBody.innerHTML = orders.map(o => `
    <div class="modal-order-row">
      <div>
        <div style="font-weight:900; color:#fff; font-size:0.95rem;">#${o.id} — ${o.name}</div>
        <div style="color:rgba(255,255,255,0.5); font-size:0.8rem; margin-top:2px;">₱${o.amount}</div>
      </div>
      <span class="modal-status ${statusColors[o.status] || 'pending'}">${o.status}</span>
    </div>
  `).join('');

  modal.style.display = 'flex';
}

function closeDayModal() {
  document.getElementById('dayModal').style.display = 'none';
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDayModal(); });
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
