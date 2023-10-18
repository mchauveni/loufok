<?php

class HTTP
{
    /**
     * Indique si la méthode de travail est GET.
     */
    public static function is_method_get(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

  /**
   * Retourne l'URL complète.
   *
   * @return string
   */
  public static function url(string $url = '')
  {
      // ajouter le slash si nécessaire
      $url = substr($url, 0, 1) != '/' ? '/'.$url : $url;

      return APP_ROOT_URL_COMPLETE.$url;
  }

    /**
     * Redirige vers une route.
     *
     * @return void
     */
    public static function redirect(string $url = '/')
    {
        header('Location: '.APP_ROOT_URL_COMPLETE.$url);
    }
}
