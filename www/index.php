<?php

use Pa\Core\ConstantLoader;
use Pa\Core\helpers;
use Pa\Core\MiddleWareManager;

function myAutoloader($class)
{
    $class = str_replace('Pa\\', '', $class);
    $class = str_replace('\\', '/', $class);

    $path = $class.".php";
    if (file_exists($path)) {
        include $path;
    }
}

// Appel l'autoloader
spl_autoload_register("myAutoloader");

// Recupère l'intégralité des .env
new ConstantLoader();

// Récupère toute l'uri sans prendre en compte la query
$uri = strtok($_SERVER["REQUEST_URI"], '?');

// Parse et recupère l'intégralité des routes presentes dans le fichier de route
$listOfRoutes = yaml_parse_file("routes.yml");

// Execute la méthode onRequest de tous les middlewares présent dans le dossier /Middleware
// Permet de verifier si l'utilisateur doit être connecté ou non pour acceder a l'url
// Vérifie également son role pour définir si il a le droit d'acceder a l'url
MiddleWareManager::launch('onRequest');

// Verifie que l'uri existe dans le dossier de route
if (!empty($listOfRoutes[$uri])) {
    // Recupere le controller et l'action sur laquelle la route pointe
    $c =  ucwords($listOfRoutes[$uri]["controller"]."Controller");
    $a =  $listOfRoutes[$uri]["action"]."Action";

    // Le chemin vers le controller
    $pathController = "Controllers/".$c.".php";

    // Verifie que le fichier existe sinon renvoie une exception
    if (file_exists($pathController)) {
        // L'inclus s'il existe
        include $pathController;
        //Vérifier que la class existe sinon renvoie une exception
        if (class_exists($c)) {
            // Crée une instance de la classe
            $controller = new $c();
            
            //Vérifier que la méthode existe sinon renvoie une exception
            if (method_exists($controller, $a)) {
                // Appelle la fonction défini dans le fichier route
                $controller->$a();
            } else {
                throw new Exception('L\'action n\'existe pas.');
            }
        } else {
            throw new Exception("La class controller n'existe pas" . $c);
        }
    } else {
        throw new Exception('Le fichier controller n\'existe pas.');
    }
} elseif (helpers::pageUrlExist($uri)) {
    // Si l'uri n'eest pas présente dans le fichier de route, verifie que la page n'est pas présente en bdd
    // dans la table page puis execute les mêmes verification que pour une route du fichier routes.yml
    $c = 'PageController';
    $a = 'showAction';

    $pathController = "Controllers/".$c.".php";
    if (file_exists($pathController)) {
        include $pathController;
        if (class_exists($c)) {
            $controller = new $c();
            if (method_exists($controller, $a)) {
                $controller->$a();
            } else {
                throw new Exception('L\'action n\'existe pas.' . $a);
            }
        } else {
            throw new Exception("La class controller n'existe pas" . $c);
        }
    }
} else {
    // Si l'uri n'est ni en bdd ni dans le dossier routes, une erreur 404 est renvoyé
    throw new Exception('L\'URL n\'existe pas : Erreur 404');
}
