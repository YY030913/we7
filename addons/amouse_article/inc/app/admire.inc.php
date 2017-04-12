<?php

$op= $_GPC['op'] ? $_GPC['op'] : 'list';

$artid = intval($_GPC['artid']);

$acid=$_W['acid'];
$account = $uniaccount = array();
$uniaccount = pdo_fetch("SELECT * FROM ".tablename('uni_account')." WHERE uniacid = :uniacid", array(':uniacid' => $weid));
$acid = !empty($acid) ? $acid : $uniaccount['default_acid'];
$account = account_fetch($acid);

$detail = pdo_fetch("SELECT * FROM " . tablename('fineness_article') . " WHERE `id`=:id and weid=:weid", array(':id'=>$artid,':weid' => $weid));
$set=  pdo_fetch("SELECT * FROM ".tablename('fineness_sysset')." WHERE weid=:weid limit 1", array(':weid' => $weid));
$follow_url = $set['guanzhuUrl'];
load()->model('mc');
$userinfo = mc_oauth_userinfo();
$need_openid = true;
if ($_W['container'] != 'wechat') {
    if ($_GPC['do'] == 'admire') {
        $need_openid = false;
    }
}



$adsets= pdo_fetchall("SELECT * FROM ".tablename('fineness_admire_set')." WHERE aid =$artid ORDER BY displayorder ASC limit 0,6 ");

include $this->template('admire');






