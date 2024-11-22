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
        $requete = $pdo->prepare ("SELECT genre.id_genre AS id_genre, genre.nom_genre AS nom_genre
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
    
    public function deleteGenre($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            if ($id) {
                    $pdo = Connect::seConnecter();
                    //Arrête la transmission automatique des requêtes et initie la transaction
                    $pdo->beginTransaction();

                    // Préparer la suppression des liaisons de films avec le genre supprimé
                    $requeteGenreFilm = $pdo->prepare("DELETE FROM genre_film WHERE id_genre = :id");
                    $requeteGenreFilm->execute(["id" => $id]);

                    // Préparer la suppression du genre
                    $requeteGenre = $pdo->prepare("DELETE FROM genre WHERE id_genre = :id");
                    $requeteGenre->execute(["id" => $id]);

                    // Valide la transaction et enclenche les requêtes précédentes 
                    $pdo->commit();
                    echo "Le genre a bien été supprimé.";
                } 
            }
            header("Location: index.php?action=listGenres");
            exit;
        }

        // fonction qui permet la modification d'un genre
        public function editGenre($id) {
            $pdo = Connect::seConnecter();
        
            // Récupérer les informations du genre
            $requete = "SELECT id_genre, nom_genre FROM genre WHERE id_genre = :id";
            $requeteSelect = $pdo->prepare($requete);
            $requeteSelect->bindParam(":id", $id); // relie le paramètre de la requête au paramètre $id
            $requeteSelect->execute();
            $resultatSelect = $requeteSelect->fetch();
        
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id_genre = filter_input(INPUT_POST, 'id_genre', FILTER_VALIDATE_INT);
                $nom_genre = trim($_POST['nom_genre'] ?? '');
        
                // S'il y a un ID + que le nom_genre n'est pas vide
                if ($id_genre && !empty($nom_genre)) {
                    $requetes = "UPDATE genre SET nom_genre = :nom_genre WHERE id_genre = :id";
                    $requeteUpdate = $pdo->prepare($requetes);
                    $requeteUpdate->execute([    // execute la requête de mise à jour en fonction de chacun des paramètres
                        ':id' => $id_genre,
                        ':nom_genre' => $nom_genre
                    ]);

                    header("Location: index.php?action=listGenres");
                    exit;
                } 
            }
            require "view/editGenre.php";
        }
    }
