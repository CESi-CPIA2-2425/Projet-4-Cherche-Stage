CREATE DATABASE stage;
USE stage; 

CREATE TABLE Utilisateur(
   ID_ut INT,
   nom VARCHAR(50),
   prenom VARCHAR(50),
   email VARCHAR(70),
   mdp_crypte VARCHAR(100),
   PRIMARY KEY(ID_ut)
);

CREATE TABLE Etudiant(
   ID_etu INT,
   CV TEXT,
   Majorite LOGICAL,
   PERMIS LOGICAL,
   Civilite LOGICAL,
   ID_ut INT NOT NULL,
   PRIMARY KEY(ID_etu),
   UNIQUE(ID_ut),
   FOREIGN KEY(ID_ut) REFERENCES Utilisateur(ID_ut)
);

CREATE TABLE Entreprise(
   ID_ent INT,
   SIRET INT,
   SIREN VARCHAR(50),
   activite VARCHAR(50),
   nom_ent VARCHAR(50),
   addresse_postal VARCHAR(50),
   ID_ut INT NOT NULL,
   PRIMARY KEY(ID_ent),
   UNIQUE(ID_ut),
   FOREIGN KEY(ID_ut) REFERENCES Utilisateur(ID_ut)
);

CREATE TABLE Annonce(
   ID_ano INT,
   description VARCHAR(500),
   ID_ent INT NOT NULL,
   PRIMARY KEY(ID_ano),
   FOREIGN KEY(ID_ent) REFERENCES Entreprise(ID_ent)
);

CREATE TABLE Pilote(
   ID_pil INT,
   ID_ut INT NOT NULL,
   PRIMARY KEY(ID_pil),
   UNIQUE(ID_ut),
   FOREIGN KEY(ID_ut) REFERENCES Utilisateur(ID_ut)
);

CREATE TABLE POSTULER(
   ID_etu INT,
   ID_ano INT,
   PRIMARY KEY(ID_etu, ID_ano),
   FOREIGN KEY(ID_etu) REFERENCES Etudiant(ID_etu),
   FOREIGN KEY(ID_ano) REFERENCES Annonce(ID_ano)
);

CREATE TABLE VISITER(
   ID_etu INT,
   ID_ano INT,
   PRIMARY KEY(ID_etu, ID_ano),
   FOREIGN KEY(ID_etu) REFERENCES Etudiant(ID_etu),
   FOREIGN KEY(ID_ano) REFERENCES Annonce(ID_ano)
);







