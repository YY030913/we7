<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
$pinglun = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND status=:status AND type=:type ORDER BY createtime DESC",array(':openid'=>$openid,':weid'=>$weid,':status'=>'1',':type'=>'0'));
include $this->template('my_pinglun');