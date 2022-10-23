<?php

namespace prosite\EasyWebp;

use Yii;

trait ConvertorTrait
{
    /**
     * Convert original image to webp 
     * @param  array $fileInfo
     * @param  string $webpFullPath
     * @return string|null
     */
    private static function createWebp($fileInfo, $webpFullPath)
    {
		$extension = strtolower($fileInfo['extension']);
        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
            return null;
        }

        $sourceImage = $fileInfo['dirname']  . '/' . $fileInfo['basename'];
        try {
            $alpha = false;
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $tmpImg = imagecreatefromjpeg($sourceImage);
                    break;
                case 'png':
                    $tmpImg = imagecreatefrompng($sourceImage);
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
        } catch (\Throwable $ex) {
            Yii::warning('An error occurred while converting the image: ' . $ex->getMessage());
            return null;
        }
    }
}
