<!DOCTYPE html>
<html>
<head>
    <title>Kalkulator Sederhana</title>

    <style>
        body {
            font-family: Arial;
        }

        .kalkulator {
            width: 300px;
            padding: 20px;
            border: 1px solid black;
        }

        input {
            width: 90%;
            padding: 8px;
            margin: 5px 0;
        }

        button {
            padding: 10px;
            margin: 5px;
        }
    </style>
</head>

<body>

<div class="kalkulator">

    <h2>Kalkulator JavaScript</h2>

    <input type="number" id="bil1" placeholder="Bilangan Pertama">

    <input type="number" id="bil2" placeholder="Bilangan Kedua">

    <br>

    <button onclick="tambah()">+</button>
    <button onclick="kurang()">-</button>
    <button onclick="kali()">*</button>
    <button onclick="bagi()">/</button>

    <h3>Hasil : <span id="hasil"></span></h3>

</div>

<script>

function tambah() {

    let a = parseFloat(document.getElementById("bil1").value);
    let b = parseFloat(document.getElementById("bil2").value);

    document.getElementById("hasil").innerHTML = a + b;
}

function kurang() {

    let a = parseFloat(document.getElementById("bil1").value);
    let b = parseFloat(document.getElementById("bil2").value);

    document.getElementById("hasil").innerHTML = a - b;
}

function kali() {

    let a = parseFloat(document.getElementById("bil1").value);
    let b = parseFloat(document.getElementById("bil2").value);

    document.getElementById("hasil").innerHTML = a * b;
}

function bagi() {

    let a = parseFloat(document.getElementById("bil1").value);
    let b = parseFloat(document.getElementById("bil2").value);

    document.getElementById("hasil").innerHTML = a / b;
}

</script>

</body>
</html>