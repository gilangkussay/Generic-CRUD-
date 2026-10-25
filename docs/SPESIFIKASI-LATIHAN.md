# Spesifikasi Template CRUD Generik (Latihan)

> Ini adalah spesifikasi latihan, bukan lembar soal atau rubrik nilai resmi Ujikom UNPAM.

## Tujuan
Membangun aplikasi web administrasi data master dengan PHP Native, MySQL, OOP, autentikasi, dan fungsi CRUD.

## Aktor
- **Pengunjung:** dapat membuka halaman login dan pendaftaran akun.
- **Pengguna yang sudah mendaftar/login:** melihat dashboard, mencari, menambah, mengubah, dan menghapus data.
- Pendaftaran publik hanya membuat akun dengan role `user`; pengunjung tidak dapat memilih role administrator.

## Entitas contoh
Tabel `master_records` memakai field:
- `id`: primary key auto increment.
- `record_code`: kode unik, wajib.
- `name`: nama data, wajib.
- `category`: kategori, wajib.
- `description`: keterangan opsional.
- `numeric_value`: nilai angka/jumlah non-negatif.
- `status`: `active` atau `inactive`.
- `created_by`: relasi ke pengguna pembuat.
- `created_at`, `updated_at`: timestamp.

## Persyaratan fungsional
1. Pengunjung dapat mendaftar dengan nama lengkap, username unik, password, dan konfirmasi password.
2. Validasi pendaftaran dilakukan di server; password disimpan sebagai hash dan akun baru mendapat role `user`.
3. Login memakai username dan password ter-hash.
4. Logout mengakhiri sesi dan hanya menerima POST.
5. Halaman privat memerlukan sesi pengguna.
6. Dashboard menampilkan total data, jumlah aktif, kategori unik, dan agregat nilai angka.
7. Pengguna dapat melihat daftar, mencari berdasarkan kode/nama/kategori, dan menavigasi halaman.
8. Pengguna dapat menambah, mengedit, dan menghapus data.
9. Server memvalidasi field wajib, panjang karakter, format kode, kode unik, nilai angka, serta status.
10. Form mutasi menggunakan token CSRF.
11. Output yang berasal dari pengguna di-escape sebelum ditampilkan.
12. Operasi database menggunakan PDO prepared statements.

## Persyaratan non-fungsional
- PHP 8.1+ dengan ekstensi PDO MySQL (`mbstring` direkomendasikan).
- MySQL/MariaDB yang mendukung InnoDB.
- Tidak membutuhkan Composer atau koneksi internet untuk menjalankan aplikasi.
- Layout responsif dan pesan kesalahan mudah dipahami.
- Konfigurasi lokal disimpan di `.env` dan tidak di-commit.

## Batasan
Field contoh harus diubah jika tugas aktual meminta entitas yang berbeda. Fitur seperti role granular, upload gambar, export Excel, atau laporan khusus tidak dianggap wajib kecuali tertulis pada instruksi tugas.
