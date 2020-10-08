<?php

namespace Pa\Core\Validator;

class MarkValidator{

    public static function checkMarkForm($configForm, $data)
    {
        $listOfErrors = [];
        $regex = "/^(?=.*[1-9]).{1,2}$/";
        $rangeNote = range(0, 20, 0.25);
        $rangeCoeff = range(1, 10);
        $dateToday = date("Y-m-d");

        // Verifie qu'il y ai le bon nombre de champs
        if (count($configForm["fields"]) == count($data)) {

            foreach ($configForm["fields"] as $name => $config) {

                // Verifie que tous les chamsp required soit bien rempli
                if (!array_key_exists($name, $data) ||
                    ($config["required"] && empty($data[$name]))
                ) return ["Erreur lors du remplissage du formulaire"];

                //longueur des champs && bon charactères
                if ($config["type"] === "text") {
                    if ($name === "matiere" && (strlen($data[$name]) < 2 || strlen($data[$name] > 50))) {
                        $listOfErrors[] = $config['matierError'];
                    }
                    if ($name === "name" && (strlen($data[$name]) < 2 || strlen($data[$name] > 50))) {
                        $listOfErrors[] = $config['nameError'];
                    }

                    if ($name === "note" && !in_array($data[$name], $rangeNote)){
                        $listOfErrors[] = $config['marksError'];
                    }

                    if ($name === "coefficient" && !in_array($data[$name], $rangeCoeff)){
                        $listOfErrors[] = $config['coeffError'];
                    }
                }

                if ($name === "date" && (strtotime($data["date"]) > strtotime($dateToday))){
                        $listOfErrors[] = $config["dateError"];
                }

            }
        }
        return $listOfErrors;
    }

}