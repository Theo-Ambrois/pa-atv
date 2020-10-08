<?php

namespace Pa\Managers;

use Pa\Core\Connection\BDDInterface;
use Pa\Core\Manager;
use Pa\Core\QueryBuilder;
use Pa\Models\Pages;

/**
 * Class PageManager
 * @package Pa\Managers
 */
class PageManager extends Manager
{
    /**
     * PageManager constructor.
     * Appelle le constructeur parent
     */
    public function __construct()
    {
        parent::__construct(Pages::class, 'pages');
    }

    /**
     * @return array
     * Recupère toutes les pages
     */
    public function getAll()
    {
        return $this->findAll();
    }

    public function findPageByMenuPos($pos)
    {
        $res = (new QueryBuilder())->select('m.id_menu')
            ->from('menu', 'm')
            ->where('position = :position')
            ->setParameter('position', $pos)
            ->getQuery()
            ->getOneOrNull();

        return $this->findBy(['idMenu'=>$res['id_menu']]);
    }
}