<?php
global $_W,$_GPC;
$openid = $_W['openid'];
if(empty($openid)){
	$openid = $_GPC['uc_openid'];
	if(empty($openid)){
		die(json_encode(error('-6','验证失败、请重试')));
	}
}
$weid = $_W['uniacid'];
$data = array();
if($_W['isajax']){
	$listid = intval($_GPC['listid']);
	if(empty($listid)){
			die(json_encode(error('-1','直播id错误！')));
	}
	$code = $_GPC['look_code'];
	if(empty($code)){
			die(json_encode(error('-1','请输入正确的密码！')));
	}
	$look_code = pdo_fetchcolumn("SELECT `look_code` FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
	if(empty($look_code)){
			die(json_encode(error('-1','密码未设置、请检查')));
	}else{
		if($code!=$look_code){
				die(json_encode(error('-1','密码不正确、请重试')));
		}
	}
	$code_record =  pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->online_code_record)." WHERE openid = :openid AND weid=:weid AND listid=:listid AND code=:code",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid,':code'=>$look_code));
	if(!empty($code_record)){
			die(json_encode(error('-10','你已经验证过了')));
	}
	$data['listid'] = $listid;
	$user =  pdo_fetch("SELECT `nickname`,`avatar`,`id`,`sex`,`cansay` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	if(empty($user)){
		die(json_encode(error('-1','您的资料不存在')));
	}else{
		$data['createtime'] = time();
		$data['weid'] = $weid;
		$data['openid'] = $openid;
		$data['code'] = $code;
		pdo_insert($this->online_code_record,$data);
		die(json_encode(error('0','验证成功')));
	}
}