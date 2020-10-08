<div class="container">
    <div class="row no-wrap">
        <div class="col-offset-3"></div>
        <div class="col-6" style="margin-top: 25vh">
            <div class="card" style="padding: 2% 10%">
                <div class="text-center">
                    <h1>Réinitaliser mot de passe</h1>
                    <?php if (isset($errors)) {
                        foreach ($errors as $e) {
                            echo $e . '<br>';
                        }
                    } ?>
                </div>
                <?php $this->addModal("form", $configFormUser); ?></div>
        </div>
    </div>
</div>