<?php

namespace prosite\EasyWebp;

use Yii;

class Get
{
    public static function files($img)
    {
        $webpFile = null;
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

        $webpFileName = $fileInfo['filename'] . '.webp';
		$webpPath = $fileInfo['dirname']  . '/' . $webpFileName;

        if (file_exists($webpPath)) {
            $webpFile = $webpPath;
        }

        return static::returnPathsArray($img, $webpFile);
    }

    private static function returnPathsArray($img, $webp = false)
    {
        $imgPath = pathinfo($img);

        return [
            'original' => $img,
            'webp' => ($webp === true) ? $imgPath['dirname']  . '/' . $imgPath['filename'] . '.webp' : null
        ];
    }
}
