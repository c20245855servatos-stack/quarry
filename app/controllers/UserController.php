<?php

declare(strict_types=1);
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../core/Flash.php';
require_once __DIR__ . '/../core/Csrf.php';

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

        $name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if (empty($name) || empty($email)) {
            Flash::set('error', 'Name and email are required.');
            redirect('dashboard', 'settings');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Flash::set('error', 'Please enter a valid email address.');
            redirect('dashboard', 'settings');
        }

        if ($this->user->updateProfile($userId, $name, $email, $phone, $address)) {
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

    public function create()
    {
        AuthMiddleware::adminOnly();
        require __DIR__ . '/../views/admin/users/create.php';
    }

    public function store()
    {
        AuthMiddleware::adminOnly();
        $full_name = trim((string) filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_SPECIAL_CHARS));
        $contact_number = trim((string) filter_input(INPUT_POST, 'contact_number', FILTER_SANITIZE_SPECIAL_CHARS));
        $email = trim((string) filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $password = trim((string) $_POST['password'] ?? '');
        $address = trim((string) filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS));
        $is_admin = filter_input(INPUT_POST, 'is_admin', FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        $errors = [];

        if ($full_name === '') {
            $errors[] = 'Full name is required.';
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid email is required.';
        }

        if ($password === '' || strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }

        if (!empty($errors)) {
            http_response_code(422);
            foreach ($errors as $error) {
                echo "<p style='color:red;'>{$error}</p>";
            }
            return;
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->user->create($full_name, $contact_number, $email, $hashedPassword, $is_admin, $address);

        header("Location: ?controller=user&action=index");
        exit;
    }

    public function edit(int $id)
    {
        AuthMiddleware::adminOnly();
        $user = $this->user->find($id);
        require __DIR__ . '/../views/admin/users/edit.php';
    }

    public function update(int $id)
    {
        AuthMiddleware::adminOnly();
        $full_name = trim((string) filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_SPECIAL_CHARS));
        $contact_number = trim((string) filter_input(INPUT_POST, 'contact_number', FILTER_SANITIZE_SPECIAL_CHARS));
        $email = trim((string) filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $address = trim((string) filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS));
        $is_admin = filter_input(INPUT_POST, 'is_admin', FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        if ($full_name === '' || $email === '') {
            echo "Invalid input.";
            return;
        }

        $this->user->update($id, $full_name, $contact_number, $email, $is_admin, $address);

        header("Location: ?controller=user&action=index");
        exit;
    }

    public function delete(int $id)
    {
        AuthMiddleware::adminOnly();
        $this->user->delete($id);
        header("Location: ?controller=user&action=index");
        exit;
    }
}