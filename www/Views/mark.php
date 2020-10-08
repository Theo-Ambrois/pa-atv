<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card card--isHalf">
                <a class="button" href="<?= Pa\Core\helpers::getUrl("mark", "create")?>">Créer une note</a>
                <?php foreach ($marks as $k => $v) {?>
                    <div>
                        <?= $v?>
                        <a style="color: blue" href="<?= Pa\Core\helpers::getUrl("mark", "edit", ['id'=>$k]) ?>"> Modifier </a>
                        <a style="color: red" href="<?= Pa\Core\helpers::getUrl("mark", "remove", ['id'=>$k]) ?>"> Supprimer</a>
                    </div>
                <?php 
            } ?>
            </div>
        </div>
    </div>
</div>
