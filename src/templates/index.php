<?php
if (!$_COOKIE['is_logged_in']) {
    HTTP::redirect('/login');
}

$loufokerie = Loufokerie::getInstance()->getCurrent();

$date_debut = date_format(date_create($loufokerie['date_debut_loufokerie']), 'd M Y');
$date_fin = date_format(date_create($loufokerie['date_fin_loufokerie']), 'd M Y');
$today = date('Y-m-d');

$contributions = Contribution::getInstance()->findBy(['id_loufokerie' => $loufokerie['id_loufokerie']]);

$random_contribution = RandomContribution::getInstance()->findBy([
    'id_joueur' => $_COOKIE["id"],
    'id_loufokerie' => $loufokerie["id_loufokerie"]
])[0];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title -->
    <title>Loufok</title>
    <!-- Meta Tags -->
    <meta name="robots" content="noindex, nofollow">
    <!-- Favicon -->
    <link rel="icon" href="./favicon.ico">
    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/index.css">
</head>

<body>
    <header class="header">
        <div class="header__icons">
            <img class="header__icon header__icon--loufok" src="/assets/images/loufok.svg" alt="">
            <a class="header__logout" href="/logout"><img class="header__icon" src="/assets/images/logout.svg" alt=""></a>
        </div>
        <h1 class="header__greetings">Bienvenue <span class="header__username"><?php echo $_COOKIE["username"] ?></span>,</h1>
    </header>
    <hr class="separator">
    </hr>
    <div>
        <?php
        if (!$loufokerie) {
            echo "Il n'y a pas de Loufokerie en cours..";
        } else {
        ?>
            <div class="loufokerie">
                <h2 class="loufokerie__title"><?php echo $loufokerie["titre_loufokerie"] ? $loufokerie['titre_loufokerie'] : "Loufokerie en cours"  ?></h2>
                <div class="loufokerie__header">
                    <p class="loufokerie__dates"><?php echo $date_debut . " - " . $date_fin ?></p>
                    <div class="loufokerie__nbcontrib">
                        <span><?php echo Contribution::getInstance()->countBy($loufokerie["id_loufokerie"]); ?></span>
                        <img src="/assets/images/contributions.svg" alt="contributions">
                    </div>
                </div>
                <?php
                // Si le joueur n'a pas de contribution aléatoire attribuée
                if (!$random_contribution) {
                ?>
                    <div class="joinLoufokerie">
                        <p class="joinLoufokerie__text">Vous n'avez pas encore de contribution attribuée</p>
                        <a href="/assignRandomContrib" class="joinLoufokerie__button">Rejoindre la loufokerie</a>
                    </div>
                <?php
                    // Sinon s'il a déjà une contribution aléatoire attribuée, rejoins la contribution
                } else {
                    foreach ($contributions as $contribution) {
                        if ($contribution["id_contribution"] === $random_contribution["id_contribution"]) {
                            echo "<p>{$contribution['texte_contribution']}</p>";
                        } else {
                            echo "<hr class='separator'></hr>";
                        }
                    }
                }
                ?>
            </div>
        <?php
        }
        ?>
    </div>
</body>

</html>
<?php
