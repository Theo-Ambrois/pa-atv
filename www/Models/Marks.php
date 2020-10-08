<?php
namespace Pa\Models;

use Pa\Core\helpers;
use Pa\Managers\MarkManager;

class Marks extends Model
{
    protected $id_mark;
    protected $note;
    protected $matiere;
    protected $date;
    protected $coefficient;
    protected $name;
    protected $idUser;


    /** SETTER & GETTER */
    public function setId_mark($id)
    {
        $this->id_mark=$id;
        return $this;
    }
    public function getId()
    {
        return $this->id_mark;
    }
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }
    public function getNote()
    {
        return $this->note;
    }
    public function setMatiere($matiere)
    {
        $this->matiere=trim($matiere);
        return $this;
    }
    public function getMatiere()
    {
        return $this->matiere;
    }
    public function setDate($date)
    {
        $this->date=trim($date);
        return $this;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function setCoefficient($coefficient)
    {
        $this->coefficient=trim($coefficient);
        return $this;
    }
    public function getCoefficient()
    {
        return $this->coefficient;
    }
    public function setName($name)
    {
        $this->name=trim($name);
        return $this;
    }
    public function getName()
    {
        return $this->name;
    }

    public function setIdUser($idUser)
    {
        $this->idUser=$idUser;
        return $this;
    }
    public function getIduser()
    {
        return $this->idUser;
    }

    public function getAll()
    {
        $allMarks = (new MarkManager())->getAll();
        $marks = [];
        foreach ($allMarks as $m) {
            $marks[$m->getId()] = $m->getName();
        }
        return $marks;
    }

    /**
     * @param string $key
     * @return string|null
     * Recherche toute les relations de la table
     */
    public function getRelation(string $key): ?string
    {
        $relations = $this->initRelation();

        if(isset($relations[$key]))
            return $this->initRelation()[$key];

        return null;
    }

    /**
     * @return array
     * initialise la relation avec les autres tables
     */
    public function initRelation()
    {
        // clef etrangère vers classe
        return [];
    }


    /**
     * @return array
     * Formulaire de création d'une note
     */
    public static function createMarkForm(){
        return [

                "config"=>[
                    "method"=>"POST",
                    "action"=>helpers::getUrl("mark", "register"),
                    "class"=>"mark",
                    "id"=>"formRegisterMark",
                    "submit"=>"Rentrer une note"
                ],

                "fields"=>[

                    "note"=>[
                        "type"=>"text",
                        "placeholder"=>"Note",
                        "class"=>"input",
                        "id"=>"example",
                        "required"=>true,
                        "marksError"=>"Note non valide."
                    ],

                    "eleve" => [
                        "type"=>"select",
                        "class"=>'input',
                        "options"=>Users::getAll(),
                        "id"=>"exampleRoleSelect",
                        "required"=>true,
                        "studentError"=>"Eleve non valide."
                    ],

                    "matiere"=>[
                        "type"=>"text",
                        "placeholder"=>"Nom de la matiere",
                        "class"=>"input",
                        "id"=>"exampleMatiere",
                        "required"=>true,
                        "min-length"=>2,
                        "max-length"=>100,
                        "matierError"=>"Votre matiere doit être comprise en 2 et 100 caractères."
                    ],

                    "name"=>[
                        "type"=>"text",
                        "placeholder"=>"Nom de l'interrogation",
                        "class"=>"input",
                        "id"=>"exampleName",
                        "required"=>true,
                        "min-length"=>2,
                        "max-length"=>100,
                        "nameError"=>"Votre interrogation doit être compris en 2 et 100 caractères."
                    ],

                    "coefficient"=>[
                        "type"=>"text",
                        "placeholder"=>"Coeff de l'exam",
                        "class"=>"input",
                        "id"=>"exampleCoeff",
                        "required"=>true,
                        "authorized-characters"=> ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"],
                        "coeffError"=>"Votre coeff est invalide."
                    ],

                    "date"=>[
                        "type"=>"date",
                        "placeholder"=>"Date de l'examen",
                        "class"=>"input",
                        "id"=>"exampleDate",
                        "required"=>true,
                        "dateError"=>"Date invalide."
                    ]

                ]

                ];
    }

    /**
     * @return array
     * Formulaire de création d'une note
     */
    public static function EditMarkForm($id){
        return [

                "config"=>[
                    "method"=>"POST",
                    "action"=>helpers::getUrl("mark", "edit", ['id'=>$id]),
                    "class"=>"mark",
                    "id"=>"formRegisterMark",
                    "submit"=>"Rentrer une note"
                ],

                "fields"=>[

                    "note"=>[
                        "type"=>"text",
                        "placeholder"=>"Note",
                        "class"=>"input",
                        "id"=>"example",
                        "required"=>true,
                        "authorized-characters"=> ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"],
                        "errorMsg"=>"Note non valide."
                    ],

                    "eleve" => [
                        "type"=>"select",
                        "class"=>'input',
                        "options"=>Users::getAll(),
                        "id"=>"exampleRoleSelect",
                        "required"=>true,
                        "errorMsg"=>"Eleve non valide."
                    ],

                    "matiere"=>[
                        "type"=>"text",
                        "placeholder"=>"Nom de la matiere",
                        "class"=>"input",
                        "id"=>"exampleMatiere",
                        "required"=>true,
                        "min-length"=>2,
                        "max-length"=>100,
                        "errorMsg"=>"Votre matiere doit être comprise en 2 et 100 caractères."
                    ],

                    "name"=>[
                        "type"=>"text",
                        "placeholder"=>"Nom de l'interrogation",
                        "class"=>"input",
                        "id"=>"examplInterrolName",
                        "required"=>true,
                        "min-length"=>2,
                        "max-length"=>100,
                        "errorMsg"=>"Votre interro doit être compris en 2 et 100 caractères."
                    ],

                    "coefficient"=>[
                        "type"=>"text",
                        "placeholder"=>"Coeff de l'exam",
                        "class"=>"input",
                        "id"=>"exampleCoeff",
                        "required"=>true,
                        "authorized-characters"=> ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"],
                        "errorMsg"=>"Votre coeff est invalide."
                    ],

                    "date"=>[
                        "type"=>"date",
                        "placeholder"=>"Date de l'examen",
                        "class"=>"input",
                        "id"=>"exampleDate",
                        "required"=>true
                    ]

                ]

                ];
    }

}