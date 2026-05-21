<?php 
require_once __DIR__ . '/../../core/Csrf.php';
ob_start(); 
?>

<style>
/* ========================
   MODERN CONSTRUCTION THEME - LOGIN PAGE
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

body {
    background: linear-gradient(180deg, #1A1A1A 0%, #242424 50%, #2A2A2A 100%);
    color: var(--text-primary);
    min-height: 100vh;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
}

/* ========================
   BACKGROUND
======================== */
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
    color: var(--text-primary);
    background: var(--background);
}

body::before {
    content: "";
    position: fixed;
    inset: 0;
    background: var(--background);
    z-index: -1;
    animation: fadeIn 0.8s ease;
}

/* ========================
   LOGIN CONTAINER
======================== */
.login-container {
    min-height: calc(100vh - var(--navbar-height, 60px));
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
}

.login-card {
    background: white;
    border: 3px solid var(--primary);
    border-radius: 20px;
    padding: 32px 28px;
    width: 100%;
    max-width: 360px;
    box-shadow: var(--shadow-md);
    animation: slideInUp 0.8s ease;
    transition: 0.3s ease;
}

.login-card:hover {
    border-color: var(--secondary);
    box-shadow: var(--shadow-lg);
    transform: translateY(-4px);
}

.login-header {
    text-align: center;
    margin-bottom: 20px;
    animation: slideInDown 0.8s ease;
}

.login-header .icon {
    font-size: 2rem;
    color: var(--primary);
    margin-bottom: 10px;
    display: block;
    animation: float 3s ease-in-out infinite;
}

.login-header h1 {
    font-size: 1.5rem;
    font-weight: 900;
    margin: 0 0 4px;
    color: var(--primary);
}

.login-header p {
    color: var(--text-secondary);
    font-size: 0.85rem;
    margin: 0;
    font-weight: 500;
}

/* ========================
   FORM ELEMENTS
======================== */
.login-form {
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

.form-group label {
    font-size: 0.85rem;
    font-weight: 800;
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-group input {
    background: rgba(255, 215, 0, 0.1);
    border: 2px solid rgba(255, 215, 0, 0.3);
    color: var(--primary);
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 0.9rem;
    outline: none;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    font-family: Arial, sans-serif;
    font-weight: 500;
}

.form-group input::placeholder {
    color: rgba(26, 26, 26, 0.5);
    opacity: 0.6;
}

.form-group input:focus {
    border-color: var(--accent);
    background: rgba(255, 215, 0, 0.2);
    box-shadow: 0 0 0 4px var(--focus-ring);
    transform: scale(1.02);
}

.input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.input-group input {
    flex: 1;
    padding-right: 45px;
}

.input-group button {
    position: absolute;
    right: 12px;
    background: none;
    border: none;
    color: rgba(26, 26, 26, 0.7);
    border-radius: 0;
    padding: 8px;
    cursor: pointer;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    font-weight: 700;
    z-index: 10;
}

.input-group button:hover {
    background: none;
    transform: none;
    box-shadow: none;
    color: var(--accent);
}

/* ========================
   CHECKBOX
======================== */
.form-check {
    display: flex;
    align-items: center;
    gap: 8px;
    animation: slideInUp 0.6s ease 0.3s both;
}

.form-check input {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: var(--primary);
}

.form-check label {
    margin: 0;
    font-size: 0.9rem;
    color: #000000;
    font-weight: 500;
    cursor: pointer;
}

/* ========================
   BUTTONS
======================== */
.login-actions {
    display: flex;
    gap: 12px;
    margin-top: 24px;
    animation: slideInUp 0.8s ease 0.4s both;
}

.btn-login {
    flex: 1;
    padding: 14px 24px;
    background: var(--accent);
    color: var(--primary);
    font-weight: 700;
    font-size: 0.95rem;
    border: none;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    letter-spacing: 0.3px;
    box-shadow: var(--shadow-sm);
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.btn-login::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.2);
    transition: 0.5s;
}

.btn-login:hover::before {
    left: 100%;
}

.btn-login:hover {
    background: var(--hover-secondary);
    color: var(--primary);
    transform: translateY(-4px) scale(1.05);
    box-shadow: var(--shadow-md);
}

.btn-register {
    flex: 1;
    padding: 14px 24px;
    background: transparent;
    color: var(--primary);
    font-weight: 700;
    font-size: 0.95rem;
    border: 2px solid var(--accent);
    border-radius: 10px;
    text-decoration: none;
    transition: 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    letter-spacing: 0.3px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.btn-register::before {
    content: "";
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 215, 0, 0.1);
    transition: 0.5s;
}

.btn-register:hover::before {
    left: 100%;
}

.btn-register:hover {
    border-color: var(--accent);
    color: var(--primary);
    background: rgba(255, 215, 0, 0.1);
    transform: translateY(-4px);
    box-shadow: var(--shadow-sm);
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
    .login-card {
        padding: 32px 24px;
    }

    .login-header h1 {
        font-size: 1.6rem;
    }

    .login-actions {
        flex-direction: column;
    }

    .btn-login,
    .btn-register {
        width: 100%;
    }
}
</style>

<div class="login-container">
    <div class="login-card">

        <!-- HEADER -->
        <div class="login-header">
            <i class="bi bi-box-arrow-in-right icon"></i>
            <h1>Welcome Back</h1>
            <p>Sign in to your account</p>
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
        <form action="?controller=auth&action=login" method="POST" class="login-form">
            <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    <button type="button" onclick="togglePassword()" title="Toggle password visibility">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-check">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
            </div>

            <!-- ACTIONS -->
            <div class="login-actions">
                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                </button>
                <a href="?controller=registration&action=create" class="btn-register">
                    <i class="bi bi-person-plus me-2"></i> Register
                </a>
            </div>

        </form>

    </div>
</div>

<script>
function togglePassword() {
    const pass = document.getElementById("password");
    const btn = pass.parentElement.querySelector('button');
    const icon = btn.querySelector('i');
    
    if (pass.type === "password") {
        pass.type = "text";
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        pass.type = "password";
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';