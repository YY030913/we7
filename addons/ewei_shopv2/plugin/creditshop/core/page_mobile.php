<?php

class CreditshopMobilePage extends PluginMobilePage
{
	public function footerMenus()
	{
		global $_W;
		global $_GPC;
		include $this->template('creditshop/_menu');
	}
}

?>
