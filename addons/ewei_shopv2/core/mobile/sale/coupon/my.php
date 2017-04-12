<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class My_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$set = m('common')->getPluginset('coupon');
		com('coupon')->setShare();
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$data = pdo_fetch('select * from ' . tablename('ewei_shop_coupon_data') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($data)) {
			if (empty($coupon)) {
				header('location: ' . webUrl('sale/coupon/my'));
				exit();
			}
		}

		$coupon = pdo_fetch('select * from ' . tablename('ewei_shop_coupon') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $data['couponid'], ':uniacid' => $_W['uniacid']));

		if (empty($coupon)) {
			header('location: ' . webUrl('sale/coupon/my'));
			exit();
		}

		$coupon['gettime'] = $data['gettime'];
		$coupon['back'] = $data['back'];
		$coupon['backtime'] = $data['backtime'];
		$coupon['used'] = $data['used'];
		$coupon['usetime'] = $data['usetime'];
		$time = time();
		$coupon = com('coupon')->setMyCoupon($coupon, $time);
		$num = pdo_fetchcolumn('select ifnull(count(*),0) from ' . tablename('ewei_shop_coupon_data') . ' where couponid=:couponid and openid=:openid and uniacid=:uniacid and used=0 ', array(':couponid' => $coupon['id'], ':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
		$canuse = !$coupon['past'] && empty($data['used']);
		$useurl = mobileUrl('goods');

		if ($coupon['coupontype'] == 1) {
			$useurl = mobileUrl('member/recharge');
		}

		$set = $_W['shopset']['coupon'];
		com('coupon')->setShare();
		include $this->template();
	}

	public function getlist()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$cate = trim($_GPC['cate']);

		if (!empty($cate)) {
			if ($cate == 'used') {
				$used = 1;
			}
			else {
				$past = 1;
			}
		}

		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$time = time();
		$sql = 'select d.id,d.couponid,d.gettime,c.timelimit,c.timedays,c.timestart,c.timeend,c.thumb,c.couponname,c.enough,c.backtype,c.deduct,c.discount,c.backmoney,c.backcredit,c.backredpack,c.bgcolor,c.thumb from ' . tablename('ewei_shop_coupon_data') . ' d';
		$sql .= ' left join ' . tablename('ewei_shop_coupon') . ' c on d.couponid = c.id';
		$sql .= ' where d.openid=:openid and d.uniacid=:uniacid ';

		if (!empty($past)) {
			$sql .= ' and  ( (c.timelimit =0 and c.timedays<>0 and  c.timedays*86400 + d.gettime <unix_timestamp()) or (c.timelimit=1 and c.timeend<unix_timestamp() ))';
		}
		else if (!empty($used)) {
			$sql .= ' and d.used =1 ';
		}
		else {
			if (empty($used)) {
				$sql .= ' and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=unix_timestamp() ) )  or  (c.timelimit =1 and c.timestart<=' . $time . ' && c.timeend>=' . $time . ')) and  d.used =0 ';
			}
		}

		$total = pdo_fetchcolumn($sql, array(':openid' => $openid, ':uniacid' => $_W['uniacid']));
		$sql .= ' order by d.gettime desc  LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		$coupons = set_medias(pdo_fetchall($sql, array(':openid' => $openid, ':uniacid' => $_W['uniacid'])), 'thumb');

		foreach ($coupons as &$row) {
			$row = com('coupon')->setMyCoupon($row, $time);
		}

		unset($row);
		show_json(1, array('list' => $coupons, 'pagesize' => $psize, 'total' => $total));
	}
}

?>
