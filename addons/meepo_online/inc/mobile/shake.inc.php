<?php
global $_W,$_GPC;
$openid = $_W['openid'];
$weid = $_W['uniacid'];
if($_W['isajax']){
	$listid = intval($_GPC['listid']);
	if(empty($listid)){
			die(json_encode(error('-1','直播id错误！')));
	}
	
	$check_shake = pdo_fetch("SELECT `settings` FROM ".tablename($this->listmenu_table)." WHERE weid=:weid AND listid=:listid AND type=:type",array(':weid'=>$weid,':listid'=>$listid,':type'=>'shake'));
	if(empty($check_shake)){
		die(json_encode(error('-2','直播未开启摇一摇功能！')));
	}else{
		$settings = iunserializer($check_shake['settings']);
		if($settings['get_one_award']=='1'){
				$award_record = pdo_fetchcolumn("SELECT COUNT(*)	FROM ".tablename($this->shake_record_table)." WHERE weid=:weid AND openid=:openid AND listid=:listid AND award_id!=:award_id",array(':weid'=>$weid,':openid'=>$openid,':listid'=>$listid,':award_id'=>'0'));
				if($award_record > 0){
					die(json_encode(error('-2','你已经中过奖啦！')));
				}
		}
		if($settings['shake_times'] > 0){
				$had_shake_time = pdo_fetchcolumn("SELECT COUNT(*)	FROM ".tablename($this->shake_record_table)." WHERE weid=:weid AND openid=:openid AND listid=:listid",array(':weid'=>$weid,':openid'=>$openid,':listid'=>$listid));
				if($had_shake_time >= $settings['shake_times']){
					die(json_encode(error('-3','你的机会已经用完了、下次再来吧！')));
				}
		}
	}
	$user =  pdo_fetch("SELECT `nickname`,`avatar`,`id`,`mobile`,`realname`,`address` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	if(empty($user)){
		die(json_encode(error('-4','您的资料不存在')));
	}else{
			$awards = pdo_fetchall("SELECT  * FROM " . tablename($this->shake_award_table) . " WHERE weid=:weid AND listid=:listid ORDER BY gailv ASC", array(":weid" =>$weid,':listid'=>$listid));
			$arrayRand = array();
			$totalRand = 0;
			$length = count($awards);
			for ($index = 0; $index < $length; $index++) {
				$arrayRand[$index] = $awards[$index]['gailv'];
				$totalRand += $arrayRand[$index];
			}
			$arrayRand[$length] = 100 - $totalRand;//无法中奖的概率
			$pIndex = $this->get_rand($arrayRand);//随机
			$return = array();
			$data = array();
			$data['listid'] = $listid;
			$data['createtime'] = time();
			$data['weid'] = $weid;
			$data['openid'] = $openid;
			$data['nickname'] = $user['nickname'];
			$data['avatar'] = $user['avatar'];
			if($settings['shake_times'] > 0){
				$have_chance =  $settings['shake_times'] - $had_shake_time - 1;	
			}else{
				$have_chance =  '无数';
			}
			if ($pIndex == $length) {//not get
				pdo_insert($this->shake_record_table,$data);
				
				$return['errno'] = '-5';
				$return['message'] = '很遗憾、没有中奖呢';
				$return['have_chance'] = $have_chance;
				die(json_encode($return));
			} else {//get
				$award = $awards[$pIndex];
				if ($award['had_get_num'] >= $award['num'] ) { //over award nums
					pdo_insert($this->shake_record_table,$data);
					$return['errno'] = '-5';
					$return['message'] = '很遗憾、没有中奖呢';
					$return['have_chance'] = $have_chance;
					die(json_encode($return));
				}else{//can award
					$data['award_id'] = intval($award['id']);
					pdo_insert($this->shake_record_table,$data);
					pdo_query("UPDATE ".tablename($this->shake_award_table)." SET had_get_num = had_get_num +1 WHERE weid = :weid AND listid=:listid AND id=:id",array(':weid'=>$weid,':listid'=>$listid,':id'=>$award['id']));
					
					$data_url = $this->createMobileUrl('detail',array('listid'=>$listid));
					$live_list = pdo_fetch("SELECT `title` FROM ".tablename($this->list_table)." WHERE weid=:weid  AND  id=:id",array(':weid'=>$weid,':id'=>$listid));
					$news_config =  iunserializer(pdo_fetchcolumn("SELECT `settings` FROM ".tablename($this->setting_table)." WHERE weid=:weid",array(':weid' =>$weid)));
					$data_title = '恭喜您参与'.$live_list['title'].'摇一摇活动中奖啦！';
					$data_content = $award['name'];
					$tpl_data = array();
					$tpl_data['first'] = array('value'=>$data_title, 'color'=>'#173177');
					$tpl_data['keyword1'] = array('value'=>$live_list['title'], 'color'=>'#173177');
					$tpl_data['keyword2'] = array('value'=> $data_content, 'color'=>'#173177');
					$tpl_data['remark'] = array('value'=>"感谢您的参与!", 'color'=>'#173177');
					$true_content = "奖品名称: ".$award['name'];
					$this->mc_notice_consume($news_config['award_tpl'],$tpl_data,$openid, $data_title, $true_content, $data_url,$news_config['award_customer_img']);
					$return['errno'] = '1';
					$return['name'] = $award['name'];
					$return['img'] = tomedia($award['img']);
					if($award['type']=='0'){
						$return['need_input'] = 0;
						$return['get_url'] = $award['get_url'];
					}else{
						$return['need_input'] = 0;
						$return['get_url'] = '';
					}
					$return['have_chance'] = $have_chance;
					die(json_encode($return));
				}
			}
	}
}

