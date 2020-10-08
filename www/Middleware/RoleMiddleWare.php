<?php

namespace Pa\Middleware;

use Pa\Managers\RoleManager;
use Pa\Core\helpers;

class RoleMiddleWare
{
    public function __construct()
    {

    }

    public function onRequest()
    {
        if (isset($_COOKIE['login']) && INSTALLER !== "false" && INSTALLER !== "ongoing") {
            // Recupère le role de l'utilisateur
            $role = (new RoleManager)->getUserRoleByLogin($_COOKIE['login']);
            // Crée un tableau listant l'intégralité des droits du role
            $auth = helpers::getAuth($role);
            // Récupère la route
            $uri = strtok($_SERVER["REQUEST_URI"], '?');
            // Parse et recupère l'intégralité des routes presentes dans le fichier de route
            $listOfRoutes = yaml_parse_file("routes.yml");
            // Verifie si cette route existe. Si elle existe, un boucle sur le tableau de role est réalisé pour savoir si
            // l'utilisateur possède les autorisation nécéssaire pour y acceder.
            if (!empty($listOfRoutes[$uri])) {
                foreach ($listOfRoutes[$uri]['role'] as $key) {
                    if ($key !== '' && !($auth[$key])) {
                        header("Location: ".helpers::getUrl('default', 'default'));
                        //Ce die() permet de stop l'action appelé par l'url avant la redirection vers le dashboard
                        die();
                    }
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