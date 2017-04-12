<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Picker_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$goods = pdo_fetch('select id,thumb,title,marketprice,total,maxbuy,minbuy,unit,hasoption,showtotal,diyformid,diyformtype,diyfields,isdiscount,isdiscount_time,isdiscount_discounts, needfollow, followtip, followurl, type, isverify, maxprice, minprice from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));

		if (empty($goods)) {
			show_json(0);
		}

		$goods = set_medias($goods, 'thumb');
		$openid = $_W['openid'];
		$follow = m('user')->followed($openid);
		if (!empty($goods['needfollow']) && !$follow) {
			$followtip = (empty($goods['followtip']) ? '如果您想要购买此商品，需要您关注我们的公众号，点击【确定】关注后再来购买吧~' : $goods['followtip']);
			$followurl = (empty($goods['followurl']) ? $_W['shopset']['share']['followurl'] : $goods['followurl']);
			show_json(2, array('followtip' => $followtip, 'followurl' => $followurl));
		}

		if ($goods['isdiscount'] && (time() <= $goods['isdiscount_time'])) {
			$isdiscount = true;
			$isdiscount_discounts = json_decode($goods['isdiscount_discounts'], true);
			$openid = $_W['openid'];
			$member = m('member')->getMember($openid);
			$levelid = $member['level'];
			$key = (empty($levelid) ? 'default' : 'level' . $levelid);
		}
		else {
			$isdiscount = false;
		}

		$specs = false;
		$options = false;
		if (!empty($goods) && $goods['hasoption']) {
			$specs = pdo_fetchall('select* from ' . tablename('ewei_shop_goods_spec') . ' where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));

			foreach ($specs as &$spec) {
				$spec['items'] = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_spec_item') . ' where specid=:specid order by displayorder asc', array(':specid' => $spec['id']));
			}

			unset($spec);
			$options = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid and uniacid=:uniacid order by displayorder asc', array(':goodsid' => $id, ':uniacid' => $_W['uniacid']));
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
		$diyformhtml = '';
		$diyform_plugin = p('diyform');

		if ($diyform_plugin) {
			$fields = false;

			if ($goods['diyformtype'] == 1) {
				if (!empty($goods['diyformid'])) {
					$diyformid = $goods['diyformid'];
					$formInfo = $diyform_plugin->getDiyformInfo($diyformid);
					$fields = $formInfo['fields'];
				}
			}
			else {
				if ($goods['diyformtype'] == 2) {
					$diyformid = 0;
					$fields = iunserializer($goods['diyfields']);

					if (empty($fields)) {
						$fields = false;
					}
				}
			}

			if (!empty($fields)) {
				ob_clean();
				ob_start();
				$inPicker = true;
				$openid = $_W['openid'];
				$member = m('member')->getMember($openid, true);
				$f_data = $diyform_plugin->getLastData(3, 0, $diyformid, $id, $fields, $member);

				if (empty($f_data)) {
					$f_data = $diyform_plugin->getLastCartData($id);
				}

				include $this->template('diyform/formfields');
				$diyformhtml = ob_get_contents();
				ob_clean();
			}
		}

		if (!empty($specs)) {
			foreach ($specs as $key => $value) {
				foreach ($specs[$key]['items'] as $k => &$v) {
					$v['thumb'] = tomedia($v['thumb']);
				}
			}
		}

		$goods['canAddCart'] = true;
		if (($goods['isverify'] == 2) || ($goods['type'] == 2) || ($goods['type'] == 3)) {
			$goods['canAddCart'] = false;
		}

		show_json(1, array('goods' => $goods, 'specs' => $specs, 'options' => $options, 'diyformhtml' => $diyformhtml));
	}
}

?>
