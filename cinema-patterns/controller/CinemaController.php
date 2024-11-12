<?php

namespace Controller;

use Model\Connect;

class CinemaController{

    //lister les films
    public function listFilms(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query ("SELECT titre, date_sortie FROM film");

        require "view/listFilms.php";
    }
    public function listActeurs(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query ("SELECT personne.nom, personne.prenom, personne.sexe, personne.date_naissance FROM acteur INNER JOIN personne ON acteur.id_personne = personne.id_personne WHERE personne.id_personne IN (SELECT id_personne FROM acteur)");

        require "view/listActeurs.php";
    }
    
    public function detailFilm($id){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare ("SELECT titre, duree, date_sortie, synopsis FROM film WHERE id_film = :id");
        $requete->execute(["id" => $id]);
        $film = $requete->fetch();
        require "view/acteur/detailFilm.php";
    }
}

?>