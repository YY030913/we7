<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$openid = $_W['openid'];
$user =  pdo_fetch("SELECT * FROM ".tablename($this->user_table)." WHERE openid = :openid AND weid=:weid",array(':openid' =>$openid,':weid' =>$weid));
//var_dump($user);
$listid = 10;
if(empty($listid)){
	message('缺少直播id参数');
}
$list = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND   id=:id",array(':weid'=>$weid,':id'=>$listid));
$pinglun_id = 544;
if(!empty($pinglun_id)){
		$sql = 'SELECT * FROM ' . tablename($this->pinglun_table) . ' WHERE `id`=:id';
		$pinglun = pdo_fetch($sql, array(
						':id' =>$pinglun_id 
		));
		//var_dump($pinglun);
}
include $this->template('oauth_pay_success');