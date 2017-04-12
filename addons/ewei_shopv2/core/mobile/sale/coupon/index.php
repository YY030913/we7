<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$cateid = trim($_GPC['catid']);
		$set = m('common')->getPluginset('coupon');

		if (!empty($set['closecenter'])) {
			header('location: ' . mobileUrl('member'));
			exit();
		}

		$advs = (is_array($set['advs']) ? $set['advs'] : array());
		$shop = m('common')->getSysset('shop');
		$category = pdo_fetchall('select * from ' . tablename('ewei_shop_coupon_category') . ' where uniacid=:uniacid and status=1 order by displayorder desc', array(':uniacid' => $_W['uniacid']));
		include $this->template();
	}

	public function getlist()
	{
		global $_W;
		global $_GPC;
		$cateid = trim($_GPC['cateid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$time = time();
		$sql = 'select id,timelimit,timedays,timestart,timeend,thumb,couponname,enough,backtype,deduct,discount,backmoney,backcredit,backredpack,bgcolor,thumb,credit,money,getmax from ' . tablename('ewei_shop_coupon') . ' c ';
		$sql .= ' where uniacid=:uniacid and gettype=1 and (total=-1 or total>0) and ( timelimit = 0 or  (timelimit=1 and timeend>unix_timestamp()))';

		if (!empty($cateid)) {
			$sql .= ' and catid=' . $cateid;
		}

		$total = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid']));
		$sql .= ' order by displayorder desc, id desc  LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		$coupons = set_medias(pdo_fetchall($sql, array(':uniacid' => $_W['uniacid'])), 'thumb');

		foreach ($coupons as &$row) {
			$row = com('coupon')->setCoupon($row, $time);
		}

		unset($row);
		show_json(1, array('list' => $coupons, 'pagesize' => $psize, 'total' => $total));
	}
}

?>
