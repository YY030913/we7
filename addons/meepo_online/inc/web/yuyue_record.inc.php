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
	/*if(!empty($_GPC['nickname'])){
		$nickname = $_GPC['nickname'];
		$condition .= " AND nickname LIKE '%{$_GPC['nickname']}%'";
	}*/
	$paras = array(':weid'=>$weid,':listid'=>$listid);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$llists = pdo_fetchall("SELECT * FROM ".tablename($this->my_live_table)." WHERE weid=:weid AND listid=:listid $condition  ORDER BY createtime DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",$paras);
	$lists = array();
	if(!empty($llists)){
			foreach($llists as $row){
					 $user = pdo_fetch("SELECT `nickname`,`avatar` FROM ".tablename($this->list_user_table)." WHERE listid=:listid AND openid=:openid",array(':listid'=>$listid,':openid'=>$row['openid']));
					 $row['nickname'] = $user['nickname'];
					 $row['avatar'] = $user['avatar'];
					 $lists[] = $row;
			}
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->my_live_table) . " WHERE weid=:weid
	AND listid=:listid $condition",$paras);
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='delete'){
	if(empty($_GPC['id'])){
		message('此项不存在或是已经被删除',$this->createWebUrl('yuyue_record',array('listid'=>$listid)),'error');
	}else{
		$id = intval($_GPC['id']);
	}
	pdo_delete($this->my_live_table,array('id'=>$id,'listid'=>$listid,'weid'=>$weid));
	message('删除成功',$this->createWebUrl('yuyue_record',array('listid'=>$listid)),'success');
}
include $this->template('yuyue_record');