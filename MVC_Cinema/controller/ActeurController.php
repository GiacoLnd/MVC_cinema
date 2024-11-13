<?php

namespace Controller;
use Model\Connect;

class ActeurController{

    // Liste les acteurs
    public function listActeurs(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query ("SELECT acteur.id_acteur AS id_acteur, personne.nom, personne.prenom, personne.sexe, DATE_FORMAT(personne.date_naissance, '%d/%m/%Y') AS date_naissance 
        FROM acteur 
        INNER JOIN personne ON acteur.id_personne = personne.id_personne 
        WHERE personne.id_personne IN (SELECT id_personne FROM acteur)");

        require "view/listActeurs.php";
    }

    // affiche les détails de l'acteur en fonction de l'id_acteur
    public function detailActeur($id){
    //affiche recherche et affiche les infos personnelles de l'acteur//
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("SELECT personne.prenom AS prenom, personne.nom AS nom, personne.sexe AS sexe, DATE_FORMAT(personne.date_naissance, '%d/%m/%Y') AS date_naissance
            FROM acteur
            INNER JOIN personne ON acteur.id_personne = personne.id_personne
            WHERE acteur.id_Acteur= :id");
        $requete->execute(["id" => $id]);
        $film = $requete-> fetch();
 
         // recherche et affiche les roles incarnés par l'acteur et le titre du film dans lequel il a joué//
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