<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$listid = 13;
$ggifts = pdo_fetchall("SELECT * FROM ".tablename($this->gift_table)." WHERE weid=:weid AND listid=:listid   ORDER BY displayorder ASC,createtime DESC",array(':weid'=>$weid,':listid'=>$listid));
	$gifts = array();
	if(!empty($ggifts)){
		foreach($ggifts as $row){
			$row['nums'] = pdo_fetchcolumn("SELECT SUM(num) FROM ".tablename($this->pinglun_table)." WHERE type=:type AND listid=:listid AND weid=:weid AND status=:status",array(':type'=>intval($row['id']),':listid'=>$listid,':weid'=>$weid,':status'=>'1'));
			$gifts[] = $row;
		}
	}
	$gifts_person = count(pdo_fetchall("SELECT DISTINCT openid FROM ".tablename($this->pinglun_table)." WHERE listid=:listid AND weid=:weid  AND status=:status AND type!=:type1 AND type!=:type2",array(':listid'=>$listid,':weid'=>$weid,':status'=>'1',':type1'=>'0',':type2'=>'redpack')));
include $this->template('ceshi');