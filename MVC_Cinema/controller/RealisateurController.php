<?php

namespace Controller;
use Model\Connect;

class RealisateurController{

    // Liste les Réalisateurs
    public function listRealisateurs(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query ("SELECT realisateur.id_realisateur AS id_realisateur, personne.nom, personne.prenom, personne.sexe, DATE_FORMAT(personne.date_naissance, '%d/%m/%Y') AS date_naissance 
        FROM realisateur 
        INNER JOIN personne ON realisateur.id_personne = personne.id_personne 
        WHERE personne.id_personne IN (SELECT id_personne FROM realisateur)");

        require "view/listRealisateurs.php";
    }

    // Affiche les détails du realisateur voulu et sa filmographie
    public function detailRealisateur($id){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("SELECT personne.prenom AS prenom, personne.nom AS nom, personne.sexe AS sexe, DATE_FORMAT(personne.date_naissance, '%d/%m/%Y') AS date_naissance
            FROM realisateur
            INNER JOIN personne ON realisateur.id_personne = personne.id_personne
            WHERE realisateur.id_realisateur= :id");
        $requete->execute(["id" => $id]);
        $film = $requete-> fetch();

        $requeteFilm = $pdo->prepare("SELECT film.titre AS titre
            FROM film 
            INNER JOIN realisateur ON film.id_realisateur = realisateur.id_realisateur
            WHERE realisateur.id_realisateur = :id");
        $requeteFilm->execute ([":id" => $id]);
        $realisations= $requeteFilm -> fetchAll();

        require "view/detailRealisateur.php";
    }

}