<?php
$installSql = <<<sql
CREATE TABLE IF NOT EXISTS `{$_W['config']['db']['tablepre']}qiyue_qiuqian` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(20) NOT NULL DEFAULT '',
  `filename` varchar(200) NOT NULL DEFAULT '',
  `myorder` tinyint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  `sharenum` int(10) NOT NULL DEFAULT '0',
  `viewnum` int(10) NOT NULL DEFAULT '0',
  `morepic` mediumtext NOT NULL,
  KEY `uniacid` (`id`,`uniacid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
sql;
$row = pdo_run($installSql);
?>