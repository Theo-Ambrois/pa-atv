<?php


namespace Pa\Models;


use Pa\Core\helpers;
use Pa\Managers\PlanningManager;

class Plannings extends Model
{
    protected $id_planning;
    protected $name;
    protected $date_start;
    protected $date_end;

    public function getId()
    {
        return $this->id_planning;
    }

    public function setId_planning($id)
    {
        $this->id_planning = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDate_start()
    {
        return $this->date_start;
    }

    public function setDate_start($date)
    {
        $this->date_start = $date;
        return $this;
    }

    public function getDate_end()
    {
        return $this->date_end;
    }

    public function setDate_end($date)
    {
        $this->date_end = $date;
        return $this;
    }

    /**
     * @param string $id
     * @return array
     * Retourne tous les plannings au format clef -> id du planning, valeur -> nom du planning
     * Si un id est donné, il mettra en première pos du tableau, le planning correspondant à cet id
     */
    public static function getAll($id = '')
    {
        $allPlannings = (new PlanningManager())->getAllPlannings();
        $plannings = [];
        if (isset($id['idPlanning']) && $id['idPlanning'] !== '') {
            foreach ($allPlannings as $p) {
                if ($p->getId() === $id['idPlanning']) {
                    $plannings[$id['idPlanning']] = $p->getName();
                }
            }
            foreach ($allPlannings as $p) {
                if ($p->getId() !== $id['idPlanning'])$plannings[$p->getId()] = $p->getName();
            }
        }else {
            foreach ($allPlannings as $p) {
                $plannings[$p->getId()] = $p->getName();
            }
        }
        return $plannings;
    }

    /**
     * @return array
     */
    public static function getCreateForm()
    {
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("planning", "create"),
                "class"=>"planning",
                "id"=>"formCreatePlanning",
                "submit"=>"Créer"
            ],

            "fields"=>[

                "role" => [
                    "type"=>"select",
                    "class"=>'input',
                    "options"=>Roles::getAll(),
                    "id"=>"exampleRoleSelect",
                    "required"=>true,
                    "errorMsg"=>"Le rôle séléctionné n'est pas valide."
                ],

                "name"=>[
                    "type"=>"text",
                    "placeholder"=>"Nom du planning",
                    "class"=>"form",
                    "id"=>"name",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>50,
                    "errorMsg"=>"Le nom doit être compris en 2 et 50 caractères."
                ],

                "date_start"=> [
                    "type"=>"date",
                    "class"=>"form",
                    "id"=>"formDateStart",
                    "required"=>true
                ],

                "date_end"=>[
                    "type"=>"date",
                    "class"=>"form",
                    "id"=>"formDateEnd",
                    "required"=>true,
                    "dateErrorMsg"=>"La date de fin doit être postérieure à la date de début"
                ]
            ]

        ];

    }

    /**
     * @param $id
     * @param string $idRole
     * @return array
     */
    public static function getEditForm($id, $idRole = '')
    {
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("planning", "edit", ['id'=>$id]),
                "class"=>"planning",
                "id"=>"formEditPlanning",
                "submit"=>"Modifier"
            ],

            "fields"=>[

                "role" => [
                    "type"=>"select",
                    "class"=>'input',
                    "options"=>Roles::getAll($idRole),
                    "id"=>"exampleRoleSelect",
                    "required"=>true,
                    "errorMsg"=>"Le rôle séléctionné n'est pas valide."
                ],

                "name"=>[
                    "type"=>"text",
                    "placeholder"=>"Nom du planning",
                    "class"=>"form",
                    "id"=>"name",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>50,
                    "errorMsg"=>"Le nom doit être compris en 2 et 50 caractères."
                ],

                "date_start"=> [
                    "type"=>"date",
                    "class"=>"form",
                    "id"=>"formDateStart",
                    "required"=>true
                ],

                "date_end"=>[
                    "type"=>"date",
                    "class"=>"form",
                    "id"=>"formDateEnd",
                    "required"=>true,
                    "dateErrorMsg"=>"La date de fin doit être postérieure à la date de début"
                ]
            ]

        ];

    }
}