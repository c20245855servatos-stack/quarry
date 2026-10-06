<?php ob_start(); ?>

<style>
/* ========================
   ANIMATIONS
======================== */
@keyframes slideInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInDown {
    from { opacity: 0; transform: translateY(-30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* ========================
   BACKGROUND - TERRAFORGE CONSTRUCTION THEME
======================== */
body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: linear-gradient(180deg, #1A1A1A 0%, #242424 50%, #2A2A2A 100%);
    z-index: -1;
    animation: fadeIn 0.8s ease;
}

/* ========================
   REGISTRATION CARD
======================== */
.reg-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.reg-card {
    background: rgba(255, 255, 255, 0.04);
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 24px;
    padding: 48px 40px;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(10px);
    animation: slideInUp 0.8s ease;
    transition: 0.3s ease;
}

.reg-card:hover {
    border-color: #FFD700;
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.8);
    transform: translateY(-4px);
}

.reg-header {
    text-align: center;
    margin-bottom: 32px;
    animation: slideInDown 0.8s ease;
}

.reg-header .icon {
    font-size: 3rem;
    color: #FFD700;
    margin-bottom: 16px;
    display: block;
    animation: float 3s ease-in-out infinite;
}

.reg-header h2 {
    font-size: 2rem;
    font-weight: 900;
    margin: 0 0 8px;
    color: #ffffff;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

.reg-header p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.95rem;
    margin: 0;
    font-weight: 500;
}

/* ========================
   FORM ELEMENTS
======================== */
.reg-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
    animation: slideInUp 0.6s ease both;
}

.form-group:nth-child(1) { animation-delay: 0.1s; }
.form-group:nth-child(2) { animation-delay: 0.2s; }
.form-group:nth-child(3) { animation-delay: 0.3s; }
.form-group:nth-child(4) { animation-delay: 0.4s; }
.form-group:nth-child(5) { animation-delay: 0.5s; }
.form-group:nth-child(6) { animation-delay: 0.6s; }

.form-group label {
    font-size: 0.85rem;
    font-weight: 800;
    color: #FFD700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-group input,
.form-group textarea {
    background: rgba(255, 255, 255, 0.06);
    border: 2px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 0.9rem;
    outline: none;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    font-family: Arial, sans-serif;
    font-weight: 500;
}

.form-group input::placeholder,
.form-group textarea::placeholder {
    color: rgba(255, 255, 255, 0.5);
    opacity: 1;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #FFD700;
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 0 4px rgba(255, 215, 0, 0.2);
    transform: scale(1.02);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

/* ========================
   PASSWORD INPUT WRAPPER
======================== */
.password-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.password-input-wrapper input {
    width: 100%;
    padding-right: 45px;
}

.password-toggle {
    position: absolute;
    right: 12px;
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    font-size: 1.2rem;
    padding: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s;
    z-index: 10;
}

.password-toggle:hover {
    color: #FFD700;
}

.password-toggle:focus {
    outline: none;
}

.password-toggle i {
    pointer-events: none;
}

/* ========================
   BUTTONS
======================== */
.reg-actions {
    display: flex;
    gap: 12px;
    margin-top: 24px;
    animation: slideInUp 0.8s ease 0.7s both;
}

.btn-register {
    flex: 1;
    padding: 14px 24px;
    background: linear-gradient(135deg, #FFD700 0%, #FFC000 100%);
    color: #1a1a1a;
    font-weight: 700;
    font-size: 0.95rem;
    border: none;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    letter-spacing: 0.3px;
    box-shadow: 0 8px 24px rgba(255, 215, 0, 0.4);
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.btn-register::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.3);
    transition: 0.5s;
}

.btn-register:hover::before {
    left: 100%;
}

.btn-register:hover {
    background: linear-gradient(135deg, #FFC000 0%, #FFB000 100%);
    color: #1a1a1a;
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 16px 40px rgba(255, 215, 0, 0.6);
}

.btn-back {
    flex: 1;
    padding: 14px 24px;
    background: transparent;
    color: #ffffff;
    font-weight: 700;
    font-size: 0.95rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    text-decoration: none;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    letter-spacing: 0.3px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-back::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    transition: 0.5s;
}

.btn-back:hover::before {
    left: 100%;
}

.btn-back:hover {
    border-color: #FFD700;
    color: #FFD700;
    background: rgba(255, 215, 0, 0.1);
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(255, 215, 0, 0.3);
}

/* ========================
   ALERTS
======================== */
.alert-error {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(239, 68, 68, 0.08));
    border: 2px solid rgba(239, 68, 68, 0.3);
    color: #dc2626;
    border-radius: 10px;
    padding: 14px 16px;
    margin-bottom: 20px;
    font-weight: 600;
    animation: slideInUp 0.6s ease;
}

/* ========================
   RESPONSIVE
======================== */
@media (max-width: 768px) {
    .reg-card {
        padding: 32px 24px;
    }

    .reg-header h2 {
        font-size: 1.6rem;
    }

    .reg-actions {
        flex-direction: column;
    }

    .btn-register,
    .btn-back {
        width: 100%;
    }
}
</style>

<div class="reg-container">
    <div class="reg-card">

        <!-- HEADER -->
        <div class="reg-header">
            <i class="bi bi-person-plus-fill icon"></i>
            <h2>Create Account</h2>
            <p>Join TerraForge today</p>
        </div>

        <!-- FLASH ERROR -->
        <?php if (Flash::has('error')): ?>
            <div class="alert-error">
                <?php foreach (Flash::get('error') as $msg): ?>
                    <div>✗ <?= htmlspecialchars($msg) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- FORM -->
        <form action="?controller=registration&action=store" method="POST" class="reg-form">
            <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="Enter your full name" required
                       data-no-emoji="true" maxlength="100">
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input type="tel" name="contact_number" id="contact_number"
                       placeholder="e.g. 09171234567 or +639171234567"
                       data-phone="true" maxlength="16" autocomplete="tel" required>
                <span id="phone_hint" style="font-size:0.75rem;font-weight:600;margin-top:3px;display:none;"></span>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required maxlength="150">
            </div>

            <div class="form-group">
                <label>Address</label>
                <?php require BASE_PATH . '/app/views/layouts/address_selector.php'; ?>
                <?php renderAddressSelector('address', '', '', true); ?>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="password-input-wrapper">
                    <input type="password" name="password" id="password"
                           placeholder="Create a strong password" required minlength="6"
                           oninput="validatePasswordStrength(this); stripEmojiFromInput(this)">
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="bi bi-eye" id="password-eye"></i>
                    </button>
                </div>
                <span id="password_hint" style="font-size:0.75rem;font-weight:600;margin-top:-6px;margin-bottom:4px;display:none;"></span>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <div class="password-input-wrapper">
                    <input type="password" name="password_confirm" id="password_confirm"
                           placeholder="Confirm your password" required
                           oninput="validatePasswordMatch(this); stripEmojiFromInput(this)">
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirm')">
                        <i class="bi bi-eye" id="password_confirm-eye"></i>
                    </button>
                </div>
                <span id="confirm_hint" style="font-size:0.75rem;font-weight:600;margin-top:-6px;margin-bottom:4px;display:none;"></span>
            </div>

            <!-- ACTIONS -->
            <div class="reg-actions">
                <button type="submit" class="btn-register">
                    <i class="bi bi-check-circle me-2"></i> Create Account
                </button>
                <a href="?controller=auth&action=index" class="btn-back">
                    <i class="bi bi-arrow-left me-2"></i> Back
                </a>
            </div>

            <!-- Validation error banner -->
            <div id="reg_error_banner" style="display:none; background:rgba(239,68,68,0.12); border:1px solid rgba(239,68,68,0.4); border-radius:8px; padding:12px 16px; margin-top:12px; font-size:0.85rem; font-weight:700; color:#f87171; line-height:1.6;">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <span id="reg_error_text"></span>
            </div>

        </form>

    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(fieldId + '-eye');
    if (!field || !eyeIcon) return;
    if (field.type === 'password') {
        field.type = 'text';
        eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        field.type = 'password';
        eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

function validatePasswordStrength(el) {
    const hint = document.getElementById('password_hint');
    const val = el.value;
    if (val.length === 0) {
        el.style.borderColor = '';
        hint.style.display = 'none';
        return;
    }
    if (val.length < 6) {
        el.style.borderColor = '#ef4444';
        hint.textContent = '✗ Password must be at least 6 characters';
        hint.style.color = '#ef4444';
        hint.style.display = 'block';
    } else {
        el.style.borderColor = '#22c55e';
        hint.textContent = '✓ Password looks good';
        hint.style.color = '#22c55e';
        hint.style.display = 'block';
    }
    // Re-validate confirm if already filled
    const confirm = document.getElementById('password_confirm');
    if (confirm && confirm.value.length > 0) validatePasswordMatch(confirm);
}

function validatePasswordMatch(el) {
    const hint = document.getElementById('confirm_hint');
    const password = document.getElementById('password').value;
    if (el.value.length === 0) {
        el.style.borderColor = '';
        hint.style.display = 'none';
        return;
    }
    if (el.value !== password) {
        el.style.borderColor = '#ef4444';
        hint.textContent = '✗ Passwords do not match';
        hint.style.color = '#ef4444';
        hint.style.display = 'block';
    } else {
        el.style.borderColor = '#22c55e';
        hint.textContent = '✓ Passwords match';
        hint.style.color = '#22c55e';
        hint.style.display = 'block';
    }
}

// ── Emoji / invalid character blocking ──
const EMOJI_RE = /[\u{1F000}-\u{1FFFF}\u{2600}-\u{27BF}\u{1F300}-\u{1F9FF}\u{FE00}-\u{FEFF}\u{200B}-\u{200F}]/gu;
const NAME_RE  = /[^\p{L}\p{M}\s'\-\.]/gu;
const PHONE_RE = /[^\d\s\+\-\(\)]/g;
const ADDR_RE  = /[^\p{L}\p{M}\p{N}\s,\.#\-\/\(\)]/gu;

function cleanInput(el) {
    const re = el.dataset.phone ? PHONE_RE
             : el.dataset.noEmoji && el.name === 'address' ? ADDR_RE
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

// ── PH Phone validation ──
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

// ── Global emoji stripper (used by password fields) ──
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
    function showRegError(msg) {
        const banner = document.getElementById('reg_error_banner');
        const text   = document.getElementById('reg_error_text');
        if (!banner || !text) return;
        text.textContent = msg;
        banner.style.display = 'block';
        banner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    function hideRegError() {
        const banner = document.getElementById('reg_error_banner');
        if (banner) banner.style.display = 'none';
    }
    // Tagged inputs (name, phone, address)
    document.querySelectorAll('[data-no-emoji], [data-phone]').forEach(el => {
        el.addEventListener('input', () => cleanInput(el));
        el.addEventListener('paste', () => setTimeout(() => cleanInput(el), 0));
    });

    // All other text/password/email inputs — strip emoji only
    document.querySelectorAll('input[type="text"]:not([data-no-emoji]):not([data-phone]):not([readonly]), input[type="password"], input[type="email"]').forEach(el => {
        el.addEventListener('input', () => stripEmojiField(el));
        el.addEventListener('paste', () => setTimeout(() => stripEmojiField(el), 0));
    });

    // PH phone live validation
    const phoneEl = document.getElementById('contact_number');
    if (phoneEl) {
        phoneEl.addEventListener('input',  () => validatePhoneField(phoneEl));
        phoneEl.addEventListener('blur',   () => validatePhoneField(phoneEl));
        phoneEl.addEventListener('paste',  () => setTimeout(() => validatePhoneField(phoneEl), 0));
    }

    // Block form submit if phone is filled but invalid
    const form = phoneEl?.closest('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            hideRegError();

            const fullName    = form.querySelector('input[name="full_name"]');
            const phone       = document.getElementById('contact_number');
            const email       = form.querySelector('input[name="email"]');
            const password    = document.getElementById('password');
            const confirmPwd  = document.getElementById('password_confirm');
            const citySelect  = form.querySelector('select[id$="_city"]');
            const brgySelect  = form.querySelector('select[id$="_brgy"]');
            const streetInput = form.querySelector('input[id$="_st"]');

            // Reset borders
            [fullName, phone, email, password, confirmPwd, citySelect, brgySelect, streetInput]
                .forEach(el => { if (el) el.style.borderColor = ''; });

            const fail = (el, msg) => {
                if (el) { el.style.borderColor = '#ef4444'; el.focus(); }
                showRegError(msg);
                e.preventDefault();
            };

            if (!fullName?.value.trim())
                return fail(fullName, 'Full name is required.');

            if (!phone?.value.trim())
                return fail(phone, 'Contact number is required.');

            if (!normalizePHPhone(phone.value.trim()))
                return fail(phone, 'Please enter a valid Philippine mobile number (e.g. 09171234567).');

            if (!email?.value.trim())
                return fail(email, 'Email address is required.');

            if (!citySelect?.value)
                return fail(citySelect, 'Please select your City / Municipality.');

            if (!brgySelect?.value)
                return fail(brgySelect, 'Please select your Barangay.');

            if (!streetInput?.value.trim())
                return fail(streetInput, 'Street / Road name is required.');

            if (!password?.value || password.value.length < 6)
                return fail(password, 'Password must be at least 6 characters.');

            if (!confirmPwd?.value || confirmPwd.value !== password.value)
                return fail(confirmPwd, 'Passwords do not match.');
        });
    }
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';