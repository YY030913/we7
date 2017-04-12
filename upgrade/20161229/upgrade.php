<?php
define('IN_SYS', true);
require '../../framework/bootstrap.inc.php';
require IA_ROOT . '/web/common/bootstrap.sys.inc.php';
require IA_ROOT . '/web/common/common.func.php';
$we7_coupon_exists = pdo_get('modules', array('name' => 'we7_coupon'));
if (!empty($we7_coupon_exists)) {
	pdo_update('modules', array('settings' => '2'), array('mid' => $we7_coupon_exists['mid']));
}
