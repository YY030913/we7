<?php
global $_W,$_GPC;

$act = trim($_GPC['act']);

$list = M('citys')->getList();

if($act == 'add'){
	$data = array();
	$input = $_GPC['__input'];
	$return = M('citys')->update($input);
	die(json_encode($return));
}

if($act == 'delete'){
	$input = $_GPC['__input'];
	$id = intval($input['id']);
	M('citys')->delete($id);
	die();
}

include $this->template('address');