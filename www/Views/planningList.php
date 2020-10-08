<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card card--isHalf">
                <?php foreach ($plannings as $k => $v): ?>
                    <div>
                        <a href="<?= Pa\Core\helpers::getUrl("planning", "show", ['id'=>$k]) ?>" style="color: black"><?= $v ?></a>
                        <a style="color: blue" href="<?= Pa\Core\helpers::getUrl("planning", "edit", ['id'=>$k]) ?>"> Modifier </a>
                        <a style="color: red" href="<?= Pa\Core\helpers::getUrl("planning", "remove", ['id'=>$k]) ?>"> Supprimer </a>
                    </div>
                <?php endforeach;?>
                <a class="button" href="<?= Pa\Core\helpers::getUrl("planning", "create")?>">Créer un planning</a>
            </div>
        </div>
    </div>
</div>

