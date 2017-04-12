<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
$tem_yyy = pdo_fetchall("SELECT * FROM ".tablename($this->shake_record_table)." WHERE openid=:openid AND weid=:weid   ORDER BY createtime DESC",array(':openid'=>$openid,':weid'=>$weid));
$yyy = array();
if(!empty($tem_yyy) && is_array($tem_yyy)){
	foreach($tem_yyy as $row){
		if($row['award_id']!='0'){
			$award_info = pdo_fetch("SELECT `name`,`img` FROM ".tablename($this->shake_award_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$row['award_id']));
			$row['award_img'] = tomedia($award_info['img']);
			$row['award_name'] = $award_info['name'];
		}
		$yyy[] = $row;
	}
}
include $this->template('my_yyy');