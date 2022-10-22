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
	/**
	 * @var string path (example: /img/portfolio/image.png)
	 */
	public $src;

	/**
	 * @var string image options, class, width, alt and other (optional)
	 */
	public $options = [];

	/**
	 * @var array files path to return  
	 */
	private $_files;

	public function init()
	{
		parent::init();

		$this->_files = Get::files($this->src);
	}

    public function run()
    {
        $files = $this->_files;
        
		$originalImg = Html::img($this->src, $this->options);
        
        $return  = Html::beginTag('picture');
		if (!empty($files['webp'])) {
            $return .= Html::tag("source", [], ["srcset" => $files['webp'], "type" => "image/webp"]);
		}
        $return .= $originalImg;
        $return .= Html::endTag('picture');

        return $return;
    }
}
