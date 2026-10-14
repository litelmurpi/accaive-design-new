# Cloudflare R2 Setup — Accaive Design Studio

Panduan komprehensif untuk setup Cloudflare R2 Object Storage dan integrasi dengan Laravel 11 + Filament v3 di server Railway.

---

## 1. Buat Bucket R2 di Cloudflare
1. Buka [Cloudflare Dashboard](https://dash.cloudflare.com/) lalu login.
2. Di menu navigasi samping kiri, pilih **R2 Object Storage**.
3. Klik tombol **Create bucket**.
4. Beri nama bucket, misal: `accaive-media`.
5. Pilihan *Location*: pilih **Automatic**.
6. Klik **Create bucket**.

---

## 2. Aktifkan Akses Publik (Public Access)
Agar file media yang diunggah dapat diakses oleh publik dan browser:
1. Masuk ke halaman bucket `accaive-media`.
2. Klik tab **Settings**.
3. Scroll ke bagian **Public Access**.
4. Pilih salah satu opsi:
   - **Opsi A (R2.dev Subdomain - Paling Cepat)**:
     - Di box *R2.dev Subdomain*, klik **Allow Access**.
     - Ketik kata konfirmasi `allow` lalu klik confirm.
     - Dapatkan URL publik, contoh: `https://pub-xxxxxxxxxxxxxxxxxxxxxxxx.r2.dev`.
   - **Opsi B (Custom Domain)**:
     - Klik **Connect Domain**, masukkan domain kustom (contoh: `media.accaivedesign.id`).
     - Cloudflare akan otomatis mengonfigurasi DNS record untuk domain tersebut.
5. Catat URL publik ini (tanpa trailing slash `/`), karena nilai ini akan digunakan sebagai `AWS_URL`.

---

## 3. Buat R2 API Token (Kredensial S3-Compatible)
1. Di sidebar kiri, klik menu **R2 Object Storage** (ke dashboard utama R2).
2. Di panel sebelah kanan atas, klik **Manage R2 API Tokens**.
3. Klik tombol **Create API token**.
4. Isi konfigurasi token:
   - **Token name**: `accaive-backend-production`
   - **Permissions**: Pilih **Object Read & Write**
   - **Specify bucket**: Pilih *Apply to specific buckets only* lalu pilih `accaive-media`
   - **TTL**: Biarkan *Forever* (tidak kedaluwarsa)
5. Klik **Create API Token**.
6. **CATAT SEGERA** data kredensial berikut (Secret Key tidak akan ditampilkan lagi):
   - **Access Key ID**
   - **Secret Access Key**
   - **Account ID / S3 Endpoint** (`https://<ACCOUNT_ID>.r2.cloudflarestorage.com`)

---

## 4. Konfigurasi Environment Variables di Railway

Buka project service backend di **Railway** -> tab **Variables**, lalu tambahkan / perbarui variabel berikut:

```env
FILESYSTEM_DISK=s3
FILAMENT_FILESYSTEM_DISK=s3

AWS_ACCESS_KEY_ID=<Access_Key_ID_dari_Step_3>
AWS_SECRET_ACCESS_KEY=<Secret_Access_Key_dari_Step_3>
AWS_DEFAULT_REGION=auto
AWS_BUCKET=accaive-media
AWS_ENDPOINT=https://<ACCOUNT_ID>.r2.cloudflarestorage.com
AWS_URL=https://pub-xxxxxx.r2.dev
AWS_USE_PATH_STYLE_ENDPOINT=true
```

> **Catatan untuk Local Development**:
> Di environment lokal (`backend/.env`), biarkan `FILESYSTEM_DISK=local` agar development lokal tidak mengotori bucket produksi.

---

## 5. Deployment & Migrasi Media Lama

Setelah variabel di-set di Railway dan kode dideploy:

1. **Jalankan dry-run migrasi**:
   ```bash
   php artisan media:migrate-to-r2 --dry-run
   ```
2. **Jalankan migrasi file ke R2**:
   ```bash
   php artisan media:migrate-to-r2
   ```
3. **Verifikasi kelengkapan file media di DB**:
   ```bash
   php artisan media:migrate-to-r2 --verify
   ```

---

## 6. Verifikasi & Pengujian
- **API Endpoint**:
  Lakukan request ke API:
  ```bash
  curl -s https://<RAILWAY_APP_URL>/api/projects | grep -o 'https://[^"]*'
  ```
  Pastikan URL gambar yang dikembalikan berawalan domain R2 (`https://pub-xxxxxx.r2.dev/...` atau custom domain).
- **Filament Admin Panel**:
  Buka `/admin`, coba edit sebuah project atau upload gambar baru. Pastikan gambar berhasil terunggah dan tampil dengan benar.

---

## 7. Rollback Procedure
Jika sewaktu-waktu perlu kembali ke penyimpanan lokal Railway:
1. Di Railway dashboard, ubah:
   ```env
   FILESYSTEM_DISK=local
   FILAMENT_FILESYSTEM_DISK=public
   ```
2. Redeploy service. Backend akan kembali menyajikan file dari disk lokal `storage/app/public`.
