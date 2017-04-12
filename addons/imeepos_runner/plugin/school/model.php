<?php
class schoolPlugin {
	public function getMenu(){
		$menu = array();
		$menu[] = array('url'=>'','title'=>'领快递','icon'=>'fa fa-archive');
		$menu[] = array('url'=>'','title'=>'寄快递','icon'=>'fa fa-location-arrow');
		$menu[] = array('url'=>'','title'=>'送水上楼','icon'=>'fa fa-flask');
		$menu[] = array('url'=>'','title'=>'帮我修','icon'=>'fa fa-laptop');
		$menu[] = array('url'=>'','title'=>'稍份饭','icon'=>'fa fa-coffee');
		$menu[] = array('url'=>'','title'=>'送礼物','icon'=>'fa fa-gift');
		$menu[] = array('url'=>'','title'=>'帮选课','icon'=>'fa fa-gavel');
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