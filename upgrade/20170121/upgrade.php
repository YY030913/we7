<?php
define('IN_SYS', true);
require '../../framework/bootstrap.inc.php';
require IA_ROOT . '/web/common/bootstrap.sys.inc.php';
require IA_ROOT . '/web/common/common.func.php';

//百度百科接口关闭
pdo_delete('rule', array('uniacid' => 0, 'name' => '百度百科', 'module' => 'userapi'));
pdo_delete('userapi_reply', array('apiurl' => 'baike.php'));
