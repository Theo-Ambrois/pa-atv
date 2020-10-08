<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card card--isHalf">
                <?php foreach ($users as $k => $v): ?>
                    <div>
                        <?= $v ?>
                        <?php if ($k !== 1): ?>
                            <a style="color: blue"
                               href="<?= Pa\Core\helpers::getUrl("user", "editAdmin", ['id' => $k]) ?>"> Modifier </a>
                            <a style="color: red"
                               href="<?= Pa\Core\helpers::getUrl("user", "removeAdmin", ['id' => $k]) ?>">
                                Supprimer </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <a class="button" href="<?= Pa\Core\helpers::getUrl("user", "register") ?>">Créer un utilisateur</a>
            </div>
        </div>
    </div>
</div>

