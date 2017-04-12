<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$listid = $_GPC['listid'];
if(empty($listid)){
	message('错误、没有直播id',referer(),'error');
}
$qr_url = str_replace('./','',$_W['siteroot'].'app/'.$this->createMobileUrl('detail',array('listid'=>$listid)));
$send_url = str_replace('./','',$_W['siteroot'].'app/'.$this->createMobileUrl('news_send',array('listid'=>$listid)));
include $this->template('how_do');
