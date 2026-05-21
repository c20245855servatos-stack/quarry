<?php ob_start();
$user = $_SESSION['user'] ?? null;
?>

<?php require __DIR__ . '/admin_style.css.php'; ?>

<style>
/* Enhanced Readability Styles for Admin Settings */
.settings-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 0 20px;
}

.settings-header {
  text-align: center;
  margin-bottom: 40px;
  padding: 30px 0;
  border-bottom: 3px solid rgba(255, 215, 0, 0.3);
}

.settings-title {
  font-size: 2.5rem;
  font-weight: 900;
  color: #FFD700;
  margin-bottom: 12px;
  text-transform: uppercase;
  letter-spacing: 2px;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

.settings-subtitle {
  font-size: 1.1rem;
  color: rgba(255, 255, 255, 0.8);
  font-weight: 600;
  line-height: 1.6;
}

.profile-section {
  background: linear-gradient(135deg, rgba(255, 215, 0, 0.15), rgba(255, 215, 0, 0.05));
  border: 2px solid rgba(255, 215, 0, 0.3);
  border-radius: 16px;
  padding: 32px;
  margin-bottom: 40px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.profile-info {
  display: flex;
  align-items: center;
  gap: 24px;
  margin-bottom: 40px;
  padding: 24px;
  background: rgba(0, 0, 0, 0.2);
  border-radius: 12px;
  border: 1px solid rgba(255, 215, 0, 0.2);
}

.profile-avatar {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: linear-gradient(135deg, #FFD700, #FFB000);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.2rem;
  font-weight: 900;
  color: #1a1a1a;
  box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
  flex-shrink: 0;
}

.profile-details h3 {
  font-size: 1.6rem;
  font-weight: 900;
  color: #FFD700;
  margin: 0 0 8px 0;
  letter-spacing: 1px;
}

.profile-details .email {
  font-size: 1.1rem;
  color: rgba(255, 255, 255, 0.9);
  font-weight: 600;
  margin-bottom: 6px;
}

.profile-details .role {
  font-size: 1rem;
  color: #FFD700;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 6px;
}

.password-section {
  background: rgba(255, 255, 255, 0.03);
  border: 2px solid rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  padding: 32px;
  margin-bottom: 40px;
}

.section-title {
  font-size: 1.4rem;
  font-weight: 900;
  color: #FFD700;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  gap: 10px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.form-grid {
  display: grid;
  gap: 24px;
  margin-bottom: 32px;
}

.form-field {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-label {
  font-size: 1rem;
  font-weight: 700;
  color: rgba(255, 255, 255, 0.9);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.form-input {
  padding: 16px 20px;
  background: rgba(0, 0, 0, 0.3);
  border: 2px solid rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  color: #ffffff;
  font-size: 1rem;
  font-weight: 600;
  transition: all 0.3s ease;
}

.form-input:focus {
  outline: none;
  border-color: #FFD700;
  background: rgba(0, 0, 0, 0.4);
  box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
}

.form-input::placeholder {
  color: rgba(255, 255, 255, 0.5);
  font-weight: 500;
}

.security-notice {
  background: linear-gradient(135deg, rgba(255, 215, 0, 0.2), rgba(255, 215, 0, 0.1));
  border: 2px solid rgba(255, 215, 0, 0.4);
  border-radius: 12px;
  padding: 20px 24px;
  margin-bottom: 32px;
  font-size: 1rem;
  color: rgba(255, 255, 255, 0.95);
  font-weight: 600;
  line-height: 1.6;
  display: flex;
  align-items: flex-start;
  gap: 12px;
}

.security-notice i {
  color: #FFD700;
  font-size: 1.3rem;
  margin-top: 2px;
  flex-shrink: 0;
}

.submit-button {
  width: 100%;
  padding: 18px 24px;
  background: linear-gradient(135deg, #FFD700, #FFB000);
  border: none;
  border-radius: 12px;
  color: #1a1a1a;
  font-size: 1.1rem;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}

.submit-button:hover {
  background: linear-gradient(135deg, #FFB000, #FF8C00);
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
}

.security-info {
  background: rgba(255, 255, 255, 0.03);
  border: 2px solid rgba(255, 255, 255, 0.1);
  border-radius: 16px;
  padding: 32px;
}

.info-grid {
  display: grid;
  gap: 20px;
}

.info-item {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 20px;
  border-radius: 12px;
  border-left: 4px solid;
  transition: all 0.3s ease;
}

.info-item:hover {
  transform: translateX(4px);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.info-item.success {
  background: rgba(34, 197, 94, 0.1);
  border-left-color: #22c55e;
}

.info-item.info {
  background: rgba(59, 130, 246, 0.1);
  border-left-color: #3b82f6;
}

.info-item.warning {
  background: rgba(255, 215, 0, 0.1);
  border-left-color: #FFD700;
}

.info-icon {
  font-size: 1.4rem;
  flex-shrink: 0;
}

.info-content h4 {
  font-size: 1rem;
  font-weight: 700;
  margin: 0 0 4px 0;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.info-content p {
  font-size: 0.9rem;
  margin: 0;
  opacity: 0.8;
  line-height: 1.4;
}

.success .info-icon { color: #22c55e; }
.success h4 { color: #22c55e; }

.info .info-icon { color: #3b82f6; }
.info h4 { color: #3b82f6; }

.warning .info-icon { color: #FFD700; }
.warning h4 { color: #FFD700; }

/* Responsive Design */
@media (max-width: 768px) {
  .settings-container {
    padding: 0 16px;
  }
  
  .settings-title {
    font-size: 2rem;
  }
  
  .profile-info {
    flex-direction: column;
    text-align: center;
    gap: 16px;
  }
  
  .profile-avatar {
    width: 70px;
    height: 70px;
    font-size: 2rem;
  }
  
  .profile-section,
  .password-section,
  .security-info {
    padding: 24px 20px;
  }
}
</style>

<div class="adm-wrap">
  <div class="settings-container">
    
    <!-- HEADER -->
    <div class="settings-header">
      <h1 class="settings-title">
        <i class="bi bi-gear-fill"></i> Admin Settings
      </h1>
      <p class="settings-subtitle">
        Manage your administrator account settings and security preferences
      </p>
    </div>

    <!-- ADMIN PROFILE SECTION -->
    <div class="profile-section">
      <div class="profile-info">
        <div class="profile-avatar">
          <?= strtoupper(substr($user['name'] ?? 'A', 0, 1)) ?>
        </div>
        <div class="profile-details">
          <h3><?= htmlspecialchars($user['name'] ?? '') ?></h3>
          <div class="email"><?= htmlspecialchars($user['email'] ?? '') ?></div>
          <div class="role">
            <i class="bi bi-shield-fill-check"></i>
            Administrator
          </div>
        </div>
      </div>

      <!-- PASSWORD CHANGE FORM -->
      <div class="password-section">
        <h2 class="section-title">
          <i class="bi bi-shield-lock"></i>
          Change Password
        </h2>

        <form method="POST" action="?controller=admin&action=changePassword">
          <input type="hidden" name="_csrf" value="<?= Csrf::generate() ?>">
          <div class="form-grid">
            <div class="form-field">
              <label class="form-label">Current Password</label>
              <input type="password" name="current_password" class="form-input" 
                     placeholder="Enter your current password" required>
            </div>

            <div class="form-field">
              <label class="form-label">New Password</label>
              <input type="password" name="new_password" class="form-input" 
                     placeholder="Enter new password (minimum 6 characters)" required minlength="6">
            </div>

            <div class="form-field">
              <label class="form-label">Confirm New Password</label>
              <input type="password" name="confirm_password" class="form-input" 
                     placeholder="Confirm your new password" required>
            </div>
          </div>

          <div class="security-notice">
            <i class="bi bi-info-circle"></i>
            <div>
              <strong>Security Requirements:</strong> Your password must be at least 6 characters long. 
              As an administrator, we recommend using a strong, unique password to protect the system 
              and maintain security standards.
            </div>
          </div>

          <button type="submit" class="submit-button">
            <i class="bi bi-key"></i>
            Update Password
          </button>
        </form>
      </div>
    </div>

    <!-- SECURITY INFORMATION -->
    <div class="security-info">
      <h2 class="section-title">
        <i class="bi bi-shield-check"></i>
        Security Information
      </h2>
      
      <div class="info-grid">
        <div class="info-item success">
          <i class="bi bi-check-circle-fill info-icon"></i>
          <div class="info-content">
            <h4>Administrator Access</h4>
            <p>You have full system access and administrative privileges</p>
          </div>
        </div>
        
        <div class="info-item info">
          <i class="bi bi-person-badge-fill info-icon"></i>
          <div class="info-content">
            <h4>Account Type</h4>
            <p>Administrator with complete system management capabilities</p>
          </div>
        </div>
        
        <div class="info-item warning">
          <i class="bi bi-clock-fill info-icon"></i>
          <div class="info-content">
            <h4>Current Session</h4>
            <p>Active since <?= date('M d, Y \a\t g:i A') ?></p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/layout.php';
?>