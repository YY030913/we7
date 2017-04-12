<?php
/**
 * 人人快递模块定义
 *
 * @author imeepos
 * @url http://bbs.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');

class imeepos_runnerModule extends WeModule {
	public function __construct(){
		global $_W,$_GPC;
		if($_W['os'] == 'mobile') {

		} else {
			$do = $_GPC['do'];
			$doo = $_GPC['doo'];
			$act = $_GPC['act'];
			global $frames;
			$frames = getModuleFrames('imeepos_runner');
			_calc_current_frames2($frames);
		}
	}
	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		$setting = $this->module['config'];
		$setting = $this->module['config'];
		$path = IA_ROOT . '/addons/imeepos_runner/template/mobile/';
		
		if (is_dir($path)) {
			$apis = array();
			if ($handle = opendir($path)) {
				while (false !== ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
						$stylesResults[] = $file;
					}
				}
			}
		}
		$items = array();
		load()->func('file');
		foreach ($stylesResults as $item){
			if($item != 'default'){
				$file = $path.$item.'/config.php';
				unlink($file);
			}
			if(file_exists($path.$item.'/config.php')){
				require_once $path.$item.'/config.php';
				$items[] = $config;
			}
		}
		if(!empty($_GPC['name'])){
			$dat = array();
			$dat['name'] = $_GPC['name'];
			$this->saveSettings($dat);
			message('模板设置成功',referer(),'success');
		}
		include $this->template('setting');
	}

}


function getModuleFrames($name){
	global $_W;
	$sql = "SELECT * FROM ".tablename('modules')." WHERE name = :name limit 1";
	$params = array(':name'=>$name);
	$module = pdo_fetch($sql,$params);

	$sql = "SELECT * FROM ".tablename('modules_bindings')." WHERE module = :name ";
	$params = array(':name'=>$name);
	$module_bindings = pdo_fetchall($sql,$params);

	$frames = array();

	$frames['set']['title'] = '基础设置';
	$frames['set']['active'] = '';

	$frames['set']['items'] = array();

	$frames['manage']['title'] = '运营管理';
	$frames['manage']['active'] = '';
	$frames['manage']['items'] = array();

	$frames['set']['items']['divider_set']['url'] = url('site/entry/divider_set',array('m'=>$name));
	$frames['set']['items']['divider_set']['title'] = '帮我送设置';
	$frames['set']['items']['divider_set']['actions'] = array();
	$frames['set']['items']['divider_set']['active'] = '';

	$frames['set']['items']['buy_set']['url'] = url('site/entry/buy_set',array('m'=>$name));
	$frames['set']['items']['buy_set']['title'] = '帮我买设置';
	$frames['set']['items']['buy_set']['actions'] = array();
	$frames['set']['items']['buy_set']['active'] = '';

	$frames['set']['items']['v_set']['url'] = url('site/entry/v_set',array('m'=>$name));
	$frames['set']['items']['v_set']['title'] = '认证设置';
	$frames['set']['items']['v_set']['actions'] = array();
	$frames['set']['items']['v_set']['active'] = '';

	$frames['manage']['items']['task']['url'] = url('site/entry/task',array('m'=>$name));
	$frames['manage']['items']['task']['title'] = '任务管理';
	$frames['manage']['items']['task']['actions'] = array();
	$frames['manage']['items']['task']['active'] = '';


	$frames['manage']['items']['v']['url'] = url('site/entry/v',array('m'=>$name));
	$frames['manage']['items']['v']['title'] = '认证管理';
	$frames['manage']['items']['v']['actions'] = array();
	$frames['manage']['items']['v']['active'] = '';

	$frames['manage']['items']['runner']['url'] = url('site/entry/runner',array('m'=>$name));
	$frames['manage']['items']['runner']['title'] = '监控';
	$frames['manage']['items']['runner']['actions'] = array();
	$frames['manage']['items']['runner']['active'] = '';


	if($_W['role'] == 'founder'){
		$frames['founder']['title'] = '管理员特权';
		$frames['founder']['active'] = '';
		$frames['founder']['items'] = array();

		$frames['founder']['items']['delete']['url'] = url('site/entry/delete',array('m'=>$name));
		$frames['founder']['items']['delete']['title'] = '清理数据';
		$frames['founder']['items']['delete']['actions'] = array();
		$frames['founder']['items']['delete']['active'] = '';
	}
	return $frames;
}

function _calc_current_frames2(&$frames) {
	global $_W,$_GPC,$frames;
	if(!empty($frames) && is_array($frames)) {
		foreach($frames as &$frame) {
			foreach($frame['items'] as &$fr) {
				$query = parse_url($fr['url'], PHP_URL_QUERY);
				parse_str($query, $urls);
				if(defined('ACTIVE_FRAME_URL')) {
					$query = parse_url(ACTIVE_FRAME_URL, PHP_URL_QUERY);
					parse_str($query, $get);
				} else {
					$get = $_GET;
				}
				if(!empty($_GPC['a'])) {
					$get['a'] = $_GPC['a'];
				}
				if(!empty($_GPC['c'])) {
					$get['c'] = $_GPC['c'];
				}
				if(!empty($_GPC['do'])) {
					$get['do'] = $_GPC['do'];
				}
				if(!empty($_GPC['doo'])) {
					$get['doo'] = $_GPC['doo'];
				}
				if(!empty($_GPC['op'])) {
					$get['op'] = $_GPC['op'];
				}
				if(!empty($_GPC['m'])) {
					$get['m'] = $_GPC['m'];
				}
				$diff = array_diff_assoc($urls, $get);

				if(empty($diff)) {
					$fr['active'] = ' active';
					$frame['active'] = ' active';
				}
			}
		}
	}
}