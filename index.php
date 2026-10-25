<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\RecordController;
use App\Models\Record;

$page = (string) ($_GET['page'] ?? (auth_user() ? 'dashboard' : 'login'));
$method = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));
$authController = new AuthController();
$recordRepository = new Record();
$dashboardController = new DashboardController($recordRepository);
$recordController = new RecordController($recordRepository);

try {
    switch ($page) {
        case 'login':
            $method === 'POST' ? $authController->login() : $authController->showLogin();
            break;
        case 'register':
            $method === 'POST' ? $authController->register() : $authController->showRegister();
            break;
        case 'logout':
            require_post($method);
            $authController->logout();
            break;
        case 'dashboard':
            require_login();
            $dashboardController->index();
            break;
        case 'records':
            require_login();
            $recordController->index();
            break;
        case 'records-create':
            require_login();
            $method === 'POST' ? $recordController->store() : $recordController->create();
            break;
        case 'records-edit':
            require_login();
            $recordController->edit((int) ($_GET['id'] ?? 0));
            break;
        case 'records-update':
            require_login();
            require_post($method);
            $recordController->update((int) ($_GET['id'] ?? 0));
            break;
        case 'records-delete':
            require_login();
            require_post($method);
            $recordController->delete((int) ($_POST['id'] ?? 0));
            break;
        default:
            http_response_code(404);
            render('errors/404', ['title' => 'Halaman tidak ditemukan']);
    }
} catch (Throwable $exception) {
    error_log((string) $exception);
    http_response_code(500);
    render('errors/500', ['title' => 'Terjadi kesalahan']);
}
