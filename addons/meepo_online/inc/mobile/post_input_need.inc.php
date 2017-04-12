<?php
global $_W,$_GPC;
$openid = $_W['openid'];
if(empty($openid)){
	$openid = $_GPC['uc_openid'];
	if(empty($openid)){
		die(json_encode(error('-6','提交失败了')));
	}
}
$weid = $_W['uniacid'];
$data = array();
if($_W['isajax']){
	$listid = intval($_GPC['listid']);
	if(empty($listid)){
			die(json_encode(error('-1','直播id错误！')));
	}
	
	$data['listid'] = $listid;
	$user =  pdo_fetch("SELECT `id` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	if(empty($user)){
		die(json_encode(error('-3','您的资料不存在')));
	}else{
		$need_input_arr = pdo_fetchall("SELECT * FROM ".tablename($this->need_input_table)." WHERE weid=:weid AND listid=:listid   ORDER BY displayorder ASC,createtime DESC",array(':weid' =>$weid,':listid'=>$listid));
		if(!empty($need_input_arr) && is_array($need_input_arr)){
			foreach($need_input_arr as $row){
					$data[$row['code']] = $_GPC[$row['code']]; 
					if(empty($data[$row['code']])){
						die(json_encode(error('-3',$row['placeholder'])));
					}
			}
		}
		$data = iserializer($data);
		pdo_update($this->list_user_table,array('need_info'=>$data),array('openid'=>$openid,'weid'=>$weid,'listid'=>$listid,'id'=>$user['id']));
		die(json_encode(error('1','提交成功')));
	}
}