<div class="container">
    <div class="row no-wrap">
        <div class="col-offset-3"></div>
        <div class="col-6">
            <div class="card" style="padding: 2% 10% 0 10%">
                <?php if (isset($errors)) {
                    echo $errors;
                } ?>
                <h1 class="h4 text-gray-900 mb-4 text-align-center">Installation !</h1>
                <?php $this->addModal("form", $configForm); ?>
            </div>
        </div>
    </div>
</div>
