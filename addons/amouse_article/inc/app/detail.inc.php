<?php
global $_W, $_GPC;
$weid=$_W['uniacid'];
$set = $this->getSysett($weid);
$id = intval($_GPC['id']);

$acid=$_W['acid'];

$account = $uniaccount = array();
$uniaccount = pdo_fetch("SELECT * FROM ".tablename('uni_account')." WHERE uniacid = :uniacid", array(':uniacid' => $weid));
$acid = !empty($acid) ? $acid : $uniaccount['default_acid'];
$account = account_fetch($acid);

$detail = pdo_fetch("SELECT * FROM " . tablename('fineness_article') . " WHERE `id`=:id and weid=:weid", array(':id'=>$id,':weid' => $weid));

$openid = $_W['fans']['from_user'];
if(empty($openid)){
    $openid = getip();
}

$myrecord = pdo_fetch("SELECT * FROM " . tablename('fineness_article_log') . " WHERE openid=:openid and aid=:aid and uniacid=:uniacid limit 1 ", array(':openid' => $openid, ':aid' =>$id, ':uniacid' => $_W['uniacid']));
if (empty($myrecord['id'])) {
    $insert = array('aid' => $id, 'read' => 1, 'uniacid' => $_W['uniacid'], 'openid' => $openid);
    pdo_insert('fineness_article_log', $insert);
    $sid = pdo_insertid();
    pdo_update('fineness_article', array('clickNum' => $detail['clickNum'] + 1), array('id' => $detail['id']));
}
$shareimg = toimage($detail['thumb']);
$url=$_W['siteroot']."app/".substr($this->createMobileUrl('detail',array('id'=>$id,'uniacid'=>$weid),true),2);
if($detail['bg_music_switch']==1){
    if (strexists($detail['musicurl'], 'http://')||strexists($detail['musicurl'], 'https://')) {
        $detail['musicurl'] = $detail['musicurl'];
    } else {
        $detail['musicurl'] = $_W['attachurl'] . $detail['musicurl'];
    }
}
if (!empty($detail['outLink'])) {
    if(strtolower(substr($detail['outLink'], 0, 4)) != 'tel:' && !strexists($detail['outLink'], 'http://') && !strexists($detail['outLink'], 'https://')) {
        $detail['outLink'] = $_W['siteroot'] . 'app/' . $detail['outLink'];
    }
    header('Location: '. $detail['outLink']);
    exit;
}
$detail['content']= preg_replace("/<img(.*?)(http[s]?\:\/\/mmbiz.qpic.cn[^\?]*?)(\?[^\"]*?)?\"/i", '<img $1$2"', $detail['content']);
if(!empty($detail['thumb'])) {
    $detail['thumb'] = tomedia($detail['thumb']);
} else {
    $detail['thumb'] = '';
}
$readnum = $detail['clickNum'] > 100000 ? '100000+' : $detail['clickNum']; 
$zanNum = $detail['zanNum'] > 100000 ? '100000+' : $detail['zanNum'];

$sql = "SELECT * FROM `ims_fineness_adv_er` AS t1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM `ims_fineness_adv_er`)-(SELECT MIN(id) FROM `ims_fineness_adv_er`))+(SELECT MIN(id) FROM `ims_fineness_adv_er`)) AS id) AS t2 WHERE t1.id >= t2.id ORDER BY t1.id LIMIT 1";
$randAdv = pdo_fetch($sql);
if($randAdv){
    $randAdv['thumb'] = (strpos($randAdv['thumb'], 'http://') === FALSE) ? tomedia($randAdv['thumb']) : $randAdv['thumb'];
}
$sql1 = "SELECT * FROM `ims_wx_tuijian` AS t1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM `ims_wx_tuijian`)-(SELECT MIN(id) FROM `ims_wx_tuijian`))+(SELECT MIN(id) FROM `ims_wx_tuijian`)) AS id) AS t2 WHERE t1.id >= t2.id AND t1.hot=1 ORDER BY t1.id LIMIT 1";
$randtj = pdo_fetch($sql1);
if($randtj){
    $randtj['thumb'] = (strpos($randtj['thumb'], 'http://') === FALSE) ? tomedia($randtj['thumb']) : $randtj['thumb'];
}

$wechat=  pdo_fetch("SELECT * FROM ".tablename('account_wechats')." WHERE acid=:acid AND uniacid=:uniacid limit 1", array(':acid' => $weid,':uniacid' => $weid));

if($detail && $detail['iscomment']=='0'){
    $where = " WHERE `aid`=$id and weid=$weid " ;
    if($set && $set['iscomment']==1){//不开启审核
        $where.=" and status=1 ";
    }

    load()->model('mc');
    $userinfo = mc_oauth_userinfo();

    $cList = pdo_fetchall("SELECT * FROM " . tablename('fineness_comment') .$where );
}

if($detail['isadmire']==0){
    $admires=pdo_fetchall("SELECT * FROM ".tablename('fineness_admire')." WHERE `aid`=:aid and weid=:weid and status=1 order by id desc ", array(':aid'=>$detail['id'],':weid'=>$weid));
}

if(!empty($detail['template'])) {
    include $this->template($detail['templatefile']);
    exit;
}
include $this->template('themes/detail5');
exit;