DROP DATABASE stage;
CREATE DATABASE stage;
USE stage;

CREATE TABLE Utilisateur(
   Id_uti INT AUTO_INCREMENT,
   civilite BOOL,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(70) NOT NULL,
   descriptif VARCHAR(400),
   mot_de_passe VARCHAR(100) NOT NULL,
   role VARCHAR(10)NOT NULL,
   PRIMARY KEY(Id_uti),
   UNIQUE(email)
);

CREATE TABLE Etudiant(
   Id_etu INT AUTO_INCREMENT,
   cv LONGBLOB,
   majorité BOOL NOT NULL,
   permis BOOL,
   civilite VARCHAR(2) NOT NULL,
   etablissement VARCHAR(50),
   Id_uti INT NOT NULL,
   PRIMARY KEY(Id_etu),
   UNIQUE(Id_uti),
   FOREIGN KEY(Id_uti) REFERENCES Utilisateur(Id_uti)
);

CREATE TABLE Pilote(
   Id_pil INT AUTO_INCREMENT,
   Id_etu INT NOT NULL,
   Id_uti INT NOT NULL,
   PRIMARY KEY(Id_pil),
   UNIQUE(Id_uti),
   FOREIGN KEY(Id_etu) REFERENCES Etudiant(Id_etu),
   FOREIGN KEY(Id_uti) REFERENCES Utilisateur(Id_uti)
);

CREATE TABLE Entreprise(
   Id_ent INT AUTO_INCREMENT,
   nom_ent VARCHAR(70) NOT NULL,
   adresse VARCHAR(100) NOT NULL,
   SIRET INT NOT NULL,
   SIREN INT NOT NULL,
   domaine_activite VARCHAR(50) NOT NULL,
   Id_uti INT NOT NULL,
   PRIMARY KEY(Id_ent),
   UNIQUE(Id_uti),
   UNIQUE(SIREN),
   FOREIGN KEY(Id_uti) REFERENCES Utilisateur(Id_uti)
);

CREATE TABLE Annonce(
   Id_ann INT AUTO_INCREMENT,
   titre VARCHAR(50) NOT NULL,
   contenu VARCHAR(800),
   Id_ent INT NOT NULL,
   PRIMARY KEY(Id_ann),
   FOREIGN KEY(Id_ent) REFERENCES Entreprise(Id_ent)
);

CREATE TABLE Postuler(
   Id_etu INT,
   Id_ann INT,
   PRIMARY KEY(Id_etu, Id_ann),
   FOREIGN KEY(Id_etu) REFERENCES Etudiant(Id_etu),
   FOREIGN KEY(Id_ann) REFERENCES Annonce(Id_ann)
);

CREATE TABLE Visiter(
   Id_etu INT,
   Id_ann INT,
   PRIMARY KEY(Id_etu, Id_ann),
   FOREIGN KEY(Id_etu) REFERENCES Etudiant(Id_etu),
   FOREIGN KEY(Id_ann) REFERENCES Annonce(Id_ann)
);

CREATE TABLE Wishlist(
   Id_etu INT,
   Id_ann INT,
   PRIMARY KEY(Id_etu, Id_ann),
   FOREIGN KEY(Id_etu) REFERENCES Etudiant(Id_etu),
   FOREIGN KEY(Id_ann) REFERENCES Annonce(Id_ann)
);



USE stage;

--  UTILISATEURS : 9 rôles uniques
INSERT INTO Utilisateur (nom, prenom, email, descriptif, mot_de_passe,role) VALUES
-- Étudiants
('Skywalker', 'Luke', 'luke@jedi.org', 'Jeune Jedi motivé pour explorer les étoiles', 'mdp123','etudiant'),
('Rey', 'Nobody', 'rey@jedi.org', 'À la recherche de sa place dans la galaxie', 'mdp123','etudiant'),
('Finn', 'FN-2187', 'finn@resistance.org', 'Ancien stormtrooper en reconversion', 'mdp123','etudiant'),

-- Pilotes (superviseurs)
('Kenobi', 'Obi-Wan', 'kenobi@jedi.org', 'Encadre la formation de Luke', 'mdp123','pilote'),
('Organa', 'Leia', 'leia@resistance.org', 'Guide Rey dans sa quête', 'mdp123','pilote'),
('Poe', 'Dameron', 'poe@resistance.org', 'Pilote d’élite mentor de Finn', 'mdp123','pilote'),

-- Gestionnaires d'entreprises
('Ripley', 'Ellen', 'ripley@weyland.com', 'Responsable mission scientifique Weyland', 'mdp123','entreprise'),
('Kirk', 'James', 'kirk@enterprise.com', 'Capitaine recruteur pour Starfleet', 'mdp123','entreprise'),
('Mando', 'Din Djarin', 'mando@nevarro.net', 'Recherche jeunes talents pour la Guilde', 'mdp123','entreprise');

--  ETUDIANTS (liés aux 3 premiers utilisateurs)
INSERT INTO Etudiant (cv, majorité, permis, civilite, etablissement, Id_uti) VALUES
(NULL, TRUE, TRUE, TRUE, 'Temple Jedi', 1),   -- Luke
(NULL, TRUE, FALSE, FALSE, 'Base Echo', 2),   -- Rey
(NULL, TRUE, TRUE, TRUE, 'Corps de la Résistance', 3); -- Finn

--  PILOTES (liés à 3 étudiants distincts)
INSERT INTO Pilote (Id_etu, Id_uti) VALUES
(1, 4), -- Kenobi encadre Luke
(2, 5), -- Leia encadre Rey
(3, 6); -- Poe encadre Finn

-- D'abord : ENTREPRISES avec Id_ent fixe pour correspondre aux annonces
INSERT INTO Entreprise (Id_ent, nom_ent, adresse, SIRET, SIREN, domaine_activite, Id_uti) VALUES
(1, 'Weyland-Yutani', 'LV-426, Zeta II Reticuli', 111100001, 111111111, 'Xenobiologie', 7), -- Ripley
(2, 'Starfleet Academy', 'USS Enterprise, Secteur Alpha', 222200002, 222222222, 'Exploration', 8), -- Kirk
(3, 'Guilde des Chasseurs', 'Nevarro, Zone extérieure', 333300003, 333333333, 'Sécurité privée', 9); -- Mando

-- Ensuite : ANNONCES avec clé étrangère correcte vers ENTREPRISE via Id_ent
INSERT INTO Annonce (titre, contenu, Id_ent) VALUES
('Mission scientifique sur LV-426', 'Analyse d’échantillons biologiques en conditions extrêmes.', 1),
('Exploration du Quadrant Bêta', 'Stage d’observation à bord de l’USS Enterprise.', 2),
('Protection des convois de Nevarro', 'Accompagnement de missions sécurisées en bordure extérieure.', 3);


--  WISHLIST : chaque étudiant met une annonce en favori
INSERT INTO Wishlist (Id_etu, Id_ann) VALUES
(1, 2), -- Luke → Exploration
(2, 1), -- Rey → Xenobiologie
(3, 3); -- Finn → Sécurité

--  VISITER : étudiants ont consulté des offres
INSERT INTO Visiter (Id_etu, Id_ann) VALUES
(1, 1), (1, 2),
(2, 1), (2, 3),
(3, 2), (3, 3);

--  POSTULER : au moins un a postulé
INSERT INTO Postuler (Id_etu, Id_ann) VALUES
(2, 1), -- Rey postule chez Weyland
(3, 3); -- Finn postule chez Nevarro