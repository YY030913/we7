<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$menus = pdo_fetchall("SELECT * FROM ".tablename($this->footer_menu_table)." WHERE weid=:weid ORDER BY displayorder ASC",array(':weid'=>$weid));
if($_W['ispost']){
	$name = $_GPC['name'];
	if(!empty($name) && is_array($name)){
		pdo_delete($this->footer_menu_table,array('weid'=>$weid));
		foreach($name as $key=>$row){
				pdo_insert($this->footer_menu_table,array('displayorder'=>$_GPC['displayorder'][$key],'name'=>$row,'url'=>$_GPC['url'][$key],'icon'=>$_GPC['icon'][$key],'isshow'=>$_GPC['isshow'][$key],'weid'=>$weid));
		}
		message('菜单保存成功',referer(),'success');
	}
}
include $this->template('footer_menu');