<?php

// Récupère la loufokerie et formate les dates
$loufokerie = Loufokerie::getInstance()->getCurrent();

if ($loufokerie) {
    // Les dates de la loufokerie en cours
    $date_debut = date_format(date_create($loufokerie['date_debut_loufokerie']), 'd M Y');
    $date_fin = date_format(date_create($loufokerie['date_fin_loufokerie']), 'd M Y');

    // Récupère toutes les contributions de la loufokerie actuelle
    $contributions = Contribution::getInstance()->findBy(['id_loufokerie' => $loufokerie['id_loufokerie']]);
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
    <link rel="stylesheet" href="./assets/css/header.css">
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
        <hr class="header__separator">
        </hr>
    </header>
    <div>
        <?php
        if (!$loufokerie) {
        ?>
            <div class="no_loufokerie">
                <p class="no_loufokerie__text">Il n'y a pas de Loufokerie en cours..</p>
                <a class="no_loufokerie__button" href="./admin/nouvelleloufokerie">Nouvelle Loufokerie</a>
            </div>
        <?php
        } else {
        ?>
            <div class="loufokerie">
                <h2 class="loufokerie__title"><?php echo $loufokerie["titre_loufokerie"] ? $loufokerie['titre_loufokerie'] : "Loufokerie en cours"  ?></h2>
                <div class="loufokerie__options">
                    <a class="loufokerie__edit" href="">Modifier</a>
                    <a class="loufokerie__end" href="./admin/endloufok">Terminer</a>
                </div>
                <div class="loufokerie__header">
                    <p class="loufokerie__dates"><?php echo $date_debut . " - " . $date_fin ?></p>
                    <div class="loufokerie__nbcontrib">
                        <span><?php echo count($contributions); ?></span>
                        <img src="./assets/images/contributions.svg" alt="contributions">
                    </div>
                </div>
                <?php
                foreach ($contributions as $contribution) {
                    $contributeur = ($contribution['id_joueur']) ? User::getInstance()->findBy(["id_joueur" => $contribution['id_joueur']])[0] : null;
                ?>
                    <div class="loufokerie__contribution">
                        <span class="loufokerie__user"><?php echo $contributeur ? $contributeur['nom_plume'] . " - " . $contributeur['ad_mail_joueur'] : "Admin" ?></span>
                        <p><?php echo $contribution['texte_contribution'] ?></p>
                    </div>
                <?php
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
