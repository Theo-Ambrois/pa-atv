<?php

use Pa\Core\helpers;
use Pa\Core\Validator\CourseValidator;
use Pa\Core\View;
use Pa\Managers\CourseManager;
use Pa\Models\Courses;

class CourseController
{
    /**
     * Création d'un cours
     */
    public function createAction()
    {
        $title = 'Créer un cours';
        $tabName = 'Planning';
        // Récup du formulaire de création
        $configForm = courses::getCreateForm();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verif les données du formulaires
            $errors = CourseValidator::checkCourseForm($configForm, $_POST);
            // Si aucune erreur alors on peux créer le cours
            if (empty($errors)) {
                $course = new Courses();

                $course->setMatiere(helpers::specialChars($_POST['matiere']));
                $course->setTeacher(helpers::specialChars($_POST['teacher']));
                $course->setDate_start($_POST['date_start']);
                $course->setDate_end($_POST['date_end']);
                $course->setIdPlanning($_POST['planning']);

                (new CourseManager())->save($course);

                header("Location: " . helpers::getUrl("planning", "list"));
                // Die pour stoper la suite de la fonction
                die();
            }
        }

        $view = new View("courseCreate");
        $view->assign('title', $title);
        $view->assign('tabName', $tabName);
        $view->assign('configForm', $configForm);
        if (isset($errors)) $view->assign('errors', $errors);
    }

    /**
     * Suppression d'un cours
     */
    public function removeAction()
    {
        // Suppression d'un cours par son id
        (new CourseManager())->delete($_GET['id'], 'id_course');

        // Redirection vers les plannings
        header("Location: " . helpers::getUrl("planning", "list"));
    }

    /**
     * Edition d'un cours
     */
    public function editAction()
    {
        $title = 'Créer un cours';
        $tabName = 'Planning';
        // Récupération de l'id du planning
        $planningId = (new CourseManager())->getPlanningId($_GET['id']);
        // Récupération des infos du cours
        $courseInfo = (new CourseManager())->getInfo($_GET['id']);
        // Récup du formulaire d'édition
        $configForm = courses::getEditForm($_GET['id'], $planningId);
        // Remplace les espaces par des T pour affiché les infos correctement
        $courseInfo['date_start'] = str_replace(' ', 'T', $courseInfo['date_start']);
        $courseInfo['date_end'] = str_replace(' ', 'T', $courseInfo['date_end']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // verif des erreurs
            $errors = CourseValidator::checkCourseForm($configForm, $_POST, $_GET['id']);
            if (empty($errors)) {
                $course = new Courses();

                $course->setId_course($courseInfo['id_course']);
                $course->setMatiere(helpers::specialChars($_POST['matiere']));
                $course->setTeacher(helpers::specialChars($_POST['teacher']));
                $course->setDate_start($_POST['date_start']);
                $course->setDate_end($_POST['date_end']);
                $course->setIdPlanning($_POST['planning']);

                (new CourseManager())->save($course);

                header("Location: " . helpers::getUrl("planning", "list"));
                // Die pour stoper la suite de la fonction
                die();
            }
        }

        $view = new View("courseEdit");
        $view->assign('title', $title);
        $view->assign('tabName', $tabName);
        $view->assign('courseInfo', $courseInfo);
        $view->assign('configForm', $configForm);
        if (isset($errors)) $view->assign('errors', $errors);
    }
}