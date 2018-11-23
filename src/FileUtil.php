<?php
/**
 * Created by PhpStorm.
 * User: ky
 * Date: 2018/11/23
 * Time: 18:44
 */

class FileUtil
{
    public static function sizeOfFiles($file): int
    {
        $totalSize = 0;
        foreach ($file as $item) {
            $totalSize = filesize($item);
        }
        return $totalSize;
    }
}