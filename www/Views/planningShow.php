<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row">
                    <div class="col-12">
                        <p>
                            Cours :
                        </p>
                    </div>
                    <?php foreach ($courses as $course): ?>
                        <div class="col-3">
                            <div class="card card--isBig">
                            <p> Cours de :
                                <?= $course['matiere'] ?>
                            </p>
                            <p> Enseigné par :
                                <?= $course["teacher"] ?>
                            </p>
                            <p> Début à :
                                <?= $course["date_start"] ?>
                            </p>
                            <p> Fin à :
                                <?= $course['date_end'] ?>
                            </p>
                            <a style="color: blue" href="<?= Pa\Core\helpers::getUrl("course", "edit", ['id'=>$course['id_course']]) ?>">Modifier</a>
                            <a style="color: red;" href="<?= Pa\Core\helpers::getUrl("course", "remove", ['id'=>$course['id_course']]) ?>">Supprimer</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>
                            Evenement :
                        </p>
                    </div>
                    <?php foreach ($events as $event): ?>
                        <div class="col-3">
                            <div class="card card--isBig">
                                <p> Nom :
                                    <?= $event['event_name'] ?>
                                </p>
                                <p> Description :
                                    <?= $event["description"] ?>
                                </p>
                                <p> Se déroule à :
                                    <?= $event["place"] ?>
                                </p>
                                <p> Début à :
                                    <?= $event['date_start'] ?>
                                </p>
                                <p> Fin à :
                                    <?= $event['date_end'] ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a  class="button" href="<?= Pa\Core\helpers::getUrl("course", "create") ?>">Ajouter un cours</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>