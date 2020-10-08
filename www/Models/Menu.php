<?php

namespace Pa\Models;

use Pa\Core\helpers;
use Pa\Managers\MenuManager;
use Pa\Managers\RoleManager;

class Menu extends Model
{

    protected $id_menu;
    protected $name;
    protected $position;

    public function setId_menu($id)
    {
        $this->id_menu = $id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setPosition($pos)
    {
        $this->position = $pos;
        return $this;
    }

    public function getId()
    {
        return $this->id_menu;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $id
     * @return array
     * Si un $id est donné, il retournera en premiere case du tableau, l'onglet auquel correspond l'id
     */
    public function getAll($id = '')
    {
        $allTabs = (new MenuManager())->getAll();
        $menu = [];
        if ($id !== '') {
            foreach ($allTabs as $t) {
                if ($t->getId() === $id) {
                    $menu[$id] = $t->getName();
                }
            }
            foreach ($allTabs as $t) {
                if ($t->getId() !== $id)$menu[$t->getId()] = $t->getName();
            }
        }else {
            foreach ($allTabs as $t) {
                $menu[$t->getId()] = $t->getName();
            }
        }
        return $menu;
    }

    public function getAllByPos()
    {
        $allTabs = (new MenuManager())->getAll();
        $menu = [];
        foreach ($allTabs as $t) {
            $menu[$t->getPosition()] = $t->getName();
        }
        ksort($menu);
        return $menu;
    }


    public function getMenu()
    {
        $allTabs = (new MenuManager())->getAll();
        return $allTabs;
    }

    /**
     * @return array
     */
    public static function getCreateForm()
    {
        return [

            "config" => [
                "method" => "POST",
                "action" => helpers::getUrl("menu", "create"),
                "class" => "planning",
                "id" => "formCreateMenu",
                "submit" => "Créer"
            ],

            "fields" => [
                "name" => [
                    "type" => "text",
                    "placeholder" => "Nom de l'onglet",
                    "class" => "form",
                    "id" => "name",
                    "required" => true,
                    "min-length" => 2,
                    "max-length" => 50,
                    "errorMsg" => "Le nom doit être compris en 2 et 50 caractères."
                ],
            ]
        ];

    }

    /**
     * @param $pos
     * @param string $idRole
     * @return array
     */
    public static function getEditForm($pos)
    {
        return [

            "config" => [
                "method" => "POST",
                "action" => helpers::getUrl("menu", "edit", ['pos' => $pos]),
                "class" => "menu",
                "id" => "formEditMenu",
                "submit" => "Modifier"
            ],

            "fields" => [
                "name" => [
                    "type" => "text",
                    "placeholder" => "Nom de l'onglet",
                    "class" => "form",
                    "id" => "name",
                    "required" => true,
                    "min-length" => 2,
                    "max-length" => 50,
                    "errorMsg" => "Le nom doit être compris en 2 et 50 caractères."
                ]
            ]
        ];
    }
}