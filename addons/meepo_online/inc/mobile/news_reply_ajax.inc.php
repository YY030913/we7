<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
if($_W['isajax']){
	$openid = $_GPC['openid'];
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
				$content = $_GPC['content'];
				$user =  pdo_fetch("SELECT `nickname`,`avatar` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
				if(empty($user)){
					die(json_encode(error(-1,'你的信息不存在或是已经被删除')));
				}
				$data = array('weid'=>$weid,'listid'=>$listid,'newsid'=>$news_id,'content'=>$content,'createtime'=>time(),'avatar'=>$user['avatar'],'nickname'=>$user['nickname']);
				pdo_insert($this->live_news_reply,$data);
				$return = error(0,'success');
		 }
	}
	die(json_encode($return));
}