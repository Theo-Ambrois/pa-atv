<?php

namespace Pa\Core\Validator;

use Pa\Managers\UserManager;

class PlanningValidator{

    public static function checkPlanningForm($configForm, $data)
    {
        $listOfErrors = [];

        // Verifie qu'il y ai le bon nombre de champs
        if (count($configForm["fields"]) == count($data)) {

            foreach ($configForm["fields"] as $name => $config) {

                // Verifie que tous les chamsp required soit bien rempli
                if (!array_key_exists($name, $data) ||
                    ($config["required"] && empty($data[$name]))
                ) return ["Erreur lors du remplissage du formulaire"];

                if ($config['type'] === 'text') {
                    if ($name === "name" && (strlen($data[$name]) < 2 || strlen($data[$name] > 50))) {
                        $listOfErrors[] = $config['errorMsg'];
                    }
                }

                if ($name == "date_end" && (strtotime($data["date_start"]) > strtotime($data["date_end"])))
                    $listOfErrors[] = $config["dateErrorMsg"];
            }
        }
        return $listOfErrors;
    }
}