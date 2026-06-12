<?php
/**
 * Grade conversion logic extracted from konversi_nilai.php
 * Converts a numeric score (0-100) to a letter grade.
 */

function konversiNilai(int $nilai): array
{
    if ($nilai < 0 || $nilai > 100) {
        return ['error' => 'Nilai harus berada di antara 0 sampai 100.'];
    }

    if ($nilai >= 85) {
        $grade = 'A';
        $deskripsi = 'Sangat Baik';
    } elseif ($nilai >= 70) {
        $grade = 'B';
        $deskripsi = 'Baik';
    } elseif ($nilai >= 55) {
        $grade = 'C';
        $deskripsi = 'Cukup';
    } elseif ($nilai >= 40) {
        $grade = 'D';
        $deskripsi = 'Kurang';
    } else {
        $grade = 'E';
        $deskripsi = 'Sangat Kurang';
    }

    return ['grade' => $grade, 'deskripsi' => $deskripsi];
}
