<?php
class Admin extends Controller
{
    private Database $db;

    public function __construct()
    {
        // Get the singleton instance of the Database class
        try {
            $this->db = Database::getInstance();
        } catch (Exception $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    public function index()
    {

        $data['title']="Admin";
        $this->view('admin/dashboard',$data);
    }


}