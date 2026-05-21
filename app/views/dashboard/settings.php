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
    background: white;
    border: 3px solid var(--accent);
    border-radius: 18px;
    padding: 32px 36px;
    box-shadow: var(--shadow-md);
    transition: 0.3s ease;
}

.settings-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary);
}

.settings-card label {
    font-size: 0.85rem;
    font-weight: 800;
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    display: block;
}

.settings-card input {
    background: rgba(255, 215, 0, 0.1);
    border: 2px solid var(--accent);
    color: var(--primary);
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 0.95rem;
    font-weight: 600;
    outline: none;
    width: 100%;
    margin-bottom: 18px;
    transition: 0.3s;
}

.settings-card input:focus {
    border-color: var(--primary);
    background: rgba(255, 215, 0, 0.2);
    box-shadow: 0 0 0 4px var(--focus-ring);
    transform: scale(1.02);
}

.settings-card input[readonly] {
    opacity: 0.7;
    cursor: not-allowed;
    background: var(--secondary);
    color: var(--text-secondary);
    font-weight: 500;
}
</style>

<div class="container-fluid p-4">

    <h2 class="fw-bold mb-1" style="color: var(--text-light);"><i class="bi bi-gear-fill me-2"></i>Settings</h2>
    <p style="color: var(--text-secondary); font-size:0.95rem;font-weight:700;margin-bottom:28px;">Manage your account information.</p>

    <div class="settings-card">
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:28px;">
            <div style="width:56px;height:56px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:700;flex-shrink:0;color:var(--primary);">
                <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
            </div>
            <div>
                <div style="font-weight:900;font-size:1.1rem;color:var(--primary);"><?= htmlspecialchars($user['name'] ?? '') ?></div>
                <div style="color:var(--secondary);font-size:0.9rem;font-weight:700;"><?= !empty($user['is_admin']) ? '<i class="bi bi-patch-check-fill" style="color:var(--accent)"></i> Administrator' : 'Member' ?></div>
            </div>
        </div>

        <form method="POST" action="?controller=user&action=updateProfile">
            <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>

            <label>Email Address</label>
            <input type="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly title="Email cannot be changed here.">

            <label>Phone Number</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($fullUser['contact_number'] ?? '') ?>" placeholder="e.g. +63 912 345 6789">

            <label>Delivery Address</label>
            <input type="text" name="address" value="<?= htmlspecialchars($fullUser['address'] ?? '') ?>" placeholder="Enter your full delivery address" required>

            <button type="submit" class="btn btn-warning w-100 fw-bold py-2 mb-3">
                <i class="bi bi-check-lg me-1"></i> Save Profile Changes
            </button>
        </form>

        <hr style="border-color: var(--accent); margin: 32px 0;">

        <h5 style="color: var(--primary); font-weight: 900; margin-bottom: 20px;">
            <i class="bi bi-shield-lock me-2"></i>Change Password
        </h5>

        <form method="POST" action="?controller=user&action=changePassword">
            <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">
            <label>Current Password</label>
            <input type="password" name="current_password" placeholder="Enter your current password" required>

            <label>New Password</label>
            <input type="password" name="new_password" placeholder="Enter new password (min. 6 characters)" required minlength="6">

            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm your new password" required>

            <div style="background:rgba(255,215,0,0.15);border:2px solid var(--accent);border-radius:12px;padding:16px 20px;margin-bottom:24px;font-size:0.9rem;color:var(--primary);font-weight:700;">
                <i class="bi bi-info-circle me-2" style="color:var(--accent);font-size:1.1rem;"></i>
                Your password must be at least 6 characters long for security.
            </div>

            <button type="submit" class="btn btn-danger w-100 fw-bold py-2">
                <i class="bi bi-key me-1"></i> Change Password
            </button>
        </form>
    </div>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>
