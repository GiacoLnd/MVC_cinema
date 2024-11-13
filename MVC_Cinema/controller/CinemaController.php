<?php

namespace Controller;

use Model\Connect;

class CinemaController{

    //lister les films
    public function listFilms(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query ("SELECT titre, DATE_FORMAT(date_sortie, '%Y') AS date_sortie, id_film FROM film");

        require "view/listFilms.php";
    }
    public function listActeurs(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query ("SELECT acteur.id_acteur AS id_acteur, personne.nom, personne.prenom, personne.sexe, DATE_FORMAT(personne.date_naissance, '%d/%m/%Y') AS date_naissance FROM acteur INNER JOIN personne ON acteur.id_personne = personne.id_personne WHERE personne.id_personne IN (SELECT id_personne FROM acteur)");

        require "view/listActeurs.php";
    }
    
    public function detailFilm($id){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare ("SELECT titre, TIME_FORMAT(SEC_TO_TIME(duree * 60), '%H:%i') AS duree, DATE_FORMAT(date_sortie, '%Y') AS date_sortie, synopsis FROM film WHERE id_film = :id");
        $requete->execute(["id" => $id]);
        $film = $requete->fetch();
        
        $requeteCasting = $pdo->prepare("SELECT  personne.nom AS nom, personne.prenom AS prenom, personnage.nom_role AS nom_role
        FROM casting 
        INNER JOIN film ON casting.id_film = film.id_film
        INNER JOIN acteur ON casting.id_acteur = acteur.id_acteur
        INNER JOIN personnage ON casting.id_role = personnage.id_role
        INNER JOIN personne ON acteur.id_personne = personne.id_personne
        WHERE casting.id_film = :id");
        $requeteCasting->execute ([":id" => $id]);
        $castings = $requeteCasting -> fetchAll();
        require "view/detailFilm.php";
    }

    public function detailActeur($id){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("SELECT personne.prenom AS prenom, personne.nom AS nom, personne.sexe AS sexe, DATE_FORMAT(personne.date_naissance, '%d/%m/%Y') AS date_naissance
        FROM acteur
        INNER JOIN personne ON acteur.id_personne = personne.id_personne
        WHERE acteur.id_Acteur= :id");
        $requete->execute(["id" => $id]);
        $film = $requete-> fetch();

        $requeteRole = $pdo->prepare("SELECT personnage.nom_role AS nom_role, film.titre AS titre
        FROM casting 
        INNER JOIN film ON casting.id_film = film.id_film
        INNER JOIN acteur ON casting.id_acteur = acteur.id_acteur
        INNER JOIN personnage ON casting.id_role = personnage.id_role
        INNER JOIN personne ON acteur.id_personne = personne.id_personne
        WHERE acteur.id_acteur = :id");
        $requeteRole->execute ([":id" => $id]);
        $roles = $requeteRole -> fetchAll();
        require "view/detailActeur.php";
    }
}