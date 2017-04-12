<?php
global $_W,$_GPC;
$openid = $_W['openid'];
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
	$type = intval($_GPC['type']);
	if(empty($type)){
		die(json_encode(error('-2','该礼物不存在！')));
	}
	$data['type'] = $type;
	$data['categoryid'] = $category_id;
	$content = $_GPC['content'];
	if(empty($content)){
			die(json_encode(error('-3','礼物名称错误！')));
	}
	$data['content'] = $content;
	$user =  pdo_fetch("SELECT `nickname`,`avatar`,`id`,`sex`,`cansay` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	if(empty($user)){
		die(json_encode(error('-4','您的资料不存在')));
	}else{
		$new_pinglun = $live['pinglun']+1;
		pdo_update($this->list_table,array('pinglun'=>$new_pinglun),array('weid'=>$weid,'id'=>$listid));
		$data['status'] = 1;
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