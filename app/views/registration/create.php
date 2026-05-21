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
                <input type="text" name="full_name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact_number" placeholder="Enter your contact number">
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" placeholder="Enter your address"></textarea>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="password-input-wrapper">
                    <input type="password" name="password" id="password" placeholder="Create a strong password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="bi bi-eye" id="password-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <div class="password-input-wrapper">
                    <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirm your password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirm')">
                        <i class="bi bi-eye" id="password_confirm-eye"></i>
                    </button>
                </div>
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

        </form>

    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(fieldId + '-eye');
    
    if (!field || !eyeIcon) {
        console.error('Field or icon not found:', fieldId);
        return;
    }
    
    if (field.type === 'password') {
        field.type = 'text';
        eyeIcon.classList.remove('bi-eye');
        eyeIcon.classList.add('bi-eye-slash');
    } else {
        field.type = 'password';
        eyeIcon.classList.remove('bi-eye-slash');
        eyeIcon.classList.add('bi-eye');
    }
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';