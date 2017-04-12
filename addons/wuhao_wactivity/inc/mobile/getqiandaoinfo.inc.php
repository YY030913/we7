<?php
//获取签到数据
//加载视图
global $_W,$_GPC;

$matchid=$_GPC['matchid'];
$data_matches=pdo_fetchall("SELECT * FROM ".tablename('wactivity_matches')." WHERE `uniacid`=:uniacid AND `matchid`=:matchid",array(':uniacid'=>$_W['uniacid'],':matchid'=>$matchid));
$data_groups=pdo_fetchall("SELECT * FROM ".tablename('wactivity_groups')." WHERE `uniacid`=:uniacid",array(':uniacid'=>$_W['uniacid']));
$data_baoming=pdo_fetchall("SELECT * FROM ".tablename('wactivity_baoming')." WHERE `uniacid`=:uniacid AND `matchid`=:matchid AND `realstatus`=:realstatus",array(':uniacid'=>$_W['uniacid'],':matchid'=>$matchid,':realstatus'=>1));
$data_total=array();

$data_matches[0]['qiandaonum']=0;
foreach($data_baoming as $key => $value){
	$data_matches[0]['qiandaonum']++;
	$data_players=pdo_fetch("SELECT * FROM ".tablename('wactivity_players')." WHERE `uniacid`=:uniacid AND `id`=:id",array(':uniacid'=>$_W['uniacid'],':id'=>$value['id']));
	foreach($data_groups as $key_groups => $value_groups){
		if($data_players['groupname'] == $value_groups['groupname']){			
			if(!$data_total[$key_groups]['qiandaonum']){
				$data_total[$key_groups]['qiandaonum']=1;
			}else{
				$data_total[$key_groups]['qiandaonum']+=1;
			}				
			$data_total[$key_groups]['qiandaolist'].=$data_players['name']." ";
			$data_total[$key_groups]['groupname']=$value_groups['groupname'];				
		}
	}
}

if($data_total){	
	include $this->template('getqiandaoinfo');
}else{
	message('尚没有签到数据', $this->createMobileUrl('qiandao', array()), 'error');
}
