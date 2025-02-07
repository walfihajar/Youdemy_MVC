<?php
require_once __DIR__ . '/Utilisateur.php';

class Enseignant extends Utilisateur {
  // Constructeur
  // Constructeur
  public function __construct($id, $nom, $prenom, $email, $password, $statut = 'active', $est_valide = true) {
    parent::__construct($id, $nom, $prenom, $email, $password, 2, $statut, $est_valide); // 2 est l'ID du rôle enseignant
}

// Méthode pour consulter les inscriptions
public function consulterInscriptions() {
  $db = Database::getInstance()->getConnection();
  try {
      // Récupérer les inscriptions pour tous les cours de l'enseignant
      $stmt = $db->prepare("
          SELECT u.nom, u.prenom, u.email, i.inscrit_a, c.titre AS cours_titre
          FROM inscriptions i
          JOIN utilisateurs u ON i.etudiant_id = u.id_utilisateur
          JOIN courses c ON i.course_id = c.id_course
          WHERE c.enseignant_id = ?
      ");
      $stmt->execute([$this->getId()]);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
      error_log("Erreur lors de la récupération des inscriptions : " . $e->getMessage());
      throw new Exception("Erreur lors de la récupération des inscriptions.");
  }
}

// Méthode pour accéder aux statistiques des cours
public function accederStatistiques() {
    $db = Database::getInstance()->getConnection();
    try {
        // Récupérer les statistiques des cours de l'enseignant
        $stmt = $db->prepare("
            SELECT c.titre, COUNT(i.etudiant_id) AS nombre_inscriptions
            FROM courses c
            LEFT JOIN inscriptions i ON c.id_course = i.course_id
            WHERE c.enseignant_id = ?
            GROUP BY c.id_course
        ");
        $stmt->execute([$this->getId()]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération des statistiques : " . $e->getMessage());
        throw new Exception("Erreur lors de la récupération des statistiques.");
    }
}

// Méthode pour enregistrer un enseignant dans la base de données
public function register() {
    $this->save(); // Utilise la méthode save() de la classe parente Utilisateur
}

public static function getAllEnseignants() {
  $db = Database::getInstance()->getConnection();
  try {
      // Récupérer tous les utilisateurs avec le rôle enseignant (role_id = 2)
      $stmt = $db->prepare("
          SELECT u.* 
          FROM utilisateurs u 
          WHERE u.role_id = 2
      ");
      $stmt->execute();
      $enseignants = [];
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $enseignants[] = new Enseignant(
              $row['id_utilisateur'],
              $row['nom'],
              $row['prenom'],
              $row['email'],
              $row['password'],
              $row['statut'],
              $row['est_valide']
          );
      }
      return $enseignants;
  } catch (PDOException $e) {
      error_log("Erreur lors de la récupération des enseignants : " . $e->getMessage());
      throw new Exception("Erreur lors de la récupération des enseignants.");
  }
}

public function getNombreCategories() {
$db = Database::getInstance()->getConnection();
try {
    // Récupérer le nombre de catégories distinctes pour les cours de l'enseignant
    $stmt = $db->prepare("
        SELECT COUNT(DISTINCT c.categorie_id) AS nombre_categories
        FROM courses c
        WHERE c.enseignant_id = ?
    ");
    $stmt->execute([$this->getId()]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['nombre_categories'];
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération du nombre de catégories : " . $e->getMessage());
    throw new Exception("Erreur lors de la récupération du nombre de catégories.");
}
}
}
?>