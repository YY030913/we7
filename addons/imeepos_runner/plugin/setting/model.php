<?php
class settingPlugin extends Imeepos_runnerModuleSite{
	
	public function hasMobile(){
		return false;
	}
	public function getMenu(){
		return '';
	}
	public function getMenu2 (){
		$menu = array();
		$menu[] = array('url'=>$this->createWebUrl('plugin',array('mp'=>'setting','mdo'=>'setting')),'title'=>'系统设置','icon'=>'fa fa-bolt');
		return $menu;
	}
}