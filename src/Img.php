<?php

namespace prosite\EasyWebp;


/**
 * Widget allows you to convert jpg and png to webp
 * 
 * How to use:
 * 
 * ```php
 * <?= \prosite\EasyWebp\Img::widget(['src' => '/img/portfolio/image.png', 'alt' => 'Example Image' ]) ?>
 * ```
 *
 * This code will generate the following block:
 *
 * ```html
 * <picture>
 *     <source type='image/webp' srcset='/img/portfolio/image.webp'>
 *     <img src='/img/portfolio/image.png' alt='Example Image'>
 * </picture>
 * ```
 * 
 * If you want to get only the paths to the original file and webp, then use the Get method.
 * Example:
 * 
 * ```php
 * return \prosite\EasyWebp\Get::files('/img/portfolio/image.png');
 * ```
 * 
 * This code will return the following array:
 * 
 *  [
 *      original => /img/portfolio/image.png,
 *      webp => /img/portfolio/image.webp
 *  ]
 * 
 */
class Img extends \yii\base\Widget
{
    public function run()
    {
        return 'Hello!';
    }
}
