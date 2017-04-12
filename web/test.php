<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 * $sn: pro/web/index.php : v 14b9a4299104 : 2015/09/11 10:44:21 : yanghf $
 */
define('IN_SYS', true);
require '../framework/bootstrap.inc.php';
require IA_ROOT . '/web/common/bootstrap.sys.inc.php';
load()->web('common');
load()->web('template');
load()->func('communication');
load()->model('cache');
load()->model('frame');
load()->model('cloud');
load()->classs('coupon');


if (!pdo_tableexists('activity_clerks')) {
	pdo_delete('core_menu', array('permission_name ' => 'profile_deskmenu'));
	pdo_delete('core_menu', array('permission_name ' => 'stat_card'));
	pdo_delete('core_menu', array('permission_name ' => 'stat_paycenter'));
	pdo_delete('core_menu', array('permission_name ' => 'stat_cash'));
}




//Sl1720Mq2SCHWUgMNuQyrTtPdSr7DFjAjee6q3VhOEY 永久视频
//Sl1720Mq2SCHWUgMNuQyraph53Ecx69RCbZ4ZxRnfxM 永久音频
$account_api = WeAccount::create();
//$account_api->clearAccessToken();
//$thumb = $account_api->uploadVideoFixed('我的视频', '我的视频描述', '/videos/myvideo.mp4');
//$thumb = $account_api->uploadMediaFixed('/audios/1123.mp3');
//print_r($thumb);exit;
//$result = $account_api->downloadMedia('PlwECnLT9a6btGwBjGzZ5zJC5Lf_BN1o0MIp9yWp6dxak3mrj0LXHKv0oISdmd-1', true);
//print_r($result);exit;
//$result = $account_api->downloadMedia('GjBxqhVBvKtGN7u74bq4KQh_9uwNy_uki-Dcon1lISFGZDmh4wjq_04tmibzhXwH');
//$result = $account_api->getMaterial('Sl1720Mq2SCHWUgMNuQyre7IMLWzR-93lwzJMuJBgSA', true); //永久图片
//$result = $account_api->getMaterial('Sl1720Mq2SCHWUgMNuQyrWwsmO_TeONOCzGeUGgIp2M', true);
//$result = $account_api->getMaterial('Sl1720Mq2SCHWUgMNuQyrbqe8Xxk1WSukZn4_lAw6XQ', true); //永久图文
//$result = $account_api->getMaterial('Sl1720Mq2SCHWUgMNuQyrTtPdSr7DFjAjee6q3VhOEY'); //永久视频
$result = $account_api->delMaterial('Sl1720Mq2SCHWUgMNuQyrTtPdSr7DFjAjee6q3VhOEYddd');
print_r($result);exit;
//exit;
$thumb = $account_api->uploadMediaFixed(IA_ROOT . '/attachment/images/global/nopic.jpg', 'image');
$news = array(
	'articles' => array(
		array(
			'title' => '图文标题1',
			'author' => '作者1',
			'digest' => '摘要1',
			'content' => '内容1',
			'show_cover_pic' => true,
			'content_source_url' => 'http://baidu.com',
			'thumb_media_id' => $thumb['media_id'],
		),
	),
);
$result = $account_api->addMatrialNews($news);
print_r($result);exit;