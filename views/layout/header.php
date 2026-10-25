<?php
use App\Core\Csrf;
$pageTitle = isset($title) ? (string) $title : env('APP_NAME', 'Template CRUD Ujikom');
$user = auth_user();
$activePage = (string) ($_GET['page'] ?? '');
$flashes = pull_flashes();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> · <?= e(env('APP_NAME', 'Template CRUD Ujikom')) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="<?= !empty($isAuthPage) ? 'auth-body' : 'app-body' ?>">
<?php if (!empty($isAuthPage)): ?>
    <main class="auth-shell">
        <section class="auth-brand">
            <div class="brand-mark">GC</div>
            <p class="eyebrow">PHP NATIVE · MYSQL · OOP</p>
            <h1>Generic CRUD<br>Ujikom Practice</h1>
            <p>Template latihan yang bisa disesuaikan dengan spesifikasi tugas pemrograman.</p>
            <div class="auth-note"><span class="dot"></span> Local development starter kit</div>
        </section>
        <section class="auth-panel">
<?php else: ?>
    <div class="app-shell">
        <aside class="sidebar" id="sidebar">
            <a class="brand" href="<?= e(url('dashboard')) ?>"><span class="brand-mark small">GC</span><span><strong>Generic CRUD</strong><small>Ujikom Practice</small></span></a>
            <div class="nav-label">MENU UTAMA</div>
            <nav class="main-nav">
                <a class="nav-link <?= $activePage === 'dashboard' ? 'active' : '' ?>" href="<?= e(url('dashboard')) ?>"><span class="nav-icon">▦</span>Dashboard</a>
                <a class="nav-link <?= str_starts_with((string) ($_GET['page'] ?? ''), 'records') ? 'active' : '' ?>" href="<?= e(url('records')) ?>"><span class="nav-icon">▤</span>Data Master</a>
            </nav>
            <div class="sidebar-bottom"><p>Template starter</p><span>Adaptasikan nama tabel, field, dan aturan bisnis sesuai soal.</span></div>
        </aside>
        <div class="main-area">
            <header class="topbar">
                <button class="menu-toggle" type="button" id="menuToggle" aria-label="Buka navigasi">☰</button>
                <div><span class="topbar-caption">RUANG KERJA</span><strong><?= e($pageTitle) ?></strong></div>
                <div class="topbar-user"><span class="avatar"><?= e(strtoupper(substr($user['full_name'] ?? 'A', 0, 1))) ?></span><span class="user-details"><strong><?= e($user['full_name'] ?? 'Pengguna') ?></strong><small><?= e($user['role'] ?? 'user') ?></small></span><form method="post" action="<?= e(url('logout')) ?>" class="logout-form"><?= csrf_field() ?><button class="btn btn-ghost btn-sm" type="submit">Keluar ↗</button></form></div>
            </header>
            <main class="content">
<?php endif; ?>
<?php foreach ($flashes as $flash): ?>
    <div class="alert alert-<?= e($flash['type']) ?>" role="status"><span><?= $flash['type'] === 'success' ? '✓' : '!' ?></span><?= e($flash['message']) ?><button class="alert-close" type="button" aria-label="Tutup">×</button></div>
<?php endforeach; ?>
