<?php
// 删除数据表
$uninstallSql = <<<uninstallSql
	DROP TABLE IF EXISTS `{$_W['config']['db']['tablepre']}qiyue_qiuqian`;
uninstallSql;
$row = pdo_run($uninstallSql);

//删除附件
load()->func('file');
$path = IA_ROOT.'/attachment/images/'.$_W['uniacid'].'/qiuqian/';
rmdirs($path);