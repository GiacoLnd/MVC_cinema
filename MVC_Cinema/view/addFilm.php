<?php ob_start();?>

<h3>Ajouter un film</h3>

<form action="index.php?action=addFilm" method="POST">
<p>    
    <label for="titre">
        Titre du film : 
        <input type="text" id="titre" name="titre">
    </label>
</p>    
<p>
    <label for="date_sortie">
        Année de sa sortie :
        <input type="date" id="date_sortie" name="date_sortie" value="01/01/2024">
    </label>
</p>
<p>
    <label for="duree">
        Duree en minutes: 
        <input type="text" id="duree" name="duree">
    </label>
</p>
<p>
    <label for="synopsis">
        Sonsynopsis : 
        <textarea id="synopsis" name="synopsis" rows="5" cols="50" placeholder="Ecrivez le synopsis ici ..." ></textarea>
    </label>
</p>
<p>
    <label for="realisateurs">Choisissez son réalisateur :</label>
        <select name="realisateurs" id="realisateurs" required>
            <option value="" disabled selected>Sélectionnez un réalisateur</option>
            <?php foreach ($realisateurs as $realisateur): ?>
                <option value="<?= htmlspecialchars($realisateur['id_realisateur']) ?>">
                    <?= htmlspecialchars($realisateur['prenom']) ?>
                    <?= htmlspecialchars($realisateur['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
</p>
    <button type="submit">Ajouter le film</button>
    
</form>

<a href="index.php?action=listGenres">Retour à la liste des films</a>

<?php

$titre = "Ajoutez un films";
$titre_secondaire = "Ajoutez un films";
$contenu = ob_get_clean();
require "view/template.php";