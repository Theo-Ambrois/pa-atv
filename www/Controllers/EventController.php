<?php

use Pa\Core\View;
use Pa\Models\Events;
use Pa\Core\Validator\EventValidator;
use Pa\Core\helpers;
use Pa\Managers\EventManager;

class EventController
{

    static $title = "Evénement";
    static $tabName = "EVENEMENT";


    public function defaultAction()
    {
        $events = (new EventManager())->getAll();

        $myView = new View("eventList", "back");
        $myView->assign("title", self::$title);
        $myView->assign("tabName", self::$tabName);
        $myView->assign("events", $events);
    }

    public function createAction() 
    {
        $title = "Création d'un événement";
        $configEventCreateForm = Events::getEventCreateForm();

        // si la méthode est post, ça veut dire qu'un formulaire est envoyé, on rentre dans la boucle pour les vérifs
        if($_SERVER["REQUEST_METHOD"] == $configEventCreateForm['config']['method']){
            // méthode du validator pour vérifier le formulaire de créatiçon d'event
            $errors = EventValidator::checkEventForm($configEventCreateForm, $_POST);
            
            if(empty($errors)) {
                //création d'un event
                $event = new Events();
                $event->setEvent_Name(helpers::specialChars($_POST["event_name"]));
                $event->setDescription(helpers::specialChars($_POST["description"]));
                $event->setPlace(helpers::specialChars($_POST["place"]));
                $event->setDate_Start($_POST["date_start"]);
                $event->setDate_End($_POST["date_end"]);

                (new EventManager())->save($event);
                
                // redirection vers la liste des events
                header("Location: " . helpers::getUrl("event", "default"));
            }

        }

        $myView = new View("createEvent", "back");
        $myView->assign("title", $title);
        $myView->assign("tabName", self::$tabName);
        $myView->assign("configEventCreateForm", $configEventCreateForm);
        if (isset($errors)) $myView->assign("errors", $errors);
        
    }

    public function showAction()
    {
        // récupère l'event par son id dans l'url
        $event = (new Events())->getEventById($_GET['id']);
        
        //calcul de la durée de l'événement
        $duration = abs(strtotime($event["date_start"]) - strtotime($event["date_end"]));
        $day = floor($duration / 86400);
        $hour = floor(($duration % 86400) / 3600);
        $min = str_pad(($duration % 3600) / 60, 2, 0, STR_PAD_LEFT);
        if ($day == 0) {
            $formatedDuration = $hour . "h" . $min . "m";
        } else {
            $hour = str_pad($hour, 2, 0, STR_PAD_LEFT);
            $formatedDuration = $day . "j" . $hour . "h" . $min . "m";
        }
        

        // on crée 2 variables, l'une qui contient année, jour et mois, l'autre qui contient heure, minute et seconde
        $dateTime = explode(" ", $event["date_start"]);
        $date = explode("-", $dateTime[0]);
        $time = explode(":", $dateTime[1]);

        $myView = new View('eventShow', 'back');
        $myView->assign("title", self::$title);
        $myView->assign("tabName", self::$tabName);
        $myView->assign('event', $event);
        $myView->assign('formatedDuration', $formatedDuration);
        $myView->assign('date', $date);
        $myView->assign('time', $time);
    }

    public function editAction()
    {
        $title = "Modification d'un événement";

        // récupère les données de l'event via l'id dans l'url
        $eventData = (new Events())->getEventById($_GET['id']);
        // on remplace l'espace par un T pour convertir la string en datetime-local
        $eventData["date_start"] = str_replace(" ", "T", $eventData["date_start"]);
        $eventData["date_end"] = str_replace(" ", "T", $eventData["date_end"]);
        
        // récupère le formulaire
        $configEventEditForm = Events::getEventEditForm($_GET['id']);

        // Si on accede a l'url avec un post, on met à jour la table pages avec les infos contenue dans le $_POST
        if ($_SERVER["REQUEST_METHOD"] == $configEventEditForm['config']['method']) {

            // méthode du validator pour vérifier le formulaire de créatiçon d'event
            $errors = EventValidator::checkEventForm($configEventEditForm, $_POST);

            if(empty($errors)) {
                
                $event = new Events();
                $event->setId_event($eventData['id_event']);
                $event->setEvent_Name(helpers::specialChars($_POST["event_name"]));
                $event->setDescription(helpers::specialChars($_POST["description"]));
                $event->setPlace(helpers::specialChars($_POST["place"]));
                $event->setDate_Start($_POST["date_start"]);
                $event->setDate_End($_POST["date_end"]);

                (new EventManager())->save($event);

                // redirection vers la liste des events
                header("Location: " . helpers::getUrl('event', 'show', ['id'=>$eventData['id_event']]));
            }
        }

        $myView = new View('eventEdit', "back");
        $myView->assign("title", $title);
        $myView->assign("tabName", self::$tabName);
        $myView->assign("eventData", $eventData);
        $myView->assign("configEventEditForm", $configEventEditForm);
        if (isset($errors)) $myView->assign("errors", $errors);
    }

    public function deleteAction()
    {
        // récupère les données de l'event via l'id dans l'url
        $eventData = (new Events())->getEventById($_GET['id']);
        // supprime l'event en bdd via l'id
        (new EventManager())->delete($eventData['id_event'], 'id_event');
        // redirection vers la liste des events
        header("Location: ".helpers::getUrl("event", "default"));
    }

}