<?php
define('IN_SYS', true);
require '../../framework/bootstrap.inc.php';
require IA_ROOT . '/web/common/bootstrap.sys.inc.php';
require IA_ROOT . '/web/common/common.func.php';
$we7_coupon_exists = pdo_get('modules', array('name' => 'we7_coupon'));
$paycenter_stat = pdo_get('core_menu', array('permission_name' => 'stat_paycenter'));
$credit1_stat = pdo_get('core_menu', array('permission_name' => 'stat_credit1'));
$credit2_stat = pdo_get('core_menu', array('permission_name' => 'stat_credit2'));

$credit1_stat_url = url('site/entry', array('m' => 'we7_coupon', 'do' => 'statcredit1'));
$credit2_stat_url = url('site/entry', array('m' => 'we7_coupon', 'do' => 'statcredit2'));
$cash_stat_url = url('site/entry', array('m' => 'we7_coupon', 'do' => 'statcash'));
$card_stat_url = url('site/entry', array('m' => 'we7_coupon', 'do' => 'statcard'));
$paycenter_stat_url = url('site/entry', array('m' => 'we7_coupon', 'do' => 'statpaycenter'));
if (!empty($we7_coupon_exists)) {
	if (!empty($credit1_stat) && !empty($credit2_stat)) {
		pdo_update('core_menu', array('url' => $credit1_stat_url), array('permission_name' => 'stat_credit1'));
		pdo_update('core_menu', array('url' => $credit2_stat_url), array('permission_name' => 'stat_credit2'));
		if (!empty($paycenter_stat)) {
			pdo_update('core_menu', array('url' => $cash_stat_url), array('permission_name' => 'stat_cash'));
			pdo_update('core_menu', array('url' => $card_stat_url), array('permission_name' => 'stat_card'));
			pdo_update('core_menu', array('url' => $paycenter_stat_url), array('permission_name' => 'stat_paycenter'));
		}
	}
}
