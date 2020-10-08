<?php

namespace Pa\Middleware;

use Pa\Core\helpers;

class InstallerMiddleWare
{

    private $installer;

    /**
     * InstallerMiddleWare constructor.
     * Remplace la valeur INSTALLER=false par INSTALLER=ongoing dans le fichier .env
     */
    public function __construct()
    {
        $env = file_get_contents('.env');
        $explodedEnv = explode("\n", $env);
        foreach ($explodedEnv as $e) {
            $tmp = explode("=", $e);
            if ($tmp[0] === 'INSTALLER' && $this->installer !== "ongoing") {
                $this->installer = $tmp[1];
                $env = str_replace("false", "ongoing", $env);
            }
        }
        file_put_contents('.env', $env);
    }

    /**
     * Redirige vers la page d'installation si la variable d'env est à false
     */
    public function onRequest()
    {
        if ($this->installer === "false") {
            header("Location: " . helpers::getUrl('installer', 'install'));
            // Ce die() permet de stop l'action appelé par l'url avant la redirection vers l'installeur
            die();
        }
    }

    public function onController()
    {

    }

    public function onView()
    {

    }
}