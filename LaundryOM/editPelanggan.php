<?php

require_once "vendor/autoload.php";
use Laundry\Database;
use Laundry\Pelanggan;

$database = new Database(
    "localhost",
    "laundry-om",
    "root",
    ""
);

$db = $database->connect();

$pelanggan = new Pelanggan($db);
$id = (int) ($_GET['id'] ?? 0);
$namaPelanggan = (string) ($_GET['nama'] ?? "");

$dataPelanggan = $pelanggan->cariPelanggan($id);

if (!$dataPelanggan) {
    die ("Pelanggan tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pelanggan->ubah(
        $id,
        $_POST['nama'],
        $_POST['no_hp'],
        $_POST['alamat'],  
    );

    header("Location: TampilPelanggan.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/numen111104/nide-ui-default@v1.0.0/css/default-ui.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;700;800&display=swap">
</head>
<body>
    <h1>Edit Pelanggan: <?= $namaPelanggan ?></h1>
    <form method="POST">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" value="<?= $dataPelanggan['nama'] ?? '' ?>" required><br>

        <label for="no_hp">Nomor Hp:</label>
        <input type="text" name="no_hp" id="no_hp" value="<?= $dataPelanggan['no_hp'] ?? '' ?>" required><br>

        <label for="alamat">Alamat:</label>
        <input type="text" name="alamat" id="alamat" value="<?= $dataPelanggan['alamat'] ?? '' ?>" required><br>

        <button type="submit">Simpan</button>
        <a href="TampilPelanggan.php">Kembali</a>
    </form>
</body>
</html>