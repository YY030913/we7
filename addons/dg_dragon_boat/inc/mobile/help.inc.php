<?php
global $_W, $_GPC;
$rid        = $_GPC["rid"];
$acid       = empty($_W['account']['acid']) ? $_W['uniacid'] : $_W['account']['acid'];
$openid     = !empty($_W['openid']) ? $_W['openid'] : $_W['fans']['from_user'];
$nickname   = $_W['fans']['nickname'];
$headimgurl = $_W['fans']['tag']['avatar'];
$playerId   = (int) $_GPC['playerId'];
$distane    = (int) $_GPC['distane'];
$reply      = pdo_fetch("SELECT * FROM " . tablename('longzhou_reply') . " WHERE rid = :rid", array(
    ':rid' => $rid
));
$gametime   = intval($reply["gametime"]);
if ($distane > (15 * $gametime)) {
    $distane = 15 * $gametime;
}
$obj;
if (strlen($openid) > 0 && strlen($nickname) > 0) {
    if (nonExistHelp($openid, $playerId, $rid, $acid)) {
        $ret = insertHelp($rid, $acid, $openid, $nickname, $headimgurl, $distane, $playerId);
        if ($ret > 0) {
            $obj['sucess'] = 1;
        } else {
            $obj['sucess'] = 0;
        }
        updatePlayer($playerId, $distane, $rid, $acid);
        $playinfo        = selectPlayer($playerId, $rid, $acid);
        $obj["nickname"] = $playinfo["WeixinName"];
        $obj["distance"] = $playinfo["Distance"];
    } else {
        $obj['sucess'] = -1;
    }
    echo json_encode($obj);
} else {
    $obj['sucess'] = 0;
    echo json_encode($obj);
}
function selectPlayer($playerId, $rid, $acid)
{
    $sql    = "select * from " . tablename("longzhou_player") . " where PlayerId=" . $playerId . " and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetch($sql);
    return $result;
}
function updatePlayer($playerId, $distane, $rid, $acid)
{
    $sql = "update " . tablename("longzhou_player") . " SET Distance = Distance + $distane  where PlayerId =" . $playerId . " and rid=" . $rid . " and iacid=" . $acid;
    pdo_fetch($sql, array());
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
function nonExistHelp($openid, $playerId, $rid, $acid)
{
    $sql    = "select count(*) as num from " . tablename("longzhou_help") . " where HelpOpenId='" . $openid . "' and HelpPlayer =" . $playerId . " and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetch($sql, array());
    $num    = (int) $result['num'];
    return $num == 0;
}
