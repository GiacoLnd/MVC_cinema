<?php

namespace Controller;
use Model\Connect;

class FilmController {
    // lister les films //
    public function listFilms(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query ("SELECT titre, DATE_FORMAT(date_sortie, '%Y') AS date_sortie, id_film FROM film");

        require "view/listFilms.php";
    }

    //afficher les détails du film voulu
    public function detailFilm($id){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare ("SELECT titre, TIME_FORMAT(SEC_TO_TIME(duree * 60), '%H:%i') AS duree, DATE_FORMAT(date_sortie, '%Y') AS date_sortie, synopsis 
            FROM film 
            WHERE id_film = :id");
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

}