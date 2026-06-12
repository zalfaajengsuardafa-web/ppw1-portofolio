<?php
/**
 * Calculator logic extracted from kalkulator.php
 * Performs basic arithmetic operations.
 */

function hitung(float $a, float $b, string $op)
{
    return match ($op) {
        '+' => $a + $b,
        '-' => $a - $b,
        '*' => $a * $b,
        '/' => $b != 0 ? $a / $b : 'Error: Pembagi tidak boleh 0!',
        default => 'Error: Operasi tidak dikenal!',
    };
}
