<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$op = empty($_GPC['op'])? 'list':$_GPC['op'];
if($op=='list'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$categorys = pdo_fetchall("SELECT * FROM ".tablename($this->category_table)." WHERE weid=:weid ORDER BY displayorder ASC,createtime DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':weid'=>$weid));
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->category_table) . " WHERE weid=:weid", array(':weid'=>$weid));
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='post'){
	load()->func('tpl');
	$id = intval($_GPC['id']);
	$category = pdo_fetch("SELECT * FROM ".tablename($this->category_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	if(empty($category)){
		$category = array(
			'isshow'=>1,
		);
	}
	if (checksubmit('submit')) {
			
		$data = array();
		$data['weid'] = $weid;
		$data['title'] = $_GPC['title'];
		$data['isshow'] = intval($_GPC['isshow']);
		$data['no_img'] = $_GPC['no_img'];
		$data['displayorder'] = intval($_GPC['displayorder']);
		if(!empty($id)){
			pdo_update($this->category_table,$data,array('id'=>$id,'weid'=>$weid));
			message('编辑成功',$this->createWebUrl('category_manage'),'success');
		}else{
			$data['createtime'] = time();
			pdo_insert($this->category_table,$data);
			message('新增成功',$this->createWebUrl('category_manage'),'success');
		}
	}
}elseif($op=='del'){
	$id = intval($_GPC['id']);
	$category = pdo_fetch("SELECT * FROM ".tablename($this->category_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	if(empty($category)){
		message('此项不存在或是已经被删除',referer());
	}else{
		$live_lists = pdo_fetchall("SELECT `id` FROM ".tablename($this->list_table)." WHERE weid=:weid AND categoryid=:categoryid",array(':weid'=>$weid,':categoryid'=>$id));
		if(!empty($live_lists) && is_array($live_lists)){
			foreach($live_lists as $row){
				pdo_delete($this->pinglun_table,array('listid'=>$row['id'],'weid'=>$weid));
				pdo_delete($this->zan_table,array('listid'=>$row['id'],'weid'=>$weid));
				pdo_delete($this->share_table,array('listid'=>$row['id'],'weid'=>$weid));
				pdo_delete($this->list_user_table,array('listid'=>$row['id'],'weid'=>$weid));
				pdo_delete($this->listmenu_table,array('listid'=>$row['id'],'weid'=>$weid));
				pdo_delete($this->gift_table,array('listid'=>$row['id'],'weid'=>$weid));
				pdo_delete($this->shake_record_table,array('listid'=>$row['id'],'weid'=>$weid));
				pdo_delete($this->shake_award_table,array('listid'=>$row['id'],'weid'=>$weid));
				pdo_delete($this->list_table,array('id'=>$row['id'],'weid'=>$weid));
			}
		}
		pdo_delete($this->category_table,array('id'=>$id,'weid'=>$weid));
	}
	message('删除成功',referer());
}
include $this->template('category_manage');