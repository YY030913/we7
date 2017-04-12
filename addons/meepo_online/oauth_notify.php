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
			$sql = 'SELECT * FROM ' . tablename('meepo_online_pinglun') . ' WHERE `id`=:id';
			$params = array();
			$pay_id  =  substr($get['out_trade_no'],10);
			$params[':id'] = $pay_id;
			$log = pdo_fetch($sql, $params);
			if(!empty($log) && $log['status'] == '0') {
					pdo_update('meepo_online_pinglun',array('status'=>'1'),array('id'=>$log['id']));
					pdo_query("UPDATE ".tablename('meepo_online_list')." SET pinglun = pinglun + 1 WHERE  
					id=:id",array(':id'=>$log['listid']));
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
