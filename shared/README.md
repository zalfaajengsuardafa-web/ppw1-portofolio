# Shared Utilities

Kumpulan file yang digunakan bersama oleh beberapa bab/modul praktikum.

## CSS (`shared/css/`)

| File | Deskripsi |
|------|-----------|
| `responsive-breakpoints.css` | Media queries untuk breakpoint mobile/tablet/laptop/desktop |
| `responsive-breakpoints-alt.css` | Variasi breakpoints dengan base style |
| `responsive-layout.css` | Layout responsif (header, navbar, hero, grid) |
| `dimsum.css` | Theme CSS untuk halaman restoran dimsum (hero slider, header) |
| `style.css` | Theme CSS untuk halaman restoran (navbar, hero, menu carousel) |

**Digunakan oleh:** `bab-05-stylesheet/`, `bab-06-pegenalan_flex_box/`

## PHP (`shared/php/`)

| File | Fungsi | Deskripsi |
|------|--------|-----------|
| `db_connect.php` | `db_connect()` | Koneksi database MySQL yang reusable |
| `auth.php` | `isLoggedIn()`, `requireLogin()`, `logout()` | Autentikasi session-based |
| `file_upload.php` | `uploadFile()`, `deleteFile()` | Upload & hapus file gambar |
| `grade_converter.php` | `convertGrade()` | Konversi nilai angka ke grade huruf |

**Digunakan oleh:** `bab-12-php/`, `bab-13-php_2/`, `bab-14-crudpraktikum_crud/`

## Cara Pakai

### CSS
```html
<link rel="stylesheet" href="../shared/css/style.css" />
```

### PHP
```php
require_once __DIR__ . '/../shared/php/db_connect.php';
$conn = db_connect('localhost', 'root', '', 'nama_database');
```
