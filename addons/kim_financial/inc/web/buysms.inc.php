<?php
/**
 * 会员财务中心
 *
 * 作者:Kim
 * 模块定制QQ: 800083075
 * 后台体验地址: http://www.goodziyuan.com
 */
defined('IN_IA') or exit('Access Denied');
global $_W,$_GPC;
checklogin();
$_W['page']['title'] = "购买短信";
$ops = array("record");
$op = in_array($_GPC["op"], $ops) ? $_GPC["op"] : "display";
$settings = get_settings();
if($_W['ispost'] && $_W['isajax']) {
    $number = intval($_GPC["number"]);
    $result = array("code"=>0,"message"=>"提交失败,请重试!");
    if($_W["user"]["uid"] <= 0) die(json_encode(array("code"=>0, "message"=>"获取身份失败,请重新登录")));
    if($_W["user"]["credit2"]<=0) die(json_encode(array("code"=>1, "message"=>"余额不足,请进行充值","url"=>$this->createWebUrl("Recharge"))));
    if($number < 1) die(json_encode(array("code"=>0, "message"=>"至少购买1条")));
    $price = 0.1;
    if(!empty($settings) && doubleval($settings["dx_UnitPrice"]) > 0) $price = doubleval($settings["dx_UnitPrice"]);
    $total = $price*$number;
    if($_W["user"]["credit2"]< $total) die(json_encode(array("code"=>1, "message"=>"余额不够,请进行充值","url"=>$this->createWebUrl("Recharge"))));
    if(!is_error(user_credits_update($_W["user"]["uid"], "credit2", doubleval(-$total), array(1,"购买短信消费")))){
        //加短信数
        $notify["sms"]['balance'] = $_W["user"]["sms"]["balance"]+$number;
        $notify["sms"]['signature'] = $_W["user"]["sms"]['signature'];
        pdo_update("uni_settings",array("notify"=>@iserializer($notify)),array("uniacid"=>$_W['uniacid']));
        die(json_encode(array("code"=>1, "message"=>"购买成功.")));
    };
    die(json_encode(array("code"=>0, "message"=>"购买失败")));
}
if($_W["user"]["credit2"] < doubleval($settings["dx_UnitPrice"])) {
    message("余额不足,请进行充值.",$this->createWebUrl('Recharge'));
}
$service = explode("|",$settings["service_qqs"]);
$qqs = array();
foreach($service as $ser) {
    list($name,$qq) = explode("-",$ser);
    $qqs[] = array(
        "name"=>$name,
        "qq"=>$qq
    );
}
include $this->template('financial_buysms');