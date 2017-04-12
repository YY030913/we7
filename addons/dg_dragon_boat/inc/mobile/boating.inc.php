<?php

global $_W, $_GPC;
load()->func('tpl');
$rid         = $_GPC["rid"];
$acid        = empty($_W['account']['acid']) ? $_W['uniacid'] : $_W['account']['acid'];
$openid      = !empty($_W['openid']) ? $_W['openid'] : $_W['fans']['from_user'];
$nickname    = $_W['fans']['nickname'];
$headimgurl  = $_W['fans']['tag']['avatar'];
$preNum      = 0;
$isNewPlayer = 0;
$currentDis  = 0;
$playerInfo;
$boatIndex = $_GPC["boatIndex"];
$pid       = 0;
$isPlayed  = 0;
$helpArr   = array();
$helpHtml  = '';
$prePlayer;
$havePre = 0;
$disPre  = 0;
$nextPlayer;
$disNext        = 0;
$boatPlayerName = '';
$playertable    = "longzhou_player";
$helptable      = "longzhou_help";
if (isset($_GPC['pid'])) {
    $ishelp         = 1;
    $pid            = (int) $_GPC['pid'];
    $playerInfo     = getPlayerInfo($pid, $rid, $acid);
    $preNum         = selectPlayerRank($playerInfo['OpenId'], $rid, $acid) + 1;
    $boatIndex      = $playerInfo['BoatIndex'];
    $currentDis     = $playerInfo['Distance'];
    $boatPlayerName = $playerInfo['WeixinName'];
    $nickname       = $boatPlayerName;
    $helpArr        = selectHelpsByPlayerId($pid, $rid, $acid);
    $helpHtml       = getHelpsHtml($helpArr, $openid, $isPlayed);
} else {
    $ishelp         = 0;
    $boatPlayerName = $nickname;
    if (nonExist($openid, $rid, $acid)) {
        $preNum      = getBetterInitPlayerNum($rid, $acid) + 1;
        $isNewPlayer = 1;
        $currentDis  = 0;
    } else {
        $isNewPlayer = 0;
        $pid         = selectPlayerId($openid, $rid, $acid);
        $boatIndex   = selectPlayerBoat($openid, $rid, $acid);
        $preNum      = selectPlayerRank($openid, $rid, $acid) + 1;
        $currentDis  = selectMyDistance($openid, $rid, $acid);
        $helpArr     = selectHelpsByOpenId($openid, $rid, $acid);
        $helpHtml    = getHelpsHtml($helpArr, $openid, $isPlayed);
    }
}
if (!empty($_GPC['pid'])) {
    $sql    = "select * from " . tablename($helptable) . " where HelpPlayer=" . $_GPC['pid'] . " and HelpOpenId='" . $openid . "' and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetchall($sql);
    if (count($result) == 0) {
        $ishad = 0;
    } else {
        $ishad = 1;
    }
} else {
    $sql    = "select * from " . tablename($playertable) . " where OpenId='" . $openid . "' and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetchall($sql);
    if (count($result) == 0) {
        $ishad = 0;
    } else {
        $ishad = 1;
    }
}
if (count($helpArr) > 5) {
    $ismore    = 1;
    $helpcount = count($helpArr);
}
if ($preNum <= 1) {
    $prePlayer = null;
} else {
    $prePlayer = getPrePlayerInfo($preNum, $rid, $acid);
    $havePre   = 1;
    $disPre    = $prePlayer['Distance'] - $currentDis;
}
$nextPlayer = getNextPlayerInfo($preNum, $rid, $acid);
if ($nextPlayer == null) {
} else {
    $haveNext = 1;
    $disNext  = $currentDis - $nextPlayer['Distance'];
}
$reply         = pdo_fetch("SELECT * FROM " . tablename("longzhou_reply") . " WHERE rid = :rid ORDER BY `id` DESC", array(
    ':rid' => $rid
));
$gametime      = $reply["gametime"];
$qylogo        = $reply["qylogo"];
$qyname        = $reply["qyname"];
$qylink        = $reply["qylink"];
$xtitle        = str_replace("【姓名】", $nickname, $reply["sharetitle"]);
$title         = str_replace("【距离】", $currentDis, $xtitle);
$sharetitle    = $title;
$sharetitle2   = $reply["sharetitle"];
$shareimg      = "http://" . $_SERVER['HTTP_HOST'] . "/attachment/" . $reply["shareimg"];
$xcontent      = str_replace("【姓名】", $nickname, $reply["sharecontent"]);
$content       = str_replace("【距离】", $currentDis, $xcontent);
$sharecontent  = $content;
$sharecontent2 = $reply["sharecontent"];
$sharelink     = $_W['siteroot'] . 'app/' . $this->createMobileUrl('zhuhua', array(
    'rid' => $rid,
    'pid' => $pid,
    'boatIndex' => $boatIndex
));
$sharelink     = str_replace('./', '', $sharelink);
include $this->template('boating');
function getPrePlayerInfo($preNum, $rid, $acid)
{
    $limit  = $preNum - 2;
    $sql    = "select * from " . tablename("longzhou_player") . " where rid=" . $rid . " and iacid=" . $acid . " order by Distance desc limit $limit, 1";
    $result = pdo_fetch($sql, array());
    return $result;
}
function getNextPlayerInfo($preNum, $rid, $acid)
{
    $sql    = "select * from " . tablename("longzhou_player") . " where rid=" . $rid . " and iacid=" . $acid . " order by Distance desc limit $preNum, 1";
    $result = pdo_fetchall($sql, array());
    if (count($result) > 0) {
        return $result[0];
    } else {
        return null;
    }
}
function getPlayerInfo($pid, $rid, $acid)
{
    $sql = "select * from " . tablename("longzhou_player") . " where PlayerId=" . $pid . " and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetch($sql, array());
    return $result;
}
function getHelpsHtml($helpArr, $openid, &$isPlayed)
{
    $html = '';
    for ($i = 0; $i < count($helpArr); $i++) {
        if ($helpArr[$i]['HelpOpenId'] == $openid) {
            $isPlayed = 1;
        }
        $dis  = $helpArr[$i]['HelpDistance'];
        $head = $helpArr[$i]['HelpHead'];
        if ($i < 5) {
            $html .= '<li><div class="pic"><img src="' . $head . '"></div><span>划' . $dis . '米</span></li>';
        }
    }
    return $html;
}
function selectHelpsByPlayerId($pid, $rid, $acid)
{
    $sql    = "select * from " . tablename("longzhou_help") . " where HelpPlayer = " . $pid . " and rid=" . $rid . " and iacid=" . $acid . " order by HelpId desc";
    $result = pdo_fetchall($sql, array());
    return $result;
}
function selectHelpsByOpenId($openid, $rid, $acid)
{
    $sql    = "select * from " . tablename("longzhou_help") . " where HelpPlayer = (select PlayerId from " . tablename("longzhou_player") . " where OpenId = '" . $openid . "' and rid=" . $rid . " and iacid=" . $acid . ") order by HelpId desc";
    $result = pdo_fetchall($sql, array());
    return $result;
}
function selectMyDistance($openid, $rid, $acid)
{
    $sql    = "select Distance from " . tablename("longzhou_player") . " where OpenId = '" . $openid . "' and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetch($sql, array());
    return (int) $result['Distance'];
}
function selectPlayerBoat($openid, $rid, $acid)
{
    $sql    = " select BoatIndex from " . tablename("longzhou_player") . " where OpenId = '" . $openid . "' and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetch($sql, array());
    $id     = (int) $result['BoatIndex'];
    return $id;
}
function selectPlayerId($openid, $rid, $acid)
{
    $sql    = " select PlayerId from " . tablename("longzhou_player") . " where OpenId = '" . $openid . "' and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetch($sql, array());
    $id     = (int) $result['PlayerId'];
    return $id;
}
function selectPlayerRank($openid, $rid, $acid)
{
    $sql    = "select count(*) as num from " . tablename("longzhou_player") . " where Distance > 
				(select Distance from " . tablename("longzhou_player") . " where OpenId = '" . $openid . "' and rid=" . $rid . " and iacid=" . $acid . ")";
    $result = pdo_fetch($sql, array());
    $num    = (int) $result['num'];
    return $num;
}
function getBetterInitPlayerNum($rid, $acid)
{
    $sql    = "select count(*) as num from " . tablename("longzhou_player") . " where Distance > 0 and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetch($sql, array());
    $num    = (int) $result['num'];
    return $num;
}
function nonExist($openid, $rid, $acid)
{
    $sql    = "select count(*) as num from " . tablename("longzhou_player") . " where OpenId='" . $openid . "' and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetch($sql, array());
    $num    = (int) $result['num'];
    return $num == 0;
}