<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Database;
use App\Models\User;

final class AuthController extends BaseController
{
    public function showLogin(): void
    {
        if (auth_user() !== null) {
            $this->redirectTo('dashboard');
        }
        $this->renderView('auth/login', ['title' => 'Masuk']);
    }

    public function showRegister(): void
    {
        if (auth_user() !== null) {
            $this->redirectTo('dashboard');
        }
        $this->renderView('auth/register', ['title' => 'Daftar Akun']);
    }

    public function register(): void
    {
        verify_csrf_or_abort();

        $username   = trim((string) ($_POST['username'] ?? ''));
        $full_name  = trim((string) ($_POST['full_name'] ?? ''));
        $password   = (string) ($_POST['password'] ?? '');
        $password2  = (string) ($_POST['password_confirmation'] ?? '');

        set_old(['username' => $username, 'full_name' => $full_name]);

        // Validasi
        if ($username === '' || $full_name === '' || $password === '') {
            set_flash('error', 'Semua field wajib diisi.');
            $this->redirectTo('register');
        }

        if (text_length($username) > 60) {
            set_flash('error', 'Username maksimal 60 karakter.');
            $this->redirectTo('register');
        }

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            set_flash('error', 'Username hanya boleh huruf, angka, dan underscore.');
            $this->redirectTo('register');
        }

        if (text_length($password) < 6) {
            set_flash('error', 'Password minimal 6 karakter.');
            $this->redirectTo('register');
        }

        if ($password !== $password2) {
            set_flash('error', 'Konfirmasi password tidak cocok.');
            $this->redirectTo('register');
        }

        // Cek username sudah dipakai
        $existing = User::findByUsername($username);
        if ($existing !== null) {
            set_flash('error', 'Username sudah digunakan, pilih username lain.');
            $this->redirectTo('register');
        }

        // Simpan user baru
        $stmt = Database::connection()->prepare(
            'INSERT INTO users (username, password_hash, full_name, role) VALUES (:username, :password_hash, :full_name, :role)'
        );
        $stmt->execute([
            'username'      => $username,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]),
            'full_name'     => $full_name,
            'role'          => 'user',
        ]);

        set_flash('success', 'Akun berhasil dibuat. Silakan login.');
        clear_old();
        $this->redirectTo('login');
    }

    public function login(): void
    {
        verify_csrf_or_abort();
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        set_old(['username' => $username]);

        if ($username === '' || $password === '' || text_length($username) > 60) {
            set_flash('error', 'Username dan password wajib diisi.');
            $this->redirectTo('login');
        }

        $user = User::findByUsername($username);
        if ($user === null || !password_verify($password, (string) $user['password_hash'])) {
            set_flash('error', 'Username atau password salah.');
            $this->redirectTo('login');
        }

        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'        => (int) $user['id'],
            'username'  => (string) $user['username'],
            'full_name' => (string) $user['full_name'],
            'role'      => (string) $user['role'],
        ];
        unset($_SESSION['_csrf_token']);
        clear_old();
        set_flash('success', 'Berhasil login. Selamat datang, ' . $user['full_name'] . '.');
        $this->redirectTo('dashboard');
    }

    public function logout(): void
    {
        verify_csrf_or_abort();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires'  => time() - 42000,
                'path'     => $params['path'],
                'domain'   => $params['domain'],
                'secure'   => $params['secure'],
                'httponly' => $params['httponly'],
                'samesite' => $params['samesite'] ?? 'Lax',
            ]);
        }
        session_destroy();
        $this->redirectTo('login');
    }
}
