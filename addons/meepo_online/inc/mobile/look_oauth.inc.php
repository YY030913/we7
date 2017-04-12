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
	$pay_money = pdo_fetchcolumn("SELECT `pay_money` FROM ".tablename($this->list_table)." WHERE weid=:weid AND   id=:id",array(':weid'=>$weid,':id'=>$listid));
	if($pay_money<0.01){
			die(json_ecode(error('-1','金额最少为0.01元哦！')));
	}
	$user =  pdo_fetch("SELECT `nickname`,`avatar`,`id`,`sex`,`cansay` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	if(empty($user)){
		die(json_encode(error('-4','您的资料不存在')));
	}else{
		$data['status'] = 0;
		$data['createtime'] = TIMESTAMP;
		$data['weid'] = $weid;
		$data['openid'] = $openid;
		$data['money'] = $pay_money;
		$ceshi = pdo_insert($this->online_pay_record,$data);
		$pay_id = pdo_insertid();		
		$oauth_account = pdo_fetchcolumn("SELECT `uniacid` FROM " . tablename('account_wechats') . " WHERE acid = :acid ", array(':acid' =>$_W['oauth_account']['acid']));
    $setting = uni_setting($oauth_account, array('payment'));
		if(!is_array($setting['payment']['wechat']) || !$setting['payment']['wechat']['switch']) {
			pdo_delete($this->online_pay_record,array('id'=>$pay_id));
			die(json_encode(error('-6','没有设定支付参数')));
		}
		$params = array(
			'fee' =>$pay_money,
			'user' =>$oauth_openid,
			'title' =>urldecode($_GPC['content']),
			'uniontid'=>random(10,true).$pay_id,
		);
		$sl = base64_encode(json_encode($params));
		$auth = sha1($sl . $oauth_account . $_W['config']['setting']['authkey']);
		$pay_url = "../app/index.php?c=entry&do=oauth_pay_look&m=meepo_online&i=".$oauth_account."&auth={$auth}&ps={$sl}&type=oauth_pay";
		die(json_encode(error('1',$pay_url)));
	}
}
