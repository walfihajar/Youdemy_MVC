<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            $dsn = "pgsql:host=localhost;port=5432;dbname=youdemy2";
            $username = "postgres";
            $password = "achraf123";
            
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
?>
