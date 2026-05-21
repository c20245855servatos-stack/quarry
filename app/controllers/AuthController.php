<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__ . '/../core/Flash.php';
require_once __DIR__ . '/../core/Csrf.php';
require_once __DIR__ . '/../core/Security.php';

class AuthController
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    // Show login page
    public function index(): void
    {
        if (isset($_SESSION['user'])) {
            redirect('dashboard', 'index');
        }
        require __DIR__ . '/../views/auth/login.php';
    }

    // Handle login POST
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('auth', 'index');
        }

        // Rate limit: max 5 login attempts per 5 minutes per session
        Security::rateLimit('login', 5, 300);

        // CSRF validation
        if (!Csrf::validate($_POST['_csrf'] ?? '')) {
            Flash::set('error', 'Invalid request. Please try again.');
            redirect('auth', 'index');
        }

        $email    = trim((string)($_POST['email']    ?? ''));
        $password =             ($_POST['password']  ?? '');

        if ($email === '' || $password === '') {
            Flash::set('error', 'Email and password are required.');
            redirect('auth', 'index');
        }

        // Validate email format before hitting the database
        if (!Security::validateEmail($email)) {
            Flash::set('error', 'Incorrect email or password.');
            redirect('auth', 'index');
        }

        $user = $this->user->findByEmail($email);

        // Use identical error message for both "not found" and "wrong password"
        // to prevent user enumeration
        if (!$user || !password_verify($password, $user['password'])) {
            Flash::set('error', 'Incorrect email or password.');
            redirect('auth', 'index');
        }

        // Regenerate session ID on login to prevent session fixation
        session_regenerate_id(true);

        // Reset login rate limit on success
        Security::resetRateLimit('login');

        // Clear any existing session data
        session_unset();

        $_SESSION['user'] = [
            'id'       => (int)$user['client_id'],
            'name'     => $user['full_name'],
            'email'    => $user['email'],
            'is_admin' => (bool)$user['is_admin'],
        ];

        Flash::set('success', 'Welcome back, ' . $user['full_name'] . '!');

        if ($user['is_admin']) {
            header("Location: ?controller=admin&action=index");
        } else {
            header("Location: ?controller=dashboard&action=index");
        }
        exit();
    }

    // Logout
    public function logout(): void
    {
        // Save cart to database before logout if user is logged in
        if (!empty($_SESSION['user']['id']) && !empty($_SESSION['cart'])) {
            try {
                require_once __DIR__ . '/../models/Material.php';
                $materialModel = new Material();
                $materialModel->syncSessionCartToDatabase(
                    (int)$_SESSION['user']['id'],
                    $_SESSION['cart']
                );
            } catch (Exception $e) {
                error_log("LOGOUT: Failed to save cart - " . $e->getMessage());
            }
        }

        Session::destroy();
        redirect('auth', 'index');
    }
}
