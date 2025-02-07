<?php
require_once(__DIR__ . '/../models/Utilisateur.php');
require_once(__DIR__ . '/../models/Administrateur.php');
require_once(__DIR__ . '/../core/Database.php');

class AdminController {

    // Afficher le tableau de bord de l'administrateur
    public function dashboard() {
      session_start();
      // Vérification de la session de l'administrateur
      // if (!isset($_SESSION['utilisateur']) || !$_SESSION['utilisateur']->isAdmin()) {
      //     require_once __DIR__.'/../views/auth/login.php';
      //     exit();
      // }
  
      // Récupérer les statistiques globales de l'administrateur
      try {
          $admin = $_SESSION['utilisateur'];
          $_SESSION['statistiquesGlobales'] = $admin->accederStatistiquesGlobales();
          $_SESSION['statistiquesGlobales']['total_utilisateurs'] = Utilisateur::getTotalUsers(); // Récupérer le total des utilisateurs
          $_SESSION['coursParCategorie'] = $admin->getNombreCoursParCategorie();
          $_SESSION['coursPlusPopulaire'] = $admin->getCoursPlusPopulaire();
          $_SESSION['top3Enseignants'] = $admin->getTop3Enseignants();
  
          // Passer toutes les données à la vue
          require_once __DIR__. '/../views/pages/admin/dashboard.php'; // Charger la vue du tableau de bord
      } catch (Exception $e) {
          echo "Erreur lors de la récupération des statistiques : " . $e->getMessage();
      }
  }

    // Afficher tous les utilisateurs
    public function afficherUtilisateurs() {
        // if (!isset($_SESSION['utilisateur']) || !$_SESSION['utilisateur']->isAdmin()) {
        //     require_once __DIR__.'/../views/auth/login.php';
        //     exit();
        // }

        // Récupérer tous les utilisateurs
        try {
            $utilisateurs = Utilisateur::getAllUsers(); 
            require_once __DIR__. '/../views/pages/admin/utilisateur.php'; // Charger la vue des utilisateurs
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
            require_once  __DIR__. '/../views/pages/admin/utilisateur.php'; // Charger la vue même en cas d'erreur
        }
    }

    // Valider un compte enseignant
    public function validerCompteEnseignant() {
        // if (!isset($_SESSION['utilisateur']) || !$_SESSION['utilisateur']->isAdmin()) {
        //     require_once __DIR__.'/../views/auth/login.php';
        //     exit();
        // }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $enseignantId = $_POST['enseignant_id'];
            try {
                $admin = $_SESSION['utilisateur'];
                $message = $admin->validerCompteEnseignant($enseignantId);
                $_SESSION['success'] = $message;
                $this->afficherUtilisateurs(); // Rediriger vers la liste des utilisateurs
                exit();
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                $this->afficherUtilisateurs(); // Rediriger vers la liste des utilisateurs
                exit();
            }
        }
    }

    // Gérer un utilisateur (activer, suspendre, supprimer)
    public function gererUtilisateur() {
        // if (!isset($_SESSION['utilisateur']) || !$_SESSION['utilisateur']->isAdmin()) {
        //     require_once __DIR__.'/../views/auth/login.php';
        //     exit();
        // }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $utilisateurId = $_POST['utilisateur_id'];
            $action = $_POST['action'];

            try {
                $admin = $_SESSION['utilisateur'];
                $message = $admin->gererUtilisateur($utilisateurId, $action);
                $_SESSION['success'] = $message;
                $this->afficherUtilisateurs(); // Rediriger vers la liste des utilisateurs
                exit();
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                $this->afficherUtilisateurs(); // Rediriger vers la liste des utilisateurs
                exit();
            }
        }
    }

    // Déconnexion de l'administrateur
    public function logout() {
        session_destroy();
        require_once __DIR__.'/../views/auth/login.php';
        exit();
    }
}
?>