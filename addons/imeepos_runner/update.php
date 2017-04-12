<?php
/**
 */
$sql = "
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `lat` varchar(32) DEFAULT '',
  `lng` varchar(32) DEFAULT '',
  `poiaddress` varchar(320) DEFAULT '',
  `poiname` varchar(128) DEFAULT '',
  `cityname` varchar(128) DEFAULT '',
  `detail` varchar(320) DEFAULT '',
  `realname` varchar(32) DEFAULT '',
  `mobile` varchar(32) DEFAULT '',
  `create_at` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  ;

CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_adv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `title` varchar(64) DEFAULT '',
  `image` varchar(300) DEFAULT '',
  `time` int(11) DEFAULT '0',
  `link` varchar(320) DEFAULT '',
  `status` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  ;

CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `freight` float(10,2) DEFAULT '0.00',
  `title` varchar(132) DEFAULT '',
  `buyprovince` varchar(32) DEFAULT '',
  `buycity` varchar(32) DEFAULT '',
  `province` varchar(32) DEFAULT '',
  `city` varchar(32) DEFAULT '',
  `address` varchar(132) DEFAULT '',
  `receivelon` varchar(32) DEFAULT '',
  `receivelat` varchar(32) DEFAULT '',
  `expectedtime` int(11) DEFAULT '0',
  `buyaddress` varchar(132) DEFAULT '',
  `sendlon` varchar(32) DEFAULT '',
  `sendlat` varchar(32) DEFAULT '',
  `other` varchar(320) DEFAULT '',
  `distance` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  `limit_time` int(11) DEFAULT '0',
  `receiveaddress` varchar(132) DEFAULT '',
  `receivedetail` varchar(320) DEFAULT NULL,
  `receivemobile` varchar(32) DEFAULT NULL,
  `message` varchar(640) DEFAULT NULL,
  `receiverealname` varchar(32) DEFAULT NULL,
  `dianfu` tinyint(2) DEFAULT NULL,
  `goodscost` decimal(10,2) DEFAULT NULL,
  `goodstitle` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_citys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(64) DEFAULT '',
  `lat` varchar(32) DEFAULT '',
  `lng` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  ;

CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(32) DEFAULT '',
  `code` varchar(32) DEFAULT '',
  `time` int(11) DEFAULT '0',
  `content` varchar(320) DEFAULT '',
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  ;

CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  `goodsweight` float(10,2) DEFAULT '0.00',
  `goodscost` float(10,2) DEFAULT '0.00',
  `goodsname` varchar(64) DEFAULT '',
  `sendprovince` varchar(32) DEFAULT '',
  `sendcity` varchar(32) DEFAULT '',
  `sendaddress` varchar(132) DEFAULT '',
  `receiveprovince` varchar(32) DEFAULT '',
  `receivecity` varchar(32) DEFAULT '',
  `receiveaddress` varchar(132) DEFAULT '',
  `pickupdate` int(11) DEFAULT '0',
  `sendlon` varchar(64) DEFAULT '',
  `sendlat` varchar(64) DEFAULT '',
  `receivelon` varchar(64) DEFAULT '',
  `receivelat` varchar(64) DEFAULT '',
  `distance` int(11) DEFAULT '0',
  `dataTimeValue` int(11) DEFAULT '0',
  `time` tinyint(2) DEFAULT '0',
  `base_fee` float(10,2) DEFAULT '0.00',
  `fee` float(10,2) DEFAULT '0.00',
  `total` float(10,2) DEFAULT '0.00',
  `small_money` float(10,2) DEFAULT '0.00',
  `senddetail` varchar(64) DEFAULT '',
  `receivedetail` varchar(320) DEFAULT '',
  `receivemobile` varchar(32) DEFAULT '',
  `receiverealname` varchar(32) DEFAULT '',
  `message` varchar(640) DEFAULT '',
  `images` varchar(1000) DEFAULT NULL,
  `float_distance` float(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  ;

CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_idauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `cardno` varchar(32) DEFAULT '',
  `code` int(11) DEFAULT '0',
  `birthday` varchar(32) DEFAULT '',
  `sex` varchar(32) DEFAULT '',
  `name` varchar(32) DEFAULT '',
  `address` varchar(64) DEFAULT '',
  `openid` varchar(64) DEFAULT '',
  `uid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `src` varchar(300) DEFAULT NULL,
  `code` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  ;

CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_listenlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `create_time` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  ;

CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL,
  `uniacid` int(11) unsigned NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `groupid` int(11) unsigned NOT NULL,
  `time` int(11) DEFAULT NULL,
  `openid` varchar(64) DEFAULT NULL,
  `online` tinyint(2) DEFAULT '0',
  `nickname` varchar(32) DEFAULT '',
  `avatar` varchar(320) DEFAULT NULL,
  `gender` tinyint(2) DEFAULT '0',
  `city` varchar(32) DEFAULT '',
  `provice` varchar(32) DEFAULT '',
  `realname` varchar(32) DEFAULT '',
  `mobile` varchar(32) DEFAULT '',
  `xinyu` int(11) DEFAULT '0',
  `isrunner` tinyint(2) DEFAULT '0',
  `card_image1` varchar(320) DEFAULT '',
  `card_image2` varchar(320) DEFAULT '',
  `cardnum` varchar(64) DEFAULT '',
  `lat` varchar(64) DEFAULT '',
  `lng` varchar(64) DEFAULT '',
  `forbid` tinyint(4) DEFAULT '0',
  `oauth_code` varchar(64) DEFAULT '',
  `level_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;

CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `status` tinyint(2) DEFAULT '0',
  `title` varchar(320) DEFAULT '',
  `link` varchar(320) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  ;

CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_moneylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `reciveid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `fee` float(10,2) DEFAULT '0.00',
  `openid` varchar(64) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_navs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `title` varchar(32) DEFAULT '',
  `link` varchar(320) DEFAULT '',
  `icon_on` varchar(320) DEFAULT '',
  `icon_off` varchar(320) DEFAULT '',
  `create_time` int(11) DEFAULT '0',
  `ido` varchar(32) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `position` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;



CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_paylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `tid` varchar(64) DEFAULT '',
  `time` int(11) DEFAULT '0',
  `setting` text,
  `status` tinyint(2) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `fee` float(10,2) DEFAULT '0.00',
  `type` varchar(32) DEFAULT '',
  `taskid` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;



CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_recive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `taskid` int(11) DEFAULT '0',
  `create_time` int(11) DEFAULT '0',
  `fee` float(10,2) DEFAULT '0.00',
  `update_time` int(11) DEFAULT '0',
  `status` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `code` varchar(32) DEFAULT '',
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;



CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_star` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  `from_openid` varchar(64) DEFAULT '',
  `to_openid` varchar(64) DEFAULT '',
  `star` int(11) DEFAULT '0',
  `type` tinyint(4) DEFAULT '0',
  `content` varchar(1000) DEFAULT '',
  `create_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8  ;


CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `status` tinyint(2) DEFAULT '1',
  `create_time` int(11) DEFAULT '0',
  `cityid` int(11) DEFAULT '0',
  `media_id` varchar(132) DEFAULT '',
  `openid` varchar(64) DEFAULT '',
  `desc` text,
  `update_time` int(11) DEFAULT '0',
  `code` text,
  `qrcode` text,
  `city` varchar(32) DEFAULT '',
  `type` tinyint(4) DEFAULT '0',
  `total` float(10,2) DEFAULT '0.00',
  `small_money` float(10,2) DEFAULT '0.00',
  `limit_time` int(11) DEFAULT '0',
  `address` varchar(320) DEFAULT '',
  `read_num` int(11) DEFAULT '0',
  `share_num` int(11) DEFAULT '0',
  `listen_num` int(11) DEFAULT '0',
  `message` varchar(320) DEFAULT '',
  `dianfu` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  ;


CREATE TABLE IF NOT EXISTS `ims_imeepos_runner3_tasks_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `content` varchar(1000) DEFAULT '',
  `create_time` int(11) DEFAULT '0',
  `lat` varchar(32) DEFAULT '',
  `lng` varchar(32) DEFAULT '',
  `status` tinyint(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_adv` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL,
  `module` varchar(32) NOT NULL,
  `starttime` int(11) unsigned NOT NULL,
  `endtime` int(11) unsigned NOT NULL,
  `displayorder` int(11) unsigned NOT NULL,
  `title` varchar(132) NOT NULL,
  `link` varchar(132) NOT NULL,
  `image` varchar(132) NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `isfull` tinyint(2) NOT NULL,
  `pid` int(11) unsigned NOT NULL,
  `images` text NOT NULL,
  `set` text NOT NULL,
  `month` float(6,2) unsigned NOT NULL,
  `postion` varchar(32) NOT NULL,
  `content` text,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_apply_certify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `state` tinyint(4) NOT NULL,
  `certify_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `delete_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_apply_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `service_type_id` int(11) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `note` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `delete_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `condition` int(11) DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_certify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `ename` varchar(60) DEFAULT NULL,
  `is_valid` tinyint(2) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `timelong` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_UNIACID` (`uniacid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_class` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL,
  `title` varchar(32) NOT NULL,
  `icon` varchar(132) NOT NULL,
  `desc` varchar(132) NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `module` varchar(32) NOT NULL,
  `set` text NOT NULL,
  `link` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_father` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(32) DEFAULT NULL,
  `fid` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `content` text,
  `time` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `nickname` varchar(60) DEFAULT NULL,
  `mobile` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_gonggao` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL,
  `module` varchar(32) NOT NULL,
  `title` varchar(132) NOT NULL,
  `link` varchar(132) NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `starttime` int(11) unsigned NOT NULL,
  `endtime` int(11) unsigned NOT NULL,
  `content` text NOT NULL,
  `tag` varchar(300) NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `displayorder` int(11) unsigned NOT NULL,
  `num` int(11) unsigned NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(255) DEFAULT NULL,
  `type` tinyint(3) DEFAULT NULL,
  `logno` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT NULL,
  `rechargetype` varchar(255) DEFAULT NULL,
  `transid` varchar(64) DEFAULT NULL,
  `zeng` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_openid` (`openid`),
  KEY `idx_type` (`type`),
  KEY `idx_createtime` (`createtime`),
  KEY `idx_status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_markets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `condition` int(11) DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL,
  `uniacid` int(11) unsigned NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `groupid` int(11) unsigned NOT NULL,
  `fid` int(11) DEFAULT NULL,
  `credit_red` decimal(10,2) DEFAULT NULL,
  `credit_deposit` decimal(10,2) DEFAULT NULL,
  `is_runner` tinyint(2) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `credit_runner` int(11) unsigned NOT NULL,
  `credit_member` int(11) unsigned NOT NULL,
  `openid` varchar(64) DEFAULT NULL,
  `qr` varchar(200) DEFAULT NULL,
  `scan` tinyint(2) DEFAULT NULL,
  `online` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_member_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `desc` text,
  `startnum` int(11) DEFAULT NULL,
  `ionc` varchar(200) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_member_paylog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupid` int(11) unsigned NOT NULL,
  `fee` float(8,2) unsigned NOT NULL,
  `title` varchar(132) NOT NULL,
  `createtime` int(11) unsigned NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `transid` varchar(64) NOT NULL,
  `ordersn` varchar(64) NOT NULL,
  `uniacid` int(11) unsigned NOT NULL,
  `uid` int(11) unsigned NOT NULL,
  `runnerid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_member_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `realname` varchar(60) DEFAULT NULL,
  `age` int(6) DEFAULT NULL,
  `tools` varchar(300) DEFAULT NULL,
  `diverpic` varchar(300) DEFAULT NULL,
  `cardpic1` varchar(300) DEFAULT NULL,
  `cardpic2` varchar(300) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `latitude` varchar(32) NOT NULL,
  `longitude` varchar(32) DEFAULT NULL,
  `openid` varchar(64) DEFAULT NULL,
  `mobile` varchar(32) DEFAULT NULL,
  `wechat` varchar(64) DEFAULT NULL,
  `cardnum` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `fopenid` varchar(64) DEFAULT '',
  `topenid` varchar(64) DEFAULT '',
  `content` varchar(300) DEFAULT '',
  `status` tinyint(2) DEFAULT '0',
  `createtime` int(11) DEFAULT '0',
  `readtime` int(11) DEFAULT '0',
  `replytime` int(11) DEFAULT '0',
  `replayid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_msg_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `tpl_id` varchar(100) NOT NULL,
  `template` text NOT NULL,
  `tags` varchar(1000) NOT NULL,
  `set` text NOT NULL,
  `type` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_UNIACID` (`uniacid`),
  KEY `IDX_TYPE` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_msg_template_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(52) NOT NULL,
  `set` text NOT NULL,
  `uniacid` int(11) unsigned NOT NULL,
  `tpl_id` varchar(124) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_my_certify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `uniacid` int(11) DEFAULT NULL,
  `certify_id` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_my_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `services_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `update_at` int(11) DEFAULT NULL,
  `delete_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL,
  `title` varchar(32) NOT NULL,
  `icon` varchar(132) NOT NULL,
  `link` varchar(132) NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `module` varchar(32) NOT NULL,
  `type` varchar(32) NOT NULL,
  `displayorder` int(11) unsigned NOT NULL,
  `postion` varchar(32) NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `datas` text,
  `savetime` int(11) DEFAULT NULL,
  `pagetype` tinyint(6) DEFAULT NULL,
  `pageinfo` text,
  `pagename` varchar(64) DEFAULT NULL,
  `keyword` varchar(32) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `setdefault` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_paylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `openid` varchar(40) DEFAULT NULL,
  `tid` varchar(64) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `actiontype` tinyint(2) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_UNIACID` (`uniacid`),
  KEY `IDX_TID` (`tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `content` text,
  `img` varchar(300) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_runner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `desc` text,
  `groupid` int(11) DEFAULT NULL,
  `isonline` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_runner_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `title` varchar(60) DEFAULT NULL,
  `desc` text,
  `startnum` int(11) DEFAULT NULL,
  `ionc` varchar(200) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `isdefault` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `desc` text,
  `price` decimal(10,2) DEFAULT NULL,
  `imgurl` varchar(255) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL,
  `usort` int(11) DEFAULT NULL,
  `create_ar` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `tumelong` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `invitecode` text,
  `set` text NOT NULL,
  `about` text NOT NULL,
  `seo` text NOT NULL,
  `share` text NOT NULL,
  `themes` text NOT NULL,
  `tasks` text NOT NULL,
  `juhe` text NOT NULL,
  `template_message` text NOT NULL,
  `widthdraw` text NOT NULL,
  `renren` text NOT NULL,
  `renren_city` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `cid` int(11) DEFAULT '0',
  `title` varchar(64) DEFAULT '',
  `desc` varchar(300) DEFAULT '',
  `content` text,
  `mobile` varchar(32) DEFAULT '',
  `wechat` varchar(32) DEFAULT '',
  `createtime` int(11) DEFAULT '0',
  `image` varchar(200) DEFAULT '',
  `thumbs` text,
  `status` tinyint(2) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `icon` varchar(200) DEFAULT '',
  `uid` int(11) DEFAULT '0',
  `opentime` varchar(300) DEFAULT '',
  `address` varchar(300) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_shop_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `title` varchar(64) DEFAULT '',
  `icon` varchar(200) DEFAULT '',
  `time` int(11) DEFAULT '0',
  `desc` varchar(300) DEFAULT '',
  `fid` int(11) DEFAULT '0',
  `setting` text,
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_shop_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `cid` int(11) DEFAULT '0',
  `title` varchar(64) DEFAULT '',
  `desc` varchar(300) DEFAULT '',
  `image` varchar(200) DEFAULT '',
  `thumbs` text,
  `createtime` int(11) DEFAULT '0',
  `fee` decimal(10,2) DEFAULT '0.00',
  `shopid` int(11) DEFAULT '0',
  `status` tinyint(2) DEFAULT '0',
  `address` varchar(300) DEFAULT NULL,
  `displayorder` int(11) DEFAULT NULL,
  `opentime` varchar(255) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `openid` varchar(64) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_tasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) unsigned NOT NULL,
  `uid` int(11) unsigned NOT NULL,
  `oauth_openid` varchar(64) NOT NULL,
  `openid` varchar(64) NOT NULL,
  `desc` varchar(132) NOT NULL,
  `cid` int(11) unsigned NOT NULL,
  `fee` float(11,2) NOT NULL,
  `nickname` varchar(32) NOT NULL,
  `realname` varchar(32) NOT NULL,
  `mobile` varchar(32) NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `module` varchar(32) NOT NULL,
  `createtime` int(11) unsigned NOT NULL,
  `transid` varchar(64) NOT NULL,
  `displayorder` int(11) unsigned NOT NULL,
  `ordersn` varchar(64) NOT NULL,
  `startlat` double NOT NULL,
  `startlng` double NOT NULL,
  `endlat` double NOT NULL,
  `endlng` double NOT NULL,
  `startaddress` varchar(132) NOT NULL,
  `endaddress` varchar(132) NOT NULL,
  `look_num` int(11) DEFAULT NULL,
  `share_num` int(11) DEFAULT NULL,
  `sheng_num` int(11) DEFAULT NULL,
  `zhong_num` int(11) DEFAULT NULL,
  `jing_num` int(11) DEFAULT NULL,
  `total_num` int(11) DEFAULT NULL,
  `thumbs` text,
  `postrealname` varchar(32) NOT NULL,
  `postmobile` varchar(32) NOT NULL,
  `recivemobile` varchar(32) DEFAULT NULL,
  `reciverealname` varchar(32) DEFAULT NULL,
  `starttime` varchar(32) DEFAULT NULL,
  `endtime` varchar(32) DEFAULT NULL,
  `peoplelimit` int(3) DEFAULT NULL,
  `lessfee` decimal(11,2) DEFAULT NULL,
  `kglimit` decimal(5,2) DEFAULT NULL,
  `unitname` varchar(32) DEFAULT NULL,
  `timelimit` decimal(6,2) DEFAULT NULL,
  `addresslimit` decimal(6,2) DEFAULT NULL,
  `totalfee` float(10,2) DEFAULT NULL,
  `limitgender` tinyint(2) DEFAULT NULL,
  `setting` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_tasks_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taskid` int(11) DEFAULT '0',
  `uniacid` int(11) DEFAULT '0',
  `title` varchar(200) DEFAULT '',
  `ratting1` int(11) DEFAULT '0',
  `ratting2` int(11) DEFAULT '0',
  `ratting3` int(11) DEFAULT '0',
  `fuid` int(11) DEFAULT '0',
  `tuid` int(11) DEFAULT '0',
  `time` int(11) DEFAULT '0',
  `desc` text,
  `type` tinyint(4) DEFAULT '0',
  `reciveid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_tasks_recive` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_uniacid` int(32) unsigned NOT NULL,
  `to_uniacid` int(11) unsigned NOT NULL,
  `from_uid` int(11) unsigned NOT NULL,
  `to_uid` int(11) unsigned NOT NULL,
  `from_openid` varchar(64) NOT NULL,
  `to_openid` varchar(64) NOT NULL,
  `taskid` int(11) unsigned NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `time` int(11) unsigned NOT NULL,
  `reciveid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_tasks_recive_active` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `uid` int(11) DEFAULT '0',
  `reciveid` int(11) DEFAULT '0',
  `taskid` int(11) DEFAULT '0',
  `openid` varchar(64) DEFAULT '',
  `lat` varchar(64) DEFAULT '',
  `lng` varchar(64) DEFAULT '',
  `address` varchar(128) DEFAULT '',
  `time` int(11) DEFAULT '0',
  `desc` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_imeepos_runner_users_invitecode` (
  `user_id` int(10) unsigned NOT NULL,
  `invite_code` char(16) NOT NULL,
  `invite_counts` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  UNIQUE KEY `invite_code` (`invite_code`),
  UNIQUE KEY `user_id_2` (`user_id`),
  KEY `user_id` (`user_id`),
  KEY `invite_code_2` (`invite_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";

pdo_run($sql);

if(!pdo_fieldexists('imeepos_runner3_tasks', 'update_time')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD  `update_time` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('imeepos_runner3_tasks', 'code')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD `code` text;");
}
if(!pdo_fieldexists('imeepos_runner3_tasks', 'qrcode')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD  `qrcode` text;");
}
if(!pdo_fieldexists('imeepos_runner3_tasks', 'total')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD  `total` float(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists('imeepos_runner3_tasks', 'small_money')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD  `small_money` float(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists('imeepos_runner3_tasks', 'limit_time')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD  `limit_time` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('imeepos_runner3_tasks', 'address')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD  `address` varchar(320) DEFAULT '';");
}
if(!pdo_fieldexists('imeepos_runner3_tasks', 'read_num')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD  `read_num` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('imeepos_runner3_tasks', 'share_num')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD  `share_num` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('imeepos_runner3_tasks', 'listen_num')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD  `listen_num` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('imeepos_runner3_tasks', 'message')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD  `message` varchar(320) DEFAULT '';");
}
if(!pdo_fieldexists('imeepos_runner3_tasks', 'dianfu')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_tasks')." ADD  `dianfu` tinyint(2) DEFAULT '0';");
}
if(!pdo_fieldexists('imeepos_runner3_recive', 'update_time')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_recive')." ADD   `update_time` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('imeepos_runner3_recive', 'status')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_recive')." ADD  `status` tinyint(2) DEFAULT '0';");
}
if(!pdo_fieldexists('imeepos_runner3_paylog', 'taskid')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_paylog')." ADD   `taskid` int(10) DEFAULT '0';");
}

if(!pdo_fieldexists('imeepos_runner3_member', 'lat')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_member')." ADD `lat` varchar(64) DEFAULT '';");
}
if(!pdo_fieldexists('imeepos_runner3_member', 'lng')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_member')." ADD  `lng` varchar(64) DEFAULT '';");
}
if(!pdo_fieldexists('imeepos_runner3_member', 'forbid')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_member')." ADD  `forbid` tinyint(4) DEFAULT '0';");
}
if(!pdo_fieldexists('imeepos_runner3_member', 'oauth_code')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_member')." ADD  `oauth_code` varchar(64) DEFAULT '';");
}
if(!pdo_fieldexists('imeepos_runner3_member', 'level_id')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_member')." ADD `level_id` int(11) DEFAULT '0';");
}
if(!pdo_fieldexists('imeepos_runner3_detail', 'small_money')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_detail')." ADD  `small_money` float(10,2) DEFAULT '0.00';");
}
if(!pdo_fieldexists('imeepos_runner3_detail', 'senddetail')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_detail')." ADD  `senddetail` varchar(64) DEFAULT '';");
}
if(!pdo_fieldexists('imeepos_runner3_detail', 'receivedetail')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_detail')." ADD  `receivedetail` varchar(320) DEFAULT '';");
}
if(!pdo_fieldexists('imeepos_runner3_detail', 'receivemobile')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_detail')." ADD  `receivemobile` varchar(32) DEFAULT '';");
}
if(!pdo_fieldexists('imeepos_runner3_detail', 'receiverealname')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_detail')." ADD  `receiverealname` varchar(32) DEFAULT '';");
}
if(!pdo_fieldexists('imeepos_runner3_detail', 'message')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_detail')." ADD  `message` varchar(640) DEFAULT '';");
}
if(!pdo_fieldexists('imeepos_runner3_detail', 'images')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_detail')." ADD  `images` varchar(1000) DEFAULT NULL;");
}
if(!pdo_fieldexists('imeepos_runner3_detail', 'float_distance')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_detail')." ADD  `float_distance` float(10,2) DEFAULT NULL;");
}
if(!pdo_fieldexists('imeepos_runner3_buy', 'receivedetail')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_buy')." ADD  `receivedetail` varchar(320) DEFAULT NULL;");
}
if(!pdo_fieldexists('imeepos_runner3_buy', 'receivemobile')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_buy')." ADD  `receivemobile` varchar(32) DEFAULT NULL;");
}
if(!pdo_fieldexists('imeepos_runner3_buy', 'message')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_buy')." ADD  `message` varchar(640) DEFAULT NULL;");
}
if(!pdo_fieldexists('imeepos_runner3_buy', 'receiverealname')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_buy')." ADD  `receiverealname` varchar(32) DEFAULT NULL;");
}
if(!pdo_fieldexists('imeepos_runner3_buy', 'dianfu')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_buy')." ADD  `dianfu` tinyint(2) DEFAULT NULL;");
}
if(!pdo_fieldexists('imeepos_runner3_buy', 'goodscost')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_buy')." ADD  `goodscost` decimal(10,2) DEFAULT NULL;");
}
if(!pdo_fieldexists('imeepos_runner3_buy', 'goodstitle')) {
	pdo_query("ALTER TABLE ".tablename('imeepos_runner3_buy')." ADD  `goodstitle` varchar(32) DEFAULT NULL;");
}
if (pdo_tableexists('imeepos_runner3_address')) {
    if (!pdo_fieldexists('imeepos_runner3_address', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_address') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_address')) {
    if (!pdo_fieldexists('imeepos_runner3_address', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_address') . " ADD `uniacid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_address')) {
    if (!pdo_fieldexists('imeepos_runner3_address', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_address') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_address')) {
    if (!pdo_fieldexists('imeepos_runner3_address', 'lat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_address') . " ADD `lat` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_address')) {
    if (!pdo_fieldexists('imeepos_runner3_address', 'lng')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_address') . " ADD `lng` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_address')) {
    if (!pdo_fieldexists('imeepos_runner3_address', 'poiaddress')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_address') . " ADD `poiaddress` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_address')) {
    if (!pdo_fieldexists('imeepos_runner3_address', 'poiname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_address') . " ADD `poiname` varchar(128)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_address')) {
    if (!pdo_fieldexists('imeepos_runner3_address', 'cityname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_address') . " ADD `cityname` varchar(128)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_address')) {
    if (!pdo_fieldexists('imeepos_runner3_address', 'detail')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_address') . " ADD `detail` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_address')) {
    if (!pdo_fieldexists('imeepos_runner3_address', 'realname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_address') . " ADD `realname` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_address')) {
    if (!pdo_fieldexists('imeepos_runner3_address', 'mobile')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_address') . " ADD `mobile` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_address')) {
    if (!pdo_fieldexists('imeepos_runner3_address', 'create_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_address') . " ADD `create_at` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_adv')) {
    if (!pdo_fieldexists('imeepos_runner3_adv', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_adv') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_adv')) {
    if (!pdo_fieldexists('imeepos_runner3_adv', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_adv') . " ADD `uniacid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_adv')) {
    if (!pdo_fieldexists('imeepos_runner3_adv', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_adv') . " ADD `title` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_adv')) {
    if (!pdo_fieldexists('imeepos_runner3_adv', 'image')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_adv') . " ADD `image` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_adv')) {
    if (!pdo_fieldexists('imeepos_runner3_adv', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_adv') . " ADD `time` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_adv')) {
    if (!pdo_fieldexists('imeepos_runner3_adv', 'link')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_adv') . " ADD `link` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_adv')) {
    if (!pdo_fieldexists('imeepos_runner3_adv', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_adv') . " ADD `status` tinyint(2)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'freight')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `freight` float(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `title` varchar(132)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'buyprovince')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `buyprovince` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'buycity')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `buycity` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'province')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `province` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'city')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `city` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'address')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `address` varchar(132)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'receivelon')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `receivelon` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'receivelat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `receivelat` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'expectedtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `expectedtime` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'buyaddress')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `buyaddress` varchar(132)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'sendlon')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `sendlon` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'sendlat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `sendlat` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'other')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `other` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'distance')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `distance` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'taskid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `taskid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'limit_time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `limit_time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_buy')) {
    if (!pdo_fieldexists('imeepos_runner3_buy', 'receiveaddress')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_buy') . " ADD `receiveaddress` varchar(132)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_citys')) {
    if (!pdo_fieldexists('imeepos_runner3_citys', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_citys') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_citys')) {
    if (!pdo_fieldexists('imeepos_runner3_citys', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_citys') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_citys')) {
    if (!pdo_fieldexists('imeepos_runner3_citys', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_citys') . " ADD `title` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_citys')) {
    if (!pdo_fieldexists('imeepos_runner3_citys', 'lat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_citys') . " ADD `lat` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_citys')) {
    if (!pdo_fieldexists('imeepos_runner3_citys', 'lng')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_citys') . " ADD `lng` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_code')) {
    if (!pdo_fieldexists('imeepos_runner3_code', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_code') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_code')) {
    if (!pdo_fieldexists('imeepos_runner3_code', 'mobile')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_code') . " ADD `mobile` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_code')) {
    if (!pdo_fieldexists('imeepos_runner3_code', 'code')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_code') . " ADD `code` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_code')) {
    if (!pdo_fieldexists('imeepos_runner3_code', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_code') . " ADD `time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_code')) {
    if (!pdo_fieldexists('imeepos_runner3_code', 'content')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_code') . " ADD `content` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_code')) {
    if (!pdo_fieldexists('imeepos_runner3_code', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_code') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_code')) {
    if (!pdo_fieldexists('imeepos_runner3_code', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_code') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'taskid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `taskid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'goodsweight')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `goodsweight` float(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'goodscost')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `goodscost` float(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'goodsname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `goodsname` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'sendprovince')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `sendprovince` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'sendcity')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `sendcity` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'sendaddress')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `sendaddress` varchar(132)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'receiveprovince')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `receiveprovince` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'receivecity')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `receivecity` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'receiveaddress')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `receiveaddress` varchar(132)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'pickupdate')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `pickupdate` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'sendlon')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `sendlon` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'sendlat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `sendlat` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'receivelon')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `receivelon` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'receivelat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `receivelat` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'distance')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `distance` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'dataTimeValue')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `dataTimeValue` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `time` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'base_fee')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `base_fee` float(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'fee')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `fee` float(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'total')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `total` float(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'images')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `images` varchar(1000)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'message')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `message` varchar(1000)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'senddetail')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `senddetail` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'receivedetail')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `receivedetail` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'receivemobile')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `receivemobile` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'receiverealname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `receiverealname` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'small_money')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `small_money` float(10,2)   DEFAULT 0.00 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_detail')) {
    if (!pdo_fieldexists('imeepos_runner3_detail', 'float_distance')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_detail') . " ADD `float_distance` float(10,2)   DEFAULT 0.00 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_image')) {
    if (!pdo_fieldexists('imeepos_runner3_image', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_image') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_image')) {
    if (!pdo_fieldexists('imeepos_runner3_image', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_image') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_image')) {
    if (!pdo_fieldexists('imeepos_runner3_image', 'src')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_image') . " ADD `src` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_image')) {
    if (!pdo_fieldexists('imeepos_runner3_image', 'code')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_image') . " ADD `code` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_listenlog')) {
    if (!pdo_fieldexists('imeepos_runner3_listenlog', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_listenlog') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_listenlog')) {
    if (!pdo_fieldexists('imeepos_runner3_listenlog', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_listenlog') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_listenlog')) {
    if (!pdo_fieldexists('imeepos_runner3_listenlog', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_listenlog') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_listenlog')) {
    if (!pdo_fieldexists('imeepos_runner3_listenlog', 'create_time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_listenlog') . " ADD `create_time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_listenlog')) {
    if (!pdo_fieldexists('imeepos_runner3_listenlog', 'taskid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_listenlog') . " ADD `taskid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `id` int(11) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `uid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `uniacid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `status` tinyint(2) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'groupid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `groupid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'online')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `online` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'nickname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `nickname` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'avatar')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `avatar` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'gender')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `gender` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'city')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `city` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'provice')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `provice` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'realname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `realname` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'mobile')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `mobile` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'xinyu')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `xinyu` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'isrunner')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `isrunner` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'card_image1')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `card_image1` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'card_image2')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `card_image2` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'cardnum')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `cardnum` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'lat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `lat` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'lng')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `lng` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_member')) {
    if (!pdo_fieldexists('imeepos_runner3_member', 'forbid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_member') . " ADD `forbid` tinyint(4)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_message')) {
    if (!pdo_fieldexists('imeepos_runner3_message', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_message') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_message')) {
    if (!pdo_fieldexists('imeepos_runner3_message', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_message') . " ADD `uniacid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_message')) {
    if (!pdo_fieldexists('imeepos_runner3_message', 'create_time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_message') . " ADD `create_time` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_message')) {
    if (!pdo_fieldexists('imeepos_runner3_message', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_message') . " ADD `status` tinyint(2)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_message')) {
    if (!pdo_fieldexists('imeepos_runner3_message', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_message') . " ADD `title` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_message')) {
    if (!pdo_fieldexists('imeepos_runner3_message', 'link')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_message') . " ADD `link` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_moneylog')) {
    if (!pdo_fieldexists('imeepos_runner3_moneylog', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_moneylog') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_moneylog')) {
    if (!pdo_fieldexists('imeepos_runner3_moneylog', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_moneylog') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_moneylog')) {
    if (!pdo_fieldexists('imeepos_runner3_moneylog', 'reciveid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_moneylog') . " ADD `reciveid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_moneylog')) {
    if (!pdo_fieldexists('imeepos_runner3_moneylog', 'create_time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_moneylog') . " ADD `create_time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_moneylog')) {
    if (!pdo_fieldexists('imeepos_runner3_moneylog', 'fee')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_moneylog') . " ADD `fee` float(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_moneylog')) {
    if (!pdo_fieldexists('imeepos_runner3_moneylog', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_moneylog') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_navs')) {
    if (!pdo_fieldexists('imeepos_runner3_navs', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_navs') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_navs')) {
    if (!pdo_fieldexists('imeepos_runner3_navs', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_navs') . " ADD `uniacid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_navs')) {
    if (!pdo_fieldexists('imeepos_runner3_navs', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_navs') . " ADD `title` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_navs')) {
    if (!pdo_fieldexists('imeepos_runner3_navs', 'link')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_navs') . " ADD `link` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_navs')) {
    if (!pdo_fieldexists('imeepos_runner3_navs', 'icon_on')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_navs') . " ADD `icon_on` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_navs')) {
    if (!pdo_fieldexists('imeepos_runner3_navs', 'icon_off')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_navs') . " ADD `icon_off` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_navs')) {
    if (!pdo_fieldexists('imeepos_runner3_navs', 'create_time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_navs') . " ADD `create_time` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_navs')) {
    if (!pdo_fieldexists('imeepos_runner3_navs', 'displayorder')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_navs') . " ADD `displayorder` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_navs')) {
    if (!pdo_fieldexists('imeepos_runner3_navs', 'ido')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_navs') . " ADD `ido` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_navs')) {
    if (!pdo_fieldexists('imeepos_runner3_navs', 'position')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_navs') . " ADD `position` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_paylog')) {
    if (!pdo_fieldexists('imeepos_runner3_paylog', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_paylog') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_paylog')) {
    if (!pdo_fieldexists('imeepos_runner3_paylog', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_paylog') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_paylog')) {
    if (!pdo_fieldexists('imeepos_runner3_paylog', 'tid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_paylog') . " ADD `tid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_paylog')) {
    if (!pdo_fieldexists('imeepos_runner3_paylog', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_paylog') . " ADD `time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_paylog')) {
    if (!pdo_fieldexists('imeepos_runner3_paylog', 'setting')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_paylog') . " ADD `setting` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_paylog')) {
    if (!pdo_fieldexists('imeepos_runner3_paylog', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_paylog') . " ADD `status` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_paylog')) {
    if (!pdo_fieldexists('imeepos_runner3_paylog', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_paylog') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_paylog')) {
    if (!pdo_fieldexists('imeepos_runner3_paylog', 'fee')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_paylog') . " ADD `fee` float(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_paylog')) {
    if (!pdo_fieldexists('imeepos_runner3_paylog', 'type')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_paylog') . " ADD `type` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_paylog')) {
    if (!pdo_fieldexists('imeepos_runner3_paylog', 'taskid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_paylog') . " ADD `taskid` int(10)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_recive')) {
    if (!pdo_fieldexists('imeepos_runner3_recive', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_recive') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_recive')) {
    if (!pdo_fieldexists('imeepos_runner3_recive', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_recive') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_recive')) {
    if (!pdo_fieldexists('imeepos_runner3_recive', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_recive') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_recive')) {
    if (!pdo_fieldexists('imeepos_runner3_recive', 'taskid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_recive') . " ADD `taskid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_recive')) {
    if (!pdo_fieldexists('imeepos_runner3_recive', 'create_time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_recive') . " ADD `create_time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_recive')) {
    if (!pdo_fieldexists('imeepos_runner3_recive', 'fee')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_recive') . " ADD `fee` float(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_setting')) {
    if (!pdo_fieldexists('imeepos_runner3_setting', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_setting') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_setting')) {
    if (!pdo_fieldexists('imeepos_runner3_setting', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_setting') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_setting')) {
    if (!pdo_fieldexists('imeepos_runner3_setting', 'code')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_setting') . " ADD `code` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_setting')) {
    if (!pdo_fieldexists('imeepos_runner3_setting', 'value')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_setting') . " ADD `value` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_star')) {
    if (!pdo_fieldexists('imeepos_runner3_star', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_star') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_star')) {
    if (!pdo_fieldexists('imeepos_runner3_star', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_star') . " ADD `uniacid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_star')) {
    if (!pdo_fieldexists('imeepos_runner3_star', 'taskid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_star') . " ADD `taskid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_star')) {
    if (!pdo_fieldexists('imeepos_runner3_star', 'from_openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_star') . " ADD `from_openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_star')) {
    if (!pdo_fieldexists('imeepos_runner3_star', 'to_openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_star') . " ADD `to_openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_star')) {
    if (!pdo_fieldexists('imeepos_runner3_star', 'star')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_star') . " ADD `star` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_star')) {
    if (!pdo_fieldexists('imeepos_runner3_star', 'type')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_star') . " ADD `type` tinyint(4)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_star')) {
    if (!pdo_fieldexists('imeepos_runner3_star', 'content')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_star') . " ADD `content` varchar(1000)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_star')) {
    if (!pdo_fieldexists('imeepos_runner3_star', 'create_time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_star') . " ADD `create_time` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `status` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'create_time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `create_time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'cityid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `cityid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'media_id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `media_id` varchar(132)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `desc` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'city')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `city` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'type')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `type` tinyint(4)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'code')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `code` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'qrcode')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `qrcode` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'update_time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `update_time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'total')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `total` float(10,2)   DEFAULT 0.00 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'small_money')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `small_money` float(10,2)   DEFAULT 0.00 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'limit_time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `limit_time` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'address')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `address` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'read_num')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `read_num` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'share_num')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `share_num` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'listen_num')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `listen_num` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks', 'message')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks') . " ADD `message` varchar(320)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks_log')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks_log', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks_log') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks_log')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks_log', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks_log') . " ADD `uniacid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks_log')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks_log', 'taskid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks_log') . " ADD `taskid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks_log')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks_log', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks_log') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks_log')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks_log', 'content')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks_log') . " ADD `content` varchar(1000)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks_log')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks_log', 'create_time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks_log') . " ADD `create_time` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks_log')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks_log', 'lat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks_log') . " ADD `lat` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner3_tasks_log')) {
    if (!pdo_fieldexists('imeepos_runner3_tasks_log', 'lng')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner3_tasks_log') . " ADD `lng` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `id` int(11) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `uniacid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'module')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `module` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'starttime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `starttime` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'endtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `endtime` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'displayorder')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `displayorder` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `title` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'link')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `link` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'image')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `image` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `status` tinyint(2) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'isfull')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `isfull` tinyint(2) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'pid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `pid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'images')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `images` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'set')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `set` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'month')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `month` float(6,2) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'postion')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `postion` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'content')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `content` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_adv')) {
    if (!pdo_fieldexists('imeepos_runner_adv', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_adv') . " ADD `uid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_certify')) {
    if (!pdo_fieldexists('imeepos_runner_apply_certify', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_certify') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_certify')) {
    if (!pdo_fieldexists('imeepos_runner_apply_certify', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_certify') . " ADD `uid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_certify')) {
    if (!pdo_fieldexists('imeepos_runner_apply_certify', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_certify') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_certify')) {
    if (!pdo_fieldexists('imeepos_runner_apply_certify', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_certify') . " ADD `time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_certify')) {
    if (!pdo_fieldexists('imeepos_runner_apply_certify', 'price')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_certify') . " ADD `price` decimal(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_certify')) {
    if (!pdo_fieldexists('imeepos_runner_apply_certify', 'state')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_certify') . " ADD `state` tinyint(4) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_certify')) {
    if (!pdo_fieldexists('imeepos_runner_apply_certify', 'certify_id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_certify') . " ADD `certify_id` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_certify')) {
    if (!pdo_fieldexists('imeepos_runner_apply_certify', 'created_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_certify') . " ADD `created_at` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_certify')) {
    if (!pdo_fieldexists('imeepos_runner_apply_certify', 'updated_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_certify') . " ADD `updated_at` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_certify')) {
    if (!pdo_fieldexists('imeepos_runner_apply_certify', 'delete_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_certify') . " ADD `delete_at` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_service')) {
    if (!pdo_fieldexists('imeepos_runner_apply_service', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_service') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_service')) {
    if (!pdo_fieldexists('imeepos_runner_apply_service', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_service') . " ADD `uniacid` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_service')) {
    if (!pdo_fieldexists('imeepos_runner_apply_service', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_service') . " ADD `uid` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_service')) {
    if (!pdo_fieldexists('imeepos_runner_apply_service', 'service_type_id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_service') . " ADD `service_type_id` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_service')) {
    if (!pdo_fieldexists('imeepos_runner_apply_service', 'state')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_service') . " ADD `state` tinyint(4) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_service')) {
    if (!pdo_fieldexists('imeepos_runner_apply_service', 'note')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_service') . " ADD `note` varchar(255) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_service')) {
    if (!pdo_fieldexists('imeepos_runner_apply_service', 'created_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_service') . " ADD `created_at` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_service')) {
    if (!pdo_fieldexists('imeepos_runner_apply_service', 'updated_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_service') . " ADD `updated_at` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_apply_service')) {
    if (!pdo_fieldexists('imeepos_runner_apply_service', 'delete_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_apply_service') . " ADD `delete_at` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_awards')) {
    if (!pdo_fieldexists('imeepos_runner_awards', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_awards') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_awards')) {
    if (!pdo_fieldexists('imeepos_runner_awards', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_awards') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_awards')) {
    if (!pdo_fieldexists('imeepos_runner_awards', 'condition')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_awards') . " ADD `condition` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_awards')) {
    if (!pdo_fieldexists('imeepos_runner_awards', 'value')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_awards') . " ADD `value` decimal(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_awards')) {
    if (!pdo_fieldexists('imeepos_runner_awards', 'type')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_awards') . " ADD `type` tinyint(4)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_certify')) {
    if (!pdo_fieldexists('imeepos_runner_certify', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_certify') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_certify')) {
    if (!pdo_fieldexists('imeepos_runner_certify', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_certify') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_certify')) {
    if (!pdo_fieldexists('imeepos_runner_certify', 'name')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_certify') . " ADD `name` varchar(60)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_certify')) {
    if (!pdo_fieldexists('imeepos_runner_certify', 'ename')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_certify') . " ADD `ename` varchar(60)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_certify')) {
    if (!pdo_fieldexists('imeepos_runner_certify', 'is_valid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_certify') . " ADD `is_valid` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_certify')) {
    if (!pdo_fieldexists('imeepos_runner_certify', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_certify') . " ADD `time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_certify')) {
    if (!pdo_fieldexists('imeepos_runner_certify', 'icon')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_certify') . " ADD `icon` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_certify')) {
    if (!pdo_fieldexists('imeepos_runner_certify', 'price')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_certify') . " ADD `price` decimal(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_certify')) {
    if (!pdo_fieldexists('imeepos_runner_certify', 'timelong')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_certify') . " ADD `timelong` int(4)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_class')) {
    if (!pdo_fieldexists('imeepos_runner_class', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_class') . " ADD `id` int(11) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_class')) {
    if (!pdo_fieldexists('imeepos_runner_class', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_class') . " ADD `uniacid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_class')) {
    if (!pdo_fieldexists('imeepos_runner_class', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_class') . " ADD `title` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_class')) {
    if (!pdo_fieldexists('imeepos_runner_class', 'icon')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_class') . " ADD `icon` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_class')) {
    if (!pdo_fieldexists('imeepos_runner_class', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_class') . " ADD `desc` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_class')) {
    if (!pdo_fieldexists('imeepos_runner_class', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_class') . " ADD `time` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_class')) {
    if (!pdo_fieldexists('imeepos_runner_class', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_class') . " ADD `status` tinyint(2) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_class')) {
    if (!pdo_fieldexists('imeepos_runner_class', 'module')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_class') . " ADD `module` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_class')) {
    if (!pdo_fieldexists('imeepos_runner_class', 'set')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_class') . " ADD `set` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_class')) {
    if (!pdo_fieldexists('imeepos_runner_class', 'link')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_class') . " ADD `link` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_father')) {
    if (!pdo_fieldexists('imeepos_runner_father', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_father') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_father')) {
    if (!pdo_fieldexists('imeepos_runner_father', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_father') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_father')) {
    if (!pdo_fieldexists('imeepos_runner_father', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_father') . " ADD `openid` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_father')) {
    if (!pdo_fieldexists('imeepos_runner_father', 'fid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_father') . " ADD `fid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_father')) {
    if (!pdo_fieldexists('imeepos_runner_father', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_father') . " ADD `time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_feedback')) {
    if (!pdo_fieldexists('imeepos_runner_feedback', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_feedback') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_feedback')) {
    if (!pdo_fieldexists('imeepos_runner_feedback', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_feedback') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_feedback')) {
    if (!pdo_fieldexists('imeepos_runner_feedback', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_feedback') . " ADD `uid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_feedback')) {
    if (!pdo_fieldexists('imeepos_runner_feedback', 'content')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_feedback') . " ADD `content` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_feedback')) {
    if (!pdo_fieldexists('imeepos_runner_feedback', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_feedback') . " ADD `time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_feedback')) {
    if (!pdo_fieldexists('imeepos_runner_feedback', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_feedback') . " ADD `status` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_feedback')) {
    if (!pdo_fieldexists('imeepos_runner_feedback', 'nickname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_feedback') . " ADD `nickname` varchar(60)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_feedback')) {
    if (!pdo_fieldexists('imeepos_runner_feedback', 'mobile')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_feedback') . " ADD `mobile` varchar(60)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `id` int(11) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `uniacid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'module')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `module` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `title` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'link')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `link` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `status` tinyint(2) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'starttime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `starttime` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'endtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `endtime` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'content')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `content` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'tag')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `tag` varchar(300) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `time` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'displayorder')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `displayorder` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'num')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `num` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_gonggao')) {
    if (!pdo_fieldexists('imeepos_runner_gonggao', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_gonggao') . " ADD `desc` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_log')) {
    if (!pdo_fieldexists('imeepos_runner_log', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_log') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_log')) {
    if (!pdo_fieldexists('imeepos_runner_log', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_log') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_log')) {
    if (!pdo_fieldexists('imeepos_runner_log', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_log') . " ADD `openid` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_log')) {
    if (!pdo_fieldexists('imeepos_runner_log', 'type')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_log') . " ADD `type` tinyint(3)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_log')) {
    if (!pdo_fieldexists('imeepos_runner_log', 'logno')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_log') . " ADD `logno` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_log')) {
    if (!pdo_fieldexists('imeepos_runner_log', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_log') . " ADD `title` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_log')) {
    if (!pdo_fieldexists('imeepos_runner_log', 'createtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_log') . " ADD `createtime` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_log')) {
    if (!pdo_fieldexists('imeepos_runner_log', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_log') . " ADD `status` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_log')) {
    if (!pdo_fieldexists('imeepos_runner_log', 'money')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_log') . " ADD `money` decimal(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_log')) {
    if (!pdo_fieldexists('imeepos_runner_log', 'rechargetype')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_log') . " ADD `rechargetype` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_log')) {
    if (!pdo_fieldexists('imeepos_runner_log', 'transid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_log') . " ADD `transid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_log')) {
    if (!pdo_fieldexists('imeepos_runner_log', 'zeng')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_log') . " ADD `zeng` decimal(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_markets')) {
    if (!pdo_fieldexists('imeepos_runner_markets', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_markets') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_markets')) {
    if (!pdo_fieldexists('imeepos_runner_markets', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_markets') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_markets')) {
    if (!pdo_fieldexists('imeepos_runner_markets', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_markets') . " ADD `title` varchar(60)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_markets')) {
    if (!pdo_fieldexists('imeepos_runner_markets', 'condition')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_markets') . " ADD `condition` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_markets')) {
    if (!pdo_fieldexists('imeepos_runner_markets', 'value')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_markets') . " ADD `value` decimal(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_markets')) {
    if (!pdo_fieldexists('imeepos_runner_markets', 'type')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_markets') . " ADD `type` tinyint(4)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `id` int(11) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `uid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `uniacid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `status` tinyint(2) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'groupid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `groupid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'fid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `fid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'credit_red')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `credit_red` decimal(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'credit_deposit')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `credit_deposit` decimal(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'is_runner')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `is_runner` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'credit_runner')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `credit_runner` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'credit_member')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `credit_member` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'qr')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `qr` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'scan')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `scan` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member')) {
    if (!pdo_fieldexists('imeepos_runner_member', 'online')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member') . " ADD `online` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_level')) {
    if (!pdo_fieldexists('imeepos_runner_member_level', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_level') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_level')) {
    if (!pdo_fieldexists('imeepos_runner_member_level', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_level') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_level')) {
    if (!pdo_fieldexists('imeepos_runner_member_level', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_level') . " ADD `title` varchar(60)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_level')) {
    if (!pdo_fieldexists('imeepos_runner_member_level', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_level') . " ADD `desc` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_level')) {
    if (!pdo_fieldexists('imeepos_runner_member_level', 'startnum')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_level') . " ADD `startnum` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_level')) {
    if (!pdo_fieldexists('imeepos_runner_member_level', 'ionc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_level') . " ADD `ionc` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_level')) {
    if (!pdo_fieldexists('imeepos_runner_member_level', 'level')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_level') . " ADD `level` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_member_paylog', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_paylog') . " ADD `id` int(11) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_member_paylog', 'groupid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_paylog') . " ADD `groupid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_member_paylog', 'fee')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_paylog') . " ADD `fee` float(8,2) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_member_paylog', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_paylog') . " ADD `title` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_member_paylog', 'createtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_paylog') . " ADD `createtime` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_member_paylog', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_paylog') . " ADD `status` tinyint(2) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_member_paylog', 'transid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_paylog') . " ADD `transid` varchar(64) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_member_paylog', 'ordersn')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_paylog') . " ADD `ordersn` varchar(64) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_member_paylog', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_paylog') . " ADD `uniacid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_member_paylog', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_paylog') . " ADD `uid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_member_paylog', 'runnerid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_paylog') . " ADD `runnerid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `uid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'realname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `realname` varchar(60)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'age')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `age` int(6)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'tools')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `tools` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'diverpic')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `diverpic` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'cardpic1')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `cardpic1` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'cardpic2')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `cardpic2` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'createtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `createtime` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'latitude')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `latitude` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'longitude')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `longitude` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'mobile')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `mobile` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'wechat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `wechat` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_member_profile')) {
    if (!pdo_fieldexists('imeepos_runner_member_profile', 'cardnum')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_member_profile') . " ADD `cardnum` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_message')) {
    if (!pdo_fieldexists('imeepos_runner_message', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_message') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_message')) {
    if (!pdo_fieldexists('imeepos_runner_message', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_message') . " ADD `uniacid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_message')) {
    if (!pdo_fieldexists('imeepos_runner_message', 'fopenid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_message') . " ADD `fopenid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_message')) {
    if (!pdo_fieldexists('imeepos_runner_message', 'topenid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_message') . " ADD `topenid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_message')) {
    if (!pdo_fieldexists('imeepos_runner_message', 'content')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_message') . " ADD `content` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_message')) {
    if (!pdo_fieldexists('imeepos_runner_message', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_message') . " ADD `status` tinyint(2)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_message')) {
    if (!pdo_fieldexists('imeepos_runner_message', 'createtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_message') . " ADD `createtime` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_message')) {
    if (!pdo_fieldexists('imeepos_runner_message', 'readtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_message') . " ADD `readtime` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_message')) {
    if (!pdo_fieldexists('imeepos_runner_message', 'replytime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_message') . " ADD `replytime` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_message')) {
    if (!pdo_fieldexists('imeepos_runner_message', 'replayid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_message') . " ADD `replayid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template') . " ADD `uniacid` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template') . " ADD `title` varchar(500) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template', 'tpl_id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template') . " ADD `tpl_id` varchar(100) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template', 'template')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template') . " ADD `template` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template', 'tags')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template') . " ADD `tags` varchar(1000) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template', 'set')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template') . " ADD `set` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template', 'type')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template') . " ADD `type` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template_data')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template_data', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template_data') . " ADD `id` int(11) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template_data')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template_data', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template_data') . " ADD `title` varchar(52) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template_data')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template_data', 'set')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template_data') . " ADD `set` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template_data')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template_data', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template_data') . " ADD `uniacid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_msg_template_data')) {
    if (!pdo_fieldexists('imeepos_runner_msg_template_data', 'tpl_id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_msg_template_data') . " ADD `tpl_id` varchar(124) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_certify')) {
    if (!pdo_fieldexists('imeepos_runner_my_certify', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_certify') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_certify')) {
    if (!pdo_fieldexists('imeepos_runner_my_certify', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_certify') . " ADD `uid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_certify')) {
    if (!pdo_fieldexists('imeepos_runner_my_certify', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_certify') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_certify')) {
    if (!pdo_fieldexists('imeepos_runner_my_certify', 'certify_id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_certify') . " ADD `certify_id` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_certify')) {
    if (!pdo_fieldexists('imeepos_runner_my_certify', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_certify') . " ADD `time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_services')) {
    if (!pdo_fieldexists('imeepos_runner_my_services', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_services') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_services')) {
    if (!pdo_fieldexists('imeepos_runner_my_services', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_services') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_services')) {
    if (!pdo_fieldexists('imeepos_runner_my_services', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_services') . " ADD `uid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_services')) {
    if (!pdo_fieldexists('imeepos_runner_my_services', 'services_id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_services') . " ADD `services_id` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_services')) {
    if (!pdo_fieldexists('imeepos_runner_my_services', 'price')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_services') . " ADD `price` decimal(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_services')) {
    if (!pdo_fieldexists('imeepos_runner_my_services', 'created_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_services') . " ADD `created_at` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_services')) {
    if (!pdo_fieldexists('imeepos_runner_my_services', 'update_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_services') . " ADD `update_at` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_my_services')) {
    if (!pdo_fieldexists('imeepos_runner_my_services', 'delete_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_my_services') . " ADD `delete_at` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_nav')) {
    if (!pdo_fieldexists('imeepos_runner_nav', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_nav') . " ADD `id` int(11) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_nav')) {
    if (!pdo_fieldexists('imeepos_runner_nav', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_nav') . " ADD `uniacid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_nav')) {
    if (!pdo_fieldexists('imeepos_runner_nav', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_nav') . " ADD `title` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_nav')) {
    if (!pdo_fieldexists('imeepos_runner_nav', 'icon')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_nav') . " ADD `icon` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_nav')) {
    if (!pdo_fieldexists('imeepos_runner_nav', 'link')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_nav') . " ADD `link` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_nav')) {
    if (!pdo_fieldexists('imeepos_runner_nav', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_nav') . " ADD `time` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_nav')) {
    if (!pdo_fieldexists('imeepos_runner_nav', 'module')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_nav') . " ADD `module` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_nav')) {
    if (!pdo_fieldexists('imeepos_runner_nav', 'type')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_nav') . " ADD `type` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_nav')) {
    if (!pdo_fieldexists('imeepos_runner_nav', 'displayorder')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_nav') . " ADD `displayorder` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_nav')) {
    if (!pdo_fieldexists('imeepos_runner_nav', 'postion')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_nav') . " ADD `postion` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_nav')) {
    if (!pdo_fieldexists('imeepos_runner_nav', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_nav') . " ADD `status` tinyint(2) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_page')) {
    if (!pdo_fieldexists('imeepos_runner_page', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_page') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_page')) {
    if (!pdo_fieldexists('imeepos_runner_page', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_page') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_page')) {
    if (!pdo_fieldexists('imeepos_runner_page', 'datas')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_page') . " ADD `datas` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_page')) {
    if (!pdo_fieldexists('imeepos_runner_page', 'savetime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_page') . " ADD `savetime` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_page')) {
    if (!pdo_fieldexists('imeepos_runner_page', 'pagetype')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_page') . " ADD `pagetype` tinyint(6)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_page')) {
    if (!pdo_fieldexists('imeepos_runner_page', 'pageinfo')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_page') . " ADD `pageinfo` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_page')) {
    if (!pdo_fieldexists('imeepos_runner_page', 'pagename')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_page') . " ADD `pagename` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_page')) {
    if (!pdo_fieldexists('imeepos_runner_page', 'keyword')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_page') . " ADD `keyword` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_page')) {
    if (!pdo_fieldexists('imeepos_runner_page', 'createtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_page') . " ADD `createtime` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_page')) {
    if (!pdo_fieldexists('imeepos_runner_page', 'setdefault')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_page') . " ADD `setdefault` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_paylog', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_paylog') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_paylog', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_paylog') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_paylog', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_paylog') . " ADD `openid` varchar(40)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_paylog', 'tid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_paylog') . " ADD `tid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_paylog', 'fee')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_paylog') . " ADD `fee` decimal(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_paylog', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_paylog') . " ADD `status` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_paylog', 'type')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_paylog') . " ADD `type` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_paylog', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_paylog') . " ADD `time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_paylog', 'actiontype')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_paylog') . " ADD `actiontype` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_paylog', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_paylog') . " ADD `title` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_paylog')) {
    if (!pdo_fieldexists('imeepos_runner_paylog', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_paylog') . " ADD `uid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_rule')) {
    if (!pdo_fieldexists('imeepos_runner_rule', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_rule') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_rule')) {
    if (!pdo_fieldexists('imeepos_runner_rule', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_rule') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_rule')) {
    if (!pdo_fieldexists('imeepos_runner_rule', 'rid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_rule') . " ADD `rid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_rule')) {
    if (!pdo_fieldexists('imeepos_runner_rule', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_rule') . " ADD `title` varchar(60)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_rule')) {
    if (!pdo_fieldexists('imeepos_runner_rule', 'content')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_rule') . " ADD `content` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_rule')) {
    if (!pdo_fieldexists('imeepos_runner_rule', 'img')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_rule') . " ADD `img` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_rule')) {
    if (!pdo_fieldexists('imeepos_runner_rule', 'url')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_rule') . " ADD `url` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner')) {
    if (!pdo_fieldexists('imeepos_runner_runner', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner')) {
    if (!pdo_fieldexists('imeepos_runner_runner', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner')) {
    if (!pdo_fieldexists('imeepos_runner_runner', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner') . " ADD `uid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner')) {
    if (!pdo_fieldexists('imeepos_runner_runner', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner') . " ADD `time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner')) {
    if (!pdo_fieldexists('imeepos_runner_runner', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner') . " ADD `status` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner')) {
    if (!pdo_fieldexists('imeepos_runner_runner', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner') . " ADD `desc` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner')) {
    if (!pdo_fieldexists('imeepos_runner_runner', 'groupid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner') . " ADD `groupid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner')) {
    if (!pdo_fieldexists('imeepos_runner_runner', 'isonline')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner') . " ADD `isonline` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner_level')) {
    if (!pdo_fieldexists('imeepos_runner_runner_level', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner_level') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner_level')) {
    if (!pdo_fieldexists('imeepos_runner_runner_level', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner_level') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner_level')) {
    if (!pdo_fieldexists('imeepos_runner_runner_level', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner_level') . " ADD `title` varchar(60)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner_level')) {
    if (!pdo_fieldexists('imeepos_runner_runner_level', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner_level') . " ADD `desc` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner_level')) {
    if (!pdo_fieldexists('imeepos_runner_runner_level', 'startnum')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner_level') . " ADD `startnum` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner_level')) {
    if (!pdo_fieldexists('imeepos_runner_runner_level', 'ionc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner_level') . " ADD `ionc` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner_level')) {
    if (!pdo_fieldexists('imeepos_runner_runner_level', 'level')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner_level') . " ADD `level` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner_level')) {
    if (!pdo_fieldexists('imeepos_runner_runner_level', 'price')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner_level') . " ADD `price` decimal(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_runner_level')) {
    if (!pdo_fieldexists('imeepos_runner_runner_level', 'isdefault')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_runner_level') . " ADD `isdefault` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_services')) {
    if (!pdo_fieldexists('imeepos_runner_services', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_services') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_services')) {
    if (!pdo_fieldexists('imeepos_runner_services', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_services') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_services')) {
    if (!pdo_fieldexists('imeepos_runner_services', 'name')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_services') . " ADD `name` varchar(60)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_services')) {
    if (!pdo_fieldexists('imeepos_runner_services', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_services') . " ADD `desc` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_services')) {
    if (!pdo_fieldexists('imeepos_runner_services', 'price')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_services') . " ADD `price` decimal(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_services')) {
    if (!pdo_fieldexists('imeepos_runner_services', 'imgurl')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_services') . " ADD `imgurl` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_services')) {
    if (!pdo_fieldexists('imeepos_runner_services', 'state')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_services') . " ADD `state` tinyint(4)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_services')) {
    if (!pdo_fieldexists('imeepos_runner_services', 'usort')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_services') . " ADD `usort` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_services')) {
    if (!pdo_fieldexists('imeepos_runner_services', 'create_ar')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_services') . " ADD `create_ar` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_services')) {
    if (!pdo_fieldexists('imeepos_runner_services', 'updated_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_services') . " ADD `updated_at` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_services')) {
    if (!pdo_fieldexists('imeepos_runner_services', 'tumelong')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_services') . " ADD `tumelong` int(4)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'invitecode')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `invitecode` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'set')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `set` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'about')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `about` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'seo')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `seo` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'share')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `share` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'themes')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `themes` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'tasks')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `tasks` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'juhe')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `juhe` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'template_message')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `template_message` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'widthdraw')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `widthdraw` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'renren')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `renren` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_settings')) {
    if (!pdo_fieldexists('imeepos_runner_settings', 'renren_city')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_settings') . " ADD `renren_city` text NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `uniacid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'cid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `cid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `title` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `desc` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'content')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `content` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'mobile')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `mobile` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'wechat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `wechat` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'createtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `createtime` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'image')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `image` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'thumbs')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `thumbs` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `status` tinyint(2)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'displayorder')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `displayorder` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'icon')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `icon` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `uid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'opentime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `opentime` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop')) {
    if (!pdo_fieldexists('imeepos_runner_shop', 'address')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop') . " ADD `address` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_class')) {
    if (!pdo_fieldexists('imeepos_runner_shop_class', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_class') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_class')) {
    if (!pdo_fieldexists('imeepos_runner_shop_class', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_class') . " ADD `uniacid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_class')) {
    if (!pdo_fieldexists('imeepos_runner_shop_class', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_class') . " ADD `title` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_class')) {
    if (!pdo_fieldexists('imeepos_runner_shop_class', 'icon')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_class') . " ADD `icon` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_class')) {
    if (!pdo_fieldexists('imeepos_runner_shop_class', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_class') . " ADD `time` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_class')) {
    if (!pdo_fieldexists('imeepos_runner_shop_class', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_class') . " ADD `desc` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_class')) {
    if (!pdo_fieldexists('imeepos_runner_shop_class', 'fid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_class') . " ADD `fid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_class')) {
    if (!pdo_fieldexists('imeepos_runner_shop_class', 'setting')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_class') . " ADD `setting` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_class')) {
    if (!pdo_fieldexists('imeepos_runner_shop_class', 'displayorder')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_class') . " ADD `displayorder` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `uniacid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'cid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `cid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `title` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `desc` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'image')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `image` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'thumbs')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `thumbs` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'createtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `createtime` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'fee')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `fee` decimal(10,2)   DEFAULT 0.00 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'shopid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `shopid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `status` tinyint(2)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'address')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `address` varchar(300)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'displayorder')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `displayorder` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'opentime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `opentime` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_shop_goods')) {
    if (!pdo_fieldexists('imeepos_runner_shop_goods', 'endtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_shop_goods') . " ADD `endtime` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_sms')) {
    if (!pdo_fieldexists('imeepos_runner_sms', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_sms') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_sms')) {
    if (!pdo_fieldexists('imeepos_runner_sms', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_sms') . " ADD `uniacid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_sms')) {
    if (!pdo_fieldexists('imeepos_runner_sms', 'code')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_sms') . " ADD `code` varchar(10)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_sms')) {
    if (!pdo_fieldexists('imeepos_runner_sms', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_sms') . " ADD `time` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_sms')) {
    if (!pdo_fieldexists('imeepos_runner_sms', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_sms') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_sms')) {
    if (!pdo_fieldexists('imeepos_runner_sms', 'mobile')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_sms') . " ADD `mobile` varchar(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `id` int(11) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `uniacid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `uid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'oauth_openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `oauth_openid` varchar(64) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `openid` varchar(64) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `desc` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'cid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `cid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'fee')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `fee` float(11,2) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'nickname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `nickname` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'realname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `realname` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'mobile')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `mobile` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `status` tinyint(2) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'module')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `module` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'createtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `createtime` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'transid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `transid` varchar(64) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'displayorder')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `displayorder` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'ordersn')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `ordersn` varchar(64) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'startlat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `startlat` double NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'startlng')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `startlng` double NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'endlat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `endlat` double NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'endlng')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `endlng` double NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'startaddress')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `startaddress` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'endaddress')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `endaddress` varchar(132) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'look_num')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `look_num` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'share_num')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `share_num` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'sheng_num')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `sheng_num` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'zhong_num')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `zhong_num` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'jing_num')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `jing_num` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'total_num')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `total_num` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'thumbs')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `thumbs` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'postrealname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `postrealname` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'postmobile')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `postmobile` varchar(32) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'recivemobile')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `recivemobile` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'reciverealname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `reciverealname` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'starttime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `starttime` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'endtime')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `endtime` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'peoplelimit')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `peoplelimit` int(3)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'lessfee')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `lessfee` decimal(11,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'kglimit')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `kglimit` decimal(5,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'unitname')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `unitname` varchar(32)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'timelimit')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `timelimit` decimal(6,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'addresslimit')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `addresslimit` decimal(6,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'totalfee')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `totalfee` float(10,2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'limitgender')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `limitgender` tinyint(2)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks')) {
    if (!pdo_fieldexists('imeepos_runner_tasks', 'setting')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks') . " ADD `setting` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'taskid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `taskid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `uniacid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `title` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'ratting1')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `ratting1` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'ratting2')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `ratting2` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'ratting3')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `ratting3` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'fuid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `fuid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'tuid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `tuid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `time` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `desc` text    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'type')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `type` tinyint(4)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_comment')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_comment', 'reciveid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_comment') . " ADD `reciveid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive') . " ADD `id` int(11) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive', 'from_uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive') . " ADD `from_uniacid` int(32) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive', 'to_uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive') . " ADD `to_uniacid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive', 'from_uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive') . " ADD `from_uid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive', 'to_uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive') . " ADD `to_uid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive', 'from_openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive') . " ADD `from_openid` varchar(64) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive', 'to_openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive') . " ADD `to_openid` varchar(64) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive', 'taskid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive') . " ADD `taskid` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive') . " ADD `status` tinyint(2) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive') . " ADD `time` int(11) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive', 'reciveid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive') . " ADD `reciveid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive_active')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive_active', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive_active') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive_active')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive_active', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive_active') . " ADD `uniacid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive_active')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive_active', 'uid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive_active') . " ADD `uid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive_active')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive_active', 'reciveid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive_active') . " ADD `reciveid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive_active')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive_active', 'taskid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive_active') . " ADD `taskid` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive_active')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive_active', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive_active') . " ADD `openid` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive_active')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive_active', 'lat')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive_active') . " ADD `lat` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive_active')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive_active', 'lng')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive_active') . " ADD `lng` varchar(64)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive_active')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive_active', 'address')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive_active') . " ADD `address` varchar(128)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive_active')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive_active', 'time')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive_active') . " ADD `time` int(11)   DEFAULT 0 COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_tasks_recive_active')) {
    if (!pdo_fieldexists('imeepos_runner_tasks_recive_active', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_tasks_recive_active') . " ADD `desc` varchar(200)    COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_users_invitecode')) {
    if (!pdo_fieldexists('imeepos_runner_users_invitecode', 'user_id')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_users_invitecode') . " ADD `user_id` int(10) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_users_invitecode')) {
    if (!pdo_fieldexists('imeepos_runner_users_invitecode', 'invite_code')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_users_invitecode') . " ADD `invite_code` char(16) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_users_invitecode')) {
    if (!pdo_fieldexists('imeepos_runner_users_invitecode', 'invite_counts')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_users_invitecode') . " ADD `invite_counts` int(10) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_users_invitecode')) {
    if (!pdo_fieldexists('imeepos_runner_users_invitecode', 'created_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_users_invitecode') . " ADD `created_at` int(10) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_users_invitecode')) {
    if (!pdo_fieldexists('imeepos_runner_users_invitecode', 'updated_at')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_users_invitecode') . " ADD `updated_at` int(10) unsigned NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('imeepos_runner_users_invitecode')) {
    if (!pdo_fieldexists('imeepos_runner_users_invitecode', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('imeepos_runner_users_invitecode') . " ADD `uniacid` int(10) unsigned NOT NULL   COMMENT '';");
    }
}