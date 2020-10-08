<?php
namespace Pa\Middleware;

use Pa\Core\helpers;

class AuthentMiddleWare
{
    public function __construct()
    {

    }

    public function onRequest()
    {
        if(INSTALLER !== "false" && INSTALLER !== "ongoing") {
            // Récupère la route
            $uri = strtok($_SERVER["REQUEST_URI"], '?');
            // Parse et recupère l'intégralité des routes presentes dans le fichier de route
            $listOfRoutes = yaml_parse_file("routes.yml");
            // Verifie si cette route nécéssite d'être connecté pour l'atteindre, si oui vérifie que l'utilisateur est tjrs
            // connecté, si nan, il est renvoyé sur la page de login
            if (!empty($listOfRoutes[$uri]) && $listOfRoutes[$uri]['logged'] === true ) {
                if (!isset($_COOKIE["login"])) {
                    header("Location: ".helpers::getUrl('user', 'login'));
                    // Ce die() permet de stop l'action appelé par l'url avant la redirection vers la page de login
                    die();
                }
            }
        }
    }

    public function onController()
    {

    }

    public function onView()
    {

    }
}