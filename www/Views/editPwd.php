<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-6 margin-auto">
            <div class="card card--isHalf">
                <div class="row">
                    <?php if (isset($errors)) {
                        foreach($errors as $e) {
                            echo $e."<br>";
                        }
                    }
                    ?>
                    <div class="col-12">
                        <?= $this->addModal("form", $configEditPwdForm); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
