<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$openid = $_GPC['topenid'];
/*if($openid=='fromUser'){
	$openid = $ip = CLIENT_IP;
}*/
$listid = intval($_GPC['listid']);
if(empty($openid) || empty($listid)){
	message('参数错误！');
}
$list = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND   id=:id",array(':weid'=>$weid,':id'=>$listid));
$categoryid = intval($list['categoryid']);
if(empty($list)){
	message('直播不存在或是已经被删除！',$this->createMobileUrl('index'),'error');
}
if($list['gift_show']=='1'){
	$ggifts = pdo_fetchall("SELECT * FROM ".tablename($this->gift_table)." WHERE weid=:weid AND listid=:listid   ORDER BY displayorder ASC,createtime DESC",array(':weid'=>$weid,':listid'=>$listid));
	$gifts = array();
	if(!empty($ggifts)){
		foreach($ggifts as $row){
			$row['nums'] = pdo_fetchcolumn("SELECT SUM(num) FROM ".tablename($this->pinglun_table)." WHERE type=:type AND listid=:listid AND weid=:weid AND status=:status",array(':type'=>intval($row['id']),':listid'=>$listid,':weid'=>$weid,':status'=>'1'));
			$gifts[] = $row;
		}
	}
	$gifts_person = count(pdo_fetchall("SELECT DISTINCT openid FROM ".tablename($this->pinglun_table)." WHERE listid=:listid AND weid=:weid  AND status=:status AND type!=:type1 AND type!=:type2",array(':listid'=>$listid,':weid'=>$weid,':status'=>'1',':type1'=>'0',':type2'=>'redpack')));
}
$user = pdo_fetch("SELECT * FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
//var_dump($user);
//die;
if(empty($user)){
	message('你的信息不存在或是已经被删除！');
}
$oauth_account = pdo_fetchcolumn("SELECT `uniacid` FROM " . tablename('account_wechats') . " WHERE acid = :acid ", array(':acid' =>$_W['oauth_account']['acid']));
$wechat_pay = uni_setting($oauth_account, array('payment'));
if(!$wechat_pay['payment']['wechat']['switch'] || empty($wechat_pay['payment']['wechat']['mchid'])){
	message('打赏或者送礼需要借用具备支付权限的认证服务号！');
}
load()->model('mc');
$oauth_info = mc_oauth_userinfo();
if (!is_error($oauth_info) && !empty($oauth_info) && is_array($oauth_info)) {
		$oauth_openid = $oauth_info['openid'];
		pdo_update($this->list_user_table,array('oauth_openid'=>$oauth_openid),array('id'=>$user['id'],'listid'=>$listid));
		$user['oauth_openid'] = $oauth_openid;
}else{
		message("借用oauth失败");
}
include $this->template('oauth_gift');