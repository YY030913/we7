<?php

global $_W,$_GPC;
load()->func('tpl');
$weid = $_W['uniacid'];
$setting = pdo_fetch("SELECT * FROM ".tablename($this->setting_table)." WHERE	 weid=:weid",array(':weid'=>$weid));
if(empty($setting)){
		$setting['settings']['gz_must'] = 1;
		$setting['settings']['gz_url'] = '';
		$setting['settings']['kefu_url'] = '';
		$setting['settings']['live_copyright'] = '© 20015-2016 xxx 版权所有';
		$setting['settings']['live_list_title'] = '直播列表';
		$setting['settings']['live_jingxuan_title'] = '精选直播';
		$setting['settings']['no_avatar'] = '../addons/meepo_online/no_avatar.jpg';
		$setting['settings']['footer_color'] = '#ff6a00';
		$setting['settings']['socket_url'] = 'xxxxx:1409';
		$setting['settings']['sina_key'] = '1562966081';
}else{
		$setting['settings']  = iunserializer($setting['settings']);
}
if($_W['ispost']){
	$id = intval($_GPC['id']);
	$data = array();
	$data['weid'] = $weid;
	$post_setting = array('gz_must'=>$_GPC['gz_must'],'gz_url'=>$_GPC['gz_url'],'no_avatar'=>$_GPC['no_avatar'],'live_copyright'=>$_GPC['live_copyright'],'kefu_url'=>$_GPC['kefu_url'],'live_list_title'=>$_GPC['live_list_title'],'live_jingxuan_title'=>$_GPC['live_jingxuan_title'],'footer_color'=>$_GPC['footer_color'],'socket_url'=>$_GPC['socket_url'],'sina_key'=>$_GPC['sina_key'],'consumer_tpl'=>$_GPC['consumer_tpl'],'consumer_customer_img'=>$_GPC['consumer_customer_img'],'award_tpl'=>$_GPC['award_tpl'],'award_customer_img'=>$_GPC['award_customer_img'],'yuyue_tpl'=>$_GPC['yuyue_tpl'],'yuyue_customer_img'=>$_GPC['yuyue_customer_img'],'index_share_title'=>$_GPC['index_share_title'],'index_share_content'=>$_GPC['index_share_content'],'index_share_img'=>$_GPC['index_share_img'],'jingxuan_share_title'=>$_GPC['jingxuan_share_title'],'jingxuan_share_content'=>$_GPC['jingxuan_share_content'],'jingxuan_share_img'=>$_GPC['jingxuan_share_img'],'list_share_title'=>$_GPC['list_share_title'],'list_share_content'=>$_GPC['list_share_content'],'list_share_img'=>$_GPC['list_share_img']);
	$data['settings'] = iserializer($post_setting);
	if(empty($id)){
		$data['createtime'] = time();	
		pdo_insert($this->setting_table,$data);
	}else{
		pdo_update($this->setting_table,$data,array('id'=>$id,'weid'=>$weid));	
	}
	message('保存成功',referer());
}
include $this->template('setting');