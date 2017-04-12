<?php

global $_W, $_GPC;
$rid           = $_GPC["rid"];
$acid          = empty($_W['account']['acid']) ? $_W['uniacid'] : $_W['account']['acid'];
$from_user     = !empty($_W['openid']) ? $_W['openid'] : $_W['fans']['from_user'];
$playerNum     = 0;
$pid           = $_GPC['pid'];
$PlayerName    = '';
$pOrder        = 0;
$istomy        = 0;
$boatIndex     = $_GPC["boatIndex"];
$table         = "longzhou_player";
$sql           = "SELECT * FROM " . tablename('longzhou_reply') . " WHERE rid = :rid LIMIT 1";
$longzhoureply = pdo_fetch($sql, array(
    ':rid' => $rid
));
$issub         = $_GPC["issub"];
if (empty($issub)) {
    $fullurl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    setcookie('fullurl', $fullurl, time() + 3600);
}
if ($longzhoureply['end_time'] < time() || $longzhoureply['status'] == 2) {
    include $this->template('over');
    exit();
} else {
    $huodongname = $longzhoureply["huodongname"];
    $huodongdesc = $longzhoureply["huodongdesc"];
    $start_time  = $longzhoureply["start_time"];
    $end_time    = $longzhoureply["end_time"];
    $gamegzjp    = $longzhoureply["gamegzjp"];
    $sql         = "select * from " . tablename("longzhou_player") . " where OpenId='" . $from_user . "'";
    $result      = pdo_fetch($sql);
    if (empty($result)) {
        $istomy = 1;
    } else {
        $istomy    = 0;
        $boatIndex = $result["BoatIndex"];
    }
    $players      = pdo_fetchall("SELECT * FROM " . tablename("longzhou_player") . " WHERE rid = :rid", array(
        ':rid' => $rid
    ));
    $playerNum    = count($players);
    $sharetitle   = $longzhoureply["sharetitle"];
    $shareimg     = "http://" . $_SERVER['HTTP_HOST'] . "/attachment/" . $longzhoureply["shareimg"];
    $sharecontent = $longzhoureply["sharecontent"];
    $sharelink    = $_W['siteroot'] . 'app/' . $this->createMobileUrl('index', array(
        'rid' => $rid
    ));
    $sharelink    = str_replace('./', '', $sharelink);
    $sql          = "select * from " . tablename($table) . " where PlayerId=" . $pid . " and rid=" . $rid . " and iacid=" . $acid;
    $playerInfo = pdo_fetch($sql);
    if ($playerInfo['OpenId'] == $from_user) {
        $istomy  = 0;
        $urlName = '我的龙舟';
    } else {
        $istomy     = 1;
        $PlayerName = $playerInfo['WeixinName'];
        $urlName    = '帮' . $PlayerName . '划船';
        $sql        = "select count(*) as num from " . tablename($table) . " where Distance >(select Distance from " . tablename($table) . " where PlayerId =" . $pid . ") and rid=" . $rid . " and iacid=" . $acid;
        $result     = pdo_fetch($sql, array());
        $pOrder     = ((int) $result["num"]) + 1;
    }
    $players   = pdo_fetchall("SELECT * FROM " . tablename($table) . " WHERE rid = :rid", array(
        ':rid' => $rid
    ));
    $playerNum = count($players);
    $from_user = !empty($_W['openid']) ? $_W['openid'] : $_W['fans']['from_user'];
    if (empty($from_user)) {
        $from_user = empty($_COOKIE["user_oauth2_openid"]) ? $_GPC['from_user'] : $_COOKIE["user_oauth2_openid"];
    }
    $account    = WeAccount::create($_W['account']);
    $userinfo   = $account->fansQueryInfo($from_user);
    $followdesc = $longzhoureply["followdesc"];
    if (!empty($userinfo)) {
        if ($userinfo['subscribe'] == 0) {
            if ($longzhoureply["subscribe"] == 1) {
                include $this->template('subscribe');
            } else {
                if ($palyeres["PlayerId"] == $pid) {
                    include $this->template('index');
                } else {
                    include $this->template('zhuhua');
                }
            }
        } else {
            if ($result["PlayerId"] == $pid) {
                include $this->template('index');
            } else {
                include $this->template('zhuhua');
            }
        }
    } else {
        include $this->template('subscribe');
    }
}