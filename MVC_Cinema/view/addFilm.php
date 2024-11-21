<?php ob_start();?>
<h3>Ajouter un film</h3>

<form class="film-form" action="index.php?action=addFilm" method="POST">
    <div id="film-form-container">
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
                Son synopsis : 
                <textarea id="synopsis" name="synopsis" rows="5" cols="50" placeholder="Ecrivez le synopsis ici ..." ></textarea>
            </label>
        </p>
        <p>
            <label for="realisateurs">Choisissez son réalisateur :</label>
                <select name="realisateurs" id="realisateurs" required>
                    <option value="" disabled selected>Sélectionnez un réalisateur</option>
                    <?php foreach ($realisateurs as $realisateur): ?>  <!-- récupères les réalisateurs en DB pour les insérer dans une liste déroulante -->
                        <option value="<?= htmlspecialchars($realisateur['id_realisateur']) ?>">
                            <?= htmlspecialchars($realisateur['prenom']) ?>
                            <?= htmlspecialchars($realisateur['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
    </p>
    <p>
    <h3>Genres :</h3>
    <?php foreach ($genres as $genre): ?> <!-- récupères les genres en DB pour les insérer dans des checkboxs -->
        <div>
            <input 
                type="checkbox" 
                id="genre_<?= $genre['id_genre']; ?>" 
                name="genres[]" 
                value="<?= $genre['id_genre']; ?>"
            >
            <label for="genre_<?= $genre['id_genre']; ?>">
                <?= htmlspecialchars($genre['nom_genre'], ENT_QUOTES, 'UTF-8'); ?>
            </label>
        </div>
    <?php endforeach; ?>
    </p>
        <button type="submit">Ajouter le film</button>
        
</form>

<a href="index.php?action=listGenres">Retour à la liste des films</a>

<?php

$titre = "Ajoutez un films";
$titre_secondaire = "Ajoutez un films";
$contenu = ob_get_clean();
require "view/template.php";