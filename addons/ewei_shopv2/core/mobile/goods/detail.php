<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Detail_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$id = intval($_GPC['id']);
		$err = false;
		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		$member = m('member')->getMember($openid);
		if (empty($goods) || (!empty($goods['showlevels']) && !strexists($goods['showlevels'], $member['level']))) {
			$err = true;
			include $this->template();
			exit();
		}

		$goods['sales'] = $goods['sales'] + $goods['salesreal'];
		$goods['content'] = m('ui')->lazy($goods['content']);
		$buyshow = 0;

		if ($goods['buyshow'] == 1) {
			$sql = 'select o.id from ' . tablename('ewei_shop_order') . ' o left join ' . tablename('ewei_shop_order_goods') . ' g on o.id = g.orderid';
			$sql .= ' where o.openid=:openid and g.goodsid=:id and o.status>0 and o.uniacid=:uniacid limit 1';
			$buy_goods = pdo_fetch($sql, array(':openid' => $openid, ':id' => $id, ':uniacid' => $_W['uniacid']));

			if (!empty($buy_goods)) {
				$buyshow = 1;
				$goods['buycontent'] = m('ui')->lazy($goods['buycontent']);
			}
		}

		$goods['unit'] = empty($goods['unit']) ? '件' : $goods['unit'];
		$goods['dispatchprice'] = $this->getGoodsDispatchPrice($goods);
		$thumbs = iunserializer($goods['thumb_url']);

		if (empty($thumbs)) {
			$thumbs = array($goods['thumb']);
		}

		$specs = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_spec') . ' where goodsid=:goodsid and  uniacid=:uniacid order by displayorder asc', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));
		$spec_titles = array();

		foreach ($specs as $key => $spec) {
			if (2 <= $key) {
				break;
			}

			$spec_titles[] = $spec['title'];
		}

		$spec_titles = implode('、', $spec_titles);
		$params = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_goods_param') . ' WHERE uniacid=:uniacid and goodsid=:goodsid order by displayorder asc', array(':uniacid' => $uniacid, ':goodsid' => $goods['id']));
		$goods = set_medias($goods, 'thumb');
		$goods['canbuy'] = !empty($goods['status']) && empty($goods['deleted']);

		if ($goods['total'] <= 0) {
			$goods['canbuy'] = false;
		}

		$goods['timestate'] = '';
		$goods['userbuy'] = '1';

		if (0 < $goods['usermaxbuy']) {
			$order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(':goodsid' => $goods['id'], ':uniacid' => $uniacid, ':openid' => $openid));

			if ($goods['usermaxbuy'] <= $order_goodscount) {
				$goods['userbuy'] = 0;
				$goods['canbuy'] = false;
			}
		}

		$levelid = $member['level'];
		$groupid = $member['groupid'];
		$goods['levelbuy'] = '1';

		if ($goods['buylevels'] != '') {
			$buylevels = explode(',', $goods['buylevels']);

			if (!in_array($levelid, $buylevels)) {
				$goods['levelbuy'] = 0;
				$goods['canbuy'] = false;
			}
		}

		$goods['groupbuy'] = '1';

		if ($goods['buygroups'] != '') {
			$buygroups = explode(',', $goods['buygroups']);

			if (!in_array($groupid, $buygroups)) {
				$goods['groupbuy'] = 0;
				$goods['canbuy'] = false;
			}
		}

		$goods['timebuy'] = '0';

		if ($goods['istime'] == 1) {
			if (time() < $goods['timestart']) {
				$goods['timebuy'] = '-1';
				$goods['canbuy'] = false;
			}
			else {
				if ($goods['timeend'] < time()) {
					$goods['timebuy'] = '1';
					$goods['canbuy'] = false;
				}
			}
		}

		$canAddCart = true;
		if (($goods['isverify'] == 2) || ($goods['type'] == 2) || ($goods['type'] == 3)) {
			$canAddCart = false;
		}

		$enoughs = com_run('sale::getEnoughs');
		$enoughfree = com_run('sale::getEnoughFree');
		if ($enoughfree && ($enoughfree < $goods['minprice'])) {
			$goods['dispatchprice'] = 0;
		}

		$hasSales = false;
		if ((0 < $goods['ednum']) || (0 < $goods['edmoney'])) {
			$hasSales = true;
		}

		if ($enoughfree || ($enoughs && (0 < count($enoughs)))) {
			$hasSales = true;
		}

		$minprice = $goods['minprice'];
		$maxprice = $goods['maxprice'];
		if ($goods['isdiscount'] && (time() <= $goods['isdiscount_time'])) {
			$goods['oldmaxprice'] = $maxprice;
			$isdiscount_discounts = json_decode($goods['isdiscount_discounts'], true);
			$key = (empty($levelid) ? 'default' : 'level' . $levelid);
			$prices = array();
			if (!isset($isdiscount_discounts['type']) || empty($isdiscount_discounts['type'])) {
				$isd = trim($isdiscount_discounts[$key]['option0']);
				$prices[] = m('order')->getFormartDiscountPrice($isd, $goods['marketprice']);
			}
			else {
				foreach ($isdiscount_discounts[$key] as $k => $v) {
					$k = substr($k, 6);
					$op_marketprice = m('goods')->getOptionPirce($goods['id'], $k);
					$prices[] = m('order')->getFormartDiscountPrice($v, $op_marketprice);
				}
			}

			$minprice = min($prices);
			$maxprice = max($prices);
		}

		$goods['minprice'] = number_format($minprice, 2);
		$goods['maxprice'] = number_format($maxprice, 2);
		$getComments = empty($_W['shopset']['trade']['closecommentshow']);
		$hasServices = $goods['cash'] || $goods['seven'] || $goods['repair'] || $goods['invoice'] || $goods['quality'];
		$isFavorite = m('goods')->isFavorite($id);
		$cartCount = m('goods')->getCartCount();
		m('goods')->addHistory($id);
		$shop = set_medias(m('common')->getSysset('shop'), 'logo');
		$shop['url'] = mobileUrl('', NULL, true);
		$mid = intval($_GPC['mid']);
		$opencommission = false;

		if (p('commission')) {
			if (empty($member['agentblack'])) {
				$cset = p('commission')->getSet();
				$opencommission = 0 < intval($cset['level']);

				if ($opencommission) {
					if (empty($mid)) {
						if (($member['isagent'] == 1) && ($member['status'] == 1)) {
							$mid = $member['id'];
						}
					}

					if (!empty($mid)) {
						if (empty($cset['closemyshop'])) {
							$shop = set_medias(p('commission')->getShop($mid), 'logo');
							$shop['url'] = mobileUrl('commission/myshop', array('mid' => $mid), true);
						}
					}
				}
			}
		}

		$shopdetail = array('logo' => !empty($goods['detail_logo']) ? tomedia($goods['detail_logo']) : $shop['logo'], 'shopname' => !empty($goods['detail_shopname']) ? $goods['detail_shopname'] : $shop['name'], 'description' => !empty($goods['detail_totaltitle']) ? $goods['detail_totaltitle'] : $shop['description'], 'btntext1' => trim($goods['detail_btntext1']), 'btnurl1' => !empty($goods['detail_btnurl1']) ? $goods['detail_btnurl1'] : mobileUrl('goods'), 'btntext2' => trim($goods['detail_btntext2']), 'btnurl2' => !empty($goods['detail_btnurl2']) ? $goods['detail_btnurl2'] : $shop['url']);

		if (empty($shop['selectgoods'])) {
			$statics = array('all' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and status=1 and deleted=0', array(':uniacid' => $_W['uniacid'])), 'new' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and isnew=1 and status=1 and deleted=0', array(':uniacid' => $_W['uniacid'])), 'discount' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and isdiscount=1 and status=1 and deleted=0', array(':uniacid' => $_W['uniacid'])));
		}
		else {
			$goodsids = explode(',', $shop['goodsids']);
			$statics = array('all' => count($goodsids), 'new' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and id in( ' . $shop['goodsids'] . ' ) and isnew=1 and status=1 and deleted=0', array(':uniacid' => $_W['uniacid'])), 'discount' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and id in( ' . $shop['goodsids'] . ' ) and isdiscount=1 and status=1 and deleted=0', array(':uniacid' => $_W['uniacid'])));
		}

		$goodsdesc = (!empty($goods['description']) ? $goods['description'] : $goods['subtitle']);
		$_W['shopshare'] = array('title' => !empty($goods['share_title']) ? $goods['share_title'] : $goods['title'], 'imgUrl' => !empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']), 'desc' => !empty($goodsdesc) ? $goodsdesc : $_W['shopset']['shop']['name'], 'link' => mobileUrl('goods/detail', array('id' => $goods['id']), true));
		$com = p('commission');

		if ($com) {
			$cset = $_W['shopset']['commission'];

			if (!empty($cset)) {
				if (($member['isagent'] == 1) && ($member['status'] == 1)) {
					$_W['shopshare']['link'] = mobileUrl('goods/detail', array('id' => $goods['id'], 'mid' => $member['id']), true);
				}
				else {
					if (!empty($_GPC['mid'])) {
						$_W['shopshare']['link'] = mobileUrl('goods/detail', array('id' => $goods['id'], 'mid' => $_GPC['mid']), true);
					}
				}
			}
		}

		$stores = array();

		if ($goods['isverify'] == 2) {
			$storeids = array();

			if (!empty($goods['storeids'])) {
				$storeids = array_merge(explode(',', $goods['storeids']), $storeids);
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

	protected function getGoodsDispatchPrice($goods)
	{
		if (!empty($goods['issendfree'])) {
			return 0;
		}

		if (($goods['type'] == 2) || ($goods['type'] == 3)) {
			return 0;
		}

		if ($goods['dispatchtype'] == 1) {
			return $goods['dispatchprice'];
		}

		$dispatch = m('dispatch')->getOneDispatch($goods['dispatchid']);
		$areas = iunserializer($dispatch['areas']);
		if (!empty($areas) && is_array($areas)) {
			$firstprice = array_map(function($val) {
				return $val['firstprice'];
			}, $areas);
			array_push($firstprice, m('dispatch')->getDispatchPrice(1, $dispatch));
			$ret = array('min' => round(min($firstprice), 2), 'max' => round(max($firstprice), 2));
		}
		else {
			$ret = m('dispatch')->getDispatchPrice(1, $dispatch);
		}

		return $ret;
	}

	public function get_detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		exit(m('ui')->lazy($goods['content']));
	}

	public function get_comments()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$percent = 100;
		$params = array(':goodsid' => $id, ':uniacid' => $_W['uniacid']);
		$count = array('all' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and level>=0 and deleted=0 and uniacid=:uniacid', $params), 'good' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and level>=5 and deleted=0 and uniacid=:uniacid', $params), 'normal' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and level>=2 and level<=4 and deleted=0 and uniacid=:uniacid', $params), 'bad' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and level<=1 and deleted=0 and uniacid=:uniacid', $params), 'pic' => pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and ifnull(images,\'a:0:{}\')<>\'a:0:{}\' and deleted=0 and uniacid=:uniacid', $params));
		$list = array();

		if (0 < $count['all']) {
			$percent = intval(($count['good'] / (empty($count['all']) ? 1 : $count['all'])) * 100);
			$list = pdo_fetchall('select nickname,level,content,images,createtime from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid and deleted=0 and uniacid=:uniacid order by istop desc, id desc limit 2', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));

			foreach ($list as &$row) {
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
				$row['images'] = set_medias(iunserializer($row['images']));
				$row['nickname'] = cut_str($row['nickname'], 1, 0) . '**' . cut_str($row['nickname'], 1, -1);
			}

			unset($row);
		}

		show_json(1, array('count' => $count, 'percent' => $percent, 'list' => $list));
	}

	public function get_comment_list()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$level = trim($_GPC['level']);
		$params = array(':goodsid' => $id, ':uniacid' => $_W['uniacid']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = '';

		if ($level == 'good') {
			$condition = ' and level=5';
		}
		else if ($level == 'normal') {
			$condition = ' and level>=2 and level<=4';
		}
		else if ($level == 'bad') {
			$condition = ' and level<=1';
		}
		else {
			if ($level == 'pic') {
				$condition = ' and ifnull(images,\'a:0:{}\')<>\'a:0:{}\'';
			}
		}

		$list = pdo_fetchall('select nickname,level,content,images,createtime,headimgurl from ' . tablename('ewei_shop_order_comment') . ' ' . '  where goodsid=:goodsid and uniacid=:uniacid  ' . $condition . ' order by istop desc, id desc LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);

		foreach ($list as &$row) {
			$row['headimgurl'] = tomedia($row['headimgurl']);
			$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
			$row['images'] = set_medias(iunserializer($row['images']));
			$row['nickname'] = cut_str($row['nickname'], 1, 0) . '**' . cut_str($row['nickname'], 1, -1);
		}

		unset($row);
		$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid  and uniacid=:uniacid ' . $condition, $params);
		show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));
	}
}

?>
