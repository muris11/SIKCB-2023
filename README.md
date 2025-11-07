# SIKC B 2023

[![PHP Version](https://img.shields.io/badge/PHP-8.0+-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange.svg)](https://mysql.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## 📋 Deskripsi Proyek

**SIKC B 2023** adalah sistem manajemen konten (Content Management System) berbasis web yang dirancang khusus untuk mengelola kegiatan pembelajaran di lingkungan pendidikan. Sistem ini menyediakan platform terintegrasi untuk mengelola semester, kelas, materi pembelajaran, galeri foto, perpustakaan mini, dan administrasi pengguna.

Proyek ini dikembangkan sebagai bagian dari Sistem Informasi Kelas (SIKC) Batch 2023 menggunakan arsitektur MVC (Model-View-Controller) dengan fokus pada kemudahan penggunaan, keamanan, dan skalabilitas untuk mendukung proses pembelajaran yang efektif.

## ✨ Fitur Utama

### 👥 Manajemen Pengguna

- **Autentikasi Lengkap**: Sistem login dan registrasi dengan validasi email
- **Role-based Access Control**: Pemisahan hak akses antara Admin dan User
- **Reset Password**: Fitur lupa password dengan email verification
- **Session Management**: Pengelolaan sesi yang aman dengan cookie hardening

### 📚 Manajemen Akademik

- **Semester Management**: Pengelolaan periode akademik dengan cover image
- **Class Management**: CRUD kelas dengan informasi lengkap (SKS, jadwal, pengajar)
- **Material Upload**: Upload materi pembelajaran dalam berbagai format
- **Gallery System**: Sistem galeri foto per semester dengan caption

### 📖 Mini Library

- **Group Management**: Pengelolaan kelompok pembelajaran
- **Member Management**: Sistem keanggotaan kelompok
- **Category System**: Kategorisasi berdasarkan jenis kegiatan
- **Image Support**: Dukungan gambar untuk setiap kelompok

### 🔧 Panel Admin

- **Dashboard Komprehensif**: Overview sistem dengan statistik
- **User Management**: Kelola semua pengguna sistem
- **Content Management**: Kontrol penuh atas konten akademik
- **System Monitoring**: Pemantauan aktivitas sistem

### 🎨 Antarmuka Pengguna

- **Responsive Design**: Kompatibel desktop dan mobile
- **Modern UI**: Antarmuka yang intuitif dan user-friendly
- **SEO Friendly**: Optimasi untuk mesin pencari
- **Accessibility**: Dukungan aksesibilitas

## 🛠️ Teknologi yang Digunakan

### Backend

- **PHP 8.0+**: Bahasa pemrograman utama
- **MySQL 5.7+**: Sistem manajemen basis data
- **PDO**: Database abstraction layer untuk keamanan
- **Composer**: Dependency management

### Frontend

- **HTML5**: Struktur markup
- **CSS3**: Styling dengan framework custom
- **JavaScript**: Interaktivitas client-side
- **AOS (Animate On Scroll)**: Library animasi

### Libraries & Tools

- **PHPMailer**: Pengiriman email
- **Laragon**: Environment development lokal
- **Git**: Version control system

### Arsitektur

- **MVC Pattern**: Separation of concerns
- **PSR-4 Autoloading**: Standard autoloading
- **Custom Router**: Routing system proprietary
- **Session-based Auth**: Sistem autentikasi berbasis sesi

## 📁 Struktur Proyek

```
kelaskita-cms/
├── 📄 index.php                 # Entry point aplikasi
├── 📄 composer.json             # Dependency management
├── 📄 database_setup.sql        # Skema database MySQL
├── 📄 README.md                 # Dokumentasi proyek
├── 📄 robots.txt                # SEO - robots directive
├── 📄 sitemap.php               # Dynamic sitemap generator
├── 📄 sitemap.xml               # Static sitemap
├── 📄 analytics_tracking.php    # Google Analytics integration
├── 📁 app/                      # Source code aplikasi
│   ├── 📁 Config/               # Konfigurasi aplikasi
│   │   ├── 📄 config.php        # Konfigurasi development
│   │   └── 📄 config_production.php # Konfigurasi production
│   ├── 📁 Controllers/          # Business logic layer
│   │   ├── 📄 AdminController.php    # Admin operations
│   │   ├── 📄 AuthController.php     # Authentication
│   │   ├── 📄 DashboardController.php # Dashboard logic
│   │   ├── 📄 HomeController.php     # Public pages
│   │   ├── 📄 ImageController.php    # Image handling
│   │   ├── 📄 KelasController.php    # Class management
│   │   └── 📄 SemesterController.php # Semester management
│   ├── 📁 Core/                 # Core utilities
│   │   ├── 📄 Auth.php          # Authentication utilities
│   │   ├── 📄 Mailer.php        # Email service
│   │   ├── 📄 Router.php        # Routing system
│   │   └── 📄 Session.php       # Session management
│   ├── 📁 Models/               # Data access layer
│   │   ├── 📄 Gallery.php       # Gallery model
│   │   ├── 📄 Kelas.php         # Class model
│   │   ├── 📄 Material.php      # Material model
│   │   ├── 📄 MiniLibrary.php   # Mini library model
│   │   ├── 📄 Semester.php      # Semester model
│   │   └── 📄 User.php          # User model
│   └── 📁 Views/                # Presentation layer
│       ├── 📁 admin/            # Admin templates
│       ├── 📁 auth/             # Authentication templates
│       ├── 📁 errors/           # Error pages
│       ├── 📁 home/             # Public pages
│       ├── 📁 layout/           # Layout components
│       ├── 📁 semester/         # Semester pages
│       └── 📁 user/             # User dashboard
├── 📁 assets/                   # Static assets
│   ├── 📄 style.css             # Main stylesheet
│   ├── 📄 aos-fallback.css      # Animation fallback
│   └── 📁 images/               # Static images
├── 📁 config/                   # Additional configuration
│   └── 📄 email.php             # Email configuration
├── 📁 database/                 # Database related files
├── 📁 public/                   # Public web root
│   ├── 📄 index.php             # Public entry point
│   ├── 📄 test_form_final.html  # Testing form
│   ├── 📁 assets/               # Public assets
│   └── 📁 uploads/              # File uploads directory
├── 📁 routes/                   # Route definitions
│   └── 📄 gallery.php           # Gallery routes
└── 📁 vendor/                   # Composer dependencies
    └── 📁 phpmailer/            # PHPMailer library
```

## 🚀 Instalasi & Setup

### Persyaratan Sistem

- **PHP**: 8.0 atau lebih tinggi
- **MySQL**: 5.7+ atau MariaDB 10.2+
- **Web Server**: Apache/Nginx (Laragon recommended)
- **Composer**: Untuk dependency management
- **Git**: Untuk version control

### Langkah Instalasi

1. **Clone Repository**

   ```bash
   git clone https://github.com/muris11/SIKCB-2023.git kelaskita-cms
   cd kelaskita-cms
   ```

2. **Install Dependencies**

   ```bash
   composer install
   ```

3. **Setup Database**

   - Buat database baru di MySQL: `kelaskita_cms`
   - Import file `database_setup.sql`:
     ```sql
     mysql -u root -p kelaskita_cms < database_setup.sql
     ```
   - Atau gunakan phpMyAdmin untuk import

4. **Konfigurasi Environment**

   - Edit `app/Config/config.php` untuk development
   - Edit `app/Config/config_production.php` untuk production
   - Sesuaikan kredensial database dan pengaturan email

5. **Setup Web Server**

   - Pastikan document root mengarah ke folder `kelaskita-cms`
   - Untuk Laragon: tambahkan virtual host
   - Untuk Apache: konfigurasi .htaccess jika diperlukan

6. **Akses Aplikasi**
   - Buka browser: `http://localhost/kelaskita-cms`
   - Default admin: Buat user admin melalui database atau registrasi

## 📊 Skema Database

Sistem menggunakan 7 tabel utama dengan relasi yang terstruktur:

### 🗂️ Tabel Utama

- **`users`**: Data pengguna (id, name, email, password_hash, role)
- **`semesters`**: Periode akademik (id, name, description, cover_image)
- **`classes`**: Data kelas (id, semester_id, name, teacher, schedule, sks)
- **`gallery`**: Galeri foto (id, semester_id, image_data, caption)
- **`materials`**: Materi pembelajaran (id, class_id, title, file_data)
- **`mini_library`**: Kelompok pembelajaran (id, group_name, category)
- **`mini_library_members`**: Anggota kelompok (id, mini_library_id, name)

### 🔗 Relasi Database

- Classes → Semesters (Many-to-One)
- Gallery → Semesters (Many-to-One)
- Materials → Classes (Many-to-One)
- Mini Library Members → Mini Library (Many-to-One)
- Classes → Users (Many-to-One untuk PJ/Penanggung Jawab)

## 🔧 Konfigurasi

### Database Configuration

```php
const DB_HOST    = 'localhost';
const DB_NAME    = 'kelaskita_cms';
const DB_USER    = 'root';
const DB_PASS    = '';
const DB_CHARSET = 'utf8mb4';
```

### Email Configuration

Edit file `config/email.php` untuk pengaturan PHPMailer:

```php
const SMTP_HOST     = 'smtp.gmail.com';
const SMTP_PORT     = 587;
const SMTP_USER     = 'your-email@gmail.com';
const SMTP_PASS     = 'your-app-password';
const SMTP_ENCRYPT  = 'tls';
```

### Environment Settings

```php
const APP_NAME         = 'SIKC B 2023';
const DEVELOPMENT_MODE = true; // Set false di production
const BASE_URL         = 'http://localhost/kelaskita-cms/';
```

## 📖 Penggunaan

### Untuk Admin

1. **Login** sebagai administrator
2. **Dashboard**: Monitor aktivitas sistem
3. **Manage Users**: Tambah/edit/hapus pengguna
4. **Manage Semesters**: Buat periode akademik baru
5. **Manage Classes**: Konfigurasi kelas dan materi
6. **Gallery Management**: Upload foto kegiatan
7. **Mini Library**: Kelola kelompok pembelajaran

### Untuk User/Pengguna

1. **Register/Login**: Buat akun atau masuk sistem
2. **Browse Semesters**: Lihat periode akademik
3. **View Classes**: Akses materi kelas
4. **Gallery**: Lihat foto kegiatan
5. **Mini Library**: Bergabung dengan kelompok

## 🔒 Keamanan

- **Password Hashing**: Menggunakan bcrypt untuk hash password
- **SQL Injection Protection**: Prepared statements dengan PDO
- **XSS Protection**: Input sanitization dan output escaping
- **CSRF Protection**: Token validation untuk form submissions
- **Session Security**: Secure cookie settings dengan HttpOnly dan SameSite
- **File Upload Security**: Validasi tipe file dan ukuran
- **Access Control**: Role-based permissions

## 🔍 SEO & Performance

- **Dynamic Sitemap**: Auto-generated sitemap.xml
- **Meta Tags**: SEO-friendly meta descriptions
- ** robots.txt**: Search engine directives
- **Responsive Images**: Optimized image loading
- **Database Indexing**: Optimized queries dengan proper indexing
- **Caching Strategy**: Session dan database connection pooling

## 🧪 Testing

### Manual Testing

- Gunakan `public/test_form_final.html` untuk testing form
- Test semua CRUD operations
- Verify email functionality
- Test file upload features

### Database Testing

```sql
-- Check table structures
DESCRIBE users;
DESCRIBE semesters;
DESCRIBE classes;

-- Verify foreign key constraints
SHOW CREATE TABLE classes;
```

## 🚀 Deployment

### Production Setup

1. **Environment Configuration**

   - Copy `config_production.php`
   - Set `DEVELOPMENT_MODE = false`
   - Configure production database credentials

2. **Security Hardening**

   - Disable error display
   - Set proper file permissions
   - Configure HTTPS
   - Setup backup routines

3. **Performance Optimization**
   - Enable opcode caching (OPcache)
   - Configure database connection pooling
   - Setup CDN untuk static assets

## 🤝 Kontribusi

Kami menerima kontribusi untuk pengembangan **SIKC B 2023 - Sistem Informasi Kelas Batch 2023**!

### Proses Kontribusi

1. **Fork** repositori ini
2. **Buat Branch** fitur baru: `git checkout -b feature/nama-fitur`
3. **Commit** perubahan: `git commit -m "Tambah fitur X"`
4. **Push** ke branch: `git push origin feature/nama-fitur`
5. **Buat Pull Request** dengan deskripsi lengkap

### Panduan Kontribusi

- Ikuti PSR-12 coding standards
- Tambahkan komentar pada kode kompleks
- Update dokumentasi untuk fitur baru
- Test thoroughly sebelum submit PR

## 📝 Lisensi

Proyek ini menggunakan lisensi **MIT License**.

```
MIT License

Copyright (c) 2023 SIKC B 2023 - Sistem Informasi Kelas Batch 2023

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
```

## 📞 Dukungan & Kontak

- **Project**: SIKC B 2023 - Sistem Informasi Kelas Batch 2023
- **Developer**: Muris AK (NIM: [Your NIM])
- **Institution**: [Your University/Institution Name]
- **Course**: [Course Name/Subject]
- **Email**: muris.ak@student.example.ac.id
- **GitHub Profile**: [https://github.com/muris11](https://github.com/muris11)
- **Repository**: [https://github.com/muris11/SIKCB-2023](https://github.com/muris11/SIKCB-2023)
- **Issues & Support**: [GitHub Issues](https://github.com/muris11/SIKCB-2023/issues)
- **Documentation**: [Repository Wiki](https://github.com/muris11/SIKCB-2023/wiki)
- **LinkedIn**: [Your LinkedIn Profile]
- **Portfolio**: [Your Portfolio Website]

## 🙏 Acknowledgments

- **Laragon**: Development environment
- **PHPMailer**: Email functionality
- **MySQL Community**: Database system
- **PHP Community**: Programming language
- **Open Source Community**: Libraries dan tools

## 📈 Roadmap

### Fitur Mendatang

- [ ] API RESTful untuk mobile app
- [ ] Real-time notifications
- [ ] Advanced reporting system
- [ ] Integration dengan LMS platforms
- [ ] Multi-language support
- [ ] Theme customization
- [ ] Backup automation
- [ ] Performance monitoring

### Improvements

- [ ] Unit testing framework
- [ ] Docker containerization
- [ ] CI/CD pipeline
- [ ] Code documentation
- [ ] Performance optimization

---

**SIKC B 2023** - Sistem Informasi Kelas Batch 2023 - Membuat pembelajaran lebih terorganisir dan efektif! 🎓

*Developed with ❤️ by Muris AK - Academic Project 2023*
