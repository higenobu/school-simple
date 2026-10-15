<?php
class Dao {
    protected PDO $pdo;

    public function __construct() {
        $cfg = require __DIR__ . '/config.php';
        $this->pdo = new PDO(
            $cfg['dsn'],
            $cfg['username'],
            $cfg['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
}
