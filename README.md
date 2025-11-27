# Jurnal PKL - Laravel 
**Jurnal PKL** adalah aplikasi berbasis web yang dikembangkan untuk membantu Sekolah Menengah Kejuruan (SMK) dalam digitalisasi proses monitoring dan pelaporan Praktik Kerja Lapangan (PKL). Aplikasi ini menjembatani komunikasi antara Siswa dan Guru Pendamping, memastikan seluruh kegiatan, absensi, dan laporan terekam dengan baik dan transparan.

### Fitur Utama
* **Role Management:** Tersedia role **Siswa** dan **Admin (Guru Pendamping)**.
* **Verifikasi Berkas:** Upload dan validasi surat pernyataan/syarat PKL.
* **Jurnal Harian:** Input kegiatan harian siswa dengan status persetujua oleh Guru.
* **Laporan Akhir:** Pengajuan laporan akhir setelah PKL dilaksanakan.
* **OTP Verifikasi:** Keamanan pendaftaran akun menggunakan Email OTP.

---

## 🛠️ Spesifikasi Teknis



* **Bahasa Pemrograman:** PHP 8.x
* **Framework Backend:** Laravel 11.x (atau versi yang sesuai)
* **Frontend:** Laravel Blade & Bootstrap 5
* **Database:** MySQL
* **Server Environment:** Laragon / Docker / XAMPP
* **Email Service (Dev):** Mailtrap (untuk testing OTP)

---

## ⚙️ Panduan Instalasi (Installation Guide)


### Langkah 1: Clone Repositori
Lakukan Clone Repositori ke dalam komputer Anda. Buka terminal (Git Bash / CMD) dan jalankan:

```bash
git clone https://github.com/zaydsuryamarthana/jurnal-pkl.git
cd jurnal-pkl

```
### Langkah 2: Install Dependencies
Install beberapa pustaka yang dibutuhkan, Anda bisa melihatnya pada file package.json

```bash
composer Install
npm install

```
### Langkah 3: Konfigurasi Environment
Duplikat file Environment untuk dibuatkan file baru .env

```bash
cp .env.example .env
```
Buka file .env menggunakan teks editor (VS Code / Notepad), lalu sesuaikan konfigurasi berikut:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_jurnal_pkl  <-- Sesuaikan nama DB
DB_USERNAME=root           <-- Sesuaikan username (default: root)
DB_PASSWORD=               <-- Sesuaikan password (default: kosong)
```

```bash
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@smk-anda.sch.id"
MAIL_FROM_NAME="${APP_NAME}"
```

### Langkah 4: Generate App Key
Buatlah kunci enkripsi pada Aplikasi.
```bash
php artisan key:generate
```
### Langkah 5: Migrasi Database & Data Seeder
Jalankan perintah ini untuk membuat melakukan migrasi database dan seeder.
```bash
php artisan migrate --seed
```

### Langkah 6: Setup Storage
Lakukan Setup Storage file upload (surat magang, laporan) bisa diakses publik.
```bash
php artisan storage:link
```
### Langkah 7: Jalankan Aplikasi secara Lokal
Server Laravel
```bash
php artisan serve
```
Compile Aset Vite
```bash
npm run dev
```
---

## 🚀 Roadmap & Pengembangan Masa Depan (Future Development)

Untuk meningkatkan skalabilitas, performa, dan pengalaman pengguna (User Experience) ke tingkat selanjutnya, pengembangan aplikasi ini direncanakan akan beralih dari arsitektur *Monolith* (Blade) menuju arsitektur *Headless* (API Driven). Berikut adalah rencana jangka panjang kami:

### Fase 1: Transformasi Backend ke RESTful API
Fokus pada pemisahan logika bisnis dari tampilan agar backend dapat digunakan oleh berbagai platform (Web & Mobile).
* **API Development:** Membangun endpoint REST API menggunakan Laravel Resources & Controllers.
* **API Authentication:** Migrasi sistem login ke **Laravel Sanctum** (Token-based) untuk keamanan akses stateless.

### Fase 2: Modernisasi UI/UX
Merombak total antarmuka pengguna untuk pengalaman yang lebih responsif, modern, dan *app-like*.
* **Single Page Application (SPA):** Membangun ulang Frontend menggunakan teknologi modern (seperti **Next.js / React / Vue.js**) untuk navigasi instan tanpa reload halaman.
* **Interactive UI Components:** Implementasi Skeleton Loading, SweetAlert, dan Real-time Form Validation untuk feedback yang lebih baik kepada user.
* **State Management:** Pengelolaan data lokal yang lebih efisien untuk mengurangi request berulang ke server.

### Fase 3: Optimasi Performa & Skalabilitas
Memastikan aplikasi tetap cepat meski data siswa dan laporan semakin banyak.

* **Image Optimization:** Kompresi otomatis saat siswa mengupload bukti kegiatan atau laporan.
* **Asynchronous Processing:** Menggunakan **Laravel Queue** untuk proses berat (seperti pengiriman email OTP atau rekap laporan PDF) agar tidak membebani loading user.

### Fase 4: Ekosistem Multi-Platform
Memanfaatkan API yang sudah dibangun untuk memperluas jangkauan akses.
* **Mobile Application:** Pengembangan aplikasi native (Android/iOS) menggunakan React Native atau Flutter yang terhubung ke API Jurnal PKL.

## 🤝 Kontribusi
Jika Anda ingin berkontribusi pada proyek ini, silakan Fork repositori ini dan buat Pull Request.

- Saya sangat berterima kasih kepada seluruh pihak yang telah menggunakan aplikasi ini, dan bisa memberikan kritikan agar aplikasi ini bisa dikembangkan lebih baik lagi.

