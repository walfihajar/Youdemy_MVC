<?php
session_start();
require_once(__DIR__ . '/../models/Utilisateur.php'); 
require_once(__DIR__ . '/../models/Etudiant.php'); 
require_once(__DIR__ . '/../models/Administrateur.php'); 
require_once(__DIR__ . '/../core/Database.php'); 


class AuthController {

  // Affiche la page d'inscription
  public function inscription() {
      require_once __DIR__.'/../views/auth/register.php';
  }

  // Affiche la page de connexion
  public function connection() {
      require_once __DIR__.'/../views/auth/login.php';
  }

  // Handle user login
  public function login() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $email = $this->validateInput($_POST['email']);
          $password = $this->validateInput($_POST['password']);

          try {
              if (empty($email) || empty($password)) {
                  throw new Exception("Veuillez remplir tous les champs.");
              }
              
              $user = Utilisateur::login($email, $password);
              
              // Check if the user account is validated
              if ($user->getRoleId() === 2 && !$user->estValide()) {
                  throw new Exception("Votre compte enseignant n'a pas encore été validé par un administrateur.");
              }
              
              $_SESSION['user'] = [
                  'id' => $user->getId(),
                  'nom' => $user->getNom(),
                  'prenom' => $user->getPrenom(),
                  'email' => $user->getEmail(),
                  'role' => $user->getRoleId() === 1 ? 'etudiant' : ($user->getRoleId() === 2 ? 'enseignant' : 'admin'),
                  'est_valide' => $user->estValide()
              ];

              // Redirect to the correct dashboard based on user role
              if ($_SESSION['user']['role'] === 'admin') {
                  // header('Location: /admin/dashboard.php');
                  require_once __DIR__.'/../views/pages/admin/dashboard.php';
              } elseif ($_SESSION['user']['role'] === 'enseignant') {
                  // header('Location: /enseignant/dashboard.php');
                  require_once __DIR__.'/../views/pages/enseignant/dashboard.php';
              } else {
                  // header('Location: /etudiant/dashboard.php');
                  require_once __DIR__.'/../views/pages/etudiant/dashboard.php';
              }

              exit();
          } catch (Exception $e) {
              $_SESSION['error'] = $e->getMessage();
              // header('Location: /auth/login.php');
              require_once __DIR__.'/../views/auth/login.php';
              exit();
          }
      }
  }

  // Handle user registration
  public function register() {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $nom = $this->validateInput($_POST['nom']);
          $prenom = $this->validateInput($_POST['prenom']);
          $email = $this->validateInput($_POST['email']);
          $password = $this->validateInput($_POST['password']);
          $role = $this->validateInput($_POST['role']);

          try {
              if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($role)) {
                  throw new Exception("Veuillez remplir tous les champs.");
              }
              
              $role_id = $role === 'etudiant' ? 1 : ($role === 'enseignant' ? 2 : 3);
              $est_valide = ($role === 'etudiant') ? 1 : 0;
              $passwordHash = password_hash($password, PASSWORD_BCRYPT);
              
              $user = ($role === 'etudiant')
                  ? new Etudiant(null, $nom, $prenom, $email, $passwordHash, 'active', $est_valide)
                  : new Utilisateur(null, $nom, $prenom, $email, $passwordHash, $role_id, 'active', $est_valide);
              
              $user->save();
              
              $_SESSION['success'] = ($role === 'enseignant') 
                  ? "Votre inscription a été soumise. Un administrateur doit valider votre compte."
                  : "Inscription réussie ! Vous pouvez maintenant vous connecter.";
              
              // header('Location: /auth/login.php');
              require_once __DIR__.'/../views/auth/login.php';
              exit();
          } catch (Exception $e) {
              $_SESSION['error'] = $e->getMessage();
              // header('Location: /auth/register.php');
              require_once __DIR__.'/../views/auth/register.php';
              exit();
          }
      }
  }

  // Handle user logout
  public function logout() {
      session_destroy();
      // header('Location: /auth/login.php');
      require_once __DIR__.'/../views/auth/login.php';
      exit();
  }

  // Input validation to prevent malicious data
  private function validateInput($data) {
      return htmlspecialchars(stripslashes(trim($data)));
  }
}


// class AuthController {

    
//     public function inscription() {
//         require_once __DIR__.'/../views/auth/register.php';
//     }

    
//     public function connection() {
//         require_once __DIR__.'/../views/auth/login.php';
//     }

    
//     public function login() {
//         session_start();
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $email = $this->validateInput($_POST['email']);
//             $password = $this->validateInput($_POST['password']);

//             try {
//                 if (empty($email) || empty($password)) {
//                     throw new Exception("Veuillez remplir tous les champs.");
//                 }
                
//                 $user = Utilisateur::login($email, $password);
                
//                 if ($user->getRoleId() === 2 && !$user->estValide()) {
//                     throw new Exception("Votre compte enseignant n'a pas encore été validé par un administrateur.");
//                 }
                
//                 $_SESSION['user'] = [
//                     'id' => $user->getId(),
//                     'nom' => $user->getNom(),
//                     'prenom' => $user->getPrenom(),
//                     'email' => $user->getEmail(),
//                     'role' => $user->getRoleId() === 1 ? 'etudiant' : ($user->getRoleId() === 2 ? 'enseignant' : 'admin'),
//                     'est_valide' => $user->estValide()
//                 ];
                
//                 header("Location: /cours_en_ligne_mvc/app/views/pages/{$_SESSION['user']['role']}/dashboard.php");
//                 exit();
//             } catch (Exception $e) {
//                 $_SESSION['error'] = $e->getMessage();
//                 header("Location: /cours_en_ligne_mvc/app/views/auth/login.php");
//                 exit();
//             }
//         }
//     }

    
//     public function register() {
//         session_start();
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $nom = $this->validateInput($_POST['nom']);
//             $prenom = $this->validateInput($_POST['prenom']);
//             $email = $this->validateInput($_POST['email']);
//             $password = $this->validateInput($_POST['password']);
//             $role = $this->validateInput($_POST['role']);

//             try {
//                 if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($role)) {
//                     throw new Exception("Veuillez remplir tous les champs.");
//                 }
                
//                 $role_id = $role === 'etudiant' ? 1 : ($role === 'enseignant' ? 2 : 3);
//                 $est_valide = ($role === 'etudiant') ? 1 : 0;
//                 $passwordHash = password_hash($password, PASSWORD_BCRYPT);
                
//                 $user = ($role === 'etudiant')
//                     ? new Etudiant(null, $nom, $prenom, $email, $passwordHash, 'active', $est_valide)
//                     : new Utilisateur(null, $nom, $prenom, $email, $passwordHash, $role_id, 'active', $est_valide);
                
//                 $user->save();
                
//                 $_SESSION['success'] = ($role === 'enseignant') 
//                     ? "Votre inscription a été soumise. Un administrateur doit valider votre compte."
//                     : "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                
//                 header("Location: /cours_en_ligne_mvc/app/views/auth/login.php");
//                 exit();
//             } catch (Exception $e) {
//                 $_SESSION['error'] = $e->getMessage();
//                 header("Location: /cours_en_ligne_mvc/app/views/auth/register.php");
//                 exit();
//             }
//         }
//     }

//     public function logout() {
//         session_start();
//         session_destroy();
//         header("Location: /cours_en_ligne_mvc/app/views/auth/login.php");
//         exit();
//     }

    
//     private function validateInput($data) {
//         return htmlspecialchars(stripslashes(trim($data)));
//     }
// }
?>
