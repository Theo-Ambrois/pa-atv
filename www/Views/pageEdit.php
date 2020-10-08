<div class="col-10 margin-left-auto">
    <div class="row">
        <div class="col-12">
            <div class="card card--isFull">
                <div class="row">
                    <div class="col-12">
                        <head>
                            <meta charset="utf-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1">
                            <script src="https://cdn.tiny.cloud/1/7dm3a6o9utq6mfv0fpw3mzkdf6k71onmi6jwmnintbnmxeoa/tinymce/5/tinymce.min.js"
                                    referrerpolicy="origin">
                            </script>
                            <script>
                                tinymce.init({
                                    selector: '#mytextarea'
                                });
                            </script>
                        </head>
                        <body>
                        <?php if (isset($errors)) {
                            foreach($errors as $e) {
                                echo "<p style='color: red; margin: 0;'>".$e."</p><br>";
                            }
                        }
                        ?>
                        <h1>Modifier votre page !</h1>
                        <form method="post"
                              action="<?= Pa\Core\helpers::getUrl('page', 'edit', ['id' => $_GET['id']]) ?>">
                            <label>Le titre de votre page :</label>
                            <input id="title" type="text" name="title" value="<?= urldecode($page['title']) ?>"><br>
                            <label>Dans quel onglet se trouvera cette page ? </label>
                            <select name="menu">
                                <?php foreach ($menu as $k => $v): ?>
                                    <?php if ($_GET['id'] !== '1' && $_GET['id'] !== '2'): ?>
                                        <option value="<?= $k ?>"><?= $v ?></option>
                                    <?php elseif ($k == $_GET['id']): ?>
                                        <option value="<?= $k ?>"><?= $v ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <textarea id="mytextarea" style="min-height: 50vh"
                                      name="content"><?= $page['content'] ?></textarea>
                            <button type="submit" class="button">Modifier</button>
                        </form>
                        </body>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>