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

## Menjalankan dengan Docker

Sebagai alternatif instalasi manual di atas, aplikasi ini juga bisa dijalankan sepenuhnya lewat Docker (Nginx + PHP-FPM + MySQL, 3 container terpisah via `docker-compose`).

**Requirements**: Docker Engine + Docker Compose (`docker --version`, `docker-compose --version` atau `docker compose version`).

1. **Siapkan file `.env`** (jika belum ada)

   ```bash
   cp .env.example .env
   ```

2. **Build image**

   ```bash
   docker-compose build
   ```

   Proses ini meng-compile asset Tailwind/Vite di build stage terpisah (Node) lalu menyalin hasilnya ke image PHP-FPM final — image production tidak membutuhkan Node runtime.

3. **Jalankan seluruh stack**

   ```bash
   docker-compose up -d
   ```

   Ini menjalankan 3 service:
   - `db` — MySQL 8.0 (database `nadi`, tanpa password root, data persisten di volume `db_data`)
   - `app` — PHP-FPM yang menjalankan kode Laravel (menunggu `db` sehat lebih dulu)
   - `webserver` — Nginx yang melayani request di `http://localhost:8081` dan meneruskan proses `.php` ke `app` lewat FastCGI

4. **Generate `APP_KEY` & `JWT_SECRET`** (hanya perlu sekali, jika `.env` masih kosong)

   ```bash
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan jwt:secret
   ```

   Karena `.env` di-mount langsung ke dalam container `app`, perubahan yang ditulis oleh perintah di atas otomatis tersimpan kembali ke file `.env` di host.

5. **Migrasi & seed database** (manual, dijalankan sendiri kapan pun dibutuhkan — bukan otomatis saat container start)

   ```bash
   docker-compose exec app php artisan migrate --seed
   ```

6. **Buka aplikasi**

   Akses [http://localhost:8081](http://localhost:8081).

### Perintah Docker yang berguna

```bash
docker-compose logs -f app          # lihat log aplikasi
docker-compose exec app php artisan migrate:fresh --seed   # reset total data
docker-compose exec app bash        # masuk ke shell container app
docker-compose down                 # stop semua container (data DB tetap di volume)
docker-compose down -v              # stop + hapus semua volume (termasuk data DB & cache asset)
```

> Catatan: `app_public` (asset hasil build Tailwind/Vite) dan `storage_data` adalah named volume yang otomatis terisi dari konten image saat pertama kali dibuat. Jika mengubah tampilan/CSS lalu `docker-compose build` ulang, jalankan `docker-compose down -v && docker-compose up -d` agar Nginx mengambil asset baru (bukan sekadar `restart`).

Konfigurasi Docker berada di:
```
docker-compose.yml           Definisi 3 service (app, webserver, db)
docker/php/Dockerfile        Multi-stage build: Node (asset) → PHP-FPM (Alpine)
docker/nginx/default.conf    Konfigurasi vhost Nginx (proxy .php ke app:9000)
```

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
