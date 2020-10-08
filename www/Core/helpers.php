<?php

namespace Pa\Core;

use Pa\Managers\PageManager;

class helpers
{
    /**
     * @param $controller
     * @param $action
     * @param array $query
     * @return int|string
     * Récupère l'url correspondant a un controller et une action
     * Passer en parametre un tableau de query permet d'ajouter a la suite de l'url la query
     */
    public static function getUrl($controller, $action, $query = [])
    {
        // Récupère tous le contenue du fichier routes.yml
        $listOfRoutes = yaml_parse_file("routes.yml");
        foreach ($listOfRoutes as $url=>$route) {
            // Verifie pour chaque route si le controller et l'action sont égale
            if ($route["controller"] == $controller && $route["action"]==$action) {
                // Si une query a été donnée, on l'ajoute a la suite de l'url sinon on retourne que l'url
                if ($query !==  []) {
                    $queryWithParams = '';
                    foreach ($query as $k=>$v) {
                        $queryWithParams .= "&$k=$v";
                    }
                    return $url.'?'.ltrim($queryWithParams, '&');
                }
                return $url;
            }
        }
            //die("Aucune correspondance pour la route");
    }

    /**
     * @param $uri
     * @return bool
     * Vérifie en bdd qu'une page créé avec tinyMCE existe
     */
    public static function pageUrlExist($uri)
    {
        $page = (new PageManager())->findBy(['title'=>ltrim($uri, '/')]);
        return empty($page) ? false : true;
    }

    /**
     * @param $params
     * @return array
     * getAuth() retourne un tableau précisant vrai ou faux pour préciser si le role
     * a le droit de Lire/Modifier/Créer/Supprimer
     */
    public static function getAuth($params)
    {
        $auth = [];
        foreach ($params as $k => $v) {
            if ($k === 'planning' || $k === 'user' || $k === 'document' ||
                $k === 'event' || $k === 'role' || $k === 'mark' || $k === 'page') {
                if (($v - 8) >= 0) {
                    $v -= 8;
                    $auth[$k . '_delete'] = 1;
                } else $auth[$k . '_delete'] = 0;
                if (($v - 4) >= 0) {
                    $v -= 4;
                    $auth[$k . '_update'] = 1;
                } else $auth[$k . '_update'] = 0;
                if (($v - 2) >= 0) {
                    $v -= 2;
                    $auth[$k . '_read'] = 1;
                } else $auth[$k . '_read'] = 0;
                if (($v - 1) >= 0) {
                    $v -= 1;
                    $auth[$k . '_create'] = 1;
                } else $auth[$k . '_create'] = 0;
            }
        }
        return $auth;
    }

    /**
     * @param $string
     * @return string
     * Retourne le string parser avec htmlspecialchar (2 fois parce que 1 fois ne fonctionne pas)
     */
    public static function specialChars($string)
    {
        return htmlspecialchars(htmlspecialchars($string, ENT_QUOTES));

    }

    public static function cleanString($text) {
        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
            '/[!?,;.:§^¨ù%*µ<>_-`#]/'    => '',
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $text);
    }

    /**
     * @param $beginning
     * @param $end
     * @param $string
     * @return mixed
     * Fonction permettant de retirer tout les balises scripts et leurs contenue dans un string
     */
    public static function removeScriptTag($string, $beginning = "<script>", $end = "</script>") {
        // Récupère la position de la balise script ouvrante
        $beginningPos = strpos($string, $beginning);
        // Récupère la position de la balise script fermante
        $endPos = strpos($string, $end);
        // Si aucune balise n'est trouvé retourne le string
        if ($beginningPos === false || $endPos === false) {
            return $string;
        }
        // Récupère la chaine de caractère
        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);
        // Ré-appelle la fonction en modifiant le string donner en params
        // pour s'assurer qu'il ne reste aucune balise script
        return self::removeScriptTag(str_replace($textToDelete, '', $string), $beginning, $end);
    }
}
