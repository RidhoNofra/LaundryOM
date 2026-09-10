<?php

require_once "vendor/autoload.php";

use Laundry\Database;
use Laundry\Layanan;

$database = new Database(
    "localhost",
    "laundry-om",
    "root",
    ""
);

$db = $database->connect();

$layanan = new Layanan($db);

$id = (int) $_GET['id'];

$dataLayanan = $layanan->cariLayanan($id);

if (!$dataLayanan) {
    die("Layanan tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $layanan->hapus($id);

    header("Location: TampilLayanan.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hapus Layanan</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/numen111104/nide-ui-default@v1.0.0/css/default-ui.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;700;800&display=swap">
</head>

<body>

    <h1>Hapus Layanan</h1>

    <p>
        Apakah kamu yakin ingin menghapus layanan
        <strong><?= $dataLayanan['pilihan_layanan'] ?></strong>?
    </p>

    <p>
        Harga: Rp<?= $dataLayanan['harga'] ?>
    </p>

    <form method="post">
        <button type="submit">Ya, Hapus</button>
        <a href="TampilLayanan.php">Batal</a>
    </form>

</body>

</html>