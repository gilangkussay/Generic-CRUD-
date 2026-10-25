<div class="login-heading"><p class="eyebrow">BUAT AKUN BARU</p><h2>Daftar akun</h2><p>Isi data di bawah untuk membuat akun baru.</p></div>
<form method="post" action="<?= e(url('register')) ?>" class="form-stack" autocomplete="off">
    <?= csrf_field() ?>
    <div class="field">
        <label for="full_name">Nama Lengkap</label>
        <input id="full_name" name="full_name" type="text" value="<?= e(old('full_name')) ?>" maxlength="120" required autofocus placeholder="Masukkan nama lengkap">
    </div>
    <div class="field">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?= e(old('username')) ?>" maxlength="60" autocomplete="username" required placeholder="Huruf, angka, underscore">
        <small>Hanya boleh huruf, angka, dan underscore (_).</small>
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" autocomplete="new-password" required placeholder="Minimal 6 karakter">
    </div>
    <div class="field">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required placeholder="Ulangi password">
    </div>
    <button type="submit" class="btn btn-primary btn-block">Buat Akun <span>→</span></button>
</form>
<p class="auth-switch">Sudah punya akun? <a href="<?= e(url('login')) ?>">Login di sini</a></p>
<div class="auth-footer"><span>●</span> Aplikasi latihan lokal · Jangan gunakan password asli di sini.</div>
