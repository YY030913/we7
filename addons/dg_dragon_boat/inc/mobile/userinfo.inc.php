<?php

global $_W, $_GPC;
$rid    = $_GPC["rid"];
$acid   = empty($_W['account']['acid']) ? $_W['uniacid'] : $_W['account']['acid'];
$openid = !empty($_W['openid']) ? $_W['openid'] : $_W['fans']['from_user'];
$name   = $_GPC["name"];
$phone  = $_GPC["phone"];
$ret    = insertuser($rid, $acid, $openid, $name, $phone);
$obj;
if ($ret > 0) {
    $obj['sucess'] = 1;
} else {
    $obj['sucess'] = -1;
}
echo json_encode($obj);
function insertuser($rid, $acid, $openid, $name, $phone)
{
    $params = array(
        "rid" => $rid,
        "iacid" => $acid,
        "uniacid" => $acid,
        "openid" => $openid,
        "name" => $name,
        "phone" => $phone
    );
    pdo_insert('longzhou_userinfo', $params);
    return pdo_insertid();
}
