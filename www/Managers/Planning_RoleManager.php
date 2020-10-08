<?php


namespace Pa\Managers;


use Pa\Core\Manager;
use Pa\Models\Planning_Role;

class Planning_RoleManager extends Manager
{
    public function __construct()
    {
        parent::__construct(Planning_Role::class, 'planning_role');
    }
}