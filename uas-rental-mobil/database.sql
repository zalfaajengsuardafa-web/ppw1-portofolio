-- ============================================
-- Database: rental_mobil
-- Sistem Rental Mobil - UAS Pemrograman Web 1
-- ============================================

CREATE DATABASE IF NOT EXISTS rental_mobil;
USE rental_mobil;

-- ============================================
-- Tabel: users
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role ENUM('admin', 'petugas') NOT NULL DEFAULT 'petugas',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- Tabel: mobil
-- ============================================
CREATE TABLE IF NOT EXISTS mobil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nopol VARCHAR(15) NOT NULL UNIQUE,
    merk VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    tahun YEAR NOT NULL,
    warna VARCHAR(30) NOT NULL,
    harga_sewa DECIMAL(12,2) NOT NULL,
    status ENUM('tersedia', 'disewa') NOT NULL DEFAULT 'tersedia',
    gambar VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================
-- Tabel: transaksi
-- ============================================
CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_mobil INT NOT NULL,
    nama_penyewa VARCHAR(100) NOT NULL,
    no_ktp VARCHAR(20) NOT NULL,
    no_telp VARCHAR(20) NOT NULL,
    tgl_sewa DATE NOT NULL,
    tgl_kembali DATE NOT NULL,
    total_biaya DECIMAL(12,2) NOT NULL,
    status ENUM('aktif', 'selesai', 'batal') NOT NULL DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_mobil) REFERENCES mobil(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ============================================
-- Data contoh: users (password = 'admin123')
-- ============================================
INSERT INTO users (username, password, nama_lengkap, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin'),
('zalfa', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Zalfa Ajeng Suardafa', 'admin');

-- ============================================
-- Data contoh: mobil (minimal 5 record)
-- ============================================
INSERT INTO mobil (nopol, merk, model, tahun, warna, harga_sewa, status) VALUES
('AB 1234 CD', 'Toyota', 'Avanza', 2023, 'Putih', 350000.00, 'tersedia'),
('AB 5678 EF', 'Honda', 'Brio', 2022, 'Merah', 300000.00, 'tersedia'),
('AB 9012 GH', 'Suzuki', 'Ertiga', 2023, 'Silver', 375000.00, 'disewa'),
('AB 3456 IJ', 'Daihatsu', 'Xenia', 2021, 'Hitam', 325000.00, 'tersedia'),
('AB 7890 KL', 'Mitsubishi', 'Xpander', 2024, 'Abu-abu', 450000.00, 'tersedia'),
('AB 2345 MN', 'Toyota', 'Innova', 2023, 'Putih', 500000.00, 'tersedia'),
('AB 6789 OP', 'Honda', 'Jazz', 2022, 'Biru', 280000.00, 'disewa');

-- ============================================
-- Data contoh: transaksi (minimal 5 record)
-- ============================================
INSERT INTO transaksi (id_mobil, nama_penyewa, no_ktp, no_telp, tgl_sewa, tgl_kembali, total_biaya, status) VALUES
(3, 'Budi Santoso', '3404112233445566', '081234567890', '2026-06-01', '2026-06-03', 750000.00, 'aktif'),
(7, 'Siti Rahayu', '3404223344556677', '082345678901', '2026-06-02', '2026-06-05', 840000.00, 'aktif'),
(1, 'Ahmad Hidayat', '3404334455667788', '083456789012', '2026-05-20', '2026-05-22', 700000.00, 'selesai'),
(2, 'Dewi Lestari', '3404445566778899', '084567890123', '2026-05-15', '2026-05-17', 600000.00, 'selesai'),
(5, 'Rudi Hermawan', '3404556677889900', '085678901234', '2026-05-10', '2026-05-12', 900000.00, 'selesai');
