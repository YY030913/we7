<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$sms_config = pdo_fetch("SELECT * FROM ".tablename($this->dayu_table)." WHERE weid=:weid",array(':weid'=>$weid));
if($_W['ispost']){
	$data = array();
	$data['weid'] = $weid;
	$data['appkey'] = $_GPC['appkey'];
	$data['appsecret'] = $_GPC['appsecret'];
	$data['sms_tpl_id'] = $_GPC['sms_tpl_id'];
  $data['sms_signname'] = $_GPC['sms_signname'];
	$data['sms_success_tpl_id'] = $_GPC['sms_success_tpl_id'];
	if(empty($sms_config)){
		pdo_insert($this->dayu_table,$data);
	}else{
		pdo_update($this->dayu_table,$data,array('weid'=>$weid));
	}
	message('保存成功',referer,'success');
}
include $this->template('yuyue_sms');