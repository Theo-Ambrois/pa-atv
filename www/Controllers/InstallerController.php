<?php


use Pa\Core\ConstantLoader;
use Pa\Core\helpers;
use Pa\Core\QueryBuilder;
use Pa\Core\Validator\UserValidator;
use Pa\Core\View;
use Pa\Managers\MenuManager;
use Pa\Managers\PageManager;
use Pa\Managers\RoleManager;
use Pa\Managers\User_Has_RoleManager;
use Pa\Managers\UserManager;
use Pa\Models\Menu;
use Pa\Models\Pages;
use Pa\Models\Roles;
use Pa\Models\User_Has_Role;
use Pa\Models\Users;

class InstallerController
{
    private $installer;

    public function __construct()
    {

    }

    /**
     * Installation
     */
    public function installAction()
    {
        $title = 'Installation...';
        // récuperation du formulaire d'installation
        $configForm = self::getInstallerForm();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Vérification uniquement pour les champs concernant l'utilisateur (On ne peux pas vérifier les champs
            // concernant les infos de la db)
            $errors = UserValidator::checkRegisterForm($configForm, $_POST);
            if (empty($errors)) {
                // Inscriptions des données dans les fichier d'environnement
                $this->initEnv($_POST);
                // Modification du script permettant de créer la DB avec les infos désiré par l'user
                $this->initSQLScript($_POST);
                // Création d'un role admin avec tous les droits
                $this->createAdmin();
                // Création d'un utilisateur avec le role admin
                $this->createUser($_POST);
                // Création des 2 onglets par défault du menu (Index/contact)
                $this->createTabs();
                // Création des 2 pages associées au onglets par défault du menu
                $this->createPages($_POST);

                header("Location: " . helpers::getUrl("user", "login"));
                die();
            }
        }

        $view = new View('install', 'account');
        $view->assign('configForm', $configForm);
        $view->assign('title', $title);
        if(isset($errors)) $view->assign('errors', $errors);
    }

    /**
     * @param $params
     * Récupère les informations concernant la DB et les inscrits dans les fichiers d'environnement
     * Puis load les fichiers d'environnement
     */
    private function initEnv($params) {
        $env = "DB_USER=".$params['DB_USER']."\nDB_PWD=".$params['DB_PWD']."\nDB_HOST=".$params['DB_HOST']."\nDB_DRIVER=mysql\nDB_NAME=".$params['DB_NAME']."\nMIDDLEWARE_PATH=Middleware\nINSTALLER=true\n";
        $dev = "DB_PREFIXE=".$params['DB_PREFIXE']."\n";

        file_put_contents('.env', $env);
        file_put_contents('.dev', $dev);

        new ConstantLoader();
    }

    /**
     * @param $params
     * Récupère le script permettant de créer toute la DB
     * Remplace le nom de base de la DB et le prefixe par ceux choisi par l'utilisateur
     * Execute le script pour créer la base de données
     */
    private function initSQLScript($params)
    {
        $sql = file_get_contents("script/DB.sql");
        $sql = str_replace("nfoz_", $params['DB_PREFIXE'], $sql);
        $sql = str_replace("mvcdocker2", $params["DB_NAME"], $sql);
        file_put_contents('script/DB.sql', $sql);
        try {
            $db = new \PDO(DB_DRIVER . ":host=" . DB_HOST , DB_USER, DB_PWD);
            $db->exec($sql);
        } catch (PDOException $e) {
            echo 'Erreur SQL : '. $e;
        }
    }

    /**
     * Crée un role admin possedant tous les droits
     */
    private function createAdmin()
    {
        $role = new Roles();
        $role->setGroup_name('Admin');
        $role->setPlanning(15);
        $role->setDocument(15);
        $role->setEvent(15);
        $role->setMark(15);
        $role->setRole(15);
        $role->setUser(15);
        $role->setPage(15);

        $roleManager = new RoleManager();
        $roleManager->save($role);
    }

    /**
     * @param $params
     * Crée un utilisateur avec les informations de l'utilisateur
     * Cet utilisateur possede le role admin
     */
    private function createUser($params)
    {
        $user = new Users();

        $user->setFirstname(helpers::specialChars($params["firstname"]));
        $user->setLastname(helpers::specialChars($params["lastname"]));
        $user->setLogin(helpers::specialChars($params["login"]));
        $user->setEmail($params["email"]);
        $user->setEmailperso($params["email_perso"]);
        $user->setPwd(sha1($params["password"]));
        $user->setStatus(0);
        $user->setResettoken('');

        $userManager = new UserManager();
        $userManager->save($user);

        $userHasRole = new User_Has_Role();
        $userHasRole->setIdUser(1);
        $userHasRole->setIdRole(1);

        $userHasRoleManager = new User_Has_RoleManager();
        $userHasRoleManager->save($userHasRole);
    }

    /**
     * Crée les 2 onglets par défault du menu (index/contact)
     */
    private function createTabs()
    {
        $indexTab = new Menu();
        $contactTab = new Menu();

        $indexTab->setName('Index');
        $indexTab->setPosition(1);
        $contactTab->setName('Contact');
        $contactTab->setPosition(2);

        $menuManager = new MenuManager();
        $menuManager->save($indexTab);
        $menuManager->save($contactTab);
    }

    /**
     * @param $params
     * Crée les 2 pages par défault (index/contact) et les lie au menu
     */
    private function createPages($params)
    {
        $indexPage = new Pages();
        $contactPage = new Pages();

        $indexPage->setTitle('Index');
        $indexPage->setContent("<p>Bonjour et bienvenue sur la page d'accueil !</p>");
        $indexPage->setIdMenu(1);

        $contactPage->setTitle('Contact');
        $contactPage->setContent("<p>Une question ? Vous pouvez envoyer un mail &agrave; : ".$params['email']."</p>");
        $contactPage->setIdMenu(2);

        $pageManager = new PageManager();
        $pageManager->save($indexPage);
        $pageManager->save($contactPage);
    }

    /**
     * @return array
     * Formulaire d'installation
     */
    private static function getInstallerForm()
    {
        return [

            "config"=>[
                "method"=>"POST",
                "action"=>helpers::getUrl("installer", "install"),
                "class"=>"user",
                "id"=>"formInstaller",
                "submit"=>"Installer !"
            ],

            "fields"=>[

                "DB_NAME" => [
                    "type"=>"text",
                    "placeholder"=>"Nom de votre base de données",
                    "class"=>"input",
                    "required"=>true,
                    ],

                "DB_PREFIXE" => [
                    "type"=>"text",
                    "placeholder"=>"Préfixe de votre base de données",
                    "class"=>"input",
                    "required"=>true,
                ],

                "DB_USER" => [
                    "type"=>"text",
                    "placeholder"=>"Utilisateur de la base de données",
                    "class"=>"input",
                    "required"=>true,
                ],

                "DB_PWD" => [
                    "type"=>"password",
                    "placeholder"=>"Mot de passe de l'utilisteur de la base de données",
                    "class"=>"input",
                    "required"=>true,
                ],

                "DB_HOST" => [
                    "type"=>"text",
                    "placeholder"=>"Host de votre base de données",
                    "class"=>"input",
                    "required"=>true,
                ],

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
                ],

                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email",
                    "class"=>"input",
                    "id"=>"exampleInputEmail",
                    "errorMsg"=>"Votre email est invalide.",
                    "required"=>true
                ],

                "email_perso"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email Personnel",
                    "class"=>"input",
                    "id"=>"exampleInputEmail",
                    "errorMsg"=>"Votre email est invalide.",
                    "required"=>true
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
}
