<?php

use Pa\Core\View;
use Pa\Managers\MarkManager;
use Pa\Managers\UserManager;
use Pa\Models\Users;
use Pa\Models\Marks;
use Pa\Models\User_Has_Mark;
use Pa\Managers\User_Has_MarkManager;
use Pa\Core\Validator\MarkValidator;
use Pa\Core\helpers;
use Pa\Core\QueryBuilder;

class MarkController
{
    /**
     * Création d'une note
     */
    public function createAction()
    {
        $title = "Création d'une note";
        $tabName = "MARK";
        // Form de création d'une note
        $configFormMark = marks::createMarkForm();

        // Si on accede a l'url avec un post, on sauvegarde la table mark avec les infos contenue dans le $_POST
        if ($_SERVER["REQUEST_METHOD"] === $configFormMark['config']['method']) {
            $errors = MarkValidator::checkMarkForm($configFormMark, $_POST);
            if(empty($errors)) {
            //$auth = $this->getAuthValue($_POST);
                $mark = new Marks();
                $mark->setNote(helpers::specialChars($_POST['note']));
                $mark->setCoefficient(helpers::specialChars($_POST["coefficient"]));
                $mark->setMatiere(helpers::specialChars($_POST["matiere"]));
                $mark->setName(helpers::specialChars($_POST["name"]));
                $mark->setDate($_POST["date"]);
                $mark->setIdUser($_POST["eleve"]);


                $markManager = new MarkManager();
                $markManager->save($mark);


                // Redirection vers la liste des notes
                header("Location: " . helpers::getUrl("mark", "list"));
                die();
            }

        }
        
        $view = new View("markCreate");
        $view->assign("configFormMark", $configFormMark);
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
        if (isset($errors)) {
            $view->assign('errors', $errors);
        }

    }

    /**
     * Suppression d'une note
     */
    public function removeAction()
    {
        $markManager = new MarkManager();
        // Suppression de la note par son id
        $markManager->delete($_GET['id'], 'id_mark');

        // Redirection pour mettre à jour la liste
        header("Location: " . helpers::getUrl("mark", "list"));
    }

    /**
     * Modification d'une note
     */
    public function editAction()
    {
        $title = "Editer note";
        $tabName = "MARK";
        $configMarkForm = Marks::editMarkForm($_GET['id']);

        // Si on accede a l'url avec un post, on met à jour la table note avec les infos contenue dans le $_POST
        if ($_SERVER["REQUEST_METHOD"] === $configMarkForm['config']['method']) {
            $errors = MarkValidator::checkMarkForm($configMarkForm, $_POST);
            if(empty($errors)) {
                $mark = new Marks();
                $mark->setId_mark($_GET['id']);
                $mark->setNote(helpers::specialChars($_POST['note']));
                $mark->setCoefficient(helpers::specialChars($_POST["coefficient"]));
                $mark->setMatiere(helpers::specialChars($_POST["matiere"]));
                $mark->setName(helpers::specialChars($_POST["name"]));
                $mark->setDate($_POST["date"]);
                $mark->setIdUser($_POST["eleve"]);

                $markManager = new MarkManager();
                $markManager->save($mark);

                // Redirection vers la liste des notes
                header("Location: " . helpers::getUrl("mark", "list"));
            }
        }

        $markManager = new MarkManager();
        $markInfo = $markManager->getMarkInfo($_GET['id']);
        

        $view = new View("markEdit");
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
        $view->assign('markInfo', $markInfo);
        $view->assign('configMarkForm', $configMarkForm);
        
        if (isset($errors)) {
            $view->assign('errors', $errors);
        }
    }

    /**
     * Liste toutes les notes présent en bdd
     */
    public function listAction()
    {
        $title = "Lister notes";
        $tabName = "MARK";


        // Récupère l'intégralité des note et les dispose dans un tableau ou la clef correspond à l'id présent en bdd
        $allMarks = (new MarkManager)->getAll();
        $marks = [];
        foreach ($allMarks as $m) {
            $userManager = (new UserManager)->getUserById($m->getIdUser());
            $marks[$m->getId()] = $userManager["firstname"] ." ". $userManager["lastname"] ." ".$m->getMatiere() ." ". $m->getName() ." ". $m->getNote() ." ". $m->getCoefficient() ." ". $m->getDate();
        }

        $view = new View("mark");
        $view->assign("marks", $marks);
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
    }

    public function ownAction(){
        $userInfo = (new UserManager())->getUserInfo($_COOKIE["login"]);
        $userInfo = (new QueryBuilder())->select('m.*')
                                        ->from('marks', 'm')
                                        ->where('idUser = :idUser')
                                        ->setParameter('idUser', $userInfo['id_user'])
                                        ->getQuery()
                                        ->getArray();

    $title = "Lister ses propres notes";
    $tabName = "MARK";

    $view = new View("ownMark");
    $view->assign("userInfo", $userInfo);
    $view->assign("title", $title);
    $view->assign("tabName", $tabName);
    }
}

