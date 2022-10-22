<?php

namespace prosite\EasyWebp;

use Yii;

class Get
{
    public static function files($img)
    {
        $imgFullPath = Yii::getAlias('@webroot') . $img;

        if (file_exists($imgFullPath) === false) {
            return false;
        }
        
		$fileSize = filesize($imgFullPath);
		if ($fileSize === 0) {
			return false;
		}

		$fileInfo = pathinfo($imgFullPath);
		$extension = strtolower($fileInfo['extension']);
        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            return static::returnPathsArray($img, false);
        }

        $webpFileName = $fileInfo['filename'] . '.webp';
		$webpFullPath = $fileInfo['dirname']  . '/' . $webpFileName;
        if (file_exists($webpFullPath)) {
            return static::returnPathsArray($img, true);
        }

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $tmpImg = imagecreatefromjpeg($imgFullPath);
                imagepalettetotruecolor($tmpImg);
                imagealphablending($tmpImg, true);
                imagesavealpha($tmpImg, true);
                imagewebp($tmpImg, $webpFullPath, 80);
                imagedestroy($tmpImg);
                break;
            case 'png':
                $tmpImg = imagecreatefrompng($imgFullPath);
                imagepalettetotruecolor($tmpImg);
                imagealphablending($tmpImg, true);
                imagesavealpha($tmpImg, true);
                imagewebp($tmpImg, $webpFullPath, 80);
                imagedestroy($tmpImg);
                break;
        }

        return static::returnPathsArray($img, true);
    }

    private static function returnPathsArray($img, $withWebp = false)
    {
        $imgPath = pathinfo($img);

        return [
            'original' => $img,
            'webp' => ($withWebp == true) ? $imgPath['dirname']  . '/' . $imgPath['filename'] . '.webp' : null
        ];
    }
}
