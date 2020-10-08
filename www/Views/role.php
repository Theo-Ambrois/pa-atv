<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card card--isHalf">
                <?php foreach ($roles as $k => $v): ?>
                    <div>
                        <?= $v ?>
                        <?php if ($k !== 1): ?>
                            <a style="color: blue" href="<?= Pa\Core\helpers::getUrl("role", "edit", ['id' => $k]) ?>">
                                Modifier </a>
                            <a style="color: red" href="<?= Pa\Core\helpers::getUrl("role", "remove", ['id' => $k]) ?>">
                                Supprimer</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <a class="button" href="<?= Pa\Core\helpers::getUrl("role", "create") ?>">Créer un role</a>
            </div>
        </div>
    </div>
</div>

