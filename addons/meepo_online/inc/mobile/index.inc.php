<?php
//ini_set("display_errors", "On");
//error_reporting(E_ALL | E_STRICT);
include MODULE_ROOT.'/inc/mobile/__init.php';
$new_categorys = array();
$categorys = pdo_fetchall("SELECT * FROM ".tablename($this->category_table)." WHERE weid=:weid AND isshow=:isshow  ORDER BY displayorder ASC,createtime DESC",array(':weid'=>$weid,':isshow'=>'1'));
if(!empty($categorys) && is_array($categorys)){
	foreach($categorys as $row){
			$row['list'] = pdo_fetchall("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND categoryid=:categoryid AND isshow=:isshow ORDER BY displayorder ASC,createtime DESC LIMIT 7",array(":weid"=>$weid,':categoryid'=>$row['id'],':isshow'=>'1'));
			$new_categorys[] = $row;
	}
}
$advs = pdo_fetchall("SELECT `img`,`url` FROM ".tablename($this->advs_table)." WHERE weid=:weid AND isshow=:isshow  ORDER BY displayorder ASC,createtime DESC",array(':weid'=>$weid,':isshow'=>'1'));
include $this->template('index');
