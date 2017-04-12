<?php

class Common_EweiShopV2Model
{
	public function getSetData($uniacid = 0)
	{
		global $_W;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$set = m('cache')->getArray('sysset', $uniacid);

		if (empty($set)) {
			$set = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));

			if (empty($set)) {
				$set = array();
			}

			m('cache')->set('sysset', $set, $uniacid);
		}

		return $set;
	}

	public function getSysset($key = '', $uniacid = 0)
	{
		global $_W;
		global $_GPC;
		$set = $this->getSetData($uniacid);
		$allset = iunserializer($set['sets']);
		$retsets = array();

		if (!empty($key)) {
			if (is_array($key)) {
				foreach ($key as $k) {
					$retsets[$k] = isset($allset[$k]) ? $allset[$k] : array();
				}
			}
			else {
				$retsets = (isset($allset[$key]) ? $allset[$key] : array());
			}

			return $retsets;
		}

		return $allset;
	}

	public function getPluginset($key = '', $uniacid = 0)
	{
		global $_W;
		global $_GPC;
		$set = $this->getSetData($uniacid);
		$allset = iunserializer($set['plugins']);
		$retsets = array();

		if (!empty($key)) {
			if (is_array($key)) {
				foreach ($key as $k) {
					$retsets[$k] = isset($allset[$k]) ? $allset[$k] : array();
				}
			}
			else {
				$retsets = (isset($allset[$key]) ? $allset[$key] : array());
			}

			return $retsets;
		}

		return $allset;
	}

	public function updateSysset($values, $uniacid = 0)
	{
		global $_W;
		global $_GPC;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$setdata = pdo_fetch('select id, sets from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));

		if (empty($setdata)) {
			pdo_insert('ewei_shop_sysset', array('sets' => iserializer($values), 'uniacid' => $uniacid));
		}
		else {
			$sets = iunserializer($setdata['sets']);

			foreach ($values as $key => $value) {
				foreach ($value as $k => $v) {
					$sets[$key][$k] = $v;
				}
			}

			pdo_update('ewei_shop_sysset', array('sets' => iserializer($sets)), array('id' => $setdata['id']));
		}

		$setdata = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
		m('cache')->set('sysset', $setdata, $uniacid);
		$this->setGlobalSet();
	}

	public function updatePluginset($values, $uniacid = 0)
	{
		global $_W;
		global $_GPC;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$setdata = pdo_fetch('select id, plugins from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));

		if (empty($setdata)) {
			pdo_insert('ewei_shop_sysset', array('plugins' => iserializer($values), 'uniacid' => $uniacid));
		}
		else {
			$plugins = iunserializer($setdata['plugins']);

			foreach ($values as $key => $value) {
				foreach ($value as $k => $v) {
					$plugins[$key][$k] = $v;
				}
			}

			pdo_update('ewei_shop_sysset', array('plugins' => iserializer($plugins)), array('id' => $setdata['id']));
		}

		$setdata = pdo_fetch('select * from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));
		m('cache')->set('sysset', $setdata, $uniacid);
		$this->setGlobalSet();
	}

	public function setGlobalSet()
	{
		$sysset = $this->getSysset();
		$pluginset = $this->getPluginset();

		if (is_array($pluginset)) {
			foreach ($pluginset as $k => $v) {
				$sysset[$k] = $v;
			}
		}

		m('cache')->set('globalset', $sysset);
		return $sysset;
	}

	public function alipay_build($params, $alipay = array(), $type = 0, $openid = '')
	{
		global $_W;
		$tid = $params['tid'];
		$set = array();
		$set['service'] = 'alipay.wap.create.direct.pay.by.user';
		$set['partner'] = $alipay['partner'];
		$set['_input_charset'] = 'utf-8';
		$set['sign_type'] = 'MD5';

		if (empty($type)) {
			$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$set['return_url'] = mobileUrl('order/pay/alipay_complete', array('openid' => $openid), true);
		}
		else {
			$set['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/alipay/notify.php';
			$set['return_url'] = mobileUrl('member/recharge/alipay_complete', array('openid' => $openid), true);
		}

		$set['out_trade_no'] = $tid;
		$set['subject'] = $params['title'];
		$set['total_fee'] = $params['fee'];
		$set['seller_id'] = $alipay['account'];
		$set['payment_type'] = 1;
		$set['body'] = $_W['uniacid'] . ':' . $type;
		$prepares = array();

		foreach ($set as $key => $value) {
			if (($key != 'sign') && ($key != 'sign_type')) {
				$prepares[] = $key . '=' . $value;
			}
		}

		sort($prepares);
		$string = implode($prepares, '&');
		$string .= $alipay['secret'];
		$set['sign'] = md5($string);
		return array('url' => ALIPAY_GATEWAY . '?' . http_build_query($set, '', '&'));
	}

	public function wechat_build($params, $wechat, $type = 0)
	{
		global $_W;
		load()->func('communication');
		if (empty($wechat['version']) && !empty($wechat['signkey'])) {
			$wechat['version'] = 1;
		}

		$wOpt = array();

		if ($wechat['version'] == 1) {
			$wOpt['appId'] = $wechat['appid'];
			$wOpt['timeStamp'] = TIMESTAMP . '';
			$wOpt['nonceStr'] = random(8) . '';
			$package = array();
			$package['bank_type'] = 'WX';
			$package['body'] = urlencode($params['title']);
			$package['attach'] = $_W['uniacid'] . ':' . $type;
			$package['partner'] = $wechat['partner'];
			$package['device_info'] = 'ewei_shopv2';
			$package['out_trade_no'] = $params['tid'];
			$package['total_fee'] = $params['fee'] * 100;
			$package['fee_type'] = '1';
			$package['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php';
			$package['spbill_create_ip'] = CLIENT_IP;
			$package['input_charset'] = 'UTF-8';
			ksort($package);
			$string1 = '';

			foreach ($package as $key => $v) {
				if (empty($v)) {
					continue;
				}

				$string1 .= $key . '=' . $v . '&';
			}

			$string1 .= 'key=' . $wechat['key'];
			$sign = strtoupper(md5($string1));
			$string2 = '';

			foreach ($package as $key => $v) {
				$v = urlencode($v);
				$string2 .= $key . '=' . $v . '&';
			}

			$string2 .= 'sign=' . $sign;
			$wOpt['package'] = $string2;
			$string = '';
			$keys = array('appId', 'timeStamp', 'nonceStr', 'package', 'appKey');
			sort($keys);

			foreach ($keys as $key) {
				$v = $wOpt[$key];

				if ($key == 'appKey') {
					$v = $wechat['signkey'];
				}

				$key = strtolower($key);
				$string .= $key . '=' . $v . '&';
			}

			$string = rtrim($string, '&');
			$wOpt['signType'] = 'SHA1';
			$wOpt['paySign'] = sha1($string);
			return $wOpt;
		}

		$package = array();
		$package['appid'] = $wechat['appid'];
		$package['mch_id'] = $wechat['mchid'];
		$package['nonce_str'] = random(8) . '';
		$package['body'] = $params['title'];
		$package['device_info'] = 'ewei_shopv2';
		$package['attach'] = $_W['uniacid'] . ':' . $type;
		$package['out_trade_no'] = $params['tid'];
		$package['total_fee'] = $params['fee'] * 100;
		$package['spbill_create_ip'] = CLIENT_IP;
		$package['notify_url'] = $_W['siteroot'] . 'addons/ewei_shopv2/payment/wechat/notify.php';
		$package['trade_type'] = 'JSAPI';
		$package['openid'] = $_W['openid'];
		ksort($package, SORT_STRING);
		$string1 = '';

		foreach ($package as $key => $v) {
			if (empty($v)) {
				continue;
			}

			$string1 .= $key . '=' . $v . '&';
		}

		$string1 .= 'key=' . $wechat['signkey'];
		$package['sign'] = strtoupper(md5($string1));
		$dat = array2xml($package);
		$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);

		if (is_error($response)) {
			return $response;
		}

		$xml = @simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);

		if (strval($xml->return_code) == 'FAIL') {
			return error(-1, strval($xml->return_msg));
		}

		if (strval($xml->result_code) == 'FAIL') {
			return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
		}

		$prepayid = $xml->prepay_id;
		$wOpt['appId'] = $wechat['appid'];
		$wOpt['timeStamp'] = TIMESTAMP . '';
		$wOpt['nonceStr'] = random(8) . '';
		$wOpt['package'] = 'prepay_id=' . $prepayid;
		$wOpt['signType'] = 'MD5';
		ksort($wOpt, SORT_STRING);

		foreach ($wOpt as $key => $v) {
			$string .= $key . '=' . $v . '&';
		}

		$string .= 'key=' . $wechat['signkey'];
		$wOpt['paySign'] = strtoupper(md5($string));
		return $wOpt;
	}

	public function getAccount()
	{
		global $_W;
		load()->model('account');

		if (!empty($_W['acid'])) {
			return WeAccount::create($_W['acid']);
		}

		$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		return WeAccount::create($acid);
	}

	public function createNO($table, $field, $prefix)
	{
		$billno = date('YmdHis') . random(6, true);

		while (1) {
			$count = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_' . $table) . ' where ' . $field . '=:billno limit 1', array(':billno' => $billno));

			if ($count <= 0) {
				break;
			}

			$billno = date('YmdHis') . random(6, true);
		}

		return $prefix . $billno;
	}

	public function html_images($detail = '')
	{
		$detail = htmlspecialchars_decode($detail);
		preg_match_all('/<img.*?src=[\\\'| \\"](.*?(?:[\\.gif|\\.jpg|\\.png|\\.jpeg]?))[\\\'|\\"].*?[\\/]?>/', $detail, $imgs);
		$images = array();

		if (isset($imgs[1])) {
			foreach ($imgs[1] as $img) {
				$im = array('old' => $img, 'new' => save_media($img));
				$images[] = $im;
			}
		}

		foreach ($images as $img) {
			$detail = str_replace($img['old'], $img['new'], $detail);
		}

		return $detail;
	}

	public function array_images($arr)
	{
		foreach ($arr as &$a) {
			$a = save_media($a);
		}

		unset($a);
		return $arr;
	}

	public function getSec($uniacid = 0)
	{
		global $_W;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$set = pdo_fetch('select sec from ' . tablename('ewei_shop_sysset') . ' where uniacid=:uniacid limit 1', array(':uniacid' => $uniacid));

		if (empty($set)) {
			$set = array();
		}

		return $set;
	}

	public function paylog($log = '')
	{
		global $_W;
		$openpaylog = m('cache')->getString('paylog', 'global');

		if (!empty($openpaylog)) {
			$path = IA_ROOT . '/addons/ewei_shopv2/data/paylog/' . $_W['uniacid'] . '/' . date('Ymd');

			if (!is_dir($path)) {
				load()->func('file');
				@mkdirs($path, '0777');
			}

			$file = $path . '/' . date('H') . '.log';
			file_put_contents($file, $log, FILE_APPEND);
		}
	}

	public function getAreas()
	{
		$file = IA_ROOT . '/addons/ewei_shopv2/static/js/dist/area/Area.xml';
		$file_str = file_get_contents($file);
		$areas = json_decode(json_encode(simplexml_load_string($file_str)), true);
		return $areas;
	}

	public function getWechats()
	{
		return pdo_fetchall('SELECT  a.uniacid,a.name FROM ' . tablename('ewei_shop_sysset') . ' s  ' . ' left join ' . tablename('account_wechats') . ' a on a.uniacid = s.uniacid');
	}

	public function getCopyright($ismanage = false)
	{
		global $_W;
		$copyrights = m('cache')->getArray('systemcopyright', 'global');

		if (!is_array($copyrights)) {
			$copyrights = pdo_fetchall('select *  from ' . tablename('ewei_shop_system_copyright'));
			m('cache')->set('systemcopyright', $copyrights, 'global');
		}

		$copyright = false;

		foreach ($copyrights as $cr) {
			if ($cr['uniacid'] == $_W['uniacid']) {
				if ($ismanage && ($cr['ismanage'] == 1)) {
					$copyright = $cr;
					break;
				}

				if (!$ismanage && ($cr['ismanage'] == 0)) {
					$copyright = $cr;
					break;
				}
			}
		}

		if (!$copyright) {
			foreach ($copyrights as $cr) {
				if ($cr['uniacid'] == -1) {
					if ($ismanage && ($cr['ismanage'] == 1)) {
						$copyright = $cr;
						break;
					}

					if (!$ismanage && ($cr['ismanage'] == 0)) {
						$copyright = $cr;
						break;
					}
				}
			}
		}

		return $copyright;
	}

	public function keyExist($key = '')
	{
		global $_W;

		if (empty($key)) {
			return NULL;
		}

		$keyword = pdo_fetch('SELECT * FROM ' . tablename('rule_keyword') . ' WHERE content=:content and uniacid=:uniacid limit 1 ', array(':content' => trim($key), ':uniacid' => $_W['uniacid']));

		if (!empty($keyword)) {
			$rule = pdo_fetch('SELECT * FROM ' . tablename('rule') . ' WHERE id=:id and uniacid=:uniacid limit 1 ', array(':id' => $keyword['rid'], ':uniacid' => $_W['uniacid']));

			if (!empty($rule)) {
				return $rule;
			}
		}
	}

	public function createStaticFile($url, $regen = false)
	{
		global $_W;

		if (empty($url)) {
			return NULL;
		}

		$url = preg_replace('/(&|\\?)mid=[^&]+/', '', $url);
		$cache = md5($url) . '_html';
		$content = m('cache')->getString($cache);
		if (empty($content) || $regen) {
			load()->func('communication');
			$resp = ihttp_request($url, array('site' => 'createStaticFile'));
			$content = $resp['content'];
			m('cache')->set($cache, $content);
		}

		return $content;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
