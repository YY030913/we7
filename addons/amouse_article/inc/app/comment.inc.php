<?php
global $_GPC, $_W;
$artid = intval($_GPC['artid']);

if(empty($artid)){
    $artid = intval($_GPC['id']);
}
$weid=$_W['uniacid'];
$detail = pdo_fetch("SELECT * FROM " . tablename('fineness_article') . " WHERE `id`=:id and weid=:weid", array(':id'=>$artid,':weid' => $weid));
$set=  pdo_fetch("SELECT * FROM ".tablename('fineness_sysset')." WHERE weid=:weid limit 1", array(':weid' => $weid));
$follow_url = $set['guanzhuUrl'];
$is_follow = false;
load()->model('mc');
$userinfo = mc_oauth_userinfo();

$mycomments=pdo_fetchall("SELECT * FROM ".tablename('fineness_comment')." WHERE `aid`=:aid and weid=:weid AND openid=:openid order by createtime desc ", array(':aid'=>$artid, ':weid'
=>$weid,':openid'=>$userinfo['openid']));

include $this->template('comment');