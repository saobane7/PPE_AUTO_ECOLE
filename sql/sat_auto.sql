
DROP DATABASE IF EXISTS sat_auto;
CREATE DATABASE IF NOT EXISTS sat_auto ;
USE sat_auto;


CREATE TABLE client (
    id_client INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    date_naissance DATE NOT NULL,
    type ENUM('etudiant', 'particulier', 'professionnel') NOT NULL DEFAULT 'particulier'
     
);

CREATE TABLE moniteur (
    id_moniteur INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    date_embauche DATE NOT NULL,
    numero_agrement VARCHAR(50) 
);


CREATE TABLE cours_theorique (
    id_cours INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(100) NOT NULL,
    date_cours DATE NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    salle VARCHAR(50),
    places_max INT DEFAULT 20,
    statut ENUM('planifie', 'termine', 'annule') DEFAULT 'planifie'
);

CREATE TABLE inscription_theorique (
    id_inscription INT PRIMARY KEY AUTO_INCREMENT,
    id_cours INT NOT NULL,
    id_client INT NOT NULL,
    present BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_cours) REFERENCES cours_theorique(id_cours) ON DELETE CASCADE,
    FOREIGN KEY (id_client) REFERENCES client(id_client) ON DELETE CASCADE,
    UNIQUE KEY unique_inscription (id_cours, id_client)
);

CREATE TABLE cours_pratique (
    id_seance INT PRIMARY KEY AUTO_INCREMENT,
    date_seance DATE NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    id_moniteur INT NOT NULL,
    id_client INT NOT NULL,
    type_vehicule VARCHAR(50) DEFAULT 'voiture',
    statut ENUM('planifie', 'termine', 'annule') DEFAULT 'planifie',
    notes TEXT,
    FOREIGN KEY (id_moniteur) REFERENCES moniteur(id_moniteur) ON DELETE CASCADE,
    FOREIGN KEY (id_client) REFERENCES client(id_client) ON DELETE CASCADE
);



CREATE TABLE examen (
    id_examen INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('theorique', 'pratique') NOT NULL,
    date_examen DATE NOT NULL,
    heure TIME NOT NULL,
    id_client INT NOT NULL,
    lieu VARCHAR(100),
    resultat ENUM('reussi', 'echoue') NULL,
    notes TEXT,
    FOREIGN KEY (id_client) REFERENCES client(id_client) ON DELETE CASCADE
);


create table user (
	iduser int(3) not null auto_increment,
	nom varchar (50),
	prenom varchar(50),
	email varchar(50),
	mdp varchar(255),
	droits enum ("user", "admin"),
	primary key (iduser)
);

insert into user values (null,"Illyes", "Adrien", "a@gmail.com", "123", "admin");
insert into user values (null,"Idir", "Rayane", "b@gmail.com", "456", "user");


INSERT INTO client (nom, prenom, email, mot_de_passe, telephone, date_naissance, type) VALUES
('Dupont','Jean','jean@mail.com','pass1','0600000001','2000-01-10','particulier'),
('Martin','Sara','sara@mail.com','pass2','0600000002','1999-03-12','etudiant'),
('Diallo','Moussa','moussa@mail.com','pass3','0600000003','1998-07-20','particulier'),
('Benali','Yanis','yanis@mail.com','pass4','0600000004','2001-05-15','etudiant'),
('Nguyen','Linh','linh@mail.com','pass5','0600000005','1997-11-30','professionnel');


INSERT INTO moniteur (nom, prenom, email, mot_de_passe, telephone, date_embauche, numero_agrement) VALUES
('Moreau','Paul','paul@mail.com','mdp1','0700000001','2020-02-01','AGR001'),
('Petit','Laura','laura@mail.com','mdp2','0700000002','2019-06-15','AGR002'),
('Traore','Amadou','amadou@mail.com','mdp3','0700000003','2021-01-10','AGR003'),
('Bernard','Julie','julie@mail.com','mdp4','0700000004','2018-09-20','AGR004'),
('Lopez','Carlos','carlos@mail.com','mdp5','0700000005','2022-03-05','AGR005');


INSERT INTO cours_theorique (titre, date_cours, heure_debut, heure_fin, salle, places_max) VALUES
('Code de la route','2026-02-10','09:00','11:00','Salle A',20),
('Priorités','2026-02-12','14:00','16:00','Salle B',20),
('Signalisation','2026-02-15','10:00','12:00','Salle A',20),
('Sécurité','2026-02-18','09:00','11:00','Salle C',20),
('Conduite responsable','2026-02-20','14:00','16:00','Salle B',20);


INSERT INTO inscription_theorique (id_cours, id_client, present) VALUES
(1,1,true),
(2,2,false),
(3,3,true),
(4,4,false),
(5,5,true);


INSERT INTO cours_pratique (date_seance, heure_debut, heure_fin, id_moniteur, id_client, statut, notes) VALUES
('2026-02-11','10:00','11:00',1,1,'planifie','Première séance'),
('2026-02-13','11:00','12:00',2,2,'planifie',''),
('2026-02-16','09:00','10:00',3,3,'termine','Bon niveau'),
('2026-02-19','14:00','15:00',4,4,'planifie',''),
('2026-02-21','15:00','16:00',5,5,'annule','Absent');


INSERT INTO examen (type, date_examen, heure, id_client, lieu, resultat, notes) VALUES
('theorique','2026-03-01','09:00',1,'Paris','reussi',''),
('theorique','2026-03-01','09:00',2,'Paris','echoue','Stress'),
('pratique','2026-03-10','10:00',3,'Créteil','reussi','Bonne conduite'),
('pratique','2026-03-10','11:00',4,'Créteil',NULL,'En attente'),
('theorique','2026-03-05','14:00',5,'Paris','reussi','');
