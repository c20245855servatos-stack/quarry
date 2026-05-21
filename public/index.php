<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

// Enable output compression for faster transfers
if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) {
    ini_set('zlib.output_compression', '1');
    ini_set('zlib.output_compression_level', '5');
}

require_once BASE_PATH . '/app/core/Session.php';
require_once BASE_PATH . '/app/core/Flash.php';
require_once BASE_PATH . '/app/core/Security.php';

// Load environment variables first
if (file_exists(BASE_PATH . '/.env')) {
    $lines = file(BASE_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }
        if (strpos($line, '=') !== false) {
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Redirect HTTPS to HTTP in development to avoid "Not Secure" warnings
$isProduction = ($_ENV['APP_ENV'] ?? 'development') === 'production';
if (!$isProduction && isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    $redirectURL = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirectURL", true, 301);
    exit();
}

// Error reporting - disable in production
if (($_ENV['APP_ENV'] ?? 'production') === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Set security headers (minimal in development)
Security::setSecurityHeaders();

Session::start();

/**
 * Simple redirect helper
 */
function redirect(string $controller, string $action): never
{
    header("Location: ?controller={$controller}&action={$action}");
    exit;
}

$controllerName = strtolower(trim($_GET['controller'] ?? 'page'));
$action         = strtolower(trim($_GET['action']     ?? 'home'));
$id             = $_GET['id'] ?? null;

$controllerClass = ucfirst($controllerName) . 'Controller';
$controllerFile  = BASE_PATH . "/app/controllers/{$controllerClass}.php";

if (!file_exists($controllerFile)) {
    http_response_code(404);
    exit("Page not found.");
}

require_once $controllerFile;

if (!class_exists($controllerClass)) {
    http_response_code(404);
    exit("Page not found.");
}

$controller = new $controllerClass();

if (!method_exists($controller, $action)) {
    http_response_code(404);
    exit("Page not found.");
}

if ($id !== null) {
    $controller->$action($id);
} else {
    $controller->$action();
}
