-- Définition du type ENUM pour statut
CREATE TYPE statut_enum AS ENUM ('active', 'suspendu');

-- Définition du type ENUM pour rôle
CREATE TYPE role_enum AS ENUM ('etudiant', 'enseignant', 'admin');

CREATE TABLE roles (
    id_role SERIAL PRIMARY KEY,
    nom role_enum NOT NULL
);

CREATE TABLE utilisateurs (
    id_utilisateur SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    statut statut_enum DEFAULT 'active',  -- Utilisation du type ENUM défini
    est_valide BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id_role) ON DELETE CASCADE
);

CREATE TABLE categories (
    id_categorie SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tags (
    id_tag SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TYPE course_type_enum AS ENUM ('video', 'document');

CREATE TABLE courses (
    id_course SERIAL PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255),
    contenu TEXT NOT NULL,
    type course_type_enum NOT NULL, -- Utilisation d'un type ENUM pour `type`
    categorie_id INT,
    enseignant_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categories(id_categorie) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (enseignant_id) REFERENCES utilisateurs(id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE course_tags (
    course_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (course_id, tag_id),
    FOREIGN KEY (course_id) REFERENCES courses(id_course) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id_tag) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE inscriptions (
    course_id INT NOT NULL,
    etudiant_id INT NOT NULL,
    inscrit_a TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (course_id, etudiant_id),
    FOREIGN KEY (course_id) REFERENCES courses(id_course) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (etudiant_id) REFERENCES utilisateurs(id_utilisateur) ON DELETE CASCADE ON UPDATE CASCADE
);
