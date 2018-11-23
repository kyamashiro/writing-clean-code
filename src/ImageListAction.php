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
    /**
     * @var array
     */
    public $paths = [
        'Food' => './data/images/food/*',
        'Animal' => './data/images/animal/*',
        'Landscape' => './data/images/landscape/*'
    ];

    /**
     * @var
     */
    public $file_list;

    /**
     *
     */
    public function actionResult(): void
    {
        foreach ($this->paths as $pic_category => $path) {
            $this->file_list[$pic_category] = $this->getFiles($path);
        }
    }

    /**
     * @param string $path
     * @return ImageFiles
     */
    private function getFiles(string $path): ImageFiles
    {
        $files = glob($path);
        return new ImageFiles($files, $path);
    }
}