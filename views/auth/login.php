<div class="login-heading"><p class="eyebrow">SELAMAT DATANG KEMBALI</p><h2>Login ke akun</h2><p>Masuk untuk mengelola data master.</p></div>
<form method="post" action="<?= e(url('login')) ?>" class="form-stack" autocomplete="on">
    <?= csrf_field() ?>
    <div class="field"><label for="username">Username</label><input id="username" name="username" type="text" value="<?= e(old('username')) ?>" maxlength="60" autocomplete="username" required autofocus placeholder="Masukkan username"><small>Gunakan akun demo pada README.</small></div>
    <div class="field"><label for="password">Password</label><input id="password" name="password" type="password" autocomplete="current-password" required placeholder="Masukkan password"></div>
    <button type="submit" class="btn btn-primary btn-block">Masuk ke Dashboard <span>→</span></button>
</form>
<p class="auth-switch">Belum punya akun? <a href="<?= e(url('register')) ?>">Daftar akun</a></p>
<div class="auth-footer"><span>●</span> Aplikasi latihan lokal · Jangan gunakan password demo di server publik.</div>
