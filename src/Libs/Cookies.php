<?php

class Cookies
{
	/* Stocke toutes les données du compte connecté dans les cookies */
	public static function store_account(array $data, bool $is_admin)
	{
		switch ($is_admin) {
			case true:
				$_COOKIE["account_type"] = "admin";
				$_COOKIE["id"] = $data["id_administrateur"];
				$_COOKIE["email"] = $data["ad_mail_administrateur"];
				break;

			case false:
				$_COOKIE["account_type"] = "user";
				$_COOKIE["id"] = $data["id_joueur"];
				$_COOKIE["username"] = $data["nom_plume"];
				$_COOKIE["email"] = $data["ad_mail_administrateur"];
				$_COOKIE["gender"] = $data["sexe"];
				$_COOKIE["birthdate"] = $data["ddn"];
				break;
		}
	}

	/* Supprime tous les cookies */
	public static function unsetAll()
	{
		foreach ($_COOKIE as $cookie) {
			unset($cookie);
		}
	}

	/* Supprime un cookie */
	public static function unset(string $key)
	{
		if (isset($_COOKIE[$key])) {
			unset($_COOKIE[$key]);
		}
	}
}
