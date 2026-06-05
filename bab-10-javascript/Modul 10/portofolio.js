// ============================================================
// FILE: portofolio.js
// Ini adalah file JavaScript EKSTERNAL yang dipanggil dari
// bab10_soal1.html menggunakan <script src="portofolio.js">
// ============================================================

// Data proyek mahasiswa
const proyek = [
    { nama: "Sistem Absensi Online", teknologi: "HTML, CSS, JS", tahun: "2024" },
    { nama: "Web Toko Buku Digital", teknologi: "Bootstrap, jQuery", tahun: "2024" },
    { nama: "Aplikasi Kalkulator Ilmiah", teknologi: "JavaScript Murni", tahun: "2023" },
];

// Membangun konten HTML dari data di atas
let isiKonten = "<strong style='color:#f5a623;'>📂 Daftar Proyek Terbaru:</strong><br><br>";

for (let i = 0; i < proyek.length; i++) {
    isiKonten += `✅ <strong>${proyek[i].nama}</strong> &mdash; ${proyek[i].teknologi} (${proyek[i].tahun})<br>`;
}

isiKonten += "<br><strong style='color:#f5a623;'>🏆 Pengalaman Organisasi:</strong><br><br>";
isiKonten += "✅ Anggota Himpunan Mahasiswa Informatika (2023 - sekarang)<br>";
isiKonten += "✅ Peserta Workshop Pengembangan Web (2024)<br>";

// Memasukkan konten ke elemen HTML dengan id 'output-eksternal'
document.getElementById("output-eksternal").innerHTML = isiKonten;

console.log("✅ File portofolio.js berhasil dimuat dan dieksekusi!");