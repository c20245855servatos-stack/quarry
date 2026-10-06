<?php
ob_start();
$user = $_SESSION['user'] ?? null;
// Fetch full user data including address from DB
require_once BASE_PATH . '/app/models/User.php';
$userModel = new User();
$fullUser = $userModel->find((int)($user['id'] ?? 0)) ?? [];
?>

<style>
/* ========================
   MODERN CONSTRUCTION THEME - SETTINGS PAGE
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

.settings-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.09);
    border-radius: 14px;
    padding: 24px 28px;
    box-shadow: var(--shadow-sm);
    max-width: 560px;
    margin: 0 auto;
}

.settings-card label {
    font-size: 0.7rem;
    font-weight: 700;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 6px;
    display: block;
}

.settings-card input {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.12);
    color: #ffffff;
    border-radius: 8px;
    padding: 9px 14px;
    font-size: 0.88rem;
    font-weight: 600;
    outline: none;
    width: 100%;
    margin-bottom: 14px;
    transition: 0.2s;
}

.settings-card input:focus {
    border-color: rgba(255,215,0,0.5);
    background: rgba(255,215,0,0.06);
    box-shadow: 0 0 0 3px rgba(255,215,0,0.1);
}

.settings-card input[readonly] {
    opacity: 0.45;
    cursor: not-allowed;
    background: rgba(255,255,255,0.03);
    color: rgba(255,255,255,0.5);
}
</style>

<div class="container-fluid p-4">

    <h2 class="fw-bold mb-1" style="color: var(--text-light); text-align:center;"><i class="bi bi-gear-fill me-2"></i>Settings</h2>
    <p style="color: var(--text-secondary); font-size:0.95rem;font-weight:700;margin-bottom:28px; text-align:center;">Manage your account information.</p>

    <div class="settings-card">
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:22px;">
            <div style="width:44px;height:44px;border-radius:50%;background:#FFD700;display:flex;align-items:center;justify-content:center;font-size:1.2rem;font-weight:900;flex-shrink:0;color:#1a1a1a;">
                <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
            </div>
            <div>
                <div style="font-weight:800;font-size:0.95rem;color:#ffffff;"><?= htmlspecialchars($user['name'] ?? '') ?></div>
                <div style="color:rgba(255,255,255,0.4);font-size:0.75rem;font-weight:600;"><?= !empty($user['is_admin']) ? '<i class="bi bi-patch-check-fill" style="color:#FFD700"></i> Administrator' : 'Member' ?></div>
            </div>
        </div>

        <form method="POST" action="?controller=user&action=updateProfile">
            <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">

            <?php if (Flash::has('success')): ?>
            <div style="background:rgba(34,197,94,0.12);border:1px solid rgba(34,197,94,0.3);color:#4ade80;border-radius:7px;padding:10px 14px;margin-bottom:14px;font-size:0.85rem;font-weight:700;">
                <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars(implode(' ', Flash::get('success'))) ?>
            </div>
            <?php endif; ?>
            <?php if (Flash::has('error')): ?>
            <div style="background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.3);color:#f87171;border-radius:7px;padding:10px 14px;margin-bottom:14px;font-size:0.85rem;font-weight:700;">
                <i class="bi bi-exclamation-circle-fill me-2"></i><?= htmlspecialchars(implode(' ', Flash::get('error'))) ?>
            </div>
            <?php endif; ?>

            <label>Full Name</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required
                   data-no-emoji="true" maxlength="100">

            <label>Email Address</label>
            <!-- Hidden so it submits but shows as readonly -->
            <input type="hidden" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
            <input type="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly title="Email cannot be changed here.">

            <label>Phone Number</label>
            <input type="tel" name="phone" id="phone"
                   value="<?= htmlspecialchars($fullUser['contact_number'] ?? '') ?>"
                   placeholder="e.g. 09171234567 or +639171234567"
                   data-phone="true" maxlength="16" autocomplete="tel">
            <span id="phone_hint" style="font-size:0.75rem;font-weight:600;margin-top:-10px;margin-bottom:10px;display:none;"></span>

            <label>Delivery Address</label>
            <?php
            $currentAddr = $fullUser['address'] ?? '';
            if ($currentAddr !== ''):
            ?>
            <div style="background:rgba(255,215,0,0.06); border:1px solid rgba(255,215,0,0.2); border-radius:7px; padding:10px 13px; margin-bottom:10px; font-size:0.82rem; font-weight:600; color:rgba(255,255,255,0.7); line-height:1.5;">
                <div style="font-size:0.7rem; font-weight:800; color:#FFD700; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:4px;">
                    <i class="bi bi-geo-alt-fill me-1"></i> Current Address
                </div>
                <?= htmlspecialchars($currentAddr) ?>
            </div>
            <?php endif; ?>
            <?php
            require_once BASE_PATH . '/app/views/layouts/address_selector.php';
            renderAddressSelector('address', $currentAddr, '', false);
            ?>

            <button type="submit" class="btn btn-warning w-100 fw-bold py-2 mb-3">
                <i class="bi bi-check-lg me-1"></i> Save Profile Changes
            </button>
        </form>

        <hr style="border-color: rgba(255,255,255,0.08); margin: 24px 0;">

        <h5 style="color: #ffffff; font-weight: 800; font-size:0.95rem; margin-bottom: 16px;">
            <i class="bi bi-shield-lock me-2" style="color:#FFD700;"></i>Change Password
        </h5>

        <form method="POST" action="?controller=user&action=changePassword">
            <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">

            <label>Current Password</label>
            <input type="password" name="current_password" placeholder="Enter your current password" required>

            <label>New Password</label>
            <input type="password" name="new_password" id="new_password"
                   placeholder="Enter new password (min. 6 characters)" required minlength="6"
                   oninput="validateNewPwd(this)">
            <span id="new_pwd_hint" style="font-size:0.75rem;font-weight:600;margin-top:-10px;margin-bottom:10px;display:none;"></span>

            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" id="confirm_password"
                   placeholder="Confirm your new password" required
                   oninput="validateConfirmPwd(this)">
            <span id="confirm_pwd_hint" style="font-size:0.75rem;font-weight:600;margin-top:-10px;margin-bottom:10px;display:none;"></span>

            <div style="background:rgba(255,215,0,0.06);border:1px solid rgba(255,215,0,0.2);border-radius:8px;padding:12px 16px;margin-bottom:16px;font-size:0.8rem;color:rgba(255,255,255,0.5);font-weight:600;">
                <i class="bi bi-info-circle me-2" style="color:#FFD700;"></i>
                Password must be at least 6 characters long.
            </div>

            <button type="submit" class="btn btn-danger w-100 fw-bold py-2">
                <i class="bi bi-key me-1"></i> Change Password
            </button>
        </form>
    </div>

</div>

<script>
const EMOJI_RE = /[\u{1F000}-\u{1FFFF}\u{2600}-\u{27BF}\u{1F300}-\u{1F9FF}\u{FE00}-\u{FEFF}\u{200B}-\u{200F}]/gu;
const NAME_RE  = /[^\p{L}\p{M}\s'\-\.]/gu;
const PHONE_RE = /[^\d\s\+\-\(\)]/g;
const ADDR_RE  = /[^\p{L}\p{M}\p{N}\s,\.#\-\/\(\)]/gu;

function cleanInput(el) {
    const re = el.dataset.phone ? PHONE_RE
             : el.dataset.addr  ? ADDR_RE
             : el.dataset.noEmoji ? NAME_RE
             : EMOJI_RE;
    const pos = el.selectionStart;
    const before = el.value;
    const after  = before.replace(re, '');
    if (before !== after) {
        el.value = after;
        const diff = before.length - after.length;
        el.setSelectionRange(Math.max(0, pos - diff), Math.max(0, pos - diff));
    }
}

function normalizePHPhone(raw) {
    const clean = raw.replace(/[\s\-]/g, '');
    const m = clean.match(/^(?:\+63|63|0)(9\d{9})$/);
    return m ? '+63' + m[1] : null;
}

function validatePhoneField(el) {
    const hint = document.getElementById('phone_hint');
    const val  = el.value.trim();
    if (val === '') {
        el.style.borderColor = '';
        if (hint) hint.style.display = 'none';
        return;
    }
    const normalized = normalizePHPhone(val);
    if (normalized) {
        el.style.borderColor = '#22c55e';
        if (hint) {
            hint.textContent = '✓ Valid — will be saved as ' + normalized;
            hint.style.color = '#22c55e';
            hint.style.display = 'block';
        }
    } else {
        el.style.borderColor = '#ef4444';
        if (hint) {
            hint.textContent = '✗ Must be a valid PH mobile number (e.g. 09171234567)';
            hint.style.color = '#ef4444';
            hint.style.display = 'block';
        }
    }
}

function stripEmojiField(el) {
    const re = /[\u{1F000}-\u{1FFFF}\u{2600}-\u{27BF}\u{1F300}-\u{1F9FF}\u{FE00}-\u{FEFF}\u{200B}-\u{200F}]/gu;
    const pos = el.selectionStart;
    const before = el.value;
    const after = before.replace(re, '');
    if (before !== after) {
        el.value = after;
        const diff = before.length - after.length;
        try { el.setSelectionRange(Math.max(0, pos - diff), Math.max(0, pos - diff)); } catch(e) {}
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Tagged inputs
    document.querySelectorAll('[data-no-emoji], [data-phone]').forEach(el => {
        el.addEventListener('input', () => cleanInput(el));
        el.addEventListener('paste', () => setTimeout(() => cleanInput(el), 0));
    });

    // All other text/password inputs — strip emoji
    document.querySelectorAll('input[type="text"]:not([data-no-emoji]):not([data-phone]):not([readonly]), input[type="password"]').forEach(el => {
        el.addEventListener('input', () => stripEmojiField(el));
        el.addEventListener('paste', () => setTimeout(() => stripEmojiField(el), 0));
    });

    const phoneEl = document.getElementById('phone');
    if (phoneEl) {
        // Run on load if pre-filled
        if (phoneEl.value.trim()) validatePhoneField(phoneEl);
        phoneEl.addEventListener('input',  () => validatePhoneField(phoneEl));
        phoneEl.addEventListener('blur',   () => validatePhoneField(phoneEl));
        phoneEl.addEventListener('paste',  () => setTimeout(() => validatePhoneField(phoneEl), 0));

        const form = phoneEl.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const val = phoneEl.value.trim();
                if (val !== '' && !normalizePHPhone(val)) {
                    e.preventDefault();
                    validatePhoneField(phoneEl);
                    phoneEl.focus();
                }
            });
        }
    }
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>