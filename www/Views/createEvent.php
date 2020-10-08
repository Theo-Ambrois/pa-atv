<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Créer un événement</h1>
            </div>
            <?php if (isset($errors)) { ?>
                <p><ul>
                    <?php
                    foreach($errors as $e) {
                        echo "<li style='color:red'>• " . $e . "</li><br>";
                    } ?>
                </ul></p>
            <?php } ?>
            <?php $this->addModal("form", $configEventCreateForm); ?>
            <hr>
        </div>
    </div>
</div>