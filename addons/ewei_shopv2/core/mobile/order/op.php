<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Op_EweiShopV2Page extends MobilePage
{
	public function cancel()
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC['id']);
		$order = pdo_fetch('select id,ordersn,openid,status,deductcredit,deductcredit2,deductprice,couponid from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if (empty($order)) {
			show_json(0, '订单未找到');
		}

		if (0 < $order['status']) {
			show_json(0, '订单已支付，不能取消!');
		}

		if ($order['status'] < 0) {
			show_json(0, '订单已经取消!');
		}

		m('order')->setStocksAndCredits($orderid, 2);
		pdo_update('ewei_shop_order', array('status' => -1, 'canceltime' => time(), 'closereason' => trim($_GPC['remark'])), array('id' => $order['id'], 'uniacid' => $_W['uniacid']));

		if (0 < $order['deductprice']) {
			m('member')->setCredit($order['openid'], 'credit1', $order['deductcredit'], array('0', $_W['shopset']['shop']['name'] . '购物返还抵扣积分 积分: ' . $order['deductcredit'] . ' 抵扣金额: ' . $order['deductprice'] . ' 订单号: ' . $order['ordersn']));
		}

		m('order')->setDeductCredit2($order);
		if (com('coupon') && !empty($order['couponid'])) {
			com('coupon')->returnConsumeCoupon($orderid);
		}

		m('notice')->sendOrderMessage($orderid);
		show_json(1);
	}

	public function finish()
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC['id']);
		$order = pdo_fetch('select id,status,openid,couponid,refundstate,refundid from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if (empty($order)) {
			show_json(0, '订单未找到');
		}

		if ($order['status'] != 2) {
			show_json(0, '订单不能确认收货');
		}

		if ((0 < $order['refundstate']) && !empty($order['refundid'])) {
			$change_refund = array();
			$change_refund['status'] = -2;
			$change_refund['refundtime'] = time();
			pdo_update('ewei_shop_order_refund', $change_refund, array('id' => $order['refundid'], 'uniacid' => $_W['uniacid']));
		}

		pdo_update('ewei_shop_order', array('status' => 3, 'finishtime' => time(), 'refundstate' => 0), array('id' => $order['id'], 'uniacid' => $_W['uniacid']));
		m('member')->upgradeLevel($order['openid']);
		m('order')->setGiveBalance($orderid, 1);
		if (com('coupon') && !empty($order['couponid'])) {
			com('coupon')->backConsumeCoupon($orderid);
		}

		m('notice')->sendOrderMessage($orderid);

		if (p('commission')) {
			p('commission')->checkOrderFinish($orderid);
		}

		show_json(1);
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC['id']);
		$order = pdo_fetch('select id,status,refundstate,refundid from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

		if (empty($order)) {
			show_json(0, '订单未找到!');
		}

		if (($order['status'] != 3) && ($order['status'] != -1)) {
			show_json(0, '无法删除');
		}

		if ((0 < $order['refundstate']) && !empty($order['refundid'])) {
			$change_refund = array();
			$change_refund['status'] = -2;
			$change_refund['refundtime'] = time();
			pdo_update('ewei_shop_order_refund', $change_refund, array('id' => $order['refundid'], 'uniacid' => $_W['uniacid']));
		}

		pdo_update('ewei_shop_order', array('userdeleted' => 1, 'refundstate' => 0), array('id' => $order['id'], 'uniacid' => $_W['uniacid']));
		show_json(1);
	}
}

?>
