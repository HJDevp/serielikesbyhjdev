CREATE DATABASE `APP STREAM FILM`;

USE `APP STREAM FILM`;

CREATE TABLE IF NOT EXISTS `Utlisateur`
(
 `id` INT NOT NULL AUTO_INCREMENT,
 `login` TEXT NOT NULL,
 `motdepasse` TEXT NOT NULL,
 `isAdmin` tinyint DEFAULT 0,
 PRIMARY KEY(`id`)
);


CREATE TABLE IF NOT EXISTS `Films`
(
 `id` INT NOT NULL AUTO_INCREMENT,
 `titre` VARCHAR(100) NOT NULL,
 `resume` TEXT NOT NULL,
 `lienImage` TEXT NOT NULL,
 PRIMARY KEY(`id`)
)

-- ALTERATION DANS LA TABLE Film --
ALTER TABLE `Film`
ADD `datedesortie` DATE AFTER `lienImage`;

ALTER TABLE `Film`
ADD `genre` TEXT NOT NULL AFTER `datedesortie`,
ADD `duree` TEXT NOT NULL,
ADD `acteur` VARCHAR(80) NOT NULL;





CREATE TABLE IF NOT EXISTS `note`
(
`id`INT NOT NULL AUTO_INCREMENT,
`idFilm` INT NOT NULL,
`idUtilisateur` INT NOT NULL,
`noteSur5` INT NOT NULL,
 FOREIGN KEY (`idFilm`) REFERENCES `Film`(`id`),
 FOREIGN KEY(`idUtilisateur`) REFERENCES `Utilisateur`(`id`),
 PRIMARY KEY(`id`)
);

/* Pour calculer la moyenne de chaque note de film */

SELECT film.id, film.titre, film.resume, film.lienImage, AVG(note.noteSur5)
FROM film, note, utilisateur
WHERE
film.id = note.idFilm
AND
note.idUtilisateur = utilisateur.id
GROUP BY film.id;

SELECT Film.titre, Utilisateur.login, note.noteSur5
FROM Film, Utilisateur, note
WHERE
Film.id = note.idFilm
AND
note.idUtilisateur = Utilisateur.id;


SELECT utilisateur.login, note.noteSur5
FROM Film, note, utilisateur
WHERE
Film.id = note.idFilm
AND
note.idUtilisateur = utilisateur.id
AND
film.id = 1;

SELECT AVG(note.noteSur5)
FROM Film, note, utilisateur
WHERE
Film.id = note.idFilm
AND
note.idUtilisateur = utilisateur.id
AND
film.id = 1;