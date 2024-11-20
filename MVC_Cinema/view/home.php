<?php ob_start();?>
<div id="home-container">
    <h3>En manque d'idée ?</h3>
    <div class="square-suggestions">
            <p>Suggestions :</p>
            <i class="ri-arrow-left-line" id="left-one"></i>
            <i class="ri-arrow-right-line" id="right-one"></i>
    </div>
    <div class="square-rated">
        <p>Les mieux notés :</p>
        <i class="ri-arrow-left-line" id="left-two"></i>
        <i class="ri-arrow-right-line" id="right-two"></i>
    </div>
</div>
<?php

$titre = "PopcornTime - Home";
$titre_secondaire = "Accueil";
$contenu = ob_get_clean();
require "view/template.php";?>



