<?php
/**
 * IMT (Body Mass Index) calculation logic extracted from tugas2.php
 */

function hitungIMT(float $berat, float $tinggi): array
{
    if ($tinggi <= 0) {
        return ['error' => 'Tinggi badan harus lebih dari 0.'];
    }
    if ($berat <= 0) {
        return ['error' => 'Berat badan harus lebih dari 0.'];
    }

    $imt = $berat / ($tinggi * $tinggi);

    if ($imt < 18.5) {
        $kategori = 'Kurus';
    } elseif ($imt < 25) {
        $kategori = 'Normal';
    } elseif ($imt < 30) {
        $kategori = 'Gemuk';
    } else {
        $kategori = 'Obesitas';
    }

    return ['imt' => round($imt, 2), 'kategori' => $kategori];
}
