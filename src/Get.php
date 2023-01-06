<?php

namespace prosite\EasyWebp;

use Yii;

/**
 * Get only the paths to the webp file.
 * Example:
 * 
 * ```php
 * return \prosite\EasyWebp\Get::webp('/img/portfolio/image.png');
 * ```
 * 
 * This code will return the following string: /img/portfolio/image.webp
 * 
 */
class Get
{
    use ConvertorTrait;

    /**
     * Get path to the webp file
     * @param  string $img
     * @return string|null
     */
    public static function webp($img)
    {
        $imgFullPath = Yii::getAlias('@webroot') . $img;
        $fileInfo = pathinfo($imgFullPath);
        $webpFileName = $fileInfo['filename'] . '.webp';
        $webpFullPath = $fileInfo['dirname']  . '/' . $webpFileName;

        if (!is_file($imgFullPath)) {
            return null;
        }

        $originalFileSize = filesize($imgFullPath);

        if (file_exists($webpFullPath)) {
            return (filesize($webpFullPath) < $originalFileSize) ? static::getWebpPath($img) : null;
        }

        if (!static::createWebp($fileInfo, $webpFullPath, $originalFileSize)) {
            return null;
        }

        return static::getWebpPath($img);
    }
}
