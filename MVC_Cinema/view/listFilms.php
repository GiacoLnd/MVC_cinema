<?php ob_start();?>

<p class="uk-label uk-label-warning"> Il y a <?= $requete->rowCount() ?> films</p>

<table class="uk-table uk-table-striped">
    <thead>
        <tr>
            <th>TITRE</th>
            <th>ANNEE SORTIE</th>
        </tr>
    </thead>
    <tbody>
        <?php

            foreach($requete->fetchAll() as $film) {?>
                <tr>
                    <td><?= $film["titre"] ?></td>
                    <td><?= $film['date_sortie'] ?></td>
                    <td><a href="index.php?action=detailFilm&id=<?= $film['id_film'] ?>">Voir les détails</a></td>
                    
                    
                </tr>    
        <?php } ?>
    </tbody>    
</table>

<a href="index.php?action=addFilm">Ajouter un film</a>

<?php

$titre = "Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require "view/template.php";?>