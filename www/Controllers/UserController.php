<?php

use Pa\Core\helpers;
use Pa\Core\Mailer;
use Pa\Core\View;
use Pa\Core\Validator\UserValidator;
use Pa\Managers\User_Has_RoleManager;
use Pa\Models\User_Has_Role;
use Pa\Models\User_Has_Mark;
use Pa\Models\Users;
use Pa\Managers\UserManager;
use Pa\Core\Exceptions\NotFoundException;

class UserController
{
    /**
     * Suppression de son compte
     */
    public function removeAction()
    {
        $userManager = new UserManager();
        // On récupère les infos correspondant à l'utilisateur connecté
        $userInfo = $userManager->getUserInfo($_COOKIE['login']);
        // Verifie que le compte à supprimer n'est pas le compte admin
        if ($userInfo['id_user'] === '1') {
            header("Location: ".helpers::getUrl("user", "showProfile"));
            die();
        }
        // On supprime le compte en utilisant l'id de l'utilisateur connecté
        $userManager->delete($userInfo['id_user'], 'id_user');

        // On supprime le cookie qui indique que l'utilisateur est connecté
        if (isset($_COOKIE['login'])) {
            unset($_COOKIE['login']);
            setcookie('login', null, -1, '/');
        }
        // On redirige vers la page de login après la suppression
        header("Location: ".helpers::getUrl("user", "login"));
    }

    /**
     * Modification du profile de l'utilisateur connecté
     */
    public function editProfileAction()
    {
        $title = "Profile utilisateur";
        $tabName = "PROFILE";


        $userManager = new UserManager();
        // On récupère les infos de l'utilisateur connecté
        $userInfo = $userManager->getUserInfo($_COOKIE['login']);
        // On récupère le formulaire correspondant à la modification d'un compte
        $configEditProfileForm = users::getEditProfileForm('editProfile');

        // Si on accede a l'url avec un post, on modifie la table users avec les infos contenue dans le $_POST
        if ($_SERVER["REQUEST_METHOD"] === $configEditProfileForm['config']['method']) {
            // On valide le contenue du formulaire pour être sur qu'il n'y a pas eu de fraude
            $errors = UserValidator::checkEditProfileForm($configEditProfileForm, $_POST);
            if (empty($errors)) {
                $user = new Users();
                $user->setId_user($userInfo['id_user']);
                $user->setFirstname(helpers::specialChars($_POST["firstname"]));
                $user->setLastname(helpers::specialChars($_POST["lastname"]));
                $user->setLogin(helpers::specialChars($_POST["login"]));
                $user->setEmail($_POST["email"]);
                $user->setEmailperso($_POST["email_perso"]);
                $user->setPwd($userInfo['password']);
                $user->setStatus(0);
                $user->setResettoken('');

                $userManager->save($user);

                // On reset le cookie dans le cas ou le login a été modifié
                setcookie("login", $_POST["login"], time() + 3600);
                // Redirige vers la page affichant les infos du profile pour montrer que les modifs ont bien été prise
                // en compte
                header("Location: " . helpers::getUrl("user", "showProfile"));
            }
        }
        $view = new View("editProfile");
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
        $view->assign("userInfo", $userInfo);
        $view->assign("configEditProfileForm", $configEditProfileForm);
    }

    /**
     * Affiche le profile de l'utilisateur connecté
     */
    public function showProfileAction()
    {
        $title = "Profile utilisateur";
        $tabName = "PROFILE";

        $userManager = new UserManager();
        // On recupère les infos de l'utilisateur connecté pour les affiché dans sa page
        $user = $userManager->getUserInfo($_COOKIE['login']);

        $view = new View("profile");
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
        $view->assign("user", $user);
    }

