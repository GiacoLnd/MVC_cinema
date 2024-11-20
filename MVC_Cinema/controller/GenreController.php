<?php

namespace Controller;
use Model\Connect;

class GenreController{

    // Liste les Genre
    public function listGenres(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query ("SELECT id_genre AS id_genre, nom_genre AS nom_genre 
        FROM genre");

        require "view/listGenres.php";
    }

    public function detailGenre($id){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare ("SELECT genre.nom_genre AS nom_genre
        FROM genre
        WHERE id_genre = :id");
        $requete->execute(["id" => $id]);
        $titreGenre = $requete->fetch();
        
        $requeteGenre = $pdo->prepare("SELECT film.titre AS titre, DATE_FORMAT(film.date_sortie, '%Y') AS date_sortie
        FROM genre_film
        INNER JOIN genre ON genre.id_genre = genre_film.id_genre
        INNER JOIN film ON film.id_film = genre_film.id_film
        WHERE genre_film.id_genre = :id");
        $requeteGenre->execute ([":id" => $id]);
        $genres = $requeteGenre -> fetchAll();
        
        require "view/detailGenre.php";
    }
}