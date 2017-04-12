<?php
global $_W,$_GPC;
$oauth_openid =  $_GPC['oauth_openid'];
if(empty($oauth_openid)){
	die(json_encode(error('-1','借用openid不存在！')));
}
$topenid = $_GPC['topenid'];
if(empty($topenid)){
	die(json_encode(error('-1','真实openid不存在！')));
}
$openid = $topenid;
$weid = $_W['uniacid'];
$data = array();
if($_W['isajax']){
	$listid = intval($_GPC['listid']);
	if(empty($listid)){
			die(json_encode(error('-1','id错误！')));
	}
	$data['listid'] = $listid;
	$category_id = intval($_GPC['category_id']);
	if(empty($category_id)){
			die(json_encode(error('-2','直播分类id错误！')));
	}
	$data['categoryid'] = $category_id;
	$gift_number = intval($_GPC['gift_number']);
	if(empty($gift_number)|| $gift_number<0){
			die(json_encode(error('-2','礼物数量必须大于0哦')));
	}
	$data['num'] = $gift_number;
	$type = $_GPC['type'];
	if(empty($type)){
		die(json_encode(error('-2','该礼物不存在！')));
	}
	$data['type'] = $type;
	
	$content = $_GPC['content'];
	if(empty($content)){
			die(json_encode(error('-3','礼物名称错误！')));
	}
	$money = $_GPC['money'];
	if(empty($money)){
		die(json_ecode(error('-1','最少为0.01元哦！')));
	}else{
		if($money<0.01){
				die(json_ecode(error('-1','最少为0.01元哦！')));
		}
	}
	$data['content'] = $content;
	$user =  pdo_fetch("SELECT `nickname`,`avatar`,`id`,`sex`,`cansay` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	if(empty($user)){
		die(json_encode(error('-4','您的资料不存在')));
	}else{
		$data['status'] = 0;
		$data['createtime'] = TIMESTAMP;
		$data['weid'] = $weid;
		$data['openid'] = $openid;
		$data['nickname'] = $user['nickname'];
		$data['avatar'] = $user['avatar'];
		$data['sex'] = $user['sex'];
		$data['money'] = $money;
		pdo_insert($this->pinglun_table,$data);
		$pay_id = pdo_insertid();		
		if($type=='redpack'){
			$content = '打赏红包';
		}
		
		$oauth_account = pdo_fetchcolumn("SELECT `uniacid` FROM " . tablename('account_wechats') . " WHERE acid = :acid ", array(':acid' =>$_W['oauth_account']['acid']));
    $setting = uni_setting($oauth_account, array('payment'));
		if(!is_array($setting['payment']['wechat']) || !$setting['payment']['wechat']['switch']) {
			pdo_delete($this->pinglun_table,array('id'=>$pay_id));
			die(json_encode(error('-6','没有设定支付参数')));
		}
		$params = array(
			'fee' =>$money,
			'user' =>$oauth_openid,
			'title' =>urldecode($content),
			'uniontid'=>random(10,true).$pay_id,
		);
		$sl = base64_encode(json_encode($params));
		$auth = sha1($sl . $oauth_account . $_W['config']['setting']['authkey']);
		$pay_url = "../app/index.php?c=entry&do=oauth_pay&m=meepo_online&i=".$oauth_account."&auth={$auth}&ps={$sl}&type=oauth_pay";
		die(json_encode(error('1',$pay_url)));
	}
}
