<?php
global $_W,$_GPC;
$openid = $_W['openid'];
$weid = $_W['uniacid'];
if($_W['isajax']){
	$listid = intval($_GPC['listid']);
	if(empty($openid) || empty($listid)){
		die(json_encode(error('-1','预约失败、请重试')));
	}else{
		$list = pdo_fetch("SELECT `start_time`,`end_time`,`put_mobile`,`sms_mobile` FROM ".tablename($this->list_table)." WHERE weid=:weid AND   id=:id",array(':weid'=>$weid,':id'=>$listid));
		if(empty($list)){
			die(json_encode(error('-2','预约失败、直播不存在或是已被删除！')));
		}
		if(TIMESTAMP>$list['end_time']){
			die(json_encode(error('-2','预约失败、直播已经结束啦！')));
		}
		if(TIMESTAMP>$list['start_time'] && TIMESTAMP<$list['end_time']){
			die(json_encode(error('-2','预约失败、直播已经开始啦！')));
		}
		$check_yuyue = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->my_live_table)." WHERE openid=:openid AND listid=:listid AND weid=:weid",array(':openid'=>$openid,':listid'=>$listid,':weid'=>$weid));
		if(!empty($check_yuyue)){
			die(json_encode(error('-1','你已经预约过啦！')));
		}
		if($list['put_mobile']=='1'){
			$mobile = $_GPC['mobile'];
			if(!empty($mobile)){
				if($list['sms_mobile']=='1'){
						$mobile_code = $_GPC['sms_code'];
						if(empty($mobile_code)){
							die(json_encode(error('-2','预约失败、手机验证码不正确')));
						}else{
							//pdo_insert($this->dayu_sms_record,$insert);
							$check_real = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->dayu_sms_record)." WHERE weid=:weid AND openid=:openid AND sms_code=:sms_code",array(':weid'=>$weid,':openid'=>$openid,':sms_code'=>$mobile_code));
							if(empty($check_real)){
								die(json_encode(error('-2','预约失败、手机验证码不正确')));
							}
						}
				}
			}else{
				die(json_encode(error('-2','预约失败、手机号码不正确')));
			}
		}
		$data = array();
		$data['listid'] = $listid;
		$data['weid'] = $weid;
		$data['openid'] = $openid;
		$data['mobile'] = $mobile;
		$data['createtime'] = TIMESTAMP;
		pdo_insert($this->my_live_table,$data);
		die(json_encode(error(0,'预约成功')));
	}
}

