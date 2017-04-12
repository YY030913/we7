<?php
$sql = "
CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL,
  `weid` int(10) unsigned NOT NULL,
  `tpl` int(10) unsigned NOT NULL DEFAULT '0',
  `status` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(20) NOT NULL COMMENT '活动标题',
  `description` longtext NOT NULL COMMENT '活动介绍',
  `thumb` varchar(200) DEFAULT '',
  `isshow` tinyint(1) DEFAULT '0',
  `bj` varchar(100) NOT NULL COMMENT '名片图片',
  `viewnum` int(11) DEFAULT '0',
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; 

CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_member` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT NULL,
  `realname` varchar(50) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `job` varchar(50) DEFAULT NULL,
  `qq` varchar(50) DEFAULT NULL,
  `industry` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `weixin` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `headimg` varchar(255) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `myattention` varchar(255) DEFAULT NULL,
  `myfocus` varchar(255) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `companyAddress` varchar(255) DEFAULT NULL,
  `lat` decimal(18,10) DEFAULT '0.0000000000',
  `lng` decimal(18,10) DEFAULT '0.0000000000',
  `status` tinyint(1) DEFAULT NULL COMMENT '0表示已审核，1表示未审核，2表示禁用',
  `qianming` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_bg` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `displayorder` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_card` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `from_user` varchar(255) NOT NULL,
  `mid` int(10) NOT NULL COMMENT '会员表id',
  `mobile` tinyint(1) DEFAULT '0' COMMENT 'type=1;0代表全部可见，1代表互相收藏可见，2代表自己可见',
  `email` tinyint(1) DEFAULT '0' COMMENT 'type=2;0代表全部可见，1代表互相收藏可见，2代表自己可见',
  `weixin` tinyint(1) DEFAULT '0' COMMENT 'type=3;0代表全部可见，1代表互相收藏可见，2代表自己可见',
  `address` tinyint(1) DEFAULT '0' COMMENT 'type=4;0代表全部可见，1代表互相收藏可见，2代表自己可见',
  `bgimg` varchar(255) DEFAULT NULL,
  `shopName` varchar(255) DEFAULT NULL,
  `templateFile` varchar(300) DEFAULT 'qianx_index',
  `shopIcon` varchar(255) DEFAULT NULL,
  `shopUrl` varchar(255) DEFAULT NULL,
  `zan` int(10) DEFAULT '0',
  `view` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_companyinfo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `mid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `from_user` varchar(255) NOT NULL,
  `img` text,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_music` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) DEFAULT NULL,
  `musicName` varchar(255) DEFAULT NULL,
  `musicSinger` varchar(255) DEFAULT NULL,
  `musicImg` varchar(255) DEFAULT NULL,
  `musicUrl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_industry` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `displayorder` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_presence` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `mid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `from_user` varchar(255) DEFAULT NULL,
  `img` text,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_bjyy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `mid` int(10) NOT NULL,
  `musicid` int(10) NOT NULL,
  `from_user` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_photo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `mid` int(10) NOT NULL COMMENT '会员表id',
  `cid` int(10) NOT NULL COMMENT '名片表id',
  `from_user` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '栏目名称',
  `icon` varchar(255) DEFAULT NULL COMMENT '栏目图标',
  `thumb` text COMMENT '图片',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
 
CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_mycollect` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `mid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `from_user` varchar(255) NOT NULL,
  `collect_mid` int(10) NOT NULL,
  `collect_cid` int(10) NOT NULL,
  `collect_from_user` varchar(255) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
 
CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_zan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `mid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `from_user` varchar(255) NOT NULL,
  `zan_mid` int(10) NOT NULL,
  `zan_cid` int(10) NOT NULL,
  `zan_from_user` varchar(255) NOT NULL,
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_amouse_weicard_sysset`(
  `id` int(11)  AUTO_INCREMENT,
  `weid` int(11) DEFAULT 0 ,
  `guanzhuUrl` varchar(255) DEFAULT '1' comment '引导关注',
  `copyright` varchar(255) DEFAULT '' comment '版权',
  `cnzz` varchar(800) DEFAULT '' comment '第三方统计',
  `appid` varchar(255) default '',
  `isoauth` int(2) unsigned NOT NULL DEFAULT '1',
  `appsecret` varchar(255) default '',
  `appid_share` varchar(255) default '',
  `appsecret_share` varchar(255) default '',
  PRIMARY KEY (`id`),KEY `indx_weid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";

pdo_run($sql);
 if(!pdo_fieldexists('amouse_weicard_sysset', 'isoauth')) {
	pdo_query("ALTER TABLE ".tablename('amouse_weicard_sysset')." ADD `isoauth` int(2) unsigned NOT NULL DEFAULT '1';");
}

 if(!pdo_fieldexists('amouse_weicard_card', 'templateFile')) {
	pdo_query("ALTER TABLE ".tablename('amouse_weicard_card')." ADD   `templateFile` varchar(300) DEFAULT 'qianx_index';");
}
 if(!pdo_fieldexists('amouse_weicard_industry', 'weid')) {
	pdo_query("ALTER TABLE ".tablename('amouse_weicard_industry')." ADD  `weid` int(10) NOT NULL;");
}

