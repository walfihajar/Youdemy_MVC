<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/Utilisateur.php';

class Administrateur extends Utilisateur {
  // Constructeur
  public function __construct($id, $nom, $prenom, $email, $passwordHash = null, $role_id, $statut = 'active', $est_valide = true) {
      parent::__construct($id, $nom, $prenom, $email, $passwordHash, $role_id, $statut, $est_valide);
  }

  // Méthode pour valider un compte enseignant
  public function validerCompteEnseignant($enseignantId) {
      $db = Database::getInstance()->getConnection();
      try {
          $stmt = $db->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = ? AND role_id = 2");
          $stmt->execute([$enseignantId]);
          $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

          if (!$utilisateur) {
              throw new Exception("Aucun enseignant trouvé avec cet ID.");
          }

          $stmt = $db->prepare("UPDATE utilisateurs SET est_valide = TRUE WHERE id_utilisateur = ?");
          $stmt->execute([$enseignantId]);

          if ($stmt->rowCount() > 0) {
              return "Le compte enseignant a été validé avec succès.";
          } else {
              throw new Exception("Erreur lors de la validation du compte enseignant.");
          }
      } catch (PDOException $e) {
          error_log("Erreur dans validerCompteEnseignant : " . $e->getMessage());
          throw new Exception("Erreur lors de la validation du compte enseignant : " . $e->getMessage());
      }
  }

  // Méthode pour gérer les utilisateurs (activer, suspendre, supprimer)
  public function gererUtilisateur($utilisateurId, $action) {
      $db = Database::getInstance()->getConnection();
      try {
          $stmt = $db->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = ?");
          $stmt->execute([$utilisateurId]);
          $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

          if (!$utilisateur) {
              throw new Exception("Aucun utilisateur trouvé avec cet ID.");
          }

          switch ($action) {
              case 'activer':
                  $stmt = $db->prepare("UPDATE utilisateurs SET statut = 'active' WHERE id_utilisateur = ?");
                  break;
              case 'suspendre':
                  $stmt = $db->prepare("UPDATE utilisateurs SET statut = 'suspendu' WHERE id_utilisateur = ?");
                  break;
              case 'supprimer':
                  $stmt = $db->prepare("DELETE FROM utilisateurs WHERE id_utilisateur = ?");
                  break;
              default:
                  throw new Exception("Action non reconnue.");
          }

          $stmt->execute([$utilisateurId]);

          if ($stmt->rowCount() > 0) {
              return "Action '$action' effectuée avec succès sur l'utilisateur.";
          } else {
              throw new Exception("Aucun utilisateur trouvé avec cet ID.");
          }
      } catch (PDOException $e) {
          throw new Exception("Erreur lors de la gestion de l'utilisateur : " . $e->getMessage());
      }
  }

  // Méthode pour accéder aux statistiques globales
  public function accederStatistiquesGlobales() {
      $db = Database::getInstance()->getConnection();
      try {
          $statistiques = [];

          // Nombre total d'utilisateurs
          $stmt = $db->query("SELECT COUNT(*) as total_utilisateurs FROM utilisateurs");
          $statistiques['total_utilisateurs'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_utilisateurs'];

          // Nombre total de cours
          $stmt = $db->query("SELECT COUNT(*) as total_cours FROM courses");
          $statistiques['total_cours'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_cours'];

          // Nombre total d'enseignants
          $stmt = $db->query("SELECT COUNT(*) as total_enseignants FROM utilisateurs WHERE role_id = 2");
          $statistiques['total_enseignants'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_enseignants'];

          // Nombre total d'étudiants
          $stmt = $db->query("SELECT COUNT(*) as total_etudiants FROM utilisateurs WHERE role_id = 1");
          $statistiques['total_etudiants'] = $stmt->fetch(PDO::FETCH_ASSOC)['total_etudiants'];

          return $statistiques;
      } catch (PDOException $e) {
          throw new Exception("Erreur lors de la récupération des statistiques : " . $e->getMessage());
      }
  }

  // Méthode pour récupérer le nombre de cours par catégorie
    public function getNombreCoursParCategorie() {
      $db = Database::getInstance()->getConnection();
      try {
          $stmt = $db->prepare("
              SELECT c.nom AS categorie, COUNT(co.id_course) AS nombre_cours
              FROM categories c
              LEFT JOIN courses co ON c.id_categorie = co.categorie_id
              GROUP BY c.id_categorie
          ");
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
          error_log("Erreur lors de la récupération des cours par catégorie : " . $e->getMessage());
          throw new Exception("Erreur lors de la récupération des cours par catégorie.");
      }
  }

  // Méthode pour récupérer le cours le plus populaire
  public function getCoursPlusPopulaire() {
      $db = Database::getInstance()->getConnection();
      try {
          $stmt = $db->prepare("
              SELECT c.titre, COUNT(i.etudiant_id) AS nombre_inscriptions
              FROM courses c
              LEFT JOIN inscriptions i ON c.id_course = i.course_id
              GROUP BY c.id_course
              ORDER BY nombre_inscriptions DESC
              LIMIT 1
          ");
          $stmt->execute();
          return $stmt->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
          error_log("Erreur lors de la récupération du cours le plus populaire : " . $e->getMessage());
          throw new Exception("Erreur lors de la récupération du cours le plus populaire.");
      }
  }

  // Méthode pour récupérer les top 3 enseignants
  public function getTop3Enseignants() {
      $db = Database::getInstance()->getConnection();
      try {
          $stmt = $db->prepare("
              SELECT u.nom, u.prenom, COUNT(c.id_course) AS nombre_cours
              FROM utilisateurs u
              JOIN courses c ON u.id_utilisateur = c.enseignant_id
              WHERE u.role_id = 2
              GROUP BY u.id_utilisateur
              ORDER BY nombre_cours DESC
              LIMIT 3
          ");
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
          error_log("Erreur lors de la récupération des top 3 enseignants : " . $e->getMessage());
          throw new Exception("Erreur lors de la récupération des top 3 enseignants.");
      }
  }

}
?>