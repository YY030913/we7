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
	$pay_money = pdo_fetchcolumn("SELECT `pay_money` FROM ".tablename($this->list_table)." WHERE weid=:weid AND   id=:id",array(':weid'=>$weid,':id'=>$listid));
	if($pay_money<0.01){
			die(json_ecode(error('-1','金额最少为0.01元哦！')));
	}
	$pay_record =  pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->online_pay_record)." WHERE openid = :openid AND weid=:weid AND listid=:listid AND status=:status",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid,':status'=>'1'));
	if(!empty($pay_record)){
			die(json_encode(error('-10','你已经支付过了')));
	}
		$data['status'] = 0;
		$data['createtime'] = TIMESTAMP;
		$data['weid'] = $weid;
		$data['openid'] = $openid;
		$data['money'] = $pay_money;
		pdo_insert($this->online_pay_record,$data);
		$pay_id = pdo_insertid();		
		$params = array(
			'fee' =>$pay_money,
			'user' =>$_W['openid'],
			'title' =>urldecode('付费观看直播'),
			'uniontid'=>random(10,true).$pay_id,
		);
		$setting = uni_setting($_W['uniacid'], array('payment'));
		if(!is_array($setting['payment']['wechat'])) {
			pdo_delete($this->online_pay_record,array('id'=>$pay_id));
			die(json_encode(error('-6','没有设定支付参数')));
		}
		$wechat = $setting['payment']['wechat'];
		$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid';
		$row = pdo_fetch($sql, array(':acid' => $wechat['account']));
		$wechat['appid'] = $row['key'];
		$wechat['secret'] = $row['secret'];
		$wOpt = $this->wechat_build_look($params, $wechat);
		if (is_error($wOpt)) {
			pdo_delete($this->online_pay_record,array('id'=>$pay_id));
			die(json_encode(error('-6',$wOpt['message'])));
		}
		$return = array();
		$return['errno']  = '1';
		$return['data'] = $wOpt;
		die(json_encode($return));
	
}
