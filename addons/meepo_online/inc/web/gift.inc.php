<?php

global $_W,$_GPC;
$weid = $_W['uniacid'];

load()->func('tpl');
$op = empty($_GPC['op'])? 'list':$_GPC['op'];
$listid = intval($_GPC['listid']);
if(empty($listid)){
	message('直播id不存在',$this->createWebUrl('list_manage'),'error');
}
$zhibo_list = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
if(empty($zhibo_list)){
	message('此直播不存在或是已经被删除',$this->createWebUrl('live_manage'),'error');
}
if($op=='list'){
	$gifts = pdo_fetchall("SELECT * FROM ".tablename($this->gift_table)." WHERE weid=:weid AND listid=:listid ORDER BY displayorder ASC,createtime DESC",array(':weid'=>$weid,':listid'=>$listid));
}elseif($op=='post'){
	$id = intval($_GPC['id']);
	$gift = pdo_fetch("SELECT * FROM ".tablename($this->gift_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	if(empty($gift)){
		$gift = array(
			'displayorder'=>0,
		);
	}
	if (checksubmit('submit')) {
		$data = array();
		$data['listid'] = $listid;
		$data['money'] = $_GPC['money'];
		$data['displayorder'] = intval($_GPC['displayorder']);
		$data['name'] = $_GPC['name'];
		$data['img'] = $_GPC['img'];
		$data['weid'] = $weid;
		if(!empty($id)){
			pdo_update($this->gift_table,$data,array('id'=>$id,'weid'=>$weid));
			message('编辑成功',$this->createWebUrl('gift',array('listid'=>$listid)),'success');
		}else{
			$data['createtime'] = time();
			pdo_insert($this->gift_table,$data);
			message('新增成功',$this->createWebUrl('gift',array('listid'=>$listid)),'success');
		}

	}
}elseif($op=='del'){
	$id = intval($_GPC['id']);
	$gift = pdo_fetch("SELECT * FROM ".tablename($this->gift_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	if(empty($gift)){
		message('此项不存在或是已经被删除',$this->createWebUrl('gift',array('listid'=>$listid)),'error');
	}else{
		$check_gift = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid AND type=:type AND status=:status",array(':weid'=>$weid,':listid'=>$listid,':type'=>$id,':status'=>'1'));
		if($check_gift>0){
			pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun - '{$check_gift}' WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
		}
		pdo_delete($this->pinglun_table,array('weid'=>$weid,'type'=>$id,'listid'=>$listid));
		pdo_delete($this->gift_table,array('id'=>$id,'weid'=>$weid));
	}
	message('删除成功',$this->createWebUrl('gift',array('listid'=>$listid)),'success');
}
include $this->template('gift');