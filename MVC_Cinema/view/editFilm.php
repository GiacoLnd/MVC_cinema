<?php ob_start();?>
<h3><?php echo $resultatSelect['titre']; ?></h3>

<form method="POST">
    <input type="hidden" name="id_film" value="<?php echo $resultatSelect['id_film']; ?>">
    <label for="titre">Titre du film :</label>
    <input type="text" name="titre" id="titre" value="<?php echo $resultatSelect['titre']; ?>" required>
    <label for="date_sortie">Date de sortie du film :</label>
    <input type="date" name="date_sortie" id="date_sortie" value="<?php echo $resultatSelect['date_sortie']; ?>" required>
    <label for="duree">Durée du film :</label>
    <input type="text" name="duree" id="duree" value="<?php echo $resultatSelect['duree']; ?>" required>
    <label for="synopsis">Synopsis du film :</label>
    <textarea name="synopsis" id="synopsis" rows="5" cols="50" required><?php echo $resultatSelect['synopsis']; ?></textarea>
    <label for="realisateurs">Realisateurs du film :</label>
    <select name="realisateurs" id="realisateurs" required>
        <?php foreach ($realisateurs as $realisateur) {
            echo '<option value="' . $realisateur['id_personne'] . '">' . $realisateur['nom'] . ' ' . $realisateur['prenom'] . '</option>';
        } ?>
    </select>
<h3>Genres :</h3>
<form method="POST" action="index.php?action=editGenres">
    <?php foreach ($genres as $genre): ?> <!-- Parcourt les genres récupérés de la base de données -->
        <div>
            <input 
                type="checkbox" 
                id="genre_<?= htmlspecialchars($genre['id_genre'], ENT_QUOTES, 'UTF-8'); ?>" 
                name="genres[]" 
                value="<?= htmlspecialchars($genre['id_genre'], ENT_QUOTES, 'UTF-8'); ?>"
            >
            <label for="genre_<?= htmlspecialchars($genre['id_genre'], ENT_QUOTES, 'UTF-8'); ?>">
                <?= htmlspecialchars($genre['nom_genre'], ENT_QUOTES, 'UTF-8'); ?>
            </label>
        </div>
    <?php endforeach; ?>
    <button type="submit">Modifier</button>
</form>


<?php
$titre = "Edition";
$titre_secondaire = "Edition";
$contenu = ob_get_clean();
require "view/template.php";