<?php

namespace app\assets;
use yii\web\AssetBundle;

class TabletAsset extends AssetBundle{
	public $basePath = "@webroot";
	public $baseUrl = "@web";
	public $css = [
		'css/tablet.css',		
	];

	public $js = [
		'js/tablet-menu.js'
	];
}