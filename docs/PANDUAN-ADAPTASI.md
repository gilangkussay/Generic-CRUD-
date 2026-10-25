# Panduan Adaptasi Spesifikasi Tugas

Gunakan panduan ini untuk latihan sebelum ujian. Saat mengerjakan asesmen, patuhi aturan asesor tentang materi, template, internet, dan AI.

## 1. Baca soal, jangan menebak
Salin instruksi ke checklist. Bedakan:
- **Wajib:** disebut langsung dalam soal.
- **Tersirat:** dibutuhkan agar alur wajib bekerja (contoh: FK pada relasi siswa-kelas).
- **Opsional:** hanya dibuat jika waktu dan aturan mengizinkan.

## 2. Petakan kebutuhan
| Pertanyaan | Catatan yang dibuat |
|---|---|
| Aplikasi untuk siapa? | Aktor dan hak akses |
| Data apa yang dikelola? | Entitas dan field |
| Hubungan data? | ERD sederhana, PK/FK |
| Operasi apa yang wajib? | Create, Read, Update, Delete, search, report |
| Aturan bisnis? | Unik, wajib, rentang nilai, status, transaksi |
| Bukti hasil? | Tampilan, laporan, cetak, pesan sukses |
| Bagaimana diuji? | Input valid dan invalid untuk setiap fitur |

## 3. Bagian yang umumnya diubah
- `database/schema.sql`: nama tabel, field, tipe data, PK/FK, unique/index, sample data.
- `app/Models/Record.php`: SQL, nama kolom, query list/detail/create/update/delete, statistik.
- `app/Controllers/RecordController.php`: field input, validasi, pesan error, aturan bisnis.
- `views/records/index.php`: kolom tabel, label, filter dan aksi.
- `views/records/form.php`: field form, input type, dropdown/radio dan pesan validasi.
- `views/dashboard/index.php`: statistik yang cocok dengan domain tugas.
- `docs/SPESIFIKASI-LATIHAN.md` dan `README.md`: dokumentasi terbaru.

## 4. Contoh perubahan entitas
Jika soal meminta data siswa, jangan sekadar mengganti label. Ubah skema menjadi misalnya `students(nis, name, class_id, address, status)`, tambahkan `classes`, buat FK, lalu adaptasi model, validasi NIS, dropdown kelas, query join, form dan pengujian.

Jika soal meminta perpustakaan, rancang entitas buku/anggota/peminjaman sesuai instruksi. Jika soal meminta inventaris, pastikan field stok dan aturan keluar-masuk konsisten. Setiap domain memiliki aturan bisnis berbeda.

## 5. Urutan pengerjaan aman
1. Pastikan project bisa dibuka di localhost.
2. Baca semua instruksi dan buat checklist persyaratan.
3. Buat/ubah tabel dan relasi, import SQL, pastikan koneksi.
4. Implementasikan alur paling kecil end-to-end: list → tambah → edit → hapus.
5. Tambahkan validasi dan aturan bisnis.
6. Uji input valid, field kosong, duplikat, angka negatif, ID yang tidak ada, akses tanpa login, serta token CSRF salah.
7. Jalankan `php -l` untuk semua file PHP dan periksa browser/log.
8. Pastikan README dan SQL sesuai versi terakhir.

## 6. Checklist sebelum demo
- [ ] Daftar akun valid berhasil; username duplikat dan password yang tidak cocok ditolak.
- [ ] Akun baru mendapat role `user`, bukan `admin`.
- [ ] Login berhasil dan kredensial salah ditolak.
- [ ] Halaman privat tidak terbuka ketika logout.
- [ ] Semua operasi database memakai prepared statements.
- [ ] Semua form mutasi memakai CSRF.
- [ ] Nilai tampil memakai escaping HTML.
- [ ] Validasi dilakukan di server, bukan hanya atribut HTML.
- [ ] Kode unik/relasi/constraint sesuai aturan bisnis.
- [ ] Tidak ada error PHP yang disembunyikan tanpa dicatat.
- [ ] Dapat menjelaskan alur request → controller → model → database → view.
