<?php

class AuthMiddleware
{
    private static function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private static function denyAccess(): never
    {
        if (self::isAjax()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Session expired. Please log in again.']);
            exit;
        }
        redirect('auth', 'index');
    }

    public static function check(): void
    {
        if (!isset($_SESSION['user'])) {
            self::denyAccess();
        }

        // Validate session structure to prevent tampering
        $user = $_SESSION['user'];
        if (!isset($user['id'], $user['name'], $user['email'])) {
            session_destroy();
            self::denyAccess();
        }

        // Validate that the session user ID is a positive integer
        if (!is_numeric($user['id']) || (int)$user['id'] <= 0) {
            session_destroy();
            self::denyAccess();
        }

        // Bind session to IP + User-Agent fingerprint to detect hijacking
        // Only use User-Agent (not IP) to avoid false positives with mobile/proxy users
        $fingerprint = hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? 'unknown');

        if (!isset($_SESSION['_fingerprint'])) {
            $_SESSION['_fingerprint'] = $fingerprint;
        } elseif (!hash_equals($_SESSION['_fingerprint'], $fingerprint)) {
            // Fingerprint mismatch — possible session hijack
            session_destroy();
            self::denyAccess();
        }
    }

    public static function adminOnly(): void
    {
        self::check();

        if (empty($_SESSION['user']['is_admin'])) {
            if (self::isAjax()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Access denied.']);
                exit;
            }
            http_response_code(403);
            exit('Access denied.');
        }
    }
}
