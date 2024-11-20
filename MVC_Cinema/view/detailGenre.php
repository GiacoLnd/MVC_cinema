<?php ob_start();?>

<h3>Liste des films du genre :</h3>

<table>
    <thead>
        <tr>
            <th colspan="2"><?= $titreGenre['nom_genre']?></th>
        </tr>
    </thead>
    <tbody>
            <?php foreach($genres as $genre) {?>
            <tr>
                <td><?= $genre['titre']?></td>
                <td><?= $genre['date_sortie'] ?></td>
            </tr>
            <?php } ?>   
    </tbody>
</table>
<?php

$titre = "Détails du genre";
$titre_secondaire = "Détails du genre";
$contenu = ob_get_clean();
require "view/template.php";