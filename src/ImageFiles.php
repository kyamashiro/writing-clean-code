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
    private $path;
    private $files;
    private $sizeOfFiles;

    /**
     * ImageFiles constructor.
     * @param $files
     * @param string $path
     */
    public function __construct(array $files, string $path)
    {
        $this->files = $files;
        $this->path = $path;
        $this->sizeOfFiles = FileUtil::sizeOfFiles($files);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @return mixed
     */
    public function getSizeOfFiles(): int
    {
        return $this->sizeOfFiles;
    }
}