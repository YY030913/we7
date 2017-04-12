<?php
global $_W,$_GPC;
if(checksubmit('submit')){
	$data['uniacid']=$_W['uniacid'];
	$data['groupid']=$_GPC['groupid'];
	$data['groupname']=$_GPC['groupname'];
	$data['groupphone']=$_GPC['groupphone'];
	$data['groupmaster']=$_GPC['groupmaster'];	
	$data['ticketsnum']=$_GPC['ticketsnum'];
	$data['baomingnum']=$_GPC['baomingnum'];	
	$data['create_time']=date('y-m-d h:i:s',time());
	
	
	$result=pdo_update('wactivity_groups', $data, array('groupid' => $data['groupid'],'uniacid'=>$data['uniacid']));
	if($result){
		message('更新群组成功',$this->createWebUrl('listallgroups',array()),'success');
	}else{
		message('更新群组失败',$this->createWebUrl('listallgroups',array()),'error');
	}
}else{
	$groups=pdo_fetch("SELECT * FROM ".tablename('wactivity_groups')." WHERE `uniacid`=:uniacid AND `groupid`=:groupid",array(':uniacid'=>$_W['uniacid'],':groupid'=>$_GPC['groupid']));

	include $this->template('editgroups');
}
