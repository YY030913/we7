<?php
global $_W,$_GPC;
$openid = $_W['openid'];
if(empty($openid)){
	$openid = $_GPC['uc_openid'];
	if(empty($openid)){
		die(json_encode(error('-8','评论失败了！')));
	}
}
$weid = $_W['uniacid'];
$data = array();
if($_W['isajax']){
	
	$listid = intval($_GPC['listid']);
	if(empty($listid)){
			die(json_encode(error('-1','直播id错误！')));
	}
	$live = pdo_fetch("SELECT `cansay`,`status`,`pinglun` FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
	if($live['cansay']=='1'){
			die(json_encode(error('-7','主播已开启禁言')));
	}
	
	$data['listid'] = $listid;
	$category_id = intval($_GPC['category_id']);
	if(empty($category_id)){
			die(json_encode(error('-2','直播分类id错误！')));
	}
	$data['categoryid'] = $category_id;
	$content = $_GPC['content'];
	if(empty($content)){
			die(json_encode(error('-3','请先输入评论内容！')));
	}
	$data['content'] = $content;
	$user =  pdo_fetch("SELECT `nickname`,`avatar`,`id`,`sex`,`cansay` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	if($user['cansay']=='1'){
			die(json_encode(error('-6','你已被禁言')));
	}
	if(empty($user)){
		die(json_encode(error('-4','您的资料不存在')));
	}else{
		
		if($live['status']=='0'){
				pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun + 1 WHERE weid = 
		:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
				$data['status'] = 1;
		}else{
				$data['status'] = 0;
		}
		$data['createtime'] = time();
		$data['weid'] = $weid;
		$data['openid'] = $openid;
		$data['nickname'] = $user['nickname'];
		$data['avatar'] = $user['avatar'];
		$data['sex'] = $user['sex'];
		$new_id = pdo_insert($this->pinglun_table,$data);
		die(json_encode(array('errno'=>'1','commnum'=>$new_id)));
		
		
	}
}