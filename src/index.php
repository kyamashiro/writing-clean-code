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
<?php foreach ($imagelist->file_list as $pic_category => $list): ?>
    <h2>
        <?= $pic_category ?> Photos (<?= round($list->getSizeOfFiles() / 1024); ?>KB)
    </h2>
    <?php foreach ($list->getFiles() as $file_name) : ?>
        <ul>
            <li>
                <?= basename($file_name) ?>
            </li>
        </ul>
    <?php endforeach; ?>
<?php endforeach; ?>
</body>
</html>
