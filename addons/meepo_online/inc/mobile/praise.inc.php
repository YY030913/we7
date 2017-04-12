<?php
global $_W,$_GPC;
$openid = $_W['openid'];
if(empty($openid)){
	$openid = $_GPC['uc_openid'];
	if(empty($openid)){
		die(json_encode(error('-6','点赞失败了！')));
	}
}
$weid = $_W['uniacid'];
$data = array();
if($_W['isajax']){
	$listid = intval($_GPC['listid']);
	if(empty($listid)){
			die(json_encode(error('-1','直播id错误！')));
	}
	$zan_style = pdo_fetchcolumn("SELECT `zan_style` FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
	$zan_record =  pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->zan_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	if($zan_style=='1' && $zan_record>0){
		die(json_encode(error('-5','赞过了、不可以再赞哦！')));
	}
	$data['listid'] = $listid;
	$user =  pdo_fetch("SELECT `nickname`,`avatar`,`id`,`sex`,`cansay` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	if($user['cansay']=='1'){
			die(json_encode(error('-2','你已被禁言')));
	}
	if(empty($user)){
		die(json_encode(error('-3','您的资料不存在')));
	}else{
		$data['createtime'] = time();
		$data['weid'] = $weid;
		$data['openid'] = $openid;
		$data['nickname'] = $user['nickname'];
		$data['avatar'] = $user['avatar'];
		pdo_insert($this->zan_table,$data);
		pdo_query("UPDATE ".tablename($this->list_table)." SET zan = zan + 1 WHERE weid = 
		:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
		$new_zan = intval(pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->zan_table)." WHERE weid=:weid AND listid=:listid",array(':weid'=>$weid,':listid'=>$listid)));
		$news_zan_nums = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_zan)." WHERE weid=:weid AND listid=:listid",array(':weid'=>$weid,':listid'=>$listid)));
		$new_zan = $new_zan +$news_zan_nums;
		$return  = array('errno'=>'1','num'=>$new_zan);
		die(json_encode($return));
	}
}