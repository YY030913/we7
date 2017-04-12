<?php
global $_W,$_GPC;
$code = 'plugin_setting';
$item = M('setting')->getByCode($code);
$plugin = iunserializer($item['value']);

if($_W['ispost']){
	$data = iserializer($_POST);
	M('setting')->update($code,$data);
	message('提交成功');
}
include $this->template('setting');