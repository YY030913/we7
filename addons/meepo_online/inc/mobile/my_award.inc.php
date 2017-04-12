<?php
//ini_set("display_errors", "On");
//error_reporting(E_ALL | E_STRICT);
include MODULE_ROOT.'/inc/mobile/__init.php';
$tem_award = pdo_fetchall("SELECT * FROM ".tablename($this->shake_record_table)." WHERE openid=:openid AND weid=:weid  AND award_id !=:award_id ORDER BY createtime DESC",array(':openid'=>$openid,':weid'=>$weid,':award_id'=>'0'));
$award = array();
if(!empty($tem_award) && is_array($tem_award)){
	foreach($tem_award as $row){
		if($row['award_id']!='0'){
			$award_info = pdo_fetch("SELECT `name`,`img` FROM ".tablename($this->shake_award_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$row['award_id']));
			$row['award_img'] = tomedia($award_info['img']);
			$row['award_name'] = $award_info['name'];
		}
		$award[] = $row;
	}
}
include $this->template('my_award');