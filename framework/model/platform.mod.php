<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 * $sn$
 */
defined('IN_IA') or exit('Access Denied');

/**
	* 微信个性化菜单接口：语言
	* @return 	array
*/
function platform_menu_languages() {
	$languages = array(
		array('ch'=>'简体中文', 'en'=>'zh_CN'),
		array('ch'=>'繁体中文TW', 'en'=>'zh_TW'),
		array('ch'=>'繁体中文HK', 'en'=>'zh_HK'),
		array('ch'=>'英文', 'en'=>'en'),
		array('ch'=>'印尼', 'en'=>'id'),
		array('ch'=>'马来', 'en'=>'ms'),
		array('ch'=>'西班牙', 'en'=>'es'),
		array('ch'=>'韩国', 'en'=>'ko'),
		array('ch'=>'意大利 ', 'en'=>'it'),
		array('ch'=>'日本', 'en'=>'ja'),
		array('ch'=>'波兰', 'en'=>'pl'),
		array('ch'=>'葡萄牙', 'en'=>'pt'),
		array('ch'=>'俄国', 'en'=>'ru'),
		array('ch'=>'泰文', 'en'=>'th'),
		array('ch'=>'越南', 'en'=>'vi'),
		array('ch'=>'阿拉伯语', 'en'=>'ar'),
		array('ch'=>'北印度', 'en'=>'hi'),
		array('ch'=>'希伯来', 'en'=>'he'),
		array('ch'=>'土耳其', 'en'=>'tr'),
		array('ch'=>'德语', 'en'=>'de'),
		array('ch'=>'法语', 'en'=>'fr')
	);
	return $languages;
}