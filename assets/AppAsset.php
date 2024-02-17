<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css?v=1',
    ];
    public $js = [
        //'js/scripts.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        $this->css = self::getCss();
        $this->js = self::getJs();
    }

    public function getCss()
    {
        return [
            'css/site.css?v='.mt_rand(1000,10000),
        ];
    }

    public function getJs()
    {
        return [
            'js/scripts.js?v='.mt_rand(1000,10000),
        ];
    }
}
