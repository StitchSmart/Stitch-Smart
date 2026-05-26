<?php
/**
 * Stitch Smart — Application Configuration
 *
 * Loads environment variables from the root .env file and defines
 * application-wide constants consumed by controllers and views.
 */

// ── Load .env ───────────────────────────────────────────────────────────────
// Simple .env parser — no external dependency required.
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        // Skip comments and blank lines
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (str_contains($line, '=')) {
            [$key, $value] = explode('=', $line, 2);
            $key   = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key]    = $value;
                $_SERVER[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
}

// ── Helper ───────────────────────────────────────────────────────────────────
if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $val = $_ENV[$key] ?? getenv($key);
        return ($val !== false && $val !== null && $val !== '') ? $val : $default;
    }
}

// ── Application Constants ────────────────────────────────────────────────────
define('APP_NAME',    env('APP_NAME',    'Stitch Smart'));
define('APP_ENV',     env('APP_ENV',     'development'));
define('APP_DEBUG',   filter_var(env('APP_DEBUG', true), FILTER_VALIDATE_BOOLEAN));
define('BASE_URL',    env('APP_URL',     'http://localhost:8000/'));

// ── Google Gemini Constants for Admin AI ─────────────────────────────────────
define('GOOGLE_API_KEY', env('GOOGLE_API_KEY', ''));
define('GEMINI_MODEL',    env('GEMINI_MODEL',    'gemini-1.5-flash'));

// ── Chatbot ──────────────────────────────────────────────────────────────────
define('CHATBOT_API_URL',     env('CHATBOT_API_URL',     'http://localhost:5000'));
define('CHATBOT_API_TIMEOUT', (int) env('CHATBOT_API_TIMEOUT', 10));

// ── Mail ─────────────────────────────────────────────────────────────────────
define('MAIL_HOST',       env('MAIL_HOST',       'smtp.gmail.com'));
define('MAIL_PORT',       (int) env('MAIL_PORT', 587));
define('MAIL_USERNAME',   env('MAIL_USERNAME',   ''));
define('MAIL_PASSWORD',   env('MAIL_PASSWORD',   ''));
define('MAIL_ENCRYPTION', env('MAIL_ENCRYPTION', 'tls'));
define('MAIL_FROM_NAME',  env('MAIL_FROM_NAME',  APP_NAME));

// ── Theme ─────────────────────────────────────────────────────────────────────
// $global_theme is set dynamically from DB settings in the router / controllers.
// Default fallback:
if (!isset($global_theme)) {
    $global_theme = 'theme-luxury';
}