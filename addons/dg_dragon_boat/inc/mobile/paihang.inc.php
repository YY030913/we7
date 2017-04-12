<?php

global $_W, $_GPC;
$rid        = $_GPC["rid"];
$acid       = empty($_W['account']['acid']) ? $_W['uniacid'] : $_W['account']['acid'];
$pid        = $_GPC["pid"];
$nickname   = $_W['fans']['nickname'];
$openid     = !empty($_W['openid']) ? $_W['openid'] : $_W['fans']['from_user'];
$nid        = "";
$boatIndex  = "";
$currentDis = "";
if (!empty($pid)) {
    $nid      = $pid;
    $psql     = "select * from " . tablename("longzhou_player") . " where PlayerId =" . $nid . " and rid = " . $rid . " and iacid=" . $acid . "";
    $palyeres = pdo_fetch($psql);
    if (!empty($palyeres)) {
        $boatIndex  = $palyeres['BoatIndex'];
        $currentDis = $palyeres['Distance'];
    }
} else {
    $psql     = "select * from " . tablename("longzhou_player") . " where OpenId = '" . $openid . "' and rid = " . $rid . " and iacid=" . $acid . "";
    $palyeres = pdo_fetch($psql);
    if (!empty($palyeres)) {
        $nid        = $palyeres['PlayerId'];
        $boatIndex  = $palyeres['BoatIndex'];
        $currentDis = $palyeres['Distance'];
    }
}
$type         = $_GPC['type'];
$helpcount    = 0;
$helpArr      = selectHelpsByPlayerId($nid, $rid, $acid);
$helpcount    = count($helpArr);
$helpsHtml    = getHelpsHtml($helpArr);
$playerArr    = selectPlayers($rid, $acid);
$playersHtml  = getPlayersHtml($playerArr);
$playerOrder  = selectPlayerRank($nid, $rid, $acid) + 1;
$reply        = pdo_fetch("SELECT * FROM " . tablename("longzhou_reply") . " WHERE rid = :rid ORDER BY `id` DESC", array(
    ':rid' => $rid
));
$xtitle       = str_replace("【姓名】", $nickname, $reply["sharetitle"]);
$title        = str_replace("【距离】", $currentDis, $xtitle);
$sharetitle   = $title;
$shareimg     = "http://" . $_SERVER['HTTP_HOST'] . "/attachment/" . $reply["shareimg"];
$xcontent     = str_replace("【姓名】", $nickname, $reply["sharecontent"]);
$content      = str_replace("【距离】", $currentDis, $xcontent);
$sharecontent = $content;
$sharelink    = $_W['siteroot'] . 'app/' . $this->createMobileUrl('zhuhua', array(
    'rid' => $rid,
    'pid' => $nid,
    'boatIndex' => $boatIndex
));
$sharelink    = str_replace('./', '', $sharelink);
$endsecond    = $reply["end_time"];
$now          = time();
$nowsecond    = strtotime(date("y-m-d h:i:s", $now));
$leftsecond   = $endsecond - $nowsecond;
include $this->template('paihang');
function selectPlayerRank($nid, $rid, $acid)
{
    $sql    = "select count(*) as num from " . tablename("longzhou_player") . " where Distance >
		(select Distance from " . tablename("longzhou_player") . " where PlayerId =" . $nid . " and rid = " . $rid . " and iacid=" . $acid . ") and rid = " . $rid . " and iacid=" . $acid;
    $result = pdo_fetch($sql);
    $num    = (int) $result['num'];
    return $num;
}
function getHelpsHtml($helpArr)
{
    $html = '';
    for ($i = 0; $i < count($helpArr); $i++) {
        $dis      = $helpArr[$i]['HelpDistance'];
        $head     = $helpArr[$i]['HelpHead'];
        $helpName = $helpArr[$i]['HelpName'];
        $order    = $i + 1;
        $html .= '<li><img src="' . $head . '" width="50"><p class="p1">' . $helpName . '</p><p>划了：<i>' . $dis . '</i>米</p><div class="count">' . $order . '</div></li>';
    }
    return $html;
}
function selectHelpsByPlayerId($nid, $rid, $acid)
{
    $result = array();
    if (!empty($nid)) {
        $sql    = "select * from " . tablename("longzhou_help") . " where HelpPlayer =" . $nid . " and rid = " . $rid . " and iacid=" . $acid . " order by HelpDistance desc";
        $result = pdo_fetchall($sql);
    }
    return $result;
}
function selectPlayers($rid, $acid)
{
    $sql    = "select * from " . tablename("longzhou_player") . " where rid = " . $rid . " and iacid=" . $acid . " order by Distance desc";
    $result = pdo_fetchall($sql);
    return $result;
}
function getPlayersHtml($playerArr)
{
    $html = '';
    for ($i = 0; $i < count($playerArr); $i++) {
        $playerId = $playerArr[$i]['PlayerId'];
        $dis      = $playerArr[$i]['Distance'];
        $head     = $playerArr[$i]['WeixinHead'];
        $name     = $playerArr[$i]['WeixinName'];
        $order    = $i + 1;
        $html .= '<li  onclick="goHelp(' . $playerId . ')"><img src="' . $head . '" width="50"><p class="p1">' . $name . '</p><p>共划了：<i>' . $dis . '</i>米</p><div class="count">' . $order . '</div></li>';
    }
    return $html;
}