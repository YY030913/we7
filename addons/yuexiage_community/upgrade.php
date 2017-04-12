<?php

//内容增加广告字段
if(!pdo_fieldexists('yuexiage_community_contents', 'advertisement_img')) {

	pdo_query("ALTER TABLE ".tablename('yuexiage_community_contents')." ADD `advertisement_img` VARCHAR(100) NOT NULL DEFAULT '' AFTER `hits`;");

}
if(!pdo_fieldexists('yuexiage_community_contents', 'advertisement_link')) {

	pdo_query("ALTER TABLE ".tablename('yuexiage_community_contents')." ADD `advertisement_link` TEXT NOT NULL DEFAULT '' AFTER `hits`;");

}

//0.6.1版本黑名单错误更改
$blacklist = pdo_fetch("SELECT eid FROM ".tablename('modules_bindings')." WHERE module='yuexiage_community' AND title='黑名单管理' ");
if ( count($blacklist) ) {
	pdo_update('modules_bindings',array('do'=>'blacklist','state'=>''),array('eid'=>$blacklist['eid']));
}

//没有黑名单数据表时创建
if(!pdo_tableexists('yuexiage_community_blacklist')){
$sql = <<<EOF
DROP TABLE IF EXISTS `ims_yuexiage_community_blacklist`;
CREATE TABLE `ims_yuexiage_community_blacklist` (
  `id` int(10) NOT NULL auto_increment,
  `uid` int(10) default NULL,
  `nickname` varchar(50) default NULL,
  `status` int(5) default '0',
  `uniacid` int(10) unsigned NOT NULL,
  `time` int(10) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
EOF;
pdo_run($sql);	
}

