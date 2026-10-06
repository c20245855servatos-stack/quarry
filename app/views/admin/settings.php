<?php ob_start();
$user = $_SESSION['user'] ?? null;
?>

<?php require __DIR__ . '/admin_style.css.php'; ?>

<style>
.settings-wrap {
  max-width: 700px;
  margin: 0 auto;
  padding: 0 16px 40px;
}

/* ── Page Header ── */
.settings-page-header {
  text-align: center;
  margin-bottom: 32px;
  padding-bottom: 22px;
  border-bottom: 1px solid rgba(255,255,255,0.08);
}
.settings-page-header h1 {
  font-size: 1.55rem;
  font-weight: 900;
  color: #fff;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  margin: 0 0 7px;
}
.settings-page-header p {
  font-size: 0.88rem;
  color: rgba(255,255,255,0.5);
  margin: 0;
  font-weight: 600;
}

/* ── Cards ── */
.s-card {
  background: rgba(255,255,255,0.04);
  border: 1px solid rgba(255,255,255,0.09);
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 16px;
}
.s-card-head {
  padding: 15px 22px;
  background: rgba(255,255,255,0.04);
  border-bottom: 1px solid rgba(255,255,255,0.07);
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 0.82rem;
  font-weight: 800;
  color: rgba(255,255,255,0.85);
  text-transform: uppercase;
  letter-spacing: 1px;
}
.s-card-head i { color: #FFD700; font-size: 0.95rem; }
.s-card-body { padding: 22px; }

/* ── Profile row ── */
.profile-row {
  display: flex;
  align-items: center;
  gap: 16px;
}
.profile-avatar {
  width: 64px;
  height: 64px;
  border-radius: 50%;
  background: linear-gradient(135deg, #FFD700, #FFB000);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.6rem;
  font-weight: 900;
  color: #1a1a1a;
  flex-shrink: 0;
  box-shadow: 0 4px 14px rgba(255,215,0,0.3);
}
.profile-meta { flex: 1; min-width: 0; }
.profile-meta .name {
  font-size: 1.05rem;
  font-weight: 800;
  color: #fff;
  margin: 0 0 4px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.profile-meta .email {
  font-size: 0.85rem;
  color: rgba(255,255,255,0.55);
  font-weight: 600;
  margin: 0 0 7px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.role-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: rgba(255,215,0,0.12);
  border: 1px solid rgba(255,215,0,0.3);
  color: #FFD700;
  font-size: 0.72rem;
  font-weight: 800;
  padding: 4px 11px;
  border-radius: 20px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* ── Form fields ── */
.s-form-group { margin-bottom: 18px; }
.s-form-group:last-of-type { margin-bottom: 0; }
.s-label {
  display: block;
  font-size: 0.76rem;
  font-weight: 800;
  color: rgba(255,255,255,0.7);
  text-transform: uppercase;
  letter-spacing: 0.8px;
  margin-bottom: 7px;
}
.s-input {
  width: 100%;
  padding: 12px 15px;
  background: rgba(0,0,0,0.3);
  border: 1px solid rgba(255,255,255,0.12);
  border-radius: 7px;
  color: #fff;
  font-size: 0.92rem;
  font-weight: 600;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.s-input:focus {
  outline: none;
  border-color: #FFD700;
  box-shadow: 0 0 0 3px rgba(255,215,0,0.12);
  background: rgba(0,0,0,0.4);
}
.s-input::placeholder { color: rgba(255,255,255,0.3); font-weight: 500; }

/* ── Security hint ── */
.s-hint {
  display: flex;
  align-items: flex-start;
  gap: 9px;
  background: rgba(255,215,0,0.06);
  border: 1px solid rgba(255,215,0,0.18);
  border-radius: 7px;
  padding: 12px 15px;
  margin: 18px 0 18px;
  font-size: 0.82rem;
  color: rgba(255,255,255,0.6);
  font-weight: 600;
  line-height: 1.5;
}
.s-hint i { color: #FFD700; font-size: 0.9rem; margin-top: 1px; flex-shrink: 0; }

/* ── Submit button ── */
.s-submit {
  width: 100%;
  padding: 13px 18px;
  background: linear-gradient(135deg, #FFD700, #FFB000);
  border: none;
  border-radius: 7px;
  color: #1a1a1a;
  font-size: 0.9rem;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.25s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  box-shadow: 0 3px 12px rgba(255,215,0,0.25);
}
.s-submit:hover {
  background: linear-gradient(135deg, #FFB000, #FF8C00);
  transform: translateY(-1px);
  box-shadow: 0 5px 16px rgba(255,215,0,0.35);
}
.s-submit:active { transform: translateY(0); }

/* ── Security info items ── */
.s-info-item {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 14px 16px;
  border-radius: 7px;
  border-left: 3px solid;
  margin-bottom: 10px;
  transition: transform 0.2s ease;
}
.s-info-item:last-child { margin-bottom: 0; }
.s-info-item:hover { transform: translateX(3px); }
.s-info-item.green  { background: rgba(34,197,94,0.07);  border-left-color: #22c55e; }
.s-info-item.blue   { background: rgba(59,130,246,0.07); border-left-color: #3b82f6; }
.s-info-item.yellow { background: rgba(255,215,0,0.07);  border-left-color: #FFD700; }
.s-info-item .s-info-icon { font-size: 1.1rem; flex-shrink: 0; }
.s-info-item.green  .s-info-icon { color: #22c55e; }
.s-info-item.blue   .s-info-icon { color: #3b82f6; }
.s-info-item.yellow .s-info-icon { color: #FFD700; }
.s-info-title {
  font-size: 0.78rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin: 0 0 3px;
}
.s-info-item.green  .s-info-title { color: #22c55e; }
.s-info-item.blue   .s-info-title { color: #3b82f6; }
.s-info-item.yellow .s-info-title { color: #FFD700; }
.s-info-desc {
  font-size: 0.82rem;
  color: rgba(255,255,255,0.5);
  margin: 0;
  font-weight: 600;
  line-height: 1.4;
}
</style>

<div class="adm-wrap">
  <div class="settings-wrap">

    <!-- PAGE HEADER -->
    <div class="settings-page-header">
      <h1><i class="bi bi-gear-fill me-2" style="color:#FFD700;"></i>Admin Settings</h1>
      <p>Manage your account and security preferences</p>
    </div>

    <!-- PROFILE CARD -->
    <div class="s-card">
      <div class="s-card-head">
        <i class="bi bi-person-fill"></i> Account
      </div>
      <div class="s-card-body">
        <div class="profile-row">
          <div class="profile-avatar">
            <?= strtoupper(substr($user['name'] ?? 'A', 0, 1)) ?>
          </div>
          <div class="profile-meta">
            <div class="name"><?= htmlspecialchars($user['name'] ?? 'Admin') ?></div>
            <div class="email"><?= htmlspecialchars($user['email'] ?? '') ?></div>
            <span class="role-badge"><i class="bi bi-shield-fill-check"></i> Administrator</span>
          </div>
        </div>
      </div>
    </div>

    <!-- CHANGE PASSWORD CARD -->
    <div class="s-card">
      <div class="s-card-head">
        <i class="bi bi-shield-lock-fill"></i> Change Password
      </div>
      <div class="s-card-body">
        <form method="POST" action="?controller=admin&action=changePassword">
          <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">

          <div class="s-form-group">
            <label class="s-label">Current Password</label>
            <input type="password" name="current_password" class="s-input"
                   placeholder="Enter your current password" required autocomplete="current-password">
          </div>

          <div class="s-form-group">
            <label class="s-label">New Password</label>
            <input type="password" name="new_password" class="s-input"
                   placeholder="Minimum 6 characters" required minlength="6" autocomplete="new-password">
          </div>

          <div class="s-form-group">
            <label class="s-label">Confirm New Password</label>
            <input type="password" name="confirm_password" class="s-input"
                   placeholder="Re-enter new password" required autocomplete="new-password">
          </div>

          <div class="s-hint">
            <i class="bi bi-info-circle-fill"></i>
            Use at least 6 characters. A strong password includes uppercase letters, numbers, and symbols.
          </div>

          <button type="submit" class="s-submit">
            <i class="bi bi-key-fill"></i> Update Password
          </button>
        </form>
      </div>
    </div>

    <!-- SECURITY INFO CARD -->
    <div class="s-card">
      <div class="s-card-head">
        <i class="bi bi-shield-check"></i> Security Info
      </div>
      <div class="s-card-body">
        <div class="s-info-item green">
          <i class="bi bi-check-circle-fill s-info-icon"></i>
          <div>
            <div class="s-info-title">Full Access</div>
            <div class="s-info-desc">Administrator with complete system privileges</div>
          </div>
        </div>
        <div class="s-info-item blue">
          <i class="bi bi-person-badge-fill s-info-icon"></i>
          <div>
            <div class="s-info-title">Account Type</div>
            <div class="s-info-desc">System administrator — all modules accessible</div>
          </div>
        </div>
        <div class="s-info-item yellow">
          <i class="bi bi-clock-fill s-info-icon"></i>
          <div>
            <div class="s-info-title">Session Started</div>
            <div class="s-info-desc"><?= date('M d, Y \a\t g:i A') ?></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const EMOJI_RE = /[\u{1F000}-\u{1FFFF}\u{2600}-\u{27BF}\u{1F300}-\u{1F9FF}\u{FE00}-\u{FEFF}\u{200B}-\u{200F}]/gu;
    function stripEmoji(el) {
        const pos = el.selectionStart;
        const before = el.value;
        const after = before.replace(EMOJI_RE, '');
        if (before !== after) {
            el.value = after;
            const diff = before.length - after.length;
            try { el.setSelectionRange(Math.max(0, pos - diff), Math.max(0, pos - diff)); } catch(e) {}
        }
    }
    document.querySelectorAll('input[type="password"], input[type="text"]:not([readonly])').forEach(el => {
        el.addEventListener('input', () => stripEmoji(el));
        el.addEventListener('paste', () => setTimeout(() => stripEmoji(el), 0));
    });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
