<?php
// ── FUNGSI DASAR ─────────────────────────────────────────
function sapa() {
echo "Halo, Selamat Datang!";
}
sapa(); // Memanggil fungsi
// ── FUNGSI DENGAN PARAMETER ──────────────────────────────
function sapaNama($nama, $prodi) {
echo "Halo, $nama dari $prodi!";
}
sapaNama("Ani", "TRPL");
sapaNama("Budi", "SI");
// ── DEFAULT PARAMETER VALUE ──────────────────────────────
function hitungDiskon($harga, $persen = 10) {
$diskon = $harga * $persen / 100;
return $harga - $diskon;
}
echo hitungDiskon(100000); // 90000 — pakai default 10%
echo hitungDiskon(100000, 25); // 75000 — diskon 25%
// ── FUNGSI DENGAN RETURN VALUE ───────────────────────────
function luasPersegi($sisi) {
return $sisi * $sisi;
}
$luas = luasPersegi(7);
echo "Luas persegi: $luas"; // 49
// ── TYPE DECLARATION (PHP 7+) ────────────────────────────
function tambah(int $a, int $b): int {
return $a + $b;
}
echo tambah(5, 3); // 8
// ── ARROW FUNCTION (PHP 7.4+) ────────────────────────────
$kuadrat = fn($x) => $x * $x;
echo $kuadrat(5); // 25
?>