# Panduan Lengkap Deployment: Accaive Design Studio

**Arsitektur: Vercel (Frontend) + Railway (Backend & CMS) + 1 Domain Kustom (.id)**

---

## 💡 Jawaban Pertanyaan: "Beli 1 Domain, Apakah Bisa Dipakai untuk Vercel & CMS Sekaligus?"

> **Jawabannya: BISA BANGET dan 100% GRATIS (tidak perlu beli domain tambahan)!**

Saat Anda membeli **1 domain** (misalnya `accaive.id`), Anda mendapatkan hak penuh untuk membuat **subdomain tanpa batas** secara gratis melalui panel DNS domain Anda.

Contoh pembagian 1 domain tersebut:

1. **Domain Utama** (`accaive.id` dan `www.accaive.id`) $\rightarrow$ Diarahkan ke **Vercel** (untuk website Company Profile / Portofolio publik).
2. **Subdomain** (`admin.accaive.id`) $\rightarrow$ Diarahkan ke **Railway** (untuk CMS Filament v3 klien & API).

Keduanya berjalan berdampingan secara mandiri, aman, dan sangat profesional.

---

## 🛠️ Persiapan Awal (Local Project)

Pastikan semua perubahan terbaru sudah di-commit dan di-push ke GitHub:

```bash
git add .
git commit -m "feat: setup vercel config and production readiness"
git push origin main
```

---

## 📋 Langkah Demi Langkah Deployment

### TAHAP 1: Pembelian Domain (.id)

1. Beli domain pilihan Anda (misal: `accaive.id` atau `accaivedesign.id`) di penyedia lokal seperti **DomaiNesia**, **IDCloudHost**, atau **Niagahoster**.
2. Selesaikan pembayaran hingga domain aktif.
3. Buka menu **DNS Management** atau **Zone Editor** di dashboard domain Anda. *(Biarkan tab ini terbuka untuk diisi di Tahap 4)*.

---

### TAHAP 2: Deploy Backend CMS di Railway.app

