<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css" integrity="sha512-6p+GTq7fjTHD/sdFPWHaFoALKeWOU9f9MPBoPnvJEWBkGS4PKVVbCpMps6IXnTiXghFbxlgDE8QRHc3MU91lJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.min.css" integrity="sha512-T7lIYojLrqj7eBrV1NvUSZplDBi8mFyIEGFGdox8Bic92Col3GVrscbJkL37AJoDmF2iAh81fRpO4XZukI6kbA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Average+Sans&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
        <link href="public/css/style.css" rel="stylesheet" />
        <title><?= $titre ?></title> <!-- récupère la variable $titre contenu dans chaque fichier view à chaque fois que le template est appelé -->
    </head>
    <body>
        <a href="index.php?action=home"><img src="public/img/Logo_site.png" alt="PopcornTime"></a>
    <nav>
            <ul>
                <li><a href="index.php?action=listFilms">Films</a></li>
                <li><a href="index.php?action=listActeurs">Acteurs</a></li>
                <li><a href="index.php?action=listRealisateurs">Réalisateurs</a></li>
                <li><a href="index.php?action=listGenres">Genres</a></li>
            </ul>
        </nav>
    <div id="wrapper" class="uk-container uk-container-expand">
        <main>
            <div id="contenu">
                <div id="title-container">
                    <h1 class="uk-heading-divider">PopcornTime</h1>
                    <p class="subtitle">Movie, Popcorn & Chill</p>
                </div>
                <h2 class="uk-heading-bullet"><?= $titre_secondaire ?></h2> <!-- récupère la variable $titre_secondaire contenu dans chaque fichier view à chaque fois que le template est appelé -->
                <?= $contenu ?> <!-- récupère le contenu de la page voulue -->
            </div>
        </main>
    </div>
        <footer>
            <button onclick="hautDePage()" id="topBtn" title="Haut de page">Haut de page <i class="ri-arrow-up-line"></i></button>
            <div id="container-footer">
                <p>Rejoignez-nous sur les réseaux :</p>
                <i class="ri-facebook-fill" id="facebook"></i>
                <i class="ri-twitter-x-line" id="twitter"></i>
                <i class="ri-instagram-fill" id="instagram"></i>
            </div>
        </footer>
        <script src="public/js/script.js"></script>
    </body>
</html>