<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2018/11/23
 * Time: 16:30
 */

namespace App;

class ImageListAction
{
    public $food_files = [];
    public $animal_files = [];
    public $lands_scape_files = [];

    public function actionResult()
    {
        $this->food_files = $this->getFiles('./data/images/food/*');
        $this->animal_files = $this->getFiles('./data/images/animal/*');
        $this->lands_scape_files = $this->getFiles('./data/images/landscape/*');
    }

    private function getFiles(string $path): ImageFiles
    {
        $files = glob($path);
        return new ImageFiles($files, FileUtil::sizeOfFiles($files));
    }
}