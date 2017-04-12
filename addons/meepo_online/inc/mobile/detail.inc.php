<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
$listid = intval($_GPC['listid']);
if(empty($listid)){
	message('直播id错误！',$this->createMobileUrl('index'),'error');
}
$list = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND   id=:id",array(':weid'=>$weid,':id'=>$listid));
$categoryid = intval($list['categoryid']);
if(empty($list)){
	message('直播不存在或是已经被删除！',$this->createMobileUrl('index'),'error');
}
if($list['look_type']=='1'){
	if (strpos($user_agent, 'MicroMessenger') === false) {
					header("location:$gz_url");
					exit;
	}
	if(strpos($user_agent, 'WindowsWechat')){
		    header("location:$gz_url");
			  exit;
	}
}
$need_pay = 0;
if($list['need_pay']=='1'){
	$check_had_pay = pdo_fetchcolumn("SELECT `id` FROM ".tablename($this->online_pay_record)." WHERE listid=:listid AND openid=:openid AND weid=:weid AND status=:status",array(':listid'=>$listid,':openid'=>$openid,':weid'=>$weid,':status'=>'1'));
	if(empty($check_had_pay)){
		$need_pay = 1;
	}
}
$need_code = 0;
if($list['need_pay']=='2'){
	$check_had_code = pdo_fetchcolumn("SELECT `id` FROM ".tablename($this->online_code_record)." WHERE listid=:listid AND openid=:openid AND weid=:weid",array(':listid'=>$listid,':openid'=>$openid,':weid'=>$weid));
	if(empty($check_had_code)){
		$need_code = 1;
	}
}
$need_input = 0;
$need_input_arr = array();
if($list['need_pay']=='3'){
	$need_info = pdo_fetchcolumn("SELECT `need_info` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
	$need_info  = iunserializer($need_info);
	if(empty($need_info)){
		$need_input = 1;
		$need_input_arr = pdo_fetchall("SELECT * FROM ".tablename($this->need_input_table)." WHERE weid=:weid AND listid=:listid   ORDER BY displayorder ASC,createtime DESC",array(':weid' =>$weid,':listid'=>$listid));
		
	}
}
$menus = pdo_fetchall("SELECT * FROM ".tablename($this->listmenu_table)." WHERE weid=:weid AND listid=:listid AND isshow=:isshow  ORDER BY displayorder ASC,createtime DESC",array(':weid'=>$weid,':listid'=>$listid,':isshow'=>'1'));
if(empty($menus)){
	message('请先添加自定义直播菜单',$this->createMobileUrl('index'),'error');
}
if(count($menus) > 4){
	message('可显示的自定义直播菜单最多4个、请重新设置',$this->createMobileUrl('index'),'error');
}
$had_shake_time = pdo_fetchcolumn("SELECT COUNT(*)	FROM ".tablename($this->shake_record_table)." WHERE weid=:weid AND openid=:openid AND listid=:listid",array(':weid'=>$weid,':openid'=>$openid,':listid'=>$listid));
if($list['gift_show']=='1'){
	$ggifts = pdo_fetchall("SELECT * FROM ".tablename($this->gift_table)." WHERE weid=:weid AND listid=:listid   ORDER BY displayorder ASC,createtime DESC",array(':weid'=>$weid,':listid'=>$listid));
	$gifts = array();
	if(!empty($ggifts)){
		foreach($ggifts as $row){
			$row['nums'] = pdo_fetchcolumn("SELECT SUM(num) FROM ".tablename($this->pinglun_table)." WHERE type=:type AND listid=:listid AND weid=:weid AND status=:status",array(':type'=>intval($row['id']),':listid'=>$listid,':weid'=>$weid,':status'=>'1'));
			$gifts[] = $row;
		}
	}
	$gifts_person = count(pdo_fetchall("SELECT DISTINCT openid FROM ".tablename($this->pinglun_table)." WHERE listid=:listid AND weid=:weid  AND status=:status AND type!=:type1 AND type!=:type2",array(':listid'=>$listid,':weid'=>$weid,':status'=>'1',':type1'=>'0',':type2'=>'redpack')));
}
$wechat_pay = uni_setting($weid, array('payment'));

if(!is_array($wechat_pay['payment']['wechat']) || empty($wechat_pay['payment']['wechat']['switch'])){
	$can_pay = 0;	
}else{
  $can_pay = 1;
}
$list_user_id = pdo_fetchcolumn("SELECT `id` FROM ".tablename($this->list_user_table)." WHERE openid = :openid AND weid=:weid AND listid=:listid",array(':openid' =>$openid,':weid' =>$weid,':listid'=>$listid));
$fatherid = intval($_GPC['fd']);
if(empty($list_user_id)){
	$new_user = array(
		'openid' =>$openid,
		'weid'=>$weid,
		'createtime'=>time(),
		'avatar'=>$user['avatar'],
		'nickname'=>$user['nickname'],
		'sex'=>intval($user['sex']),
		'categoryid'=>$categoryid,
		'listid'=>$listid,
		'cansay'=>0,
		'father_id'=>$fatherid,
	);
	pdo_insert($this->list_user_table,$new_user);
	$list_user_id = pdo_insertid();

}

$see_user = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->list_user_table)." WHERE weid=:weid AND listid=:listid",array(':weid' =>$weid,':listid'=>$listid));
$see_user = intval($see_user) + intval($list['live_persons']);
$pingluns = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid  AND status=:status ORDER BY createtime DESC LIMIT 0,8",array(':weid'=>$weid,':listid'=>$listid,':status'=>'1'));
$ping_nums = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid  AND status=:status",array(':weid'=>$weid,':listid'=>$listid,':status'=>'1')));
$zan_nums = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->zan_table)." WHERE weid=:weid AND listid=:listid",array(':weid'=>$weid,':listid'=>$listid)));
$comment_html = '';
if(is_array($pingluns) && !empty($pingluns)){
		foreach($pingluns as $key=>$row){
						if($row['type']=='redpack'){
							$content='<span style="color: red">送出 <img class="gift_img" style="width: 20px;height: 20px;vertical-align: middle;" src="../addons/meepo_online/template/mobile/images/redpack.png"> '.$row['money'].'元红包</span>';
						}elseif($row['type']=='0'){
							$content=$this->emo($row['content']);
						}else{
							$gift_img = tomedia(pdo_fetchcolumn("SELECT `img` FROM ".tablename($this->gift_table)." WHERE id=:id AND listid=:listid AND weid=:weid",array(':id'=>intval($row['type']),':listid'=>$listid,':weid'=>$weid)));
							$content='<span style="color: red">送出 <img class="gift_img" style="width: 20px;height: 20px;vertical-align: middle;" src="'.$gift_img.'"> '.$row['content'].'、数量'.$row['num'].'</span>';						
						}	
						
					
						$comment_html .= 
						'<li class="comment clearfix"><img src="'.$row['avatar'].'" class="cmt-ava" />
							<p class="cmt-info">
							<span class="cmt-user">'.$row['nickname'].'</span>
							<span class="cmt-time">'.date("Y-m-d H:i:s",$row['createtime']).'</span>
							</p>
							<div class="cmt-content">'.$content.'</div>
						</li>';
		}
}
//get news
$nnews = pdo_fetchall("SELECT * FROM ".tablename($this->live_news_table)." WHERE weid=:weid AND listid=:listid  ORDER BY createtime DESC LIMIT 0,5",array(':weid'=>$weid,':listid'=>$listid));
$news = array();
if(is_array($nnews) && !empty($nnews)){
		foreach($nnews as $row){
					$row['pl_nums'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_reply)." WHERE weid=:weid AND listid=:listid AND newsid=:newsid",array(':weid'=>$weid,':listid'=>$listid,':newsid'=>$row['id']));
					$row['zan_nums'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_zan)." WHERE weid=:weid AND listid=:listid AND newsid=:newsid",array(':weid'=>$weid,':listid'=>$listid,':newsid'=>$row['id']));
					$news[] = $row;
		}
}
$news_nums = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_table)." WHERE weid=:weid AND listid=:listid",array(':weid'=>$weid,':listid'=>$listid));
$news_pl_nums = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_reply)." WHERE weid=:weid AND listid=:listid",array(':weid'=>$weid,':listid'=>$listid)));
$news_zan_nums = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_zan)." WHERE weid=:weid AND listid=:listid",array(':weid'=>$weid,':listid'=>$listid)));
$check_yuyue = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->my_live_table)." WHERE openid=:openid AND listid=:listid AND weid=:weid",array(':openid'=>$openid,':listid'=>$listid,':weid'=>$weid));
if($_W['container']=='windows' || $_W['container']=='unknown'){
	$top_user = pdo_fetchall("SELECT `nickname`,`avatar` FROM ".tablename($this->list_user_table)." WHERE weid=:weid AND listid=:listid ORDER BY createtime DESC LIMIT 0,10",array(':weid'=>$weid,':listid'=>$listid));
	$pinglun_top12 = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid  AND status=:status ORDER BY createtime DESC LIMIT 0,12",array(':weid'=>$weid,':listid'=>$listid,':status'=>'1'));
	include $this->template('detail_pc');
}else{
	include $this->template('detail');
}
