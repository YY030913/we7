<?php
global $_W,$_GPC;


/***
 * 支持的组件
 * */

$navs = M('tpl')->getTpls();

$params = array('color'=> '','bgcolor'=> '','notice'=> '','noticehref'=> '','scroll'=> '0','field'=>'params');
$nav = array('id'=>'notice','name'=>'公告','params'=>$params);
M('tpl')->update($nav);

$params = array('shape'=> '','align'=> 'center','scroll'=> '2','bgcolor'=> '','field'=>'params');
$data = array();
$data[] = array('id'=> '','imgurl'=> '../addons/imeepos_runner/preview.jpg','hrefurl'=>$this->createMobileUrl('index'));
$nav = array('id'=>'banner','name'=>'轮播','params'=>$params,'data'=>$data);
M('tpl')->update($nav);

$params = array('title1'=> '','title2'=> '','showtitle2'=> '1','fontsize1'=> '18px','fontsize2'=>'14px','align'=>'left','color'=>'#000');
$nav = array('id'=>'title','name'=>'标题','params'=>$params);
M('tpl')->update($nav);

$params = array('placeholder'=> '请输入关键字','style'=> 'style1','searchurl'=> '1');
$nav = array('id'=>'search','name'=>'搜索框','params'=>$params);
M('tpl')->update($nav);

$params = array('height'=> '2px','style'=> 'dashed','color'=> '1');
$nav = array('id'=>'line','name'=>'辅助线','params'=>$params);
M('tpl')->update($nav);

$params = array('height'=> '100px','bgcolor'=> '');
$nav = array('id'=>'blank','name'=>'辅助空白','params'=>$params);
M('tpl')->update($nav);

$params = array('bgcolor'=> '');
$nav = array('id'=>'richtext','name'=>'富文本','params'=>$params);
M('tpl')->update($nav);


$params = array('num'=> '20%','style'=> '0','bgcolor'=> '#fff');
$data = array();
$data[] = array('id'=>'','imgurl'=>'','text'=>'','hrefurl'=>'','color'=>'');
$nav = array('id'=>'menu','name'=>'按钮组','params'=>$params);
M('tpl')->update($nav);


$params = array('num'=> '20%','style'=> '0','bgcolor'=> '#fff');
$data = array();
$data[] = array('id'=>'','imgurl'=>'','hrefurl'=>'','option'=>'');
$nav = array('id'=>'picture','name'=>'单图','params'=>$params);
M('tpl')->update($nav);

$pagename = trim($_GPC['pagename']);
if(empty($pagename)){
	$pagename = 'index';
}

$tpl = array();
$tpl['name'] = 'index';
$tpl['title'] = '快递首页';
M('tpldata')->update($tpl);

$item = M('tpldata')->getInfo($pagename);
$pageinfo = $item['pageinfo'];

if(empty($_GPC['act'])){
	$_GPC['act'] = 'tabs';
}

$act = trim($_GPC['act']);

if($act == 'tabs'){
	$_W['page']['title'] = '快捷菜单 - 站点管理 - 微站功能';
	$multiid = intval($_GPC['multiid']);
	$type = intval($_GPC['type']) ? intval($_GPC['type']) : 2;

	if ($_GPC['wapeditor']) {
		$params = $_GPC['wapeditor']['params'];
		if (empty($params)) {
			message('请您先设计手机端页面.', '', 'error');
		}
		$params = json_decode(html_entity_decode(urldecode($params)), true);
		if (empty($params)) {
			message('请您先设计手机端页面.', '', 'error');
		}
		$html = htmlspecialchars_decode($_GPC['wapeditor']['html'], ENT_QUOTES);
		$data = array(
			'uniacid' => $_W['uniacid'],
			'multiid' => $multiid,
			'title' => '快捷菜单',
			'description' => '',
			'status' => intval($_GPC['status']),
			'type' => $type,
			'params' => json_encode($params),
			'html' => $html,
			'createtime' => TIMESTAMP,
		);
		if ($type == '4') {
			$id = pdo_fetchcolumn("SELECT id FROM ".tablename('site_page')." WHERE uniacid = :uniacid AND type = :type", array(':uniacid' => $_W['uniacid'], ':type' => $type));
		} else {
			$id = pdo_fetchcolumn("SELECT id FROM ".tablename('site_page')." WHERE multiid = :multiid AND type = :type", array(':multiid' => $multiid, ':type' => $type));
		}
		if (!empty($id)) {
			pdo_update('site_page', $data, array('id' => $id));
		} else {
			if ($type == 4) {
				$data['status'] = 1;
			}
			pdo_insert('site_page', $data);
			$id = pdo_insertid();
		}
		message('快捷菜单保存成功.', url('site/editor/quickmenu', array('multiid' => $multiid, 'type' => $type)), 'success');
	}
	if ($type == '4') {
		$page = pdo_fetch("SELECT * FROM ".tablename('site_page')." WHERE type = :type AND uniacid = :uniacid", array(':type' => $type, ':uniacid' => $_W['uniacid']));
	} else {
		$page = pdo_fetch("SELECT * FROM ".tablename('site_page')." WHERE multiid = :multiid AND type = :type", array(':multiid' => $multiid, ':type' => $type));
	}
	$modules = uni_modules();

	include $this->template('design_tabs');
	exit();
}


include $this->template('design');