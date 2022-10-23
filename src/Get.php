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

        if (is_file($imgFullPath) === false) {
            return null;
        }
        
		$fileSize = filesize($imgFullPath);
		if ($fileSize === 0) {
			return null;
		}

		$fileInfo = pathinfo($imgFullPath);
        $webpFileName = $fileInfo['filename'] . '.webp';
		$webpFullPath = $fileInfo['dirname']  . '/' . $webpFileName;
        if (file_exists($webpFullPath)) {
            return static::returnWebpPath($img);
        }

        if (!static::createWebp($fileInfo, $webpFullPath)) {
            return null;
        }   

        if (filesize($webpFullPath) >= $fileSize) {
            return null;
        }
        
        return static::returnWebpPath($img);
    }
    
    /**
     * Return Webp path as string
     * @param  string $img path to original image file. Example: /img/portfolio/image.jpg
     * @return string /img/portfolio/image.webp
     */
    private static function returnWebpPath($img)
    {
        $imgPath = pathinfo($img);
        return $imgPath['dirname']  . '/' . $imgPath['filename'] . '.webp';
    }
}
