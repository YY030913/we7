<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Page extends WeModuleSite
{
	public function runTasks()
	{
		global $_W;
		load()->func('communication');
		$lasttime = strtotime(m('cache')->getString('receive', 'global'));
		$interval = intval(m('cache')->getString('receive_time', 'global'));

		if (empty($interval)) {
			$interval = 60;
		}

		$interval *= 60;
		$current = time();

		if (($lasttime + $interval) <= $current) {
			m('cache')->set('receive', date('Y-m-d H:i:s', $current), 'global');
			ihttp_request(EWEI_SHOPV2_TASK_URL . 'order/receive.php', NULL, NULL, 1);
		}

		$lasttime = strtotime(m('cache')->getString('closeorder', 'global'));
		$interval = intval(m('cache')->getString('closeorder_time', 'global'));

		if (empty($interval)) {
			$interval = 60;
		}

		$interval *= 60;
		$current = time();

		if (($lasttime + $interval) <= $current) {
			m('cache')->set('closeorder', date('Y-m-d H:i:s', $current), 'global');
			ihttp_request(EWEI_SHOPV2_TASK_URL . 'order/close.php', NULL, NULL, 1);
		}

		if (com('coupon')) {
			$lasttime = strtotime(m('cache')->getString('couponback', 'global'));
			$interval = intval(m('cache')->getString('couponback_time', 'global'));

			if (empty($interval)) {
				$interval = 60;
			}

			$interval *= 60;
			$current = time();

			if (($lasttime + $interval) <= $current) {
				m('cache')->set('couponback', date('Y-m-d H:i:s', $current), 'global');
				ihttp_request(EWEI_SHOPV2_TASK_URL . 'coupon/back.php', NULL, NULL, 1);
			}
		}

		exit('run finished.');
	}

	public function template($filename = '', $type = TEMPLATE_INCLUDEPATH)
	{
		global $_W;
		global $_GPC;

		if (empty($filename)) {
			$filename = str_replace('.', '/', $_W['routes']);
		}

		if ($_GPC['do'] == 'web') {
			$filename = str_replace('/add', '/post', $filename);
			$filename = str_replace('/edit', '/post', $filename);
			$filename = 'web/' . $filename;
		}
		else {
			if ($_GPC['do'] == 'mobile') {
			}
		}

		$name = 'ewei_shopv2';
		$moduleroot = IA_ROOT . '/addons/ewei_shopv2';

		if (defined('IN_SYS')) {
			$compile = IA_ROOT . '/data/tpl/web/' . $_W['template'] . '/' . $name . '/' . $filename . '.tpl.php';
			$source = $moduleroot . '/template/' . $filename . '.html';

			if (!is_file($source)) {
				$source = $moduleroot . '/template/' . $filename . '/index.html';
			}

			if (!is_file($source)) {
				$explode = array_slice(explode('/', $filename), 1);
				$temp = array_slice($explode, 1);
				$source = $moduleroot . '/plugin/' . $explode[0] . '/template/web/' . implode('/', $temp) . '.html';

				if (!is_file($source)) {
					$source = $moduleroot . '/plugin/' . $explode[0] . '/template/web/' . implode('/', $temp) . '/index.html';
				}
			}
		}
		else {
			$template = m('cache')->getString('template_shop');

			if (empty($template)) {
				$template = 'default';
			}

			if (!is_dir($moduleroot . '/template/mobile/' . $template)) {
				$template = 'default';
			}

			$compile = IA_ROOT . '/data/tpl/app/' . $name . '/' . $template . '/mobile/' . $filename . '.tpl.php';
			$source = IA_ROOT . '/addons/' . $name . '/template/mobile/' . $template . '/' . $filename . '.html';

			if (!is_file($source)) {
				$source = IA_ROOT . '/addons/' . $name . '/template/mobile/default/' . $filename . '.html';
			}

			if (!is_file($source)) {
				$source = IA_ROOT . '/addons/' . $name . '/template/mobile/default/' . $filename . '/index.html';
			}

			if (!is_file($source)) {
				$names = explode('/', $filename);
				$pluginname = $names[0];
				$ptemplate = m('cache')->getString('template_' . $pluginname);

				if (empty($ptemplate)) {
					$ptemplate = 'default';
				}

				if (!is_dir($moduleroot . '/plugin/' . $pluginname . '/template/mobile/' . $ptemplate)) {
					$ptemplate = 'default';
				}

				unset($names[0]);
				$pfilename = implode('/', $names);
				$source = $moduleroot . '/plugin/' . $pluginname . '/template/mobile/' . $ptemplate . '/' . $pfilename . '.html';

				if (!is_file($source)) {
					$source = $moduleroot . '/plugin/' . $pluginname . '/template/mobile/' . $ptemplate . '/' . $pfilename . '/index.html';
				}
			}
		}

		if (!is_file($source)) {
			exit('Error: template source \'' . $filename . '\' is not exist!');
		}

		if (DEVELOPMENT || !is_file($compile) || (filemtime($compile) < filemtime($source))) {
			shop_template_compile($source, $compile, true);
		}

		return $compile;
	}

	public function message($msg, $redirect = '', $type = '')
	{
		global $_W;
		$title = '';
		$buttontext = '';
		$message = $msg;

		if (is_array($msg)) {
			$message = (isset($msg['message']) ? $msg['message'] : '');
			$title = (isset($msg['title']) ? $msg['title'] : '');
			$buttontext = (isset($msg['buttontext']) ? $msg['buttontext'] : '');
		}

		include $this->template('_message');
		exit();
	}
}

?>
