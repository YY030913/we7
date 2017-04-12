<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
$zan = pdo_fetchall("SELECT * FROM ".tablename($this->zan_table)." WHERE openid=:openid AND weid=:weid   ORDER BY createtime DESC",array(':openid'=>$openid,':weid'=>$weid));
include $this->template('my_zan');