<?php
/**
 * 米波在线直播模块微站定义
 *
 * @author 米波团队
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
class Meepo_onlineModuleSite extends WeModuleSite {
		public $category_table = 'meepo_online_category';
		public $list_table = 'meepo_online_list';
		public $user_table = 'meepo_online_user';
		public $pinglun_table = 'meepo_online_pinglun';
		public $my_live_table = 'meepo_my_live';
		public $zan_table = 'meepo_online_list_zan';
		public $advs_table = 'meepo_online_adv';
		public $list_user_table = 'meepo_online_list_user';
		public $share_table = 'meepo_online_list_share';
		//public $my_alive_table = 'meepo_online_my_alive';
		public $setting_table = 'meepo_online_setting';
		public $listmenu_table = 'meepo_online_list_menu';
		public $gift_table = 'meepo_online_list_gift';
		public $shake_record_table = 'meepo_online_list_shake_record';
		public $shake_award_table = 'meepo_online_list_shake_award';
		public $footer_menu_table = 'meepo_footer_menu';
		public $online_pay_record = 'meepo_online_list_lookpay';
		public $online_code_record = 'meepo_online_list_lookcode';
		public $dayu_table = 'meepo_online_dayu_sms';
		public $dayu_sms_record = 'meepo_online_dayu_sms_record';
		public $need_input_table = 'meepo_online_list_need_input';
		public $live_news_table = 'meepo_online_list_live_news';
		public $live_news_reply  = 'meepo_online_list_live_news_reply';
		public $live_news_zan = 'meepo_online_list_live_news_zan';
		public function sendMess($params) {
			global $_W, $_GPC;
			$_W['uniacid'] = $_W['weid'] = $params['uniacid'];
			$weid = $_W['uniacid'];
			if(!empty($params['listid'])){
				$listid  = intval($params['listid']);
				$live_list = pdo_fetch("SELECT `title` FROM ".tablename($this->list_table)." WHERE weid=:weid  AND  id=:id",array(':weid'=>$params['uniacid'],':id'=>$listid));
				$news_config =  iunserializer(pdo_fetchcolumn("SELECT `settings` FROM ".tablename($this->setting_table)." WHERE weid=:weid",array(':weid' =>$params['uniacid'])));
				$people = pdo_fetchall("SELECT `openid`,`createtime`,`mobile` FROM ".tablename($this->my_live_table)." WHERE listid=:listid AND weid=:weid",array(':listid'=>$listid,':weid'=>$params['uniacid']));
				$dayu = pdo_fetch("SELECT * FROM ".tablename($this->dayu_table)." WHERE weid=:weid",array(':weid'=>$params['uniacid']));
				include IA_ROOT."/addons/meepo_online/alidayu/TopSdk.php";
				if(!empty($people) && is_array($people)){
					foreach($people as $row){
						$data_title = '您预约的直播、马上就开始啦！';
						$data_content = '直播主题:'.$live_list['title'];
						$data_url = $this->createMobileUrl('detail',array('listid'=>$listid));
						$nikcname = pdo_fetchcolumn("SELECT `nickname` FROM ".tablename($this->list_user_table)." WHERE listid=:listid AND openid=:openid",array(':listid'=>$listid,':openid'=>$row['openid']));
						$tpl_data = array();
						$tpl_data['first'] = array('value'=>$data_title, 'color'=>'#173177');
						$tpl_data['keyword1'] = array('value'=>$nikcname, 'color'=>'#173177');
						$tpl_data['keyword2'] = array('value'=>$data_content, 'color'=>'#173177');
						$tpl_data['keyword3'] = array('value'=>date("Y-m-d H:i",$row['createtime']), 'color'=>'#173177');
						$tpl_data['remark'] = array('value'=>"点击进入直播！", 'color'=>'#173177');
						$result = $this->mc_notice_consume($news_config['yuyue_tpl'],$tpl_data,$row['openid'], $data_title, $data_content, $data_url,$news_config['yuyue_customer_img']);
						if(!empty($row['mobile'])){
							$mobile_code = random(5,true);
							$c = new TopClient();
							$c->appkey = $dayu['appkey'];
							$c->secretKey = $dayu['appsecret'];
							$req = new AlibabaAliqinFcSmsNumSendRequest;
							$req->setExtend("123456");
							$req->setSmsType("normal");
							$req->setSmsFreeSignName($dayu['sms_signname']);
							$json = json_encode(array("fans_user"=>$nikcname,'account_name'=>$_W['account']['name'],'item_name'=>$live_list['title']));
							$req->setSmsParam($json);
							$req->setRecNum($row['mobile']);
							$req->setSmsTemplateCode($dayu['sms_success_tpl_id']);//  SMS_585014  SMS_6290144
							$result = $c->execute($req);
						}
					}
				}
			}
		}
		public function payResult($params) {
			global $_W, $_GPC;
			if ($params['result'] == 'success' && $params['from'] == 'notify') {
						$openid  = $params['user'];
						$weid  = $_W['uniacid'];
						$listid = intval($params['listid']);
						$live_list = pdo_fetch("SELECT `title` FROM ".tablename($this->list_table)." WHERE weid=:weid  AND  id=:id",array(':weid'=>$weid,':id'=>$listid));
						$news_config =  iunserializer(pdo_fetchcolumn("SELECT `settings` FROM ".tablename($this->setting_table)." WHERE weid=:weid",array(':weid' =>$weid)));
						$data_url = $this->createMobileUrl('detail',array('listid'=>$listid));
						if($params['type']=='redpack'){
							$data_title = '您在'.$live_list['title'].'活动、支付打赏红包成功';
							$data_goods  = '打赏红包';
						}else{
							$data_title = '您在'.$live_list['title'].'活动、购买'.$params['tag'].'成功、数量：'.$params['num'];
							$data_goods  = $params['tag'];
						}
						$data_content = '共支付了'.$params['fee'].'元';
						$tpl_data = array();
						$tpl_data['first'] = array('value'=>$data_title, 'color'=>'#173177');
						$tpl_data['orderMoneySum'] = array('value'=>$params['fee'].'元', 'color'=>'#173177');
						$tpl_data['orderProductName'] = array('value'=>$data_goods, 'color'=>'#173177');
						$tpl_data['remark'] = array('value'=>"感谢您的参与!", 'color'=>'#173177');
						$this->mc_notice_consume($news_config['consumer_tpl'],$tpl_data,$openid, $data_title, $data_content, $data_url,$news_config['consumer_customer_img']);
						
			}	
		}
		public function payResultlook($params) {
				global $_W, $_GPC;
			if ($params['result'] == 'success' && $params['from'] == 'notify') {
						$openid  = $params['user'];
						$weid  = $_W['uniacid'];
						$listid = intval($params['listid']);
						$live_list = pdo_fetch("SELECT `title` FROM ".tablename('meepo_online_list')." WHERE weid=:weid  AND  id=:id",array(':weid'=>$weid,':id'=>$listid));
						$news_config =  iunserializer(pdo_fetchcolumn("SELECT `settings` FROM ".tablename($this->setting_table)." WHERE weid=:weid",array(':weid' =>$weid)));
						$data_url = $this->createMobileUrl('detail',array('listid'=>$listid));
					
							$data_title = '您在'.$live_list['title'].'活动、购买直播观看权成功';
							$data_goods  = '购买直播观看权';
						
						$data_content = '共支付了'.$params['fee'].'元';
						$tpl_data = array();
						$tpl_data['first'] = array('value'=>$data_title, 'color'=>'#173177');
						$tpl_data['orderMoneySum'] = array('value'=>$params['fee'].'元', 'color'=>'#173177');
						$tpl_data['orderProductName'] = array('value'=>$data_goods, 'color'=>'#173177');
						$tpl_data['remark'] = array('value'=>"感谢您的参与!", 'color'=>'#173177');
						$this->mc_notice_consume($news_config['consumer_tpl'],$tpl_data,$openid, $data_title, $data_content, $data_url,$news_config['consumer_customer_img']);
						
			}	
		}
		public function mc_notice_consume($tpl_id ='',$tpl_data = array(),$openid, $title, $content, $url = '',$thumb='') {
			global $_W;
			load()->model('mc');
			$acc = mc_notice_init();
			if(is_error($acc)) {
				//return error(-1, $acc['message']);
			}
			if($_W['account']['level'] == 4) {
				$real_url = $_W['siteroot']. 'app/'.$url;
				if(strexists($real_url,'/addons/meepo_online')){
					$real_url = str_replace('/addons/meepo_online','',$real_url);
				}
				$status = $acc->sendTplNotice($openid, $tpl_id,$tpl_data, $real_url);
				if(is_error($status)){
					$status = $this->mc_notice_custom_news($openid, $title, $content,$url,$thumb);
				}
			}
			if($_W['account']['level'] == 3) {
				$status = $this->mc_notice_custom_news($openid, $title, $content,$url,$thumb);
			}
			
		}
		public function mc_notice_custom_news($openid, $title, $content,$url,$thumb) {
			global $_W;
			load()->model('mc');
			$acc = mc_notice_init();
			if(is_error($acc)) {
				return error(-1, $acc['message']);
			}
			$fans = pdo_fetch('SELECT salt,acid,openid FROM ' . tablename('mc_mapping_fans') . ' WHERE uniacid = :uniacid AND openid = :openid', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			$row = array();
			$row['title'] = urlencode($title);
			$row['description'] = urlencode($content);
			$row['picurl'] = tomedia($thumb);
			if(strexists($row['picurl'],'/addons/meepo_online')){
					$row['picurl'] = str_replace('/addons/meepo_online','',$row['picurl']);
			}
			$pass['time'] = TIMESTAMP;
			$pass['acid'] = $fans['acid'];
			$pass['openid'] = $fans['openid'];
			$pass['hash'] = md5("{$fans['openid']}{$pass['time']}{$fans['salt']}{$_W['config']['setting']['authkey']}");
			$auth = base64_encode(json_encode($pass));
			$vars = array();
			$vars['__auth'] = $auth;
			$vars['forward'] = base64_encode($url);
			$row['url'] =  $_W['siteroot']. 'app/' . murl('auth/forward', $vars);
			if(strexists($row['url'],'/addons/meepo_online')){
					$row['url'] = str_replace('/addons/meepo_online','',$row['url']);
			}
			$news[] = $row;
			$send['touser'] = trim($openid);
			$send['msgtype'] = 'news';
			$send['news']['articles'] = $news;
			$status = $acc->sendCustomNotice($send);
			return $status;
		}
		public function logging_run($log, $type = 'normal', $filename) {
				global $_W;
				$weid = $_W['uniacid'];
				$filename = IA_ROOT . '/addons/meepo_online/'.$weid.'/'. $filename . '_' . date('Ymd') . '.log';
				load()->func('logging');
				load()->func('file');
				mkdirs(dirname($filename));
				$logFormat = "%date %type %user %url %context";
				if (!empty($GLOBALS['_POST'])) {
					$context[] = logging_implode($GLOBALS['_POST']);
				}
				if (is_array($log)) {
					$context[] = logging_implode($log);
				} else {
					$context[] = preg_replace('/[ \t\r\n]+/', ' ', $log);
				}
				$log = str_replace(explode(' ', $logFormat), array(
					'[' . date('Y-m-d H:i:s', $_W['timestamp']) . ']',
					$type,
					$_W['username'],
					$_SERVER["PHP_SELF"] . "?" . $_SERVER["QUERY_STRING"],
					implode("\n", $context),
				), $logFormat);

				file_put_contents($filename, $log . "\r\n", FILE_APPEND);
				return true;
		}
		public function get_follow_fansinfo($openid){
					global $_W,$_GPC;
					$access_token = $this->getAccessToken();
					$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
					load()->func('communication');
					$content = ihttp_request($url);		
					$info = @json_decode($content['content'], true);
					return $info;
		}
		public  function  getAccessToken () {
			global $_W;
			load()->classs('weixin.account');
			$accObj = WeixinAccount::create($_W['acid']);
			$access_token = $accObj->fetch_token();
			return $access_token;
		}

		public function wechat_build($params, $wechat) {
			global $_W;
			load()->func('communication');
			if (empty($wechat['version']) && !empty($wechat['signkey'])) {
				$wechat['version'] = 1;
			}
			$wOpt = array();
			if ($wechat['version'] == 1) {
				$wOpt['appId'] = $wechat['appid'];
				$wOpt['timeStamp'] = TIMESTAMP;
				$wOpt['nonceStr'] = random(8);
				$package = array();
				$package['bank_type'] = 'WX';
				$package['body'] = $params['title'];
				$package['attach'] = $_W['uniacid'];
				$package['partner'] = $wechat['partner'];
				$package['out_trade_no'] = $params['uniontid'];
				$package['total_fee'] = $params['fee'] * 100;
				$package['fee_type'] = '1';
				$package['notify_url'] = $_W['siteroot'] . 'addons/meepo_online/notify.php';
				$package['spbill_create_ip'] = CLIENT_IP;
				$package['time_start'] = date('YmdHis', TIMESTAMP);
				$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
				$package['input_charset'] = 'UTF-8';
				ksort($package);
				$string1 = '';
				foreach($package as $key => $v) {
					if (empty($v)) {
						continue;
					}
					$string1 .= "{$key}={$v}&";
				}
				$string1 .= "key={$wechat['key']}";
				$sign = strtoupper(md5($string1));

				$string2 = '';
				foreach($package as $key => $v) {
					$v = urlencode($v);
					$string2 .= "{$key}={$v}&";
				}
				$string2 .= "sign={$sign}";
				$wOpt['package'] = $string2;

				$string = '';
				$keys = array('appId', 'timeStamp', 'nonceStr', 'package', 'appKey');
				sort($keys);
				foreach($keys as $key) {
					$v = $wOpt[$key];
					if($key == 'appKey') {
						$v = $wechat['signkey'];
					}
					$key = strtolower($key);
					$string .= "{$key}={$v}&";
				}
				$string = rtrim($string, '&');

				$wOpt['signType'] = 'SHA1';
				$wOpt['paySign'] = sha1($string);
				return $wOpt;
			} else {
				$package = array();
				$package['appid'] = $wechat['appid'];
				$package['mch_id'] = $wechat['mchid'];
				$package['nonce_str'] = random(8);
				$package['body'] = $params['title'];
				$package['attach'] = $_W['uniacid'];
				$package['out_trade_no'] = $params['uniontid'];
				$package['total_fee'] = $params['fee'] * 100;
				$package['spbill_create_ip'] = CLIENT_IP;
				$package['time_start'] = date('YmdHis', TIMESTAMP);
				$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
				$package['notify_url'] = $_W['siteroot'] . 'addons/meepo_online/notify.php';
				$package['trade_type'] = 'JSAPI';
				$package['openid'] = $_W['fans']['from_user'];
				ksort($package, SORT_STRING);
				$string1 = '';
				foreach($package as $key => $v) {
					if (empty($v)) {
						continue;
					}
					$string1 .= "{$key}={$v}&";
				}
				$string1 .= "key={$wechat['signkey']}";
				$package['sign'] = strtoupper(md5($string1));
				$dat = array2xml($package);
				$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
				if (is_error($response)) {
					return $response;
				}
				$xml = @isimplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
				if (strval($xml->return_code) == 'FAIL') {
					return error(-1, strval($xml->return_msg));
				}
				if (strval($xml->result_code) == 'FAIL') {
					return error(-1, strval($xml->err_code).': '.strval($xml->err_code_des));
				}
				$prepayid = $xml->prepay_id;
				$wOpt['appId'] = $wechat['appid'];
				$wOpt['timeStamp'] = TIMESTAMP;
				$wOpt['nonceStr'] = random(8);
				$wOpt['package'] = 'prepay_id='.$prepayid;
				$wOpt['signType'] = 'MD5';
				ksort($wOpt, SORT_STRING);
				foreach($wOpt as $key => $v) {
					$string .= "{$key}={$v}&";
				}
				$string .= "key={$wechat['signkey']}";
				$wOpt['paySign'] = strtoupper(md5($string));
				return $wOpt;
			}
		}
		public function wechat_build_look($params, $wechat) {
			global $_W;
			load()->func('communication');
			if (empty($wechat['version']) && !empty($wechat['signkey'])) {
				$wechat['version'] = 1;
			}
			$wOpt = array();
			if ($wechat['version'] == 1) {
				$wOpt['appId'] = $wechat['appid'];
				$wOpt['timeStamp'] = TIMESTAMP;
				$wOpt['nonceStr'] = random(8);
				$package = array();
				$package['bank_type'] = 'WX';
				$package['body'] = $params['title'];
				$package['attach'] = $_W['uniacid'];
				$package['partner'] = $wechat['partner'];
				$package['out_trade_no'] = $params['uniontid'];
				$package['total_fee'] = $params['fee'] * 100;
				$package['fee_type'] = '1';
				$package['notify_url'] = $_W['siteroot'] . 'addons/meepo_online/notify_look.php';
				$package['spbill_create_ip'] = CLIENT_IP;
				$package['time_start'] = date('YmdHis', TIMESTAMP);
				$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
				$package['input_charset'] = 'UTF-8';
				ksort($package);
				$string1 = '';
				foreach($package as $key => $v) {
					if (empty($v)) {
						continue;
					}
					$string1 .= "{$key}={$v}&";
				}
				$string1 .= "key={$wechat['key']}";
				$sign = strtoupper(md5($string1));

				$string2 = '';
				foreach($package as $key => $v) {
					$v = urlencode($v);
					$string2 .= "{$key}={$v}&";
				}
				$string2 .= "sign={$sign}";
				$wOpt['package'] = $string2;

				$string = '';
				$keys = array('appId', 'timeStamp', 'nonceStr', 'package', 'appKey');
				sort($keys);
				foreach($keys as $key) {
					$v = $wOpt[$key];
					if($key == 'appKey') {
						$v = $wechat['signkey'];
					}
					$key = strtolower($key);
					$string .= "{$key}={$v}&";
				}
				$string = rtrim($string, '&');

				$wOpt['signType'] = 'SHA1';
				$wOpt['paySign'] = sha1($string);
				return $wOpt;
			} else {
				$package = array();
				$package['appid'] = $wechat['appid'];
				$package['mch_id'] = $wechat['mchid'];
				$package['nonce_str'] = random(8);
				$package['body'] = $params['title'];
				$package['attach'] = $_W['uniacid'];
				$package['out_trade_no'] = $params['uniontid'];
				$package['total_fee'] = $params['fee'] * 100;
				$package['spbill_create_ip'] = CLIENT_IP;
				$package['time_start'] = date('YmdHis', TIMESTAMP);
				$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
				$package['notify_url'] = $_W['siteroot'] . 'addons/meepo_online/notify_look.php';
				$package['trade_type'] = 'JSAPI';
				$package['openid'] = $_W['fans']['from_user'];
				ksort($package, SORT_STRING);
				$string1 = '';
				foreach($package as $key => $v) {
					if (empty($v)) {
						continue;
					}
					$string1 .= "{$key}={$v}&";
				}
				$string1 .= "key={$wechat['signkey']}";
				$package['sign'] = strtoupper(md5($string1));
				$dat = array2xml($package);
				$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
				if (is_error($response)) {
					return $response;
				}
				$xml = @isimplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
				if (strval($xml->return_code) == 'FAIL') {
					return error(-1, strval($xml->return_msg));
				}
				if (strval($xml->result_code) == 'FAIL') {
					return error(-1, strval($xml->err_code).': '.strval($xml->err_code_des));
				}
				$prepayid = $xml->prepay_id;
				$wOpt['appId'] = $wechat['appid'];
				$wOpt['timeStamp'] = TIMESTAMP;
				$wOpt['nonceStr'] = random(8);
				$wOpt['package'] = 'prepay_id='.$prepayid;
				$wOpt['signType'] = 'MD5';
				ksort($wOpt, SORT_STRING);
				foreach($wOpt as $key => $v) {
					$string .= "{$key}={$v}&";
				}
				$string .= "key={$wechat['signkey']}";
				$wOpt['paySign'] = strtoupper(md5($string));
				return $wOpt;
			}
		}
		public function wechat_oauth_look_build($params, $wechat) {
				global $_W;
			load()->func('communication');
			if (empty($wechat['version']) && !empty($wechat['signkey'])) {
				$wechat['version'] = 1;
			}
			
			$wOpt = array();
			if ($wechat['version'] == 1) {
				$wOpt['appId'] = $wechat['appid'];
				$wOpt['timeStamp'] = TIMESTAMP;
				$wOpt['nonceStr'] = random(8);
				$package = array();
				$package['bank_type'] = 'WX';
				$package['body'] = $params['title'];
				$package['attach'] = $_W['uniacid'];
				$package['partner'] = $wechat['partner'];
				$package['out_trade_no'] = $params['uniontid'];
				$package['total_fee'] = $params['fee'] * 100;
				$package['fee_type'] = '1';
				$package['notify_url'] = $_W['siteroot'] . 'addons/meepo_online/oauth_look_notify.php';
				$package['spbill_create_ip'] = CLIENT_IP;
				$package['time_start'] = date('YmdHis', TIMESTAMP);
				$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
				$package['input_charset'] = 'UTF-8';
				ksort($package);
				$string1 = '';
				foreach($package as $key => $v) {
					if (empty($v)) {
						continue;
					}
					$string1 .= "{$key}={$v}&";
				}
				$string1 .= "key={$wechat['key']}";
				$sign = strtoupper(md5($string1));

				$string2 = '';
				foreach($package as $key => $v) {
					$v = urlencode($v);
					$string2 .= "{$key}={$v}&";
				}
				$string2 .= "sign={$sign}";
				$wOpt['package'] = $string2;

				$string = '';
				$keys = array('appId', 'timeStamp', 'nonceStr', 'package', 'appKey');
				sort($keys);
				foreach($keys as $key) {
					$v = $wOpt[$key];
					if($key == 'appKey') {
						$v = $wechat['signkey'];
					}
					$key = strtolower($key);
					$string .= "{$key}={$v}&";
				}
				$string = rtrim($string, '&');

				$wOpt['signType'] = 'SHA1';
				$wOpt['paySign'] = sha1($string);
				return $wOpt;
			} else {
				$package = array();
				$package['appid'] = $wechat['appid'];
				$package['mch_id'] = $wechat['mchid'];
				$package['nonce_str'] = random(8);
				$package['body'] = $params['title'];
				$package['attach'] = $_W['uniacid'];
				$package['out_trade_no'] = $params['uniontid'];
				$package['total_fee'] = $params['fee'] * 100;
				$package['spbill_create_ip'] = CLIENT_IP;
				$package['time_start'] = date('YmdHis', TIMESTAMP);
				$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
				$package['notify_url'] = $_W['siteroot'] . 'addons/meepo_online/oauth_look_notify.php';
				$package['trade_type'] = 'JSAPI';
				$package['openid'] = $_W['fans']['from_user'];
				ksort($package, SORT_STRING);
				$string1 = '';
				foreach($package as $key => $v) {
					if (empty($v)) {
						continue;
					}
					$string1 .= "{$key}={$v}&";
				}
				$string1 .= "key={$wechat['signkey']}";
				$package['sign'] = strtoupper(md5($string1));
				$dat = array2xml($package);
				$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
				
				if (is_error($response)) {
					return $response;
				}
				$xml = @isimplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
				
				if (strval($xml->return_code) == 'FAIL') {
					return error(-1, strval($xml->return_msg));
				}
				if (strval($xml->result_code) == 'FAIL') {
					return error(-1, strval($xml->err_code).': '.strval($xml->err_code_des));
				}
				$prepayid = $xml->prepay_id;
				$wOpt['appId'] = $wechat['appid'];
				$wOpt['timeStamp'] = TIMESTAMP;
				$wOpt['nonceStr'] = random(8);
				$wOpt['package'] = 'prepay_id='.$prepayid;
				$wOpt['signType'] = 'MD5';
				ksort($wOpt, SORT_STRING);
				foreach($wOpt as $key => $v) {
					$string .= "{$key}={$v}&";
				}
				$string .= "key={$wechat['signkey']}";
				$wOpt['paySign'] = strtoupper(md5($string));
				return $wOpt;
		}
		}
		public function wechat_oauth_build($params, $wechat) {
			global $_W;
			load()->func('communication');
			if (empty($wechat['version']) && !empty($wechat['signkey'])) {
				$wechat['version'] = 1;
			}
			
			$wOpt = array();
			if ($wechat['version'] == 1) {
				$wOpt['appId'] = $wechat['appid'];
				$wOpt['timeStamp'] = TIMESTAMP;
				$wOpt['nonceStr'] = random(8);
				$package = array();
				$package['bank_type'] = 'WX';
				$package['body'] = $params['title'];
				$package['attach'] = $_W['uniacid'];
				$package['partner'] = $wechat['partner'];
				$package['out_trade_no'] = $params['uniontid'];
				$package['total_fee'] = $params['fee'] * 100;
				$package['fee_type'] = '1';
				$package['notify_url'] = $_W['siteroot'] . 'addons/meepo_online/oauth_notify.php';
				$package['spbill_create_ip'] = CLIENT_IP;
				$package['time_start'] = date('YmdHis', TIMESTAMP);
				$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
				$package['input_charset'] = 'UTF-8';
				ksort($package);
				$string1 = '';
				foreach($package as $key => $v) {
					if (empty($v)) {
						continue;
					}
					$string1 .= "{$key}={$v}&";
				}
				$string1 .= "key={$wechat['key']}";
				$sign = strtoupper(md5($string1));

				$string2 = '';
				foreach($package as $key => $v) {
					$v = urlencode($v);
					$string2 .= "{$key}={$v}&";
				}
				$string2 .= "sign={$sign}";
				$wOpt['package'] = $string2;

				$string = '';
				$keys = array('appId', 'timeStamp', 'nonceStr', 'package', 'appKey');
				sort($keys);
				foreach($keys as $key) {
					$v = $wOpt[$key];
					if($key == 'appKey') {
						$v = $wechat['signkey'];
					}
					$key = strtolower($key);
					$string .= "{$key}={$v}&";
				}
				$string = rtrim($string, '&');

				$wOpt['signType'] = 'SHA1';
				$wOpt['paySign'] = sha1($string);
				return $wOpt;
			} else {
				$package = array();
				$package['appid'] = $wechat['appid'];
				$package['mch_id'] = $wechat['mchid'];
				$package['nonce_str'] = random(8);
				$package['body'] = $params['title'];
				$package['attach'] = $_W['uniacid'];
				$package['out_trade_no'] = $params['uniontid'];
				$package['total_fee'] = $params['fee'] * 100;
				$package['spbill_create_ip'] = CLIENT_IP;
				$package['time_start'] = date('YmdHis', TIMESTAMP);
				$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
				$package['notify_url'] = $_W['siteroot'] . 'addons/meepo_online/oauth_notify.php';
				$package['trade_type'] = 'JSAPI';
				$package['openid'] = $_W['fans']['from_user'];
				ksort($package, SORT_STRING);
				$string1 = '';
				foreach($package as $key => $v) {
					if (empty($v)) {
						continue;
					}
					$string1 .= "{$key}={$v}&";
				}
				$string1 .= "key={$wechat['signkey']}";
				$package['sign'] = strtoupper(md5($string1));
				$dat = array2xml($package);
				$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
				
				if (is_error($response)) {
					return $response;
				}
				$xml = @isimplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
				
				if (strval($xml->return_code) == 'FAIL') {
					return error(-1, strval($xml->return_msg));
				}
				if (strval($xml->result_code) == 'FAIL') {
					return error(-1, strval($xml->err_code).': '.strval($xml->err_code_des));
				}
				$prepayid = $xml->prepay_id;
				$wOpt['appId'] = $wechat['appid'];
				$wOpt['timeStamp'] = TIMESTAMP;
				$wOpt['nonceStr'] = random(8);
				$wOpt['package'] = 'prepay_id='.$prepayid;
				$wOpt['signType'] = 'MD5';
				ksort($wOpt, SORT_STRING);
				foreach($wOpt as $key => $v) {
					$string .= "{$key}={$v}&";
				}
				$string .= "key={$wechat['signkey']}";
				$wOpt['paySign'] = strtoupper(md5($string));
				return $wOpt;
			}
		}
		public function get_rand($proArr){
				$result = '';
				// 概率数组的总概率精度
				$proSum = array_sum($proArr);
				// 概率数组循环
				foreach ($proArr as $key => $proCur) {
					$randNum = mt_rand(1, $proSum); // 抽取随机数
					if ($randNum <= $proCur) {
						$result = $key; // 得出结果
						break;
					} else {
						$proSum -= $proCur;
					}
				}
				unset($proArr);
				return $result;
		}
		public function emo($content){
		$emo = array("[笑脸]", "[感冒]", "[流泪]", "[发怒]", "[爱慕]", "[吐舌]", "[发呆]", "[可爱]", "[调皮]", "[寒冷]", "[呲牙]", "[闭嘴]", "[害羞]", "[苦闷]", "[难过]", "[流汗]", "[犯困]", "[惊恐]", "[咖啡]", "[炸弹]", "[西瓜]", "[爱心]", "[心碎]");
		//<img src=MODULE_URLtemplate/mobile/default/avote/face/".($key+1).".png"
		foreach($emo as $key=>$val){
				if(strexists($content, $val)){
						$imgurl = '../addons/meepo_online/template/mobile/emo/'.($key+1).'.png';
						$replace = '<img src="'.$imgurl.'" border="0"  width=16px height=16px />';
						$content = str_replace($val,$replace,$content);
				}
		}
		return $content;
		}
		public function ip(){
					load()->func('communication');
					$content = ihttp_request("http://ip.taobao.com/service/getIpInfo.php?ip=".CLIENT_IP);		
					$info = @json_decode($content['content'], true);
					return $info;
		}
		public function cn50r($url){
		global $_W,$_GPC;
		$weid = $_W['uniacid'];
		$settings =  iunserializer(pdo_fetchcolumn("SELECT `settings` FROM ".tablename($this->setting_table)." WHERE weid=:weid",array(':weid' =>$weid)));

		$ak = $settings['sina_key'];
    $url = urlencode($url);
    $api = 'http://50r.cn/urls/add.json?ak='.$ak.'&url='.$url;
    $result = file_get_contents($api); //可以使用curl等代替
    if($result){
        $result = json_decode($result);
        if($result->error){//出错了
            die($result->error);
        }else{
            return $result->url;
        }
    }
		}
}
