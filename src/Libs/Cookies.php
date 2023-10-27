<?php

class Cookies {
	/* Stocke toutes les données du compte connecté dans les cookies */
	public static function log_in(array $data, bool $is_admin) {
		switch ($is_admin) {
			case true:
				setcookie("account_type", "admin");
				setcookie("id", "id_administrateur");
				setcookie("email", "ad_mail_administrateur");
				break;

			case false:
				setcookie("account_type", "user");
				setcookie("id", $data["id_joueur"]);
				setcookie("username", $data["nom_plume"]);
				setcookie("email", $data["ad_mail_joueur"]);
				setcookie("gender", $data["sexe"]);
				setcookie("birthdate", $data["ddn"]);
				break;
		}
		setcookie('is_logged_in', true);
	}

	public static function log_out() {
		switch ($_COOKIE['account_type']) {
			case 'admin':
				setcookie("account_type", '', -1);
				setcookie("id", '', -1);
				setcookie("email", '', -1);
				break;

			case 'user':
				setcookie("account_type", '', -1);
				setcookie("id", '', -1);
				setcookie("username", '', -1);
				setcookie("email", '', -1);
				setcookie("gender", '', -1);
				setcookie("birthdate", '', -1);
				break;
		}
		setcookie('is_logged_in', 0);
	}

	public static function init() {
		setcookie("is_logged_in", true);
	}
}
