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
    $layanan->ubah(
        $id,
        $_POST['pilihan_layanan'],
        (int) $_POST['harga']
    );

    header("Location: TampilLayanan.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Layanan</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/numen111104/nide-ui-default@v1.0.0/css/default-ui.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;700;800&display=swap">
</head>

<body>

    <h1>Edit Layanan</h1>

    <form method="post">

        <label for="pilihan_layanan">Pilihan Layanan:</label>

        <select name="pilihan_layanan" id="pilihan_layanan" required>

            <option value="Cuci lipat"
                <?= $dataLayanan['pilihan_layanan'] === 'Cuci lipat' ? 'selected' : '' ?>>
                Cuci lipat
            </option>

            <option value="Cuci setrika"
                <?= $dataLayanan['pilihan_layanan'] === 'Cuci setrika' ? 'selected' : '' ?>>
                Cuci setrika
            </option>

            <option value="Self-service"
                <?= $dataLayanan['pilihan_layanan'] === 'Self-service' ? 'selected' : '' ?>>
                Self-service
            </option>

        </select>

        <br>

        <label for="harga">Harga:</label>

        <input
            type="number"
            name="harga"
            id="harga"
            value="<?= $dataLayanan['harga'] ?>"
            min="0"
            required
        >

        <br>

        <button type="submit">Simpan Perubahan</button>

        <a href="TampilLayanan.php">Kembali</a>

    </form>

</body>

</html>