<?php

namespace Pa\Models;

use Pa\Core\helpers;
use Pa\Managers\UserManager;

class Users extends Model
{
    protected $id_user;
    protected $firstname;
    protected $lastname;
    protected $login;
    protected $email;
    protected $email_perso;
    protected $password;
    protected $status;
    protected $reset_token;


    /** SETTER & GETTER */
    public function setId_user($id)
    {
        $this->id_user=$id;
        return $this;
    }
    public function getId()
    {
        return $this->id_user;
    }
    public function setFirstname($firstname)
    {
        $this->firstname=ucwords(strtolower(trim($firstname)));
        return $this;
    }
    public function getFirstname()
    {
        return $this->firstname;
    }
    public function setLastname($lastname)
    {
        $this->lastname=strtoupper(trim($lastname));
        return $this;
    }
    public function getLastname()
    {
        return $this->lastname;
    }
    public function setLogin($login)
    {
        $this->login=trim($login);
        return $this;
    }
    public function getLogin()
    {
        return $this->login;
    }
    public function setEmail($email)
    {
        $this->email=strtolower(trim($email));
        return $this;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmailperso($email_perso)
    {
        $this->email_perso=strtolower(trim($email_perso));
        return $this;
    }
    public function getEmailperso()
    {
        return $this->email_perso;
    }
    public function setPwd($pwd)
    {
        $this->password = $pwd;
        return $this;
    }
    public function getPwd()
    {
        return $this->password;
    }
    public function setStatus($status)
    {
        $this->status=$status;
        return $this;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setResettoken($token)
    {
        $this->reset_token = $token;
        return $this;
    }
    public function getResettoken()
    {
        return $this->reset_token;
    }

    public static function getAll()
    {
        $allUsers = (new UserManager)->getListUsers();
        $users = [];
        foreach ($allUsers as $u) {
            $users[$u->getId()] = $u->getLastname()." ".$u->getFirstname();
        }
        return $users;
    }

    public function getUserByEmail($email)
    {
        $user = (new UserManager())->findBy(['email_perso'=>$email]);
        return $user[0];
    }


    /**
     * @param string $key
     * @return string|null
     * Recherche les relation avec les autres tables
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
     * Initialise les relations avec les autres tables
     */
    public function initRelation()
    {
        // clef etrangère vers classe
        return [];
    }

    /**
     * @return array
     * Formulaire de création d'un compte
     */
    public static function getRegisterForm(){
        return [

                "config"=>[
                    "method"=>"POST",
                    "action"=>helpers::getUrl("user", "register"),
                    "class"=>"user",
                    "id"=>"formRegisterUser",
                    "submit"=>"Créer"
                ],

                "fields"=>[

                    "firstname"=>[
                        "type"=>"text",
                        "placeholder"=>"Votre prénom",
                        "class"=>"input",
                        "id"=>"exampleFirstName",
                        "required"=>true,
                        "min-length"=>2,
                        "max-length"=>50,
                        "errorMsg"=>"Votre prénom doit être compris en 2 et 50 caractères."
                    ],

                    "lastname"=>[
                        "type"=>"text",
                        "placeholder"=>"Votre nom",
                        "class"=>"input",
                        "id"=>"exampleLastName",
                        "required"=>true,
                        "min-length"=>2,
                        "max-length"=>100,
                        "errorMsg"=>"Votre nom doit être compris en 2 et 100 caractères."
                    ],

                    "login"=>[
                        "type"=>"text",
                        "placeholder"=>"Votre login",
                        "class"=>"input",
                        "id"=>"exampleLastName",
                        "required"=>true,
                        "min-length"=>2,
                        "max-length"=>45,
                        "unicity" => true,
                        "errorMsg"=>"Votre login doit être compris en 2 et 45 caractères.",
                        "errorUnicity"=>"Ce login est déjà utilisé."
                    ],

                    "email"=>[
                        "type"=>"email",
                        "placeholder"=>"Votre email",
                        "class"=>"input",
                        "id"=>"exampleInputEmail",
                        "unicity" => true,
                        "errorMsg"=>"Votre email est invalide.",
                        "errorUnicity"=>"Cet email est déjà utilisé.",
                        "required"=>true
                    ],

                    "email_perso"=>[
                        "type"=>"email",
                        "placeholder"=>"Votre email Personnel",
                        "class"=>"input",
                        "id"=>"exampleInputEmail",
                        "unicity" => true,
                        "errorMsg"=>"Votre email est invalide.",
                        "errorUnicity"=>"Cet email perso est déjà utilisé.",
                        "required"=>true
                    ],

                    "role" => [
                        "type"=>"select",
                        "class"=>'input',
                        "options"=>Roles::getAll(),
                        "id"=>"exampleRoleSelect",
                        "required"=>true,
                        "errorMsg"=>"Le rôle séléctionné n'est pas valide."
                    ],

                    "password"=>[
                        "type"=>"password",
                        "placeholder"=>"Votre mot de passe",
                        "class"=>"input",
                        "id"=>"exampleInputPassword",
                        "required"=>true,
                        "errorMsg"=>"Votre mot de passe doit faire entre 6 et 20 caractères et doit avoir au moin 1 majuscule et minuscule et 1 chiffre"
                    ],

                    "pwdConfirm"=>[
                        "type"=>"password",
                        "placeholder"=>"Confirmation du mot de passe",
                        "class"=>"input",
                        "id"=>"exampleRepeatPassword",
                        "required"=>true,
                        "confirmWith"=>"password",
                        "errorMsg"=>"Votre mot de passe de confirmation n'est pas correct."
                    ]
                ]
                ];
    }

    /**
     * @return array
     * Formulaire de login
     */
    public static function getLoginForm()
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => helpers::getUrl("user", "login"),
                "class" => "user",
                "id" => "formLoginUser",
                "submit" => "Se connecter"
            ],
            "fields" => [
                "login"=>[
                    "type"=>"text",
                    "placeholder"=>"Votre login",
                    "class"=>"input",
                    "id"=>"exampleLastName",
                    "required"=>true
                ],
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe",
                    "class"=>"input",
                    "id"=>"exampleInputPassword",
                    "required"=>true
                ]
            ]
        ];
    }

    /**
     * @return array
     * Formulaire d'édition du mot de passe
     */
    public static function getEditPwdForm()
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => helpers::getUrl("user", "editPwd"),
                "class" => "user",
                "id" => "formEditPwd",
                "submit" => "Modifier"
            ],
            "fields" => [
                "password"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe",
                    "class"=>"input marginless",
                    "id"=>"exampleLastName",
                    "required"=>true
                ],
                "new_password"=>[
                    "type"=>"password",
                    "placeholder"=>"Nouveau mot de passe",
                    "class"=>"input marginless",
                    "id"=>"exampleInputPassword",
                    "required"=>true,
                    "errorMsg"=>"Votre mot de passe doit faire entre 6 et 20 caractères et doit avoir au moin 1 majuscule et minuscule et 1 chiffre"
                ],
                "new_password_confirm" => [
                    "type" => "password",
                    "placeholder" => "Confirmez votre nouveau mot de passe",
                    "class" => "input marginless",
                    "id" => "exampleInputPassword",
                    "required" => true,
                    "errorMsg"=>"Votre mot de passe de confirmation n'est pas correct."
                ]
            ]
        ];
    }

    /**
     * @param $id
     * @param $reset_token
     * @return array
     * Formulaire de ré-initialisation du mot de passe en cas de perte
     */
    public static function getResetPwdForm($id, $reset_token)
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => helpers::getUrl("user", "resetPwd", ['id'=>$id,'reset_token'=>$reset_token]),
                "class" => "user",
                "id" => "formResetPwd",
                "submit" => "Reset password"
            ],
            "fields" => [
                "new_password"=>[
                    "type"=>"password",
                    "placeholder"=>"Nouveau mot de passe",
                    "class"=>"input marginless",
                    "id"=>"exampleInputPassword",
                    "required"=>true,
                    "errorMsg"=>"Votre mot de passe doit faire entre 6 et 20 caractères et doit avoir au moin 1 majuscule et minuscule et 1 chiffre"
                ],
                "new_password_confirm" => [
                    "type" => "password",
                    "placeholder" => "Confirmez votre nouveau mot de passe",
                    "class" => "input marginless",
                    "id" => "exampleInputPassword",
                    "required" => true,
                    "errorMsg"=>"Votre mot de passe de confirmation n'est pas correct."
                ]
            ]
        ];
    }

    /**
     * @param $action
     * @param $id
     * @return array
     * Formulaire d'édition de compte
     */
    public static function getEditProfileForm($action)
    {
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("user", $action),
                "class"=>"user",
                "id"=>"formEditUser",
                "submit"=>"Modifier",
            ],

            "fields"=>[

                "firstname"=>[
                    "type"=>"text",
                    "placeholder"=>"Votre prénom",
                    "class"=>"input",
                    "id"=>"exampleFirstName",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>50,
                    "errorMsg"=>"Votre prénom doit être compris en 2 et 50 caractères."
                ],

                "lastname"=>[
                    "type"=>"text",
                    "placeholder"=>"Votre nom",
                    "class"=>"input",
                    "id"=>"exampleLastName",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>100,
                    "errorMsg"=>"Votre nom doit être compris en 2 et 100 caractères."
                ],

                "login"=>[
                    "type"=>"text",
                    "placeholder"=>"Votre login",
                    "class"=>"input",
                    "id"=>"exampleLastName",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>45,
                    "errorMsg"=>"Votre login doit être compris en 2 et 45 caractères.",
                    "unicity" => true,
                    "errorUnicity"=>"Ce login est déjà utilisé."
                ],

                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email",
                    "class"=>"input",
                    "id"=>"exampleInputEmail",
                    "errorMsg"=>"Votre email est invalide.",
                    "required"=>true,
                    "unicity" => true,
                    "errorUnicity"=>"Cet email est déjà utilisé."
                ],

                "email_perso"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email Personnel",
                    "class"=>"input",
                    "id"=>"exampleInputEmail",
                    "errorMsg"=>"Votre email est invalide.",
                    "required"=>true,
                    "unicity" => true,
                    "errorUnicity"=>"Cet email perso est déjà utilisé."
                ],
            ]

        ];
    }

    /**
     * @param $action
     * @param $id
     * @param $idRole
     * @return array
     * Formulaire d'édition d'un compte par quelqu'un ayant le droit de modifier
     */
    public static function getEditAdminProfileForm($action, $id, $idRole)
    {
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("user", $action, ['id'=>$id]),
                "class"=>"user",
                "id"=>"formEditUser",
                "submit"=>"Modifier",
            ],

            "fields"=>[

                "firstname"=>[
                    "type"=>"text",
                    "placeholder"=>"Votre prénom",
                    "class"=>"input",
                    "id"=>"exampleFirstName",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>50,
                    "errorMsg"=>"Votre prénom doit être compris en 2 et 50 caractères."
                ],

                "lastname"=>[
                    "type"=>"text",
                    "placeholder"=>"Votre nom",
                    "class"=>"input",
                    "id"=>"exampleLastName",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>100,
                    "errorMsg"=>"Votre nom doit être compris en 2 et 100 caractères."
                ],

                "login"=>[
                    "type"=>"text",
                    "placeholder"=>"Votre login",
                    "class"=>"input",
                    "id"=>"exampleLastName",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>45,
                    "errorMsg"=>"Votre login doit être compris en 2 et 45 caractères.",
                    "unicity" => true,
                    "errorUnicity"=>"Ce login est déjà utilisé."
                ],

                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email",
                    "class"=>"input",
                    "id"=>"exampleInputEmail",
                    "errorMsg"=>"Votre email est invalide.",
                    "required"=>true,
                    "unicity" => true,
                    "errorUnicity"=>"Cet email est déjà utilisé."
                ],

                "email_perso"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email Personnel",
                    "class"=>"input",
                    "id"=>"exampleInputEmail",
                    "errorMsg"=>"Votre email est invalide.",
                    "required"=>true,
                    "unicity" => true,
                    "errorUnicity"=>"Cet email perso est déjà utilisé."
                ],

                "role" => [
                    "type"=>"select",
                    "class"=>'input',
                    "options"=>Roles::getAll($idRole),
                    "id"=>"exampleRoleSelect",
                    "required"=>true,
                    "errorMsg"=>"Le rôle séléctionné n'est pas valide."
                ],
            ]

        ];
    }

}
