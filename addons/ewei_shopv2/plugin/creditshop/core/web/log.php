<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Log_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$type = intval($_GPC['type']);
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$condition = ' and log.uniacid=:uniacid and g.type=:type and log.status>0';
		$params = array(':uniacid' => $_W['uniacid'], ':type' => $type);
		$searchfield = strtolower(trim($_GPC['searchfield']));
		$keyword = trim($_GPC['keyword']);
		if (!empty($searchfield) && !empty($keyword)) {
			if ($searchfield == 'member') {
				$condition .= ' and ( m.realname like :keyword or m.nickname like :keyword  or m.mobile like :keyword) ';
			}
			else if ($searchfield == 'address') {
				$condition .= ' and ( log.realname like :keyword  or log.mobile like :keyword  or a.realname like :keyword or a.mobile like :keyword  ) ';
			}
			else if ($searchfield == 'logno') {
				$condition .= ' and log.logno like :keyword';
			}
			else if ($searchfield == 'eno') {
				$condition .= ' and log.eno like :keyword';
			}
			else if ($searchfield == 'goods') {
				$condition .= ' and g.title like :keyword';
			}
			else if ($searchfield == 'store') {
				$condition .= ' and  s.storename like :keyword';
			}
			else {
				if ($searchfield == 'express') {
					$condition .= ' and  log.expresssn like :keyword';
				}
			}

			$params[':keyword'] = '%' . $keyword . '%';
		}

		if ($_GPC['status'] != '') {
			$condition .= ' and log.status=' . intval($_GPC['status']);
		}

		if (empty($starttime) || empty($endtime)) {
			$starttime = strtotime('-1 month');
			$endtime = time();
		}

		if (!empty($_GPC['time']['start']) && !empty($_GPC['time']['end'])) {
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND log.createtime >= :starttime AND log.createtime <= :endtime ';
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}

		$sql = 'select log.*, m.nickname,m.avatar,m.realname as mrealname,m.mobile as mmobile, g.title,g.thumb,g.thumb,g.credit,g.money,g.type as goodstype,g.isverify,g.goodstype as iscoupon,s.storename,s.address as storeaddress from ' . tablename('ewei_shop_creditshop_log') . ' log ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = log.openid and m.uniacid=log.uniacid' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id = log.addressid' . ' left join ' . tablename('ewei_shop_store') . ' s on s.id = log.storeid' . ' left join ' . tablename('ewei_shop_creditshop_goods') . ' g on g.id = log.goodsid' . ' where 1 ' . $condition . ' ORDER BY log.createtime desc ';

		if (empty($_GPC['export'])) {
			$sql .= ' limit ' . (($pindex - 1) * $psize) . ',' . $psize;
		}

		$list = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('select count(log.id) from' . tablename('ewei_shop_creditshop_log') . ' log ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid = log.openid and m.uniacid=log.uniacid' . ' left join ' . tablename('ewei_shop_store') . ' s on s.id = log.storeid' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id = log.addressid' . ' left join ' . tablename('ewei_shop_creditshop_goods') . ' g on g.id = log.goodsid' . ' where 1 ' . $condition, $params);

		foreach ($list as &$row) {
			$row['address'] = array();

			if (!empty($row['addressid'])) {
				$row['address'] = pdo_fetch('select realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $row['addressid'], ':uniacid' => $_W['uniacid']));
			}
			else {
				$row['address'] = array('carrier_realname' => $row['realname'], 'carrier_mobile' => $row['mobile'], 'carrier_storename' => $row['storename'], 'carrier_address' => $row['storeaddress']);
			}

			$row['address']['logid'] = $row['id'];
			$row['address']['isverify'] = $row['isverify'];
			$row['address']['storeid'] = $row['storeid'];
			$row['address']['addressid'] = $row['addressid'];
			$canexchange = true;

			if ($row['status'] == 2) {
				if (empty($row['paystatus'])) {
					$canexchange = false;
				}

				if (empty($row['dispatchstatus'])) {
					$canexchange = false;
				}

				if ($row['isverify'] == 1) {
					if (empty($row['storeid'])) {
						$canexchange = false;
					}
				}
			}
			else {
				$canexchange = false;
			}

			$row['canexchange'] = $canexchange;
		}

		unset($row);

		if ($_GPC['export'] == 1) {
			ca('creditshop.log.export');

			if (empty($type)) {
				plog('creditshop.log.export', '导出兑换订单');
			}
			else {
				plog('creditshop.log.export', '导出抽奖订单');
			}

			foreach ($list as &$row) {
				$row['typestr'] = empty($row['type']) ? '兑换' : '抽奖';
				$row['verifystr'] = empty($row['isverify']) ? '快递' : '线下';
				$row['createtime'] = date('Y-m-d H:i', $row['createtime']);
				$row['user1'] = empty($row['realname']) ? $row['mrealname'] : $row['realname'];
				$row['user2'] = empty($row['mobile']) ? $row['mmobile'] : $row['mobile'];

				if (!empty($row['addressid'])) {
					$row['addressinfo_province'] = $row['address']['province'];
					$row['addressinfo_city'] = $row['address']['city'];
					$row['addressinfo_area'] = $row['address']['area'];
					$row['addressinfo_address'] = $row['address']['address'];
					$row['addressinfo_realname'] = $row['address']['realname'];
					$row['addressinfo_mobile'] = $row['address']['mobile'];
				}
				else {
					$row['storeinfo_storename'] = $row['address']['carrier_storename'];
					$row['storeinfo_address'] = $row['address']['carrier_address'];
				}

				if (empty($type)) {
					if ($row['status'] == 2) {
						$row['statusstr'] = '已兑换';
					}
					else {
						if ($row['status'] == 3) {
							$row['statusstr'] = '已兑奖';
						}
					}
				}
				else if ($row['status'] == 1) {
					$row['statusstr'] = '未中奖';
				}
				else if ($row['status'] == 2) {
					$row['statusstr'] = '已中奖';
				}
				else {
					if ($row['status'] == 3) {
						$row['statusstr'] = '已兑奖';
					}
				}

				if ($row['paytype'] == -1) {
					$row['paystr'] = '无需支付';
				}
				else if ($row['paytype'] == 0) {
					if ($row['paystatus'] == 0) {
						$row['paystr'] = '余额未支付';
					}
					else {
						$row['paystr'] = '余额已支付';
					}
				}
				else {
					if ($row['paytype'] == 1) {
						if ($row['paystatus'] == 0) {
							$row['paystr'] = '微信未支付';
						}
						else {
							$row['paystr'] = '微信已支付';
						}
					}
				}

				if ($row['dispatchstatus'] == -1) {
					$row['dispatchstr'] = '无需支付';
				}
				else if ($row['dispatchstatus'] == 0) {
					$row['dispatchstr'] = '未支付';
				}
				else {
					if ($row['dispatchstatus'] == 1) {
						$row['dispatchstr'] = '已支付';
					}
				}
			}

			unset($row);
			$columns = array(
				array('title' => 'ID', 'field' => 'id', 'width' => 12),
				array('title' => '活动编号', 'field' => 'logno', 'width' => 24),
				array('title' => '商品名称', 'field' => 'title', 'width' => 12),
				array('title' => '活动类型', 'field' => 'typestr', 'width' => 12),
				array('title' => '兑换方式', 'field' => 'verifystr', 'width' => 12),
				array('title' => '联系人', 'field' => 'user1', 'width' => 12),
				array('title' => '联系电话', 'field' => 'user2', 'width' => 12),
				array('title' => '邮寄地址', 'field' => 'addressinfo_province', 'width' => 12),
				array('title' => '', 'field' => 'addressinfo_city', 'width' => 12),
				array('title' => '', 'field' => 'addressinfo_area', 'width' => 12),
				array('title' => '', 'field' => 'addressinfo_address', 'width' => 24),
				array('title' => '', 'field' => 'addressinfo_realname', 'width' => 12),
				array('title' => '', 'field' => 'addressinfo_mobile', 'width' => 12),
				array('title' => '兑换门店', 'field' => 'storeinfo_storename', 'width' => 12),
				array('title' => '', 'field' => 'storeinfo_address', 'width' => 24),
				array('title' => '参与状态', 'field' => 'statusstr', 'width' => 12),
				array('title' => '支付状态', 'field' => 'paystr', 'width' => 12),
				array('title' => '快递状态', 'field' => 'dispatchstr', 'width' => 12),
				array('title' => '参与时间', 'field' => 'createtime', 'width' => 12)
				);
			m('excel')->export($list, array('title' => (empty($type) ? '兑换' : '抽奖') . '订单数据-' . date('Y-m-d-H-i', time()), 'columns' => $columns));
		}

		$pager = pagination($total, $pindex, $psize);
		include $this->template();
	}

	public function detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($log)) {
			$this->message('兑换记录不存在!', referer(), 'error');
		}

		$member = m('member')->getMember($log['openid']);
		$goods = $this->model->getGoods($log['goodsid'], $member);

		if (empty($goods['id'])) {
			$this->message('商品记录不存在!', referer(), 'error');
		}

		$canexchange = true;

		if ($log['status'] == 2) {
			if (empty($log['paystatus'])) {
				$canexchange = false;
			}

			if (empty($log['dispatchstatus'])) {
				$canexchange = false;
			}

			if (($goods['isverify'] == 1) && empty($log['storeid'])) {
				$canexchange = false;
			}
		}
		else {
			$canexchange = false;
		}

		$log['canexchange'] = $canexchange;

		if ($goods['isverify']) {
			if (!empty($log['storeid'])) {
				$store = pdo_fetch('select id,storename,address  from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $log['storeid'], ':uniacid' => $_W['uniacid']));
			}
		}
		else {
			$address = iunserializer($log['address']);

			if (!is_array($address)) {
				$address = pdo_fetch('select realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $log['addressid'], ':uniacid' => $_W['uniacid']));
			}
		}

		include $this->template();
	}

	public function exchange()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$log = pdo_fetch('select * from ' . tablename('ewei_shop_creditshop_log') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($log)) {
			show_json(0, '兑换记录不存在!');
		}

		if (empty($log['status'])) {
			show_json(0, '无效兑换记录!');
		}

		if (3 <= $log['status']) {
			show_json(0, '此记录已兑换过了!');
		}

		$member = m('member')->getMember($log['openid']);
		$goods = $this->model->getGoods($log['goodsid'], $member);

		if (empty($goods['id'])) {
			show_json(0, '商品记录不存在!');
		}

		if (!empty($goods['type'])) {
			if ($log['status'] <= 1) {
				show_json(0, '未中奖，不能兑换!');
			}
		}

		$store = false;
		$address = false;

		if ($goods['isverify']) {
			if (!empty($log['storeid'])) {
				$store = pdo_fetch('select id,storename,address  from ' . tablename('ewei_shop_store') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $log['storeid'], ':uniacid' => $_W['uniacid']));
			}
		}
		else {
			$address = iunserializer($log['address']);

			if (!is_array($address)) {
				$address = pdo_fetch('select realname,mobile,address,province,city,area from ' . tablename('ewei_shop_member_address') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $log['addressid'], ':uniacid' => $_W['uniacid']));
			}
		}

		if ((0 < $goods['money']) && empty($log['paystatus'])) {
			show_json(0, '未支付，无法进行兑换!');
		}

		if ((0 < $goods['dispatch']) && empty($log['dispatchstatus'])) {
			show_json(0, '未支付运费，无法进行兑换!');
		}

		if ($_W['ispost']) {
			pdo_update('ewei_shop_creditshop_log', array('status' => 3, 'usetime' => time(), 'expresscom' => $_GPC['expresscom'], 'expresssn' => $_GPC['expresssn'], 'express' => $_GPC['express']), array('id' => $id));
			$this->model->sendMessage($id);
			plog('creditshop.log.exchange', '积分商城兑换 兑换记录ID: ' . $id);
			show_json(1, array('url' => webUrl('creditshop/log', array('type' => $goods['type']))));
		}

		include $this->template();
	}
}

?>