    /**
     * Modifie le mot de passe de l'utilisateur connecté
     */
    public function editPwdAction()
    {
        $title = "Modification du mot de passe";
        $tabName = "PROFILE";
        $configEditPwdForm = users::getEditPwdForm();

        // Si on accede a l'url avec un post, on modifie le pwd contenue dans la table users avec les infos du $_POST
        if ($_SERVER["REQUEST_METHOD"] === $configEditPwdForm['config']['method']) {
            // On verifie qu'il n'y a peu eu de tentative de fraude
            $errors = UserValidator::checkEditPwdForm($configEditPwdForm, $_POST);
            if (empty($errors)) {
                $userManager = new UserManager();
                // On récupère les infos de l'utilisateur connecté
                $userInfo = $userManager->getUserInfo($_COOKIE['login']);
                // Verification entre le mot de passe indiqué en bdd et celui rentré par l'utilisateur
                if ($userInfo['password'] === sha1($_POST['password'])) {
                    $user = new Users();
                    $user->setId_user($userInfo['id_user']);
                    $user->setLogin($userInfo['login']);
                    $user->setFirstname($userInfo['firstname']);
                    $user->setLastname($userInfo['lastname']);
                    $user->setEmail($userInfo['email']);
                    $user->setEmailperso($userInfo['email_perso']);
                    $user->setStatus(0);
                    $user->setPwd(sha1($_POST['new_password']));
                    $user->setResettoken('');
                    $userManager->save($user);

                    // Redirection vers la page utilisateur
                    header("Location: ".helpers::getUrl("user", "showProfile"));
                } else {
                    $errors = ['errorMsg' => 'Votre ancien mot de passe n\'est pas correct.'];
                }
            }
        }

        $view = new View("editPwd");
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
        $view->assign('configEditPwdForm', $configEditPwdForm);
        if (isset($errors)) {
            $view->assign("errors", $errors);
        }
    }

    /**
     * Connexion
     */
    public function loginAction()
    {
        $title = 'Login';
        // Récuperation du formulaire de login
        $configFormUser = users::getLoginForm();

        // Si on accede a l'url avec un post, on vérifie dans la table users que les identifants sont correcte
        if ($_SERVER["REQUEST_METHOD"] === $configFormUser['config']['method']) {
            $userManager = new UserManager();
            // Recherche en bdd du login et mdp
            if ($userManager->login($_POST["login"], $_POST["password"])) {
                // Création d'un cookie durant 1h contenant le login de l'utilisateur
                setcookie("login", $_POST["login"], time() + 3600);
                // Redirection vers le dashboard
                header("Location: ".helpers::getUrl("default", "default"));
            } else {
                $errors = "Identifiants incorrect !";
            }
        }

        $myView = new View("login", "account");
        $myView->assign("configFormUser", $configFormUser);
        $myView->assign('title', $title);
        if (isset($errors)) {
            $myView->assign("errors", $errors);
        }
    }

