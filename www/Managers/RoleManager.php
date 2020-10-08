<?php
namespace Pa\Managers;

use Pa\Core\Manager;
use Pa\Core\QueryBuilder;
use Pa\Models\Roles;

/**
 * Class RoleManager
 * @package Pa\Managers
 */
class RoleManager extends Manager
{
    /**
     * RoleManager constructor.
     * Appelle le constructeur parent
     */
    public function __construct()
    {
        parent::__construct(Roles::class, 'roles');
    }

    /**
     * @param string $login
     * Recupère le(s) role d'un utilisateur
     */
    public function getUserRoleByLogin(string $login)
    {
        $role = (new QueryBuilder())->select('r.*')
                                    ->from('roles', 'r')
                                    ->join('user_has_role', 'uhr', 'r', 'id_role', 'idRole')
                                    ->join('users', 'u', 'uhr', 'idUser', 'id_user')
                                    ->where('u.login = :login')
                                    ->setParameter('login', $login)
                                    ->getQuery()
                                    ->getArray();
        return $role[0];
    }

    /**
     * @param $id
     * @return mixed
     * Récupère les infos d'un roles
     */
    public function getRoleInfo($id)
    {
        $role = $this->findBy(['id_role'=>$id]);
        return $role[0];
    }

    /**
     * @return array
     * Récupère tous les roles
     */
    public function getRoles()
    {
        return $this->findAll();
    }

}