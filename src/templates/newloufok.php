<?php

$errors = null;
if (HTTP::is_method_post()) {

    // Si tous les champs ne sont pas remplis, on ignore les autres tests
    if (!isset($_POST['titre_loufokerie']) || !isset($_POST['date_debut_loufokerie']) || !isset($_POST['heure_debut_loufokerie']) || !isset($_POST['date_fin_loufokerie']) || !isset($_POST['heure_fin_loufokerie']) || !isset($_POST['texte_contribution'])) {
        $errors = "Tous les champs ne sont pas remplis";
    } else {
        $datetime_debut = new DateTime($_POST['date_debut_loufokerie'] . " " . $_POST['heure_debut_loufokerie']);
        $datetime_debut = $datetime_debut->format('Y-m-d H:i:s');

        $datetime_fin = new DateTime($_POST['date_fin_loufokerie'] . " " . $_POST['heure_fin_loufokerie']);
        $datetime_fin = $datetime_fin->format('Y-m-d H:i:s');

        $now = new DateTime('now');
        $now = $now->format('Y-m-d H:i:s');

        // L'utilisateur ne peux pas créer de Loufokerie en dehors de MAINTENANT (pas prévoir)
        if ($datetime_debut > $now) {
            $errors = "Date de début ultérieure à maintenant";
        }

        if ($datetime_fin < $now) {
            $errors = "Date de début antérieure à maintenant";
        }

        if (Loufokerie::getInstance()->getCurrent()) {
            $errors = "Il y a déjà une Loufokerie en cours..";
        }

        var_dump($_POST['texte_contribution']);
        if (strlen($_POST['texte_contribution']) < 50) {
            $errors = "Texte trop court";
        }
        if (strlen($_POST['texte_contribution']) > 280) {
            $errors = "Texte trop long";
        }
    }


    if (!$errors) {
        $id = Loufokerie::getInstance()->create([
            "id_administrateur" => $_COOKIE['id'],
            "titre_loufokerie" => $_POST["titre_loufokerie"],
            "date_debut_loufokerie" => $_POST["date_debut_loufokerie"],
            "date_fin_loufokerie" => $_POST["date_fin_loufokerie"],
            "nb_contributions" => 0,
            "nb_jaime" => 0,
        ]);

        Contribution::getInstance()->createSubmission([
            "id_loufokerie" => $id,
            "id_administrateur" => $_COOKIE['id'],
            "texte_contribution" => $_POST['texte_contribution'],
            "date_soumission" => $now,
            "ordre_soumission" => 1,
        ]);

        HTTP::redirect('/admin');
    }
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
    <link rel="stylesheet" href="./assets/css/newloufok.css">
    <!-- JS -->
    <script src="./assets/scripts/contribution_textarea_handler.js"></script>
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
    <a class="button_back" href="./admin">
        <img src="./assets/images/chevron_left.svg">
        Retour
    </a>
    <form class="form" method="POST">
        <div class="form__div">
            <label class="form__label" for="titre_loufokerie">Titre</label>
            <input class="form__input" type="text" name="titre_loufokerie" required>
        </div>
        <div class="form__div">
            <label class="form__label" for="date_debut_loufokerie">Date de début</label>
            <div class="form__inputwrapper">
                <input class="form__input" type="date" name="date_debut_loufokerie" required>
                <input class="form__input" type="time" name="heure_debut_loufokerie" aria-label="heure de début" required>
            </div>
            <label class="form__label" for="date_fin_loufokerie">Date de fin</label>
            <div class="form__inputwrapper">
                <input class="form__input" type="date" name="date_fin_loufokerie" required>
                <input class="form__input" type="time" name="heure_fin_loufokerie" aria-label="heure de fin" required>
            </div>
        </div>
        <div class="form__div">
            <label class="form__label" for="texte_contribution">Première contribution</label>
            <textarea class="form__input contribute__input" name="texte_contribution" required></textarea>
        </div>
        <?php
        if ($errors) {
            echo "<p class='errors'>$errors</p>";
        }
        ?>
        <div class="form__submit">
            <button class="form__button">Valider</button>
        </div>
    </form>
</body>

</html>
<?php
