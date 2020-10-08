<?php
use Pa\Core\helpers;
use Pa\Core\Validator\MenuValidator;
use Pa\Core\View;
use Pa\Managers\MenuManager;
use Pa\Models\Menu;

class MenuController
{
    public function createAction()
    {
        $title = 'Création d\'un onglet';
        $tabName = 'MENU';
        $menus = (new Menu())->getAll();
        $configForm = Menu::getCreateForm();

        if (count($menus) >= 12) {
            header("Location: ".helpers::getUrl("menu", "list"));
            die();
        }

        // Si on accede a l'url avec un post, on sauvegarde les infos contenue dans le $_POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $errors = MenuValidator::checkMenuForm($_POST);
            if (empty($errors)) {
                // vérif des champs pour éviter les fraudes
                $menus = new Menu();
                $menus->setName(helpers::specialChars($_POST["name"]));
                // set order to be automatically the last
                $menus->setPosition(count($menus->getAll()) + 1);
                $menuManager = new MenuManager();
                $menuManager->save($menus);

                // Redirection vers la page contenenant la liste des menu existante
                header("Location: " . helpers::getUrl("menu", "list"));
                die();
            }
        }
        $view = new View('menuCreate');
        $view->assign("tabName", $tabName);
        $view->assign("title", $title);
        $view->assign('configForm', $configForm);
        if (isset($errors)){
            $view->assign('errors', $errors);
        }
    }

    public function deleteAction()
    {
        $pos = $_GET['pos'];
        $menu = new Menu;
        $menuManager = new MenuManager();
        // Recup les infos d'un onglet grâce à sa position
        $tabToDelete = $menuManager->getIdMenuByPos($pos);
        // converti id en int
        $id = intval($tabToDelete['id_menu']);
        // Si id correspond a l'index ou le contact, on ne peux pas kes supprimer
        if($id === 1 || $id === 2) {
            header("Location: " . helpers::getUrl("menu", "list"));
            die();
        }
        // Récupère le nb d'onglet avant suppression
        $nbTab = count($menu->getAll());
        // Suppression d'un onglet par son id
        $menuManager->delete($id, 'id_menu');

        // Boucle sur chaque position après la position supprimez pour les redurie de 1
        for($i = intval($pos)+1; $i<=$nbTab; $i++)
        {
            $tab = $menuManager->getIdMenuByPos($i);
            $menu->setId_menu($tab['id_menu']);
            $menu->setName($tab['name']);
            $menu->setPosition($tab['position']-1);
            $menuManager->save($menu);
        }

        // Redirection pour mettre à jour la liste
        header("Location: " . helpers::getUrl("menu", "list"));
        die();
    }

    public function editAction()
    {
        $pos = $_GET['pos'];
        $menuManager = new MenuManager();
        // Recup les infos du menu par sa position
        $menuInfo = $menuManager->getIdMenuByPos($pos);
        $id = $menuInfo['id_menu'];
        if($id === 1 || $id === 2) {
            header("Location: " . helpers::getUrl("menu", "list"));
            die();
        }
        $title = 'Modifier un onglet';
        $tabName = 'MENU';

        // Recup du form d'édition
        $configEditForm = Menu::getEditForm($pos);

        // Si on accede a l'url avec un post, on modifie la table planning avec les infos contenue dans le $_POST
        if ($_SERVER["REQUEST_METHOD"] === $configEditForm['config']['method']) {
            $errors = MenuValidator::checkMenuForm($_POST);
            if (empty($errors)) {
                // Verif des champs
                $menu = new Menu();
                $menu->setId_menu($id);
                $menu->setName(helpers::specialChars($_POST["name"]));
                $menu->setPosition($menuInfo['position']);

                // Sauvegarde dans la table menu
                (new MenuManager())->save($menu);

                // Redirection sur la liste du menu
                header("Location: " . helpers::getUrl("menu", "list"));
                // Die pour stoper la suite de la fonction
                die();
            }
        }
        $view = new View("menuEdit");
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
        $view->assign("menuInfo", $menuInfo);
        $view->assign("configEditForm", $configEditForm);
        if (isset($errors)) {
            $view->assign('errors', $errors);
        }
    }

    public function listAction()
    {
        $title = 'Menu liste';
        $tabName = 'MENU';
        // Récupération de tous les onglet dans la taéble menu puis crée un tableau ou la clef correspond à l'id présent de bdd
        $menus = (new Menu())->getAllByPos();

        $view = new View('menuList');
        $view->assign("tabName", $tabName);
        $view->assign("title", $title);
        $view->assign('menus', $menus);
    }

    public function modifyPositionAction()
    {
        $pos = $_GET['pos'];
        $up = $_GET['up'];
        $menu = new Menu();
        $menuManager = new MenuManager();
        // Recup des infos du menu
        $tabToUpdate = $menuManager->getIdMenuByPos($pos);

        // Si le menu à modifier est le dernier ou le premier, alors on retourne directement à la liste
        if ((count($menu->getAll()) == $tabToUpdate['position'] && $up === 'true') ||
            ($up === 'false' && $tabToUpdate['position'] === '1'))
        {
            header("Location: " . helpers::getUrl("menu", "list"));
            die();
        }

        $change = $up === 'true' ? 1 : -1;

        //var_dump($change);die();
        $tabToUpdateAfter = $menuManager->getIdMenuByPos($tabToUpdate['position']+$change);

        $menu->setId_menu($tabToUpdate['id_menu']);
        $menu->setName($tabToUpdate['name']);
        $menu->setPosition($tabToUpdate['position']+$change);

        $menuManager->save($menu);

        $menu->setId_menu($tabToUpdateAfter['id_menu']);
        $menu->setName($tabToUpdateAfter['name']);
        $menu->setPosition($tabToUpdateAfter['position']+($change*-1));

        $menuManager->save($menu);

        header("Location: " . helpers::getUrl("menu", "list"));
        die();
    }
}