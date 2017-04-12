<?php
/**
 * [WeEngine System] Copyright (c) 2013 WE7.CC
 * $sn: pro/app/source/activity/__init.php : v fac2b7b1f566 : 2015/09/08 07:11:59 : yanghf $
 */
defined('IN_IA') or exit('Access Denied');

if ($controller == 'activity') {
	header('Location: ' . murl('entry', array('m' => 'we7_coupon', 'do' => 'activity')));
	exit;
}
