<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Pay_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$member = m('member')->getMember($openid, true);
		$orderid = intval($_GPC['id']);

		if (empty($orderid)) {
			header('location: ' . mobileUrl('order'));
			exit();
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

		if (empty($order)) {
			header('location: ' . mobileUrl('order'));
			exit();
		}

		if ($order['status'] == -1) {
			header('location: ' . mobileUrl('order/detail', array('id' => $order['id'])));
			exit();
		}
		else {
			if (1 <= $order['status']) {
				header('location: ' . mobileUrl('order/detail', array('id' => $order['id'])));
				exit();
			}
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $uniacid, ':module' => 'ewei_shopv2', ':tid' => $order['ordersn']));
		if (!empty($log) && ($log['status'] != '0')) {
			header('location: ' . mobileUrl('order/detail', array('id' => $order['id'])));
			exit();
		}

		if (!empty($log) && ($log['status'] == '0')) {
			pdo_delete('core_paylog', array('plid' => $log['plid']));
			$log = NULL;
		}

		if (empty($log)) {
			$log = array('uniacid' => $uniacid, 'openid' => $member['uid'], 'module' => 'ewei_shopv2', 'tid' => $order['ordersn'], 'fee' => $order['price'], 'status' => 0);
			pdo_insert('core_paylog', $log);
			$plid = pdo_insertid();
		}

		$set = m('common')->getSysset(array('shop', 'pay'));
		$param_title = $set['shop']['name'] . '订单';
		$credit = array('success' => false);
		if (isset($set['pay']) && ($set['pay']['credit'] == 1) && ($log['fee'] <= $member['credit2'])) {
			$credit = array('success' => true, 'current' => $member['credit2']);
		}

		load()->model('payment');
		$setting = uni_setting($_W['uniacid'], array('payment'));
		$wechat = array('success' => false);

		if (is_weixin()) {
			if (isset($set['pay']) && ($set['pay']['weixin'] == 1)) {
				if (is_array($setting['payment']['wechat']) && $setting['payment']['wechat']['switch']) {
					$params = array();
					$params['tid'] = $log['tid'];

					if (!empty($order['ordersn2'])) {
						$var = sprintf('%02d', $order['ordersn2']);
						$params['tid'] .= 'GJ' . $var;
					}

					$params['user'] = $openid;
					$params['fee'] = $order['price'];
					$params['title'] = $param_title;
					load()->model('payment');
					$setting = uni_setting($_W['uniacid'], array('payment'));

					if (is_array($setting['payment'])) {
						$options = $setting['payment']['wechat'];
						$options['appid'] = $_W['account']['key'];
						$options['secret'] = $_W['account']['secret'];
						$wechat = m('common')->wechat_build($params, $options, 0);

						if (!is_error($wechat)) {
							$wechat['success'] = true;
						}
					}
				}
			}
		}

		$alipay = array('success' => false);
		if (isset($set['pay']) && ($set['pay']['alipay'] == 1)) {
			if (is_array($setting['payment']['alipay']) && $setting['payment']['alipay']['switch']) {
				$params = array();
				$params['tid'] = $log['tid'];
				$params['user'] = $_W['openid'];
				$params['fee'] = $order['price'];
				$params['title'] = $param_title;
				load()->func('communication');
				load()->model('payment');
				$setting = uni_setting($_W['uniacid'], array('payment'));

				if (is_array($setting['payment'])) {
					$options = $setting['payment']['alipay'];
					$alipay = m('common')->alipay_build($params, $options, 0, $_W['openid']);

					if (!empty($alipay['url'])) {
						$alipay['url'] = urlencode($alipay['url']);
						$alipay['success'] = true;
					}
				}
			}
		}

		$cash = array('success' => ($order['cash'] == 1) && isset($set['pay']) && ($set['pay']['cash'] == 1));
		$payinfo = array('orderid' => $orderid, 'credit' => $credit, 'alipay' => $alipay, 'wechat' => $wechat, 'cash' => $cash);
		include $this->template();
	}

	public function complete()
	{
		global $_W;
		global $_GPC;
		$orderid = intval($_GPC['id']);
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];

		if (empty($orderid)) {
			show_json(0, '参数错误');
		}

		$set = m('common')->getSysset(array('shop', 'pay'));
		$member = m('member')->getMember($openid, true);
		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));

		if (empty($order)) {
			show_json(0, '订单未找到');
		}

		$type = $_GPC['type'];

		if (!in_array($type, array('wechat', 'alipay', 'credit', 'cash'))) {
			show_json(0, '未找到支付方式');
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $uniacid, ':module' => 'ewei_shopv2', ':tid' => $order['ordersn']));

		if (empty($log)) {
			show_json(0, '支付出错,请重试!');
		}

		$order_goods = pdo_fetchall('select og.id,g.title, og.goodsid,og.optionid,g.total as stock,og.total as buycount,g.status,g.deleted,g.maxbuy,g.usermaxbuy,g.istime,g.timestart,g.timeend,g.buylevels,g.buygroups,g.totalcnf from  ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id ' . ' where og.orderid=:orderid and og.uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $orderid));

		foreach ($order_goods as $data) {
			if (empty($data['status']) || !empty($data['deleted'])) {
				show_json(0, $data['title'] . '<br/> 已下架!');
			}

			$unit = (empty($data['unit']) ? '件' : $data['unit']);

			if (0 < $data['minbuy']) {
				if ($data['buycount'] < $data['minbuy']) {
					show_json(0, $data['title'] . '<br/> ' . $data['min'] . $unit . '起售!', mobileUrl('order'));
				}
			}

			if (0 < $data['maxbuy']) {
				if ($data['maxbuy'] < $data['buycount']) {
					show_json(0, $data['title'] . '<br/> 一次限购 ' . $data['maxbuy'] . $unit . '!');
				}
			}

			if (0 < $data['usermaxbuy']) {
				$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $data['goodsid'], ':uniacid' => $uniacid, ':openid' => $openid));

				if ($data['usermaxbuy'] <= $order_goodscount) {
					show_json(0, $data['title'] . '<br/> 最多限购 ' . $data['usermaxbuy'] . $unit);
				}
			}

			if ($data['istime'] == 1) {
				if (time() < $data['timestart']) {
					show_json(0, $data['title'] . '<br/> 限购时间未到!');
				}

				if ($data['timeend'] < time()) {
					show_json(0, $data['title'] . '<br/> 限购时间已过!');
				}
			}

			if ($data['buylevels'] != '') {
				$buylevels = explode(',', $data['buylevels']);

				if (!in_array($member['level'], $buylevels)) {
					show_json(0, '您的会员等级无法购买<br/>' . $data['title'] . '!');
				}
			}

			if ($data['buygroups'] != '') {
				$buygroups = explode(',', $data['buygroups']);

				if (!in_array($member['groupid'], $buygroups)) {
					show_json(0, '您所在会员组无法购买<br/>' . $data['title'] . '!');
				}
			}

			if ($data['totalcnf'] == 1) {
				if (!empty($data['optionid'])) {
					$option = pdo_fetch('select id,title,marketprice,goodssn,productsn,stock,virtual from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $data['goodsid'], ':id' => $data['optionid']));

					if (!empty($option)) {
						if ($option['stock'] != -1) {
							if (empty($option['stock'])) {
								show_json(0, $data['title'] . '<br/>' . $option['title'] . ' 库存不足!');
							}
						}
					}
				}
				else {
					if ($data['stock'] != -1) {
						if (empty($data['stock'])) {
							show_json(0, $data['title'] . '<br/>库存不足!');
						}
					}
				}
			}
		}

		if ($type == 'cash') {
			if (empty($set['pay']['cash'])) {
				show_json(0, '未开启货到付款!');
			}

			pdo_update('ewei_shop_order', array('paytype' => 3), array('id' => $order['id']));
			$ret = array();
			$ret['result'] = 'success';
			$ret['type'] = 'cash';
			$ret['from'] = 'return';
			$ret['tid'] = $log['tid'];
			$ret['user'] = $order['openid'];
			$ret['fee'] = $order['price'];
			$ret['weid'] = $_W['uniacid'];
			$ret['uniacid'] = $_W['uniacid'];
			$pay_result = m('order')->payResult($ret);
			@session_start();
			$_SESSION[EWEI_SHOPV2_PREFIX . '_order_pay_complete'] = 1;
			show_json(1, $pay_result);
		}

		$ps = array();
		$ps['tid'] = $log['tid'];
		$ps['user'] = $openid;
		$ps['fee'] = $log['fee'];
		$ps['title'] = $log['title'];

		if ($type == 'credit') {
			if (empty($set['pay']['credit'])) {
				show_json(0, '未开启余额支付!');
			}

			$credits = m('member')->getCredit($openid, 'credit2');

			if ($credits < $ps['fee']) {
				show_json(0, '余额不足,请充值');
			}

			$fee = floatval($ps['fee']);
			$result = m('member')->setCredit($openid, 'credit2', 0 - $fee, array($_W['member']['uid'], $_W['shopset']['shop']['name'] . '消费' . $fee));

			if (is_error($result)) {
				show_json(0, $result['message']);
			}

			$record = array();
			$record['status'] = '1';
			$record['type'] = 'cash';
			pdo_update('core_paylog', $record, array('plid' => $log['plid']));
			$ret = array();
			$ret['result'] = 'success';
			$ret['type'] = $log['type'];
			$ret['from'] = 'return';
			$ret['tid'] = $log['tid'];
			$ret['user'] = $log['openid'];
			$ret['fee'] = $log['fee'];
			$ret['weid'] = $log['weid'];
			$ret['uniacid'] = $log['uniacid'];
			@session_start();
			$_SESSION[EWEI_SHOPV2_PREFIX . '_order_pay_complete'] = 1;
			$pay_result = m('order')->payResult($ret);
			pdo_update('ewei_shop_order', array('paytype' => 1), array('id' => $order['id']));
			show_json(1, $pay_result);
			return NULL;
		}

		if ($type == 'wechat') {
			if (!is_weixin()) {
				show_json(0, '非微信环境!');
			}

			if (empty($set['pay']['weixin'])) {
				show_json(0, '未开启微信支付!');
			}

			$ordersn = $order['ordersn'];

			if (!empty($order['ordersn2'])) {
				$ordersn .= 'GJ' . sprintf('%02d', $order['ordersn2']);
			}

			$payquery = m('finance')->isWeixinPay($ordersn, $order['price']);

			if (!is_error($payquery)) {
				$record = array();
				$record['status'] = '1';
				$record['type'] = 'wechat';
				pdo_update('core_paylog', $record, array('plid' => $log['plid']));
				$ret = array();
				$ret['result'] = 'success';
				$ret['type'] = 'wechat';
				$ret['from'] = 'return';
				$ret['tid'] = $log['tid'];
				$ret['user'] = $log['openid'];
				$ret['fee'] = $log['fee'];
				$ret['weid'] = $log['weid'];
				$ret['uniacid'] = $log['uniacid'];
				$ret['deduct'] = intval($_GPC['deduct']) == 1;
				$pay_result = m('order')->payResult($ret);
				@session_start();
				$_SESSION[EWEI_SHOPV2_PREFIX . '_order_pay_complete'] = 1;
				pdo_update('ewei_shop_order', array('paytype' => 21), array('id' => $order['id']));
				show_json(1, $pay_result);
			}

			show_json(0, '支付出错,请重试!');
		}
	}

	public function alipay_complete()
	{
		global $_GPC;
		global $_W;
		$set = m('common')->getSysset(array('shop', 'pay'));

		if (empty($set['pay']['alipay'])) {
			exit('未开启支付宝支付!');
		}

		$tid = $_GPC['out_trade_no'];

		if (!m('finance')->isAlipayNotify($_GET)) {
			exit('支付出现错误，请重试!');
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('core_paylog') . ' WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1', array(':uniacid' => $_W['uniacid'], ':module' => 'ewei_shopv2', ':tid' => $tid));

		if (empty($log)) {
			exit('支付出现错误，请重试!');
		}

		if ($log['status'] != 1) {
			$record = array();
			$record['status'] = '1';
			$record['type'] = 'alipay';
			pdo_update('core_paylog', $record, array('plid' => $log['plid']));
			$ret = array();
			$ret['result'] = 'success';
			$ret['type'] = 'alipay';
			$ret['from'] = 'return';
			$ret['tid'] = $log['tid'];
			$ret['user'] = $log['openid'];
			$ret['fee'] = $log['fee'];
			$ret['weid'] = $log['weid'];
			$ret['uniacid'] = $log['uniacid'];
			m('order')->payResult($ret);
		}

		$orderid = pdo_fetchcolumn('select id from ' . tablename('ewei_shop_order') . ' where ordersn=:ordersn and uniacid=:uniacid', array(':ordersn' => $log['tid'], ':uniacid' => $_W['uniacid']));

		if (!empty($orderid)) {
			pdo_update('ewei_shop_order', array('paytype' => 22), array('id' => $orderid));
		}

		$url = mobileUrl('order/detail', array('id' => $orderid), true);
		exit('<script>top.window.location.href=\'' . $url . '\'</script>');
	}

	public function success()
	{
		@session_start();

		if (!isset($_SESSION[EWEI_SHOPV2_PREFIX . '_order_pay_complete'])) {
			header('location: ' . mobileUrl('order'));
			exit();
		}

		unset($_SESSION[EWEI_SHOPV2_PREFIX . '_order_pay_complete']);
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$member = m('member')->getMember($openid, true);
		$orderid = intval($_GPC['id']);

		if (empty($orderid)) {
			$this->message('参数错误', mobileUrl('order'), 'error');
		}

		$order = pdo_fetch('select * from ' . tablename('ewei_shop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(':id' => $orderid, ':uniacid' => $uniacid, ':openid' => $openid));
		$goods = pdo_fetchall('select og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,og.optionname as optiontitle,g.isverify,g.storeids from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.uniacid=:uniacid ', array(':uniacid' => $uniacid, ':orderid' => $orderid));
		$address = false;

		if (!empty($order['addressid'])) {
			$address = iunserializer($order['address']);

			if (!is_array($address)) {
				$address = pdo_fetch('select * from  ' . tablename('ewei_shop_member_address') . ' where id=:id limit 1', array(':id' => $order['addressid']));
			}
		}

		$carrier = @iunserializer($order['carrier']);
		if (!is_array($carrier) || empty($carrier)) {
			$carrier = false;
		}

		$store = false;

		if (!empty($order['storeid'])) {
			$store = pdo_fetch('select * from  ' . tablename('ewei_shop_store') . ' where id=:id limit 1', array(':id' => $order['storeid']));
		}

		$stores = false;

		if ($order['isverify']) {
			$storeids = array();

			foreach ($goods as $g) {
				if (!empty($g['storeids'])) {
					$storeids = array_merge(explode(',', $g['storeids']), $storeids);
				}
			}

			if (empty($storeids)) {
				$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1', array(':uniacid' => $_W['uniacid']));
			}
			else {
				$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1', array(':uniacid' => $_W['uniacid']));
			}
		}

		include $this->template();
	}
}

?>
