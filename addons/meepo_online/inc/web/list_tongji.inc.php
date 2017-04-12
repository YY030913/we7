<?php

global $_W,$_GPC;
$weid = $_W['uniacid'];

load()->func('tpl');
$op = empty($_GPC['op'])? 'list':$_GPC['op'];
$listid = intval($_GPC['listid']);
/*$data =  pdo_fetchall("SELECT * FROM ".tablename($this->list_user_table)." WHERE  listid = :listid AND weid=:weid",array(':listid'=>$listid,':weid'=>$weid));
var_dump($data);
die;*/
if(empty($listid)){
	message('直播id不存在',$this->createWebUrl('list_manage'),'error');
}
$zhibo_list = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
if(empty($zhibo_list)){
	message('此直播不存在或是已经被删除',$this->createWebUrl('live_manage'),'error');
}
$starttime = $_GPC['datelimit']['start'] ? strtotime($_GPC['datelimit']['start']) : strtotime('-7day');
$endtime = $_GPC['datelimit']['end'] ? strtotime($_GPC['datelimit']['end']) : strtotime(date('Ymd'));
$yesterday = date('Ymd', strtotime('-1 days'));
$today = date('Ymd');
$type = intval($_GPC['type']) ? intval($_GPC['type']) : 1;
$today_shortime  = mktime(0, 0, 0, date('m'), date('d'), date('Y'));//今天凌晨
$yesday_shortime = $today_shortime - 86400;//昨天凌晨
//$yes_yesday_shortime = $yesday_shortime - 86400;//前天凌晨
$yes_new_person = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->list_user_table)." WHERE createtime >= :start_time AND createtime <= :end_time AND listid = :listid AND weid=:weid",array(':start_time'=>$yesday_shortime,':end_time'=>$today_shortime,':listid'=>$listid,':weid'=>$weid));
$yes_all_person = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->list_user_table)." WHERE    createtime <= :createtime AND listid = :listid AND weid=:weid",array(':createtime'=>$today_shortime,':listid'=>$listid,':weid'=>$weid));
$today_new_person = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->list_user_table)." WHERE createtime >= :createtime  AND listid = :listid AND weid=:weid",array(':createtime'=>$today_shortime,':listid'=>$listid,':weid'=>$weid));
$today_all_person = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->list_user_table)." WHERE    createtime <= :createtime AND listid = :listid AND weid=:weid",array(':createtime'=>time(),':listid'=>$listid,':weid'=>$weid));
if($_W['isajax']) {
	$days = array();
	$datasets = array();
	$starttime = $_GPC['starttime'] ? date('Ymd', $_GPC['starttime']) : date('Ymd', strtotime('-7day'));
	$endtime = $_GPC['endtime'] ? date('Ymd', $_GPC['endtime']) : date('Ymd');
	$starttime = $starttime == $endtime ? date('Ymd', strtotime('-1 day', strtotime($starttime))): $starttime;
	
	for ($i = strtotime($starttime); $i <= strtotime($endtime); $i+=86400) {
		$yes_day = $i-86400;
		$day = date('Ymd', $i);
		$shuju['label'][] = date('m-d', strtotime($day));
		$shuju['datasets']['new'][] = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->list_user_table)." WHERE createtime >= :start_time AND createtime <= :end_time AND listid = :listid AND weid=:weid",array(':start_time'=>$yes_day,':end_time'=>$i,':listid'=>$listid,':weid'=>$weid));
		$shuju['datasets']['cumulate'][] =  pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->list_user_table)." WHERE createtime <=:createtime  AND listid = :listid AND weid=:weid",array(':createtime'=>$i,':listid'=>$listid,':weid'=>$weid));
	}
	exit(json_encode($shuju));
}

$scroll = intval($_GPC['scroll']);
$yesterday_stat = pdo_get('stat_fans', array('date' => $yesterday, 'uniacid' => $_W['uniacid']));
$today_stat = pdo_get('stat_fans', array('date' => date('Ymd'), 'uniacid' => $_W['uniacid']));
$today_stat['cumulate'] = intval($yesterday_stat['cumulate']) + intval($today_stat['new']) - intval($today_stat['cancel']);
if($today_stat['cumulate'] < 0) {
	$today_stat['cumulate'] = 0;
}
include $this->template('list_tongji');