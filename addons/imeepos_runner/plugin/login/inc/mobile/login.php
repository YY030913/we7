<?php
global $_W,$_GPC;
checkauth();

if(!empty($_W['member']['uid'])){
	$sql = "SELECT * FROM ".tablename('mc_mapping_fans')." WHERE uniacid = :uniacid AND uid = :uid ";
	$params = array(':uniacid'=>$_W['uniacid'],':uid'=>$_W['member']['uid']);
	$user = pdo_fetch($sql,$params);
	$openid = $user['openid'];
	
	if(!empty($openid)){
		$_W['openid'] = $openid;
	}else{
		$_W['openid'] = random(64);
	}
}

if(!empty($_W['openid'])){
	$url = $this->createMobileUrl('index');
	header("location:$url");
	exit();
}