<?php

class Signup extends Controller
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

    /**
     * @throws Exception
     */
    public function index()
    {
        $data['errors'] = [];
        $user = new User();

        // Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Populate the $data array with form data
            $formData = [
                'first_name' => $_POST['first_name'] ?? '',
                'last_name'  => $_POST['last_name'] ?? '',
                'email'      => $_POST['email'] ?? '',
                'password'   => $_POST['password'] ?? '',
                'id_role'    => $_POST['id_role'] ?? 3, // Default to Student if not provided
            ];

            // Validate the form data
            if ($user->validate($formData)) {
                // Validation passed, insert the user
                $user->insert($formData);

                message("your account has been created");
                redirect('login');
                exit();
            } else {
                // Validation failed, store errors
                $data['errors'] = $user->errors;
            }
        }

        // Set the page title
        $data['title'] = "Sign Up";

        // Load the view and pass the data
        $this->view('signup', $data);

    }
}

