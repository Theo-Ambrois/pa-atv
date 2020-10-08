<?php
namespace Pa\Models;

use Pa\Managers\PageManager;

class Pages extends Model
{
    protected $id_page;
    protected $title;
    protected $content;
    protected $idMenu;

    /** SETTER & GETTER */
    public function setId_page($id)
    {
        $this->id_page=$id;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title=$title;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setIdMenu($idMenu)
    {
        $this->idMenu = $idMenu;
        return $this;
    }

    public function getId()
    {
        return $this->id_page;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getIdMenu()
    {
        return $this->idMenu;
    }

    /**
     * @return array
     * Recupère tous les titres de toutes les pages
     */
    public function getAllTitle()
    {
        $allPages = (new PageManager())->getAll();
        $pages = [];
        foreach ($allPages as $p) {
            $pages[$p->getId()] = $p->getTitle();
        }
        return $pages;
    }

    /**
     * @return mixed
     * Récupère une page en bdd depuis son titre
     */
    public function getPageByUri()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $page = (new PageManager())->findBy(['title'=>ltrim($uri, '/')]);
        return $page[0];
    }

    /**
     * @param $id
     * @return mixed
     * Recupère une page en bdd depuis son id
     */
    public function getPageById($id)
    {
        $page = (new PageManager())->findBy(['id_page'=>$id]);
       return $page[0];
    }

    public function getByMenuPos($pos)
    {
        $pages = (new PageManager())->findPageByMenuPos($pos);
        return $pages;
    }

    /**
     * @param string $key
     * @return string|null
     * recherche la relation avec les autres tables
     */
    public function getRelation(string $key): ?string
    {
        $relations = $this->initRelation();

        if(isset($relations[$key]))
            return $this->initRelation()[$key];

        return null;
    }

    /**
     * @return array
     * initialise la relation avec les autres tables
     */
    public function initRelation()
    {
        // clef etrangère vers classe
        return [];
    }
}