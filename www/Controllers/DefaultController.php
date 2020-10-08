<?php

use Pa\Core\QueryBuilder;
use Pa\Core\View;

class DefaultController
{
    public function __construct()
    {

    }

    public function defaultAction()
    {
        $title = "Dashboard";
        $tabName = "DASHBOARD";

        /**
         * Compte le nb d'users/documents/events/roles présent en bdd
         */
        $users = (new QueryBuilder())->count()->from('users', 'u')->getQuery()->getOneOrNull();
        $documents = (new QueryBuilder())->count()->from('documents', 'd')->getQuery()->getOneOrNull();
        $events = (new QueryBuilder())->count()->from('events', 'e')->getQuery()->getOneOrNull();
        $roles = (new QueryBuilder())->count()->from('roles', 'r')->getQuery()->getOneOrNull();

        /**
         * Récupère en bdd toutes les entrées comprise dans l'intervale de la requête
         */
        $eventsNb = (new QueryBuilder())->select('e.*')
            ->from('events', 'e')
            ->where('date_start >= DATE_ADD(now(), INTERVAL -7 DAY)')->getQuery()->getArray();
        $registerNb = (new QueryBuilder())->select('u.*')
            ->from('users', 'u')
            ->where('date_inserted >= DATE_ADD(now(), INTERVAL -1 YEAR)')->getQuery()->getArray();
        $documentsNb = (new QueryBuilder())->select('d.*')
            ->from('documents', 'd')
            ->where('date_inserted >= DATE_ADD(now(), INTERVAL -30 DAY)')->getQuery()->getArray();

        /**
         * Retourne un tableau utilisable par chartJs pour affiché le nb d'inscriptions, de documents et d'events
         */
        $documentsNb = $this->countDocuments($documentsNb);
        $registerNb = $this->countRegister($registerNb);
        $eventsNb = $this->countEvents($eventsNb);

        //View dashboard sur le template back
        $myView = new View("dashboard");
        $myView->assign("title", $title);
        $myView->assign("tabName", $tabName);
        $myView->assign('users', $users[0]);
        $myView->assign('documents', $documents[0]);
        $myView->assign('events', $events[0]);
        $myView->assign('roles', $roles[0]);
        $myView->assign('eventsNb', $eventsNb);
        $myView->assign('registerNb', $registerNb);
        $myView->assign('documentsNb', $documentsNb);

    }

    /**
     * @param $events
     * @return array
     * Compte le nb d'event
     */
    private function countEvents($events)
    {
        $nb = [];
        // Crée un tableau composé uniquement des dates d'insertion
        $events = array_column($events, 'date_start');
        // Boucle pour remplir chaque jour
        for ($i = 1 ; $i < 8 ; $i++) {
            $count = 0;
            // La date du jour moin i jours
            $time = date('Y-m-d', strtotime("-" . $i . "day"));
            // Vérif pour chaque inscription si la date d'insertion correspond a la date du jour moin i
            foreach ($events as $event) {
                $eventTime = substr($event, 0, 10);
                if ($eventTime === $time) {
                    $count++;
                }
            }
            $nb[$i - 1] = $count;
        }
        return $nb;
    }

    /**
     * @param $registers
     * @return array
     * Compte le nombre d'inscription
     */
    private function countRegister($registers)
    {
        $nb = [];
        // Crée un tableau composé uniquement des dates d'insertion
        $register = array_column($registers, 'date_inserted');
        // Boucle pour remplir chaque mois
        for ($i = 0 ; $i < 12 ; $i++) {
            $count = 0;
            // La date du jour moin i mois
            $time = date('Y-m', strtotime("-" . $i . "month"));
            // Récupère le numéro du mois pour l'utiliser comme index
            $index = substr($time, 5, 2);
            // Vérif pour chaque inscription si la date d'insertion correspond a la date du mois moin i
            foreach ($register as $r) {
                $registerTime = substr($r, 0, 7);
                if ($time === $registerTime) {
                    $count++;
                }
            }
        $nb[$index] = $count;
        }
        // Tri le tableau par le numéro de ses clef
        ksort($nb);
        return $nb;
    }

    /**
     * @param $documents
     * @return array
     * Compte le nb de documents
     */
    private function countDocuments($documents)
    {
        $nb = [];
        // Crée un tableau composé uniquement des dates d'insertion
        $document = array_column($documents, 'date_inserted');
        // Boucle pour remplir chaque jour
        for ($i = 0 ; $i < 30 ; $i++) {
            $count = 0;
            // La date du jour moin i jours
            $time = date('Y-m-d', strtotime("-" . $i . "day"));
            // Vérif pour chaque document si la date d'insertion correspond a la date du jour moin i
            foreach ($document as $d) {
                $documentTime = substr($d, 0, 10);
                if ($time === $documentTime) {
                    $count++;
                }
            }
            $nb[$i - 1] = $count;
        }
        return $nb;
    }
}