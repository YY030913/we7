<?php
define('IN_SYS', true);
require '../../framework/bootstrap.inc.php';
require IA_ROOT . '/web/common/bootstrap.sys.inc.php';
require IA_ROOT . '/web/common/common.func.php';

//邮件通知参数添加
$check_email = pdo_get('core_menu', array('permission_name' => 'profile_notify', 'name' => 'setting'));
if (empty($check_email)) {
	$tpid = pdo_get('core_menu', array('name' => 'setting', 'permission_name' => 'mc_setting'), array('id'));
	$email_data = array(
		'pid' => $tpid['id'],
		'title' => '邮件通知参数',
		'name' => 'setting',
		'url' => url('profile/notify'),
		'displayorder' => '0',
		'type' => 'url',
		'is_system' => '1',
		'permission_name' => 'profile_notify',
	);
	pdo_insert('core_menu', $email_data);
}