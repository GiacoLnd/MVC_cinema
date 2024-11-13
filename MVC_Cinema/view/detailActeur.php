<?php ob_start();?>

<p><strong>Nom complet : </strong> <?= $film['prenom'] . " " . $film['nom'] ?></p>
<p><strong>Genre : </strong> <?= $film['sexe'] ?></p>
<p><strong>Date de naissance : </strong> <?= $film['date_naissance'] ?></p>

<table border="1" >
    <thead>
        <tr>
            <th>Personnage(s) incarné(s)</th>
            <th>Film(s)</th>
        </tr>
    </thead>
    <tbody>
            <?php if(empty($roles)) { ?>
                <tr>
                    <td  colspan="2">Aucun film renseigné</td>
                </tr> 
            <?php } else { 
                foreach($roles as $role) {?>
                <tr>
                    <td><?= $role['nom_role']?></td>
                    <td><?= $role['titre'] ?></td>
                </tr>
                <?php }} ?>   
    </tbody>
</table>

<?php

$titre = "Détails de l'acteur";
$titre_secondaire = "Détails de l'acteur";
$contenu = ob_get_clean();
require "view/template.php";