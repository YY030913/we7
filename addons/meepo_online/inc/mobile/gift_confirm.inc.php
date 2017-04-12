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
	$data['listid'] = $listid;
	$category_id = intval($_GPC['category_id']);
	if(empty($category_id)){
			die(json_encode(error('-2','直播分类id错误！')));
	}
	$data['categoryid'] = $category_id;
	$gift_number = intval($_GPC['gift_number']);
	if(empty($gift_number)|| $gift_number<0){
			die(json_encode(error('-2','礼物数量必须大于0哦')));
	}
	$data['num'] = $gift_number;
	$type = intval($_GPC['type']);
	if(empty($type)){
		die(json_encode(error('-2','该礼物不存在！')));
	}
	$data['type'] = $type;
	$content = $_GPC['content'];
	if(empty($content)){
			die(json_encode(error('-3','礼物名称错误！')));
	}
	$money = $_GPC['money'];
	if(empty($money)){
		die(json_ecode(error('-1','最少为0.01元哦！')));
	}else{
		if($money<0.01){
				die(json_ecode(error('-1','最少为0.01元哦！')));
		}
	}
	$data['content'] = $content;
	$user =  pdo_fetch("SELECT `nickname`,`avatar`,`id`,`sex`,`cansay` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	if(empty($user)){
		die(json_encode(error('-4','您的资料不存在')));
	}else{
		$data['status'] = 1;
		$data['createtime'] = TIMESTAMP;
		$data['weid'] = $weid;
		$data['openid'] = $openid;
		$data['nickname'] = $user['nickname'];
		$data['avatar'] = $user['avatar'];
		$data['sex'] = $user['sex'];
		$data['money'] = $money;
		pdo_insert($this->pinglun_table,$data);
		pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun + 1 WHERE weid = :weid AND id=:id",array('weid'=>$weid,'id'=>$listid));
		$gifts_person = pdo_fetch("SELECT DISTINCT openid FROM ".tablename($this->pinglun_table)." WHERE listid=:listid AND weid=weid  AND status=:status AND type!='0' AND type!='redapack'",array(':listid'=>$listid,':weid'=>$weid,':status'=>'1'));
		die(json_encode(array('errno'=>'1','nums'=>count($gifts_person))));
	}
}