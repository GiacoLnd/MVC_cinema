<?php ob_start();?>

<p><strong>Nom complet : </strong> <?= $film['prenom'] . " " . $film['nom'] ?></p>
<p><strong>Genre : </strong> <?= $film['sexe'] ?></p>
<p><strong>Date de naissance : </strong> <?= $film['date_naissance'] ?></p>

<table border="1" >
    <thead>
        <tr>
            <th>Personnage(s) incarné(s)</th>
        </tr>
    </thead>
    <tbody>
            <?php // affiche les différents films réalisés, sinon prévient qu'aucun film n'est renseigné//
            if(empty($realisations)) { ?>
                <tr>
                    <td>Aucun film renseigné</td>
                </tr> 
            <?php } else { 
                foreach($realisations as $realisation) {?>
                <tr>
                    <td><?= $realisation['titre'] ?></td>
                </tr>
                <?php }} ?>   
    </tbody>
</table>

<?php

$titre = "Détails du réalisateur";
$titre_secondaire = "Détails du réalisateur";
$contenu = ob_get_clean();
require "view/template.php";