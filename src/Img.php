<?php

namespace prosite\EasyWebp;

use yii\helpers\Html;

/**
 * Widget allows you to convert jpg and png to webp
 * 
 * How to use:
 * 
 * ```php
 * <?= \prosite\EasyWebp\Img::widget(['src' => '/img/portfolio/image.png', 'options' => ['alt' => 'Example Image']]) ?>
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
 */
class Img extends \yii\base\Widget
{
    /**
     * @var string path (example: /img/portfolio/image.png)
     */
    public $src;

    /**
     * @var array image options, class, width, alt and other (optional)
     */
    public $options = [];

    /**
     * @var array files path to return  
     */
    private $_webp;

    public function init()
    {
        parent::init();

        $this->_webp = Get::webp($this->src);
    }

    public function run()
    {
        $return  = Html::beginTag('picture');
        if (!empty($this->_webp)) {
            $return .= Html::tag('source', '', ['srcset' => $this->_webp, 'type' => 'image/webp']);
        }
        $return .= Html::img($this->src, $this->options);
        $return .= Html::endTag('picture');

        return $return;
    }
}
