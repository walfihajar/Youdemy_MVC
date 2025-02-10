<?php

class Database {
    private static ?Database $instance = null;
    private PDO $pdo;

    /**
     * @throws Exception
     */
    private function __construct() {
        // Use configuration constants from config.php
        $dsn = DBDRIVER . ":host=" . DBHOST . ";port=" . DBPORT . ";dbname=" . DBNAME;
        $username = DBUSER;
        $password = DBPASS;

        try {
            // Create a PDO instance using the configuration values
            $this->pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            throw new Exception("Database connection error: " . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    /**
     * @param string $query
     * @param array $data
     * @param string $type
     * @return array|false
     * @throws Exception
     */
    public function query(string $query, array $data = [], string $type = 'object'): array|false
    {
        try {
            $con = $this->getConnection();
            $stm = $con->prepare($query);

            // Debugging: Print the query and data array
            error_log("Query: " . $query);
            error_log("Data: " . print_r($data, true));

            if ($stm) {
                $check = $stm->execute($data);
                if ($check) {
                    $fetchType = $type === 'object' ? PDO::FETCH_OBJ : PDO::FETCH_ASSOC;
                    $result = $stm->fetchAll($fetchType);

                    if (is_array($result) && count($result) > 0) {
                        return $result;
                    }
                    return []; // Return an empty array if no rows are found
                }
            }
            return false;
        } catch (PDOException $e) {
            // Log the error or handle it as needed
            throw new Exception("Query execution error: " . $e->getMessage());
        }
    }
}