<div class="col-10 margin-left-auto">
    <!-- Model Big -->
    <div class="col-12 row ">
        <div class="card card--isFull">
            
            <div class="row justify-content-center">
                <a href="<?= Pa\Core\helpers::getUrl("event", "create") ?>"><img src="webpack/img/addCross.svg" class="transfo shadow border-radius"></a>
            </div>
            
            <?php if(empty($events)) { ?>
                <div class="row justify-content-center ">
                    <h3>Aucun événement</h3>
                </div>
            <?php } else { ?>
                <div class="row">
                    <?php foreach ($events as $event) { 
                        $id = $event->getId();
                        $maxLength = 25;
                        strlen($event->getDescription()) > $maxLength ? $desc = substr($event->getDescription(), 0, $maxLength) . "..." : $desc = $event->getDescription();
                        ?>
                        <div class="col-2">
                            <div class="card card--isMedium">
                                <div class="row">
                                    <p class="margin-auto justify-content-center"><b><?=$event->getEvent_Name() ?></b></p>
                                </div>
                                <p class="card-text">Lieu : <?=$event->getPlace() ?></p>
                                <p class="card-text margin-auto"><?=$desc ?></p>
                                <div class="row --isSpaceBetween margin-auto">
                                    <a href="<?= Pa\Core\helpers::getUrl('event', 'show', ['id'=>$id]) ?>" style="color: green">Voir</a>
                                    <a href="<?= Pa\Core\helpers::getUrl('event', 'edit', ['id'=>$id]) ?>" style="color: blue">Modifier</a>
                                    <a href="<?= Pa\Core\helpers::getUrl('event', 'delete', ['id'=>$id]) ?>" style="color: red">Supprimer</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>