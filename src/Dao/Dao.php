<?php
declare(strict_types=1);

namespace App\Dao;

use PDO;

class Dao {
    protected PDO $pdo;

    public function __construct() {
        $cfg = require __DIR__ . '/../../config.php';
        $this->pdo = new PDO(
            $cfg['dsn'],
            $cfg['username'],
            $cfg['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
}
