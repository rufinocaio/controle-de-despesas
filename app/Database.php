<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $config = include 'config.php';
        try {
            $this->pdo = new PDO(
                "mysql:host=" . $config['db']['host'] . ";dbname=" . $config['db']['dbname'],
                $config['db']['user'],
                $config['db']['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão com servidor: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
