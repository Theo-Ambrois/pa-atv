<?php

namespace Pa\Models;

use Pa\Core\helpers;
use Pa\Managers\EventManager;

class Events extends Model
{
    protected $id_event;
    protected $event_name;
    protected $description;
    protected $place;
    protected $date_start;
    protected $date_end;
    
    /** SETTER & GETTER */
    public function setId_event($id)
    {
        $this->id_event = $id;
    }

    public function getId()
    {
        return $this->id_event;
    }
    /**
     * @return mixed
     */
    public function getEvent_Name()
    {
        return $this->event_name;
    }

    /**
     * @param mixed $event_name
     */
    public function setEvent_Name($event_name): void
    {
        $this->event_name = $event_name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param mixed $place
     */
    public function setPlace($place): void
    {
        $this->place = $place;
    }

    /**
     * @return mixed
     */
    public function getDate_Start()
    {
        return $this->date_start;
    }

    /**
     * @param mixed $date_start
     */
    public function setDate_Start($date_start): void
    {
        $this->date_start = $date_start;
    }

    /**
     * @return mixed
     */
    public function getDate_End()
    {
        return $this->date_end;
    }

    /**
     * @param mixed $date_end
     */
    public function setDate_End($date_end): void
    {
        $this->date_end = $date_end;
    }

    public function getEventById($id)
    {
        $event = (new EventManager())->findBy(['id_event'=>$id]);
       return $event[0];
    }

    /**
     * @return array
     * Formulaire de création d'evenement
     */
    public static function getEventCreateForm(){
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("event", "create"),
                "class"=>"event",
                "id"=>"eventForm",
                "submit"=>"Créer"
            ],

            "fields"=>[

                "event_name"=>[
                    "type"=>"text",
                    "placeholder"=>"Saisissez le titre",
                    "class"=>"form",
                    "id"=>"formTitle",
                    "required"=>true,
                    "min-length"=>3,
                    "max-length"=>150,
                    "lengthErrorMsg"=>"Le titre doit contenir entre 3 et 150 caractères"
                ],

                "description"=>[
                    "type"=>"text",
                    "placeholder"=>"Saisissez la description",
                    "class"=>"form",
                    "id"=>"formDescription",
                    "required"=>false,
                    "min-length"=>3,
                    "max-length"=>500,
                    "lengthErrorMsg"=>"La description doit contenir entre 3 et 500 caractères"
                ],

                "place"=>[
                    "type"=>"text",
                    "placeholder"=>"Saisissez le lieu",
                    "class"=>"form",
                    "id"=>"formPlace",
                    "required"=>true,
                    "min-length"=>3,
                    "max-length"=>150,
                    "lengthErrorMsg"=>"Le lieu doit contenir entre 3 et 150 caractères"
                ],

                "date_start"=>[
                    "type"=>"datetime-local",
                    "class"=>"form",
                    "id"=>"formDateStart",
                    "required"=>true
                ],

                "date_end"=>[
                    "type"=>"datetime-local",
                    "class"=>"form",
                    "id"=>"formDateEnd",
                    "required"=>true,
                    "dateErrorMsg"=>"La date de fin doit être postérieure à la date de début"
                ]
            ]

        ];
    }

    public static function getEventEditForm($id){
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("event", "edit", ['id'=>$id]),
                "class"=>"event",
                "id"=>"eventForm",
                "submit"=>"Modifier"
            ],

            "fields"=>[

                "event_name"=>[
                    "type"=>"text",
                    "placeholder"=>"Saisissez le titre",
                    "class"=>"form",
                    "id"=>"formTitle",
                    "required"=>true,
                    "min-length"=>3,
                    "max-length"=>150,
                    "lengthErrorMsg"=>"Le titre doit contenir entre 3 et 150 caractères"
                ],

                "description"=>[
                    "type"=>"text",
                    "placeholder"=>"Saisissez la description",
                    "class"=>"form",
                    "id"=>"formDescription",
                    "required"=>false,
                    "min-length"=>3,
                    "max-length"=>500,
                    "lengthErrorMsg"=>"La description doit contenir entre 3 et 500 caractères"
                ],

                "place"=>[
                    "type"=>"text",
                    "placeholder"=>"Saisissez le lieu",
                    "class"=>"form",
                    "id"=>"formPlace",
                    "required"=>true,
                    "min-length"=>3,
                    "max-length"=>150,
                    "lengthErrorMsg"=>"Le lieu doit contenir entre 3 et 150 caractères"
                ],

                "date_start"=>[
                    "type"=>"datetime-local",
                    "class"=>"form",
                    "id"=>"formDateStart",
                    "required"=>true
                ],

                "date_end"=>[
                    "type"=>"datetime-local",
                    "class"=>"form",
                    "id"=>"formDateEnd",
                    "required"=>true,
                    "dateErrorMsg"=>"La date de fin doit être postérieure à la date de début"
                ]
            ]

        ];
    }
}
