JPG and PNG to WEBP converter
=============================

The converter allows one line to display the html tag `<picture>` containing the source file and webp

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist prosite01/yii2-easy-webp "dev-master"
```

or add

```
"prosite01/yii2-easy-webp": "dev-master"
```

to the require section of your `composer.json` file.

Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \prosite\EasyWebp\Img::widget(['src' => '/img/portfolio/image.png', 'options' => ['alt' => 'Example Image']]); ?>
```
