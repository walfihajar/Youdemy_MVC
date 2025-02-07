<?php
require_once __DIR__ . '/Utilisateur.php';

class Etudiant extends Utilisateur {
  // Constructeur
  public function __construct($id, $nom, $prenom, $email, $password, $statut = 'active', $est_valide = true) {
      parent::__construct($id, $nom, $prenom, $email, $password, 1, $statut, $est_valide); // 1 est l'ID du rôle étudiant
  }

  // Méthode pour consulter les détails d'un cours
  public function consulterDetailsCours($coursId) {
      $db = Database::getInstance()->getConnection();
      try {
          $stmt = $db->prepare("SELECT * FROM courses WHERE id_course = ?");
          $stmt->execute([$coursId]);
          $cours = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($cours) {
              $stmtTags = $db->prepare("SELECT t.nom FROM tags t JOIN course_tags ct ON t.id_tag = ct.tag_id WHERE ct.course_id = ?");
              $stmtTags->execute([$coursId]);
              $tags = $stmtTags->fetchAll(PDO::FETCH_COLUMN);

              $stmtCategorie = $db->prepare("SELECT nom FROM categories WHERE id_categorie = ?");
              $stmtCategorie->execute([$cours['categorie_id']]);
              $categorie = $stmtCategorie->fetchColumn();

              return [
                  'titre' => $cours['titre'],
                  'description' => $cours['description'],
                  'image' => $cours['image'],
                  'contenu' => $cours['contenu'],
                  'type' => $cours['type'],
                  'categorie' => $categorie,
                  'tags' => $tags
              ];
          } else {
              throw new Exception("Cours introuvable.");
          }
      } catch (PDOException $e) {
          error_log("Erreur lors de la consultation des détails du cours : " . $e->getMessage());
          throw new Exception("Erreur lors de la récupération des détails du cours.");
      }
  }

  // Méthode pour s'inscrire à un cours
  public function sInscrireCours($coursId) {
      $db = Database::getInstance()->getConnection();
      try {
          $stmt = $db->prepare("SELECT * FROM inscriptions WHERE course_id = ? AND etudiant_id = ?");
          $stmt->execute([$coursId, $this->getId()]);
          $inscription = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($inscription) {
              throw new Exception("Vous êtes déjà inscrit à ce cours.");
          }

          $stmt = $db->prepare("INSERT INTO inscriptions (course_id, etudiant_id) VALUES (?, ?)");
          $stmt->execute([$coursId, $this->getId()]);

          return true;
      } catch (PDOException $e) {
          error_log("Erreur lors de l'inscription au cours : " . $e->getMessage());
          throw new Exception("Erreur lors de l'inscription au cours.");
      }
  }

  // Méthode pour accéder à la liste des cours de l'étudiant
  public function accederMesCours() {
      $db = Database::getInstance()->getConnection();
      try {
          $stmt = $db->prepare("SELECT c.* FROM courses c JOIN inscriptions i ON c.id_course = i.course_id WHERE i.etudiant_id = ?");
          $stmt->execute([$this->getId()]);
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
          error_log("Erreur lors de la récupération des cours de l'étudiant : " . $e->getMessage());
          throw new Exception("Erreur lors de la récupération des cours.");
      }
  }

  // Méthode pour enregistrer un étudiant
  public function register() {
      $this->save();
  }
}
?>