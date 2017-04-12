<?php

include MODULE_ROOT.'/inc/mobile/__init.php';
$categoryid = intval($_GPC['categoryid']);
if(empty($categoryid)){
	message('分类错误！',$this->createMobileUrl('index'),'error');
}
$category = pdo_fetch("SELECT `title`,`id` FROM ".tablename($this->category_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$categoryid));
$listid = intval($_GPC['listid']);
if(empty($listid)){
	message('直播id错误！',$this->createMobileUrl('index'),'error');
}

$list = pdo_fetchcolumn("SELECT `id` FROM ".tablename($this->list_table)." WHERE weid=:weid AND categoryid=:categoryid AND  id=:id",array(':weid'=>$weid,':categoryid'=>$categoryid,':id'=>$listid));
if(empty($list)){
	message('直播不存在或是已经被删除！',$this->createMobileUrl('index'),'error');
}
$gift_id =$_GPC['gift_id'];
$gift = pdo_fetch("SELECT * FROM ".tablename($this->gift_table)." WHERE weid=:weid AND listid=:listid   AND id=:id",array(':weid'=>$weid,':listid'=>$listid,':id'=>$gift_id));
if(empty($gift_id) || empty($gift)){
	message('礼物不存在或是已经被删除！',$this->createMobileUrl('index'),'error');
}
$pindex = 1;
$psize = 10;
$gift_records = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE listid=:listid AND weid=:weid  AND status=:status AND  type = :type ORDER BY createtime DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':listid'=>$listid,':weid'=>$weid,':status'=>'1',':type'=>$gift_id));
$send_gift_persons = pdo_fetchall("SELECT distinct openid FROM ".tablename($this->pinglun_table)." WHERE listid=:listid AND weid=:weid  AND status=:status AND type=:type",array(':listid'=>$listid,':weid'=>$weid,':status'=>'1',':type'=>$gift_id));
$send_gift_persons = count($send_gift_persons);
//die;
$total_num = pdo_fetchcolumn("SELECT SUM(num) FROM ".tablename($this->pinglun_table)." WHERE listid=:listid AND weid=:weid  AND status=:status AND  type = :type",array(':listid'=>$listid,':weid'=>$weid,':status'=>'1',':type'=>$gift_id));
include $this->template('dashang_detail');