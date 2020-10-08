<?php


namespace Pa\Models;


class Planning_Role extends Model
{
    protected $id;
    protected $idRole;
    protected $idPlanning;

    public function getId() {
        return $this->id;
    }
    /**
     * @return mixed
     */
    public function getIdRole()
    {
        return $this->idRole;
    }

    /**
     * @param mixed $idRole
     */
    public function setIdRole($idRole): void
    {
        $this->idRole = $idRole;
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
}