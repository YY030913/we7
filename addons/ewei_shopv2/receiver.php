<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Ewei_shopv2ModuleReceiver extends WeModuleReceiver
{
	public function receive()
	{
		$type = $this->message['type'];
	}
}

?>