    /**
     * Inscription
     */
    public function registerAction()
    {
        $title = "Création d'un utilisateur";
        $tabName = "UTILISATEUR";

        // Récuperation du formulaire d'inscription
        $configFormUser = users::getRegisterForm();

        // Si on accede a l'url avec un post, on inscrit dans la table users les infos présent dans le $_POST
        if($_SERVER["REQUEST_METHOD"] === $configFormUser['config']['method']){
            //vérif des champs pour éviter les fraudes
            $errors = UserValidator::CheckRegisterForm($configFormUser, $_POST);
            if (empty($errors)) {
                $user = new Users();

                $user->setFirstname(helpers::specialChars($_POST["firstname"]));
                $user->setLastname(helpers::specialChars($_POST["lastname"]));
                $user->setLogin(helpers::specialChars($_POST["login"]));
                $user->setEmail($_POST["email"]);
                $user->setEmailperso($_POST["email_perso"]);
                $user->setPwd(sha1($_POST["password"]));
                $user->setStatus(0);
                $user->setResettoken('');

                // Sauvegarde dans la tables users
                $userManager = new UserManager();
                $userManager->save($user);

                // On récupère l'id de l'utilisateur créé
                $idUser = $userManager->getUserId($user->getLogin());

                $userHasRole = new User_Has_Role();
                $userHasRole->setIdUser($idUser);
                $userHasRole->setIdRole($_POST["role"]);

                // Sauvegarde dans la table de liaison Role/Utilisateur
                $userHasRoleManager = new User_Has_RoleManager();
                $userHasRoleManager->save($userHasRole);

                // Envoie de mail sur l'email personnel de l'utilisateur pour le notifier de la création de son compte
                (new Mailer())->registerMail($_POST['email_perso'], $_POST['firstname'],
                    $_POST['lastname'], $_POST['login'], $_POST['password']);

                // Redirection sur la liste des utilisateurs
                header("Location: " . helpers::getUrl("user", "list"));
            }
        }

        $myView = new View("register");
        $myView->assign("configFormUser", $configFormUser);
        $myView->assign("title", $title);
        $myView->assign("tabName", $tabName);
        if (isset($errors)) {
            $myView->assign("errors", $errors);
        }
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     * Ré-initialisation du mot de passe en cas de perte
     */
    public function forgotPwdAction()
    {
        $title = 'Mot de passe oublié ?';
        // Si on accede a l'url avec un post
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user = new Users();
            // On récupère les infos du compte correspond à l'email
            $userInfo = $user->getUserByEmail($_POST['email']);
            // Si aucun utilisateur n'est trouvé une erreur est renvoyé
            if (!empty($userInfo)) {
                $user->setId_user($userInfo['id_user']);
                $user->setLogin($userInfo['login']);
                $user->setFirstname($userInfo['firstname']);
                $user->setLastname($userInfo['lastname']);
                $user->setEmail($userInfo['email']);
                $user->setEmailperso($userInfo['email_perso']);
                $user->setStatus(0);
                $user->setPwd($userInfo['password']);
                // Génération d'un token unique servant au reset du mot de passe de l'utilisateur
                $reset_token = uniqid();
                $user->setResettoken($reset_token);

                (new UserManager())->save($user);

                // L'url sur laquel il sera possible de modifier son mot de passe
                $url = $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].
                    helpers::getUrl('user', 'resetPwd',
                        ['id'=>$userInfo['id_user'], 'reset_token'=>$reset_token]);

                // Envoie d'un mail à l'utilisateur comportant l'url de modification du mot de passe
                (new Mailer())->resetPwdMail($userInfo['email_perso'], $userInfo['firstname'],
                    $userInfo['lastname'],  $url);

                // Alert pour prévenir qu'un email a été envoyé
                echo "<script>alert('Un mail pour modifier votre mot de passe a été envoyé !')</script>";
                // Redirection sur la page de login après l'alert
                header("Location: " . helpers::getUrl("user", "login"));
            } else $error = 'Cette adresse email n\'est pas répertorié.';
        }
        $myView = new View("forgotPwd", "account");
        $myView->assign('title', $title);
        if (isset($error)) $myView->assign('error', $error);
    }

    /**
     * Modification du mot de passe sans connaitre l'ancien mot de passe
     * Une verification avec un id & un reset_token est utilisé pour évite qu'un utilisateur connaissant
     * l'url modifie le mot de passe d'un autre utilisateur
     */
    public function resetPwdAction()
    {
        $title = 'Réinitialiser son mot de passe';
        $reset_token=$_GET['reset_token'];
        $id=$_GET['id'];

        // Si le reset token est vide, on redirige sur la page de mot de passe oublié
        if ($reset_token === '') {
            header("Location: " . helpers::getUrl("user", "forgotPwd"));
            die();
        }
        // Récuperation du formulaire de reset mdp
        $configFormUser = users::getResetPwdForm($id, $reset_token);
        // Si on accede a l'url avec un post, on modifie le pwd dans la table users avec les infos présent dans le $_POST
        if ($_SERVER['REQUEST_METHOD'] === $configFormUser['config']['method']) {
            // Verification du contenue du $_POST
            $errors = UserValidator::checkEditPwdForm($configFormUser, $_POST);
            if (empty($errors)) {
                $userManager = new UserManager();
                // Recherche de l'utilisateur a l'aide de sont id & du reset token
                $userInfo = $userManager->findBy(['id_user'=>$id, 'reset_token'=>$reset_token]);
                // Si aucun utilisateur est trouvé une erreur est envoyé
                if (!empty($userInfo[0])) {
                    $user = new Users();

                    $user->setId_user($id);
                    $user->setLogin($userInfo[0]['login']);
                    $user->setFirstname($userInfo[0]['firstname']);
                    $user->setLastname($userInfo[0]['lastname']);
                    $user->setEmail($userInfo[0]['email']);
                    $user->setEmailperso($userInfo[0]['email_perso']);
                    $user->setStatus(0);
                    $user->setPwd(sha1($_POST['new_password']));
                    // On vide le reset token pour pas qu'il soit ré-utilisé
                    $user->setResettoken('');

                    $userManager->save($user);

                    // Redirection vers la page de login
                    header("Location: " . helpers::getUrl("user", "login"));
                }
                $errors[] = 'Le compte sur lequel vous essayer de modifier le mot de passe n\'existe pas';
            }
        }
        $view = new View('resetPwd', 'account');
        $view->assign("configFormUser", $configFormUser);
        $view->assign('title', $title);
        if (isset($errors)) $view->assign("errors", $errors);
    }

    /**
     * Suppression du cookie de connexion de l'utilisateur
     */
    public function disconnectAction()
    {
        if (isset($_COOKIE['login'])) {
            unset($_COOKIE['login']);
            setcookie('login', null, -1, '/');
        }
        header("Location: ".helpers::getUrl("user", "login"));
    }

    /**
     * Affiche une liste d'utilisateur
     */
    public function listAction()
    {
        $title = "Tous les utilisateurs";
        $tabName = "UTILISATEURS";

        $users = (new UserManager())->getUsers();

        $view = new View("usersList");
        $view->assign("users", $users);
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
    }

    /**
     * Permet à l'admin de modifier un compte utilisateur
     */
    public function editAdminAction()
    {
        if ($_GET['id'] === '1') {
            // Redirige vers la liste des utilisateurs
            header("Location: " . helpers::getUrl("user", "list"));
            // Die pour ne pas executer le reste de la fonction
            die();
        }

        $title = "Profile de l'utilisateur";
        $tabName = "UTILISATEUR";

        $userManager = new UserManager();
        // On récupère les infos de l'utilisateur grace à son id
        $userInfo = $userManager->getUserById($_GET['id']);
        // On récupère l'id du role de l'utilisateur
        $userRoleId = $userManager->getRoleIdByUserId($_GET['id']);
        if ($userInfo === null) {
            // Si aucun utilisateur est trouvé, renvoie sur la liste
            header("Location: " . helpers::getUrl("user", "list"));
        }
        // On récupère le formulaire correspondant à la modification d'un compte
        $configEditProfileForm = users::getEditAdminProfileForm('editAdmin', $_GET['id'], $userRoleId);

        // Si on accede a l'url avec un post, on modifie la table users avec les infos contenue dans le $_POST
        if ($_SERVER["REQUEST_METHOD"] === $configEditProfileForm['config']['method']) {
            // On valide le contenue du formulaire
            $errors = UserValidator::checkEditProfileForm($configEditProfileForm, $_POST);
            if (empty($errors)) {
                $user = new Users();
                $user->setId_user($userInfo['id_user']);
                $user->setFirstname(helpers::specialChars($_POST["firstname"]));
                $user->setLastname(helpers::specialChars($_POST["lastname"]));
                $user->setLogin(helpers::specialChars($_POST["login"]));
                $user->setEmail($_POST["email"]);
                $user->setEmailperso($_POST["email_perso"]);
                $user->setPwd($userInfo['password']);
                $user->setStatus(0);
                $user->setResettoken('');

                $userManager->save($user);

                $userHasRoleManager = new User_Has_RoleManager();
                $userHasRoleManager->delete($_GET['id'], 'idUser');

                $userHasRole = new User_Has_Role();
                $userHasRole->setIdUser($_GET['id']);
                $userHasRole->setIdRole($_POST["role"]);
                $userHasRoleManager->save($userHasRole);

                // Redirige vers la liste des utilisateurs
                header("Location: " . helpers::getUrl("user", "list"));
                // Die pour ne pas executer le reste de la fonction
                die();
            }
        }
        $view = new View("userEdit");
        $view->assign("title", $title);
        $view->assign("tabName", $tabName);
        $view->assign("userInfo", $userInfo);
        $view->assign("configEditProfileForm", $configEditProfileForm);
    }

    public function removeAdminAction()
    {
        // Verifie que l'utilisateur a supprimer n'est pas le compte admin
        if ($_GET['id'] !== '1') {
        // Suppression de l'utilisateur par son id
            (new UserManager())->delete($_GET['id'], 'id_user');
        }

        // Redirection pour mettre à jour la liste
        header("Location: " . helpers::getUrl("user", "list"));
    }
}
