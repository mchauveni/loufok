<?php
if (!$_COOKIE['is_logged_in']) {
    HTTP::redirect('/login');
}

// Récupère la loufokerie et formate les dates
$loufokerie = Loufokerie::getInstance()->getCurrent();
$date_debut = date_format(date_create($loufokerie['date_debut_loufokerie']), 'd M Y');
$date_fin = date_format(date_create($loufokerie['date_fin_loufokerie']), 'd M Y');

// Récupère toutes les contributions de la loufokerie actuelle
$contributions = Contribution::getInstance()->findBy(['id_loufokerie' => $loufokerie['id_loufokerie']]);

// Récupère la contribution aléatoire du joueur
$random_contribution = RandomContribution::getInstance()->findBy(['id_joueur' => $_COOKIE["id"], 'id_loufokerie' => $loufokerie["id_loufokerie"]])[0];
$random_contribution = ($random_contribution != null) ? Contribution::getInstance()->findBy(["id_contribution" => $random_contribution['id_contribution']])[0] : $random_contribution;

// Récupère la contribution du joueur, si elle existe
$user_contribution = Contribution::getInstance()->findBy(["id_loufokerie" => $loufokerie["id_loufokerie"], "id_joueur" => $_COOKIE["id"]]);
$user_contribution = (count($user_contribution) > 0) ? $user_contribution[0] : null;
var_dump($user_contribution == null);

function txtContribSingularPlural($nb) {
    switch ($nb) {
        case 0:
            $txt = null;
            break;
        case 1:
            $txt = `<p>$nb contribution masquée</p>`;
            break;
        default:
            $txt = `<p>$nb contributions masquées</p>`;
            break;
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
    <link rel="icon" href="./favicon.ico">
    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <!-- JS -->
    <script src="/assets/scripts/contribution_textarea_handler.js"></script>
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
                        <span><?php echo count($contributions); ?></span>
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
                } else {
                    $nb_contrib_before = $random_contribution['ordre_soumission'] - 1;
                    $nb_contrib_after = count($contributions) - $random_contribution['ordre_soumission'];

                    $txt_before = txtContribSingularPlural($nb_contrib_before);
                    $txt_between = txtContribSingularPlural($nb_contrib_after);
                    $txt_after = txtContribSingularPlural($nb_contrib_after);
                ?>
                    <?php if ($txt_before) echo $txt_before; ?>
                    <p><?php echo $random_contribution['texte_contribution'] ?></p>
                    <?php if ($txt_after) echo $txt_after;  ?>
                    <?php if ($user_contribution) echo $user_contribution['texte_contribution'];  ?>
                <?php
                }
                if (!$user_contribution) {
                ?>
                    <div class="contribute">
                        <form class="contribute__form" action="submitContrib" method="POST">
                            <div class="contribute__inputwrapper">
                                <label class="contribute__label" for="contribution"></label>
                                <textarea class="contribute__input" type="text" name="contribution" placeholder="...boira le vin nouveau..."></textarea>
                            </div>
                            <button class="contribute__submit">Valider</button>
                        </form>
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
