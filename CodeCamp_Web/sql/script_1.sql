CREATE USER 'webadmin'@'localhost' IDENTIFIED BY '123';
GRANT ALL PRIVILEGES ON *.* TO 'webadmin'@'localhost';

CREATE DATABASE Projet_Extia CHARACTER SET utf8 COLLATE utf8_general_ci;

USE Projet_Extia;

CREATE TABLE code_entreprise
(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	code VARCHAR(30) NOT NULL
);

CREATE TABLE role
(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(255),
    description VARCHAR(255),
    date_creation DATE
);

CREATE TABLE utilisateur
(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	nom VARCHAR(30) NOT NULL,
	prenom VARCHAR(30) NOT NULL,
	sexe INT DEFAULT 1,
	login VARCHAR(255) NOT NULL,
	mot_de_passe VARCHAR(255) NOT NULL,
    question_secrete varchar(255),
    reponse_secrete varchar(255),
	email VARCHAR(255) NOT NULL,
	telephone VARCHAR(100),
	agence VARCHAR(50),
	role INT UNSIGNED NOT NULL DEFAULT 4,
	date_creation DATETIME,
	CONSTRAINT role_key
		FOREIGN KEY (role)
		REFERENCES role(id)
)ENGINE=InnoDB;


CREATE TABLE compteur_upload_image
(
    id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    compteur INT UNSIGNED,
    date_creation DATETIME
);


CREATE TABLE evenement
(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	titre VARCHAR(255) NOT NULL,
	date_evenement date NOT NULL,
	heure_evenement VARCHAR(5) NOT NULL,
	lieu VARCHAR(255) NOT NULL, 
	agence VARCHAR(50) NOT NULL,
	descriptif TEXT,
	nombre_place INT,
	nombre_participant INT DEFAULT 0,
	url TEXT,
	image VARCHAR(255),
	categorie INT DEFAULT 0,
	visio_conference INT DEFAULT 0,
	email_contact VARCHAR(255),
    id_createur INT UNSIGNED NOT NULL,
	payant INT DEFAULT 0,
	prix INT,
	date_creation DATETIME,
	date_modification DATETIME
);

CREATE TABLE pays
(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    image VARCHAR(255)
);

CREATE TABLE agence
(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom_agence VARCHAR(50) NOT NULL,
    pays_agence VARCHAR(50) NOT NULL,
    image VARCHAR(255)
);


CREATE TABLE utilisateur_evenement
(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT UNSIGNED NOT NULL,
    id_evenement INT UNSIGNED NOT NULL,
    date_creation DATETIME,
    CONSTRAINT id_utilisateur_key
        FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateur(id),

    CONSTRAINT id_evenement_key
        FOREIGN KEY (id_evenement)
        REFERENCES evenement(id)
)ENGINE=InnoDB;

CREATE TABLE question
(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT UNSIGNED NOT NULL,
    id_createur INT UNSIGNED NOT NULL,
    id_evenement INT UNSIGNED NOT NULL,
    question TEXT,
    date_creation datetime
);

CREATE TABLE  reponse
(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT UNSIGNED NOT NULL,
    id_createur INT UNSIGNED NOT NULL,
    id_evenement INT UNSIGNED NOT NULL,
    id_question INT UNSIGNED NOT NULL,
    reponse TEXT,
    date_creation datetime
);


CREATE TABLE commentaire
(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT UNSIGNED NOT NULL,
    id_evenement INT UNSIGNED NOT NULL,
    note INT UNSIGNED,
    commentaire TEXT,
    date_creation datetime,
    CONSTRAINT id_utilisateur_comm_key
        FOREIGN KEY (id_utilisateur)
        REFERENCES utilisateur(id),

    CONSTRAINT id_evenement_comm_key
        FOREIGN KEY (id_evenement)
        REFERENCES evenement(id)
);


INSERT INTO code_entreprise
(code) 
VALUES
("welcome");


INSERT INTO compteur_upload_image
(compteur, date_creation)
VALUES
(0, NOW());


INSERT INTO role
(libelle, description, date_creation) 
VALUES
("admin_fun", "Administrateur Fun du site", CURDATE()),
("admin_pro", "Administrateur Pro du site", CURDATE()),
("admin_all", "Administrateur Global du site", CURDATE()),
("utilisateur", "Utilisateur du site", CURDATE());


INSERT INTO utilisateur 
(nom, prenom, login, mot_de_passe, email, telephone, agence, question_secrete, reponse_secrete, role, date_creation)
VALUES
("user1", "user1", "user1", SHA1("123456"), "user1_u1@etna-alternance.net", "0102030405", "Paris", "Le nom de votre chien", "toto", 4, NOW()),
("user2", "user2", "user2", SHA1("123456"), "user2_u2@etna-alternance.net", "0102030405", "Paris", "Le nom de votre chien", "toto", 4, NOW()),
("user3", "user3", "user3", SHA1("123456"), "user3_u3@etna-alternance.net", "0102030405", "Paris", "Le nom de votre chien", "toto", 4, NOW()),
("user4", "user4", "user4", SHA1("123456"), "user4_u@etna-alternance.net", "0102030405", "Paris", "Le nom de votre chien", "toto", 4, NOW()),
("mesbat", "yacine", "mesbat_y", SHA1("yskh"), "mesbat_y@etna-alternance.net", "0102030405", "Paris", "Le nom de votre chien", "toto", 3, NOW()),
("smida", "haikel", "smida_h", SHA1("123456"), "smida_h@etna-alternance.net", "0102030405", "Paris", "Le nom de votre chien", "toto", 3, NOW()),
("iche", "nouri", "iche_n", SHA1("123456"), "iche_n@etna-alternance.net", "0102030405", "Paris", "Le nom de votre chien", "toto", 3, NOW()),
("kaimouni", "mossab", "kaimou_m", SHA1("123456"), "kaimou_m@etna-alternance.net", "0102030405", "Paris", "Le nom de votre chien", "toto", 3, NOW());


