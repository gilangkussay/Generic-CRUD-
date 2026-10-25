<?php
declare(strict_types=1);

use App\Core\Csrf;

function env(string $key, string $default = ''): string
{
    $value = getenv($key);
    return $value === false ? $default : (string) $value;
}

function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function text_length(string $value): int
{
    return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
}

function text_substr(string $value, int $start, ?int $length = null): string
{
    if (function_exists('mb_substr')) {
        return $length === null
            ? mb_substr($value, $start, null, 'UTF-8')
            : mb_substr($value, $start, $length, 'UTF-8');
    }
    return $length === null ? substr($value, $start) : substr($value, $start, $length);
}

function text_strimwidth(string $value, int $start, int $width, string $trimMarker = ''): string
{
    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($value, $start, $width, $trimMarker, 'UTF-8');
    }
    return strlen($value) > $width
        ? substr($value, $start, max(0, $width - strlen($trimMarker))) . $trimMarker
        : substr($value, $start, $width);
}

function url(string $page, array $params = []): string
{
    $query = array_merge(['page' => $page], $params);
    return 'index.php?' . http_build_query($query);
}

function redirect(string $location): never
{
    header('Location: ' . $location);
    exit;
}

function render(string $view, array $data = []): void
{
    extract($data, EXTR_SKIP);
    $viewPath = __DIR__ . '/../../views/' . $view . '.php';
    if (!is_file($viewPath)) {
        http_response_code(500);
        echo 'View tidak ditemukan.';
        return;
    }
    $isAuthPage = str_starts_with($view, 'auth/');
    require __DIR__ . '/../../views/layout/header.php';
    require $viewPath;
    require __DIR__ . '/../../views/layout/footer.php';
}

function auth_user(): ?array
{
    return isset($_SESSION['user']) && is_array($_SESSION['user']) ? $_SESSION['user'] : null;
}

function require_login(): void
{
    if (auth_user() === null) {
        set_flash('error', 'Silakan login terlebih dahulu.');
        redirect(url('login'));
    }
}

function require_post(string $method): void
{
    if ($method !== 'POST') {
        http_response_code(405);
        header('Allow: POST');
        render('errors/405', ['title' => 'Metode tidak diizinkan']);
        exit;
    }
}

function verify_csrf_or_abort(): void
{
    if (!Csrf::valid(isset($_POST['_token']) ? (string) $_POST['_token'] : null)) {
        http_response_code(419);
        render('errors/419', ['title' => 'Sesi formulir kedaluwarsa']);
        exit;
    }
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(Csrf::token()) . '">';
}

function set_flash(string $type, string $message): void
{
    $_SESSION['_flash'][] = ['type' => $type, 'message' => $message];
}

function pull_flashes(): array
{
    $flashes = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
    return is_array($flashes) ? $flashes : [];
}

function old(string $key, mixed $default = ''): mixed
{
    return $_SESSION['_old'][$key] ?? $default;
}

function set_old(array $values): void
{
    $_SESSION['_old'] = $values;
}

function clear_old(): void
{
    unset($_SESSION['_old']);
}

function format_number(mixed $number): string
{
    return number_format((float) $number, 2, ',', '.');
}
