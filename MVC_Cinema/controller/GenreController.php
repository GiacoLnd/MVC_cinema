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
    // Vérifie si le nom du genre entré est déjà renseigné dans la base de donnée 
    public function searchGenre($nom_genre){
        $pdo = Connect::seConnecter();
        $requeteSearchGenre = $pdo->prepare("SELECT nom_genre AS nom_genre
        FROM genre
        WHERE genre.nom_genre = :nom_genre");
        $requeteSearchGenre->execute ([":nom_genre" => $nom_genre]);
        return $requeteSearchGenre -> fetchColumn() > 0;
    }

    // Fonction qui ajoute le genre dans la base de donnée et redirige vers la liste de genres
    public function insererGenre($nom_genre){
        $pdo = Connect::seConnecter();
        $request = $pdo->prepare("INSERT INTO genre (nom_genre) VALUES (:nom_genre)");
        $request->execute([":nom_genre" => $nom_genre]);
        header('Location: index.php?action=listGenres');
        exit;
    }
    // fonction qui 
    public function addForm(){
        
    }

    // fonction qui enlève d'abord tout caractère et espace de l'entrée, puis vérifie si l'entrée existe déjà et enfin ajoute le genre, sinon, met un message d'erreur 
    public function addGenre($nom_genre): void{
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $entreeGenre = htmlspecialchars(trim($_POST["nom_genre"]), ENT_QUOTES, 'UTF-8'); // protège des failles XSS en modifiant les caractères entrés en caractères HTML et en supprimant les guillemets

            if (!empty($entreeGenre)) { // utilise la fonction de vérification du genre si le champs de texte n'est pas vide
                $existe = $this -> searchGenre($entreeGenre);
                // si le champs existe déjà mets un lien cliquable vers listeGenres et précisant que la donnée existe en DB
                if($existe){
                    echo "<br><a href='index.php?action=listGenres'>Le genre est déjà renseigné. Retour à la liste des genres !</a>";

                }
                else{ // sinon crée le nouveau genre donné avec la fonction précédente insererGenre + (entrée du champs de texte sécurisée des XSS)
                    if ($this -> insererGenre($entreeGenre)) {
                    }
                }
            } else { // si le champs est vide au moment du clic sur le bouton valider, reste sur la page du formulaire
                        header('Location: index.php?action=addGenre');
        } 
        }else {
            require "view/addGenre.php"; // précise que la fonction a besoin de la page addGenre.php
        }
    }
        
} 

