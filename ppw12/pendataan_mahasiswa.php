<?php

function bersihkan($data){
    return htmlspecialchars(trim($data));
}

$hasil = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $nama = bersihkan($_POST['nama']);
    $nim = bersihkan($_POST['nim']);
    $prodi = bersihkan($_POST['prodi']);
    $ipk = bersihkan($_POST['ipk']);
    $semester = bersihkan($_POST['semester']);

    if(empty($nama) || empty($nim) || empty($prodi) || empty($ipk) || empty($semester)){
        $hasil = "Semua field wajib diisi!";

    } else {

        if($ipk >= 3.75){
            $predikat = "Cumlaude";

        } elseif($ipk >= 3.50){
            $predikat = "Sangat Memuaskan";

        } elseif($ipk >= 2.75){
            $predikat = "Memuaskan";

        } else {
            $predikat = "Cukup";
        }

        $hasil = "
        Nama : $nama <br>
        NIM : $nim <br>
        Prodi : $prodi <br>
        IPK : $ipk <br>
        Semester : $semester <br>
        Predikat : $predikat
        ";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendataan Mahasiswa</title>
</head>
<body>
<h2>Form Pendataan Mahasiswa</h2>
<form method="POST">
    <label>Nama</label><br>
    <input type="text" name="nama" required><br><br>
    <label>NIM</label><br>
    <input type="text" name="nim" required><br><br>
    <label>Prodi</label><br>
    <select name="prodi" required>
        <option value="">-- Pilih Prodi --</option>
        <option value="TRPL">TRPL</option>
        <option value="Informatika">Informatika</option>
        <option value="Sistem Informasi">Sistem Informasi</option>
    </select><br><br>
    <label>IPK</label><br>
    <input type="number" step="0.01" name="ipk" required><br><br>
    <label>Semester</label><br>
    <input type="number" name="semester" required><br><br>
    <button type="submit">Simpan</button>
</form>
<hr>

<?= $hasil; ?>

</body>
</html>