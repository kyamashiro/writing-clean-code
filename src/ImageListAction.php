<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2018/11/23
 * Time: 16:30
 */

class ImageListAction
{
    public $food_files = [];
    public $animal_files = [];
    public $lands_scape_files = [];
    public $food_size;
    public $animal_size;
    public $land_scape_size;

    public function actionResult()
    {
        $this->food_files = glob('./data/images/food/*');
        $this->animal_files = glob('./data/images/animal/*');
        $this->lands_scape_files = glob('./data/images/landscape/*');
        $this->food_size = $this->sizeOfFiles($this->food_files);
        $this->animal_size = $this->sizeOfFiles($this->animal_files);
        $this->land_scape_size = $this->sizeOfFiles($this->lands_scape_files);
    }

    public function sizeOfFiles($file): int
    {
        $totalSize = 0;
        foreach ($file as $item) {
            $totalSize = filesize($item);
        }
        return $totalSize;
    }
}