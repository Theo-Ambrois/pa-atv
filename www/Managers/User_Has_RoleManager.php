<?php


namespace Pa\Managers;

use Pa\Core\Manager;
use Pa\Models\User_Has_Role;

/**
 * Class User_Has_RoleManager
 * @package Pa\Managers
 */
class User_Has_RoleManager extends Manager
{
    /**
     * User_Has_RoleManager constructor.
     * Appelle le constructeur parent
     */
    public function __construct()
    {
        parent::__construct(User_Has_Role::class, 'user_has_role');
    }
}