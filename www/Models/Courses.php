<?php
namespace Pa\Models;

use Pa\Core\helpers;

class Courses extends Model
{
    protected $id_course;
    protected $matiere;
    protected $teacher;
    protected $date_start;
    protected $date_end;
    protected $idPlanning;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id_course;
    }

    /**
     * @param mixed $id_course
     */
    public function setId_course($id_course): void
    {
        $this->id_course = $id_course;
    }

    /**
     * @return mixed
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * @param mixed $matiere
     */
    public function setMatiere($matiere): void
    {
        $this->matiere = $matiere;
    }

    /**
     * @return mixed
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param mixed $teacher
     */
    public function setTeacher($teacher): void
    {
        $this->teacher = $teacher;
    }

    /**
     * @return mixed
     */
    public function getDate_start()
    {
        return $this->date_start;
    }

    /**
     * @param mixed $date_start
     */
    public function setDate_start($date_start): void
    {
        $this->date_start = $date_start;
    }

    /**
     * @return mixed
     */
    public function getDate_end()
    {
        return $this->date_end;
    }

    /**
     * @param mixed $date_end
     */
    public function setDate_end($date_end): void
    {
        $this->date_end = $date_end;
    }

    /**
     * @return mixed
     */
    public function getIdPlanning()
    {
        return $this->idPlanning;
    }

    /**
     * @param mixed $idPlanning
     */
    public function setIdPlanning($idPlanning): void
    {
        $this->idPlanning = $idPlanning;
    }


    public static function getCreateForm()
    {
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("course", "create"),
                "class"=>"course",
                "id"=>"formCreateCourse",
                "submit"=>"Créer"
            ],

            "fields"=>[
                "planning" => [
                    "type"=>"select",
                    "class"=>'input',
                    "options"=>Plannings::getAll(),
                    "id"=>"planningSelect",
                    "required"=>true,
                    "errorMsg"=>"Le planning séléctionné n'est pas valide."
                ],

                "matiere"=>[
                    "type"=>"text",
                    "placeholder"=>"Nom de la matière",
                    "class"=>"form",
                    "id"=>"matiere",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>50,
                    "errorMsg"=>"La matiere doit être compris en 2 et 50 caractères."
                ],

                "teacher"=>[
                    "type"=>"text",
                    "placeholder"=>"Nom du professeur",
                    "class"=>"form",
                    "id"=>"prof",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>50,
                    "errorMsg"=>"Le nom du professeur doit être compris en 2 et 50 caractères."
                ],

                "date_start"=> [
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

    /**
     * @param $id
     * @param $idPlanning
     * @return array
     */
    public static function getEditForm($id, $idPlanning)
    {
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("course", "edit", ['id'=>$id]),
                "class"=>"course",
                "id"=>"formEditCourse",
                "submit"=>"Modifier"
            ],

            "fields"=>[
                "planning" => [
                    "type"=>"select",
                    "class"=>'input',
                    "options"=>Plannings::getAll($idPlanning),
                    "id"=>"planningSelect",
                    "required"=>true,
                    "errorMsg"=>"Le planning séléctionné n'est pas valide."
                ],

                "matiere"=>[
                    "type"=>"text",
                    "placeholder"=>"Nom de la matière",
                    "class"=>"form",
                    "id"=>"matiere",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>50,
                    "errorMsg"=>"La matiere doit être compris en 2 et 50 caractères."
                ],

                "teacher"=>[
                    "type"=>"text",
                    "placeholder"=>"Nom du professeur",
                    "class"=>"form",
                    "id"=>"prof",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>50,
                    "errorMsg"=>"Le nom du professeur doit être compris en 2 et 50 caractères."
                ],

                "date_start"=> [
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