<?php


use Pa\Core\helpers;
use Pa\Core\Validator\PlanningValidator;
use Pa\Core\View;
use Pa\Managers\Planning_RoleManager;
use Pa\Managers\PlanningManager;
use Pa\Models\Planning_Role;
use Pa\Models\Plannings;

class PlanningController
{
    /**
     * Création d'un planning
     */
    public function createAction()
    {
        $title = 'Créer un planning';
        $tabName = 'Planning';
        // Recup le form de création
        $configForm = Plannings::getCreateForm();

        if($_SERVER["REQUEST_METHOD"] === $configForm['config']['method']) {
            //vérif des champs pour éviter les fraudes
            $errors = PlanningValidator::checkPlanningForm($configForm, $_POST);
            if (empty($errors)) {
                $planning = new Plannings();

                $planning->setName(helpers::specialChars($_POST["name"]));
                $planning->setDate_end($_POST["date_end"]);
                $planning->setDate_start($_POST["date_start"]);

                // Sauvegarde dans la tables plannings
                $planningManager = new PlanningManager();
                $planningManager->save($planning);

                // Sauvegarde dans la table de liaison planning/role
                $planningId = $planningManager->getPlanningId($planning->getName());
                $planning_role = new Planning_Role();
                $planning_role->setIdRole($_POST['role']);
                $planning_role->setIdPlanning($planningId);

                (new Planning_RoleManager())->save($planning_role);

                // Redirection sur la liste des plannings
                header("Location: " . helpers::getUrl("planning", "list"));
                // Die pour stoper la suite de la fonction
                die();
            }
        }
        $view = new View("planningCreate");
        $view->assign('title', $title);
        $view->assign('tabName', $tabName);
        $view->assign('configForm', $configForm);
        if (isset($errors)){
            $view->assign('errors', $errors);
        }
    }

    /**
     * Suppression d'un planning
     */
    public function removeAction()
    {
        // Suppression d'un planning par son id
        (new PlanningManager())->delete($_GET['id'], 'id_planning');

        // Redirection pour mettre à jour la liste
        header("Location: " . helpers::getUrl("planning", "list"));
    }

    /**
     * Edition d'un planning
     */
    public function editAction()
    {
        $title = 'Créer un planning';
        $tabName = 'Planning';

        $planningManager = new PlanningManager();
        // Recup des infos du planning
        $planningInfo = $planningManager->getPlanningInfo($_GET['id']);
        // Recup le role de l'id lié au planning
        $planningRoleId = $planningManager->getPlanningRoleId($_GET['id']);

        // Recuo du form d'édition
        $configEditPlanningForm = plannings::getEditForm($_GET['id'], $planningRoleId);

        // Si on accede a l'url avec un post, on modifie la table planning avec les infos contenue dans le $_POST
        if ($_SERVER["REQUEST_METHOD"] === $configEditPlanningForm['config']['method']) {
            // Verif des champs
            $errors = PlanningValidator::checkPlanningForm($configEditPlanningForm, $_POST);
            if (empty($errors)) {
                $planning = new Plannings();
                $planning->setId_planning($_GET['id']);
                $planning->setName(helpers::specialChars($_POST["name"]));
                $planning->setDate_end($_POST["date_end"]);
                $planning->setDate_start($_POST["date_start"]);

                // Sauvegarde dans la tables plannings
                $planningManager = new PlanningManager();
                $planningManager->save($planning);

                // Suppression de la liaison pour la recréer juste après
                $planning_roleManager = new Planning_RoleManager();
                $planning_roleManager->delete($_GET['id'], 'idPlanning');

                $planning_role = new Planning_Role();
                $planning_role->setIdRole($_POST['role']);
                $planning_role->setIdPlanning($_GET['id']);

                (new Planning_RoleManager())->save($planning_role);

                // Redirection sur la liste des plannings
                header("Location: " . helpers::getUrl("planning", "list"));
                // Die pour stoper la suite de la fonction
                die();
            }
        }
        $view = new View("planningEdit");
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
        $view->assign("planningInfo", $planningInfo);
        $view->assign("configEditPlanningForm", $configEditPlanningForm);
        if (isset($errors)) {
            $view->assign('errors', $errors);
        }
    }

    /**
     * Affiche le planning et tous les cours lié
     */
    public function showAction()
    {
        $title = 'Planning';
        $tabName = 'Planning';

        // Récup de tous les cours
        $courses = (new PlanningManager())->getAllCourses($_GET['id']);

        $events = (new PlanningManager())->getAllEventsInsidePlanningRange($_GET['id']);

        $view = new View('planningShow');
        $view->assign('title', $title);
        $view->assign('tabName', $tabName);
        $view->assign('courses', $courses);
        $view->assign('events', $events);
    }

    /**
     * Liste les plannings
     */
    public function listAction()
    {
        $title = 'Planning';
        $tabName = 'Planning';

        // Récup tous les plannings
        $plannings = (new PlanningManager())->getPlannings();

        $view = new View("planningList");
        $view->assign("plannings", $plannings);
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
    }

}