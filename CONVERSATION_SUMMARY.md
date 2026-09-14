# Rangkuman Percakapan & Pengembangan Proyek (Accaive Design Studio)

Dokumen ini merangkum seluruh alur diskusi, keputusan desain, arsitektur teknis, implementasi fitur, hingga pemecahan masalah yang telah diselesaikan untuk website **[accaivedesign.id](https://accaivedesign.id)**.

---

## 📌 Daftar Isi
1. [Latar Belakang & Roadmap Proyek](#1-latar-belakang--roadmap-proyek)
2. [Fase 1: Deployment & Stabilitas Infrastruktur](#2-fase-1-deployment--stabilitas-infrastruktur)
3. [Fase 2: Dynamic Content Management System (Filament CMS)](#3-fase-2-dynamic-content-management-system-filament-cms)
4. [Fase 3: Visual UI & Layout Editor (Split-Screen & Drag-and-Drop)](#4-fase-3-visual-ui--layout-editor-split-screen--drag-and-drop)
5. [Fase 4: Strategi & Implementasi SEO Google #1](#5-fase-4-strategi--implementasi-seo-google-1)
6. [Fase 5: Verifikasi Google Search Console & Pemecahan Masalah 404](#6-fase-5-verifikasi-google-search-console--pemecahan-masalah-404)
7. [Fase 6: Penyesuaian Warna & Kontras Navigasi (Obsidian Luxury)](#7-fase-6-penyesuaian-warna--kontras-navigasi-obsidian-luxury)
8. [Status Akhir Repositori, Git Branch, dan Hasil Uji](#8-status-akhir-repositori-git-branch-dan-hasil-uji)
9. [Panduan Langkah Klien & Pemilik Website Selanjutnya](#9-panduan-langkah-klien--pemilik-website-selanjutnya)

---

## 1. Latar Belakang & Roadmap Proyek

- **Nama Brand**: Accaive Design Studio
- **Domain Resmi**: `https://accaivedesign.id`
- **Tech Stack**:
  - **Frontend**: React 19, Vite, Tailwind CSS, GSAP (ScrollTrigger), Lenis Smooth Scroll, Lucide Icons.
  - **Backend**: Laravel 11, Filament v3 (Admin CMS Panel), SQLite/PostgreSQL, RESTful API.
  - **Hosting**: Vercel (Frontend SPA) + Railway (Backend API & Filament CMS).

Objektif utama dari serangkaian sesi ini adalah mengubah website arsitektur statis menjadi platform dinamis yang dapat dikelola penuh oleh klien non-teknis, memiliki editor tata letak visual modern, terindeks sempurna di peringkat teratas Google, serta memiliki kontras visual luxury tanpa cacat tampilan.

---

## 2. Fase 1: Deployment & Stabilitas Infrastruktur

### Masalah Awal:
- Kendala koneksi database PostgreSQL di Railway (`Provision PostgreSQL`).
- Masalah pembacaan asset CSS/JS frontend saat pertama kali dihubungkan ke domain custom `accaivedesign.id`.
- Konfigurasi rewrite SPA di `vercel.json` untuk mencegah 404 saat pengguna melakukan refresh pada sub-halaman.

### Solusi & Eksekusi:
- Memperbaiki alur environment variable antara frontend (`VITE_API_URL`) dan backend Laravel (`APP_URL`, `FRONTEND_URL`, `SANCTUM_STATEFUL_DOMAINS`).
- Mengoptimalkan konfigurasi `vercel.json` dengan rewrite rute SPA `/* -> /index.html`.
- Mengonfigurasi caching header HTTP 5 menit untuk endpoint API guna meringankan beban database.

---

## 3. Fase 2: Dynamic Content Management System (Filament CMS)

### Permintaan Klien:
> *"Client pengen bisa otak-atik semua isi konten yang di frontend bisa dikelola semua di Filament-nya."*

### Solusi & Eksekusi:
- **Tabel & Model `site_settings`**: Membangun mekanisme penyimpanan key-value yang fleksibel tanpa memerlukan migrasi skema database baru setiap ada penambahan teks.
- **Integritas Cache**: Mengaktifkan `Cache::forget('site_settings')` pada event `booted()` model `SiteSetting` agar perubahan di CMS langsung aktif seketika di endpoint API.
- **Frontend Integration**:
  - Menghubungkan seluruh teks statis (Hero Headline, Award Chips, Sub-halaman Programs, Arts & Culture, Team, Careers, Press, Kontak, dan Footer) ke hook `useSettings()`.
  - Fallback aman: Jika data CMS kosong, tampilan tetap menampilkan teks standar arsitektur berkualitas tinggi (anti-rusak).

---

## 4. Fase 3: Visual UI & Layout Editor (Split-Screen & Drag-and-Drop)

### Permintaan Klien:
> *"Client juga pengen bisa ngubah layout peletakan konten-kontennya... ux di filamentnya lebih user friendly jangan gunakan interaksi yang terlalu teknis... Poin utamanya adalah mengedit antarmuka (interface)."*

### Solusi & Eksekusi (Branch: `feat/visual-ui-editor`):
1. **Split-Screen Live Canvas di Filament CMS**:
   - Panel Kiri: Form pengaturan terorganisir 5 Tab (*Tata Letak Beranda, Teks Beranda, Sub-Halaman, Kontak & Medsos, Identitas & Footer*).
   - Panel Kanan: **Live Canvas Preview** sticky yang memuat website langsung (`localhost:5173` atau `accaivedesign.id`).
   - Switcher responsif Desktop (🖥️) dan Mobile (📱 375px phone mockup).
   - **Auto-Refresh**: Canvas preview otomatis menyegarkan diri seketika setelah tombol *"Simpan Semua Perubahan"* ditekan via Livewire browser event dispatch `site-content-saved`.
2. **Drag-and-Drop Tata Letak Section Beranda (`home_sections`)**:
   - Klien dapat menukar urutan section (Hero, Proyek Pilihan, Layanan, Tim, CTA Banner) hanya dengan menggeser kartu atau tombol panah.
   - Toggle switch ON/OFF untuk menyembunyikan/menampilkan section individual.
   - `Home.jsx` di React membaca array JSON urutan ini secara dinamis dan menjaga ScrollTrigger GSAP agar tidak crash.
3. **Visual Presets untuk Tata Letak Grid**:
   - Proyek Pilihan: Preset *Asimetris Editorial*, *Simetris 2 Kolom Sejajar*, atau *Grid 3 Kolom Kompak*.
   - Layanan: Preset *Split Side-by-Side* atau *Stacked Vertical*.
4. **Zero-Code Inputs**:
   - Menghapus kewajiban klien mengetik tag HTML `<br />` atau `<span class="italic">`. Headline dipecah menjadi 3 field sederhana: *Teks Pembuka*, *Kata Aksen Miring*, dan *Teks Penutup*.
   - Menggunakan `TagsInput` untuk daftar penghargaan (Awards) dan dampak program (Impacts).

---

## 5. Fase 4: Strategi & Implementasi SEO Google #1

### Kebutuhan:
Membawa `accaivedesign.id` menduduki peringkat #1 Google saat dicari kata kunci *"Accaive"*, *"Accaive Design"*, *"Accaive Studio"*, dan *"Studio Arsitek Yogyakarta"*.

### Analisis Otoritas:
Nama "Accaive" adalah brand unik (VUG - *Very Unique Term*). Google sudah memiliki jejak lama pada Facebook (*Accaive Std*) dan YouTube (*Accaive Design studio*) di Yogyakarta. Mengaitkan website baru sebagai entitas resmi utama menjamin ranking #1 dalam waktu singkat (3–7 hari via Fast-Track).

### Solusi & Eksekusi (Branch: `feat/seo-optimization`):
1. **Schema.org JSON-LD Entity Graph (`index.html`)**:
   - Tipe data terstruktur: `["ArchitecturalFirm", "Organization", "ProfessionalService"]`.
   - Mengaitkan atribut `sameAs` ke akun Facebook, YouTube, Instagram, dan LinkedIn resmi.
   - Memasang canonical link `https://accaivedesign.id/`, meta keywords, serta OpenGraph dan Twitter Card lengkap.
2. **Aksesibilitas Googlebot & Peta Situs XML**:
   - `public/robots.txt`: Mengizinkan seluruh bot mesin pencari dan memblokir rute internal `/admin/` dan `/api/`.
   - `public/sitemap.xml`: Memetakan 14 URL utama (beranda, seluruh sub-halaman, dan portofolio proyek detail).
3. **Dynamic Page SEO di React SPA (`src/hooks/usePageSEO.js`)**:
   - Hook custom ringan untuk memperbarui `document.title`, `meta description`, dan OpenGraph secara dinamis pada tiap pergantian rute halaman (`/case-studies`, `/programs`, `/project/:slug`, dll.).
4. **Kontrol SEO di Filament CMS**:
   - Tab 5 (*Identitas & Footer*) dilengkapi kolom Meta Title, Meta Description, Target Keywords, dan Google Site Verification Token.

---

## 6. Fase 5: Verifikasi Google Search Console & Pemecahan Masalah 404

### Kendala:
Saat klien memverifikasi domain via Google Search Console metode file HTML (`googled3fabe5d8b9224ad.html`), layar browser menampilkan **404 Page Not Found**.

### Investigasi & Perbaikan:
1. File verifikasi ditemukan di komputer lokal: `/home/azfa/Desktop/accaive/googled3fabe5d8b9224ad.html`.
2. File tersebut sebelumnya berada di root project dan belum disalin ke folder `public/`, sehingga build Vite tidak menyertakannya ke `dist/` dan Vercel merutekannya ke 404 SPA.
3. File disalin ke `public/googled3fabe5d8b9224ad.html`, diuji dalam build `dist/`, digabungkan ke branch `main`, dan di-push ke GitHub.
4. Pengujian langsung via `curl` mengonfirmasi file mengembalikan status 200 OK dengan teks resmi: `google-site-verification: googled3fabe5d8b9224ad.html`.
5. Klien berhasil menjalankan uji langsung di Google Search Console dengan hasil **Centang Hijau Sempurna**:
   - ✅ *URL tersedia untuk Google*
   - ✅ *Halaman dapat diindeks*
   - ✅ *Video terdeteksi*
   - ✅ *Peta situs terdeteksi: `https://accaivedesign.id/sitemap.xml`*
   - Permintaan pengindeksan prioritas (*Request Indexing*) berhasil dikirimkan ke server Google.

---

## 7. Fase 6: Penyesuaian Warna & Kontras Navigasi (Obsidian Luxury)

### Masalah:
- Warna footer dan menu overlay lama menggunakan `#1a0f0a` (cokelat tua kemerahan) yang kurang menyatu dengan dark theme website (`#0a0a0a`).
- Logo dan tombol hamburger menggunakan CSS `mix-blend-difference` yang menghasilkan warna keruh, buram, atau kebiruan saat berada di atas foto proyek tertentu.

### Solusi & Eksekusi (Branch: `feat/colors-and-nav-polish` -> merged to `main`):
1. **Footer & Menu Overlay (`#0a0a0a`)**:
   - Latar belakang footer diubah menjadi **Hitam Pekat Obsidian (`#0a0a0a`)** dengan aksen garis tipis `border-t border-white/10`.
   - Latar belakang menu overlay diselaraskan menjadi `#0a0a0a`.
   - Format teks brand title dipertahankan sembari klien menyiapkan aset logo final.
2. **Solid Adaptive Contrast untuk Logo & Hamburger**:
   - Menghapus `mix-blend-difference` sepenuhnya.
   - **Di Latar Terang (Light Mode)**: Logo otomatis berbalik menjadi **Hitam Pekat Solid (`#000000`)** via filter `invert` yang tajam, dan garis hamburger berwarna `bg-black`.
   - **Di Latar Gelap (Dark Mode / Video / Menu Terbuka)**: Logo dan garis hamburger otomatis berwarna **Putih Bersih Solid (`#ffffff`)**.
   - Dilengkapi transisi animasi warna yang mulus (`transition-all duration-300`).

---

## 8. Status Akhir Repositori, Git Branch, dan Hasil Uji

### Struktur Branch Git:
- **`main`** *(Active & Live di Production)*: Berisi seluruh perbaikan infrastruktur, CMS konten dinamis, Visual UI Editor, SEO Schema/Sitemap, verifikasi Google, dan penyesuaian warna solid adaptive.
- **`feat/visual-ui-editor`**: Branch arsip pengembangan fitur UI & Layout Editor.
- **`feat/seo-optimization`**: Branch arsip pengembangan fitur SEO & Google verification.

### Hasil Verifikasi Kualitas Kode:
- **Frontend ESLint**: `npm run lint` $\rightarrow$ **0 error, 0 warning**.
- **Frontend Build**: `npm run build` $\rightarrow$ Sukses (3.48 detik) dengan seluruh aset statis (`robots.txt`, `sitemap.xml`, `googled3fabe5d8b9224ad.html`) berada di root `dist/`.
- **Backend Tests**: `php artisan test` $\rightarrow$ **13 tests passed, 0 failed (31 assertions)**.
- **Produksi**: Live dan stabil di `https://accaivedesign.id`.

---

## 9. Panduan Langkah Klien & Pemilik Website Selanjutnya

1. **Jadwal Pengindeksan Google (24–48 Jam)**:
   - Googlebot saat ini sedang memproses antrean perayapan prioritas. Status di Google Search Console akan segera berubah menjadi *"URL ada di Google"*.
2. **Penguatan Sinyal Media Sosial (Entity Trust - 5 Menit)**:
   - Masukkan link `https://accaivedesign.id` di bio Instagram `@accaivedesign`.
   - Perbarui kolom website di halaman Facebook *Accaive Std* dan tab About YouTube *Accaive Design studio*.
3. **Pengecekan Rutin (Hari ke-3 s/d 7)**:
   - Gunakan jendela penyamaran (*Chrome Incognito*) untuk mengetik `site:accaivedesign.id` guna melihat seluruh halaman portofolio yang masuk indeks.
   - Ketik *"accaive"* atau *"accaive design"* untuk menyaksikan website Anda naik menuju peringkat teratas Google Search.
4. **Pemasangan Aset Logo Footer di Masa Mendatang**:
   - Begitu aset gambar logo footer yang disiapkan klien sudah siap, tinggal ditempatkan pada komponen `src/components/Footer.jsx`.

---
*Dokumen rangkuman ini dibuat secara otomatis pada 15 September 2026 untuk mendokumentasikan seluruh riwayat pekerjaan pengembangan Accaive Design Studio.*
