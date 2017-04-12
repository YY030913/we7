<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
$categoryid = intval($_GPC['categoryid']);
$listid = intval($_GPC['listid']);
if(empty($listid)){
	message('直播id错误！',$this->createMobileUrl('index'),'error');
}
$list = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
$categoryid = intval($list['categoryid']);

$list_user_id = pdo_fetchcolumn("SELECT `id` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
$fatherid = intval($_GPC['fd']);
if(empty($list_user_id)){
	$new_user = array(
		'openid' =>$openid,
		'weid'=>$weid,
		'createtime'=>time(),
		'avatar'=>$user['avatar'],
		'nickname'=>$user['nickname'],
		'sex'=>intval($user['sex']),
		'categoryid'=>$categoryid,
		'listid'=>$listid,
		'cansay'=>0,
		'father_id'=>$fatherid,
	);
	pdo_insert($this->list_user_table,$new_user);
	$list_user_id = pdo_insertid();
}
include $this->template('detail_thumb');
