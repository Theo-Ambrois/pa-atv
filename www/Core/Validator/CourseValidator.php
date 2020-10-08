<?php

namespace Pa\Core\Validator;

use Pa\Managers\CourseManager;
use Pa\Managers\UserManager;

class CourseValidator{

    public static function checkCourseForm($configForm, $data, $id = '')
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
                    if (($name === "matiere" || $name === "teacher")
                        && (strlen($data[$name]) < 2 || strlen($data[$name] > 50))) {
                        $listOfErrors[] = $config['errorMsg'];
                    }
                }

                if (($name === "date_end" || $name === "date_start")) {
                    $courseManager = new CourseManager();
                    $res = $courseManager->verifCourse($data["date_start"], $data["date_end"], $data["planning"], $id);
                    if (!empty($res)) {
                        $listOfErrors[] = "Il semblerait qu'un cours existe déjà sur ce créneau<br>";
                    }
                    var_dump($data['planning']);
                    $res = $courseManager->courseInsidePlanning($data["date_start"], $data["date_end"], $data["planning"]);
                    if (!empty($res)) {
                        $listOfErrors[] = "Le cours est en dehors du planning<br>";
                    }
                }

                if ($name == "date_end" && (strtotime($data["date_start"]) > strtotime($data["date_end"])))
                    $listOfErrors[] = $config["dateErrorMsg"];
            }
        }
        return $listOfErrors;
    }
}