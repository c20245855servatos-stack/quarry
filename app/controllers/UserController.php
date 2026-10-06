<?php

declare(strict_types=1);
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../core/Flash.php';
require_once __DIR__ . '/../core/Csrf.php';
require_once __DIR__ . '/../core/Security.php';

class UserController
{
    private User $user;

    public function __construct()
    {
        AuthMiddleware::check();
        $this->user = new User();
    }

    public function index(): void
    {
        AuthMiddleware::adminOnly();
        $users = $this->user->all();
        require __DIR__ . '/../views/admin/users.php';
    }

    public function updateProfile(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('dashboard', 'settings');
        }

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('dashboard', 'settings');
        }

        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            Flash::set('error', 'User not found.');
            redirect('auth', 'index');
        }

        $name    = Security::stripEmoji(trim($_POST['full_name'] ?? ''));
        $email   = trim($_POST['email'] ?? '');
        $phone   = trim($_POST['phone'] ?? '');

        // Normalize and validate PH phone number
        $normalizedPhone = '';
        if ($phone !== '') {
            $normalized = Security::validatePHPhone($phone);
            if ($normalized === false) {
                Flash::set('error', 'Invalid contact number. Please enter a valid Philippine mobile number (e.g. 09171234567 or +639171234567).');
                redirect('dashboard', 'settings');
            }
            $normalizedPhone = $normalized;
        }
        $address = Security::stripEmoji(trim($_POST['address'] ?? ''));

        if (empty($name) || empty($email)) {
            Flash::set('error', 'Name and email are required.');
            redirect('dashboard', 'settings');
        }

        if (!Security::validateName($name)) {
            Flash::set('error', 'Name contains invalid characters. Only letters, spaces, hyphens, and apostrophes are allowed.');
            redirect('dashboard', 'settings');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Flash::set('error', 'Please enter a valid email address.');
            redirect('dashboard', 'settings');
        }

        if ($address !== '' && mb_strlen($address) > 500) {
            Flash::set('error', 'Address is too long.');
            redirect('dashboard', 'settings');
        }

        if ($this->user->updateProfile($userId, $name, $email, $normalizedPhone, $address)) {
            // Update session data
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;
            Flash::set('success', 'Profile updated successfully.');
        } else {
            Flash::set('error', 'Failed to update profile.');
        }

        redirect('dashboard', 'settings');
    }

    public function changePassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('dashboard', 'settings');
        }

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('dashboard', 'settings');
        }

        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            Flash::set('error', 'User not found.');
            redirect('auth', 'index');
        }

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validation
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            Flash::set('error', 'All password fields are required.');
            redirect('dashboard', 'settings');
        }

        if (strlen($newPassword) < 6) {
            Flash::set('error', 'New password must be at least 6 characters long.');
            redirect('dashboard', 'settings');
        }

        if ($newPassword !== $confirmPassword) {
            Flash::set('error', 'New password and confirmation do not match.');
            redirect('dashboard', 'settings');
        }

        // Verify current password
        $user = $this->user->find($userId);
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            Flash::set('error', 'Current password is incorrect.');
            redirect('dashboard', 'settings');
        }

        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        if ($this->user->updatePassword($userId, $hashedPassword)) {
            Flash::set('success', 'Password changed successfully.');
        } else {
            Flash::set('error', 'Failed to change password. Please try again.');
        }

        redirect('dashboard', 'settings');
    }

    public function delete(int|string $id)
    {
        AuthMiddleware::adminOnly();
        $this->user->delete((int)$id);
        header("Location: ?controller=user&action=index");
        exit;
    }
}