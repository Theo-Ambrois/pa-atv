<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="webpack/dist/main.css" rel="stylesheet">
    <script type="text/javascript" src="webpack/src/js/script.js"></script>
    <title><?= urldecode($page['title']) ?> </title>
</head>
<body>
<div class="container">
    <div class="row no-wrap">
        <div class="col-offset-1"></div>
        <div class="col-10">
            <!-- Menu -->
            <div class="row --isSpaceBetween menu menu--size-is-<?= $menuSize ?>">
                <nav>
                    <ul>
                        <?php
                            foreach ($tabs as $k => $v) {
                                if (count($v) === 0) {
                                  continue;
                                } else if (count($v) > 1) {
                                    echo "<li class='open'><a href='#'>".$k."</a>";
                                    echo " <ul class='under'>";
                                    foreach ($v as $value) {
                                        echo "<li><a href=".$value["title"].">".urldecode($value["title"])."</a></li>";
                                    }
                                    echo "</ul></li>";
                                } else  {
                                    echo "<li><a href=".$v[0]["title"].">".$k."</a></li>";
                                }
                            }
                        ?>
                    </ul>
                </nav>
            </div>
            <div>
                <?php include "Views/" . $this->view . ".php"; ?>
            </div>
        </div>
        <div class="col-2">
            <div class="row">
                <a href="<?= Pa\Core\helpers::getUrl('user', 'showProfile') ?>" class="col-1">
                    <img src="webpack/img/user-icon.png" class="icons"></a>
            </div>
        </div>
    </div>
</body>
</html>