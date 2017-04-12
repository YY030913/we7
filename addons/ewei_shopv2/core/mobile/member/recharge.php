<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Recharge_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset'];
		$status = 1;

		if (!empty($set['trade']['closerecharge'])) {
			$this->message('系统未开启充值!', '', 'error');
		}

		pdo_delete('ewei_shop_member_log', array('openid' => $_W['openid'], 'status' => 0, 'type' => 0, 'uniacid' => $_W['uniacid']));
		$logno = m('common')->createNO('member_log', 'logno', 'RC');
		$log = array('uniacid' => $_W['uniacid'], 'logno' => $logno, 'title' => $set['shop']['name'] . '会员充值', 'openid' => $_W['openid'], 'type' => 0, 'createtime' => time(), 'status' => 0);
		pdo_insert('ewei_shop_member_log', $log);
		$logid = pdo_insertid();
		$credit = m('member')->getCredit($_W['openid'], 'credit2');
		$wechat = array('success' => false);

		if (is_weixin()) {
			if (isset($set['pay']) && ($set['pay']['weixin'] == 1)) {
				load()->model('payment');
				$setting = uni_setting($_W['uniacid'], array('payment'));
				if (is_array($setting['payment']['wechat']) && $setting['payment']['wechat']['switch']) {
					$wechat['success'] = true;
				}
			}
		}

		$alipay = array('success' => false);
		if (isset($set['pay']['alipay']) && ($set['pay']['alipay'] == 1)) {
			load()->model('payment');
			$setting = uni_setting($_W['uniacid'], array('payment'));
			if (is_array($setting['payment']['alipay']) && $setting['payment']['alipay']['switch']) {
				$alipay['success'] = true;
			}
		}

		$acts = com_run('sale::getRechargeActivity');
		include $this->template();
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$logid = intval($_GPC['logid']);

		if (empty($logid)) {
			show_json(0, '充值出错, 请重试!');
		}

		$money = floatval($_GPC['money']);

		if (empty($money)) {
			show_json(0, '请填写充值金额!');
		}

		$type = $_GPC['type'];
		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_log') . ' WHERE `id`=:id and `uniacid`=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $logid));

		if (empty($log)) {
			show_json(0, '充值出错, 请重试!');
		}

		$couponid = intval($_GPC['couponid']);

		if ($log['money'] <= 0) {
			pdo_update('ewei_shop_member_log', array('money' => $money, 'couponid' => $couponid), array('id' => $log['id']));
		}

		$set = m('common')->getSysset(array('shop', 'pay'));

		if ($type == 'wechat') {
			if (!is_weixin()) {
				show_json(0, '非微信环境!');
			}

			if (empty($set['pay']['weixin'])) {
				show_json(0, '未开启微信支付!');
			}

			$wechat = array('success' => false);
			$params = array();
			$params['tid'] = $log['logno'];
			$params['user'] = $_W['openid'];
			$params['fee'] = $money;
			$params['title'] = $log['title'];
			load()->model('payment');
			$setting = uni_setting($_W['uniacid'], array('payment'));

			if (is_array($setting['payment'])) {
				$options = $setting['payment']['wechat'];
				$options['appid'] = $_W['account']['key'];
				$options['secret'] = $_W['account']['secret'];
				$wechat = m('common')->wechat_build($params, $options, 1);
				$wechat['success'] = false;

				if (!is_error($wechat)) {
					$wechat['success'] = true;
				}
				else {
					show_json(0, $wechat['message']);
				}
			}

			if (!$wechat['success']) {
				show_json(0, '微信支付参数错误!');
			}

			show_json(1, array('wechat' => $wechat));
		}
		else {
			if ($type == 'alipay') {
				$alipay = array('success' => false);
				$params = array();
				$params['tid'] = $log['logno'];
				$params['user'] = $_W['openid'];
				$params['fee'] = $money;
				$params['title'] = $log['title'];
				load()->func('communication');
				load()->model('payment');
				$setting = uni_setting($_W['uniacid'], array('payment'));

				if (is_array($setting['payment'])) {
					$options = $setting['payment']['alipay'];
					$alipay = m('common')->alipay_build($params, $options, 1, $_W['openid']);

					if (!empty($alipay['url'])) {
						$alipay['success'] = true;
					}
				}

				show_json(1, array('alipay' => $alipay));
			}
		}

		show_json(0, '未找到支付方式');
	}

	public function wechat_complete()
	{
		global $_W;
		global $_GPC;
		$logid = intval($_GPC['logid']);
		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_log') . ' WHERE `id`=:id and `uniacid`=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $logid));
		if (!empty($log) && empty($log['status'])) {
			$payquery = m('finance')->isWeixinPay($log['logno'], $log['money']);

			if (!is_error($payquery)) {
				pdo_update('ewei_shop_member_log', array('status' => 1, 'rechargetype' => 'wechat'), array('id' => $logid));
				m('member')->setCredit($log['openid'], 'credit2', $log['money'], array(0, '人人商城会员充值:wechatcomplete:credit2:' . $log['money']));
				m('member')->setRechargeCredit($log['openid'], $log['money']);
				com_run('sale::setRechargeActivity', $log);
				com_run('coupon::useRechargeCoupon', $log);
				m('notice')->sendMemberLogMessage($logid);
			}
		}

		show_json(1);
	}

	public function alipay_complete()
	{
		global $_W;
		global $_GPC;
		$logno = trim($_GPC['out_trade_no']);
		$notify_id = trim($_GPC['notify_id']);
		$sign = trim($_GPC['sign']);

		if (empty($logno)) {
			exit('[ERR1]充值出现错误，请重试!');
		}

		if (!m('finance')->isAlipayNotify($_GET)) {
			exit('[ERR2]充值出现错误，请重试!');
		}

		$log = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_member_log') . ' WHERE `logno`=:logno and `uniacid`=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':logno' => $logno));
		if (!empty($log) && empty($log['status'])) {
			pdo_update('ewei_shop_member_log', array('status' => 1, 'rechargetype' => 'alipay'), array('id' => $log['id']));
			m('member')->setCredit($log['openid'], 'credit2', $log['money'], array(0, '人人商城会员充值:alipayreturn:credit2:' . $log['money']));
			m('member')->setRechargeCredit($log['openid'], $log['money']);
			com_run('sale::setRechargeActivity', $log);
			com_run('coupon::useRechargeCoupon', $log);
			m('notice')->sendMemberLogMessage($log['id']);
		}

		$url = mobileUrl('member', NULL, true);
		exit('<script>top.window.location.href=\'' . $url . '\'</script>');
	}
}

?>
