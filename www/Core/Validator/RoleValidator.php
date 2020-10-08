<?php


namespace Pa\Core\Validator;
use Pa\Managers\RoleManager;

class RoleValidator
{

    /**
     * @param $configForm
     * @param $data
     * @return array|string[]
     *
     * Verification du formulaire d'enregistrement
     */
    public static function checkCreateForm($configForm, $data)
    {
        $listOfErrors = [];

        foreach($configForm["fields"] as $name => $config) {
            if ($name == "group_name") {
                if (empty($data[$name])) $listOfErrors[] = $config['errorLength'];
                
                $roleManager = new RoleManager();
                $roleNames[] = $roleManager->findBy([$name=>$data[$name]]);
                if (!empty($roleNames[0])) $listOfErrors[] = $config['errorUnicity'];
            } 
        }
        return $listOfErrors;
    }


    public static function checkEditForm($configForm, $data)
    {
        $listOfErrors = [];

        foreach($configForm["fields"] as $name => $config) {
            if ($name == "group_name") {
                if (empty($data[$name])) $listOfErrors[] = $config['errorLength'];
                
                $roleManager = new RoleManager();
                $currentRole = $roleManager->getRoleInfo($_GET['id']);

                //var_dump($currentRole);die();
                $roleNames[] = $roleManager->findBy([$name=>$data[$name]]);
                if ($currentRole[$name] != $data[$name] && !empty($roleNames[0])) $listOfErrors[] = $config['errorUnicity'];
            } 
        }
        return $listOfErrors;
    }

}