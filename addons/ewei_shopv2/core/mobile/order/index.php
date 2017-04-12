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
		$trade = m('common')->getSysset('trade');
		include $this->template();
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 50;
		$status = $_GPC['status'];
		$r_type = array('退款', '退货退款', '换货');
		$condition = ' and openid=:openid  and userdeleted=0 and deleted=0 and uniacid=:uniacid ';
		$params = array(':uniacid' => $uniacid, ':openid' => $openid);

		if ($status != '') {
			$status = intval($status);

			if ($status != 4) {
				if ($status == 2) {
					$condition .= ' and (status=2 or status=0 and paytype=3)';
				}
				else if ($status == 0) {
					$condition .= ' and status=0 and paytype!=3';
				}
				else {
					$condition .= ' and status=' . intval($status);
				}
			}
			else {
				$condition .= ' and refundstate>0';
			}
		}

		$com_verify = com('verify');
		$list = pdo_fetchall("select id,addressid,ordersn,price,dispatchprice,status,iscomment,isverify,\nverified,verifycode,verifytype,iscomment,refundid,expresscom,express,expresssn,finishtime,virtual,\npaytype,expresssn,refundstate,dispatchtype,verifyinfo\n from " . tablename('ewei_shop_order') . ' where 1 ' . $condition . ' order by createtime desc LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where 1 ' . $condition, $params);
		$refunddays = intval($_W['shopset']['trade']['refunddays']);

		foreach ($list as &$row) {
			$sql = 'SELECT og.goodsid,og.total,g.title,g.thumb,og.price,og.optionname as optiontitle,og.optionid,op.specs FROM ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on og.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' op on og.optionid = op.id ' . ' where og.orderid=:orderid order by og.id asc';
			$goods = pdo_fetchall($sql, array(':orderid' => $row['id']));

			foreach ($goods as &$r) {
				if (!empty($r['specs'])) {
					$thumb = m('goods')->getSpecThumb($r['specs']);

					if (!empty($thumb)) {
						$r['thumb'] = $thumb;
					}
				}
			}

			unset($r);
			$row['goods'] = set_medias($goods, 'thumb');

			foreach ($row['goods'] as &$r) {
				$r['thumb'] .= '?t=' . random(50);
			}

			unset($r);
			$statuscss = 'text-cancel';

			switch ($row['status']) {
			case '-1':
				$status = '已取消';
				break;

			case '0':
				if ($row['paytype'] == 3) {
					$status = '待发货';
				}
				else {
					$status = '待付款';
				}

				$statuscss = 'text-cancel';
				break;

			case '1':
				if ($row['isverify'] == 1) {
					$status = '使用中';
				}
				else if (empty($row['addressid'])) {
					$status = '待取货';
				}
				else {
					$status = '待发货';
				}

				$statuscss = 'text-warning';
				break;

			case '2':
				$status = '待收货';
				$statuscss = 'text-danger';
				break;

			case '3':
				if (empty($row['iscomment'])) {
					$status = (empty($_W['shopset']['trade']['closecomment']) ? '待评价' : '已完成');
				}
				else {
					$status = '交易完成';
				}

				$statuscss = 'text-success';
			}

			$row['statusstr'] = $status;
			$row['statuscss'] = $statuscss;
			if ((0 < $row['refundstate']) && !empty($row['refundid'])) {
				$refund = pdo_fetch('select * from ' . tablename('ewei_shop_order_refund') . ' where id=:id and uniacid=:uniacid and orderid=:orderid limit 1', array(':id' => $row['refundid'], ':uniacid' => $uniacid, ':orderid' => $row['id']));

				if (!empty($refund)) {
					$row['statusstr'] = '待' . $r_type[$refund['rtype']];
				}
			}

			$canrefund = false;
			$row['canrefund'] = $canrefund;
			$row['canverify'] = false;
			$canverify = false;

			if ($com_verify) {
				$showverify = $row['dispatchtype'] || $row['isverify'];

				if ($row['isverify']) {
					if (($row['verifytype'] == 0) || ($row['verifytype'] == 1)) {
						$vs = iunserializer($row['verifyinfo']);
						$verifyinfo = array(
							array('verifycode' => $row['verifycode'], 'verified' => $row['verifytype'] == 0 ? $row['verified'] : $row['goods'][0]['total'] <= count($vs))
							);

						if ($row['verifytype'] == 0) {
							$canverify = empty($row['verified']) && $showverify;
						}
						else {
							if ($row['verifytype'] == 1) {
								$canverify = (count($vs) < $row['goods'][0]['total']) && $showverify;
							}
						}
					}
					else {
						$verifyinfo = iunserializer($row['verifyinfo']);
						$last = 0;

						foreach ($verifyinfo as $v) {
							if (!$v['verified']) {
								++$last;
							}
						}

						$canverify = (0 < $last) && $showverify;
					}
				}
				else {
					if (!empty($row['dispatchtype'])) {
						$canverify = ($row['status'] == 1) && $showverify;
					}
				}
			}

			$row['canverify'] = $canverify;
		}

		unset($row);
		show_json(1, array('list' => $list, 'pagesize' => $psize, 'total' => $total));
	}

	public function alipay()
	{
		global $_W;
		global $_GPC;
		$url = urldecode($_GPC['url']);
		include $this->template();
	}

	public function detail()
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

		if (!empty($order['userdeleted'])) {
			$this->message('订单已经被删除!', '', 'error');
		}

		$diyform_plugin = p('diyform');
		$diyformfields = '';

		if ($diyform_plugin) {
			$diyformfields = ',og.diyformfields,og.diyformdata';
		}

		$goods = pdo_fetchall('select og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,og.optionname as optiontitle,g.isverify,g.storeids' . $diyformfields . '  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.uniacid=:uniacid ', array(':uniacid' => $uniacid, ':orderid' => $orderid));

		if (!empty($goods)) {
			foreach ($goods as &$g) {
				if (!empty($g['optionid'])) {
					$thumb = m('goods')->getOptionThumb($g['goodsid'], $g['optionid']);

					if (!empty($thumb)) {
						$g['thumb'] = $thumb;
					}
				}
			}
		}

		$diyform_flag = 0;

		if ($diyform_plugin) {
			foreach ($goods as &$g) {
				$g['diyformfields'] = iunserializer($g['diyformfields']);
				$g['diyformdata'] = iunserializer($g['diyformdata']);
				unset($g);
			}

			if (!empty($order['diyformfields']) && !empty($order['diyformdata'])) {
				$order_fields = iunserializer($order['diyformfields']);
				$order_data = iunserializer($order['diyformdata']);
			}
		}

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
		$showverify = false;
		$canverify = false;
		$verifyinfo = false;

		if (com('verify')) {
			$showverify = $order['dispatchtype'] || $order['isverify'];

			if ($order['isverify']) {
				$storeids = array();

				foreach ($goods as $g) {
					if (!empty($g['storeids'])) {
						$storeids = array_merge(explode(',', $g['storeids']), $storeids);
					}
				}

				if (empty($storeids)) {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
				}
				else {
					$stores = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1 and type in(2,3)', array(':uniacid' => $_W['uniacid']));
				}

				if (($order['verifytype'] == 0) || ($order['verifytype'] == 1)) {
					$vs = iunserializer($order['verifyinfo']);
					$verifyinfo = array(
						array('verifycode' => $order['verifycode'], 'verified' => $order['verifytype'] == 0 ? $order['verified'] : $goods[0]['total'] <= count($vs))
						);

					if ($order['verifytype'] == 0) {
						$canverify = empty($order['verified']) && $showverify;
					}
					else {
						if ($order['verifytype'] == 1) {
							$canverify = (count($vs) < $goods[0]['total']) && $showverify;
						}
					}
				}
				else {
					$verifyinfo = iunserializer($order['verifyinfo']);
					$last = 0;

					foreach ($verifyinfo as $v) {
						if (!$v['verified']) {
							++$last;
						}
					}

					$canverify = (0 < $last) && $showverify;
				}
			}
			else {
				if (!empty($order['dispatchtype'])) {
					$verifyinfo = array(
						array('verifycode' => $order['verifycode'], 'verified' => $order['status'] == 3)
						);
					$canverify = ($order['status'] == 1) && $showverify;
				}
			}
		}

		$order['canverify'] = $canverify;
		$order['showverify'] = $showverify;
		$order['virtual_str'] = str_replace("\n", '<br/>', $order['virtual_str']);
		if (($order['status'] == 1) || ($order['status'] == 2)) {
			$canrefund = true;
			if (($order['status'] == 2) && ($order['price'] == $order['dispatchprice'])) {
				if (0 < $order['refundstate']) {
					$canrefund = true;
				}
				else {
					$canrefund = false;
				}
			}
		}
		else {
			if ($order['status'] == 3) {
				if (($order['isverify'] != 1) && empty($order['virtual'])) {
					if (0 < $order['refundstate']) {
						$canrefund = true;
					}
					else {
						$tradeset = m('common')->getSysset('trade');
						$refunddays = intval($tradeset['refunddays']);

						if (0 < $refunddays) {
							$days = intval((time() - $order['finishtime']) / 3600 / 24);

							if ($days <= $refunddays) {
								$canrefund = true;
							}
						}
					}
				}
			}
		}

		$order['canrefund'] = $canrefund;
		$express = false;

		if (2 <= $order['status']) {
			$expresslist = m('util')->getExpressList($order['express'], $order['expresssn']);

			if (0 < count($expresslist)) {
				$express = $expresslist[0];
			}
		}

		include $this->template();
	}

	public function express()
	{
		global $_W;
		global $_GPC;
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
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

		if (empty($order['addressid'])) {
			$this->message('订单非快递单，无法查看物流信息!');
		}

		if ($order['status'] < 2) {
			$this->message('订单未发货，无法查看物流信息!');
		}

		$goods = pdo_fetchall('select og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,og.optionname as optiontitle,g.isverify,g.storeids' . $diyformfields . '  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' where og.orderid=:orderid and og.uniacid=:uniacid ', array(':uniacid' => $uniacid, ':orderid' => $orderid));
		$expresslist = m('util')->getExpressList($order['express'], $order['expresssn']);
		include $this->template();
	}
}

?>
