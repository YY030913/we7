<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
$bests = pdo_fetchall("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND is_best=:is_best AND isshow=:isshow ORDER BY displayorder ASC,createtime DESC",array(":weid"=>$weid,':is_best'=>'1',':isshow'=>'1'));
$best = array();
if(!empty($bests) && is_array($bests)){
	foreach($bests as $row){
		$row['users'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->list_user_table)." WHERE listid=:listid AND weid=:weid",array(':listid'=>$row['id'],':weid'=>$weid));
		$best[] = $row;
	}
	
}
$advs = pdo_fetchall("SELECT `img`,`url` FROM ".tablename($this->advs_table)." WHERE weid=:weid AND isshow=:isshow  ORDER BY displayorder ASC,createtime DESC",array(':weid'=>$weid,':isshow'=>'1'));
include $this->template('best_live');