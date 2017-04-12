<?php
$sql = "
CREATE TABLE IF NOT EXISTS `ims_ice_picWallMain` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '1',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `openid` varchar(64) NOT NULL DEFAULT '1',
  `tousername` varchar(32) NOT NULL DEFAULT '1',
  `timeID` int(10) unsigned NOT NULL DEFAULT '1',
  `showID` int(10) unsigned NOT NULL DEFAULT '1',
  `imgurl` varchar(512) NOT NULL DEFAULT '1',
  `likeNum` int(10) unsigned NOT NULL DEFAULT '0',
  `time` varchar(16) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_ice_picWallUserinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '1',
  `openid` varchar(64) NOT NULL DEFAULT '1',
  `uname` varchar(16) NOT NULL,
  `phone` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
pdo_query($sql);
?>