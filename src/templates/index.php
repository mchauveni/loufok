<?php

if ($_COOKIE['account_type'] === "admin") {
    HTTP::redirect('/admin');
}

// Récupère la loufokerie et formate les dates
$loufokerie = Loufokerie::getInstance()->getCurrent();
$errors = false;

if (HTTP::is_method_post() && isset($_POST['contribution_text'])) {
    $length_contrib = strlen($_POST['contribution_text']);

    if ($length_contrib < 50) {
        $errors = "Le texte doit faire au moins 50 caractères";
    }

    if ($length_contrib > 280) {
        $errors = "Le texte est trop long";
    }

    if (Contribution::getInstance()->findBy(['id_joueur' => $_COOKIE['id'], 'id_loufokerie' => $loufokerie['id_loufokerie']])) {
        $errors = "Vous avez déjà contribué";
    }

    if (!$errors) {
        $now = new DateTime('now');
        $now = $now->format('Y-m-d H:i:s');
        Contribution::getInstance()->createSubmission([
            "id_loufokerie" => $loufokerie['id_loufokerie'],
            "id_joueur" => $_COOKIE['id'],
            "texte_contribution" => $_POST['contribution_text'],
            "date_soumission" => $now,
            "ordre_soumission" => Contribution::getInstance()->getLastSubmission() + 1,
        ]);
    }
}

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
    <link rel="stylesheet" href="./assets/css/header.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <!-- JS -->
    <script src="./assets/scripts/contribution_textarea_handler.js"></script>
</head>

<body>
    <header class="header">
        <div class="header__icons">
            <img class="header__icon header__icon--loufok" src="./assets/images/loufok.svg" alt="">
            <a class="header__logout" href="./logout"><img class="header__icon" src="./assets/images/logout.svg" alt=""></a>
        </div>
        <h1 class="header__greetings">Bienvenue <span class="header__username"><?php echo $_COOKIE["username"] ?></span>,</h1>
        <hr class="header__separator">
        </hr>
    </header>
    <div>
        <?php
        if (!$loufokerie) {
            echo "<p class='no_loufokerie'>Il n'y a pas de Loufokerie en cours..</p>";
        } else {
        ?>
            <div class="loufokerie">
                <h2 class="loufokerie__title"><?php echo $loufokerie["titre_loufokerie"] ? $loufokerie['titre_loufokerie'] : "Loufokerie en cours"  ?></h2>
                <div class="loufokerie__header">
                    <p class="loufokerie__dates"><?php echo $date_debut . " - " . $date_fin ?></p>
                    <div class="loufokerie__nbcontrib">
                        <span><?php echo count($contributions); ?></span>
                        <img src="./assets/images/contributions.svg" alt="contributions">
                    </div>
                </div>
                <?php
                // Si le joueur n'a pas de contribution aléatoire attribuée
                if (!$random_contribution) {
                ?>
                    <div class="joinLoufokerie">
                        <p class="joinLoufokerie__text">Vous n'avez pas encore de contribution attribuée</p>
                        <a href="./assignRandomContrib" class="joinLoufokerie__button">Rejoindre la loufokerie</a>
                    </div>
                <?php
                } else {
                    $nb_contrib_before = $random_contribution['ordre_soumission'] - 1;
                    $nb_contrib_between = ($user_contribution) ? $user_contribution['ordre_soumission'] - $random_contribution['ordre_soumission'] - 1 :  count($contributions) - $random_contribution['ordre_soumission'];
                    $nb_contrib_after = ($user_contribution) ? count($contributions) - $user_contribution['ordre_soumission'] : 0;

                    $txt_before = txtContribSingularPlural($nb_contrib_before);
                    $txt_between = txtContribSingularPlural($nb_contrib_between);
                    $txt_after = txtContribSingularPlural($nb_contrib_after);

                ?>
                    <?php if ($txt_before) echo $txt_before; ?>
                    <p class="loufokerie__contribution"><?php echo $random_contribution['texte_contribution'] ?></p>
                    <?php if ($txt_between) echo $txt_between; ?>
                    <?php if ($user_contribution) echo "<p class='loufokerie__contribution'>" . $user_contribution['texte_contribution'] . "</p>"; ?>
                    <?php if ($txt_after) echo $txt_after; ?>
                <?php
                }
                if (!$user_contribution && $random_contribution) {
                ?>
                    <div class="contribute">
                        <form class="contribute__form" method="POST">
                            <div class="contribute__inputwrapper">
                                <label class="contribute__label" for="contribution"></label>
                                <textarea class="contribute__input" type="text" name="contribution_text" placeholder="...boira le vin nouveau..."></textarea>
                            </div>
                            <?php
                            if ($errors) {
                                echo "<p class='errors'>$errors</p>";
                            }
                            ?>
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
