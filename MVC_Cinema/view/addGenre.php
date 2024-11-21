<?php ob_start();?>

<h3>Ajouter un genre</h3>

<form action="index.php?action=addGenre" method="POST">
    <label for="nom_genre">Nom du genre : </label>
    <input type="text" id="nom_genre" name="nom_genre">
    <button type="submit">Ajouter le genre</button>
</form>

<a href="index.php?action=listGenres">Retour à la liste des genres</a>

<?php

$titre = "Ajoutez un film";
$titre_secondaire = "Ajoutez un film";
$contenu = ob_get_clean();
require "view/template.php";