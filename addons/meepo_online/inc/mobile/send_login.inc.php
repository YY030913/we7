<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
$listid = intval($_GPC['listid']);
if(empty($listid)){
	message('直播不存在');
}
$host = iunserializer(pdo_fetchcolumn("SELECT `settings` FROM ".tablename($this->listmenu_table)." WHERE weid=:weid AND listid=:listid AND isshow=:isshow AND type=:type",array(':weid'=>$weid,':listid'=>$listid,':isshow'=>'1',':type'=>'news')));

$title = pdo_fetchcolumn("SELECT `title` FROM ".tablename($this->list_table)." WHERE weid=:weid AND   id=:id",array(':weid'=>$weid,':id'=>$listid));
include $this->template('send_login');