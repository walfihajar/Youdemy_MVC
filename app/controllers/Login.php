<?php

class Login extends Controller
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
        $data['errors'] = [];
        $data['title'] = "Login";
        $user = new User();

        // Vérifier si le formulaire a été soumis
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!empty($email) && !empty($password)) {
                // Vérifier si l'utilisateur existe dans la base de données
                $row = $user->first(['email' => $email]);

                if ($row) {
                    // Vérifier le mot de passe
                    if (password_verify($password, $row->password)) {
                        Auth::authenticate($row);
                        redirect('home'); // Rediriger vers la page d'accueil
                    } else {
                        message("Mot de passe incorrect"); // Message d'erreur
                        $data['errors']['password'] = "Mot de passe incorrect";
                    }
                } else {
                    message("Email introuvable"); // Message d'erreur
                    $data['errors']['email'] = "Cet email n'existe pas";
                }
            } else {
                message("L'email et le mot de passe sont requis");
                $data['errors']['email'] = empty($email) ? "L'email est requis" : '';
                $data['errors']['password'] = empty($password) ? "Le mot de passe est requis" : '';
            }
        }

        // Charger la vue
        $this->view('login', $data);
    }



}