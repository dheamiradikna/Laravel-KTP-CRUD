# Laravel KTP CRUD

Aplikasi manajemen KTP (Kartu Tanda Penduduk) menggunakan framework Laravel dengan fitur CRUD, export/import, dan kontrol akses berbasis peran.

## Fitur

- CRUD (Create, Read, Update, Delete) data KTP lengkap dengan foto
- Generasi NIK otomatis (16 digit unik)
- Perhitungan umur otomatis berdasarkan tanggal lahir
- Export data ke format CSV & PDF
- Import data dari format CSV
- API untuk mengakses data KTP (return JSON)
- Hak akses berbasis peran (admin & user)
- Pencatatan aktivitas pengguna

## Persyaratan Sistem

- PHP >= 8.1
- Composer
- Node.js & NPM
- SQLite atau MySQL

## Instalasi

1. Clone repositori ini:
   ```
   git clone https://github.com/username/Laravel-KTP-CRUD.git
   cd Laravel-KTP-CRUD
   ```

2. Install dependensi PHP:
   ```
   composer install
   ```

3. Install dependensi JavaScript:
   ```
   npm install
   ```

4. Salin file .env.example menjadi .env:
   ```
   cp .env.example .env
   ```

5. Generate application key:
   ```
   php artisan key:generate
   ```

6. Konfigurasi database di file .env

7. Jalankan migrasi dan seeder:
   ```
   php artisan migrate --seed
   ```

8. Buat symbolic link untuk storage:
   ```
   php artisan storage:link
   ```

9. Compile assets:
   ```
   npm run dev
   ```

10. Jalankan server:
    ```
    php artisan serve
    ```

## Akun Login

1. **Admin**
   - Email: admin@example.com
   - Password: password

2. **User** (Anda dapat mendaftar sendiri melalui halaman register)

## Struktur Database

### Tabel KTP
- id: Primary key
- nik: NIK 16 digit (unik, otomatis)
- nama: Nama lengkap
- tempat_lahir: Tempat lahir
- tanggal_lahir: Tanggal lahir
- jenis_kelamin: Jenis kelamin
- alamat: Alamat lengkap
- rt_rw: RT/RW
- kelurahan_desa: Kelurahan/Desa
- kecamatan: Kecamatan
- agama: Agama
- status_perkawinan: Status perkawinan
- pekerjaan: Pekerjaan
- kewarganegaraan: Kewarganegaraan
- foto: Nama file foto (opsional)
- created_at: Timestamp pembuatan
- updated_at: Timestamp update

### Tabel User Activities
- id: Primary key
- user_id: Foreign key ke tabel users
- description: Deskripsi aktivitas
- created_at: Timestamp aktivitas
- updated_at: Timestamp update

## API Endpoints

### Authentication
- POST /api/login - Login dan dapatkan token
- POST /api/logout - Logout (hapus token)

### KTP
- GET /api/ktps - Dapatkan semua data KTP
- GET /api/ktps/{id} - Dapatkan detail KTP berdasarkan ID
- POST /api/ktps - Buat data KTP baru
- PUT /api/ktps/{id} - Update data KTP
- DELETE /api/ktps/{id} - Hapus data KTP

