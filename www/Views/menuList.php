<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card card--isHalf">
                <div class="row">
                    <div class="col-6">
                        <div class="col-12">
                            <?php foreach ($menus as $k => $v): ?>
                            <?php if($k !== count($menus)): ?>
                                <a href="<?= Pa\Core\helpers::getUrl('menu', 'modifyPosition', ['pos'=>$k, 'up'=>'true']) ?>" style="color: green"><img src="webpack/img/arrow_down.png" class="arrows"></a></a>
                            <?php endif; ?>
                            <?php if($k !== 1): ?>
                                <a href="<?= Pa\Core\helpers::getUrl('menu', 'modifyPosition', ['pos'=>$k, 'up'=>'false']) ?>" style="color: green"><img src="webpack/img/arrow_up.png" class="arrows"></a>
                            <?php endif; ?>
                                <?= $v ?>
                                <?php if($v !== 'Index' && $v !== 'Contact'): ?>
                                    <a href="<?= Pa\Core\helpers::getUrl('menu', 'edit', ['pos'=>$k]) ?>" style="color: blue">Modifier</a>
                                    <a href="<?= Pa\Core\helpers::getUrl('menu', 'delete', ['pos'=>$k]) ?>" style="color: red">Supprimer</a>
                                <?php endif; ?>
                                <br>
                            <?php endforeach; ?>


                            <?php if (count($menus) < 12):?>
                                <a class="button" href="<?= Pa\Core\helpers::getUrl("menu", "create") ?>">Créer un onglet (12 maximums)</a>
                            <?php  else: ?>
                                <p>Onglets limités a 12</p>
                            <?php  endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>