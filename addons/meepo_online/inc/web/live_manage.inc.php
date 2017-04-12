<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$op = empty($_GPC['op'])? 'list':$_GPC['op'];
if($op=='list'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$llists = pdo_fetchall("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid ORDER BY createtime DESC,displayorder ASC  LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':weid'=>$weid));
	$list = array();
	if(!empty($llists)){
		foreach($llists as $row){
			$row['say_user'] = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->list_user_table)." WHERE weid=:weid AND listid=:listid",array(':weid' =>$weid,':listid'=>$row['id']));
			$lists[] = $row;
		}
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->list_table) . " WHERE weid=:weid", array(':weid'=>$weid));
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='post'){
	$categorys = pdo_fetchall("SELECT * FROM ".tablename($this->category_table)." WHERE weid=:weid",array(':weid'=>$weid));
	if(empty($categorys)){
		message('请先添加分类',$this->createWebUrl('category_manage',array('op'=>'post')),'error');
	}
	load()->func('tpl');
	$id = intval($_GPC['id']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	if(empty($list)){
		$list = array(
			'type'=>1,
			'no_start_type'=>3,
			'end_type'=>3,
			'isshow'=>1,
			'status'=>0,
			'cansay'=>0,
			'zan_style'=>0,
			'dashang_show'=>1,
			'gift_show'=>1,
			'dashang_limit'=>1,
			'gift_pay_detail'=>1,
			'live_persons'=>500,
			'need_pay'=>0,
			'djs_txt_color'=>'#ffffff',
			'thumb_time'=>5,
				'look_code'=>'12345',
			'look_type'=>0,
			'shake_show'=>1,
			'shake_must_address'=>1,
			'gift_flower'=>2,
			'dashang_flower'=>2,
			'newjoin_flower'=>2,
			'gift_music'=>'../addons/meepo_online/template/mobile/music/dashang_success.mp3',
			'newjoin_music'=>'../addons/meepo_online/template/mobile/music/new_join.mp3',
			'dashang_music'=>'../addons/meepo_online/template/mobile/music/dashang_success.mp3',
					'top_bj'=>'../addons/meepo_online/template/mobile/images/header.png',
			'shake_bg_img'=>'../addons/meepo_online/template/mobile/images/shake-yes.gif',
			'player_height'=>180,
			'yuyue_show'=>1,
			'put_mobile'=>1,
			'sms_mobile'=>1,
			'main_color'=>'#ff6a00',
		);
	}
	if (checksubmit('submit')) {
			
		$data = array();
		$data['type'] = intval($_GPC['type']);
		$data['cansay'] = intval($_GPC['cansay']);
		$data['status'] = intval($_GPC['status']);
		$data['dashang_show'] = intval($_GPC['dashang_show']);
		$data['gift_pay_detail'] = intval($_GPC['gift_pay_detail']);
		
		$data['thumb_time'] = intval($_GPC['thumb_time']);
		$data['gift_show'] = intval($_GPC['gift_show']);
		$data['dashang_limit'] = $_GPC['dashang_limit'];
		$data['weid'] = $weid;
		$data['open_img'] = $_GPC['open_img'];
		$data['img'] = $_GPC['img'];
		$data['main_color'] = $_GPC['main_color'];
		$data['title'] = $_GPC['title'];
		$data['content'] = $_GPC['content'];
		$data['open_img'] = $_GPC['open_img'];
		$data['activity_id'] = $_GPC['activity_id'];
		$data['activity_uu'] = $_GPC['activity_uu'];
		$data['activity_vu'] = $_GPC['activity_vu'];
		$data['activity_pu'] = $_GPC['activity_pu'];
		$data['yt_iframe'] = $_GPC['yt_iframe'];
		$data['local_media'] = $_GPC['local_media'];
		$data['no_start_activity_id'] = $_GPC['no_start_activity_id'];
		$data['no_start_activity_uu'] = $_GPC['no_start_activity_uu'];
		$data['no_start_activity_vu'] = $_GPC['no_start_activity_vu'];
		$data['no_start_activity_pu'] = $_GPC['no_start_activity_pu'];
		$data['no_start_yt_iframe'] = $_GPC['no_start_yt_iframe'];
		$data['no_start_local_media'] = $_GPC['no_start_local_media'];
		$data['end_local_media'] = $_GPC['end_local_media'];
		$data['end_activity_id'] = $_GPC['end_activity_id'];
		$data['end_activity_uu'] = $_GPC['end_activity_uu'];
		$data['end_activity_vu'] = $_GPC['end_activity_vu'];
		$data['end_activity_pu'] = $_GPC['end_activity_pu'];
		$data['end_yt_iframe'] = $_GPC['end_yt_iframe'];
		$data['end_local_media'] = $_GPC['end_local_media'];
		$data['marqueen_words'] = $_GPC['marqueen_words'];
		$data['description'] = $_GPC['description'];
		$data['live_logo'] = $_GPC['live_logo'];
		$data['share_title'] = $_GPC['share_title'];
		$data['share_content'] = $_GPC['share_content'];
		$data['share_img'] = $_GPC['share_img'];
		//$data['award_tpl'] = $_GPC['award_tpl'];
		//$data['consumer_tpl'] = $_GPC['consumer_tpl'];
		//$data['yuyue_tpl'] = $_GPC['yuyue_tpl'];
		//$data['yuyue_customer_img'] = $_GPC['yuyue_customer_img'];
		//$data['award_customer_img'] = $_GPC['award_customer_img'];
		//$data['consumer_customer_img'] = $_GPC['consumer_customer_img'];
		$data['open_img_url'] = $_GPC['open_img_url'];
		$data['djs_txt_color'] = $_GPC['djs_txt_color'];
		
		$data['isshow'] = intval($_GPC['isshow']);
		$data['categoryid'] = intval($_GPC['categoryid']);
		$data['live_persons'] = intval($_GPC['live_persons']);
		$data['shake_show'] = intval($_GPC['shake_show']);
		$data['shake_must_address'] = intval($_GPC['shake_must_address']);
		$data['gift_flower'] = intval($_GPC['gift_flower']);
		$data['dashang_flower'] = intval($_GPC['dashang_flower']);
		$data['player_height'] = intval($_GPC['player_height']);
		$data['gift_music'] = $_GPC['gift_music'];
		$data['dashang_music'] = $_GPC['dashang_music'];
		$data['newjoin_music'] = $_GPC['newjoin_music'];
		$data['shake_bg_img'] = $_GPC['shake_bg_img'];
		
		$data['end_type'] = intval($_GPC['end_type']);
		$data['no_start_type'] = intval($_GPC['no_start_type']);
		$data['newjoin_flower'] = intval($_GPC['newjoin_flower']);
		$data['yuyue_show'] = intval($_GPC['yuyue_show']);
			$data['put_mobile'] = intval($_GPC['put_mobile']);
			$data['sms_mobile'] = intval($_GPC['sms_mobile']);
		if($data['categoryid']=='0'){
			message('请选择直播分类');
		}
		
		$data['start_time'] = strtotime($_GPC['ac_times']['start']);
		$data['end_time'] = strtotime($_GPC['ac_times']['end']);
		$data['displayorder'] = intval($_GPC['displayorder']);
		$data['zan_style'] = intval($_GPC['zan_style']);
		$data['need_pay'] = intval($_GPC['need_pay']);
		$data['look_type'] = intval($_GPC['look_type']);
		$data['top_bj'] = $_GPC['top_bj'];
		$data['pay_money'] = $_GPC['pay_money'];
		$data['look_code'] = $_GPC['look_code'];
		$advs = array();
		if (is_array($_GPC['adv_id']) && !empty($_GPC['adv_id'])) {
			foreach ($_GPC['adv_id'] as $key => $value ) {
				$advs[] = array('adv_id'=>$value,'adv_type'=>$_GPC[$value.'adv_type'],'adv_text'=>$_GPC['adv_text'][$key],'adv_url'=>$_GPC['adv_url'][$key],'adv_img'=>$_GPC['adv_img'][$key]);
			}
		}
		$no_start_advs = array();
		if (is_array($_GPC['no_start_id']) && !empty($_GPC['no_start_id'])) {
			foreach ($_GPC['no_start_id'] as $key => $value ) {
				$no_start_advs[] = array('no_start_id'=>$value,'live_nostart_img'=>$_GPC['live_nostart_img'][$key],'live_nostart_url'=>$_GPC['live_nostart_url'][$key]);
			}
		}
		$end_advs = array();
		if (is_array($_GPC['end_id']) && !empty($_GPC['end_id'])) {
			foreach ($_GPC['end_id'] as $key => $value ) {
				$end_advs[] = array('end_id'=>$value,'live_end_img'=>$_GPC['live_end_img'][$key],'live_end_url'=>$_GPC['live_end_url'][$key]);
			}
		}
		$live_advs = array();
		if (is_array($_GPC['live_on_id']) && !empty($_GPC['live_on_id'])) {
			foreach ($_GPC['live_on_id'] as $key => $value ) {
				$live_advs[] = array('live_on_id'=>$value,'live_on_img'=>$_GPC['live_on_img'][$key],'live_on_url'=>$_GPC['live_on_url'][$key]);
			}
		}
		$data['live_advs'] = iserializer($live_advs);
		$data['end_advs'] = iserializer($end_advs);
		$data['no_start_advs'] = iserializer($no_start_advs);
		$data['advs'] = iserializer($advs);
		
		if(!empty($id)){
			pdo_update($this->list_table,$data,array('id'=>$id,'weid'=>$weid));
			message('编辑成功',referer(),'success');
		}else{
			$data['createtime'] = time();
			pdo_insert($this->list_table,$data);
			message('新增成功',$this->createWebUrl('live_manage'),'success');
		}

	}
}elseif($op=='del'){
	$id = intval($_GPC['id']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	if(empty($list)){
		message('此项不存在或是已经被删除',$this->createWebUrl('live_manage'),'error');
	}else{
		pdo_delete($this->listmenu_table,array('listid'=>$id,'weid'=>$weid));
		pdo_delete($this->gift_table,array('listid'=>$id,'weid'=>$weid));
		pdo_delete($this->shake_record_table,array('listid'=>$id,'weid'=>$weid));
		pdo_delete($this->shake_award_table,array('listid'=>$id,'weid'=>$weid));
		pdo_delete($this->zan_table,array('listid'=>$id,'weid'=>$weid));
		pdo_delete($this->pinglun_table,array('listid'=>$id,'weid'=>$weid));
		pdo_delete($this->list_user_table,array('listid'=>$id,'weid'=>$weid));
		pdo_delete($this->list_table,array('id'=>$id,'weid'=>$weid));
	}
	message('删除成功',$this->createWebUrl('live_manage'),'success');
}elseif($op=='jingxuan'){
	$id = intval($_GPC['id']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	$is_best = intval($_GPC['is_best']);
	if(empty($list)){
		die(json_encode(error('-1','error')));
	}else{
		if($is_best){
			$is_best = 0;
		}else{
			$is_best = 1;
		}
		pdo_update($this->list_table,array('is_best'=>$is_best),array('id'=>$id,'weid'=>$weid));
		die(json_encode(error('0','success')));
	}
}
include $this->template('live_manage');