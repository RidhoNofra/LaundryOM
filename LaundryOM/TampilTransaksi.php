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

$semuaTransaksi = $transaksi->semua();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Transaksi Laundry</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/numen111104/nide-ui-default@v1.0.0/css/default-ui.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;700;800&display=swap">
</head>

<body>

    <h1>Transaksi Laundry</h1>

    <p>
        <a href="tambahTransaksi.php">Buat Transaksi</a>
    </p>

    <table border="1" cellpadding="8">

        <thead>
            <tr>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Layanan</th>
                <th>Berat</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($semuaTransaksi as $dataTransaksi): ?>

                <tr>
                    <td>
                        <?= $dataTransaksi['id'] ?>
                    </td>

                    <td>
                        <?= $dataTransaksi['nama_pelanggan'] ?>
                    </td>

                    <td>
                        <?= $dataTransaksi['pilihan_layanan'] ?>
                    </td>

                    <td>
                        <?= $dataTransaksi['berat'] !== null
                            ? $dataTransaksi['berat'] . ' kg'
                            : '-' ?>
                    </td>

                    <td>
                        Rp<?= number_format(
                            $dataTransaksi['total_harga'],
                            0,
                            ',',
                            '.'
                        ) ?>
                    </td>

                    <td>
                        <?= $dataTransaksi['status'] ?>
                    </td>

                    <td>
                        <?= $dataTransaksi['tanggal'] ?>
                    </td>

                    <td>
                        <a href="ubahStatus.php?id=<?= $dataTransaksi['id'] ?>">
                        <button type="button">Ubah Status</button>
                        </a>
                    </td>
                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</body>

</html>