<?php


class User extends Model
{
    protected $table = "users";
    public $errors = [];

    protected $allowedColumns = [
        'first_name',
        'last_name',
        'email',
        'password',
        'id_role',
        'status',
    ];

    /**
     * Override the insert method to handle role-specific logic.
     *
     * @param array $data The data to insert.
     * @throws Exception If the query fails.
     */
    public function insert($data)
    {
        // Set the status based on the id_role
        if (isset($data['id_role'])) {
            if ($data['id_role'] == 2) {
                $data['status'] = 'awaiting'; // Tutor
            } elseif ($data['id_role'] == 3) {
                $data['status'] = 'activated'; // Student
            }
        }
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }


        // Call the parent insert method to handle the actual insertion
        parent::insert($data);
    }

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['first_name'])) {
            $this->errors['first_name'] = "First name is required";
        }

        if (empty($data['last_name'])) {
            $this->errors['last_name'] = "Last name is required";
        }

        // Check if the 'email' key exists in the $data array
        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required";
        } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Invalid email format";
        } else {
            // Check if the email already exists
            $existingUser = $this->WHERE(['email' => $data['email']]);
            if (!empty($existingUser)) {
                $this->errors['email'] = "Email already exists";
            }
        }

        if (empty($data['password'])) {
            $this->errors['password'] = "Password is required";
        }

        return empty($this->errors);  // If errors array is empty, return true
    }
}