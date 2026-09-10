<?php

require_once "vendor/autoload.php";

use Laundry\Database;
use Laundry\Pelanggan;
use Laundry\Layanan;
use Laundry\Transaksi;

$database = new Database(
    "localhost",
    "laundry-om",
    "root",
    ""
);

$db = $database->connect();

$pelanggan = new Pelanggan($db);
$layanan = new Layanan($db);
$transaksi = new Transaksi($db);

$semuaPelanggan = $pelanggan->semua();
$semuaLayanan = $layanan->semua();

$pesanError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_pelanggan = (int) $_POST['id_pelanggan'];
    $id_layanan = (int) $_POST['id_layanan'];

    $berat = !empty($_POST['berat'])
        ? (int) $_POST['berat']
        : null;

    try {
        $transaksi->tambah(
            $id_pelanggan,
            $id_layanan,
            $berat
        );

        header("Location: TampilTransaksi.php");
        exit();

    } catch (Exception $error) {
        $pesanError = $error->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Buat Transaksi</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/numen111104/nide-ui-default@v1.0.0/css/default-ui.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;700;800&display=swap">
</head>

<body>

    <h1>Buat Transaksi</h1>

    <?php if ($pesanError): ?>
        <p><?= $pesanError ?></p>
    <?php endif; ?>

    <form method="post">

        <label for="id_pelanggan">Pelanggan:</label>

        <select name="id_pelanggan" id="id_pelanggan" required>

            <option value="">-- Pilih Pelanggan --</option>

            <?php foreach ($semuaPelanggan as $dataPelanggan): ?>

                <option value="<?= $dataPelanggan['id'] ?>">
                    <?= $dataPelanggan['nama'] ?>
                </option>

            <?php endforeach; ?>

        </select>

        <br>

        <label for="id_layanan">Layanan:</label>

        <select name="id_layanan" id="id_layanan" required>

            <option value="">-- Pilih Layanan --</option>

            <?php foreach ($semuaLayanan as $dataLayanan): ?>

                <option value="<?= $dataLayanan['id'] ?>">
                    <?= $dataLayanan['pilihan_layanan'] ?>
                    - Rp<?= number_format($dataLayanan['harga'], 0, ',', '.') ?>
                </option>

            <?php endforeach; ?>

        </select>

        <br>

        <label for="berat">Berat (kg):</label>

        <input
            type="number"
            name="berat"
            id="berat"
            min="1"
        >

        <br>

        <button type="submit">Buat Transaksi</button>

        <a href="TampilTransaksi.php">Kembali</a>

    </form>

</body>

</html>