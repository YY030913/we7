<?php
global $_W,$_GPC;

$mact = trim($_GPC['mact']);

if(empty($mact)){
	$setting = $this->module['config'];
	$path = IA_ROOT . '/addons/'.$this->modulename.'/template/mobile/';
	
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
	foreach ($stylesResults as $item){
		if(file_exists($path.$item.'/config.php')){
			require_once $path.$item.'/config.php';
			$items[] = $config;
		}
	}
}


if($mact == 'add'){
	$data = array();
	load()->func('file');
	$input = $_GPC['__input'];
	$input['image'] = tomedia($input['image']);
	if(empty($input['code'])){
		json(1,'模板标识不能为空',$input);
	}
	if(empty($input['title'])){
		json(1,'模板标题不能为空',$input);
	}
	if(empty($input['image'])){
		json(1,'模板说略图不能为空',$input);
	}
	$path = IA_ROOT.'/addons/'.$this->modulename.'/template/mobile/'.$input['code'].'/config.php';
	if(!file_exists($path)){
		mkdirs(dirname($path),"0777");
	}
$content = <<<EOF
<?php 
	\$config = array();
	\$config['title'] = "{$input['title']}";
	\$config['code'] = "{$input['code']}";
	\$config['image'] = "{$input['image']}";
EOF;
	file_put_contents($path, $content);
	json(0,'',$input);
}

if($mact == 'delete'){
	$path = IA_ROOT . '/addons/'.$this->modulename.'/template/mobile/';
	$input = $_GPC['__input'];
	$code = $input['code'];
	if($code == 'default'){
		message('默认数据不可深处','','ajax');
	}
	if(!empty($code)){
		@unlink($path.$code.'/config.php');
		@unlink($path.$code);
	}
	json(0,'',$input);
}

include $this->template('index');