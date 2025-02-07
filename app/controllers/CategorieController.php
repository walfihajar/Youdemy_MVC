<?php
require_once(__DIR__ . '/../models/Categorie.php');
require_once __DIR__.'/../config/config.php';

class CategorieController {

    // Afficher toutes les catégories
    public function afficherCategories() {
        // Vérification de la session de l'administrateur
        // if (!isset($_SESSION['utilisateur']) || !$_SESSION['utilisateur']->isAdmin()) {
        //     require_once __DIR__.'/../views/auth/login.php';
        //     exit();
        // }

        // Récupérer toutes les catégories
        try {
            $categories = Categorie::getAllCategorie();
              require_once __DIR__. '/../views/pages/admin/categories.php'; // Charger la vue des catégories
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la récupération des catégories : " . $e->getMessage();
              require_once __DIR__. '/../views/pages/admin/categories.php'; // Charger la vue même en cas d'erreur
        }
    }

    // Gérer les requêtes POST (ajout, modification, suppression)
    public function gererCategorie() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ajouter une catégorie
            if (isset($_POST['add_category'])) {
                $nom = $_POST['nom'];
                $categorie = new Categorie(null, $nom);
                $categorie->insertCategorie();
                $_SESSION['success'] = "Catégorie ajoutée avec succès.";
            }

            // Modifier une catégorie
            if (isset($_POST['update_category'])) {
                $categoryId = $_POST['categoryId'];
                $nom = $_POST['nom'];
                $categorie = new Categorie($categoryId, $nom);
                $categorie->updateCategorie($categoryId);
                $_SESSION['success'] = "Catégorie mise à jour avec succès.";
            }

            // Supprimer une catégorie
            if (isset($_POST['delete_category'])) {
                $categoryId = $_POST['categoryId'];
                Categorie::deleteCategorie($categoryId);
                $_SESSION['success'] = "Catégorie supprimée avec succès.";
            }
        }

        // Rediriger vers la liste des catégories
        header("Location: " . URL . "/CategorieController/afficherCategories");
        exit();
    }
}
?>