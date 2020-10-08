<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card card--isHalf">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12">
                            <label>Prénom</label>
                            <input value="<?= $user['firstname'] ?>" class="input" disabled>
                        </div>
                        <div class="col-12">
                            <label>Nom</label>
                            <input value="<?= $user['lastname'] ?>" class="input" disabled>
                        </div>
                        <div class="col-12">
                            <label>Date d'inscription</label>
                            <input value="<?= $user['date_inserted'] ?>" class="input" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="col-12">
                            <label>Login</label>
                            <input value="<?= $user['login'] ?>" class="input" disabled>
                        </div>
                        <div class="col-12">
                            <label>Email</label>
                            <input value="<?= $user['email'] ?>" class="input" disabled>
                        </div>
                        <div class="col-12">
                            <label>Email perso</label>
                            <input value="<?= $user['email_perso'] ?>" class="input" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a class="button" href="<?= Pa\Core\helpers::getUrl('mark', 'own')?>">
                            Voir ses notes
                        </a>
                        <a class="button" href="<?= Pa\Core\helpers::getUrl('user', 'editPwd') ?>">
                            Modifier son mot de passe
                        </a>
                        <a class="button" href="<?= Pa\Core\helpers::getUrl('user', 'editProfile') ?>">
                            Modifier son profile
                        </a>
                        <a class="button button--alert" href="<?= Pa\Core\helpers::getUrl('user', 'remove') ?>">
                            Supprimer son compte
                        </a>
                        <a class="button" href="<?= Pa\Core\helpers::getUrl('user', 'disconnect')?>">
                            Déconnexion
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>