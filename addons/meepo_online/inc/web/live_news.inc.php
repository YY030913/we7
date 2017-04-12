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
	if(!empty($_GPC['content'])){
			$condition .= " AND content LIKE '%{$_GPC['content']}%'";
	}
	$llists = pdo_fetchall("SELECT * FROM ".tablename($this->live_news_table)." WHERE weid=:weid  AND listid=:listid  $condition ORDER BY createtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':weid'=>$weid,':listid'=>$listid));
	$lists = array();
	if(is_array($llists) && !empty($llists)){
			foreach($llists as $row){
				$row['pl'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_reply)." WHERE weid=:weid AND listid=:listid AND newsid=:newsid",array(':weid'=>$weid,':listid'=>$listid,':newsid'=>$row['id']));
				$row['zan'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_zan)." WHERE weid=:weid AND listid=:listid AND newsid=:newsid",array(':weid'=>$weid,':listid'=>$listid,':newsid'=>$row['id']));
				$lists[] = $row;
			}
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->live_news_table) . " WHERE weid=:weid		AND listid=:listid $condition", array(':weid'=>$weid,':listid'=>$listid));
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='post'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('此记录不存在、或是已经被删除');
	}
	$list = pdo_fetch("SELECT * FROM ".tablename($this->live_news_table)." WHERE weid=:weid  AND listid=:listid AND id=:id",array(':weid'=>$weid,':listid'=>$listid,':id'=>$id));
	if(checksubmit('submit')){
		$post_data = array('content'=>$_GPC['content']);
		if(!empty($_GPC['img_urls'])){
			$imgs = iserializer($_GPC['img_urls']);	
		}else{
			$imgs = 'no_imgs';
		}
		$post_data['imgs'] = $imgs;
		pdo_update($this->live_news_table,$post_data,array('id'=>$id,'listid'=>$listid));
		message('保存成功',referer(),'success');
	}
}elseif($op=='delete'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('此记录不存在、或是已经被删除');
	}else{
			pdo_delete($this->live_news_table,array('weid'=>$weid,'listid'=>$listid,'id'=>$id));
			pdo_delete($this->live_news_reply,array('weid'=>$weid,'listid'=>$listid,'newsid'=>$id));
			pdo_delete($this->live_news_zan,array('weid'=>$weid,'listid'=>$listid,'newsid'=>$id));
			message('删除成功',referer(),'success');
	}
}elseif($op=='reset_pl'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('此记录不存在、或是已经被删除');
	}else{
			pdo_delete($this->live_news_reply,array('weid'=>$weid,'listid'=>$listid,'newsid'=>$id));
			message('清空评论成功',referer(),'success');
	}
}elseif($op=='reset_zan'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('此记录不存在、或是已经被删除');
	}else{
			pdo_delete($this->live_news_zan,array('weid'=>$weid,'listid'=>$listid,'newsid'=>$id));
			message('清空评论成功',referer(),'success');
	}
}
if(checksubmit('del_some')){
		if(empty($_GPC['select'])){
					message("请先选择删除项",referer(),'error');
		}
		foreach($_GPC['select'] as $val){
				pdo_delete($this->live_news_table,array('weid'=>$weid,'listid'=>$listid,'id'=>$val));
				pdo_delete($this->live_news_reply,array('weid'=>$weid,'listid'=>$listid,'newsid'=>$val));
				pdo_delete($this->live_news_zan,array('weid'=>$weid,'listid'=>$listid,'newsid'=>$val));
		}
		message('删除成功',referer(),'success');
}

include $this->template('live_news');