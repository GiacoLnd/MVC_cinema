<?php

use Controller\FilmController;
use Controller\ActeurController;
use Controller\RealisateurController;
use Controller\GenreController;
use Controller\HomeController;
use Controller\DeleteController;

// initialisation automatique des classes
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

//instanciation du controller 

$ctrlFilm = new FilmController();
$ctrlActeur = new ActeurController();
$ctrlRealisateur = new RealisateurController();
$ctrlGenre = new GenreController();
$ctrlHome = new HomeController();


$id = (isset($_GET["id"])) ? $_GET["id"] : null;
$nom_genre = (isset($_POST["nom_genre"])) ? $_POST["nom_genre"] : null;


if(isset($_GET["action"])){
    switch ($_GET["action"]) {

        case "home": $ctrlHome->home(); break;
        case "listFilms": $ctrlFilm->listFilms(); break;
        case "detailFilm": $ctrlFilm->detailFilm($id); break;
        case "listActeurs": $ctrlActeur->listActeurs(); break;
        case "detailActeur": $ctrlActeur->detailActeur($id); break;
        case "listRealisateurs": $ctrlRealisateur->listRealisateurs(); break;
        case "detailRealisateur": $ctrlRealisateur->detailRealisateur($id); break;
        case "listGenres": $ctrlGenre->listGenres(); break;
        case "detailGenre": $ctrlGenre->detailGenre($id); break;
        case "addGenre": $ctrlGenre->addGenre($nom_genre); break;
        case "addFilm": $ctrlFilm->addFilm(); break;
        case "deleteGenre": $ctrlGenre->deleteGenre($id); break;
        case "editGenre": $ctrlGenre->editGenre($id); break;
    } 

}
