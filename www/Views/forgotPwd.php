<div class="container">
    <div class="row no-wrap">
        <div class="col-offset-3"></div>
        <div class="col-6" style="margin-top: 25vh">
            <div class="card" style="padding: 2% 10%">
                <?php if (isset($error)) echo $error ?>
                <div class="text-center">
                    <h1>Mot de passe oublié ?</h1>
                </div>
                <form class="user" method="post" action="<?= Pa\Core\helpers::getUrl("user", "forgotPwd") ?>">
                    <div class="form-group">
                        <input type="email" class="input" name="email" placeholder="Votre Adresse Email...">
                    </div>
                    </br>
                    <div class="form-group">
                        <button type="submit" class="button">
                            Envoyer
                        </button>
                    </div>
                </form>
                <div class="text-center">
                    <a class="small" href="<?= Pa\Core\helpers::getUrl("user", "login") ?>">Aller à la page de
                        connexion</a>
                </div>
            </div>
        </div>
    </div>
</div>