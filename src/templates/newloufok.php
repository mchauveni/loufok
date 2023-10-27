<?php

// Récupère la loufokerie et formate les dates
$loufokerie = Loufokerie::getInstance()->getCurrent();

if ($loufokerie) {
    // Les dates de la loufokerie en cours
    $date_debut = date_format(date_create($loufokerie['date_debut_loufokerie']), 'd M Y');
    $date_fin = date_format(date_create($loufokerie['date_fin_loufokerie']), 'd M Y');

    // Récupère toutes les contributions de la loufokerie actuelle
    $contributions = Contribution::getInstance()->findBy(['id_loufokerie' => $loufokerie['id_loufokerie']]);

    // Récupère la contribution aléatoire du joueur
    $random_contribution = RandomContribution::getInstance()->findBy(['id_joueur' => $_COOKIE["id"], 'id_loufokerie' => $loufokerie["id_loufokerie"]]);
    $random_contribution = ($random_contribution != null) ? Contribution::getInstance()->findBy(["id_contribution" => $random_contribution[0]['id_contribution']])[0] : $random_contribution;

    // Récupère la contribution du joueur, si elle existe
    $user_contribution = Contribution::getInstance()->findBy(["id_loufokerie" => $loufokerie["id_loufokerie"], "id_joueur" => $_COOKIE["id"]]);
    $user_contribution = (count($user_contribution) > 0) ? $user_contribution[0] : null;
}

function txtContribSingularPlural($nb) {
    if ($nb <= 0) {
        $txt = null;
    } else if ($nb == 1) {
        $txt = "<p class='hidden_contribution'><span class='hidden_contribution__text'>$nb contribution masquée</span></p>";
    } else {
        $txt = "<p class='hidden_contribution'><span class='hidden_contribution__text'>$nb contributions masquées</span></p>";
    }
    return $txt;
}
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
    <link rel="icon" href="./assets/images/favicon.ico">
    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/admin.css">
    <!-- JS -->
    <script src="/assets/scripts/contribution_textarea_handler.js"></script>
</head>

<body>
    <header class="header">
        <div class="header__icons">
            <img class="header__icon header__icon--loufok" src="./assets/images/loufok.svg" alt="">
            <a class="header__logout" href="./logout" aria-label="se déconnecter"><img class="header__icon" src="./assets/images/logout.svg" alt=""></a>
        </div>
        <h1 class="header__greetings">Bienvenue <span class="header__username">Admin</span>,</h1>
        <hr class="separator">
        </hr>
    </header>

    <form action="">
        <div>
            <input type="datetime" name="" id="">
            <input type="datetime" name="" id="">
        </div>
        <div>
            <input type="text" name="" id="">
        </div>
    </form>
</body>

</html>
<?php
