<?php

global $_W, $_GPC;
$rid           = $_GPC["rid"];
$acid          = empty($_W['account']['acid']) ? $_W['uniacid'] : $_W['account']['acid'];
$from_user     = !empty($_W['openid']) ? $_W['openid'] : $_W['fans']['from_user'];
$playerNum     = 0;
$pid           = $_GPC['pid'];
$istomy        = 0;
$sql           = "SELECT * FROM " . tablename('longzhou_reply') . " WHERE rid = :rid LIMIT 1";
$longzhoureply = pdo_fetch($sql, array(
    ':rid' => $rid
));
$ismeto        = $_GPC["ismeto"];
$fullurl       = $_COOKIE["fullurl"];
if (!empty($fullurl) && $ismeto != 1) {
    setcookie("fullurl");
    header('Location: ' . $fullurl . "&issub=1");
} else {
    if ($longzhoureply['end_time'] < time() || $longzhoureply['status'] == 2) {
        include $this->template('over');
        exit();
    } else {
        $huodongname = $longzhoureply["huodongname"];
        $huodongdesc = $longzhoureply["huodongdesc"];
        $start_time  = $longzhoureply["start_time"];
        $end_time    = $longzhoureply["end_time"];
        $gamegzjp    = $longzhoureply["gamegzjp"];
        $gamemusic   = $longzhoureply["gamemusic"];
        $sql         = "select * from " . tablename("longzhou_player") . " where OpenId='" . $from_user . "' and rid=" . $rid . " and iacid=" . $acid;
        $result      = pdo_fetchall($sql);
        if (count($result) == 0) {
            $istomy = 1;
        } else {
            $istomy    = 0;
            $boatIndex = $result["BoatIndex"];
        }
        $players      = pdo_fetchall("SELECT * FROM " . tablename("longzhou_player") . " WHERE rid = :rid and iacid=" . $acid, array(
            ':rid' => $rid
        ));
        $playerNum    = count($players);
        $iscaiji      = $longzhoureply["iscaiji"];
        $qylogo       = $longzhoureply["qylogo"];
        $qyname       = $longzhoureply["qyname"];
        $qylink       = $longzhoureply["qylink"];
        $ggimg        = $longzhoureply["ggimg"];
        $gglink       = $longzhoureply["gglink"];
        $sharetitle   = $longzhoureply["sharetitle"];
        $shareimg     = "http://" . $_SERVER['HTTP_HOST'] . "/attachment/" . $longzhoureply["shareimg"];
        $sharecontent = $longzhoureply["sharecontent"];
        $sharelink    = $_W['siteroot'] . 'app/' . $this->createMobileUrl('index', array(
            'rid' => $rid
        ));
        $sharelink    = str_replace('./', '', $sharelink);
        $from_user    = !empty($_W['openid']) ? $_W['openid'] : $_W['fans']['from_user'];
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
                    include $this->template('index');
                }
            } else {
                include $this->template('index');
            }
        } else {
            include $this->template('subscribe');
        }
    }
}