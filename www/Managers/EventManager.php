<?php 

namespace Pa\Managers;

use Pa\Core\Manager;
use Pa\Models\Events;
use Pa\Core\QueryBuilder;

class EventManager extends Manager {

    public function __construct()
    {
        parent::__construct(Events::class, 'events');
    }

    // retourne tous les events
    public function getAll()
    {
        return $this->findAll();
    }

    // retourne les infos d'un event
    public function getEventInfo($id) {
	    $user = $this->findBy(["id_event"=>$id]);
	    return $user[0];
    }

}
