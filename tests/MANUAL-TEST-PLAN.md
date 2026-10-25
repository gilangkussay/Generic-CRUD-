# Manual Test Plan

Lakukan di Laragon setelah impor SQL dan konfigurasi `.env`.

| ID | Skenario | Langkah | Hasil yang diharapkan |
|---|---|---|---|
| T00 | Daftar akun valid | Buka `index.php?page=register`, isi nama, username unik, password valid, dan konfirmasi yang sama | Akun tersimpan dengan role `user`, password berupa hash, dan pengguna masuk ke dashboard |
| T00A | Username duplikat | Daftar dengan username yang telah terdaftar | Pendaftaran ditolak dan pesan yang mudah dipahami ditampilkan |
| T00B | Password tidak cocok/kurang panjang | Isi konfirmasi berbeda atau password kurang dari 8 karakter | Pendaftaran ditolak oleh validasi |
| T00C | Pendaftaran mengirim role | Coba kirim field `role=admin` dari request | Akun tetap dibuat dengan role `user` karena role ditentukan di server |
| T01 | Login valid | Masuk dengan `admin` / `admin123` | Dialihkan ke dashboard dan session dibuat |
| T02 | Login salah | Masukkan password salah | Ditolak dengan pesan generik |
| T03 | Akses privat tanpa login | Logout lalu buka `index.php?page=records` | Dialihkan ke login |
| T04 | List data | Buka Data Master | Seed data tampil |
| T05 | Tambah data valid | Masukkan kode unik dan field benar | Data tersimpan dan muncul di daftar |
| T06 | Kode duplikat | Tambah kode yang telah ada | Ditolak oleh validasi server/database |
| T07 | Field wajib kosong | Kosongkan kode/nama/kategori | Form ditolak dan kesalahan ditampilkan |
| T08 | Nilai negatif | Masukkan numeric value negatif | Ditolak server-side |
| T09 | Edit data | Ubah nama dan simpan | Perubahan tampil pada daftar |
| T10 | Hapus data | Klik hapus dan konfirmasi | Record terhapus |
| T11 | Batal hapus | Klik hapus lalu batalkan confirm | Record tetap ada |
| T12 | Pencarian | Cari potongan kode/nama/kategori | Hasil terfilter sesuai kata kunci |
| T13 | Pagination | Tambah >10 record | Navigasi halaman bekerja |
| T14 | CSRF invalid | Kirim POST tanpa token | Request ditolak dengan status 419 |
| T15 | Logout | Klik Keluar | Session dihapus, halaman login terlihat |

Catat status untuk setiap tes (Pass/Fail), tanggal, browser/PHP/MySQL version, dan bug yang ditemukan.
