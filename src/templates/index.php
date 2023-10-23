<?php
if (!$_COOKIE['is_logged_in']) {
    HTTP::redirect('/login');
}

$loufokeries = Loufokerie::getInstance()->findAll();
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
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>
    <a href="/logout"><img src="/assets/images/logout.svg" alt=""></a>
    <header>
        <h1>Bienvenue <?php echo $_COOKIE["username"] ?></h1>
    </header>
    <div>
        <?php
        if (!$loufokeries) {
            echo "Il n'y a pas encore de Loufokerie..";
        } else {
            foreach ($loufokeries as $loufokerie) {
                $date_debut = date_format(date_create($loufokerie['date_debut_loufokerie']), 'd/m/Y');
                $date_fin = date_format(date_create($loufokerie['date_fin_loufokerie']), 'd/m/Y');
        ?>
                <a class="loufokerie">
                    <h3><?php echo $date_debut . " - " . $date_fin ?></h3>

                </a>
        <?php
            }
        }
        ?>
    </div>
</body>

</html>
<?php
