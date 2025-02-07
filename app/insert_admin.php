<?php
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/models/Utilisateur.php';
require_once __DIR__ . '/controllers/AuthController.php';

$nom = "Admin";
$prenom = "Admin";
$email = "admin@youdemy.com";
$password = "admin123"; // Plain password for simplicity
$role_id = 3; // ID for the admin role, as mentioned in your setup

try {
    // Hash the password before storing it
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Create a new user (admin)
    $user = new Utilisateur(null, $nom, $prenom, $email, $passwordHash, $role_id, 'active', 1); 

    // Save the admin user to the database
    $user->save();

    // After creating the admin, redirect to the dashboard
    // Assuming the admin is logging in immediately after creation:
    $authController = new AuthController();
    $authController->login($email, $password);

    // Redirecting to the admin dashboard
    // header("Location: /cours_en_ligne_mvc/app/pages/admin/dashboard.php");
    require_once __DIR__.'/views/pages/admin/dashboard.php';
    exit();
    
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
