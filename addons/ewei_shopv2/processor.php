<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require IA_ROOT . '/addons/ewei_shopv2/version.php';
require IA_ROOT . '/addons/ewei_shopv2/defines.php';
require EWEI_SHOPV2_INC . 'functions.php';
require EWEI_SHOPV2_INC . 'processor.php';
require EWEI_SHOPV2_INC . 'plugin_model.php';
require EWEI_SHOPV2_INC . 'com_model.php';
class Ewei_shopv2ModuleProcessor extends Processor
{
	public function respond()
	{
		return parent::respond();
	}
}

?>
