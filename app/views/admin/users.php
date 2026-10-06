<?php ob_start(); ?>

<?php require __DIR__ . '/admin_style.css.php'; ?>

<div class="adm-wrap">

  <!-- HEADER -->
  <div class="adm-header">
    <div>
      <h1 class="adm-title"><i class="bi bi-people-fill"></i> User Management</h1>
      <p class="adm-sub">View and manage all registered users.</p>
    </div>
    <div class="adm-header-actions">
      <span class="adm-date"><?= count($users ?? []) ?> users total</span>
    </div>
  </div>

  <!-- STATS -->
  <style>
  .stat-card-clickable { cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease; border: 2px solid transparent; user-select: none; }
  .stat-card-clickable:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.4); }
  .stat-card-clickable.filter-active-card { border-color: #FFD700; box-shadow: 0 0 0 3px rgba(255,215,0,0.2); }
  </style>
  <div class="adm-stats usr-stats-grid" style="margin-bottom:24px;">
  <style>
  .usr-stats-grid { grid-template-columns: repeat(3, 1fr); }
  @media (max-width: 575px) {
    .usr-stats-grid { grid-template-columns: 1fr; }
    .usr-stats-grid .stat-card { flex-direction: row; align-items: center; }
    .usr-stats-grid .stat-num { font-size: 1.4rem; }
    .usr-stats-grid .stat-lbl { font-size: 0.72rem; white-space: normal; }
  }
  </style>
    <div class="stat-card stat-card-clickable filter-active-card" id="ustatAll" onclick="setUserFilter('all', this)">
      <div class="stat-icon green"><i class="bi bi-people-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= count($users ?? []) ?></div>
        <div class="stat-lbl">Total Users</div>
      </div>
    </div>
    <div class="stat-card stat-card-clickable" id="ustatAdmin" onclick="setUserFilter('admin', this)">
      <div class="stat-icon yellow"><i class="bi bi-shield-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= count(array_filter($users ?? [], fn($u) => $u['is_admin'] ?? false)) ?></div>
        <div class="stat-lbl">Admins</div>
      </div>
    </div>
    <div class="stat-card stat-card-clickable" id="ustatRegular" onclick="setUserFilter('regular', this)">
      <div class="stat-icon blue"><i class="bi bi-person-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= count(array_filter($users ?? [], fn($u) => !($u['is_admin'] ?? false))) ?></div>
        <div class="stat-lbl">Regular Users</div>
      </div>
    </div>
  </div>

  <!-- SEARCH -->
  <div class="adm-search">
    <input class="adm-input" type="text" id="userSearch" placeholder="Search users..." oninput="filterUsers()" style="max-width:320px;">
  </div>

  <!-- TABLE -->
  <div class="adm-card">
    <div class="adm-card-head">
      <span><i class="bi bi-table me-2"></i>All Users</span>
    </div>
    <?php if (empty($users ?? [])): ?>
      <div class="adm-empty">No users found.</div>
    <?php else: ?>
    <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
    <table class="adm-table" id="userTable" style="min-width:600px;">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Address</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users ?? [] as $u): ?>
        <tr data-role="<?= ($u['is_admin'] ?? false) ? 'admin' : 'regular' ?>">
          <td style="color:var(--text-primary); font-weight:700;"><?= $u['client_id'] ?? 'N/A' ?></td>
          <td>
            <div style="display:flex; align-items:center; gap:10px;">
              <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#1C6758,#28a745);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.85rem;flex-shrink:0;">
                <?= strtoupper(substr($u['full_name'] ?? 'U', 0, 1)) ?>
              </div>
              <strong style="color:var(--text-primary);"><?= htmlspecialchars($u['full_name'] ?? '') ?></strong>
            </div>
          </td>
          <td style="color:var(--text-primary); font-size:0.88rem; font-weight:700;"><?= htmlspecialchars($u['email'] ?? '') ?></td>
          <td style="color:var(--text-primary); font-size:0.85rem; font-weight:700;"><?= htmlspecialchars($u['contact_number'] ?? '—') ?></td>
          <td style="color:var(--text-primary); font-size:0.82rem; max-width:180px; font-weight:700;">
            <?php
              $addr = $u['address'] ?? '';
              $uid  = 'addr_' . ($u['client_id'] ?? 0);
              $short = mb_strimwidth($addr, 0, 40, '');
              $needsMore = mb_strlen($addr) > 40;
            ?>
            <?php if ($needsMore): ?>
              <span id="<?= $uid ?>_short"><?= htmlspecialchars($short) ?>…
                <button onclick="document.getElementById('<?= $uid ?>_short').style.display='none';document.getElementById('<?= $uid ?>_full').style.display='inline';"
                  style="background:none;border:none;color:#FFD700;font-size:0.75rem;font-weight:800;cursor:pointer;padding:0;text-decoration:underline;">
                  see more
                </button>
              </span>
              <span id="<?= $uid ?>_full" style="display:none;"><?= htmlspecialchars($addr) ?>
                <button onclick="document.getElementById('<?= $uid ?>_full').style.display='none';document.getElementById('<?= $uid ?>_short').style.display='inline';"
                  style="background:none;border:none;color:#FFD700;font-size:0.75rem;font-weight:800;cursor:pointer;padding:0;text-decoration:underline;">
                  see less
                </button>
              </span>
            <?php else: ?>
              <?= htmlspecialchars($addr ?: '—') ?>
            <?php endif; ?>
          </td>
          <td>
            <?php if ($u['is_admin'] ?? false): ?>
              <span class="status-badge status-admin">
                <i class="bi bi-patch-check-fill"></i> Admin
              </span>
            <?php else: ?>
              <span class="status-badge status-member">
                Member
              </span>
            <?php endif; ?>
          </td>
          <td>
            <?php if (!($u['is_admin'] ?? false)): ?>
            <form method="POST" action="?controller=admin&action=deleteUser" style="margin:0;" id="deleteForm_<?= (int)($u['client_id'] ?? 0) ?>">
              <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">
              <input type="hidden" name="id" value="<?= (int)($u['client_id'] ?? 0) ?>">
              <button type="button"
                class="adm-btn adm-btn-red"
                style="padding:6px 12px; font-size:0.8rem;"
                onclick="openDeleteModal(<?= (int)($u['client_id'] ?? 0) ?>, '<?= htmlspecialchars(addslashes($u['full_name'] ?? 'this user'), ENT_QUOTES) ?>')">
                <i class="bi bi-trash-fill"></i> Delete
              </button>
            </form>
            <?php else: ?>
            <span style="font-size:0.78rem; color:var(--text-secondary); font-weight:700;">Protected</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <?php endif; ?>
  </div>

