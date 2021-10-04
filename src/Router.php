<?php

namespace App;

use AltoRouter;
use App\Controller\ErrorController;

class Router extends AltoRouter {
  /**
   * Crée une instance du router pour naviguer sur le site
   *
   */
  public function __construct() {}

/**
 * Ajoute une route à faire correspondre en méthode GET
 *
 * @param string $route la route à faire correspondre (peut prendre la forme d'une regex). On peut utiliser des filtres comme [i:id]
 * @param mixed $target La chose à faire lorsqu'une route trouve une correspondance, ici on attend ce genre de format -> Controller#method
 */
  public function get(string $route, string $target): self {
    $this->map("GET", $route, $target);
    // on ajoute aussi la version avec le trailing slash
    $this->map("GET", $route . '/', $target);

    return $this;
  }

  /**
   * Ajoute une route à faire correspondre en méthode POST
   *
   * @param string $route la route à faire correspondre (peut prendre la forme d'une regex). On peut utiliser des filtres comme [i:id]
   * @param mixed $target La chose à faire lorsqu'une route trouve une correspondance, ici on attend ce genre de format -> Controller#method
   */
  public function post(string $route, string $target): self {
    $this->map("POST", $route, $target);
    // on ajoute aussi la version avec le trailing slash
    $this->map("POST", $route . '/', $target);

    return $this;
  }

  /**
   *
   * Démarre le router pour vérifier les correspondances de routes.
   * Elle va instancier un nouveau controller en rapport avec ce qui
   * est passé dans le paramètre $target lors de l'ajout d'une route et executer l'action associée
   * en passant les paramètres présents dans l'url
   *
   */
  public function start() {
    // recupere les correspondances de route <-> requete
    $match = $this->match();

    if (is_array($match)) {
      // dans la variable match qui est un tableau on à 3clés posibles: target, params, name
      $target = $match['target'];
      $params = $match['params'];

      // $result = explode('#', $target);
      // $controller = $result[0];
      // $action = $result[1];
      // cette syntaxe est equivalente à ce qui se trouve en dessous
      [$controller, $action] = explode('#', $target);

      $controller = "App\Controller\\$controller";
      // $obj = new App\Controller\MainController();

      $obj = new $controller();

      if (is_callable([$obj, $action])) {

        if (!empty($params)) {
          // on execute la combinaison de l'objet et de l'action (execute la méthode de l'objet) avec tous les paramètres reçus
          array_walk($params, [$obj, $action]);
          return;
        }

        // $obj->getHome();
        $obj->$action();
      }

      return;
    }

    // si aucune route n'a trouvé de correspondance
    $errorController = new ErrorController();
    $errorController->get404();
  }

  public static function redirect(string $path, int $code = 301) {
    http_response_code($code);
    header("Location: $path");
    die();
  }

}