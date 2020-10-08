<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card card--isFull">
                <?php 
                if (isset($errors)) {
                    foreach ($errors as $e)
                        echo $e;
                }
                
                $this->addModal("form", $configFormRole, $roleInfo); ?>
            </div>
        </div>
    </div>
</div>