<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Map_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$store = pdo_fetch('select * from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$store['logo'] = empty($store['logo']) ? $_W['shopset']['shop']['logo'] : $store['logo'];
		include $this->template();
	}
}

?>