</div>

<!-- ── Custom Delete Confirmation Modal ── -->
<div class="sys-modal-overlay" id="deleteModalOverlay">
  <div class="sys-modal">
    <div class="sys-modal-icon red"><i class="bi bi-person-x-fill"></i></div>
    <div class="sys-modal-title">Delete User</div>
    <div class="sys-modal-msg">You are about to permanently delete <strong id="deleteUserName"></strong>. This action cannot be undone.</div>
    <div class="sys-modal-btns">
      <button class="sys-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
      <button class="sys-btn-red" onclick="submitDeleteForm()">
        <i class="bi bi-trash-fill"></i> Delete
      </button>
    </div>
  </div>
</div>

<script>
let pendingDeleteId = null;

function openDeleteModal(userId, userName) {
  pendingDeleteId = userId;
  document.getElementById('deleteUserName').textContent = userName;
  document.getElementById('deleteModalOverlay').classList.add('open');
}

function closeDeleteModal() {
  pendingDeleteId = null;
  document.getElementById('deleteModalOverlay').classList.remove('open');
}

function submitDeleteForm() {
  if (pendingDeleteId !== null) {
    document.getElementById('deleteForm_' + pendingDeleteId).submit();
  }
}

// Close on backdrop click
document.getElementById('deleteModalOverlay').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteModal();
});

// Close on Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeDeleteModal();
});

let currentUserFilter = 'all';

function filterUsers() {
  const q = document.getElementById('userSearch').value.toLowerCase();
  document.querySelectorAll('#userTable tbody tr').forEach(row => {
    const matchesSearch = row.textContent.toLowerCase().includes(q);
    const role = row.dataset.role;
    const matchesFilter = currentUserFilter === 'all' ||
                          (currentUserFilter === 'admin'   && role === 'admin') ||
                          (currentUserFilter === 'regular' && role === 'regular');
    row.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
  });
}

function setUserFilter(filter, clickedEl) {
  currentUserFilter = filter;
  ['ustatAll','ustatAdmin','ustatRegular'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.classList.remove('filter-active-card');
  });
  if (clickedEl) clickedEl.classList.add('filter-active-card');
  filterUsers();
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
