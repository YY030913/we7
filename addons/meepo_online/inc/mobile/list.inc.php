<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
$categoryid = intval($_GPC['categoryid']);
if(empty($categoryid)){
	message('分类错误！',$this->createMobileUrl('index'),'error');
}
$category = pdo_fetch("SELECT `title`,`id` FROM ".tablename($this->category_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$categoryid));
$lists = pdo_fetchall("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND categoryid=:categoryid AND isshow=:isshow",array(':weid'=>$weid,':categoryid'=>$categoryid,':isshow'=>'1'));
include $this->template('list');
