<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$op = empty($_GPC['op'])? 'list':$_GPC['op'];
if($op=='list'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$categorys = pdo_fetchall("SELECT * FROM ".tablename($this->advs_table)." WHERE weid=:weid  ORDER BY displayorder ASC,createtime DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':weid'=>$weid));
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->advs_table) . " WHERE weid=:weid", array(':weid'=>$weid));
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='post'){
	load()->func('tpl');
	$id = intval($_GPC['id']);
	$adv = pdo_fetch("SELECT * FROM ".tablename($this->advs_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	if(empty($adv)){
		$adv = array(
			'isshow'=>1,
		);
	}
	if (checksubmit('submit')) {
			
		$data = array();
		$data['weid'] = $weid;
		$data['title'] = $_GPC['title'];
		$data['isshow'] = intval($_GPC['isshow']);
		$data['img'] = $_GPC['img'];
		$data['url'] = $_GPC['url'];
		$data['displayorder'] = intval($_GPC['displayorder']);
		if(!empty($id)){
			pdo_update($this->advs_table,$data,array('id'=>$id,'weid'=>$weid));
			message('编辑成功',$this->createWebUrl('advs_manage'),'success');
		}else{
			$data['createtime'] = time();
			pdo_insert($this->advs_table,$data);
			message('新增成功',$this->createWebUrl('advs_manage'),'success');
		}
	}
}elseif($op=='del'){
	$id = intval($_GPC['id']);
	$category = pdo_fetch("SELECT * FROM ".tablename($this->advs_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	if(empty($category)){
		message('此项不存在或是已经被删除',referer());
	}else{
		pdo_delete($this->advs_table,array('id'=>$id,'weid'=>$weid));
	}
	message('删除成功',referer());
}
include $this->template('advs_manage');