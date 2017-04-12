<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$openid = $_W['openid'];
if($_W['isajax']){
	$listid = intval($_GPC['listid']);
	$mobile = $_GPC['mobile'];
	if(empty($mobile) || strlen($mobile)!=11){
		die(json_encode(error('-1','请输入正确的手机号码')));
	}
	$fans_name =  pdo_fetchcolumn("SELECT `nickname` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	$dayu = pdo_fetch("SELECT * FROM ".tablename($this->dayu_table)." WHERE weid=:weid",array(':weid'=>$weid));
	$mobile_code = random(5,true);
	include IA_ROOT."/addons/meepo_online/alidayu/TopSdk.php";
	$c = new TopClient();
	$c->appkey = $dayu['appkey'];
	$c->secretKey = $dayu['appsecret'];
	$req = new AlibabaAliqinFcSmsNumSendRequest;
	$req->setExtend("123456");
	$req->setSmsType("normal");
	$req->setSmsFreeSignName($dayu['sms_signname']);
	$json = json_encode(array("fans_user"=>$fans_name,'mobile_code'=>$mobile_code));
	$req->setSmsParam($json);
	$req->setRecNum($mobile);
	$req->setSmsTemplateCode($dayu['sms_tpl_id']);//  SMS_585014  SMS_6290144
	$result = $c->execute($req);
	if($result->result->err_code=='0'){
		pdo_update($this->list_user_table,array('mobile'=>$mobile),array('openid'=>$openid,'weid'=>$weid,'listid'=>$listid));
		pdo_update($this->user_table,array('mobile'=>$mobile),array('openid'=>$openid,'weid'=>$weid));
		$insert = array('weid'=>$weid,'openid'=>$openid,'listid'=>$listid,'sms_code'=>$mobile_code,'createtime'=>time());
		pdo_insert($this->dayu_sms_record,$insert);
		die(json_encode(error('0','success')));
	}else{
		die(json_encode(error('-1','fail')));
	}
}