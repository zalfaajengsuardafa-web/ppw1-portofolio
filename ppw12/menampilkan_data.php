<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "akademik";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT nim, nama, alamat FROM mahasiswa";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo "NIM: " . $row["nim"] . " -Name: " . $row["nama"] . " " . $row["alamat"] . "<br>";
  }
} else {
  echo "0 results";
}

mysqli_close($conn);
?>