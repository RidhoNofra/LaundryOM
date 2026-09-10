<?php

namespace Laundry;

use PDOException;
use PDO;

class Database
{
    public function __construct(
        private string $host,
        private string $database,
        private string $username,
        private string $password
    ) {}

    public function connect()
    {
        // kita buat socket atau penghubung awal di dalam sebuah variabel $dsn    
        $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";

        // kita coba koneksi
        try {
            $db = new PDO(
                $dsn,
                $this->username,
                $this->password
            );

            $db->setAttribute(
                PDO::ATTR_ERRMODE, // kita pakai bawaan variabel constant dari class PDO
                PDO::ERRMODE_EXCEPTION
            );

            return $db; //tipe datanya adalah objek PDO
        } catch (PDOException $error) {
            die("Koneksi Gagal: " . $error->getMessage());
        }
    }
}
