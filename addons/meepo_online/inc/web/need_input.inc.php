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
	$lists = pdo_fetchall("SELECT * FROM ".tablename($this->need_input_table)." WHERE weid=:weid AND listid=:listid ORDER BY displayorder ASC,createtime DESC",array(':weid'=>$weid,':listid'=>$listid));
}elseif($op=='post'){
	$id = intval($_GPC['id']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->need_input_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	if(empty($list)){
		$list = array(
			'displayorder'=>0,
		);
	}
	if (checksubmit('submit')) {
		$data = array();
		$data['listid'] = $listid;
		$data['displayorder'] = intval($_GPC['displayorder']);
		$data['name'] = $_GPC['name'];
		$data['code'] = $_GPC['code'];
		$data['placeholder'] = $_GPC['placeholder'];
		$data['weid'] = $weid;
		if(!empty($id)){
			pdo_update($this->need_input_table,$data,array('id'=>$id,'weid'=>$weid));
			message('编辑成功',$this->createWebUrl('need_input',array('listid'=>$listid)),'success');
		}else{
			$data['createtime'] = time();
			pdo_insert($this->need_input_table,$data);
			message('新增成功',$this->createWebUrl('need_input',array('listid'=>$listid)),'success');
		}

	}
}elseif($op=='del'){
	$id = intval($_GPC['id']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->need_input_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	if(empty($list)){
		message('此项不存在或是已经被删除',$this->createWebUrl('need_input',array('listid'=>$listid)),'error');
	}else{
		$check_need_input = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid AND type=:type AND status=:status",array(':weid'=>$weid,':listid'=>$listid,':type'=>$id,':status'=>'1'));
		if($check_need_input>0){
			pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun - '{$check_need_input}' WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
		}
		pdo_delete($this->pinglun_table,array('weid'=>$weid,'type'=>$id,'listid'=>$listid));
		pdo_delete($this->need_input_table,array('id'=>$id,'weid'=>$weid));
	}
	message('删除成功',$this->createWebUrl('need_input',array('listid'=>$listid)),'success');
}
include $this->template('need_input');