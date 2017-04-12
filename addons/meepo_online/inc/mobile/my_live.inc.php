<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
$status = 1;
$lists = array();
$my_live = pdo_fetchall("SELECT `listid` FROM ".tablename($this->my_live_table)." WHERE openid=:openid AND weid=:weid ORDER BY createtime DESC",array(':openid'=>$openid,':weid'=>$weid));
if(!empty($my_live)){
	foreach($my_live as $val){
		$lists[] = pdo_fetch("SELECT `id`,`title`,`content`,`img` FROM ".tablename($this->list_table)." WHERE id=:id",array(':id'=>$val['listid']));
	}
}
include $this->template('my_live');
