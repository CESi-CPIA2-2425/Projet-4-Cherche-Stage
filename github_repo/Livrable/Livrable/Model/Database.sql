CREATE TABLE Utilisateur(
   Id_uti INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(70) NOT NULL,
   message VARCHAR(400),
   mot_de_passe VARCHAR(100) NOT NULL,
   PRIMARY KEY(Id_uti),
   UNIQUE(email)
);

CREATE TABLE Etudiant(
   Id_etu INT AUTO_INCREMENT,
   cv LONGBLOB,
   majorité LOGICAL NOT NULL,
   permis LOGICAL,
   civilité LOGICAL NOT NULL,
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

CREATE TABLE Annonce(
   Id_ann INT AUTO_INCREMENT,
   titre VARCHAR(50) NOT NULL,
   contenu VARCHAR(800),
   PRIMARY KEY(Id_ann)
);

CREATE TABLE Entreprise(
   Id_ent INT AUTO_INCREMENT,
   SIREN INT NOT NULL,
   adresse VARCHAR(100) NOT NULL,
   domaine_activite VARCHAR(50) NOT NULL,
   Id_ann INT NOT NULL,
   Id_uti INT NOT NULL,
   PRIMARY KEY(Id_ent),
   UNIQUE(Id_uti),
   UNIQUE(SIREN),
   FOREIGN KEY(Id_ann) REFERENCES Annonce(Id_ann),
   FOREIGN KEY(Id_uti) REFERENCES Utilisateur(Id_uti)
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
