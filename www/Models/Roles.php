<?php
namespace Pa\Models;

use Pa\Core\helpers;
use Pa\Managers\RoleManager;

class Roles extends Model
{
    protected $id_role;
    protected $group_name;
    protected $planning;
    protected $role;
    protected $mark;
    protected $document;
    protected $event;
    protected $user;
    protected $page;

    /** SETTER & GETTER */
    public function setId_role($id)
    {
        $this->id_role=$id;
        return $this;
    }

    public function setGroup_name($name)
    {
        $this->group_name=$name;
        return $this;
    }

    public function setPlanning($value)
    {
        $this->planning=$value;
        return $this;
    }

    public function setRole($value)
    {
        $this->role=$value;
        return $this;
    }

    public function setMark($value)
    {
        $this->mark=$value;
        return $this;
    }

    public function setDocument($value)
    {
        $this->document=$value;
        return $this;
    }

    public function setEvent($value)
    {
        $this->event=$value;
        return $this;
    }

    public function setUser($value)
    {
        $this->user=$value;
        return $this;
    }

    public function setPage($value)
    {
        $this->page=$value;
        return $this;
    }

    public function getId()
    {
        return $this->id_role;
    }

    public function getGroup_name()
    {
        return $this->group_name;
    }

    public function getPlanning()
    {
        return $this->planning;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getMark()
    {
        return $this->mark;
    }

    public function getDocument()
    {
        return $this->document;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return array
     * Recupère tous les roles
     * Si un $id est donné, il retournera en premiere case du tableau, le role auquel correspond l'id
     */
    public static function getAll($id = '')
    {
        $allRoles = (new RoleManager)->getRoles();
        $roles = [];
        if ($id !== '') {
            foreach ($allRoles as $r) {
                if ($r->getId() === $id) {
                    $roles[$id] = $r->getGroup_name();
                }
            }
            foreach ($allRoles as $r) {
                if ($r->getId() !== $id)$roles[$r->getId()] = $r->getGroup_name();
            }
        }else {
            foreach ($allRoles as $r) {
                $roles[$r->getId()] = $r->getGroup_name();
            }
        }
        return $roles;
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

    /**
     * @return array
     * Formulaire de création d'un role
     */
    public static function createForm(){
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("role", "create"),
                "class"=>"role",
                "id"=>"formCreateRole",
                "submit"=>"Créer le role"
            ],

            "fields"=>[
                "group_name"=>[
                    "type"=>"text",
                    "placeholder"=>"Nom du role",
                    "class"=>"input",
                    "id"=>"roleName",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>45,
                    "unicity" => true,
                    "errorLength"=>"Le nom du role doit être compris en 2 et 45 caractères.",
                    "errorUnicity"=>"Ce nom de rôle est déjà utilisé."
                ],
                "planning"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "planning_create"=>"Créer",
                        "planning_update"=>"Modifier",
                        "planning_delete"=>"Supprimer",
                        "planning_read"=>"Lire",
                    ],
                    "required"=>true
                ],
                "mark"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "mark_create"=>"Créer",
                        "mark_update"=>"Modifier",
                        "mark_delete"=>"Supprimer",
                        "mark_read"=>"Lire",
                    ],
                    "required"=>true
                ],
                "document"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "document_create"=>"Créer",
                        "document_update"=>"Downloader",
                        "document_delete"=>"Supprimer",
                        "document_read"=>"Lire",
                    ],
                    "required"=>true
                ],
                "event"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "event_create"=>"Créer",
                        "event_update"=>"Modifier",
                        "event_delete"=>"Supprimer",
                        "event_read"=>"Lire",
                    ],
                    "required"=>true
                ],
                "role"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "role_create"=>"Créer",
                        "role_update"=>"Modifier",
                        "role_delete"=>"Supprimer",
                        "role_read"=>"Lire",
                    ],
                    "required"=>true
                ],
                "user"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "user_create"=>"Créer",
                        "user_update"=>"Modifier",
                        "user_delete"=>"Supprimer",
                        "user_read"=>"Lire",
                    ],
                    "required"=>true
                ],
                "page"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "page_create"=>"Créer",
                        "page_update"=>"Modifier",
                        "page_delete"=>"Supprimer",
                        "page_read"=>"Lire",
                    ],
                    "required"=>true
                ]
            ]

        ];
    }

    /**
     * @param $id
     * @return array$
     * Formulaire de modification d'un role
     */
    public static function editForm($id){
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("role", "edit", ['id'=>$id]),
                "class"=>"role",
                "id"=>"formCreateRole",
                "submit"=>"Modifier"
            ],

            "fields"=>[
                "group_name"=>[
                    "type"=>"text",
                    "placeholder"=>"Nom du role",
                    "class"=>"input",
                    "id"=>"roleName",
                    "required"=>true,
                    "min-length"=>2,
                    "max-length"=>45,
                    "unicity" => true,
                    "errorLength"=>"Le nom du role doit être compris en 2 et 45 caractères.",
                    "errorUnicity"=>"Ce nom de rôle est déjà utilisé."
                ],
                "planning"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "planning_create"=>"Créer",
                        "planning_update"=>"Modifier",
                        "planning_delete"=>"Supprimer",
                        "planning_read"=>"Lire",
                    ],
                    "required"=>true
                ],
                "mark"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "mark_create"=>"Créer",
                        "mark_update"=>"Modifier",
                        "mark_delete"=>"Supprimer",
                        "mark_read"=>"Lire",
                    ],
                    "required"=>true
                ],
                "document"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "document_create"=>"Créer",
                        "document_update"=>"Downloader",
                        "document_delete"=>"Supprimer",
                        "document_read"=>"Lire",
                    ],
                    "required"=>true
                ],
                "event"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "event_create"=>"Créer",
                        "event_update"=>"Modifier",
                        "event_delete"=>"Supprimer",
                        "event_read"=>"Lire",
                    ],
                    "required"=>true
                ],
                "role"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "role_create"=>"Créer",
                        "role_update"=>"Modifier",
                        "role_delete"=>"Supprimer",
                        "role_read"=>"Lire",
                    ],
                    "required"=>true
                ],
                "user"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "user_create"=>"Créer",
                        "user_update"=>"Modifier",
                        "user_delete"=>"Supprimer",
                        "user_read"=>"Lire",
                    ],
                    "required"=>true
                ],
                "page"=>[
                    "type"=>'checkBox_Auth',
                    "options"=>[
                        "page_create"=>"Créer",
                        "page_update"=>"Modifier",
                        "page_delete"=>"Supprimer",
                        "page_read"=>"Lire",
                    ],
                    "required"=>true
                ]
            ]

        ];
    }

}