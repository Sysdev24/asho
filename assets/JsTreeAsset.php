<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main app application asset bundle.
 */
class JsTreeAsset extends AssetBundle
{
    public $sourcePath = '@app/themes/basic/assets/vendor/jstree';
    public $css = [
        'dist/themes/default/style.min.css',
        'dist/themes/default/fontawesome-style.css',
    ];
    public $js = [
        'dist/jstree.min.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $depends = [
        'app\assets\AppAsset',
    ];
    public $publishOptions = [
        'only' => [
            //'js/*',
        ],
        'forceCopy'=> YII_ENV_DEV ? true : false,
    ];
}
