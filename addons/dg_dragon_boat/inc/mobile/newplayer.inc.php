<?php

global $_W, $_GPC;
$rid    = $_GPC["rid"];
$acid   = empty($_W['account']['acid']) ? $_W['uniacid'] : $_W['account']['acid'];
$openid = !empty($_W['openid']) ? $_W['openid'] : $_W['fans']['from_user'];
$obj;
if (selectPlayer($openid, $rid, $acid) > 0) {
    $obj['sucess'] = -1;
} else {
    $nickname   = $_W['fans']['nickname'];
    $headimgurl = $_W['fans']['tag']['avatar'];
    $boatIndex  = $_GPC["boatIndex"];
    $distane    = (int) $_GPC['distane'];
    if ($distane > 150) {
        $distane = 150;
    }
    $playerid   = insertPlayer($rid, $acid, $openid, $nickname, $headimgurl, $distane, $boatIndex);
    $helpid     = insertHelp($rid, $acid, $openid, $nickname, $headimgurl, $distane, $playerid);
    $obj["pid"] = $playerid;
    if ($playerid > 0 && $helpid > 0) {
        $obj['sucess']   = 1;
        $obj["nickname"] = $nickname;
        $obj["distance"] = $distane;
    } else {
        $obj['sucess'] = -1;
    }
}
echo json_encode($obj);
function insertPlayer($rid, $acid, $openid, $nickname, $headimgurl, $distane, $boatIndex)
{
    $params = array(
        "rid" => $rid,
        "iacid" => $acid,
        "uniacid" => $acid,
        "OpenId" => $openid,
        "WeixinName" => $nickname,
        "WeixinHead" => $headimgurl,
        "Distance" => $distane,
        "BoatIndex" => $boatIndex
    );
    pdo_insert('longzhou_player', $params);
    return pdo_insertid();
}
function insertHelp($rid, $acid, $openid, $nickname, $headimgurl, $distane, $playerId)
{
    $params = array(
        "rid" => $rid,
        "iacid" => $acid,
        "uniacid" => $acid,
        "HelpOpenId" => $openid,
        "HelpName" => $nickname,
        "HelpHead" => $headimgurl,
        "HelpDistance" => $distane,
        "HelpPlayer" => $playerId
    );
    pdo_insert('longzhou_help', $params);
    return pdo_insertid();
}
function selectPlayer($openid, $rid, $acid)
{
    $sql    = "select count(*) as num from " . tablename("longzhou_player") . " where OpenId='" . $openid . "' and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetch($sql);
    return $result["num"];
}
