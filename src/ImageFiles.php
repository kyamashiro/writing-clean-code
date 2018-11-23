<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2018/11/23
 * Time: 19:22
 */

namespace App;

class ImageFiles
{
    private $files;
    private $sizeOfFiles;

    /**
     * ImageFiles constructor.
     * @param $files
     * @param $sizeOfFiles
     */
    public function __construct($files, $sizeOfFiles)
    {
        $this->files = $files;
        $this->sizeOfFiles = $sizeOfFiles;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return mixed
     */
    public function getSizeOfFiles()
    {
        return $this->sizeOfFiles;
    }
}