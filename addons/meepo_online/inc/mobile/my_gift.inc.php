<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
$status = empty($_GPC['status'])? 1:intval($_GPC['status']);
if($status==2){
	$status = 0;
}
$gifts = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND status=:status AND type!=:type1 AND type!=:type2  ORDER BY createtime DESC",array(':openid'=>$openid,':weid'=>$weid,':status'=>$status,':type1'=>'redpack',':type2'=>'0'));
$gift = array();
if(!empty($gifts) && is_array($gifts)){
	foreach($gifts as $row){
			$row['gift_img'] = tomedia(pdo_fetchcolumn("SELECT `img` FROM ".tablename($this->gift_table)." WHERE id=:id AND weid=:weid",array(':id'=>intval($row['type']),':weid'=>$weid)));
			$gift[] = $row;
	}
}
include $this->template('my_gift');