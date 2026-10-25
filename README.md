# Generic CRUD Ujikom Practice

**Update:** fitur pendaftaran akun (`Daftar akun`) tersedia. Akun pendaftar diberi role `user` oleh server dan tidak bisa memilih role admin melalui form.

Template latihan aplikasi administrasi data master menggunakan **PHP Native + MySQL + OOP**. Disiapkan untuk belajar CRUD, validasi, login/session, PDO, dan pengelolaan spesifikasi program.

> **Penting:** ini adalah proyek latihan yang dipetakan ke kompetensi publik skema Pemrogram (Programmer) LSP UNPAM. Ini bukan soal resmi, rubrik skor, atau jaminan bahwa ujian memakai CRUD generik. Sesuaikan dengan instruksi aktual dan aturan asesor.

## Fitur
- Daftar akun baru dengan validasi nama, format username, password minimal, konfirmasi password, dan pengecekan username unik. Akun pendaftar otomatis mendapat role `user`.
- Login/logout menggunakan PHP session dan `password_hash`/`password_verify`.
- Dashboard ringkasan.
- CRUD data master, pencarian, pagination.
- Validasi server-side untuk required field, panjang teks, format kode, keunikan kode, nilai angka, dan status.
- PDO prepared statements, CSRF token, escaping output.
- SQL dengan unique/index/foreign key.
- README, spesifikasi latihan, panduan adaptasi, prompt AI, dan manual test plan.

## Persyaratan
- PHP 8.1+ (disarankan PHP 8.2+).
- Ekstensi PHP `pdo_mysql` aktif; `mbstring` direkomendasikan untuk validasi panjang teks Unicode (template menyediakan fallback bila tidak aktif).
- MySQL 5.7+/MariaDB yang mendukung InnoDB.
- Laragon atau Apache/Nginx + PHP.

## Instalasi Laragon
1. Ekstrak folder proyek sebagai `C:\laragon\www\generic-crud-ujikom`.
2. Buka Laragon, tekan **Start All** untuk Apache/Nginx dan MySQL.
3. Buka phpMyAdmin, pilih menu **Import**, lalu pilih `database/schema.sql` dan jalankan. SQL ini membuat database `generic_crud_ujikom`.
4. Salin `.env.example` menjadi `.env` pada folder proyek. SQL ini akan menghapus dan membuat ulang tabel template dengan nama sama jika diimpor ulang; gunakan database latihan kosong dan backup dulu data yang diperlukan.
5. Sesuaikan `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, dan `DB_PASS` dengan konfigurasi MySQL lokal.
6. Pastikan ekstensi `pdo_mysql` aktif pada PHP yang digunakan Laragon. `mbstring` direkomendasikan, tetapi template menyediakan fallback dasar bila extension tersebut tidak tersedia.
7. Buka `http://localhost/generic-crud-ujikom/`.

### Akun demo lokal
- Username: `admin`
- Password: `admin123`
- Pengguna baru juga dapat membuat akun melalui tautan **Daftar akun** pada halaman login.

Akun demo tidak untuk deployment publik. Ubah password dan siapkan kebijakan akses yang sesuai sebelum aplikasi digunakan di server publik.

## Struktur inti
```text
app/
  Controllers/   # autentikasi, dashboard, CRUD
  Core/          # koneksi PDO dan CSRF
  Models/        # query database
  Support/       # helper dan pembacaan .env
assets/          # CSS dan JavaScript
views/           # tampilan login, register, dashboard, form, daftar
database/        # schema.sql dan data demo
docs/            # spesifikasi, ERD/alur, peta kompetensi, panduan, prompt AI
tests/           # skenario uji manual
index.php        # front controller
bootstrap.php    # autoload, env dan session
```

## Menjalankan pemeriksaan sintaks
Buka CMD di folder proyek:
```bat
for /R %f in (*.php) do @php -l "%f"
```
Untuk perintah di file `.bat`, gunakan `%%f` alih-alih `%f`.

Koneksi database dan alur CRUD harus dites di Laragon, karena pemeriksaan sintaks tidak membuktikan integrasi database berjalan. Ikuti `tests/MANUAL-TEST-PLAN.md`. Dari CMD, `tests\check-syntax.bat` dapat dipakai untuk memeriksa sintaks semua file PHP. Diagram awal tersedia di `docs/DIAGRAM-ALUR.md`.

## GitHub
Pastikan `.env` tidak di-commit. Jalankan di CMD pada folder proyek:
```bat
git init
git add .
git status
git commit -m "Initial generic CRUD practice template"
git branch -M main
git remote add origin https://github.com/USERNAME/generic-crud-ujikom.git
git push -u origin main
```
Ganti URL dengan repository milik sendiri. Periksa `git status` sebelum push.

## Menyesuaikan dengan tugas lain
Baca `docs/PANDUAN-ADAPTASI.md`. Bagian paling umum diadaptasi adalah `database/schema.sql`, `app/Models/Record.php`, `app/Controllers/RecordController.php`, `views/records/index.php`, `views/records/form.php`, dan statistik dashboard. Jangan hanya mengganti label jika field/relasi serta aturan bisnis ikut berbeda.

Prompt untuk coding assistant tersedia di `docs/PROMPT-AI-UJIKOM.md`. Gunakan untuk belajar dan memetakan kebutuhan. Pada asesmen langsung, patuhi kebijakan penggunaan AI/template dari penyelenggara.

## Kriteria kompetensi publik yang dirujuk
LSP UNPAM mempublikasikan enam unit untuk Skema Okupasi Pemrogram (Programmer):
- J.620100.009.01 — Menggunakan Spesifikasi Program.
- J.620100.016.01 — Menulis Kode Dengan Prinsip Sesuai Guidelines dan Best Practices.
- J.620100.017.02 — Mengimplementasikan Pemrograman Terstruktur.
- J.620100.018.02 — Mengimplementasikan Pemrograman Berorientasi Objek.
- J.620100.019.02 — Menggunakan Library atau Komponen Pre-Existing.
- J.620100.021.02 — Menerapkan Akses Basis Data.

Sumber resmi: https://lsp.unpam.ac.id/skema (diakses 24 Oktober 2026).

Halaman publik tersebut tidak memuat bobot skor atau lembar soal untuk Gelombang 72. Konfirmasikan kriteria unjuk kerja, bukti asesmen, durasi, dan aturan penggunaan alat kepada instruktur/asesor.
