<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Withdraw_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset'];
		$status = 1;

		if (empty($set['trade']['withdraw'])) {
			$this->message('系统未开启提现!', '', 'error');
		}

		$withdrawcharge = $set['trade']['withdrawcharge'];
		$withdrawbegin = floatval($set['trade']['withdrawbegin']);
		$withdrawend = floatval($set['trade']['withdrawend']);
		$credit = m('member')->getCredit($_W['openid'], 'credit2');
		include $this->template();
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$set = $_W['shopset'];

		if (empty($set['trade']['withdraw'])) {
			show_json(0, '系统未开启提现!');
		}

		$set_array = array();
		$set_array['charge'] = $set['trade']['withdrawcharge'];
		$set_array['beign'] = floatval($set['trade']['withdrawbegin']);
		$set_array['end'] = floatval($set['trade']['withdrawend']);
		$money = floatval($_GPC['money']);
		$credit = m('member')->getCredit($_W['openid'], 'credit2');

		if ($money <= 0) {
			show_json(0, '提现金额错误!');
		}

		if ($credit < $money) {
			show_json(0, '提现金额过大!');
		}

		$realmoney = $money;

		if (!empty($set_array['charge'])) {
			$money_array = m('member')->getCalculateMoney($money, $set_array);

			if ($money_array['flag']) {
				$realmoney = $money_array['realmoney'];
				$deductionmoney = $money_array['deductionmoney'];
			}
		}

		m('member')->setCredit($_W['openid'], 'credit2', 0 - $money, array(0, '人人商城余额提现预扣除: ' . $money . ',实际到账金额:' . $realmoney . ',手续费金额:' . $deductionmoney));
		$logno = m('common')->createNO('member_log', 'logno', 'RW');
		$log = array('uniacid' => $_W['uniacid'], 'logno' => $logno, 'openid' => $_W['openid'], 'title' => '余额提现', 'type' => 1, 'createtime' => time(), 'status' => 0, 'money' => $money, 'realmoney' => $realmoney, 'deductionmoney' => $deductionmoney, 'charge' => $set_array['charge']);
		pdo_insert('ewei_shop_member_log', $log);
		$logid = pdo_insertid();
		m('notice')->sendMemberLogMessage($logid);
		show_json(1);
	}
}

?>
