<?php
/**
 * Asset manager for Yii2 Slick widget.
 * 
 * @author Evgeniy Chernishev <EvgeniyRRU@gmail.com>
 */

namespace evgeniyrru\yii2slick;

use yii\web\AssetBundle;

class SlickAsset extends AssetBundle
{
    public $sourcePath = '@bower/slick-carousel/';

    public $css = [
        'slick/slick.css',
    ];

    public $js = [
        'slick/slick.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
} 