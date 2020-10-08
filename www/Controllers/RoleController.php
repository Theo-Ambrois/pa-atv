<?php
use Pa\Core\View;
use Pa\Managers\RoleManager;
use Pa\Models\Roles;
use Pa\Core\Validator\RoleValidator;
use Pa\Core\helpers;

class RoleController
{
    /**
     * Création d'un role
     */
    public function createAction()
    {
        $title = "Création d'un role";
        $tabName = "ROLE";
        // Form de création d'un role
        $configFormRole = roles::createForm();

        // Si on accede a l'url avec un post, on sauvegarde la table roles avec les infos contenue dans le $_POST
        if ($_SERVER["REQUEST_METHOD"] === $configFormRole['config']['method']) {

            $errors = RoleValidator::checkCreateForm($configFormRole, $_POST);

            if(empty($errors)) {
                // On récupère l'intégralité des valeurs représentant les authorisations du role
                $auth = $this->getAuthValue($_POST);
                $role = new Roles();
                $role->setGroup_name(helpers::specialChars($_POST['group_name']));
                $role->setPlanning($auth["planning"]);
                $role->setDocument($auth["document"]);
                $role->setEvent($auth["event"]);
                $role->setMark($auth["mark"]);
                $role->setRole($auth["role"]);
                $role->setUser($auth["user"]);
                $role->setPage($auth['page']);

                $roleManager = new RoleManager();
                $roleManager->save($role);

                // Redirection vers la liste des roles
                header("Location: " . helpers::getUrl("role", "list"));
            }
        }

        $view = new View("createRole");
        $view->assign("configFormRole", $configFormRole);
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
        if (isset($errors)) $view->assign("errors", $errors);
    }

    /**
     * Suppression d'un role
     */
    public function removeAction()
    {
        if ($_GET['id'] !== '1') {
            $roleManager = new RoleManager();
            // Suppression du role par son id
            $roleManager->delete($_GET['id'], 'id_role');
        }
        // Redirection pour mettre à jour la liste
        header("Location: " . helpers::getUrl("role", "list"));
        die();
    }

    /**
     * Modification d'un rôle
     */
    public function editAction()
    {
        if ($_GET['id'] === '1') {
            // Redirige vers la liste des roles
            header("Location: " . helpers::getUrl("role", "list"));
            // Die pour ne pas executer le reste de la fonction
            die();
        }

        $title = "Role";
        $tabName = "ROLE";

        $configFormRole = roles::editForm($_GET['id']);

        // Si on accede a l'url avec un post, on met à jour la table roles avec les infos contenue dans le $_POST
        if ($_SERVER["REQUEST_METHOD"] === $configFormRole['config']['method']) {

            $errors = RoleValidator::checkEditForm($configFormRole, $_POST);
            if(empty($errors)) {
                // On récupère l'intégralité des valeurs représentant les authorisations du role
                $auth = $this->getAuthValue($_POST);
                $role = new Roles();
                $role->setGroup_name(helpers::specialChars($_POST['group_name']));
                $role->setId_role($_GET['id']);

                $role->setPlanning($auth["planning"]);
                $role->setDocument($auth["document"]);
                $role->setEvent($auth["event"]);
                $role->setMark($auth["mark"]);
                $role->setRole($auth["role"]);
                $role->setUser($auth["user"]);
                $role->setPage($auth['page']);

                $roleManager = new RoleManager();
                $roleManager->save($role);

                // Redirection vers la liste des roles
                header("Location: " . helpers::getUrl("role", "list"));
                die();
            }
        }

        $roleManager = new RoleManager();
        // On recupère les infos concernant le roles pour pouvoir pré-remplir la page d'édition
        $roleInfo = $roleManager->getRoleInfo($_GET['id']);
        $roleName = $roleInfo['group_name'];
        $roleInfo = helpers::getAuth($roleInfo);
        $roleInfo['group_name'] = $roleName;

        $view = new View("editRole");
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
        $view->assign('roleInfo', $roleInfo);
        $view->assign('configFormRole', $configFormRole);
        if (isset($errors)) $view->assign("errors", $errors);
    }

    /**
     * Liste tous les roles présent en bdd
     */
    public function listAction()
    {
        $title = "Role";
        $tabName = "ROLE";

        // Récupère l'intégralité des roles et les dispose dans un tableau ou la clef correspond à l'id présent en bdd
        $allRoles = (new RoleManager)->getRoles();
        $roles = [];
        foreach ($allRoles as $r) {
            $roles[$r->getId()] = $r->getGroup_name();
        }

        $view = new View("role");
        $view->assign("roles", $roles);
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
    }

    /**
     * @param $params
     * @return int[]
     * Methode renvoyant un tableau contenant la valeur d'authorisation pour chaque champ
     */
    private function getAuthValue($params)
    {
        $planning = 0;
        $user = 0;
        $document = 0;
        $event = 0;
        $role = 0;
        $mark = 0;
        $page = 0;

        /**
         * create = 1
         * read = 2
         * update = 4
         * delete = 8
         * La valeur peut aller de 1 à 15
         * Pour chaque cas, on ajoute la valeur de l'authorisation dans la variable correspondant. Elle sera retourné
         * à la fin.
         */
        foreach ($params as $k => $v) {
            switch ($k) {
                // PLANNING
                case 'planning_create':
                    $planning += 1;
                    break;
                case 'planning_read':
                    $planning += 2;
                    break;
                case 'planning_update':
                    $planning += 4;
                    break;
                case 'planning_delete':
                    $planning += 8;
                    break;

                // MARK
                case 'mark_create':
                    $mark += 1;
                    break;
                case 'mark_read':
                    $mark += 2;
                    break;
                case 'mark_update':
                    $mark += 4;
                    break;
                case 'mark_delete':
                    $mark += 8;
                    break;

                // USER
                case 'user_create':
                    $user += 1;
                    break;
                case 'user_read':
                    $user += 2;
                    break;
                case 'user_update':
                    $user += 4;
                    break;
                case 'user_delete':
                    $user += 8;
                    break;

                // DOCUMENT
                case 'document_create':
                    $document += 1;
                    break;
                case 'document_read':
                    $document += 2;
                    break;
                case 'document_update':
                    $document += 4;
                    break;
                case 'document_delete':
                    $document += 8;
                    break;

                // EVENT
                case 'event_create':
                    $event += 1;
                    break;
                case 'event_read':
                    $event += 2;
                    break;
                case 'event_update':
                    $event += 4;
                    break;
                case 'event_delete':
                    $event += 8;
                    break;

                // ROLE
                case 'role_create':
                    $role += 1;
                    break;
                case 'role_read':
                    $role += 2;
                    break;
                case 'role_update':
                    $role += 4;
                    break;
                case 'role_delete':
                    $role += 8;
                    break;

                // PAGE
                case 'page_create':
                    $page += 1;
                    break;
                case 'page_read':
                    $page += 2;
                    break;
                case 'page_update':
                    $page += 4;
                    break;
                case 'page_delete':
                    $page += 8;
                    break;
            }
        }

        return [
            "planning" => $planning,
            "mark" => $mark,
            "user" => $user,
            "document" => $document,
            "event" => $event,
            "role" => $role,
            "page" => $page
        ];
    }

}