<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
if($_W['isajax']){
	$listid = intval($_GPC['listid']);
	if(empty($listid)){
		 $return = error(-1,'直播id不存在、错误');
	}else{
		 $content = $_GPC['content'];
		 if(empty($content)){
		   $return = error(-1,'图文内容必须填写');
	   }else{
				if(!empty($_GPC['img_urls'])){
					$imgs = iserializer($_GPC['img_urls']);	
				}else{
					$imgs = 'no_imgs';
				}
				$data = array('weid'=>$weid,'listid'=>$listid,'content'=>$content,'createtime'=>time(),'imgs'=>$imgs,'audio'=>'no_audio');
				pdo_insert($this->live_news_table,$data);
				$return = error(0,'发布成功');
		 }
	}
	die(json_encode($return));
}