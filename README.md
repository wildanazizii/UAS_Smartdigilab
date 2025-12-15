# SmartDigiLab - Sistem Inventaris Laboratorium dan Peminjaman Alat

![Laravel](https://img.shields.io/badge/Laravel-12.0-red)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.0-38bdf8)

Sistem manajemen inventaris laboratorium dan peminjaman alat berbasis web yang dibangun menggunakan Laravel 12. Aplikasi ini memudahkan pengelolaan alat laboratorium, pencatatan peminjaman, dan pembuatan laporan.

## 📋 Fitur Utama

### 1. Manajemen Inventaris Alat
- ✅ Tambah, ubah, hapus, dan lihat data alat laboratorium
- ✅ Data alat meliputi: nama, kode, deskripsi, jumlah, dan status ketersediaan
- ✅ Status ketersediaan: Tersedia, Dipinjam, Rusak
- ✅ Generate QR Code untuk setiap alat
- ✅ Validasi data lengkap

### 2. Sistem Peminjaman Alat
- ✅ Form peminjaman dengan skema login/form langsung
- ✅ Halaman Dosen/Staff untuk isi data peminjam (nama, NIM, kontak)
- ✅ Pilih alat yang tersedia dan tanggal pinjam
- ✅ Halaman sukses setelah pengajuan peminjaman
- ✅ Notifikasi email (opsional)

### 3. Halaman Admin Peminjaman
- ✅ Kelola data peminjaman (lihat, ubah, hapus)
- ✅ Tandai alat sebagai dikembalikan
- ✅ Update status peminjaman
- ✅ Statistik peminjaman real-time

### 4. Laporan Riwayat Peminjaman
- ✅ Filter berdasarkan tanggal (range)
- ✅ Filter berdasarkan alat
- ✅ Filter berdasarkan jenis peminjam
- ✅ Export laporan ke CSV
- ✅ Tampilan data lengkap dengan pagination

### 5. Fitur Tambahan
- ✅ Dashboard dengan statistik
- ✅ Validasi data di semua form
- ✅ QR Code untuk identifikasi alat
- ✅ UI/UX modern dengan TailwindCSS
- ✅ Responsive design
- ✅ Flash messages untuk feedback

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 12 (PHP 8.2)
- **Frontend**: Blade Templates, TailwindCSS, Font Awesome
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Package Tambahan**:
  - SimpleSoftwareIO/Simple-QRCode - Generate QR Code

## 📦 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM (untuk asset compilation)

### Langkah Instalasi

1. **Clone repository**
```bash
git clone <repository-url>
cd smartdigilab
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Setup environment**
```bash
copy .env.example .env
php artisan key:generate
```

4. **Konfigurasi database**
Edit file `.env` sesuai kebutuhan. Default menggunakan SQLite:
```env
DB_CONNECTION=sqlite
```

5. **Jalankan migrasi dan seeder**
```bash
php artisan migrate
php artisan db:seed
```

6. **Build assets**
```bash
npm run build
```

7. **Jalankan aplikasi**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 🚀 Penggunaan

### Dashboard
Akses halaman utama untuk melihat statistik dan navigasi cepat ke fitur-fitur utama.

### Manajemen Inventaris
1. Klik menu **Inventaris** untuk melihat daftar alat
2. Klik **Tambah Alat** untuk menambah alat baru
3. Gunakan tombol aksi untuk edit, lihat detail, generate QR code, atau hapus alat

### Peminjaman Alat
1. Klik menu **Pinjam Alat**
2. Isi data peminjam (nama, NIM, kontak)
3. Pilih alat yang ingin dipinjam
4. Tentukan tanggal peminjaman
5. Submit formulir

### Admin Peminjaman
1. Klik menu **Admin** untuk melihat semua peminjaman
2. Gunakan tombol **Kembalikan** untuk menandai alat sudah dikembalikan
3. Edit atau hapus data peminjaman sesuai kebutuhan

### Laporan
1. Klik menu **Laporan**
2. Gunakan filter untuk menyaring data:
   - Tanggal mulai dan akhir
   - Alat tertentu
   - Peminjam tertentu
   - Status peminjaman
3. Klik **Export CSV** untuk download laporan

## 📊 Struktur Database

### Table: equipment
- id
- name (varchar)
- code (varchar, unique)
- description (text)
- quantity (integer)
- availability_status (enum: tersedia, dipinjam, rusak)
- timestamps

### Table: borrowers
- id
- name (varchar)
- nim (varchar, unique)
- contact (varchar)
- timestamps

### Table: borrowings
- id
- borrower_id (foreign key)
- equipment_id (foreign key)
- borrow_date (date)
- return_date (date, nullable)
- status (enum: dipinjam, dikembalikan)
- timestamps

## 🎨 Screenshot

### Dashboard
Menampilkan statistik total alat, alat tersedia, sedang dipinjam, dan total peminjam.

### Inventaris Alat
Daftar lengkap alat laboratorium dengan fitur CRUD dan QR Code.

### Form Peminjaman
Form user-friendly untuk peminjaman alat dengan validasi lengkap.

### Admin Peminjaman
Interface admin untuk mengelola semua peminjaman.

### Laporan
Sistem pelaporan dengan multiple filter dan export CSV.

## 🔒 Validasi

Aplikasi dilengkapi dengan validasi lengkap:
- Nama alat wajib diisi
- Kode alat harus unik
- Jumlah alat minimal 1
- NIM peminjam harus unik
- Semua field required divalidasi
- Tanggal peminjaman divalidasi

## 📝 Catatan Pengembangan

Proyek ini dikembangkan sebagai bagian dari UTS Pemrograman Web dengan topik:
**Sistem Inventaris Laboratorium dan Peminjaman Alat**

### Kriteria yang Dipenuhi:
- ✅ Manajemen Inventaris (tambah, ubah, hapus, lihat)
- ✅ Sistem Peminjaman dengan form lengkap
- ✅ Halaman Admin untuk kelola peminjaman
- ✅ Laporan dengan filter tanggal, alat, dan peminjam
- ✅ Validasi data lengkap
- ✅ Fitur tambahan: QR Code, notifikasi, export laporan

## 🤝 Kontribusi

Untuk berkontribusi pada proyek ini:
1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 License

Project ini dibuat untuk keperluan edukasi - UTS Pemrograman Web.

## 👨‍💻 Developer

Dikembangkan dengan ❤️ menggunakan Laravel Framework

---

**SmartDigiLab** - Sistem Inventaris Laboratorium dan Peminjaman Alat
© 2025 - Dibuat untuk UTS Pemrograman Web
