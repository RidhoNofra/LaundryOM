<?php

namespace Laundry;
use PDO;

class Pelanggan {
    public function __construct(
        private PDO $db
    ) {}

    public function semua() {
        $stmt = $this->db->query(
            "SELECT * FROM pelanggan ORDER BY id"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambah(
        string $nama,
        string $no_hp,
        string $alamat
    ) {
        $stmt = $this->db->prepare(
                "INSERT INTO pelanggan (nama, no_hp, alamat) 
                VALUES (?,?,?)"
            ); 

            $stmt->execute(
                [$nama, $no_hp, $alamat]
            );
    }

    public function cariPelanggan(int $id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM pelanggan where id = ?"
        );

        $stmt->execute([$id]);

        $pelanggan = $stmt->fetch(PDO::FETCH_ASSOC);

        return $pelanggan ?: null;
    }

    public function ubah(
        int $id,
        string $nama,
        string $no_hp,
        string $alamat,
    ) {
        $stmt = $this->db->prepare(
            "UPDATE pelanggan SET nama = ?, no_hp = ?, alamat = ? where id=?" 
        ); 

        $stmt->execute([
            $nama,
            $no_hp,
            $alamat,
            $id
        ]);
    }

    public function hapus(int $id) {
        $stmt = $this->db->prepare(
            "DELETE FROM pelanggan WHERE id=?"
        );

        $stmt->execute([$id]);
    }


}



?>