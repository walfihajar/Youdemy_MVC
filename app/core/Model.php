<?php

class Model extends Database
{
    protected $table = "";
    protected $allowedColumns = [];

    public function __construct()
    {
        // Get the singleton instance of the Database class
        $this->db = Database::getInstance();
    }

    /**
     * Inserts data into the database table.
     *
     * @param array $data The data to insert.
     * @throws Exception If the query fails.
     */
    public function insert($data)
    {
        // Filter data based on allowed columns
        if (!empty($this->allowedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        // Prepare keys and values for the SQL query
        $keys = array_keys($data);
        $values = array_map(function ($key) {
            return ":" . $key;
        }, $keys); // Add colon (:) before each key for binding

        // Build the query string
        $query = "INSERT INTO " . $this->table . " (" . implode(",", $keys) . ") VALUES (" . implode(",", $values) . ")";

        // Execute the query with the data
        $this->db->query($query, $data);
    }

    /**
     * Queries the database table using a WHERE clause.
     *
     * @param array $data The conditions for the WHERE clause.
     * @return array|false The query result or false if no rows are found.
     * @throws Exception If the query fails.
     */
    public function where($data): false|array
    {
        $keys = array_keys($data);

        $query = "SELECT * FROM " . $this->table . " WHERE ";

        foreach ($keys as $key) {
            $query .= $key . "=:" . $key . " AND ";
        }
        $query = trim($query, "AND ");

        $result = $this->db->query($query, $data);

        if (is_array($result)) {
            return $result;
        }
        return false;
    }
    public function first($data)
    {
        $keys = array_keys($data);

        $query = "SELECT * FROM " . $this->table . " WHERE ";

        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " AND ";
        }
        $query = trim($query, " AND ");

        // Debugging: Print the query and data array
        error_log("Query: " . $query);
        error_log("Data: " . print_r($data, true));

        $result = $this->db->query($query, $data);

        if (is_array($result) && !empty($result)) {
            return $result[0]; // Return the first row
        }
        return false;
    }

}