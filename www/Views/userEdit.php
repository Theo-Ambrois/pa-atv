<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card card--isFull">
                <div class="row">
                    <div class="col-12">
                        <?php if (isset($errors)) {
                            foreach($errors as $e) {
                                echo $e."<br>";
                            }
                        }
                        ?>
                        <div class="col-12">
                            <?= $this->addModal("form", $configEditProfileForm, $userInfo); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
