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
  <div class="adm-stats" style="margin-bottom:24px; grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
      <div class="stat-icon green"><i class="bi bi-people-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= count($users ?? []) ?></div>
        <div class="stat-lbl">Total Users</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon yellow"><i class="bi bi-shield-fill"></i></div>
      <div class="stat-body">
        <div class="stat-num"><?= count(array_filter($users ?? [], fn($u) => $u['is_admin'] ?? false)) ?></div>
        <div class="stat-lbl">Admins</div>
      </div>
    </div>
    <div class="stat-card">
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
        <tr>
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
          <td style="color:var(--text-primary); font-size:0.82rem; max-width:160px; font-weight:700;">
            <?= htmlspecialchars(mb_strimwidth($u['address'] ?? '', 0, 40, '…')) ?>
          </td>
          <td>
            <?php if ($u['is_admin'] ?? false): ?>
              <span class="status-badge" style="background:rgba(255,193,7,0.15);border:1px solid rgba(255,193,7,0.35);color:#ffc107;">
                <i class="bi bi-patch-check-fill"></i> Admin
              </span>
            <?php else: ?>
              <span class="status-badge" style="background:rgba(59,130,246,0.15);border:1px solid rgba(59,130,246,0.3);color:#60a5fa;">
                Member
              </span>
            <?php endif; ?>
          </td>
          <td>
            <?php if (!($u['is_admin'] ?? false)): ?>
            <form method="POST" action="?controller=admin&action=deleteUser" style="margin:0;"
                  onsubmit="return confirm('Delete user <?= htmlspecialchars(addslashes($u['full_name'] ?? ''), ENT_QUOTES) ?>?')">
              <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">
              <input type="hidden" name="id" value="<?= (int)($u['client_id'] ?? 0) ?>">
              <button type="submit" class="adm-btn adm-btn-red" style="padding:6px 12px; font-size:0.8rem;">
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

<script>
function filterUsers() {
  const q = document.getElementById('userSearch').value.toLowerCase();
  document.querySelectorAll('#userTable tbody tr').forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
