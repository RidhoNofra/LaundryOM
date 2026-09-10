<?php

require_once "vendor/autoload.php";

use Laundry\Database;
use Laundry\Transaksi;

$database = new Database(
    "localhost",
    "laundry-om",
    "root",
    ""
);

$db = $database->connect();

$transaksi = new Transaksi($db);

$id = (int) $_GET['id'];

$dataTransaksi = $transaksi->cariTransaksi($id);

if (!$dataTransaksi) {
    die("Transaksi tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $status = $_POST['status'];

    $transaksi->ubahStatus(
        $id,
        $status
    );

    header("Location: TampilTransaksi.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ubah Status Transaksi</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/numen111104/nide-ui-default@v1.0.0/css/default-ui.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;700;800&display=swap">
</head>

<body>

    <h1>Ubah Status Transaksi</h1>

    <p>
        ID Transaksi: <?= $dataTransaksi['id'] ?>
    </p>

    <p>
        Status saat ini: <?= $dataTransaksi['status'] ?>
    </p>

    <form method="post">

        <label for="status">Status Baru:</label>

        <select name="status" id="status" required>

            <option value="menunggu"
                <?= $dataTransaksi['status'] === 'menunggu' ? 'selected' : '' ?>>
                Menunggu
            </option>

            <option value="proses"
                <?= $dataTransaksi['status'] === 'proses' ? 'selected' : '' ?>>
                Proses
            </option>

            <option value="selesai"
                <?= $dataTransaksi['status'] === 'selesai' ? 'selected' : '' ?>>
                Selesai
            </option>

        </select>

        <br>

        <button type="submit">Simpan</button>

        <a href="TampilTransaksi.php">Kembali</a>

    </form>

</body>

</html>