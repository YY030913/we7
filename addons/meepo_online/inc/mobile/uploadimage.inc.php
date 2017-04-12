<?php
global $_W,$_GPC;
		$weid = $_W['uniacid'];
		if(empty($_GPC['id'])){
		  die(json_encode(error(-1,'上传失败')));
		}
		load()->func('communication');
		$access_token =  $this->getAccessToken();
		$url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$access_token.'&media_id='.$_GPC['id'];
		$pic_data = ihttp_request($url);
		$path = "images/meepo_online/".$weid."/";
		load()->func('file');
		$picurl = $path.random(30) .".jpg";
		file_write($picurl,$pic_data['content']);
		if (!empty($_W['setting']['remote']['type'])) { 
			$remotestatus = file_remote_upload($picurl); 
			if (is_error($remotestatus)) {
				$data = error(-1,'远程附件上传失败、请检查！');
				die(json_encode($data));
			} else {
				die(json_encode(error(0,tomedia($picurl))));
			}
		}else{
			die(json_encode(error(0,tomedia($picurl))));
		}
		