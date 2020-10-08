<div class="container">
    <div class="row no-wrap">
        <div class="col-offset-3"></div>
        <div class="col-6" style="margin-top: 25vh">
            <div class="card" style="padding: 2% 10%">
                <?php if (isset($errors)) {
                    echo $errors;
                }
                ?>
                <h1 class="text-align-center">Bienvenue !</h1>
                <?php $this->addModal("form", $configFormUser); ?>

                <div class="text-align-center">
                    <a class="small" style="color: black" href="<?= Pa\Core\helpers::getUrl("user", "forgotPwd") ?>">Forgot
                        Password?</a>
                </div>
            </div>
        </div>
    </div>
</div>
