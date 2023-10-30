<?php
if ($_COOKIE['is_logged_in']) {
	$_COOKIE['account_type'] == "user" ? HTTP::redirect() : HTTP::redirect('/admin');
}

if (HTTP::is_method_post()) {
	date_default_timezone_set('Europe/Paris');
	$user = User::getInstance()->findBy(['ad_mail_joueur' => $_POST['email'], 'mot_de_passe_joueur' => $_POST['password']]);
	$errors = false;

	// Si un utilisateur n'est pas trouvé
	if (!$user) {
		$admin = Admin::getInstance()->findBy(['ad_mail_administrateur' => $_POST['email'], 'mot_de_passe_administrateur' => $_POST['password']]);

		if ($admin) {
			// REDIRIGER VERS UNE PAGE ADMIN
			Cookies::log_in($admin[0], true);
			HTTP::redirect('/admin');
		} else {
			$errors = 'Identifiants invalides';
		}
	}

	if (!$errors) {
		// REDIRIGER VERS LA PAGE DE BASE
		Cookies::log_in($user[0], false);
		HTTP::redirect('/');
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
	<title>Connexion</title>
	<!-- Meta Tags -->
	<meta name="robots" content="noindex, nofollow">
	<!-- Favicon -->
	<link rel="icon" href="./assets/images/favicon.ico">
	<!-- CSS -->
	<link rel="stylesheet" href="./assets/css/main.css">
	<link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>
	<div class="login">
		<form class="login__form" method="post">
			<img src="./assets/images/loufok.svg" alt="">
			<div class="login__inputwrapper">
				<label class="login__label" for="email">Adresse Email</label>
				<input class="login__input" type="text" name="email" id="">
			</div>
			<div class="login__inputwrapper">
				<label class="login__label" for="password">Mot de Passe</label>
				<input class="login__input" type="password" name="password" id="">
			</div>
			<?php
			if (isset($errors)) {
			?>
				<div class="login__errorwrapper">
					<p class="login__error"><?php echo $errors; ?></p>
				</div>
			<?php
			}
			?>
			<div class="login__inputwrapper login__inputwrapper--button">
				<button class="login__button">Se connecter</button>
			</div>
		</form>
	</div>
</body>

</html>
<?php
