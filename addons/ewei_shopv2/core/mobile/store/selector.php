<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Selector_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$ids = trim($_GPC['ids']);
		$type = intval($_GPC['type']);
		$condition = '';

		if (!empty($ids)) {
			$condition = ' and id in(' . $ids . ')';
		}

		if ($type == 1) {
			$condition .= ' and type in(1,3) ';
		}
		else {
			if ($type == 2) {
				$condition .= ' and type in(2,3) ';
			}
		}

		$list = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 ' . $condition . ' order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid']));
		include $this->template();
	}
}

?>
