<?php ob_start();?>

<p><strong>Titre :</strong> <?= $film['titre'] ?></p>
<p><strong>Durée :</strong> <?= $film['duree'] ?></p>
<p><strong>Année de sortie :</strong> <?= $film['date_sortie'] ?></p>
<p><strong>Synopsis :</strong> <?= $film['synopsis'] ?></p>
<h3>Casting :</h3>
<table>
    <thead>
        <tr>
            <th>Acteurs</th>
            <th>Rôles</th>
        </tr>
    </thead>
    <tbody>
            <?php $castings = $requete->fetchAll();
            foreach($castings as $casting) {?>
            <tr>
                <td><?= $casting['prenom'] ." ". $casting['nom'] ?></td>
                <td><?= $casting['nom_role'] ?></td>
            </tr>
            <?php } ?>   
    </tbody>
</table>
<?php

$titre = "Détail du films";
$titre_secondaire = "Détail du films";
$contenu = ob_get_clean();
require "view/template.php";