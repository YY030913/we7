<?php

global $_W, $_GPC;
$rid    = $_GPC["rid"];
$acid   = empty($_W['account']['acid']) ? $_W['uniacid'] : $_W['account']['acid'];
$openid = !empty($_W['openid']) ? $_W['openid'] : $_W['fans']['from_user'];
$pid    = intval($_GPC["pid"]);
$count  = 0;
if ($pid != 0) {
    $obj["scount"] = selectHelper($pid, $rid, $acid);
} else {
    $obj["scount"] = selectPlayer($openid, $rid, $acid);
}
echo json_encode($obj);
function selectPlayer($openid, $rid, $acid)
{
    $sql    = "select count(*) as num from " . tablename("longzhou_player") . " where OpenId='" . $openid . "' and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetch($sql);
    return $result["num"];
}
function selectHelper($pid)
{
    $sql    = "select count(*) as num from " . tablename("longzhou_help") . " where HelpPlayer=" . $pid . " and HelpOpenId='" . $openid . "' and rid=" . $rid . " and iacid=" . $acid;
    $result = pdo_fetch($sql);
    return $result["num"];
}
