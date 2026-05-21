<?php

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Simple session configuration for development
            $isProduction = ($_ENV['APP_ENV'] ?? 'development') === 'production';
            
            if ($isProduction) {
                // Secure session configuration for production
                session_set_cookie_params([
                    'lifetime' => 3600,
                    'path' => '/',
                    'domain' => '',
                    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                    'httponly' => true,
                    'samesite' => 'Strict'
                ]);
            } else {
                // Relaxed session configuration for development
                session_set_cookie_params([
                    'lifetime' => 3600,
                    'path' => '/',
                    'domain' => '',
                    'secure' => false, // Never require HTTPS in development
                    'httponly' => true,
                    'samesite' => 'Lax' // More permissive for development
                ]);
            }
            
            session_start();
            
            // Regenerate session ID periodically to prevent session fixation
            if (!isset($_SESSION['last_regeneration'])) {
                $_SESSION['last_regeneration'] = time();
            } elseif (time() - $_SESSION['last_regeneration'] > 300) { // 5 minutes
                session_regenerate_id(true);
                $_SESSION['last_regeneration'] = time();
            }
        }
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function destroy(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
    }
}
