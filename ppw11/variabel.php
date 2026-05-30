<?php
// ── TIPE DATA DASAR ──────────────────────────────────────
$nama = "Budi Santoso"; // String
$umur = 21; // Integer
$ipk = 3.75; // Float
$lulus = true; // Boolean
$kosong = null; // Null
// Cek tipe data dengan gettype()
echo gettype($nama); // string
echo gettype($umur); // integer
echo gettype($ipk); // double
// ── STRING FUNCTIONS ─────────────────────────────────────
echo strlen($nama); // 12 — panjang string
echo strtoupper($nama); // BUDI SANTOSO
echo strtolower($nama); // budi santoso
echo str_replace("Budi", "Andi", $nama); // Andi Santoso
echo substr($nama, 0, 4); // Budi — ambil 4 karakter
echo trim(" spasi "); // "spasi" — hapus spasi tepi
echo str_contains($nama, "Budi"); // true — PHP 8+
// ── CONCATENATION ────────────────────────────────────────
echo "Nama: " . $nama . ", Umur: " . $umur; // dengan titik
echo "Nama: $nama, Umur: $umur"; // interpolasi string
echo "IPK: {$profil['ipk']}"; // variabel kompleks pakai {}
?>