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
   Majorite BOOL,
   PERMIS BOOL,
   Civilite BOOL,
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


INSERT INTO Utilisateur (ID_ut, nom, prenom, email, mdp_crypte) VALUES
(1, 'Skywalker', 'Luke', 'luke.skywalker@jedi.com', 'mdp123'),
(2, 'Kenobi', 'Obi-Wan', 'obiwan.kenobi@jedi.com', 'mdp456'),
(3, 'Solo', 'Han', 'han.solo@millenniumfalcon.com', 'mdp789'),
(4, 'Tarkin', 'Wilhuff', 'tarkin.empire@deathstar.com', 'mdpEmpire'),
(5, 'Palpatine', 'Sheev', 'palpatine.sith@coruscant.com', 'mdpSith'),
(6, 'Vader', 'Darth', 'vader.sith@deathstar.com', 'mdpDarkSide'),
(7, 'Yoda', '', 'yoda.master@jedi.com', 'mdpJedi'),
(8, 'Windu', 'Mace', 'mace.windu@jedi.com', 'mdpPurple'),
(9, 'Organa', 'Leia', 'leia.organa@resistance.com', 'mdpRebel');


INSERT INTO Etudiant (ID_etu, CV, Majorite, PERMIS, Civilite, ID_ut) VALUES
(1, 'Maître Jedi - Formation avancée', TRUE, FALSE, TRUE, 1),
(2, 'Expert en diplomatie et combat au sabre', TRUE, TRUE, TRUE, 2),
(3, 'Pilote expérimenté - Missions interstellaires', TRUE, TRUE, FALSE, 3);


INSERT INTO Entreprise (ID_ent, SIRET, SIREN, activite, nom_ent, addresse_postal, ID_ut) VALUES
(1, 123456789, 'A12345', 'Transport interstellaire', 'Weyland-Yutani', 'Colonie LV-426', 4),
(2, 987654321, 'B67890', 'Technologie robotique', 'Cyberdyne Systems', 'Silicon Valley', 5),
(3, 456789123, 'C54321', 'Exploitation minière spatiale', 'Tyrell Corporation', 'Los Angeles, 2019', 6);


INSERT INTO Pilote (ID_pil, ID_ut) VALUES
(1, 7), 
(2, 8), 
(3, 9); 


INSERT INTO Annonce (ID_ano, description, ID_ent) VALUES
(1, 'Recherche ingénieur pour maintenance des androïdes.', 1),
(2, 'Offre de stage en cybersécurité pour protéger Skynet.', 2),
(3, 'Recrute mineurs pour extraire du dilithium.', 3);


INSERT INTO POSTULER (ID_etu, ID_ano) VALUES
(1, 1), 
(2, 2), 
(3, 3); 


INSERT INTO VISITER (ID_etu, ID_ano) VALUES
(3, 1), 
(1, 2), 
(2, 3); 






