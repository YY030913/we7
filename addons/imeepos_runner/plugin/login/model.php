<?php
class loginPlugin extends Imeepos_runnerModuleSite{

	public $mp = 'login';

	public function getMenu(){
		$menu = array();
		$menu[] = array('url'=>$_W['siteroot'].'/app/'.$this->createMobileUrl('plugin',array('mp'=>'login','mdo'=>'login')),'title'=>'登陆入口','icon'=>'fa fa-file');
		return $menu;
	}
	
	public function getMenu2(){
		$menu = array();
		$menu[] = array('url'=>$this->createWebUrl('plugin',array('mp'=>$this->mp,'mdo'=>'setting')),'title'=>'基础设置','icon'=>'fa fa-cog');
		return $menu;
	}
	
	public function __exec($mp,$mdo,$ismobile=true){
		include MODULE_ROOT.'/plugin/'.$mp.'/inc/'.($ismobile?'mobile/':'web/').$mdo.'.php';
	}
}