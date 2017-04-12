<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$openid = $_W['openid'];
if(empty($openid)){
	$openid = $_GPC['openid'];
}
if($_W['isajax']){
	if(empty($openid)){
		die(json_encode(error(-1,'错误、请重新进入直播页面')));
	}
	$listid = intval($_GPC['listid']);
	if(empty($listid)){
		 $return = error(-1,'直播id不存在、错误');
	}else{
		 $news_id = intval($_GPC['news_id']);
		 if(empty($news_id)){
			$return = error(-1,'图文消息不存在、请刷新重试');
		 }else{
				$user =  pdo_fetch("SELECT `nickname`,`avatar` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
				$data = array('weid'=>$weid,'listid'=>$listid,'newsid'=>$news_id,'createtime'=>time(),'avatar'=>$user['avatar'],'nickname'=>$user['nickname']);
				pdo_insert($this->live_news_zan,$data);
				$return = error(0,'success');
		 }
	}
	die(json_encode($return));
}