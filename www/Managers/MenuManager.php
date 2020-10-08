<?php
namespace Pa\Managers;

use Pa\Core\Connection\BDDInterface;
use Pa\Core\Manager;
use Pa\Core\QueryBuilder;
use Pa\Models\Menu;

class MenuManager extends Manager
{
    /**
     * MenuManager constructor.
     * Appelle le constructeur parent
     */
    public function __construct()
    {
        parent::__construct(Menu::class, 'menu');
    }

    /**
     * @return array
     * Recupère tous les menus
     */
    public function getAll()
    {
        return $this->findAll();
    }

    /**
     * @param $id
     * @return mixed
     * Recup les infos d'un onglet
     */
    public function getMenuInfo($id)
    {
        $menu = $this->findBy(["id_menu"=>$id]);
        return $menu[0];
    }

    public function getIdMenuByPos($pos)
    {
        $menu = $this->findBy(["position"=>$pos]);
        return $menu[0];
    }
}