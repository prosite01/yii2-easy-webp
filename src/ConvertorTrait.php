<?php

namespace prosite\EasyWebp;

use Yii;

trait ConvertorTrait
{
    /**
     * Convert original image to webp 
     * 
     * @param  array $fileInfo File information for the original image
     * @param  string $webpFullPath Full path to the output webp file
     * @param  int $originalFileSize Original file size in bytes
     * @return bool True if the conversion was successful, false otherwise
     */
    private static function createWebp($fileInfo, $webpFullPath, $originalFileSize)
    {
        if (!preg_match('/^(jpg|jpeg|png|gif)$/i', $fileInfo['extension'])) {
            self::createErrorLog('Unsupported file type: ' . ($fileInfo['extension'] ?? ''));
            return false;
        }

        if ($originalFileSize === 0) {
            self::createErrorLog('Empty original image');
            return false;
        }

        $imgFullPath = $fileInfo['dirname'] . '/' . $fileInfo['basename'];

        if (!is_file($imgFullPath) || !is_readable($imgFullPath)) {
            self::createErrorLog('Cannot read file: ' . $imgFullPath);
            return false;
        }

        try {
            $imageType = exif_imagetype($imgFullPath);
            $imageData = file_get_contents($imgFullPath);
            $tmpImg = imagecreatefromstring($imageData);

            if ($imageType === IMAGETYPE_PNG || $imageType === IMAGETYPE_GIF) {
                imagepalettetotruecolor($tmpImg);
                imagealphablending($tmpImg, true);
                imagesavealpha($tmpImg, true);
            }
 
            $webpQuality = 80;
            do {
                imagewebp($tmpImg, $webpFullPath, $webpQuality);
                $webpQuality -= 5;
                if ($webpQuality < 50) break;
            } while (filesize($webpFullPath) > $originalFileSize);
            
            imagedestroy($tmpImg);
        } catch (\Throwable $ex) {
            self::createErrorLog('An error occurred while converting the image: ' . $ex->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Return Webp path as string
     * 
     * @param  string $img path to original image file. Example: /img/portfolio/image.jpg
     * @return string /img/portfolio/image.webp
     */
    private static function getWebpPath($img)
    {
        $imgPath = pathinfo($img);
        return "{$imgPath['dirname']}/{$imgPath['filename']}.webp";
    }
    
    /**
     * Create an entry in the Yii log file
     *
     * @param  string $message
     * @return void
     */
    private static function createErrorLog($message)
    {
        Yii::warning($message, self::class);
    }
}
