<?php ob_start();?>

<table cellpadding="7">
    <thead>
        <tr>
            <th>Liste des genres</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $genre) {?>
                <tr>
                    <td><a href="index.php?action=detailGenre&id=<?= $genre['id_genre'] ?>"><?= $genre["nom_genre"] ?></a></td>
                </tr>    
        <?php } ?>
    </tbody>    
</table>

<a href="index.php?action=addGenre"><input type="submit" value="Ajouter un genre"></a>
<?php

$titre = "Liste des genres";
$titre_secondaire = "Liste des genres";
$contenu = ob_get_clean();
require "view/template.php";