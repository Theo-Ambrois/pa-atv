<?php

namespace Pa\Core\Validator;

use Pa\Managers\UserManager;

class EventValidator{

    /**
     * @param $configForm
     * @param $data
     * @return array|string[]
     * Verifie le form de création d'un event
     */
    public static function checkEventForm($configForm, $data): array
    {
        $listOfErrors = [];

        // Verifie qu'il y ait le bon nombre de champs
        if (count($configForm["fields"]) != count($data)) return ["Le nombre de champs remplis est incorrect"];
        
        // Boucle sur chaque champ du form
        foreach ($configForm["fields"] as $name => $config) {
            // Verifie que tous les champs required soient bien remplis
            if (!array_key_exists($name, $data) || ($config["required"] && empty($data[$name]))) 
                return ["Erreur lors du remplissage du formulaire"];

            // si le champ est de type texte
            if ($config["type"] == "text") {
                // longueur du champ
                if (strlen($data[$name]) < $config["min-length"] || strlen($data[$name]) > $config["max-length"])
                    $listOfErrors[] = $config['lengthErrorMsg'];
            }

            if ($name == "date_end" && (strtotime($data["date_start"]) > strtotime($data["date_end"])))
                $listOfErrors[] = $config["dateErrorMsg"];
        }
        return $listOfErrors;
    }
}