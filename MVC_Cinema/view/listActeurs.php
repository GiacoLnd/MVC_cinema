<?php ob_start();?>

<table class="uk-table uk-table-striped" cellpadding="7">
    <thead>
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Sexe</th>
            <th>Date de naissance</th>
            <th>Détails</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $film) {?>
                <tr>
                    <td><?= $film["prenom"] ?></td>
                    <td><?= $film["nom"] ?></td>
                    <td><?= $film["sexe"] ?></td>
                    <td><?= $film["date_naissance"] ?></td>
                    <td><a href="index.php?action=detailActeur&id=<?= $film['id_acteur'] ?>">Voir les détails</a></td>
                </tr>    
        <?php } ?>
    </tbody>    
</table>

<?php

$titre = "Liste des Acteurs";
$titre_secondaire = "Liste des acteurs";
$contenu = ob_get_clean();
require "view/template.php";