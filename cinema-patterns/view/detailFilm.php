<?php ob_start();?>

<p><strong>Titre :</strong> <?= $film['titre'] ?></p>
<p><strong>Durée :</strong> <?= $film['duree'] ?> minutes</p>
<p><strong>Date de sortie :</strong> <?= $film['date_sortie'] ?></p>
<p><strong>Synopsis :</strong> <?= htmlspecialchars($film['synopsis']) ?></p>
<?php

$titre = "Liste des films";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require "view/template.php";