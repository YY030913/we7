<?php
global $_W,$_GPC;

$title = "我要送";

$template_content = $template.'/post/index';

$setting = M('setting')->getValue('divider_set');

$citys = array();


$html = $setting['post_notice'];

$params = M('setting')->getValue('tpl_divider_design_params');

if($_W['ispost']){
	$post = iserializer($_GPC['__input']);
	M('setting')->update('tpl_divider_design_params',$post);

	message('保存成功',referer(),'ajax');
}

include $this->template('divider_template');