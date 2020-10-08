<?php
namespace Pa\Managers;

use Pa\Core\Manager;
use Pa\Core\QueryBuilder;
use Pa\Models\Marks;

/**
 * Class MarkManager
 * @package Pa\Managers
 */
class MarkManager extends Manager
{
    /**
     * MarkManager constructor.
     * Appelle le constructeur parent
     */
	public function __construct() {
        
		parent::__construct(Marks::class, 'marks');
	}

    /**
     * @param string $login
     * Recupère le(s) role d'un utilisateur
     */
    public function getUserMarkByLogin(string $login)
    {
        $mark = (new QueryBuilder())->select('m.*')
                                    ->from('marks', 'm')
                                    ->join('user_has_mark', 'uhm', 'm', 'id_mark', 'idMark')
                                    ->join('users', 'u', 'uhm', 'idUser', 'id_user')
                                    ->where('u.login = :login')
                                    ->setParameter('login', $login)
                                    ->getQuery()
                                    ->getArray();
        return $mark[0];
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

	public function getMark() {
        $mark = $this->findBy(["id"=>$id]);
        return ($mark);
	}

    public function getAll()
    {
        return $this->findAll();
    }

    /**
     * @param $id
     * @return mixed
     * Récupère les infos d'une note
     */
    public function getMarkInfo($id)
    {
        $mark = $this->findBy(['id_mark'=>$id]);
        return $mark[0];
    }

    /**
     * @param $name
     * @return mixed
     * Recup l'id d'une note par son nom
     */
    public function getMarkId($name)
    {
        $mark = $this->findBy(["name"=>$name]);
        //print_r($name);
        return $mark[0]['id_mark'];
    }

    public function getUserNameById($id)
    {
        
    }
}