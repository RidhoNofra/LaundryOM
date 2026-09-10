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
$dataPelanggan = $pelanggan->cariPelanggan($id);

if (!$dataPelanggan) {
    die("Pelanggan tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pelanggan->hapus($id);

    header("Location: TampilPelanggan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Pelanggan</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/numen111104/nide-ui-default@v1.0.0/css/default-ui.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;700;800&display=swap">
</head>

<body>

    <div class="card">
        <h2>Konfirmasi Hapus Pelanggan</h2>

        <p>Apakah kamu yakin ingin menghapus Pelanggan berikut?</p>

        <p>
            <strong>Nama:</strong>
            <?= $dataPelanggan['nama'] ?>
        </p>

        <p>
            <strong>Nomor Hp:</strong>
            <?= $dataPelanggan['no_hp'] ?>
        </p>

        <form method="POST">
            <button type="submit">Ya, Hapus</button>
            <a href="TampilPelanggan.php">Batal</a>
        </form>
    </div>

</body>
</html>