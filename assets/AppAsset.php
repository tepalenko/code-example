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
        'css/site.css',
        'css/asSwitch.min.css',
        'css/spectrum.css',
        '//learning-fe.checker-soft.com/build/css/style.min.css',
        '//fonts.googleapis.com/css?family=Montserrat:400,700,800&display=swap',
        '//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css'
    ];
    public $js = [
        'js/jquery-asSwitch.min.js',
        'js/ckeditor.js',
        'js/spectrum.js',
        '//learning-fe.checker-soft.com/build/js/main.min.js',
        'js/custom.js',
        '//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
