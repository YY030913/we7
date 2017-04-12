<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$settings =  iunserializer(pdo_fetchcolumn("SELECT `settings` FROM ".tablename($this->setting_table)." WHERE weid=:weid",array(':weid' =>$weid)));

$gz_url = $settings['gz_url'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if (strpos($user_agent, 'MicroMessenger') === false) {
			$openid = $ip = CLIENT_IP;
			$user =  pdo_fetch("SELECT * FROM ".tablename($this->user_table)." WHERE openid = :openid AND weid=:weid",array(':openid' =>$ip,':weid' =>$weid));
			if(empty($user)){
				if(empty($ip)){
					header("location:$gz_url");
					exit;
				}
				$ip_address = $this->ip();
				if($ip_address['code']!=0){
						header("location:$gz_url");
						exit;
				}
				$web_data = array(
					'openid' =>$ip,
					'weid'=>$weid,
					'createtime'=>time(),
					'newjointime'=>time(),
					'avatar'=> tomedia($settings['no_avatar']),
					'nickname'=>empty($ip_address['data']['region'])?'网友':$ip_address['data']['region'].'网友',
					'sex'=>0,
				);
				pdo_insert($this->user_table,$web_data); 
				$user_id = pdo_insertid();
				$user =  pdo_fetch("SELECT * FROM ".tablename($this->user_table)." WHERE id = :id  AND weid=:weid",array(':id'=>$user_id,':weid' =>$weid));
			}else{
				pdo_update($this->user_table,array('newjointime'=>time()),array('openid'=>$ip,'weid' =>$weid));
			}
} else {
	$openid = $_W['openid'];
	if(empty($openid)){
		header("location:$gz_url");
		exit;
	}
	$user =  pdo_fetch("SELECT * FROM ".tablename($this->user_table)." WHERE openid = :openid AND weid=:weid",array(':openid' =>$openid,':weid' =>$weid));
	if(empty($user)){
		$data = array(
			'openid' =>$openid,
			'weid'=>$weid,
			'createtime'=>time(),
			'newjointime'=>time(),
		);
		if($_W['account']['level']<3){
			load()->model('mc');
			$oauth_user = mc_oauth_userinfo();
			if (!is_error($oauth_user) && !empty($oauth_user) && is_array($oauth_user)) {
						$userinfo = $oauth_user;
			}else{
						message("借用oauth失败");
			}
		}elseif($_W['account']['level']==3){
			if($settings['gz_must']=='0'){
							load()->model('mc');
							$oauth_user = mc_oauth_userinfo();
							if (!is_error($oauth_user) && !empty($oauth_user) && is_array($oauth_user)) {
										$userinfo = $oauth_user;
							}else{
										message("借用oauth失败");
							}
			}else{
				if($_W['fans']['follow']=='1'){
							$userinfo = $this->get_follow_fansinfo($openid);
							if($userinfo['subscribe']!='1'){
								message('获取粉丝信息失败');
							}
				}else{
								header("location:$gz_url");
								exit;
				}
			}
		}else{
				if($_W['fans']['follow']=='1'){
						$userinfo = $this->get_follow_fansinfo($openid);
						if($userinfo['subscribe']!='1'){
							
							message('获取粉丝信息失败');
						}
				}else{
						if($settings['gz_must']=='0'){
							$oauth_user = mc_oauth_userinfo();
							if (!is_error($oauth_user) && !empty($oauth_user) && is_array($oauth_user)) {
										$userinfo = $oauth_user;
							}else{
										message("借用oauth失败");
							}
						}else{
							header("location:$gz_url");
							exit;
						}
				}
		}
		if(!empty($userinfo['avatar'])){
			 $data['avatar'] = $userinfo['avatar'];
		}else{
			if(empty($userinfo['headimgurl'])){
			 $data['avatar'] = tomedia($settings['no_avatar']);
			}else{
				$data['avatar'] = $userinfo['headimgurl'];
			}
		}
		if(empty($userinfo['sex'])){
			$data['sex'] = '0';
		}else{
			$data['sex'] = $userinfo['sex'];
		}
		if(!empty($userinfo['nickname'])){
			$data['nickname'] = $userinfo['nickname'];
		}else{
			$data['nickname'] = '微信昵称无法识别';
		}
		pdo_insert($this->user_table,$data); 
		$user_id = pdo_insertid();
		$user =  pdo_fetch("SELECT * FROM ".tablename($this->user_table)." WHERE id = :id  AND weid=:weid",array(':id'=>$user_id,':weid' =>$weid));
	}else{
		pdo_update($this->user_table,array('newjointime'=>time()),array('openid'=>$openid,'weid' =>$weid));
	}
}



  

