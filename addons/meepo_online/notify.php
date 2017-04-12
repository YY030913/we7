<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_MOBILE', true);
require '../../framework/bootstrap.inc.php';
$input = file_get_contents('php://input');
$isxml = true;
if (!empty($input) && empty($_GET['out_trade_no'])) {
	$obj = isimplexml_load_string($input, 'SimpleXMLElement', LIBXML_NOCDATA);
	$data = json_decode(json_encode($obj), true);
	if (empty($data)) {
		die('fail');
		exit;
	}
	if ($data['result_code'] != 'SUCCESS' || $data['return_code'] != 'SUCCESS') {
		die('fail');
		exit;
	}
	$get = $data;
} else {
	$isxml = false;
	$get = $_GET;
}
$_W['uniacid'] = $_W['weid'] = $get['attach'];
$setting = uni_setting($_W['uniacid'], array('payment'));
if(is_array($setting['payment'])) {
	$wechat = $setting['payment']['wechat'];
	WeUtility::logging('pay', var_export($get, true));
	if(!empty($wechat)) {
		ksort($get);
		$string1 = '';
		foreach($get as $k => $v) {
			if($v != '' && $k != 'sign') {
				$string1 .= "{$k}={$v}&";
			}
		}
		$wechat['signkey'] = ($wechat['version'] == 1) ? $wechat['key'] : $wechat['signkey'];
		$sign = strtoupper(md5($string1 . "key={$wechat['signkey']}"));
		if($sign == $get['sign']) {
			$sql = 'SELECT * FROM ' . tablename('meepo_online_pinglun') . ' WHERE `id`=:id AND `weid`=:weid';
			$params = array();
			$pay_id  =  substr($get['out_trade_no'],10);
			$params[':id'] = $pay_id;
			$params[':weid'] = $_W['uniacid'];
			$log = pdo_fetch($sql, $params);
			if(!empty($log) && $log['status'] == '0') {
					pdo_update('meepo_online_pinglun',array('status'=>'1'),array('id'=>$log['id']));
					pdo_query("UPDATE ".tablename('meepo_online_list')." SET pinglun = pinglun + 1 WHERE weid = :weid AND id=:id",array(':weid'=>$_W['uniacid'],':id'=>$log['listid']));
				$site = WeUtility::createModuleSite('meepo_online');
				if(!is_error($site)) {
					$method = 'payResult';
					if (method_exists($site, $method)) {
						$ret = array();
						$ret['weid'] = $log['weid'];
						$ret['uniacid'] = $log['uniacid'];
						$ret['acid'] = $log['acid'];
						$ret['result'] = 'success';
						$ret['type'] = $log['type'];
						$ret['from'] = 'notify';
						$ret['tid'] = $log['tid'];
						$ret['uniontid'] = $pay_id;
						$ret['listid'] = $log['listid'];
						$ret['trade_type'] = $get['trade_type'];
						$ret['follow'] = $get['is_subscribe'] == 'Y' ? 1 : 0;
						$ret['user'] = empty($get['openid']) ? $log['openid'] : $get['openid'];
						$ret['fee'] = $log['money'];
						$ret['tag'] = $log['content'];
						$ret['num'] = intval($log['num']);
						if(!empty($get['time_end'])) {
							$ret['paytime'] = strtotime($get['time_end']);
						}
						$site->$method($ret);
						if($isxml) {
							$result = array(
								'return_code' => 'SUCCESS',
								'return_msg' => 'OK'
							);
							echo array2xml($result);
							exit;
						} else {
							exit('success');
						}
					}
				}
			}
		}
	}
}
if($isxml) {
	die('fail');
	exit;
} else {
	die('fail');
}
