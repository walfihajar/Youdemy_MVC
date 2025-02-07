<?php
require_once(__DIR__ . '/../models/Tag.php');
require_once __DIR__.'/../config/config.php';

class TagController {

    // Afficher tous les tags
    public function afficherTags() {
        try {
            $tags = Tag::getAllTags();
            require_once __DIR__. '/../views/pages/admin/tags.php'; // Charger la vue des tags
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la récupération des tags : " . $e->getMessage();
            require_once __DIR__. '/../views/pages/admin/tags.php'; // Charger la vue même en cas d'erreur
        }
    }

    // Gérer les requêtes POST (ajout, modification, suppression)
    public function gererTag() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['add_tag'])) {
                $nom = $_POST['nom'];
                $tag = new Tag(null, $nom);
                $tag->insertTag();
                $_SESSION['success'] = "Tag ajouté avec succès.";
            }

            if (isset($_POST['update_tag'])) {
                $tagId = $_POST['tagId'];
                $nom = $_POST['nom'];
                $tag = new Tag($tagId, $nom);
                $tag->updateTag($tagId);
                $_SESSION['success'] = "Tag mis à jour avec succès.";
            }

            if (isset($_POST['delete_tag'])) {
                $tagId = $_POST['tagId'];
                Tag::deleteTag($tagId);
                $_SESSION['success'] = "Tag supprimé avec succès.";
            }

            if (isset($_POST['add_multiple_tags'])) {
                $tagNames = explode("\n", $_POST['tag_names']);
                $tagNames = array_map('trim', $tagNames);
                $tagNames = array_filter($tagNames); 
                Tag::insertMultipleTags($tagNames);
                $_SESSION['success'] = "Tags ajoutés avec succès.";
            }
        }

        // Rediriger vers la liste des tags
        header("Location: " . URL . "/TagController/afficherTags");
        exit();
    }
}
?>