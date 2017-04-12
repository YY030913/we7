<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
if($_W['isajax']){
		$pass = $_GPC['pass'];
		$listid = intval($_GPC['listid']);
		 setcookie("Meepo".$listid,$pass, time()+3600*24);
		die(json_encode(error(0,'success')));
}