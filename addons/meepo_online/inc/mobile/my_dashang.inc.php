<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
$status = empty($_GPC['status'])? 1:intval($_GPC['status']);
if($status==2){
	$status = 0;
}
$dashang = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND status=:status AND type=:type  ORDER BY createtime DESC",array(':openid'=>$openid,':weid'=>$weid,':status'=>$status,':type'=>'redpack'));
include $this->template('my_dashang');