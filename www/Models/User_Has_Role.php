<?php


namespace Pa\Models;


class User_Has_Role extends Model
{

    protected $id;
    protected $idUser;
    protected $idRole;


    /** SETTER & GETTER */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function setIdRole($idRole)
    {
        $this->idRole = $idRole;
        return $this;
    }

    /**
     * @return mixed
     * Ce getId() ne sert uniquement que pour la sauvegarde en bdd.
     * La table ne possède pas d'id mais la method save() necessite une methode getId()
     */
    public function getId()
    {
        return $this->id;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function getIdRole()
    {
        return $this->idRole;
    }

    /**
     * @param string $key
     * @return string|null
     * Recherche les relation avec les autres tables
     */
    public function getRelation(string $key): ?string
    {
        $relations = $this->initRelation();

        if (isset($relations[$key]))
            return $this->initRelation()[$key];

        return null;
    }

    /**
     * @return array|string[]
     * Initialise les relations avec les autres tables
     */
    public function initRelation()
    {
        // clef etrangère vers classe
        return [
            "idRole"=>Roles::class,
            "idUser"=>Users::class
        ];
    }
}