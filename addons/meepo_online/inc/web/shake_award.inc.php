<?php
//ini_set("display_errors", "On");
//error_reporting(E_ALL | E_STRICT);
global $_W,$_GPC;
$weid = $_W['uniacid'];
$op = empty($_GPC['op'])? 'list':$_GPC['op'];
$listid = intval($_GPC['listid']);
if(empty($listid)){
	message('直播id不存在',$this->createWebUrl('live_manage'),'error');
}
$live = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
if(empty($live)){
	message('直播id不存在',$this->createWebUrl('live_manage'),'error');
}
load()->func('tpl');
if($op=='list'){
	$paras = array(':weid'=>$weid,':listid'=>$listid);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$lists = pdo_fetchall("SELECT * FROM ".tablename($this->shake_award_table)." WHERE weid=:weid AND listid=:listid ORDER BY createtime DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",$paras);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->shake_award_table) . " WHERE weid=:weid
	AND listid=:listid",$paras);
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='post'){
	$id = intval($_GPC['id']);
	if(!empty($id)){
	$item = pdo_fetch("SELECT * FROM ".tablename($this->shake_award_table)." WHERE weid=:weid AND listid=:listid AND id=:id",array(':weid'=>$weid,':listid'=>$listid,':id'=>$id));
	}else{
		$item['type'] = 0;
		$item['get_way'] = 0;
	}
	if(checksubmit('submit')){
		$insert = array();
		$insert['weid'] = $weid;
		$insert['listid'] = $listid;
		$insert['img'] = $_GPC['img'];
		$insert['get_url'] = $_GPC['get_url'];
		$insert['num'] = intval($_GPC['num']);
		$insert['name'] = $_GPC['name'];
		$insert['gailv'] = intval($_GPC['gailv']);
		$insert['type'] = intval($_GPC['type']);
		$insert['get_way'] = 0;
		$total_gailv = pdo_fetchcolumn("SELECT SUM(gailv) FROM ".tablename($this->shake_award_table)." WHERE listid=:listid AND weid=:weid AND id!=:id",array(':listid'=>$listid,':weid'=>$weid,':id'=>$id));
		$total_gailv = $total_gailv + $insert['gailv'];
		if($total_gailv>100){
			message('总概率之和不能超过100%、请重新设置概率');
		}
		if(empty($id)){
			$insert['createtime']  = time();
			pdo_insert($this->shake_award_table,$insert);
			message('新增奖品成功',$this->createWebUrl('shake_award',array('listid'=>$listid)),'success');
		}else{
			pdo_update($this->shake_award_table,$insert,array('id'=>$id,'weid'=>$weid));
			message('编辑奖品成功',$this->createWebUrl('shake_award',array('listid'=>$listid)),'success');
		}
	}
}elseif($op=='del'){
	$id = intval($_GPC['id']);
	pdo_delete($this->shake_record_table,array('award_id'=>$id,'listid'=>$listid));
	pdo_delete($this->shake_award_table,array('id'=>$id,'listid'=>$listid));
	message('删除成功',$this->createWebUrl('shake_award',array('listid'=>$listid)),'success');
}
include $this->template('shake_award');