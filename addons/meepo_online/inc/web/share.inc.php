<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$op = empty($_GPC['op'])? 'list':$_GPC['op'];
$listid = intval($_GPC['listid']);
if(empty($listid)){
	message('直播id不存在',$this->createWebUrl('live_manage'),'error');
}
$live = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
if(empty($live)){
	message('直播不存在',$this->createWebUrl('live_manage'),'error');
}
$op = empty($_GPC['op'])? 'list':$_GPC['op'];
if($op=='list'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$weid = $_W['uniacid'];
	$condition = '';
	if(!empty($_GPC['nickname'])){
		$nickname = $_GPC['nickname'];
		$condition .= " AND nickname LIKE '%{$_GPC['nickname']}%'";
	}
	$shares = pdo_fetchall("SELECT * FROM ".tablename($this->share_table)." WHERE weid=:weid  AND listid=:listid $condition ORDER BY createtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':weid'=>$weid,':listid'=>$listid));
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->share_table) . " WHERE weid=:weid		AND listid=:listid $condition", array(':weid'=>$weid,':listid'=>$listid));
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='del'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('此项不存在、或是已经被删除');
	}else{
			pdo_delete($this->share_table,array('listid'=>$listid,'weid'=>$weid,'id'=>$id));
			message('删除成功',referer(),'success');
	}
}
include $this->template('share');