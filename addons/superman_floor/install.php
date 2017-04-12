<?php
/**
 * 【超人】抢楼活动模块定义
 *
 * @author 超人
 * @url
 */
$tablename = tablename('superman_floor_award');
$sql =<<<EOF
CREATE TABLE IF NOT EXISTS {$tablename} (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `floors` varchar(1000) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM CHARSET = utf8;
EOF;
pdo_run($sql);

$tablename = tablename('superman_floor_winner');
$sql =<<<EOF
CREATE TABLE IF NOT EXISTS {$tablename} (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `floor` int(4) unsigned NOT NULL DEFAULT '0',
  `uid` int(4) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(50) NOT NULL DEFAULT '0',
  `award_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `realname` varchar(128) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `qq` varchar(20) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX `indx_uniacid` (`uniacid`),
  UNIQUE INDEX `rid_floor_UNIQUE` (`rid`,`floor`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM CHARSET = utf8;
EOF;
pdo_run($sql);

$tablename = tablename('superman_floor');
$sql =<<<EOF
CREATE TABLE IF NOT EXISTS {$tablename} (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `awardprompt` text NOT NULL DEFAULT '',
  `currentprompt` text NOT NULL DEFAULT '',
  `floorprompt` text NOT NULL DEFAULT '',
  `setting` text NOT NULL DEFAULT '',
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM CHARSET = utf8;
EOF;
pdo_run($sql);
