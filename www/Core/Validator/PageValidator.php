<?php

namespace Pa\Core\Validator;

use Pa\Core\helpers;
use Pa\Managers\PageManager;

class PageValidator{

    public static function checkCreateForm($data)
    {
        $listOfErrors = [];
        // Verifie qu'il y ai le bon nombre de champs
        if (count($data) == 3) {
            foreach ($data as $k => $v) {
                if ($k === 'title') {
                    if (strlen(urlencode(helpers::removeScriptTag($v))) < 2 ||
                        strlen(urlencode(helpers::removeScriptTag($v))) > 50) {
                        $listOfErrors[] = 'Votre titre doit être compris entre 2 et 50 caractères !';
                    }
                    $res[] = (new PageManager())->findBy([$k=>urlencode(helpers::removeScriptTag($v))]);
                    if (!empty($res[0])) {
                        $listOfErrors[] = 'Une page portant ce nom existe déjà !';
                    }

                }
                if ($k === 'menu' && empty($v)) {
                    $listOfErrors[] = 'Vous devez associez votre page à un menu !';
                }
            }
        }
        return $listOfErrors;
    }
}