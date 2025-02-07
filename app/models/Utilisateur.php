<?php
class Utilisateur {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $password;
    private $role_id;
    private $statut;
    private $est_valide;

    // Constructeur
    public function __construct($id, $nom, $prenom, $email, $password, $role_id, $statut = 'active', $est_valide = false) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password; // Doit être hashé avant d'être stocké
        $this->role_id = $role_id;
        $this->statut = $statut;
        $this->est_valide = $est_valide;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getRoleId() { return $this->role_id; }
    public function getStatut() { return $this->statut; }
    public function estValide() { return $this->est_valide; }

    // Enregistrer un utilisateur
    public function save() {
        $db = Database::getInstance()->getConnection();
        try {
            $stmt = $db->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, role_id, statut, est_valide) VALUES (?, ?, ?, ?, ?, ?, ?) RETURNING id_utilisateur");
            $stmt->execute([$this->nom, $this->prenom, $this->email, $this->password, $this->role_id, $this->statut, $this->est_valide]);
            $this->id = $stmt->fetchColumn();
            return $this->id;
        } catch (PDOException $e) {
            error_log("Erreur lors de l'enregistrement de l'utilisateur : " . $e->getMessage());
            throw new Exception("Erreur lors de l'enregistrement de l'utilisateur.");
        }
    }

    // Trouver un utilisateur par email
    public static function findByEmail($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new Utilisateur(
                $result['id_utilisateur'],
                $result['nom'],
                $result['prenom'],
                $result['email'],
                $result['password'],
                $result['role_id'],
                $result['statut'],
                $result['est_valide']
            );
        }
        return null;
    }

    // Authentification
    // public static function login($email, $password) {
    //     $user = self::findByEmail($email);

    //     if ($user && password_verify($password, $user->getPassword())) {
    //         if ($user->getStatut() === 'suspendu') {
    //             throw new Exception("Votre compte est suspendu. Veuillez contacter l'administrateur.");
    //         }
    //         if ($user->getRoleId() === 2 && !$user->estValide()) {
    //             throw new Exception("Votre compte enseignant n'a pas encore été validé par un administrateur.");
    //         }
    //         return $user;
    //     }
    //     throw new Exception("Email ou mot de passe incorrect.");
    // }
    public static function login($email, $password) {
      $user = self::findByEmail($email);
  
      if ($user) {
          // Vérifie si le mot de passe correspond
          if (password_verify($password, $user->getPassword())) {
              // Vérifie si le compte est suspendu
              if ($user->getStatut() === 'suspendu') {
                  throw new Exception("Votre compte est suspendu. Veuillez contacter l'administrateur.");
              }
              // Vérifie si le compte enseignant est validé
              if ($user->getRoleId() === 2 && !$user->estValide()) {
                  throw new Exception("Votre compte enseignant n'a pas encore été validé par un administrateur.");
              }
              return $user;
          } else {
              throw new Exception("Mot de passe incorrect.");
          }
      } else {
          throw new Exception("Email incorrect.");
      }
  }

    // Déconnexion
    public static function logout() {
        session_destroy();
        // header("Location: /cours_en_ligne/auth/login.php");
        require_once __DIR__.'/../views/auth/login.php';
        exit();
    }

    public static function getAllUsers() {
      $db = Database::getInstance()->getConnection();
      try {
          $stmt = $db->query("
              SELECT u.*, r.nom AS role_nom 
              FROM utilisateurs u 
              JOIN roles r ON u.role_id = r.id_role
          ");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
          error_log("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
          throw new Exception("Erreur lors de la récupération des utilisateurs.");
      }
  }

  public static function getTotalUsers() {
    $db = Database::getInstance()->getConnection();
    try {
        $stmt = $db->query("SELECT COUNT(*) as total FROM utilisateurs");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Erreur lors de la récupération du total d'utilisateurs : " . $e->getMessage());
        throw new Exception("Erreur lors de la récupération du total d'utilisateurs.");
    }
}

    // Vérifications des rôles
    public function isAdmin() { return $this->role_id === 3; }
    public function isEnseignant() { return $this->role_id === 2; }
    public function isEtudiant() { return $this->role_id === 1; }
}
?>
