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

        // Préparer la requête SQL
        $requete = $pdo->prepare("
            SELECT 
                film.id_film AS id_film,
                film.titre AS titre,
                TIME_FORMAT(SEC_TO_TIME(film.duree * 60), '%H:%i') AS duree,
                DATE_FORMAT(film.date_sortie, '%Y') AS date_sortie,
                film.synopsis AS synopsis,
                genre.nom_genre AS nom_genre
            FROM 
                film
            INNER JOIN 
                genre_film ON film.id_film = genre_film.id_film
            INNER JOIN 
                genre ON genre_film.id_genre = genre.id_genre
            WHERE 
                film.id_film = :id
        ");
    
        // Exécution de la requête
        $requete->execute([":id" => $id]);
    
        // Récupérer le résultat
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

    public function addFilmForm(){
        require "view/addFilm.php";
    }
            

    private function sanitizeTitre($titre){
        $titre = trim($titre);
        $titre = ucfirst($titre);
        if (!empty($titre)) {
            return htmlspecialchars($titre, ENT_QUOTES, 'UTF-8');
        }
    }
    private function sanitreDateSortie($date_sortie){
        $date_sortie = trim($date_sortie);
        if (!empty($date_sortie)) {
            return htmlspecialchars($date_sortie, ENT_QUOTES, 'UTF-8');
        }
    }
    private function sanitizeDuree($duree){
        $duree = trim($duree);
        if (!empty($duree)) {
            return htmlspecialchars($duree, ENT_QUOTES, 'UTF-8');
        }
    }
    private function sanitizeSynopsis($synopsis){
        $synopsis = trim($synopsis);
        $synopsis = ucfirst($synopsis);
        if (!empty($synopsis)) {
            return htmlspecialchars($synopsis, ENT_QUOTES, 'UTF-8');
        }
    }
    public function recupererRealisateur(){
        $pdo = Connect::seConnecter();
        $requete = $pdo->query ("SELECT realisateur.id_realisateur, personne.nom, personne.prenom 
            FROM realisateur
            INNER JOIN personne ON realisateur.id_personne = personne.id_personne");
        $realisateurs = $requete->fetchAll();
        return $realisateurs;
    }
    public function insererFilm($titre, $date_sortie, $duree, $synopsis, $realisateur){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("INSERT INTO film (titre, date_sortie, duree, synopsis, id_realisateur) 
                                        VALUES (:titre, :date_sortie, :duree, :synopsis, :id_realisateur)");
        $requete->execute([":titre" => $titre, ":date_sortie" => $date_sortie, ":duree" => $duree, ":synopsis" => $synopsis, ":id_realisateur" => $realisateur]);
    }

    public function addFilm(){  
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $titre = $this->sanitizeTitre($_POST['titre']);
            $date_sortie = $this->sanitreDateSortie($_POST['date_sortie']);
            $duree = $this->sanitizeDuree($_POST['duree']);
            $realisateurs = $_POST['realisateurs'];
            $synopsis = $this->sanitizeSynopsis($_POST['synopsis']);

            if($titre && $date_sortie && $duree && $synopsis && $realisateurs){
                $this->insererFilm($titre, $date_sortie, $duree, $synopsis, $realisateurs);
                header('Location: index.php?action=listFilms');
                exit;
            } else {
                echo "Veuillez remplir tous les champs";
            }
        } else {
            $realisateurs = $this->recupererRealisateur();
            require "view/addFilm.php";
        }
    }       
    
}
    
    
