<?php ob_start();?>
<h3><?php echo $resultatSelect['nom_genre'] ?></h3>

<form method="POST">
    <input type="hidden" name="id_genre" value="<?php echo $resultatSelect['id_genre']; ?>">
    <label for="nom_genre">Nom du genre :</label>
    <input type="text" name="nom_genre" id="nom_genre" value="<?php $resultatSelect['nom_genre']; ?>" required>
    <button type="submit">Modifier</button>
</form>


<?php
$titre = "Editez un genre";
$titre_secondaire = "Editez un genre";
$contenu = ob_get_clean();
require "view/template.php";

