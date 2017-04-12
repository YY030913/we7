<?php
if(!pdo_fieldexists('album', 'type')) {
	pdo_query("ALTER TABLE ".tablename('album')." ADD `type` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' AFTER  `isview`;");
}

if (!pdo_indexexists('album_photo', 'idx_albumid')) {
	pdo_query("ALTER TABLE ".tablename('album_photo')." ADD INDEX `idx_albumid` ( `albumid` );");
}
$sql="CREATE TABLE IF NOT EXISTS `ims_album_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `thumb` varchar(255) NOT NULL COMMENT '分类图片',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `description` varchar(500) NOT NULL COMMENT '分类介绍',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  PRIMARY KEY (`id`),KEY `idx_weid` (`weid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_run($sql);

if(!pdo_fieldexists('album', 'pcate')) {
	pdo_query("ALTER TABLE ".tablename('album')." ADD `pcate` int(11) default 0;");
}
if(!pdo_fieldexists('album', 'ccate')) {
	pdo_query("ALTER TABLE ".tablename('album')." ADD `ccate` int(11) default 0;");
}
if(pdo_fieldexists('album_photo', 'attachment')) {
	pdo_query("ALTER TABLE ".tablename('album_photo')." CHANGE `attachment` `attachment` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';");
}
if(pdo_fieldexists('album', 'thumb')) {
	pdo_query("ALTER TABLE ".tablename('album')." CHANGE `thumb` `thumb` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '';");
}

