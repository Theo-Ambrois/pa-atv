<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card">
                        <?php if (isset($errors)) {
                                  foreach($errors as $e) {
                                      echo $e."<br>";
                                  }
                              }
                        ?>
                        <?php $this->addModal("form", $configFormUser); ?>
            </div>
        </div>
    </div>
</div>