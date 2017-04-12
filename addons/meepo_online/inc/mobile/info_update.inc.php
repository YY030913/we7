<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
if($_W['ispost']){
	$realname = trim($_GPC['realname']);
	$mobile = trim($_GPC['mobile']);
	$nickname = trim($_GPC['nickname']);
	$address = trim($_GPC['address']);
	$sex = intval($_GPC['sex']);
	pdo_update($this->list_user_table,array('nickname'=>$nickname,'realname'=>$realname,'mobile'=>$mobile,'address'=>$address,'sex'=>$sex),array('openid'=>$openid,'weid'=>$weid));
	pdo_update($this->user_table,array('nickname'=>$nickname,'realname'=>$realname,'mobile'=>$mobile,'address'=>$address,'sex'=>$sex),array('openid'=>$openid,'weid'=>$weid));
	message('保存成功',$this->createMobileUrl('user'),'success');
}
include $this->template('info_update');