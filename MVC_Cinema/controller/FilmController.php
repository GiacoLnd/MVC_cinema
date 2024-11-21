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
        $requete = $pdo->prepare ("SELECT film.id_film, film.titre AS titre, TIME_FORMAT(SEC_TO_TIME(film.duree * 60), '%H:%i') AS duree, DATE_FORMAT(film.date_sortie, '%Y') AS date_sortie, film.synopsis AS synopsis
            FROM film
            WHERE film.id_film = :id");
        $requete->execute([":id" => $id]);
        $film = $requete->fetch();

        $requeteGenre = $pdo->prepare("SELECT film.id_film,genre.nom_genre AS genre 
            FROM genre_film
            INNER JOIN genre ON genre_film.id_genre = genre.id_genre
            INNER JOIN film ON genre_film.id_film = film.id_film
            WHERE film.id_film = :id");
        $requeteGenre->execute([":id" => $id]);
        $genres = $requeteGenre -> fetchAll();

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

    // affiche le formulaire d'ajout de film
    public function addFilmForm(){
        require "view/addFilm.php";
    }
            
    // Fonction qui sanitise le titre entré dans le formulaire d'ajout de film
    private function sanitizeTitre($titre){
        $titre = trim($titre);
        $titre = ucfirst($titre);
        if (!empty($titre)) {
            return htmlspecialchars($titre, ENT_QUOTES, 'UTF-8');
        }
    }


    // Fonction qui sanitise la durée entrée dans le formulaire d'ajout de film
    private function sanitizeDuree($duree){
        $duree = trim($duree);
        if (!empty($duree)) {
            return htmlspecialchars($duree, ENT_QUOTES, 'UTF-8');
        }
    }

    // Fonction qui sanitise le synopsis entré dans le formulaire d'ajout de film
    private function sanitizeSynopsis($synopsis){
        $synopsis = trim($synopsis);
        $synopsis = ucfirst($synopsis);
        if (!empty($synopsis)) {
            return htmlspecialchars($synopsis, ENT_QUOTES, 'UTF-8');
        }
    }

    //fonction qui permet de lister les réalisateurs dans le formulaire d'ajout de film
    public function recupererRealisateur(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query ("SELECT realisateur.id_realisateur, personne.nom, personne.prenom 
            FROM realisateur
            INNER JOIN personne ON realisateur.id_personne = personne.id_personne");
        $realisateurs = $requete->fetchAll();
        return $realisateurs;
    }

    //fonction qui permet de lister les genres dans le formulaire d'ajout de film
    public function recupererGenres(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query ("SELECT id_genre, nom_genre FROM genre");
        $genres = $requete->fetchAll();
        return $genres;
    }

    // fonction qui permet l'ajout d'un film et de ses détails dans la liste de films et retourne son id
    public function insererFilm($titre, $date_sortie, $duree, $synopsis, $realisateur){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
        INSERT INTO film (titre, date_sortie, duree, synopsis, id_realisateur) 
        VALUES (:titre, :date_sortie, :duree, :synopsis, :id_realisateur)");
        $requete->execute([":titre" => $titre, ":date_sortie" => $date_sortie, ":duree" => $duree, ":synopsis" => $synopsis, ":id_realisateur" => $realisateur]);
        return $pdo -> lastInsertId();
        }
    
    //fonction qui permet la liaison d'un film avec un ou plusieurs genres
        public function insererGenre($id_film, $id_genre){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
        INSERT INTO genre_film (id_film, id_genre) 
        VALUES (:id_film, :id_genre)");
        $requete->execute([":id_film" => $id_film, ":id_genre" => $id_genre]);
    }

    //fonction qui récupère l'ensemble des fonctions du formulaire pour afficher la page addGenre et permet les fonctionnalités du formulaire
    public function addFilm(){  
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $titre = $this->sanitizeTitre($_POST['titre']);
            $date_sortie = $_POST['date_sortie'];
            $duree = $this->sanitizeDuree($_POST['duree']);
            $realisateurs = $_POST['realisateurs'];
            $synopsis = $this->sanitizeSynopsis($_POST['synopsis']);
            $genres = $_POST['genres'];

            if($titre && $date_sortie && $duree && $synopsis && !empty($realisateurs) && !empty($genres)){
                $film = $this->insererFilm($titre, $date_sortie, $duree, $synopsis, $realisateurs);

                foreach($genres as $genre){
                    $this->insererGenre($film, $genre);
                }

                header('Location: index.php?action=listFilms');
                exit;
            } else {
                echo "Veuillez remplir tous les champs";
            }
        } else {
            $realisateurs = $this->recupererRealisateur();
            $genres = $this->recupererGenres();
            require "view/addFilm.php";
        
    }       
    

}}
    
    
