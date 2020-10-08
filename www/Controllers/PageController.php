<?php

use Pa\Core\helpers;
use Pa\Core\Validator\PageValidator;
use Pa\Core\View;
use Pa\Managers\PageManager;
use Pa\Models\Menu;
use Pa\Models\Pages;

class PageController
{
    /**
     * Creation d'une page avec tinyMCE
     */
    public function createAction()
    {
        $title = 'Création d\'une page';
        $tabName = 'PAGE';
        $menu = Menu::getAll();
        unset($menu[1]);
        unset($menu[2]);

        // Si on accede a l'url avec un post, on sauvegarde la table pages avec les infos contenue dans le $_POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $errors = PageValidator::checkCreateForm($_POST);
            if (empty($errors)) {
                $page = new Pages();
                $page->setTitle(urlencode(helpers::removeScriptTag($_POST["title"])));
                $page->setContent(helpers::removeScriptTag($_POST["content"]));
                $page->setIdMenu($_POST['menu']);
                $pageManager = new PageManager();
                $pageManager->save($page);

                // Redirection vers la page contenenant la liste des pages existante
                header("Location: " . helpers::getUrl("page", "list"));
            }
        }
        $view = new View('pageCreate');
        $view->assign("tabName", $tabName);
        $view->assign("title", $title);
        $view->assign('menu', $menu);
        if (isset($errors)) {
            $view->assign('errors', $errors);
        }
    }

    /**
     * Modification d'une page avec tinyMCE
     */
    public function editAction()
    {
        $title = 'Modification d\'une page';
        $tabName = 'PAGE';

        // Si on accede a l'url avec un post, on met à jour la table pages avec les infos contenue dans le $_POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = PageValidator::checkCreateForm($_POST);
            if (empty($errors)) {
                $page = new Pages();
                $page->setId_page($_GET['id']);
                $page->setTitle(urlencode(helpers::removeScriptTag($_POST['title'])));
                $page->setContent(helpers::removeScriptTag($_POST['content']));
                $page->setIdMenu($_POST['menu']);

                (new PageManager())->save($page);

                // Redirection vers la page contenenant la liste des pages existante
                header("Location: " . helpers::getUrl("page", "list"));
                die();
            }
        }
        // On récupere le titre, contenue et l'onglet du menu de la page pour pouvoir le donner au formulaire de modification
        // pour pré-remplir les champs
        $page = (new Pages())->getPageById($_GET['id']);
        $menu = Menu::getAll($page["idMenu"]);
        if ($_GET['id'] !== '1' && $_GET['id'] !== '2') {
            unset($menu[1]);
            unset($menu[2]);
        }

        $view = new View('pageEdit');
        $view->assign('page', $page);
        $view->assign("tabName", $tabName);
        $view->assign("title", $title);
        $view->assign("menu", $menu);
        if (isset($errors)) {
            $view->assign('errors', $errors);
        }
    }

    /**
     * Suppression d'une page en bdd
     */
    public function deleteAction()
    {
        $id = $_GET['id'];
        if ($id !== '1' && $id !== '2') {
            // Suppression de la page par son id
            (new PageManager())->delete($id, 'id_page');
            // Redirection vers la liste pour mettre à jour la liste des pages
            header("Location: " . helpers::getUrl("page", "list"));
        }

    }

    /**
     * Affiche la liste de toute les pages contenu dans la table Pages
     */
    public function listAction()
    {
        $title = 'Page liste';
        $tabName = 'PAGE';
        // Récupération de tous les titres dans un tableau ou la clef correspond à l'id présent de bdd
        $pages = (new Pages())->getAllTitle();

        $view = new View('pageList');
        $view->assign("tabName", $tabName);
        $view->assign("title", $title);
        $view->assign('pages', $pages);
    }

    /**
     * Affiche le contenue d'une page créée avec tinyMCE
     */
    public function showAction()
    {
        // On récupère la page qui correspond à l'uri
        $page = (new Pages)->getPageByUri();
        $tabs = (new Menu)->getAllByPos();
        $menu = [];
        foreach ($tabs as $k => $v) {
            $pagesSortByMenu = (new Pages)->getByMenuPos($k);
            array_push($menu, $pagesSortByMenu);
        }
        $tabs = array_combine($tabs, $menu);

        $view = new View('page', 'front');
        $view->assign('page', $page);
        $view->assign('tabs', $tabs);
        $view->assign('menuSize', count($menu));
    }
}