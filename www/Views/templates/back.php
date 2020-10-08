<?php
use Pa\Core\helpers;
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
        <link href="/webpack/dist/main.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- <script type="text/javascript" src="webpack/src/js/script.js"></script> -->

        <title><?= $title ?></title>
    </head>
    <body>
        <div class="container">
            <div class="row --isSpaceBetween">
                <p class="col-2 title" style="position: fixed"><?= $tabName ?></p>
                <input placeholder="Search" class="col-2" id="search-input"/>
                <a href="<?= helpers::getUrl('user', 'showProfile') ?>" class="col-1">
                    <img src="/webpack/img/user-icon.png" class="icons">
                </a>
            </div>
            <div class="column">
                <div class="row col-12">
                    <!-- Column 1 : Menu-->
                    <div class="col-2 bg-template bg-template--fixed menuBack">
                        <ul>
                            <li><a href="<?= helpers::getUrl("default", "default") ?>">DASHBOARD</a></li>
                            <li><a href="<?= helpers::getUrl("user", "list") ?>">UTILISATEURS</a></li>
                            <li><a href="<?= helpers::getUrl("page", "list") ?>">PAGES</a></li>
                            <li><a href="<?= helpers::getUrl("menu", "list") ?>">MENU</a></li>
                            <li><a href="<?= helpers::getUrl("event", "default") ?>">EVENEMENTS</a></li>
                            <li><a href="<?= helpers::getUrl("planning", "list") ?>">PLANNING</a></li>
                            <li><a href="<?= helpers::getUrl("document", "list") ?>">DOCUMENTS</a></li>
                            <li><a href="<?= helpers::getUrl("mark", "list") ?>">NOTES</a></li>
                            <li><a href="<?= helpers::getUrl("role", "list") ?>">ROLES</a></li>
                            <li><a href="<?= helpers::getUrl("sitemap", "create") ?>">SITEMAP</a></li>
                        </ul>
                    </div>

                    <?php include "Views/".$this->view.".php";?>

                </div>
            </div>
        </div>
    </body>
</html>
