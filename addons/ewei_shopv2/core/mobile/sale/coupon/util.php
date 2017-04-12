<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Util_EweiShopV2Page extends MobilePage
{
	public function query()
	{
		global $_W;
		global $_GPC;
		$type = intval($_GPC['type']);
		$money = floatval($_GPC['money']);
		$list = com_run('coupon::getAvailableCoupons', $type, $money);
		show_json(1, array('coupons' => $list));
	}

	public function picker()
	{
		include $this->template();
	}
}

?>
