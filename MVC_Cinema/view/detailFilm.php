<?php ob_start();?>

<p><strong>Titre :</strong> <?= $film['titre'] ?></p>
<p><strong>Durée :</strong> <?= $film['duree'] ?></p>
<p><strong>Année de sortie :</strong> <?= $film['date_sortie'] ?></p>
<p><strong>Synopsis :</strong> <?= $film['synopsis'] ?></p>
<table>
    <thead>
        <tr>
            <th>Genre associé : </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($genres as $genre) {?>
            <tr>
                <td><?= $genre['genre'] ?></td>
            </tr>
        <?php } ?>  
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>Acteurs</th>
            <th>Rôles</th>
        </tr>
    </thead>
    <tbody>
            <?php foreach($castings as $cast) {?>
            <tr>
                <td><?= $cast['prenom'] ." ". $cast['nom'] ?></td>
                <td><?= $cast['nom_role'] ?></td>
            </tr>
            <?php } ?>   
    </tbody>
</table>
<?php

$titre = "Détails du films";
$titre_secondaire = "Détails du films";
$contenu = ob_get_clean();
require "view/template.php";