<?php
ini_set('display_errors', "On");
require '../vendor/autoload.php';
$imagelist = new App\ImageListAction();
$imagelist->actionResult();
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h2>
    Food Photos (<?= round($imagelist->food_files->getsizeOfFiles() / 1024); ?>KB)
</h2>
<ul>
    <?php foreach ($imagelist->food_files->getFiles() as $item): ?>
        <li>
            <?= basename($item) ?>
        </li>
    <?php endforeach; ?>
</ul>
<h2>
    Animal Photos (<?= round($imagelist->animal_files->getsizeOfFiles()  / 1024); ?>KB)
</h2>
<ul>
    <?php foreach ($imagelist->animal_files->getFiles() as $item): ?>
        <li>
            <?= basename($item) ?>
        </li>
    <?php endforeach; ?>
</ul>
<h2>
    Landscape Photos (<?= round($imagelist->lands_scape_files->getsizeOfFiles()  / 1024); ?>KB)
</h2>
<ul>
    <?php foreach ($imagelist->lands_scape_files->getFiles() as $item): ?>
        <li>
            <?= basename($item) ?>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
