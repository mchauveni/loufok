<?php
if (!$_COOKIE['is_logged_in']) {
    HTTP::redirect('/login');
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
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>
    <a href="/logout">Déconnexion</a>
    <h1>Bienvenue <?php echo $_COOKIE["username"] ?></h1>
</body>

</html>
<?php
