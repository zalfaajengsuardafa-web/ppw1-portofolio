<?php
/**
 * Shared Grade Conversion Utility
 *
 * Converts a numeric score (0-100) to a letter grade with description.
 *
 * Usage:
 *   require_once __DIR__ . '/../../shared/php/grade_converter.php';
 *   $result = convertGrade(85);
 *   // => ['grade' => 'A', 'description' => 'Sangat Baik', 'color' => 'green']
 */

function convertGrade(int $nilai): array
{
    if ($nilai < 0 || $nilai > 100) {
        return ['error' => 'Nilai harus berada di antara 0 sampai 100.'];
    }

    if ($nilai >= 85) {
        return [
            'grade'       => 'A',
            'description' => 'Sangat Baik',
            'detail'      => 'Luar biasa! Pertahankan prestasi anda.',
            'color'       => 'green',
            'badge'       => 'bg-success',
            'alert'       => 'alert-success',
        ];
    } elseif ($nilai >= 70) {
        return [
            'grade'       => 'B',
            'description' => 'Baik',
            'detail'      => 'Hasil yang bagus, terus tingkatkan!',
            'color'       => 'blue',
            'badge'       => 'bg-primary',
            'alert'       => 'alert-primary',
        ];
    } elseif ($nilai >= 55) {
        return [
            'grade'       => 'C',
            'description' => 'Cukup',
            'detail'      => 'Perlu lebih banyak belajar dan berlatih.',
            'color'       => 'orange',
            'badge'       => 'bg-warning text-dark',
            'alert'       => 'alert-warning',
        ];
    } elseif ($nilai >= 40) {
        return [
            'grade'       => 'D',
            'description' => 'Kurang',
            'detail'      => 'Nilai di bawah standar, perlu perbaikan serius.',
            'color'       => 'purple',
            'badge'       => 'bg-secondary',
            'alert'       => 'alert-secondary',
        ];
    } else {
        return [
            'grade'       => 'E',
            'description' => 'Sangat Kurang',
            'detail'      => 'Tidak memenuhi syarat kelulusan.',
            'color'       => 'red',
            'badge'       => 'bg-danger',
            'alert'       => 'alert-danger',
        ];
    }
}
