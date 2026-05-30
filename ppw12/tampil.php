<h2>List Data</h2>
<table border="1">
  <tr>
    <th>No</th>
    <th>Nama</th>
  </tr>
  <?php
    include 'conn.php';
    $mahasiswa = mysqli_query($conn, "select * from mahasiswa");
    $no = 1;
    foreach ($mahasiswa as $value) {
      echo "
      <tr>
        <td>$no</td>
        <td>" . $value['nama'] . "</td>
        <td>" . $value['alamat'] . "</td>
      </tr>
      ";
      $no++;
    }
  ?>
</table>