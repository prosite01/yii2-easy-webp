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
    /**
     * Generate and get path to the webp file
     * @param  string $img
     * @return string|null
     */
    public static function webp($img)
    {
        $imgFullPath = Yii::getAlias('@webroot') . $img;

        if (file_exists($imgFullPath) === false) {
            return null;
        }
        
		$fileSize = filesize($imgFullPath);
		if ($fileSize === 0) {
			return null;
		}

		$fileInfo = pathinfo($imgFullPath);
		$extension = strtolower($fileInfo['extension']);
        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            return null;
        }

        $webpFileName = $fileInfo['filename'] . '.webp';
		$webpFullPath = $fileInfo['dirname']  . '/' . $webpFileName;
        if (file_exists($webpFullPath)) {
            return static::returnWebpPath($img);
        }

        $alpha = false;
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $tmpImg = imagecreatefromjpeg($imgFullPath);
                break;
            case 'png':
                $tmpImg = imagecreatefrompng($imgFullPath);
                $alpha = true;
                break;
        }
        if ($alpha) {
            imagepalettetotruecolor($tmpImg);
            imagealphablending($tmpImg, true);
            imagesavealpha($tmpImg, true);
        }
        imagewebp($tmpImg, $webpFullPath, 80);
        imagedestroy($tmpImg);

        if (filesize($webpFullPath) >= $fileSize) {
            return null;
        }
        return static::returnWebpPath($img);
    }

    private static function returnWebpPath($img)
    {
        $imgPath = pathinfo($img);
        return $imgPath['dirname']  . '/' . $imgPath['filename'] . '.webp';
    }
}
