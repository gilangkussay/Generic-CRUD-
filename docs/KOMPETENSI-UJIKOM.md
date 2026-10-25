# Pemetaan Kompetensi Programmer

Halaman skema resmi LSP Universitas Pamulang mencantumkan enam unit kompetensi untuk Skema Okupasi Pemrogram (Programmer):

1. J.620100.009.01 — Menggunakan Spesifikasi Program.
2. J.620100.016.01 — Menulis Kode Dengan Prinsip Sesuai Guidelines dan Best Practices.
3. J.620100.017.02 — Mengimplementasikan Pemrograman Terstruktur.
4. J.620100.018.02 — Mengimplementasikan Pemrograman Berorientasi Objek.
5. J.620100.019.02 — Menggunakan Library atau Komponen Pre-Existing.
6. J.620100.021.02 — Menerapkan Akses Basis Data.

Sumber: https://lsp.unpam.ac.id/skema (dilihat 24 Oktober 2026).

## Catatan standar dan bukti unjuk kerja

Dokumen SKKNI bidang Software Development subbidang Pemrograman (Keputusan Menteri Ketenagakerjaan No. 282 Tahun 2016) merinci beberapa kriteria unjuk kerja yang relevan. Di antara contohnya:

- Penulisan kode: mengikuti guideline/best practice, memakai struktur yang sesuai paradigma, dan menangani error.
- Pemrograman terstruktur: memakai tipe data dan struktur kontrol yang sesuai, menghasilkan program yang dapat dieksekusi serta bebas kesalahan sintaks.
- OOP: memanfaatkan class, property/method dan hak akses; standar juga menyebut konsep inheritance, polymorphism, interface dan package.
- Akses basis data: operasi simpan/ubah/hapus/cari, library akses data, koneksi dan keamanan, penggunaan indeks, serta skenario pengujian.

Sumber standar: [SKKNI 2016-282 bidang Software Development subbidang Pemrograman (PDF)](https://ppkpijakarta.com/skkni/SKKNI%202016-282.pdf). Detail unit di dalam dokumen lama dapat memakai versi kode yang berbeda dari halaman skema LSP UNPAM saat ini; cocokkan kode dan kriteria resmi yang dibagikan asesor.

## Bukti latihan pada proyek
| Unit kompetensi | Bukti praktik yang dapat ditunjukkan |
|---|---|
| Spesifikasi program | `docs/SPESIFIKASI-LATIHAN.md`, pemetaan persyaratan, alur fitur, validasi dan pengujian |
| Guidelines/best practices | Penamaan class/method konsisten, escaping output, prepared statements, config di `.env`, server-side validation |
| Pemrograman terstruktur | Kondisi, perulangan, fungsi helper, pemisahan tanggung jawab dan alur controller |
| OOP | `Database`, `Csrf`, `RecordRepositoryInterface`, `BaseController`, `User`, `Record`, `AuthController`, `RecordController`, `DashboardController`; `Record` mengimplementasikan interface dan controller memakai dependency injection |
| Komponen/library | PDO, password hashing, session, fungsi standar PHP; tidak ada dependency pihak ketiga yang wajib |
| Akses basis data | Pendaftaran akun ke tabel users, CRUD, pencarian, pagination, agregat SQL, indeks, unique key dan foreign key |

## Batasan penting
- Sumber publik tersebut memuat **unit kompetensi**, bukan bobot nilai/perhitungan skor atau soal praktik Gelombang 72.
- Proyek ini adalah template latihan yang disusun untuk membantu melatih unit-unit tersebut. Ini bukan kisi-kisi resmi, jaminan fitur yang akan keluar, atau pengganti arahan asesor.
- Konfirmasi ke instruktur/asesor untuk form asesmen, kriteria unjuk kerja, bukti yang wajib dikumpulkan, durasi dan aturan penggunaan AI/template.