1. **Buat Project di Railway**:

   - Buka [Railway.app](https://railway.app) dan login dengan akun **GitHub**.
   - Klik tombol **"+ New Project"**.
   - Pilih **"Provision PostgreSQL"** *(Database PostgreSQL akan otomatis terbuat)*.
2. **Deploy Laravel Backend**:

   - Di project yang sama pada dashboard Railway, klik tombol **"+ New"** $\rightarrow$ pilih **"GitHub Repo"**.
   - Pilih repository project Anda.
   - Klik kotak service Laravel tersebut, lalu masuk ke tab **Settings**:
     - **Root Directory**: Ubah menjadi `/backend`
     - **Build Command**:
       ```bash
       composer install --no-dev --optimize-autoloader
       ```
     - **Deploy / Start Command**:
       ```bash
       php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT
       ```
3. **Konfigurasi Environment Variables di Railway**:
   Buka tab **Variables** pada service Laravel, lalu masukkan:

   - `APP_NAME` : `Accaive Design Studio`
   - `APP_ENV` : `production`
   - `APP_DEBUG` : `false`
   - `APP_KEY` : `base64:Vyg9S7xcIZeTBPUo9cfx5ixTyfGFeb9UfM0rJdN+8dY=`
   - `APP_URL` : `https://admin.accaive.id`
   - `DB_CONNECTION` : `pgsql`
   - `DB_HOST` : `${{Postgres.PGHOST}}`
   - `DB_PORT` : `${{Postgres.PGPORT}}`
   - `DB_DATABASE` : `${{Postgres.PGDATABASE}}`
   - `DB_USERNAME` : `${{Postgres.PGUSER}}`
   - `DB_PASSWORD` : `${{Postgres.PGPASSWORD}}`
4. **Tambahkan Persistent Volume (Agar Foto Proyek Tidak Hilang Saat Redeploy)**:

   - Di dashboard Railway, klik tombol **"+ New"** $\rightarrow$ pilih **"Volume"**.
   - Hubungkan Volume ke service Laravel.
   - Atur **Mount Path** ke: `/app/backend/storage/app/public`
5. **Buat Akun Login Klien (Filament Admin)**:

   - Setelah status deployment Laravel hijau (*Success*), buka tab **Deployments** $\rightarrow$ klik icon terminal / tombol **View Logs / Terminal**.
   - Jalankan perintah:
     ```bash
     php artisan make:filament-user
     ```
   - Masukkan Nama, Email, dan Password untuk klien Anda.
6. **Atur Custom Subdomain di Railway**:

   - Di tab **Settings** service Laravel $\rightarrow$ scroll ke bagian **Custom Domains**.
   - Masukkan: `admin.accaive.id`
   - Salin nilai CNAME yang diberikan oleh Railway (contoh: `xxxx.up.railway.app`).

---

### TAHAP 3: Deploy Frontend di Vercel

1. Buka [Vercel.com](https://vercel.com) dan login dengan akun **GitHub**.
2. Klik tombol **"Add New..."** $\rightarrow$ pilih **"Project"**.
3. Pilih repository project Anda, lalu klik **"Import"**.
4. Di halaman konfigurasi:
   - **Framework Preset**: `Vite`
   - **Root Directory**: `./` (default)
   - **Build Command**: `npm run build`
   - **Output Directory**: `dist`
5. Buka bagian **Environment Variables**, tambahkan:
   - **Key**: `VITE_API_URL`
   - **Value**: `https://admin.accaive.id/api`
6. Klik **"Deploy"**. Tunggu 1–2 menit hingga build selesai.
   *(File `vercel.json` yang sudah tersedia di project akan otomatis mencegah error 404 saat halaman di-refresh)*.

---

### TAHAP 4: Pengaturan DNS di DomaiNesia (Menghubungkan 1 Domain ke Vercel & Railway)

Buka menu **DNS Management** di DomaiNesia (seperti pada screenshot Anda). Masukkan record satu per satu lalu klik **Save Changes**:

#### Baris 1: Domain Utama (Ke Vercel)
- **Host Name**: `@` *(atau kosongkan jika sistem menolak simbol `@`)*
- **Record Type**: `A (Address)`
- **Address**: `76.76.21.21`
- **Priority**: *(Biarkan KOSONG)*
*(Klik **Save Changes**)*

#### Baris 2: Subdomain www (Ke Vercel)
- **Host Name**: `www`
- **Record Type**: `CNAME (Alias)`
- **Address**: `cname.vercel-dns.com`
- **Priority**: *(Biarkan KOSONG)*
*(Klik **Save Changes**)*

#### Baris 3: Subdomain admin CMS (Ke Railway)
- **Host Name**: `admin`
- **Record Type**: `CNAME (Alias)`
- **Address**: *(Masukkan target CNAME dari Railway Anda, contoh: `xxxx.up.railway.app`)*
- **Priority**: *(Biarkan KOSONG)*
*(Klik **Save Changes**)*

| No | Host Name | Record Type | Address | Priority | Keterangan |
| :---: | :---: | :---: | :---: | :---: | :--- |
| **1** | `@` | `A (Address)` | `76.76.21.21` | *(Kosong)* | Mengarahkan `accaivedesign.id` ke **Vercel** |
| **2** | `www` | `CNAME (Alias)` | `cname.vercel-dns.com` | *(Kosong)* | Mengarahkan `www.accaivedesign.id` ke **Vercel** |
| **3** | `admin` | `CNAME (Alias)` | *(Target CNAME dari Railway)* | *(Kosong)* | Mengarahkan `admin.accaivedesign.id` ke **Railway (CMS)** |

### Hubungkan Domain di Vercel:

1. Masuk ke project Anda di dashboard Vercel $\rightarrow$ **Settings** $\rightarrow$ **Domains**.
2. Masukkan `accaive.id` lalu klik **Add**.
3. Pilih opsi rekomendasi Vercel untuk me-redirect `www.accaive.id` ke `accaive.id`.
4. Tunggu verifikasi DNS (biasanya 5–30 menit). Begitu selesai, status akan menjadi centang hijau dan SSL (HTTPS) aktif otomatis!

---

## 🎯 Hasil Akhir

Setelah DNS terpropagasi:

- 🌐 **Pengunjung / Publik**: Mengakses `https://accaive.id` (menampilkan Company Profile & Portofolio super cepat dari Vercel CDN).
- 🔐 **Klien / Admin**: Mengakses `https://admin.accaive.id` (login ke panel Filament v3 CMS untuk menambah/mengedit proyek arsitektur, foto, dan konten).
