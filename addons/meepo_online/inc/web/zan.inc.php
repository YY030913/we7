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
if($op=='list'){
	
	$condition = '';
	if(!empty($_GPC['nickname'])){
		$nickname = $_GPC['nickname'];
		$condition .= " AND nickname LIKE '%{$_GPC['nickname']}%'";
	}
	$paras = array(':weid'=>$weid,':listid'=>$listid);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$llists = pdo_fetchall("SELECT * FROM ".tablename($this->zan_table)." WHERE weid=:weid AND listid=:listid $condition  ORDER BY createtime DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",$paras);
	$lists = array();
	if(!empty($llists)){
		foreach($llists as $row){
			$row['cansay'] = pdo_fetchcolumn("SELECT `cansay` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid",array(':openid'=>$row['openid'],':weid'=>$weid,':listid'=>$listid));
			$lists[] = $row;
		}
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->zan_table) . " WHERE weid=:weid
	AND listid=:listid $condition",$paras);
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='cansay'){
	$cansay = intval($live['cansay']);
	if(!$cansay){
		$cansay = 1;
		$message = '开启禁止评论成功';
	}else{
		$cansay = 0;
		$message = '开启准许评论成功';
	}
	pdo_update($this->list_table,array('cansay'=>$cansay),array('id'=>$listid,'weid'=>$weid));
	message($message,$this->createWebUrl('pinglun',array('listid'=>$listid,'status'=>'2')),'success');
	
}elseif($op=='status'){
	$status = intval($live['status']);
	if(!$status){
		$status = 1;
		$message = '开启审核成功';
	}else{
		$status = 0;
		$message = '关闭审核成功';
	}
	pdo_update($this->list_table,array('status'=>$status),array('id'=>$listid,'weid'=>$weid));
	message($message,$this->createWebUrl('zan',array('listid'=>$listid)),'success');
	
}elseif($op=='ajax'){
	$id = intval($_GPC['id']);
	$listid = intval($_GPC['listid']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->zan_table)." WHERE weid=:weid AND id=:id AND listid=:listid",array(':weid'=>$weid,':id'=>$id,':listid'=>$listid));
	if(empty($list)){
		die(json_encode(error(-1,'此项不存在或是已经被删除')));
	}else{
		$ajax_type = trim($_GPC['ajax_type']);
		if($ajax_type=='del'){
			
			pdo_query("UPDATE ".tablename($this->list_table)." SET zan = zan - 1 WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
			
			pdo_delete($this->zan_table,array('id'=>$id,'weid'=>$weid,'listid'=>$listid));
			die(json_encode(error(0,'success')));
		}
	}
	
}
include $this->template('zan');