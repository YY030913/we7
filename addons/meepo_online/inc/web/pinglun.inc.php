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
	message('直播id不存在',$this->createWebUrl('live_manage'),'error');
}
if($op=='list'){
	
	$condition = '';
	if(!empty($_GPC['nickname'])){
		$nickname = $_GPC['nickname'];
		$condition .= " AND nickname LIKE '%{$_GPC['nickname']}%'";
	}
	$status = empty($_GPC['status'])? '1':intval($_GPC['status']);
	if($status==2){
		$status = 0;
	}
	$paras = array(':weid'=>$weid,':listid'=>$listid,':status'=>$status,':type'=>'0');
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$llists = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid AND status=:status AND type=:type $condition  ORDER BY createtime DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",$paras);
	$lists = array();
	if(!empty($llists)){
		foreach($llists as $row){
			$row['cansay'] = pdo_fetchcolumn("SELECT `cansay` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid ",array(':openid'=>$row['openid'],':weid'=>$weid,':listid'=>$listid));
			$lists[] = $row;
		}
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->pinglun_table) . " WHERE weid=:weid
	AND listid=:listid AND status=:status AND type=:type  $condition",$paras);
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='post'){
	$id = intval($_GPC['id']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND id=:id AND listid=:listid",array(':weid'=>$weid,':id'=>$id,':listid'=>$listid));
	if(empty($list)){
		message('此项不存在或是已经被删除',$this->createWebUrl('pinglun',array('listid'=>$listid,'status'=>$status)),'error');
	}else{
		pdo_update($this->pinglun_table,array('status'=>1),array('id'=>$id,'weid'=>$weid));
	}
	message('审核成功',$this->createWebUrl('pinglun',array('listid'=>$listid,'status'=>'2')),'success');
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
	message($message,$this->createWebUrl('pinglun',array('listid'=>$listid,'status'=>'2')),'success');
	
}elseif($op=='reset'){
	$check_pl = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid AND type=:type AND status=:status",array(':weid'=>$weid,':listid'=>$listid,':type'=>'0',':status'=>'1'));
	if($check_gift>0){
		pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun - '{$check_pl}' WHERE weid = 
		:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
	}
	pdo_delete($this->pinglun_table,array('type'=>'0','listid'=>$listid,'weid'=>$weid));
	message('清空成功',$this->createWebUrl('pinglun',array('listid'=>$listid,'status'=>'1')),'success');
	
}elseif($op=='ajax'){
	$id = intval($_GPC['id']);
	$listid = intval($_GPC['listid']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND id=:id AND listid=:listid",array(':weid'=>$weid,':id'=>$id,':listid'=>$listid));
	if(empty($list)){
		die(json_encode(error(-1,'此项不存在或是已经被删除')));
	}else{
		$ajax_type = trim($_GPC['ajax_type']);
		if($ajax_type=='del'){
			if($list['status']=='1'){
					pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun - 1 WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
			}
			pdo_delete($this->pinglun_table,array('id'=>$id,'weid'=>$weid,'listid'=>$listid));
			die(json_encode(error(0,'success')));
		}elseif($ajax_type=='pass'){
			pdo_update($this->pinglun_table,array('status'=>1),array('id'=>$id,'weid'=>$weid,'listid'=>$listid));
			pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun + 1 WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
			die(json_encode(error(0,'success')));
		}elseif($ajax_type=='forbide'){
			$openid = $_GPC['openid'];
			$cansay = pdo_fetchcolumn("SELECT `cansay` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid",array(':openid'=>$openid,':weid'=>$weid,':listid'=>$listid));
			if($cansay=='1'){
				$cansay = 0;
			}else{
				$cansay = 1;
			}
			pdo_update($this->list_user_table,array('cansay'=>$cansay),array('listid'=>$listid,'weid'=>$weid,'openid'=>$openid));
			die(json_encode(error(0,'success')));
		}
	}
	
}
include $this->template('pinglun');