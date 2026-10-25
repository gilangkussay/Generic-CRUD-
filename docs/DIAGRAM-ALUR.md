# Diagram Spesifikasi Program

Dokumen diagram awal untuk latihan. Revisi sesuai instruksi aktual dan jangan anggap entitas contoh ini sebagai ketentuan soal resmi.

## ERD sederhana

```mermaid
erDiagram
    USERS ||--o{ MASTER_RECORDS : creates
    USERS {
        bigint id PK
        varchar username UK
        varchar password_hash
        varchar full_name
        enum role
    }
    MASTER_RECORDS {
        bigint id PK
        varchar record_code UK
        varchar name
        varchar category
        varchar description
        decimal numeric_value
        enum status
        bigint created_by FK
        timestamp created_at
        timestamp updated_at
    }
```

## Alur autentikasi

```mermaid
flowchart TD
    A[Pengunjung membuka aplikasi] --> B{Pilih aksi}
    B -- Daftar --> C[Form pendaftaran]
    C --> D[Validasi nama, username, dan password]
    D --> E{Valid dan username unik?}
    E -- Tidak --> C
    E -- Ya --> F[Hash password dan simpan role user]
    F --> G[Regenerasi ID session]
    B -- Login --> H[Form login]
    H --> I[Verifikasi kredensial]
    I --> J{Cocok?}
    J -- Tidak --> H
    J -- Ya --> G
    G --> K[Dashboard]
    K --> L[Kelola Data Master]
    L --> M[Validasi server dan CSRF]
    M --> N[Model menjalankan query PDO]
    N --> O[Database menyimpan/perbarui/menghapus data]
    O --> K
    K --> P[Logout POST]
    P --> Q[Hapus session]
```

## Alur data CRUD

1. Form mengirim HTTP POST dengan token CSRF.
2. Controller mengambil dan memvalidasi input server-side.
3. Controller memanggil repository melalui `RecordRepositoryInterface`.
4. Model menggunakan PDO prepared statements untuk menjalankan SQL.
5. Controller menampilkan pesan hasil atau mengalihkan pengguna.
6. View melakukan escaping nilai dengan helper `e()` saat menampilkan data.
