<div class="col-10 margin-left-auto">
    <!-- Model Big -->
    <div class="col-12 row ">
        <div class="card card--isFull">
            <div class="row justify-content-center ">
                <h3>Upload de document</h3>
            </div>
            <div class="row justify-content-center">
                <form action="document-upload" method="post" enctype="multipart/form-data">
                    Select file to upload:
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <input type="submit" value="Upload file" name="submit">
                </form>
            </div>

            <div>
                <ul>
                    <?php foreach ($documents as $k => $v) {?>
                    <div>
                        <?= $v; ?>
                        <a style="color: blue" href="<?= Pa\Core\helpers::getUrl("document", "download", ['id'=>$k]) ?>"> Download </a>
                        <a style="color: red" href="<?= Pa\Core\helpers::getUrl("document", "delete", ['id'=>$k]) ?>"> Supprimer</a>
                    </div>
                <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>