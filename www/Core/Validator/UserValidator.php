<?php


namespace Pa\Core\Validator;
use Pa\Managers\UserManager;

class UserValidator
{

    /**
     * @param $configForm
     * @param $data
     * @return array|string[]
     *
     * Verification du formulaire d'enregistrement
     */
    public static function checkRegisterForm($configForm, $data)
    {
        session_start();
        $listOfErrors = [];
        $pwd = "";

        // Verifie qu'il y ai le bon nombre de champs
        if(count($configForm["fields"]) == count($data)) {

            foreach($configForm["fields"] as $name => $config) {

                // Verifie que tous les chamsp required soit bien rempli
                if( !array_key_exists($name, $data) ||
                    ($config["required"] && empty($data[$name]))
                ) return ["Erreur lors du remplissage du formulaire"];

                /**
                 * Vérifier e-mail && e-mail perso
                 * Vérifier mot de passe 6<=X<=20 || 1 A-Z + 1 0-9
                 * Vérifier mot de passe === confirm mot de passe
                 * Vérifier Captcha
                 */

                // Verifie l'email
                if($config["type"] == "email"){
                    if(!(self::checkEmail($data[$name]))){
                        $listOfErrors[] = $config["errorMsg"];
                    }
                }

                // Verifie qu'un champs soit unique et qu'il n'existe pas déjà en BDD
                if (isset($config['unicity'])) {
                    if ($config['unicity']) {
                        $userManager = new UserManager();
                        $res[] = $userManager->findBy([$name=>$data[$name]]);
                        if (!empty($res[0])) {
                            $listOfErrors[] = $config['errorUnicity'];
                        }
                    }
                }

                // Verification du captcha
                /*
				if( $config["type"] == "captcha" && $_SESSION["captcha"] !== $data[$name] ){
				    $listOfErrors[] = $config['errorMsg'];
				}
                */

                // Verification du mot de passe
                if ($config["type"] === "password") {
                    if ($name === "password") {
                        $pwd = $data[$name];
                        if (!self::checkPwd($pwd)) {
                            $listOfErrors[] = $config['errorMsg'];
                        }
                    }
                    if ($name === "pwdConfirm" && $pwd !== $data["pwdConfirm"]) {
                        $listOfErrors[] = $config['errorMsg'];
                    }
                }

                // Verification que les champs fasse la bonne longueur
                if ($config["type"] === "text") {
                    if ($name === "firstname" && (strlen($data[$name]) < 2 || strlen($data[$name] > 50))) {
                        $listOfErrors[] = $config['errorMsg'];
                    }
                    if ($name === "lastname" && (strlen($data[$name]) < 2 || strlen($data[$name] > 100))) {
                        $listOfErrors[] = $config['errorMsg'];
                    }
                    if ($name === "login" && (strlen($data[$name]) < 2 || strlen($data[$name] > 45))) {
                        $listOfErrors[] = $config['errorMsg'];
                    }
                }
            }
        }else{
            return ["Tentative de hack"];
        }
        return $listOfErrors;
    }

    /**
     * @param $configForm
     * @param $data
     * @return array|string[]
     * Verifie le form d'édition du mot de passe
     */
    public static function checkEditPwdForm($configForm, $data)
    {
        $listOfErrors = [];
        $pwd = "";

        // Verifie qu'il y ai le bon nombre de champs
        if (count($configForm["fields"]) == count($data)) {

            // Verifie que tous les chamsp required soit bien rempli
            foreach ($configForm["fields"] as $name => $config) {
                if (!array_key_exists($name, $data) ||
                    ($config["required"] && empty($data[$name]))
                ) return ["Erreur lors du remplissage du formulaire"];

                // Verifie que le mot de passe respecte la nore imposé
                if ($config["type"] === "password") {
                    if ($name === "new_password") {
                        $pwd = $data[$name];
                        if (!self::checkPwd($pwd)) {
                            $listOfErrors[] = $config['errorMsg'];
                        }
                    }
                    // Verifie que le mot de passe de confirmation correspond au nouveau mot de passe
                    if ($name === "new_password_confirm" && $pwd !== $data["new_password_confirm"]) {
                        $listOfErrors[] = $config['errorMsg'];
                    }
                }
            }
        }else {
            return ["Tentative de hack"];
        }
        return $listOfErrors;
    }


    /**
     * @param $configForm
     * @param $data
     * @return array|string[]
     * Verifie le form d'édition d'un profile
     */
    public static function checkEditProfileForm($configForm, $data)
    {
        $listOfErrors = [];

        // Verifie qu'il y ai le bon nombre de champs
        if (count($configForm["fields"]) == count($data)) {

            foreach ($configForm["fields"] as $name => $config) {

                // Verifie que tous les chamsp required soit bien rempli
                if (!array_key_exists($name, $data) ||
                    ($config["required"] && empty($data[$name]))
                ) return ["Erreur lors du remplissage du formulaire"];

                // Verification email
                if ($config["type"] == "email") {
                    if (!(self::checkEmail($data[$name]))) {
                        $listOfErrors[] = $config["errorMsg"];
                    }
                }

                //longueur des champs
                if ($config["type"] === "text") {
                    if ($name === "firstname" && (strlen($data[$name]) < 2 || strlen($data[$name] > 50))) {
                        $listOfErrors[] = $config['errorMsg'];
                    }
                    if ($name === "lastname" && (strlen($data[$name]) < 2 || strlen($data[$name] > 100))) {
                        $listOfErrors[] = $config['errorMsg'];
                    }
                    if ($name === "login" && (strlen($data[$name]) < 2 || strlen($data[$name] > 45))) {
                        $listOfErrors[] = $config['errorMsg'];
                    }
                }
            }
        } else {
            return ["Tentative de hack"];
        }
        return $listOfErrors;
    }

    /**
     * @param $pwd
     * @return false|int
     * Verifie que le mot de passe respecte bien certaine règles
     * 6<=X<=20 && 1 A-Z + 1 0-9
     */
    public static function checkPwd($pwd){
        $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{6,20}$/";
        return preg_match($regex, $pwd);
    }

    /**
     * @param $email
     * @return mixed
     * Vérifie que l'email soit valide
     */
    public static function checkEmail($email){
        $email = trim($email);
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}