<?php
if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');
global $_GPC, $_W;
$rid = intval($_GPC['rid']);
if (empty($rid)) {
    message('抱歉，传递的参数错误！', '', 'error');
}
$list = pdo_fetchall("SELECT * FROM " . tablename('bm_payx_payed') . " WHERE rid = '$rid' ORDER BY id DESC");
foreach ($list as &$row) {
    if (empty($row['status']) || ($row['status'] == 0)) {
        $row['status'] = 未支付;
    } elseif ($row['status'] == 1) {
        $row['status'] = 已支付;
    } elseif ($row['status'] == 2) {
        $row['status'] = 已使用;
    }
    if ($row['getstatus'] == 1) {
        $row['getstatus'] = 已提现;
    } else {
        $row['getstatus'] = 未提现;
    }
    if ($row['paytype'] == 1) {
        $row['paytype'] = 余额支付;
    } elseif ($row['paytype'] == 2) {
        $row['paytype'] = 支付宝;
    } else {
        $row['paytype'] = 微信支付;
    }
    $row['paytime']  = date("Y-m-d H:i:s", $row['paytime']);
    $row['dateline'] = date("Y-m-d H:i:s", $row['dateline']);
    $row['redtime']  = date("Y-m-d H:i:s", $row['redtime']);
}
error_reporting(0);
Header('Content-type:   application/octet-stream ');
Header('Accept-Ranges:   bytes ');
Header('Content-type:application/vnd.ms-excel ;charset=utf-8');
Header('Content-Disposition:attachment;filename=Report.xls');
echo '<table width=\'100%\' border=\'1\' >';
echo '<tr>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>编号 </font></td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>支付码 </font></td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>昵称 </font></td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>openid </font></td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>使用店员 </font></td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>支付时间 </font></td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>提交时间 </font> </td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>红包时间 </font></td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>支付金额 </font></td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>红包金额 </font></td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>付款类型 </font></td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>收款状态 </font></td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>红包状态 </font></td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>卡券状态 </font> </td>';
echo '<td  style=\'color:red\' align=\'center\'>  <font size=4>提现状态 </font> </td>';
echo '</tr>';
foreach ($list as $value) {
    echo "<tr>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['id'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['paycode'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['username'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['fromuser'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['name'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['paytime'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['dateline'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['redtime'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['qrmoney'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['red'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['paytype'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['status'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['redmemo'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['cardmemo'] . " </font></td>";
    echo '<td  align=\'center\'>  <font size=4>' . $value['getstatus'] . " </font></td>";
    echo '</tr>';
}
exit();
?>