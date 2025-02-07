<?php
session_start();

require_once __DIR__.'/../models/Cours.php';
require_once __DIR__.'/../models/CoursVideo.php';
require_once __DIR__.'/../models/CoursDocument.php';
require_once __DIR__.'/../models/Tag.php';
require_once __DIR__.'/../models/Categorie.php';

class CourseController {
    public function __construct() {
        // Vérifier si l'utilisateur est connecté et est un enseignant
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'enseignant') {
            header("Location: /cours_en_ligne/includes/auth.php?action=login");
            exit();
        }
    }

    public function index() {
        $enseignant_id = $_SESSION['user']['id'];
        $cours = Cours::getAllCour($enseignant_id);
        $tags = Tag::getAllTags();
        $categories = Categorie::getAllCategorie();

        require_once __DIR__.'/../views/pages/enseignant/mes_cours.php';
    }

    public function addCourse() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_course'])) {
            // Récupérer les données du formulaire
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $categorie_id = $_POST['categorie_id'];
            $selected_tags = $_POST['tags'] ?? [];
            $type = $_POST['type'];
            $enseignant_id = $_SESSION['user']['id'];

            // Upload de l'image
            $image_path = $this->uploadFile($_FILES['image'], 'image');
            $contenu = $this->handleContentUpload($type, $_FILES, $_POST);

            // Créer le cours
            $cours = $type === 'video' ? new CoursVideo($titre, $description, $image_path, $contenu, $categorie_id, $enseignant_id) : new CoursDocument($titre, $description, $image_path, $contenu, $categorie_id, $enseignant_id);
            $cours_id = $cours->ajouterCours();

            // Ajouter les tags
            foreach ($selected_tags as $tag_id) {
                $cours->addTag($cours_id, $tag_id);
            }

            header("Location: mes_cours.php");
            exit();
        }
    }

    public function updateCourse() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_course'])) {
            // Récupérer les données du formulaire
            $course_id = $_POST['course_id'];
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $categorie_id = $_POST['categorie_id'];
            $selected_tags = $_POST['tags'] ?? [];

            // Upload de l'image
            $image_path = $_POST['existing_image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image_path = $this->uploadFile($_FILES['image'], 'image');
            }

            // Récupérer le type et le contenu du cours
            $cours = Cours::getCoursById($course_id);
            $contenu = $this->handleContentUpdate($cours, $_FILES, $_POST);

            // Mettre à jour le cours
            $cours->modifierCours($course_id);

            // Mettre à jour les tags
            $cours->updateTags($course_id, $selected_tags);

            header("Location: mes_cours.php");
            exit();
        }
    }

    public function deleteCourse() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_course'])) {
            $course_id = $_POST['course_id'];
            Cours::supprimerCours($course_id);
            header("Location: mes_cours.php");
            exit();
        }
    }

    private function uploadFile($file, $type) {
        if (isset($file) && $file['error'] == 0) {
            $upload_dir =  __DIR__ .'/../views/uploads/';
            $file_name = basename($file['name']);
            $file_path = $upload_dir . $file_name;
            move_uploaded_file($file['tmp_name'], $file_path);
            return $file_path;
        }
        return '';
    }

    private function handleContentUpload($type, $files, $post) {
        if ($type === 'video') {
            return $this->uploadFile($files['video_file'], 'video');
        } elseif ($type === 'document') {
            return $post['document_text'];
        }
        return '';
    }

    private function handleContentUpdate($cours, $files, $post) {
        $type = $cours->getType();
        if ($type === 'video' && isset($files['video_file']) && $files['video_file']['error'] == 0) {
            return $this->uploadFile($files['video_file'], 'video');
        } elseif ($type === 'document' && isset($post['document_text'])) {
            return $post['document_text'];
        }
        return $cours->getContenu();
    }
}
?>