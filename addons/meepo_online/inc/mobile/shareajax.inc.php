<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$openid = $_W['openid'];
if($_W['isajax']){
	$listid = intval($_GPC['listid']);
	$categoryid = intval($_GPC['categoryid']);
	$user =  pdo_fetch("SELECT `nickname`,`avatar`,`id`,`sex` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	if(!empty($user)){
		$data = array();
		$data['createtime'] = time();
		$data['weid'] = $weid;
		$data['openid'] = $openid;
		$data['nickname'] = $user['nickname'];
		$data['avatar'] = $user['avatar'];
		$data['listid'] = $listid;
		$data['categoryid'] = $categoryid;
		pdo_insert($this->share_table,$data);
		die(json_decode(error('0','success')));
	}else{
		die(json_decode(error('-1','error')));
	}
}