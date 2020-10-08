<?php

use Pa\Core\helpers;
use Pa\Core\View;
use Pa\Models\Menu;
use Pa\Models\Pages;

class SitemapController {

    private $title = "Sitemap";
    private $tabName = "SITEMAP";

    public function createAction()
    {
        $xml = new DOMDocument("1.0", "utf-8"); //création de l'entête xml
        $xml_site = $xml->createElement("Site"); //création élément racine "login"

        $tabs = (new Menu)->getAllByPos();
        $menu = [];
        foreach ($tabs as $k => $v) {
            $pagesSortByMenu = (new Pages)->getByMenuPos($k);
            array_push($menu, $pagesSortByMenu);
        }
        $tabs = array_combine($tabs, $menu);

        foreach ($tabs as $tab => $v) {

            $tabName = helpers::cleanString(str_replace(' ', '', ucwords(urldecode($tab))));
            $xml_tab = $xml->createElement($tabName); //crée élément
            $xml_site->appendChild($xml_tab); //rattache le controller à home

            if (count($v) > 0) {
                foreach ($v as $value) {
                    $pageName = helpers::cleanString(str_replace(' ', '', ucwords(urldecode($value["title"]))));
                    $xml_page = $xml->createElement($pageName); //crée élément
                    $xml_tab->appendChild($xml_page); //rattache la page à l'onglet
                }
            }
        }

        $xml->appendChild($xml_site); //rattache l'élément racine "login" au doc xml

        $fileName = "sitemap/arborescence.xml"; // chemin du fichier que l'on va utiliser
        $f = fopen($fileName, "w"); //création ou écrasement du fichier du fichier
        fputs($f, $xml->saveXML()); //saveXML = parse; fputs pour écrire dans le fichier
        fclose($f); //ferme le fichier

        header("Location: /sitemap/arborescence.xml"); //redirection vers le fichier
        die();


    }


}
