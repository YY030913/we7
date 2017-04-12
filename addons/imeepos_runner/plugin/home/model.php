<?php
class homePlugin extends Imeepos_runnerModuleSite{
	public $__define = __DIR__;
	
    public function getMenu (){
    	$menu = array();
    	$menu[] = array('url'=>$_W['siteurl'].'/app/'.$this->createMobileUrl('plugin',array('mp'=>'home','mdo'=>'index')),'title'=>'个人中心入口','icon'=>'fa fa-paper-plane');
    	return $menu;
    }

    public function getMenu2 (){
    	$menu = array();
    	$menu[] = array('url'=>$_W['siteurl'].'/web/'.$this->createWebUrl('plugin',array('mp'=>'home','mdo'=>'template')),'title'=>'个人中心设置','icon'=>'fa fa-cog');
    	return $menu;
    }
}