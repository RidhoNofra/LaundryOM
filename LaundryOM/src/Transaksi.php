<?php

namespace Laundry;

use PDO;

use Exeption;

class Transaksi
{
    public function __construct(
        private PDO $db
    ) {}

    public function semua()
{
    $stmt = $this->db->query(
        "SELECT 
            transaksi.id,
            pelanggan.nama AS nama_pelanggan,
            layanan.pilihan_layanan,
            transaksi.berat,
            transaksi.total_harga,
            transaksi.status,
            transaksi.tanggal
        FROM transaksi
        JOIN pelanggan 
            ON transaksi.id_pelanggan = pelanggan.id
        JOIN layanan 
            ON transaksi.id_layanan = layanan.id
        ORDER BY transaksi.id"
    );

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function cariTransaksi(int $id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM transaksi WHERE id = ?"
        );

        $stmt->execute([$id]);

        $transaksi = $stmt->fetch(PDO::FETCH_ASSOC);

        return $transaksi ?: null;
    }

    public function tambah(
        int $id_pelanggan,
        int $id_layanan,
        ?int $berat
    ) {
        // Ambil data layanan untuk mendapatkan harga
        $stmtLayanan = $this->db->prepare(
            "SELECT * FROM layanan WHERE id = ?"
        );

        $stmtLayanan->execute([$id_layanan]);

        $layanan = $stmtLayanan->fetch(PDO::FETCH_ASSOC);

        if (!$layanan) {
            throw new Exception("Layanan tidak ditemukan.");
        }

        $harga = (int) $layanan['harga'];

        // Self-service memiliki harga tetap
        if ($layanan['pilihan_layanan'] === 'Self-service') {
            $total_harga = $harga;
            $berat = null;
        } else {
            // Layanan biasa dihitung berdasarkan berat
            if ($berat === null || $berat <= 0) {
                throw new Exception("Berat cucian harus diisi.");
            }

            $total_harga = $harga * $berat;
        }

        $status = 'menunggu';
        $tanggal = date('Y-m-d');

        $stmt = $this->db->prepare(
            "INSERT INTO transaksi
            (id_pelanggan, id_layanan, berat, total_harga, status, tanggal)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->execute([
            $id_pelanggan,
            $id_layanan,
            $berat,
            $total_harga,
            $status,
            $tanggal
        ]);
    }

    public function ubahStatus(
    int $id,
    string $status
) {
    $stmt = $this->db->prepare(
        "UPDATE transaksi
        SET status = ?
        WHERE id = ?"
    );

    $stmt->execute([
        $status,
        $id
    ]);
}

public function riwayat()
{
    $stmt = $this->db->query(
        "SELECT 
            transaksi.id,
            pelanggan.nama AS nama_pelanggan,
            layanan.pilihan_layanan,
            transaksi.berat,
            transaksi.total_harga,
            transaksi.status,
            transaksi.tanggal
        FROM transaksi
        JOIN pelanggan
            ON transaksi.id_pelanggan = pelanggan.id
        JOIN layanan
            ON transaksi.id_layanan = layanan.id
        WHERE transaksi.status = 'selesai'
        ORDER BY transaksi.id"
    );

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}

?>