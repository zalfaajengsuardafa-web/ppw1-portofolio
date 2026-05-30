<!DOCTYPE html>
<html lang="id">
<head>
  <title>Kalkulator PHP</title>
</head>
<body>
  <h2>Kalkulator Sederhana</h2>
  <form method="GET" action="kalkulator.php">
    <input type="number" name="angka1" placeholder="Angka 1" required>
    <select name="operasi">
      <option value="+">+</option>
      <option value="-">-</option>
      <option value="*">x</option>
      <option value="/">&divide;</option>
    </select>
    <input type="number" name="angka2" placeholder="Angka 2" required>
    <button type="submit">Hitung</button>
  </form>

  <?php
  if (isset($_GET['angka1'])) {
    $a  = (float) $_GET['angka1'];
    $b  = (float) $_GET['angka2'];
    $op = $_GET['operasi'];

    $hasil = match($op) {
      '+' => $a + $b,
      '-' => $a - $b,
      '*' => $a * $b,
      '/' => $b != 0 ? $a / $b : "Error: Pembagi tidak boleh 0!",
    };

    echo "<h3>Hasil: $a $op $b = $hasil</h3>";
  }
  ?>
</body>
</html>