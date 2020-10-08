<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card card--isHalf">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12">
                            <?php foreach ($pages as $k => $v): ?>
                                <a href="<?= $v ?>" style="color: black"><?= urldecode($v) ?></a>
                                <a href="<?= Pa\Core\helpers::getUrl('page', 'edit', ['id'=>$k]) ?>" style="color: blue">Modifier</a>
                            <?php if($k !== 1 && $k !== 2): ?>
                                <a href="<?= Pa\Core\helpers::getUrl('page', 'delete', ['id'=>$k]) ?>" style="color: red">Supprimer</a>
                            <?php endif; ?>
                                <br>
                            <?php endforeach; ?>
                            <a class="button" href="<?= Pa\Core\helpers::getUrl("page", "create") ?>">Créer une page</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>