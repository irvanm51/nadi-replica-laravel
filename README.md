# NADI - Narasi Akademik Data Terintegratif

Demo aplikasi akademik berbasis Laravel dengan autentikasi JWT dan 2 role pengguna (**Staf** dan **Dosen**), masing-masing dengan modul dan dummy data sendiri.

## Fitur

- Login dengan verifikasi keamanan (captcha matematika) yang fungsional dan tervalidasi di server
- Autentikasi berbasis **JWT** (`tymon/jwt-auth`), token disimpan di cookie httpOnly, seluruh secret/TTL dikonfigurasi lewat `.env`
- 2 role dengan hak akses menu yang berbeda, digating di level route/middleware (bukan hanya disembunyikan di tampilan)
- Modul **Staf**: Data Mahasiswa, Surat & Dokumen, Keuangan/SPP, Laporan Akademik
- Modul **Dosen**: Jadwal Mengajar, Input Nilai, Presensi Mahasiswa, Bimbingan Skripsi
- Setiap modul menampilkan tabel dengan dummy data (seeder/factory) lengkap dengan pencarian dan pagination

## Requirements

| Kebutuhan | Versi minimum | Cek dengan |
|---|---|---|
| PHP | 8.3+ | `php -v` |
| Composer | 2.x | `composer -V` |
| Node.js & npm | Node 18+ | `node -v` |
| MySQL | 8.x (atau kompatibel) | `mysql --version` |

Ekstensi PHP standar yang dibutuhkan Laravel (biasanya sudah aktif secara default): `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`.

### Instalasi prasyarat (macOS + Homebrew)

Jika Composer/MySQL belum terpasang:

```bash
brew install composer mysql
brew services start mysql
```

## Instalasi & Menjalankan Aplikasi (dari awal sampai running)

1. **Clone / masuk ke folder proyek**

   ```bash
   cd nadi-replica-laravel
   ```

2. **Install dependency PHP**

   ```bash
   composer install
   ```

3. **Salin file environment & generate app key**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Buat database MySQL**

   ```bash
   mysql -u root -e "CREATE DATABASE IF NOT EXISTS nadi;"
   ```

   Sesuaikan `DB_USERNAME` / `DB_PASSWORD` di `.env` bila MySQL Anda menggunakan kredensial berbeda dari default (`root` tanpa password).

5. **Generate JWT secret**

   ```bash
   php artisan jwt:secret
   ```

   Perintah ini otomatis mengisi `JWT_SECRET` di `.env`. Variabel JWT lain yang bisa dikonfigurasi di `.env`:

   | Variabel | Default | Keterangan |
   |---|---|---|
   | `JWT_SECRET` | (auto) | Kunci untuk menandatangani token |
   | `JWT_TTL` | `60` | Masa berlaku token (menit) untuk sesi normal |
   | `JWT_REFRESH_TTL` | `20160` | Masa berlaku token (menit) saat "Ingat saya" dicentang (14 hari) |
   | `JWT_COOKIE_NAME` | `nadi_token` | Nama cookie httpOnly tempat token disimpan |

6. **Migrasi & seed database**

   ```bash
   php artisan migrate --seed
   ```

   Ini akan membuat seluruh tabel (users + 8 tabel modul) dan mengisi dummy data, termasuk 2 akun demo login.

7. **Install dependency frontend & build asset**

   ```bash
   npm install
   npm run build
   ```

   Untuk development dengan hot-reload, gunakan `npm run dev` di terminal terpisah, lalu jalankan langkah 8 di terminal lain.

8. **Jalankan server**

   ```bash
   php artisan serve
   ```

9. **Buka aplikasi**

   Akses [http://127.0.0.1:8000](http://127.0.0.1:8000) — otomatis diarahkan ke halaman login.

## Akun Demo

| Role | Email | Password |
|---|---|---|
| Staf | `staf@nadi.ac.id` | `password` |
| Dosen | `dosen@nadi.ac.id` | `password` |

## Reset Data

Untuk mengulang dari awal (drop semua tabel, migrasi ulang, seed ulang):

```bash
php artisan migrate:fresh --seed
```

## Struktur Modul Singkat

```
app/Http/Controllers/Auth/     Login & captcha
app/Http/Controllers/Staf/     4 controller modul staf
app/Http/Controllers/Dosen/    4 controller modul dosen
app/Http/Middleware/           JwtCookieAuthenticate, RedirectIfJwtAuthenticated, CheckRole
resources/views/auth/login.blade.php     Halaman login
resources/views/layouts/                 Layout guest & authenticated
resources/views/staf/, dosen/            View index tiap modul
database/seeders/, database/factories/   Dummy data generator
```
