<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Create_EweiShopV2Page extends MobilePage
{
	protected function diyformData($member)
	{
		global $_W;
		global $_GPC;
		$diyform_plugin = p('diyform');
		$order_formInfo = false;
		$diyform_set = false;
		$orderdiyformid = 0;
		$fields = array();
		$f_data = array();

		if ($diyform_plugin) {
			$diyform_set = $_W['shopset']['diyform'];

			if (!empty($diyform_set['order_diyform_open'])) {
				$orderdiyformid = intval($diyform_set['order_diyform']);

				if (!empty($orderdiyformid)) {
					$order_formInfo = $diyform_plugin->getDiyformInfo($orderdiyformid);
					$fields = $order_formInfo['fields'];
					$f_data = $diyform_plugin->getLastOrderData($orderdiyformid, $member);
				}
			}
		}

		return array('diyform_plugin' => $diyform_plugin, 'order_formInfo' => $order_formInfo, 'diyform_set' => $diyform_set, 'orderdiyformid' => $orderdiyformid, 'fields' => $fields, 'f_data' => $f_data);
	}

	public function main()
	{
		global $_W;
		global $_GPC;
		$uniacid = $_W['uniacid'];
		$openid = $_W['openid'];
		$member = m('member')->getMember($openid, true);
		$level = m('member')->getLevel($openid);
		$diyformdata = $this->diyformData($member);
		extract($diyformdata);
		$id = intval($_GPC['id']);
		$optionid = intval($_GPC['optionid']);
		$total = intval($_GPC['total']);

		if ($total < 1) {
			$total = 1;
		}

		$buytotal = $total;
		$errcode = 0;
		$isverify = false;
		$isvirtual = false;
		$isvirtualsend = false;
		$changenum = false;
		$fromcart = 0;
		$hasinvoice = false;
		$invoicename = '';
		$goods = array();

		if (empty($id)) {
			$sql = 'SELECT c.goodsid,c.total,g.maxbuy,g.type,g.issendfree,g.isnodiscount' . ',g.weight,o.weight as optionweight,g.title,g.thumb,ifnull(o.marketprice, g.marketprice) as marketprice,o.title as optiontitle,c.optionid,' . ' g.storeids,g.isverify,g.deduct,g.manydeduct,g.virtual,o.virtual as optionvirtual,discounts,' . ' g.deduct2,g.ednum,g.edmoney,g.edareas,g.diyformtype,g.diyformid,diymode,g.dispatchtype,g.dispatchid,g.dispatchprice,g.minbuy ' . ' ,g.isdiscount,g.isdiscount_time,g.isdiscount_discounts, ' . ' g.virtualsend,invoice,o.specs' . ' FROM ' . tablename('ewei_shop_member_cart') . ' c ' . ' left join ' . tablename('ewei_shop_goods') . ' g on c.goodsid = g.id ' . ' left join ' . tablename('ewei_shop_goods_option') . ' o on c.optionid = o.id ' . ' where c.openid=:openid and c.selected=1 and  c.deleted=0 and c.uniacid=:uniacid  order by c.id desc';
			$goods = pdo_fetchall($sql, array(':uniacid' => $uniacid, ':openid' => $openid));

			if (empty($goods)) {
				$errcode = 1;
				include $this->template();
				exit();
			}
			else {
				foreach ($goods as $k => $v) {
					if (!empty($v['specs'])) {
						$thumb = m('goods')->getSpecThumb($v['specs']);

						if (!empty($thumb)) {
							$goods[$k]['thumb'] = $thumb;
						}
					}

					if (!empty($v['optionvirtual'])) {
						$goods[$k]['virtual'] = $v['optionvirtual'];
					}

					if (!empty($v['optionweight'])) {
						$goods[$k]['weight'] = $v['optionweight'];
					}
				}
			}

			$fromcart = 1;
		}
		else {
			$sql = 'SELECT id as goodsid,type,title,weight,issendfree,isnodiscount, ' . ' thumb,marketprice,storeids,isverify,deduct,' . ' manydeduct,virtual,maxbuy,usermaxbuy,discounts,total as stock,deduct2,showlevels,' . ' ednum,edmoney,edareas,' . ' diyformtype,diyformid,diymode,dispatchtype,dispatchid,dispatchprice,minbuy, ' . ' isdiscount,isdiscount_time,isdiscount_discounts, ' . ' virtualsend,invoice,needfollow,followtip,followurl' . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
			$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $id));
			if (empty($data) || (!empty($data['showlevels']) && !strexists($data['showlevels'], $member['level']))) {
				$err = true;
				include $this->template('goods/detail');
				exit();
			}

			$follow = m('user')->followed($openid);
			if (!empty($data['needfollow']) && !$follow) {
				$followtip = (empty($goods['followtip']) ? '如果您想要购买此商品，需要您关注我们的公众号，点击【确定】关注后再来购买吧~' : $goods['followtip']);
				$followurl = (empty($goods['followurl']) ? $_W['shopset']['share']['followurl'] : $goods['followurl']);
				$this->message($followtip, $followurl, 'error');
			}

			if ((0 < $data['minbuy']) && ($total < $data['minbuy'])) {
				$total = $data['minbuy'];
			}

			$data['total'] = $total;
			$data['optionid'] = $optionid;

			if (!empty($optionid)) {
				$option = pdo_fetch('select id,title,marketprice,goodssn,productsn,virtual,stock,weight,specs from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $id, ':id' => $optionid));

				if (!empty($option)) {
					$data['optionid'] = $optionid;
					$data['optiontitle'] = $option['title'];
					$data['marketprice'] = $option['marketprice'];
					$data['virtual'] = $option['virtual'];
					$data['stock'] = $option['stock'];

					if (!empty($option['weight'])) {
						$data['weight'] = $option['weight'];
					}

					if (!empty($option['specs'])) {
						$thumb = m('goods')->getSpecThumb($option['specs']);

						if (!empty($thumb)) {
							$data['thumb'] = $thumb;
						}
					}
				}
			}

			$changenum = true;
			$goods[] = $data;
		}

		$goods = set_medias($goods, 'thumb');

		foreach ($goods as &$g) {
			if ($g['isverify'] == 2) {
				$isverify = true;
			}

			if (!empty($g['virtual']) || ($g['type'] == 2)) {
				$isvirtual = true;

				if ($g['virtualsend']) {
					$isvirtualsend = true;
				}
			}

			if ($g['invoice']) {
				$hasinvoice = $g['invoice'];
			}

			$totalmaxbuy = $g['stock'];

			if (0 < $g['maxbuy']) {
				if ($totalmaxbuy != -1) {
					if ($g['maxbuy'] < $totalmaxbuy) {
						$totalmaxbuy = $g['maxbuy'];
					}
				}
				else {
					$totalmaxbuy = $g['maxbuy'];
				}
			}

			if (0 < $g['usermaxbuy']) {
				$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $g['goodsid'], ':uniacid' => $uniacid, ':openid' => $openid));
				$last = $data['usermaxbuy'] - $order_goodscount;

				if ($last <= 0) {
					$last = 0;
				}

				if ($totalmaxbuy != -1) {
					if ($last < $totalmaxbuy) {
						$totalmaxbuy = $last;
					}
				}
				else {
					$totalmaxbuy = $last;
				}
			}

			$g['totalmaxbuy'] = $totalmaxbuy;
			if (($g['totalmaxbuy'] < $g['total']) && !empty($g['totalmaxbuy'])) {
				$g['total'] = $g['totalmaxbuy'];
			}
		}

		unset($g);

		if ($hasinvoice) {
			$invoicename = pdo_fetchcolumn('select invoicename from ' . tablename('ewei_shop_order') . ' where openid=:openid and uniacid=:uniacid and ifnull(invoicename,\'\')<>\'\'', array(':openid' => $openid, ':uniacid' => $uniacid));

			if (empty($invoicename)) {
				$invoicename = $member['realname'];
			}
		}

		$weight = 0;
		$total = 0;
		$goodsprice = 0;
		$realprice = 0;
		$deductprice = 0;
		$discountprice = 0;
		$isdiscountprice = 0;
		$deductprice2 = 0;
		$stores = array();
		$address = false;
		$carrier = false;
		$carrier_list = array();
		$dispatch_list = false;
		$dispatch_price = 0;
		$dispatch_array = array();
		$carrier_list = false;
		if (!$isverify && !$isvirtual) {
			$carrier_list = pdo_fetchall('select * from ' . tablename('ewei_shop_store') . ' where  uniacid=:uniacid and status=1 and type in(1,3) order by displayorder desc,id desc', array(':uniacid' => $_W['uniacid']));
		}

		$sale_plugin = com('sale');
		$saleset = false;

		if ($sale_plugin) {
			$saleset = $_W['shopset']['sale'];
			$saleset['enoughs'] = $sale_plugin->getEnoughs();
		}

		foreach ($goods as &$g) {
			if (empty($g['total']) || (intval($g['total']) < 1)) {
				$g['total'] = 1;
			}

			$gprice = $g['marketprice'] * $g['total'];
			$prices = m('order')->getGoodsDiscountPrice($g, $level);
			$g['ggprice'] = $prices['price'];
			$g['dflag'] = intval($g['ggprice'] < $gprice);
			$discountprice += $prices['discountprice'];
			$isdiscountprice += $prices['isdiscountprice'];
			$realprice += $g['ggprice'];
			$goodsprice += $gprice;
			$total += $g['total'];

			if ($g['manydeduct']) {
				$deductprice += $g['deduct'] * $g['total'];
			}
			else {
				$deductprice += $g['deduct'];
			}

			if ($g['deduct2'] == 0) {
				$deductprice2 += $g['ggprice'];
			}
			else {
				if (0 < $g['deduct2']) {
					if ($g['ggprice'] < $g['deduct2']) {
						$deductprice2 += $g['ggprice'];
					}
					else {
						$deductprice2 += $g['deduct2'];
					}
				}
			}
		}

		unset($g);

		if ($isverify) {
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
		}
		else {
			$address = pdo_fetch('select id,realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where openid=:openid and deleted=0 and isdefault=1  and uniacid=:uniacid limit 1', array(':uniacid' => $uniacid, ':openid' => $openid));

			if (!empty($carrier_list)) {
				$carrier = $carrier_list[0];
			}

			if (!$isvirtual) {
				$dispatch_price = m('order')->getOrderDispatchPrice($goods, $member, $address, $saleset, 0);
			}
		}

		if ($saleset) {
			foreach ($saleset['enoughs'] as $e) {
				if ((floatval($e['enough']) <= $realprice) && (0 < floatval($e['money']))) {
					$saleset['showenough'] = true;
					$saleset['enoughmoney'] = $e['enough'];
					$saleset['enoughdeduct'] = $e['money'];
					$realprice -= floatval($e['money']);
					break;
				}
			}

			if (empty($saleset['dispatchnodeduct'])) {
				$deductprice2 += $dispatch_price;
			}
		}

		$realprice += $dispatch_price;
		$deductcredit = 0;
		$deductmoney = 0;
		$deductcredit2 = 0;

		if (!empty($saleset)) {
			if (!empty($saleset['creditdeduct'])) {
				$credit = $member['credit1'];
				$pcredit = intval($saleset['credit']);
				$pmoney = round(floatval($saleset['money']), 2);
				if ((0 < $pcredit) && (0 < $pmoney)) {
					if (($credit % $pcredit) == 0) {
						$deductmoney = round(intval($credit / $pcredit) * $pmoney, 2);
					}
					else {
						$deductmoney = round((intval($credit / $pcredit) + 1) * $pmoney, 2);
					}
				}

				if ($deductprice < $deductmoney) {
					$deductmoney = $deductprice;
				}

				if ($realprice < $deductmoney) {
					$deductmoney = $realprice;
				}

				if (($pmoney * $pcredit) != 0) {
					$deductcredit = ($deductmoney / $pmoney) * $pcredit;
				}
			}

			if (!empty($saleset['moneydeduct'])) {
				$deductcredit2 = m('member')->getCredit($openid, 'credit2');

				if ($realprice < $deductcredit2) {
					$deductcredit2 = $realprice;
				}

				if ($deductprice2 < $deductcredit2) {
					$deductcredit2 = $deductprice2;
				}
			}
		}

		$haslevel = !empty($level['id']) && (0 < $level['discount']) && ($level['discount'] < 10);
		$couponcount = com_run('coupon::consumeCouponCount', $openid, $realprice);
		$goodsdata = array();

		foreach ($goods as $g) {
			$goodsdata[] = array('goodsid' => $g['goodsid'], 'total' => $g['total'], 'optionid' => $g['optionid']);
		}

		$shareAddress = false;
		if ($_W['shopset']['trade']['shareaddress'] && is_weixin()) {
			$account = WeAccount::create();

			if (method_exists($account, 'getShareAddressConfig')) {
				$shareAddress = $account->getShareAddressConfig();
			}
		}

		$createInfo = array('id' => $id, 'gdid' => intval($_GPC['gdid']), 'fromcart' => $fromcart, 'addressid' => !empty($address) && !$isverify && !$isvirtual ? $address['id'] : 0, 'storeid' => !empty($carrier_list) && !$isverify && !$isvirtual ? $carrier_list[0]['id'] : 0, 'couponcount' => $couponcount, 'isvirtual' => $isvirtual, 'isverify' => $isverify, 'goods' => $goodsdata, 'orderdiyformid' => $orderdiyformid);
		include $this->template();
	}

	public function caculate()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$realprice = 0;
		$nowsendfree = false;
		$isverify = false;
		$isvirtual = false;
		$discountprice = 0;
		$isdiscountprice = 0;
		$deductprice = 0;
		$deductprice2 = 0;
		$deductcredit2 = 0;
		$dispatchid = intval($_GPC['dispatchid']);
		$totalprice = floatval($_GPC['totalprice']);
		$dflag = $_GPC['dflag'];
		$addressid = intval($_GPC['addressid']);
		$address = pdo_fetch('select id,realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where  id=:id and openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $uniacid, ':openid' => $openid, ':id' => $addressid));
		$member = m('member')->getMember($openid, true);
		$level = m('member')->getLevel($openid);
		$weight = floatval($_GPC['weight']);
		$dispatch_price = 0;
		$deductenough_money = 0;
		$deductenough_enough = 0;
		$goodsarr = $_GPC['goods'];

		if (is_array($goodsarr)) {
			$weight = 0;
			$allgoods = array();

			foreach ($goodsarr as &$g) {
				if (empty($g)) {
					continue;
				}

				$goodsid = $g['goodsid'];
				$optionid = $g['optionid'];
				$goodstotal = $g['total'];

				if ($goodstotal < 1) {
					$goodstotal = 1;
				}

				if (empty($goodsid)) {
					$nowsendfree = true;
				}

				$sql = 'SELECT id as goodsid,title,type, weight,total,issendfree,isnodiscount, thumb,marketprice,cash,isverify,goodssn,productsn,sales,istime,' . ' timestart,timeend,usermaxbuy,maxbuy,unit,buylevels,buygroups,deleted,status,deduct,manydeduct,virtual,' . ' discounts,deduct2,ednum,edmoney,edareas,diyformid,diyformtype,diymode,dispatchtype,dispatchid,dispatchprice,' . ' isdiscount,isdiscount_time,isdiscount_discounts ,virtualsend  ' . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
				$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $goodsid));

				if (empty($data)) {
					$nowsendfree = true;
				}

				$data['stock'] = $data['total'];
				$data['total'] = $goodstotal;

				if (!empty($optionid)) {
					$option = pdo_fetch('select id,title,marketprice,goodssn,productsn,stock,virtual,weight from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $goodsid, ':id' => $optionid));

					if (!empty($option)) {
						$data['optionid'] = $optionid;
						$data['optiontitle'] = $option['title'];
						$data['marketprice'] = $option['marketprice'];

						if (!empty($option['weight'])) {
							$data['weight'] = $option['weight'];
						}
					}
				}

				$prices = m('order')->getGoodsDiscountPrice($data, $level);
				$data['ggprice'] = $prices['price'];
				$discountprice += $prices['discountprice'];
				$isdiscountprice += $prices['isdiscountprice'];
				$realprice += $data['ggprice'];
				$allgoods[] = $data;
			}

			unset($g);
			$sale_plugin = com('sale');
			$saleset = false;

			if ($sale_plugin) {
				$saleset = $_W['shopset']['sale'];
				$saleset['enoughs'] = $sale_plugin->getEnoughs();
			}

			if ($saleset) {
				foreach ($saleset['enoughs'] as $e) {
					if ((floatval($e['enough']) <= $realprice) && (0 < floatval($e['money']))) {
						$deductenough_money = floatval($e['money']);
						$deductenough_enough = floatval($e['enough']);
						$realprice -= floatval($e['money']);
						break;
					}
				}

				if (!empty($saleset['enoughfree'])) {
					if (floatval($saleset['enoughorder']) <= 0) {
						$nowsendfree = true;
					}
				}
			}

			foreach ($allgoods as $g) {
				if ($g['isverify'] == 2) {
					$isverify = true;
				}

				if (!empty($g['virtual']) || ($g['type'] == 2)) {
					$isvirtual = true;
				}

				if ($g['manydeduct']) {
					$deductprice += $g['deduct'] * $g['total'];
				}
				else {
					$deductprice += $g['deduct'];
				}

				if ($g['deduct2'] == 0) {
					$deductprice2 += $g['ggprice'];
				}
				else {
					if (0 < $g['deduct2']) {
						if ($g['ggprice'] < $g['deduct2']) {
							$deductprice2 += $g['ggprice'];
						}
						else {
							$deductprice2 += $g['deduct2'];
						}
					}
				}
			}

			if ($isverify || $isvirtual) {
				$nowsendfree = true;
			}

			if (!empty($allgoods) && !$nowsendfree) {
				$dispatch_price = m('order')->getOrderDispatchPrice($allgoods, $member, $address, $saleset, 1);
			}

			if ($dflag != 'true') {
				if (empty($saleset['dispatchnodeduct'])) {
					$deductprice2 += $dispatch_price;
				}
			}

			$couponcount = com_run('coupon::consumeCouponCount', $openid, $realprice);
			$realprice += $dispatch_price;
			$deductcredit = 0;
			$deductmoney = 0;

			if (!empty($saleset)) {
				$credit = $member['credit1'];

				if (!empty($saleset['creditdeduct'])) {
					$pcredit = intval($saleset['credit']);
					$pmoney = round(floatval($saleset['money']), 2);
					if ((0 < $pcredit) && (0 < $pmoney)) {
						if (($credit % $pcredit) == 0) {
							$deductmoney = round(intval($credit / $pcredit) * $pmoney, 2);
						}
						else {
							$deductmoney = round((intval($credit / $pcredit) + 1) * $pmoney, 2);
						}
					}

					if ($deductprice < $deductmoney) {
						$deductmoney = $deductprice;
					}

					if ($realprice < $deductmoney) {
						$deductmoney = $realprice;
					}

					$deductcredit = (($pmoney * $pcredit) == 0 ? 0 : ($deductmoney / $pmoney) * $pcredit);
				}

				if (!empty($saleset['moneydeduct'])) {
					$deductcredit2 = $member['credit2'];

					if ($realprice < $deductcredit2) {
						$deductcredit2 = $realprice;
					}

					if ($deductprice2 < $deductcredit2) {
						$deductcredit2 = $deductprice2;
					}
				}
			}
		}

		$return_array = array();
		$return_array['price'] = $dispatch_price;
		$return_array['couponcount'] = $couponcount;
		$return_array['realprice'] = $realprice;
		$return_array['deductenough_money'] = $deductenough_money;
		$return_array['deductenough_enough'] = $deductenough_enough;
		$return_array['deductcredit2'] = $deductcredit2;
		$return_array['deductcredit'] = $deductcredit;
		$return_array['deductmoney'] = $deductmoney;
		$return_array['discountprice'] = $discountprice;
		$return_array['isdiscountprice'] = $isdiscountprice;
		show_json(1, $return_array);
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$member = m('member')->getMember($openid, true);
		$data = $this->diyformData($member);
		extract($data);
		$level = m('member')->getLevel($openid);
		$dispatchid = intval($_GPC['dispatchid']);
		$dispatchtype = intval($_GPC['dispatchtype']);
		$addressid = intval($_GPC['addressid']);
		$address = false;
		if (!empty($addressid) && ($dispatchtype == 0)) {
			$address = pdo_fetch('select id,realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where id=:id and openid=:openid and uniacid=:uniacid   limit 1', array(':uniacid' => $uniacid, ':openid' => $openid, ':id' => $addressid));

			if (empty($address)) {
				show_json(0, '未找到地址');
			}
		}

		$carrierid = intval($_GPC['carrierid']);
		$goods = $_GPC['goods'];
		if (empty($goods) || !is_array($goods)) {
			show_json(0, '未找到任何商品');
		}

		$allgoods = array();
		$totalprice = 0;
		$goodsprice = 0;
		$weight = 0;
		$discountprice = 0;
		$isdiscountprice = 0;
		$cash = 1;
		$deductprice = 0;
		$deductprice2 = 0;
		$virtualsales = 0;
		$dispatch_price = 0;
		$sale_plugin = com('sale');
		$saleset = false;

		if ($sale_plugin) {
			$saleset = $_W['shopset']['sale'];
			$saleset['enoughs'] = $sale_plugin->getEnoughs();
		}

		$isvirtual = false;
		$isverify = false;
		$verifytype = 0;
		$isvirtualsend = false;

		foreach ($goods as $g) {
			if (empty($g)) {
				continue;
			}

			$goodsid = intval($g['goodsid']);
			$optionid = intval($g['optionid']);
			$goodstotal = intval($g['total']);

			if ($goodstotal < 1) {
				$goodstotal = 1;
			}

			if (empty($goodsid)) {
				show_json(0, '参数错误');
			}

			$sql = 'SELECT id as goodsid,title,type, weight,total,issendfree,isnodiscount, thumb,marketprice,cash,isverify,verifytype,' . ' goodssn,productsn,sales,istime,timestart,timeend,' . ' usermaxbuy,minbuy,maxbuy,unit,buylevels,buygroups,deleted,' . ' status,deduct,manydeduct,virtual,discounts,deduct2,ednum,edmoney,edareas,diyformtype,diyformid,diymode,' . ' dispatchtype,dispatchid,dispatchprice, ' . ' isdiscount,isdiscount_time,isdiscount_discounts, virtualsend ' . ' FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
			$data = pdo_fetch($sql, array(':uniacid' => $uniacid, ':id' => $goodsid));
			if (empty($data['status']) || !empty($data['deleted'])) {
				show_json(0, $data['title'] . '<br/> 已下架!');
			}

			$virtualid = $data['virtual'];
			$data['stock'] = $data['total'];
			$data['total'] = $goodstotal;

			if ($data['cash'] != 2) {
				$cash = 0;
			}

			$unit = (empty($data['unit']) ? '件' : $data['unit']);

			if (0 < $data['minbuy']) {
				if ($goodstotal < $data['minbuy']) {
					show_json(0, $data['title'] . '<br/> ' . $data['minbuy'] . $unit . '起售!');
				}
			}

			if (0 < $data['maxbuy']) {
				if ($data['maxbuy'] < $goodstotal) {
					show_json(0, $data['title'] . '<br/> 一次限购 ' . $data['maxbuy'] . $unit . '!');
				}
			}

			if (0 < $data['usermaxbuy']) {
				$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $data['goodsid'], ':uniacid' => $uniacid, ':openid' => $openid));

				if ($data['usermaxbuy'] <= $order_goodscount) {
					show_json(0, $data['title'] . '<br/> 最多限购 ' . $data['usermaxbuy'] . $unit . '!');
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

			$levelid = intval($member['level']);
			$groupid = intval($member['groupid']);

			if ($data['buylevels'] != '') {
				$buylevels = explode(',', $data['buylevels']);

				if (!in_array($levelid, $buylevels)) {
					show_json(0, '您的会员等级无法购买<br/>' . $data['title'] . '!');
				}
			}

			if ($data['buygroups'] != '') {
				$buygroups = explode(',', $data['buygroups']);

				if (!in_array($groupid, $buygroups)) {
					show_json(0, '您所在会员组无法购买<br/>' . $data['title'] . '!');
				}
			}

			if (!empty($optionid)) {
				$option = pdo_fetch('select id,title,marketprice,goodssn,productsn,stock,virtual,weight from ' . tablename('ewei_shop_goods_option') . ' where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1', array(':uniacid' => $uniacid, ':goodsid' => $goodsid, ':id' => $optionid));

				if (!empty($option)) {
					if ($option['stock'] != -1) {
						if (empty($option['stock'])) {
							show_json(-1, $data['title'] . '<br/>' . $option['title'] . ' 库存不足!');
						}
					}

					$data['optionid'] = $optionid;
					$data['optiontitle'] = $option['title'];
					$data['marketprice'] = $option['marketprice'];
					$virtualid = $option['virtual'];

					if (!empty($option['goodssn'])) {
						$data['goodssn'] = $option['goodssn'];
					}

					if (!empty($option['productsn'])) {
						$data['productsn'] = $option['productsn'];
					}

					if (!empty($option['weight'])) {
						$data['weight'] = $option['weight'];
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

			$data['diyformdataid'] = 0;
			$data['diyformdata'] = iserializer(array());
			$data['diyformfields'] = iserializer(array());

			if (intval($_GPC['fromcart']) == 1) {
				if ($diyform_plugin) {
					$cartdata = pdo_fetch('select id,diyformdataid,diyformfields,diyformdata from ' . tablename('ewei_shop_member_cart') . ' ' . ' where goodsid=:goodsid and optionid=:optionid and openid=:openid and deleted=0 order by id desc limit 1', array(':goodsid' => $data['goodsid'], ':optionid' => intval($data['optionid']), ':openid' => $openid));

					if (!empty($cartdata)) {
						$data['diyformdataid'] = $cartdata['diyformdataid'];
						$data['diyformdata'] = $cartdata['diyformdata'];
						$data['diyformfields'] = $cartdata['diyformfields'];
					}
				}
			}
			else {
				if (!empty($data['diyformtype']) && $diyform_plugin) {
					$temp_data = $diyform_plugin->getOneDiyformTemp($_GPC['gdid'], 0);
					$data['diyformfields'] = $temp_data['diyformfields'];
					$data['diyformdata'] = $temp_data['diyformdata'];

					if ($data['diyformtype'] == 2) {
						$data['diyformid'] = 0;
					}
					else {
						$data['diyformid'] = $data['diyformid'];
					}
				}
			}

			$gprice = $data['marketprice'] * $goodstotal;
			$goodsprice += $gprice;
			$prices = m('order')->getGoodsDiscountPrice($data, $level);
			$data['ggprice'] = $prices['price'];
			$isdiscountprice += $prices['isdiscountprice'];
			$discountprice += $prices['discountprice'];
			$totalprice += $data['ggprice'];

			if ($data['isverify'] == 2) {
				$isverify = true;
				$verifytype = $data['verifytype'];
			}

			if (!empty($data['virtual']) || ($data['type'] == 2)) {
				$isvirtual = true;

				if ($data['virtualsend']) {
					$isvirtualsend = true;
				}
			}

			if ($data['manydeduct']) {
				$deductprice += $data['deduct'] * $data['total'];
			}
			else {
				$deductprice += $data['deduct'];
			}

			$virtualsales += $data['sales'];

			if ($data['deduct2'] == 0) {
				$deductprice2 += $data['ggprice'];
			}
			else {
				if (0 < $data['deduct2']) {
					if ($data['ggprice'] < $data['deduct2']) {
						$deductprice2 += $data['ggprice'];
					}
					else {
						$deductprice2 += $data['deduct2'];
					}
				}
			}

			$allgoods[] = $data;
		}

		if (empty($allgoods)) {
			show_json(0, '未找到任何商品');
		}

		$deductenough = 0;

		if ($saleset) {
			foreach ($saleset['enoughs'] as $e) {
				if ((floatval($e['enough']) <= $totalprice) && (0 < floatval($e['money']))) {
					$deductenough = floatval($e['money']);

					if ($totalprice < $deductenough) {
						$deductenough = $totalprice;
					}

					break;
				}
			}
		}

		if (!$isvirtual && !$isverify && ($dispatchtype == 0)) {
			$dispatch_price = m('order')->getOrderDispatchPrice($allgoods, $member, $address, $saleset, 2);
		}

		$couponid = intval($_GPC['couponid']);
		if (com('coupon') && !empty($couponid)) {
			$coupon = com('coupon')->getCouponByDataID($couponid);

			if (!empty($coupon)) {
				if (($coupon['enough'] <= $totalprice) && empty($coupon['used'])) {
					if ($coupon['backtype'] == 0) {
						if (0 < $coupon['deduct']) {
							$couponprice = $coupon['deduct'];
						}
					}
					else {
						if ($coupon['backtype'] == 1) {
							if (0 < $coupon['discount']) {
								$couponprice = $totalprice * (1 - ($coupon['discount'] / 10));
							}
						}
					}

					if (0 < $couponprice) {
						$totalprice -= $couponprice;
					}
				}
			}
		}

		$totalprice -= $deductenough;
		$totalprice += $dispatch_price;
		if ($saleset && empty($saleset['dispatchnodeduct'])) {
			$deductprice2 += $dispatch_price;
		}

		$deductcredit = 0;
		$deductmoney = 0;
		$deductcredit2 = 0;

		if ($sale_plugin) {
			if (!empty($_GPC['deduct'])) {
				$credit = $member['credit1'];
				$saleset = $_W['shopset']['sale'];

				if (!empty($saleset['creditdeduct'])) {
					$pcredit = intval($saleset['credit']);
					$pmoney = round(floatval($saleset['money']), 2);
					if ((0 < $pcredit) && (0 < $pmoney)) {
						if (($credit % $pcredit) == 0) {
							$deductmoney = round(intval($credit / $pcredit) * $pmoney, 2);
						}
						else {
							$deductmoney = round((intval($credit / $pcredit) + 1) * $pmoney, 2);
						}
					}

					if ($deductprice < $deductmoney) {
						$deductmoney = $deductprice;
					}

					if ($totalprice < $deductmoney) {
						$deductmoney = $totalprice;
					}

					$deductcredit = round(($deductmoney / $pmoney) * $pcredit, 2);
				}
			}

			$totalprice -= $deductmoney;

			if (!empty($_GPC['deduct2'])) {
				$deductcredit2 = $member['credit2'];

				if ($totalprice < $deductcredit2) {
					$deductcredit2 = $totalprice;
				}

				if ($deductprice2 < $deductcredit2) {
					$deductcredit2 = $deductprice2;
				}
			}

			$totalprice -= $deductcredit2;
		}

		$ordersn = m('common')->createNO('order', 'ordersn', 'SH');
		$verifyinfo = array();
		$verifycode = '';
		$verifycodes = array();
		if ($isverify || $dispatchtype) {
			if ($isverify) {
				if (($verifytype == 0) || ($verifytype == 1)) {
					$verifycode = random(8, true);

					while (1) {
						$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where verifycode=:verifycode and uniacid=:uniacid limit 1', array(':verifycode' => $verifycode, ':uniacid' => $_W['uniacid']));

						if ($count <= 0) {
							break;
						}

						$verifycode = random(8, true);
					}
				}
				else {
					if ($verifytype == 2) {
						$totaltimes = intval($allgoods[0]['total']);

						if ($totaltimes <= 0) {
							$totaltimes = 1;
						}

						$i = 1;

						while ($i <= $totaltimes) {
							$verifycode = random(8, true);

							while (1) {
								$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where concat(verifycodes,\'|\' + verifycode +\'|\' ) like :verifycodes and uniacid=:uniacid limit 1', array(':verifycodes' => '%' . $verifycode . '%', ':uniacid' => $_W['uniacid']));

								if ($count <= 0) {
									break;
								}

								$verifycode = random(8, true);
							}

							$verifycodes[] = '|' . $verifycode . '|';
							$verifyinfo[] = array('verifycode' => $verifycode, 'verifyopenid' => '', 'verifytime' => 0, 'verifystoreid' => 0);
							++$i;
						}
					}
				}
			}
			else {
				if ($dispatchtype) {
					$verifycode = random(8, true);

					while (1) {
						$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order') . ' where verifycode=:verifycode and uniacid=:uniacid limit 1', array(':verifycode' => $verifycode, ':uniacid' => $_W['uniacid']));

						if ($count <= 0) {
							break;
						}

						$verifycode = random(8, true);
					}
				}
			}
		}

		$carrier = $_GPC['carriers'];
		$carriers = (is_array($carrier) ? iserializer($carrier) : iserializer(array()));

		if ($totalprice <= 0) {
			$totalprice = 0;
		}

		$order = array('uniacid' => $uniacid, 'openid' => $openid, 'ordersn' => $ordersn, 'price' => $totalprice, 'cash' => $cash, 'discountprice' => $discountprice, 'isdiscountprice' => $isdiscountprice, 'deductprice' => $deductmoney, 'deductcredit' => $deductcredit, 'deductcredit2' => $deductcredit2, 'deductenough' => $deductenough, 'status' => 0, 'paytype' => 0, 'transid' => '', 'remark' => trim($_GPC['remark']), 'addressid' => empty($dispatchtype) ? $addressid : 0, 'goodsprice' => $goodsprice, 'dispatchprice' => $dispatch_price, 'dispatchtype' => $dispatchtype, 'dispatchid' => $dispatchid, 'storeid' => $carrierid, 'carrier' => $carriers, 'createtime' => time(), 'isverify' => $isverify ? 1 : 0, 'verifytype' => $verifytype, 'verifycode' => $verifycode, 'verifycodes' => implode('', $verifycodes), 'verifyinfo' => iserializer($verifyinfo), 'virtual' => $virtualid, 'isvirtual' => $isvirtual ? 1 : 0, 'isvirtualsend' => $isvirtualsend ? 1 : 0, 'oldprice' => $totalprice, 'olddispatchprice' => $dispatch_price, 'couponid' => $couponid, 'couponprice' => $couponprice, 'invoicename' => trim($_GPC['invoicename']));

		if ($diyform_plugin) {
			if (is_array($_GPC['diydata']) && !empty($order_formInfo)) {
				$diyform_data = $diyform_plugin->getInsertData($fields, $_GPC['diydata']);
				$idata = $diyform_data['data'];
				$order['diyformfields'] = iserializer($fields);
				$order['diyformdata'] = $idata;
				$order['diyformid'] = $order_formInfo['id'];
			}
		}

		if (!empty($address)) {
			$order['address'] = iserializer($address);
		}

		pdo_insert('ewei_shop_order', $order);
		$orderid = pdo_insertid();

		if (is_array($carrier)) {
			$up = array('realname' => $carrier['carrier_realname'], 'mobile' => $carrier['carrier_mobile']);
			pdo_update('ewei_shop_member', $up, array('id' => $member['id'], 'uniacid' => $_W['uniacid']));

			if (!empty($member['uid'])) {
				load()->model('mc');
				mc_update($member['uid'], $up);
			}
		}

		if ($_GPC['fromcart'] == 1) {
			pdo_query('update ' . tablename('ewei_shop_member_cart') . ' set deleted=1 where  openid=:openid and uniacid=:uniacid and selected=1 ', array(':uniacid' => $uniacid, ':openid' => $openid));
		}

		foreach ($allgoods as $goods) {
			$order_goods = array('uniacid' => $uniacid, 'orderid' => $orderid, 'goodsid' => $goods['goodsid'], 'price' => $goods['marketprice'] * $goods['total'], 'total' => $goods['total'], 'optionid' => $goods['optionid'], 'createtime' => time(), 'optionname' => $goods['optiontitle'], 'goodssn' => $goods['goodssn'], 'productsn' => $goods['productsn'], 'realprice' => $goods['ggprice'], 'oldprice' => $goods['ggprice'], 'openid' => $openid);

			if ($diyform_plugin) {
				if ($goods['diyformtype'] == 2) {
					$order_goods['diyformid'] = 0;
				}
				else {
					$order_goods['diyformid'] = $goods['diyformid'];
				}

				$order_goods['diyformdata'] = $goods['diyformdata'];
				$order_goods['diyformfields'] = $goods['diyformfields'];
			}

			pdo_insert('ewei_shop_order_goods', $order_goods);
		}

		if (0 < $deductcredit) {
			m('member')->setCredit($openid, 'credit1', 0 - $deductcredit, array('0', $_W['shopset']['shop']['name'] . '购物积分抵扣 消费积分: ' . $deductcredit . ' 抵扣金额: ' . $deductmoney . ' 订单号: ' . $ordersn));
		}

		if (0 < $deductcredit2) {
			m('member')->setCredit($openid, 'credit2', 0 - $deductcredit2, array('0', $_W['shopset']['shop']['name'] . '购物余额抵扣: ' . $deductcredit2 . ' 订单号: ' . $ordersn));
		}

		if (empty($virtualid)) {
			m('order')->setStocksAndCredits($orderid, 0);
		}
		else {
			if (isset($allgoods[0])) {
				$vgoods = $allgoods[0];
				pdo_update('ewei_shop_goods', array('sales' => $vgoods['sales'] + $vgoods['total']), array('id' => $vgoods['goodsid']));
			}
		}

		$plugincoupon = com('coupon');

		if ($plugincoupon) {
			$plugincoupon->useConsumeCoupon($orderid);
		}

		m('notice')->sendOrderMessage($orderid);
		$pluginc = p('commission');

		if ($pluginc) {
			$pluginc->checkOrderConfirm($orderid);
		}

		show_json(1, array('orderid' => $orderid));
	}

	protected function singleDiyformData($id = 0)
	{
		global $_W;
		global $_GPC;
		$goods_data = false;
		$diyformtype = false;
		$diyformid = 0;
		$diymode = 0;
		$formInfo = false;
		$goods_data_id = 0;
		$diyform_plugin = p('diyform');
		if ($diyform_plugin && !empty($id)) {
			$sql = 'SELECT id as goodsid,type,diyformtype,diyformid,diymode,diyfields FROM ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid  limit 1';
			$goods_data = pdo_fetch($sql, array(':uniacid' => $_W['uniacid'], ':id' => $id));

			if (!empty($goods_data)) {
				$diyformtype = $goods_data['diyformtype'];
				$diyformid = $goods_data['diyformid'];
				$diymode = $goods_data['diymode'];

				if ($goods_data['diyformtype'] == 1) {
					$formInfo = $diyform_plugin->getDiyformInfo($diyformid);
				}
				else {
					if ($goods_data['diyformtype'] == 2) {
						$fields = iunserializer($goods_data['diyfields']);

						if (!empty($fields)) {
							$formInfo = array('fields' => $fields);
						}
					}
				}
			}
		}

		return array('goods_data' => $goods_data, 'diyformtype' => $diyformtype, 'diyformid' => $diyformid, 'diymode' => $diymode, 'formInfo' => $formInfo, 'goods_data_id' => $goods_data_id, 'diyform_plugin' => $diyform_plugin);
	}

	public function diyform()
	{
		global $_W;
		global $_GPC;
		$goodsid = intval($_GPC['id']);
		$openid = $_W['openid'];
		$data = $this->singleDiyformData($goodsid);
		extract($data);

		if ($diyformtype == 2) {
			$diyformid = 0;
		}
		else {
			$diyformid = $goods_data['diyformid'];
		}

		$fields = $formInfo['fields'];
		$insert_data = $diyform_plugin->getInsertData($fields, $_GPC['diyformdata']);
		$idata = $insert_data['data'];
		$goods_temp = $diyform_plugin->getGoodsTemp($goodsid, $diyformid, $openid);
		$insert = array('cid' => $goodsid, 'openid' => $openid, 'diyformid' => $diyformid, 'type' => 3, 'diyformfields' => iserializer($fields), 'diyformdata' => $idata, 'uniacid' => $_W['uniacid']);

		if (empty($goods_temp)) {
			pdo_insert('ewei_shop_diyform_temp', $insert);
			$gdid = pdo_insertid();
		}
		else {
			pdo_update('ewei_shop_diyform_temp', $insert, array('id' => $goods_temp['id']));
			$gdid = $goods_temp['id'];
		}

		show_json(1, array('goods_data_id' => $gdid));
	}
}

?>
