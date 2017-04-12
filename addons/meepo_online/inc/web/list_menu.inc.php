<?php

global $_W,$_GPC;
$weid = $_W['uniacid'];

load()->func('tpl');
$op = empty($_GPC['op'])? 'list':$_GPC['op'];
$listid = intval($_GPC['listid']);
if(empty($listid)){
	message('直播id不存在',$this->createWebUrl('list_manage'),'error');
}
$zhibo_list = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
if(empty($zhibo_list)){
	message('此直播不存在或是已经被删除',$this->createWebUrl('live_manage'),'error');
}
if($op=='list'){
	$menus = pdo_fetchall("SELECT * FROM ".tablename($this->listmenu_table)." WHERE weid=:weid AND listid=:listid ORDER BY displayorder ASC,createtime DESC",array(':weid'=>$weid,':listid'=>$listid));
}elseif($op=='post'){
	$id = intval($_GPC['id']);
	$menu = pdo_fetch("SELECT * FROM ".tablename($this->listmenu_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	if(empty($menu)){
		$menu = array(
			'type'=>'html',
			'isshow'=>1,
			'displayorder'=>0,
		);
		$menu['settings']['news_zan'] = 0;
		$menu['settings']['host_pass'] = '12345';
	}else{
		$menu['settings'] = iunserializer($menu['settings']);
	}
	if (checksubmit('submit')) {
		$data = array();
		$type = $_GPC['menu_type'];
		$menu_type = array('html','content','comment','button','shake','news');
		if(!in_array($type,$menu_type)){
			message('请先选择菜单类型');
		}else{
			$post_setting = array();
			if($type=='html'){
				$post_setting['iframe'] = $_GPC['iframe'];
			}elseif($type=='content'){
				$post_setting['content'] = $_GPC['menu_content'];
			}elseif($type=='comment'){
				
				$post_setting['comment_zan'] = $_GPC['comment_zan'];
				$post_setting['comment_pinglun'] = $_GPC['comment_pinglun'];
			}elseif($type=='button'){
				$post_setting['button_name'] = $_GPC['button_name'];
				$post_setting['button_url'] = $_GPC['button_url'];
			}elseif($type=='shake'){
				$post_setting['shake_times'] = intval($_GPC['shake_times']);
				$post_setting['get_one_award'] = intval($_GPC['get_one_award']);
			}elseif($type=='news'){
				$post_setting['host_img'] = $_GPC['host_img'];
				$post_setting['host_name'] = $_GPC['host_name'];
				$post_setting['host_pass'] = $_GPC['host_pass'];
				$post_setting['news_zan'] = intval($_GPC['news_zan']);
			}				
		}
		$data['type'] = $type;
		$data['listid'] = $listid;
		$data['isshow'] = intval($_GPC['isshow']);
		$data['displayorder'] = intval($_GPC['displayorder']);
		$data['name'] = $_GPC['name'];
		$data['weid'] = $weid;
		$data['settings'] = iserializer($post_setting);
		if(!empty($id)){
			pdo_update($this->listmenu_table,$data,array('id'=>$id,'weid'=>$weid));
			message('编辑成功',$this->createWebUrl('list_menu',array('listid'=>$listid)),'success');
		}else{
			$data['createtime'] = time();
			pdo_insert($this->listmenu_table,$data);
			message('新增成功',$this->createWebUrl('list_menu',array('listid'=>$listid)),'success');
		}

	}
}elseif($op=='del'){
	$id = intval($_GPC['id']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->listmenu_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
	if(empty($list)){
		message('此项不存在或是已经被删除',$this->createWebUrl('list_menu',array('listid'=>$listid)),'error');
	}else{
		pdo_delete($this->listmenu_table,array('id'=>$id,'weid'=>$weid));
	}
	message('删除成功',$this->createWebUrl('list_menu',array('listid'=>$listid)),'success');
}
include $this->template('list_menu');