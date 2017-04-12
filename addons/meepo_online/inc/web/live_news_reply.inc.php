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
$newsid = intval($_GPC['newsid']);
if(empty($newsid)){
	message('消息id不存在',$this->createWebUrl('live_news'),'error');
}

$op = empty($_GPC['op'])? 'list':$_GPC['op'];
if($op=='list'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$weid = $_W['uniacid'];
	
	$condition = '';
	if(!empty($_GPC['content'])){
			$condition .= " AND content LIKE '%{$_GPC['content']}%'";
	}
	$lists = pdo_fetchall("SELECT * FROM ".tablename($this->live_news_reply)." WHERE weid=:weid  AND listid=:listid  AND newsid=:newsid $condition ORDER BY createtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':weid'=>$weid,':listid'=>$listid,':newsid'=>$newsid));
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->live_news_reply) . " WHERE weid=:weid		AND listid=:listid   AND newsid=:newsid $condition", array(':weid'=>$weid,':listid'=>$listid,':newsid'=>$newsid));
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='delete'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('此记录不存在、或是已经被删除');
	}else{
			pdo_delete($this->live_news_reply,array('weid'=>$weid,'listid'=>$listid,'id'=>$id));
			message('删除成功',referer(),'success');
	}
}elseif($op=='reset_pl'){
	
			pdo_delete($this->live_news_reply,array('weid'=>$weid,'listid'=>$listid,'newsid'=>$newsid));
			message('清空评论成功',referer(),'success');
}
if(checksubmit('del_some')){
		if(empty($_GPC['select'])){
					message("请先选择删除项",referer(),'error');
		}
		foreach($_GPC['select'] as $val){
				pdo_delete($this->live_news_reply,array('weid'=>$weid,'listid'=>$listid,'id'=>$val));
		}
		message('删除成功',$this->createWebUrl('live_news_reply',array('listid'=>$listid,'newsid'=>$newsid)),'success');
}

include $this->template('live_news_reply');