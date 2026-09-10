<?php

namespace Laundry;

use PDO;

class Layanan
{
    public function __construct(
        private PDO $db
    ) {}

    public function semua()
    {
        $stmt = $this->db->query(
            "SELECT * FROM layanan ORDER BY id"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cariLayanan(int $id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM layanan WHERE id = ?"
        );

        $stmt->execute([$id]);

        $layanan = $stmt->fetch(PDO::FETCH_ASSOC);

        return $layanan ?: null;
    }

    public function ubah(
        int $id,
        string $pilihan_layanan,
        int $harga
    ) {
        $stmt = $this->db->prepare(
            "UPDATE layanan
            SET pilihan_layanan = ?, harga = ?
            WHERE id = ?"
        );

        $stmt->execute([
            $pilihan_layanan,
            $harga,
            $id
        ]);
    }

    public function hapus(int $id)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM layanan WHERE id = ?"
        );

        $stmt->execute([$id]);
    }
}