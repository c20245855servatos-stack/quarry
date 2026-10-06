<?php

class Security
{
    public static function setSecurityHeaders(): void
    {
        $isProduction = ($_ENV['APP_ENV'] ?? 'development') === 'production';

        // Always-on security headers
        header('X-Frame-Options: SAMEORIGIN');
        header('X-Content-Type-Options: nosniff');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        // Remove PHP version fingerprint
        header_remove('X-Powered-By');

        if ($isProduction) {
            header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; img-src 'self' data: https:; font-src 'self' https://cdn.jsdelivr.net;");
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
                header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
            }
        }
    }

    /**
     * Sanitize output — use when echoing user-supplied data into HTML.
     */
    public static function sanitizeOutput(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Sanitize input — strip tags and trim.
     */
    public static function sanitizeInput(string $input): string
    {
        return htmlspecialchars(trim(strip_tags($input)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Strip emojis and non-printable/non-standard Unicode characters.
     * Allows: letters (all scripts), digits, spaces, and common punctuation.
     * Blocks: emoji, emoticons, symbols, control characters.
     */
    public static function stripEmoji(string $input): string
    {
        // Remove emoji and symbol Unicode ranges
        $cleaned = preg_replace('/[\x{1F000}-\x{1FFFF}]/u', '', $input); // Misc symbols, emoji
        $cleaned = preg_replace('/[\x{2600}-\x{27BF}]/u', '', $cleaned); // Misc symbols & dingbats
        $cleaned = preg_replace('/[\x{FE00}-\x{FEFF}]/u', '', $cleaned); // Variation selectors, BOM
        $cleaned = preg_replace('/[\x{1F300}-\x{1F9FF}]/u', '', $cleaned); // More emoji blocks
        $cleaned = preg_replace('/[\x{200B}-\x{200F}]/u', '', $cleaned); // Zero-width chars
        $cleaned = preg_replace('/[\x{00}-\x{08}\x{0B}\x{0C}\x{0E}-\x{1F}\x{7F}]/u', '', $cleaned); // Control chars
        return trim((string)$cleaned);
    }

    /**
     * Validate a name field — allows letters (including accented/unicode),
     * spaces, hyphens, apostrophes, and periods. Blocks everything else.
     */
    public static function validateName(string $input): bool
    {
        $stripped = self::stripEmoji($input);
        // Allow unicode letters, spaces, hyphens, apostrophes, periods
        return (bool) preg_match('/^[\p{L}\p{M}\s\'\-\.]+$/u', $stripped);
    }

    /**
     * Validate a Philippine mobile number.
     * Accepts formats:
     *   09XXXXXXXXX       (11 digits, local)
     *   639XXXXXXXXX      (12 digits, no +)
     *   +639XXXXXXXXX     (13 chars with +)
     *   0917 123 4567     (with spaces)
     * Always normalizes to +639XXXXXXXXX for storage.
     * Returns the normalized number or false if invalid.
     */
    public static function validatePHPhone(string $input): string|false
    {
        // Strip spaces and dashes for normalization
        $clean = preg_replace('/[\s\-]/', '', $input);

        // Match patterns and normalize
        if (preg_match('/^\+63(9\d{9})$/', $clean, $m)) {
            return '+63' . $m[1];
        }
        if (preg_match('/^63(9\d{9})$/', $clean, $m)) {
            return '+63' . $m[1];
        }
        if (preg_match('/^0(9\d{9})$/', $clean, $m)) {
            return '+63' . $m[1];
        }

        return false;
    }

    /**
     * Validate a phone/contact number — digits, spaces, +, -, (, ) only.
     * @deprecated Use validatePHPhone() for Philippine numbers.
     */
    public static function validatePhone(string $input): bool
    {
        return (bool) preg_match('/^[\d\s\+\-\(\)]{7,20}$/', $input);
    }

    /**
     * Validate an address — allows letters, digits, spaces, and common
     * address punctuation: , . # - / ( )
     */
    public static function validateAddress(string $input): bool
    {
        $stripped = self::stripEmoji($input);
        return (bool) preg_match('/^[\p{L}\p{M}\p{N}\s\,\.\#\-\/\(\)]+$/u', $stripped);
    }

    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function generateSecureToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * Rate limiting — blocks brute-force on login and other sensitive endpoints.
     * Stores attempt counts in the session.
     *
     * @param string $key     Unique key for the action (e.g. 'login')
     * @param int    $max     Max attempts allowed
     * @param int    $window  Time window in seconds
     */
    public static function rateLimit(string $key, int $max = 5, int $window = 300): void
    {
        $sessionKey = '_rl_' . $key;

        if (!isset($_SESSION[$sessionKey])) {
            $_SESSION[$sessionKey] = ['count' => 0, 'start' => time()];
        }

        $data = &$_SESSION[$sessionKey];

        // Reset window if expired
        if (time() - $data['start'] > $window) {
            $data = ['count' => 0, 'start' => time()];
        }

        $data['count']++;

        if ($data['count'] > $max) {
            $wait = $window - (time() - $data['start']);
            http_response_code(429);
            exit("Too many attempts. Please wait {$wait} seconds before trying again.");
        }
    }

    /**
     * Reset rate limit counter after a successful action.
     */
    public static function resetRateLimit(string $key): void
    {
        unset($_SESSION['_rl_' . $key]);
    }

    /**
     * Validate that a price value is a positive number with max 2 decimal places.
     * Use server-side — never trust client-submitted prices.
     */
    public static function validatePrice(mixed $value): bool
    {
        if (!is_numeric($value)) return false;
        $f = (float)$value;
        return $f > 0 && $f === round($f, 2);
    }

    /**
     * Validate a positive integer quantity within an allowed range.
     */
    public static function validateQuantity(mixed $value, int $min = 1, int $max = 9999): bool
    {
        if (!is_numeric($value)) return false;
        $i = (int)$value;
        return $i >= $min && $i <= $max;
    }
}
