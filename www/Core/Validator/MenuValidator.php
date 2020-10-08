<?php

namespace Pa\Core\Validator;

use Pa\Core\helpers;
use Pa\Managers\MenuManager;

class MenuValidator{

    public static function checkMenuForm($data)
    {
        $listOfErrors = [];

        // Verifie qu'il y ai le bon nombre de champs
        if (count($data) === 1) {

            foreach ($data as $k => $v) {
                if ($k === 'name' && strlen($v) < 2 || strlen($v) > 50) {
                    $listOfErrors[] = 'Le nom de l\'onglet doit être compris entre 2 et 50 caractères';
                }
                $res[] = (new MenuManager())->findBy([$k=>helpers::specialChars($v)]);
                if (!empty($res[0])) {
                    $listOfErrors[] = 'Un onglet portant ce nom existe déjà !';
                }
            }
        }
        return $listOfErrors;
    }
}