INSERT INTO pays
(nom)
VALUES 
("France"),
("Belgique"),
("Suisse");


INSERT INTO agence
(nom_agence, pays_agence)
VALUES 
("Lille", "France"),
("Paris", "France"),
("Lyon", "France"),
("Aix-en-Provence", "France"),
("Sophia-Antipolis", "France"),
("Lausanne", "Suisse"),
("Bruxelles", "Belgique");

   
INSERT INTO evenement
(titre, date_evenement, heure_evenement, lieu, agence, descriptif, nombre_place, categorie, visio_conference, email_contact, id_createur, payant, prix, date_creation, image)
VALUES
("Soiree entre collegues", "2015-12-05", "20h10", "Chez Eric !", "Paris", "Petite soiree tranquile entre collegues...", 10, 1, 0, "admin_fun@gmail.com", 8, 0, 0, NOW(), NULL),
("Journee Parc Asterix", "2015-12-20", "8h10", "Parc d'Asterix", "Paris", "Tous au parc !!!", 50, 1, 0, "admin_fun@gmail.com", 8, 1, 15, NOW(), "../upload_image/parc-asterix.png"),
("Formation SQL", "2015-12-22", "10h30", "Agence de Lille", "Lille", "Formation SQL pour les developpeurs de l'agence de Lille", 20, 0, 1, "admin_pro@gmail.com", 8, 0, 0, NOW(), "../upload_image/sql.png"),
("Reunion fin d'annee", "2015-12-28", "9h00", "Paris", "Paris", "Bureau 3 au premier etage", 10, 0, 0, "admin_pro@gmail.com", 8, 0, 0, NOW(), "../upload_image/reunion.jpg"),
("Pot de depart !", "2015-12-15", "17h00", "Lyon", "Lyon", "Pot de depart de notre cher Directeur d'agence Xavier petit", 30, 1, 0, "admin_fun@gmail.com", 8, 0, 0, NOW(), NULL),
("Journee PaintBall", "2015-12-21", "10h00", "PaintBall-Machine", "Aix-en-Provence", "Que le meilleur gagne !", 20, 1, 0, "admin_fun@gmail.com", 8, 1, 5, NOW(), "../upload_image/paintball.png"),
("Formation Premier Secour", "2015-12-17", "11h00", "Rez-de-chausee batiment E", "Lausanne", "Pour ceux qui ne l'ont pas encore effectue. (Place limitee)", 15, 0, 0, "admin_pro@gmail.com", 8, 0, 0, NOW(), "../upload_image/secour.jpg"),
("Bowling !", "2015-12-18", "19h00", "Bowling-Show", "Bruxelles", "Soiree Bowling", 30, 1, 0, "admin_fun@gmail.com", 8, 0, 0, NOW(), "../upload_image/bowling.jpeg"),
("Patinoire !", "2015-12-12", "15h00", "Partinoire de Saint-Ouen", "Paris", "Ramener vos patins, sinon c'est 3 euro la location.", 50, 1, 0, "admin_fun@gmail.com", 8, 0, 0, NOW(), NULL),
("Formation Photoshop", "2015-12-18", "9h20", "Paris", "Paris", "Formation Photoshop", 10, 0, 1, "admin_pro@gmail.com", 8, 0, 0, NOW(), "../upload_image/photoshop.png"),
("Soiree Boxe !", "2015-12-25", "19h20", "Paris", "Paris", "Venez defier vos collegues sur le ring !", 15, 1, 0, "admin_fun@gmail.com", 8, 0, 0, NOW(), "../upload_image/boxe.jpg"),
("Formation PHP", "2015-12-24", "14h10", "Paris", "Paris", "Formation SQL pour les developpeurs de l'agence Paris", 10, 0, 1, "admin_pro@gmail.com", 8, 0, 0, NOW(), "../upload_image/php.png");


-- INSERT INTO utilisateur_evenement
-- (id_utilisateur, id_evenement, date_creation)
-- VALUES
-- (1, 1, NOW()),
-- (2, 1, NOW()),
-- (1, 4, NOW()),
-- (2, 4, NOW()),
-- (3, 4, NOW()),
-- (4, 4, NOW()),
-- (5, 4, NOW()),
-- (8, 6, NOW()),
-- (7, 6, NOW()),
-- (5, 7, NOW()),
-- (6, 7, NOW());


INSERT INTO commentaire
(id_utilisateur, id_evenement, note, commentaire, date_creation)
VALUES
(1, 1, 5, "Super soiree !", NOW()),
(2, 1, 4, "A refaire !", NOW()),
(7, 1, 4, "Au top !", NOW()),
(6, 5, 5, "Aurevoir Xavier !", NOW()),
(5, 9, 2, "Cette patinoire n'est pas top...", NOW());

