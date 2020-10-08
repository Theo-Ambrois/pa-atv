<div class="col-10 margin-left-auto">
    <!-- Model Big -->
    <div class="col-12 row ">
        <div class="card card--isFull">
            
            <h1><?=$event["event_name"] ?></h1>
            <p><b>Lieu</b> : <?=$event["place"] ?></p>
            <p><b>Description</b> : <?=$event["description"] ?></p>
            <p><b>Date de début</b> : <?="Le <b>" . $date[2] . "/" . $date[1] . "/" . $date[0] . "</b> à <b>" . $time[0] . "h" . $time[1] . "</b>" ?></p>
            <p><b>Durée</b> : <?=$formatedDuration ?></p>

            <a href="<?= Pa\Core\helpers::getUrl('event', 'edit', ['id'=>$_GET["id"]]) ?>" style="color: blue">Modifier</a>
            <a href="<?= Pa\Core\helpers::getUrl('event', 'delete', ['id'=>$_GET["id"]]) ?>" style="color: red">Supprimer</a>
            <br><br>
            <a href="<?= Pa\Core\helpers::getUrl('event', 'default') ?>" style="color: blue">Liste des événements</a>
            
        </div>
    </div>
</div>