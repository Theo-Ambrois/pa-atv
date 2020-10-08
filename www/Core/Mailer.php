<?php
namespace Pa\Core;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Insertion des librairies servant a faire fonctionner phpMailer
require $_SERVER['DOCUMENT_ROOT'].'/libs/PHPMailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'].'/libs/PHPMailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'].'/libs/PHPMailer/src/SMTP.php';

class Mailer
{
    private $mail;
    private $account = 'pa.andrea.echeverria@gmail.com';
    private $pwd = '15/09/1999';

    /**
     * Mailer constructor.
     * Initialisation des options de phpMailer
     */
    public function __construct()
    {
        $this->mail = new PHPMailer();

        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = "tsl";
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->Port = 587;
        $this->mail->Username = $this->account;
        $this->mail->Password = $this->pwd;
        $this->mail->isHTML(true);

    }

    /**
     * @param $email
     * @param $firstName
     * @param $lastName
     * @param $login
     * @param $pwd
     * @throws Exception
     *
     * Mail d'inscription d'un utilisateur
     */
    public function registerMail($email, $firstName, $lastName, $login, $pwd)
    {
        try {
            $this->mail->setFrom($this->account, 'Inscription sur notre plateforme !');
            $this->mail->addAddress($email, $firstName . ' ' . $lastName);
            $this->mail->Subject = 'Creation de votre compte sur notre plateforme !';
            $this->mail->Body = "Bonjour votre compte a ete cree sur la plateforme ... <br>
                    Voici vos identifiants : <br>
                    login = " . $login . "<br> 
                    Mot de passe = " . $pwd . "<br>
                    Vous pouvez modifier vos informations a tout moment depuis votre profile.";
            $this->mail->send();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param $email
     * @param $firstName
     * @param $lastName
     * @param $url
     * @throws Exception
     *
     * Mail contenant l'url pour le mot de passe oublié
     */
    public function resetPwdMail($email, $firstName, $lastName, $url)
    {
        try {
            $this->mail->setFrom($this->account, 'Ré-initialisation de votre mot de passe');
            $this->mail->addAddress($email, $firstName . ' ' . $lastName);
            $this->mail->Subject = 'Demande de reset de mot de passe';
            $this->mail->Body = "Bonjour une demande pour modifier votre mot de passe a été effectué<br>
                    Voici le lien sur lequel vous pourrez le modifier : <br>
                    <a href=".$url.">".$url."</a><br>
                    Ce lien ne marchera qu'une fois.";
            $this->mail->send();
        }catch (Exception $e) {
            throw new Exception($e);
        }
    }
}