<?php
class xiaoquPlugin {
	public function getMenu(){
		$menu = array();
		$menu[] = array('url'=>'','title'=>'送水上楼','icon'=>'fa fa-flask');
		$menu[] = array('url'=>'','title'=>'帮我修','icon'=>'fa fa-legal');
		$menu[] = array('url'=>'','title'=>'帮我装','icon'=>'fa fa-laptop');
		$menu[] = array('url'=>'','title'=>'帮我送','icon'=>'fa fa-car');
		$menu[] = array('url'=>'','title'=>'帮我买','icon'=>'fa fa-gift');
		$menu[] = array('url'=>'','title'=>'作业辅导','icon'=>'fa fa-graduation-cap');
		$menu[] = array('url'=>'','title'=>'老人陪护','icon'=>'fa fa-wheelchair');
		$menu[] = array('url'=>'','title'=>'紧急互助','icon'=>'fa fa-paw');
		return $menu;
	}
	public function getMenu2(){
		$menu = array();
		$menu[] = array('url'=>'','title'=>'临时工','icon'=>'fa fa-bolt');
		$menu[] = array('url'=>'','title'=>'正式工','icon'=>'fa fa-group');
		$menu[] = array('url'=>'','title'=>'系统设置','icon'=>'fa fa-cog');
		return $menu;
	}
}