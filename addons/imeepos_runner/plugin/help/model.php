<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/5
 * Time: 14:18
 */

class helpPlugin extends Imeepos_runnerModuleSite{
	
	public $mp = 'help';
	
	public function getMenu(){
		$menu = array();
		return $menu;
	}
	
	public function getMenu2(){
		$menu = array();
		$menu[] = array('url'=>$this->createWebUrl('plugin',array('mp'=>$this->mp,'mdo'=>'help')),'title'=>'使用手册','icon'=>'fa fa-cog');
		$menu[] = array('url'=>$this->createWebUrl('plugin',array('mp'=>$this->mp,'mdo'=>'deve')),'title'=>'开发手册','icon'=>'fa fa-cog');
		$menu[] = array('url'=>$this->createWebUrl('plugin',array('mp'=>$this->mp,'mdo'=>'qus')),'title'=>'常见问题','icon'=>'fa fa-cog');
		$menu[] = array('url'=>$this->createWebUrl('plugin',array('mp'=>$this->mp,'mdo'=>'post')),'title'=>'工单提交','icon'=>'fa fa-cog');
		return $menu;
	}
}