<?php
class templatePlugin extends Imeepos_runnerModuleSite{
    public function getMenu (){
    	$item = array();
    	
    	return $item;
    }

    public function getMenu2 (){
		$menu = array();
		$menu[] = array('url'=>$this->createWebUrl('plugin',array('mp'=>'template','mdo'=>'template')),'title'=>'模板管理','icon'=>'fa fa-bolt');
		return $menu;
    }
}