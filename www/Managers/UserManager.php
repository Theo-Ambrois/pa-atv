<?php

namespace Pa\Managers;

use Pa\Core\Manager;
use Pa\Core\QueryBuilder;
use Pa\Models\Users;

/**
 * Class UserManager
 * @package Pa\Managers
 */
class UserManager extends Manager
{
    /**
     * UserManager constructor.
     * Appelle le construteur parent
     */
	public function __construct() {
		parent::__construct(Users::class, 'users');
	}

    /**
     * @param $login
     * @return mixed
     * Recupère l'id d'un utilisateur d'après son login
     */
	public function getUserId($login) {
        $user = $this->findBy(["login"=>$login]);
        return ($user[0]["id_user"]);
	}

    /**
     * @param $login
     * @return mixed
     * Recupère les infos d'un utilisateur
     */
	public function getUserInfo($login) {
	    $user = $this->findBy(["login"=>$login]);
	    return $user[0];
    }

    /**
     * @param $login
     * @param $password
     * @return bool
     * Recherche un utilisateur par son login et mot de passe pour verifier la connexion
     */
	public function login($login, $password) {
	    $pwd = sha1($password);
	    $user = $this->findBy(["login"=>$login, "password"=>$pwd]);
	    return empty($user) ? false : true;
    }

    /**
     * @return array
     * Récupère tous les utilisateurs
     */
    public function getUsers()
    {
        $allUsers = $this->findAll();
        $users = [];
        foreach ($allUsers as $user) {
            $users[$user->getId()] = $user->getFirstname() . ' ' . $user->getLastname();
        }
        return $users;
    }

    public function getListUsers()
    {
        return $this->findAll();
    }

    /**
     * @param $id
     * @return mixed
     * Recherche un utilisateur par son id
     */
    public function getUserById($id)
    {
        $user = $this->findBy(["id_user"=>$id]);
        return $user[0];
    }

    /**
     * @param $id
     * @return mixed
     * Recherche l'id du role de l'utilisateur grace a son id
     */
    public function getRoleIdByUserId($id)
    {
        $user = (new QueryBuilder())->select('uhr.idRole')
            ->from('user_has_role', 'uhr')
            ->where('uhr.idUser = :idUser')
            ->setParameter('idUser', $id)
            ->getQuery()
            ->getArray();
        return $user[0]['idRole'];
    }
}