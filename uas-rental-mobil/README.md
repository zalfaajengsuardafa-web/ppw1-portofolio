# Sistem Rental Mobil
**UAS Pemrograman Web 1 — Zalfa Ajeng Suardafa (25/568990/SV/27577)**

Aplikasi web Sistem Rental Mobil berbasis PHP murni, MySQL, Bootstrap 5, dan Vanilla JavaScript.

---

## Fitur Utama
- **Autentikasi**: Login/Logout dengan session, password_hash, password_verify
- **CRUD Mobil**: Tambah, lihat, edit, hapus data mobil (dengan search & pagination)
- **CRUD Transaksi**: Tambah, lihat, edit, hapus, selesaikan transaksi rental
- **Dashboard**: Statistik ringkas (total mobil, tersedia, disewa, transaksi aktif, pendapatan)
- **Responsif**: Mendukung tampilan mobile (min 375px) hingga desktop
- **Keamanan**: Prepared statements, htmlspecialchars, password hashing
- **JavaScript**: Validasi form client-side, confirm delete, hitung biaya otomatis, live search

---

## Struktur Folder
```
uas-rental-mobil/
├── assets/
│   ├── css/
│   │   └── style.css          # Custom stylesheet
│   ├── js/
│   │   └── script.js          # JavaScript validasi & interaktivitas
│   └── img/                   # Folder gambar (opsional)
├── includes/
│   ├── config.php             # Konfigurasi database
│   ├── header.php             # Header & navbar
│   └── footer.php             # Footer & script
├── pages/
│   ├── login.php              # Halaman login
│   ├── logout.php             # Proses logout
│   ├── dashboard.php          # Dashboard statistik
│   ├── mobil.php              # CRUD data mobil
│   ├── mobil_action.php       # Proses create/update mobil
│   ├── transaksi.php          # CRUD data transaksi
│   └── transaksi_action.php   # Proses create/update transaksi
├── database.sql               # Skema database + data contoh
├── index.php                  # Entry point (redirect)
└── README.md                  # Dokumentasi
```

---

## Cara Instalasi (XAMPP/Laragon)

### 1. Setup Database
1. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`)
2. Buat database baru dengan nama `rental_mobil`
3. Import file `database.sql` atau jalankan query-nya di tab SQL

### 2. Setup Project
1. Copy folder `uas-rental-mobil` ke dalam direktori web server:
   - **XAMPP**: `C:\xampp\htdocs\ppw1-portofolio\`
   - **Laragon**: `C:\laragon\www\ppw1-portofolio\`
2. Pastikan konfigurasi database di `includes/config.php` sudah sesuai

### 3. Akses Aplikasi
- Buka browser: `http://localhost/ppw1-portofolio/uas-rental-mobil/`
- Login dengan: **admin** / **admin123**

---

## Akun Demo
| Username | Password  | Role  |
|----------|-----------|-------|
| admin    | admin123  | Admin |
| zalfa    | admin123  | Admin |

---

## Teknologi
- PHP 7.4+ (murni, tanpa framework)
- MySQL / MariaDB
- Bootstrap 5.3
- Vanilla JavaScript
- Bootstrap Icons

---

## Spesifikasi UAS yang Dipenuhi
| No | Komponen              | Status |
|----|-----------------------|--------|
| 1  | Database & CRUD       | ✅     |
| 2  | Prepared Statements   | ✅     |
| 3  | Struktur Folder Rapi  | ✅     |
| 4  | Bootstrap Responsif   | ✅     |
| 5  | Navbar Collapse       | ✅     |
| 6  | Min 3 Komponen BS     | ✅ (Card, Modal, Button) |
| 7  | Login Session         | ✅     |
| 8  | password_hash/verify  | ✅     |
| 9  | htmlspecialchars      | ✅     |
| 10 | Validasi JS (2+ field)| ✅     |
| 11 | confirm() Delete      | ✅     |
| 12 | DOM Manipulation      | ✅     |
| 13 | addEventListener      | ✅     |
| 14 | Search & Pagination   | ✅     |
| 15 | Min 5 Record          | ✅ (7 mobil, 5 transaksi) |

---

*© 2026 Zalfa Ajeng Suardafa — TRPL*
