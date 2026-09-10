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

$semuaLayanan = $layanan->semua();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Layanan</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/numen111104/nide-ui-default@v1.0.0/css/default-ui.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;700;800&display=swap">
</head>

<body>

    <h1>Layanan</h1>

    <table border="1" cellpadding="8">

        <thead>
            <tr>
                <th>ID</th>
                <th>Pilihan Layanan</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($semuaLayanan as $layanan): ?>

                <tr>
                    <td><?= $layanan['id'] ?></td>

                    <td><?= $layanan['pilihan_layanan'] ?></td>

                    <td><?= $layanan['harga'] ?></td>

                    <td>
                        <a href="editLayanan.php?id=<?= $layanan['id'] ?>">
                            <button type="button">Edit</button>
                        </a>

                        <a href="hapusLayanan.php?id=<?= $layanan['id'] ?>">
                            <button type="button">Hapus</button>
                        </a>
                    </td>
                </tr>

            <?php endforeach ?>

        </tbody>

    </table>

</body>

</html>