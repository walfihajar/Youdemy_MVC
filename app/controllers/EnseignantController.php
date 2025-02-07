<?php
session_start();
require_once(__DIR__ . '/../core/Database.php');
require_once(__DIR__ . '/../models/Enseignant.php');


class EnseignantController {
    // Afficher le tableau de bord de l'enseignant
    public function dashboard() {
        // Vérifier si l'utilisateur est connecté et est un enseignant validé
        // if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'enseignant' || !$_SESSION['user']['est_valide']) {
        //     header("Location: /cours_en_ligne/cours_en_ligne/auth/login.php");
        //     exit();
        // }

        // Créer une instance de l'enseignant
        $enseignant = new Enseignant($_SESSION['user']['id'], $_SESSION['user']['nom'], $_SESSION['user']['prenom'], $_SESSION['user']['email'], '');

        // Récupérer les statistiques des cours
        try {
            $statistiques = $enseignant->accederStatistiques();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $statistiques = [];
        }

        // Récupérer le nombre de catégories
        try {
            $nombreCategories = $enseignant->getNombreCategories();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $nombreCategories = 0; // Valeur par défaut en cas d'erreur
        }

        // Récupérer les inscriptions des étudiants pour tous les cours de l'enseignant
        try {
            $inscriptions = $enseignant->consulterInscriptions();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $inscriptions = [];
        }

        // Charger la vue du tableau de bord
        require_once __DIR__ .'/../../views/pages/enseignant/dashboard.php';
    }
}
?>