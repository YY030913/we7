<?php
global $_W,$_GPC;
$openid = $_W['openid'];
$weid = $_W['uniacid'];
$data = array();
if($_W['isajax']){
	$listid = intval($_GPC['listid']);
	$realname = $_GPC['realname'];
	$mobile = $_GPC['mobile'];
	$address = $_GPC['address'];
	if(empty($listid) || empty($realname) || empty($mobile)){
		die(json_encode(error('-1','参数错误！')));
	}
	$user =  pdo_fetch("SELECT `id` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	if(empty($user)){
		die(json_encode(error('-1','您的资料不存在')));
	}
	pdo_update($this->list_user_table,array('realname'=>$realname,'mobile'=>$mobile,'address'=>$address),array('openid'=>$openid,'weid'=>$weid,'listid'=>$listid));
	pdo_update($this->user_table,array('realname'=>$realname,'mobile'=>$mobile,'address'=>$address),array('openid'=>$openid,'weid'=>$weid));
	die(json_encode(error('1','success')));
}