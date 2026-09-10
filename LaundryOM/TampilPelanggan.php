<?php

use Laundry\Pelanggan;
use Laundry\Database;

require_once "vendor/autoload.php";

$database = new Database(
    "localhost",
    "laundry-om",
    "root",
    ""
);

$db = $database->connect();

$pelanggan = new Pelanggan($db);

$semuaPelanggan = $pelanggan->semua();

?>

<!DOCTYPE html>
<html lang="en">
<head>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/numen111104/nide-ui-default@v1.0.0/css/default-ui.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;700;800&display=swap">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan</title>
</head>
<body>
    <h1>Pelanggan</h1>
    <p>
        <a href="tambahPelanggan.php">Tambah</a>
    </p>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Nomor HP</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($semuaPelanggan as $pelanggan): ?>
                <tr>
                    <td><?php echo $pelanggan['id'] ?></td>
                    <td><?= $pelanggan['nama'] ?> </td>
                    <td><?= $pelanggan['no_hp'] ?></td>
                    <td><?= $pelanggan['alamat'] ?></td>
                    <td>
                        <a href="editPelanggan.php?id=<?= $pelanggan['id']?>&nama=<?= $pelanggan['nama'] ?>"><button type="button">Edit</button></a>

                        <a href="hapusPelanggan.php?id=<?= $pelanggan['id']?>&nama=<?= $pelanggan['nama'] ?>"><button type="button">Hapus</button></a>
                    </td>
                </tr>
             <?php endforeach ?>
        </tbody>
    </table>
</body>
</html><?php


?>