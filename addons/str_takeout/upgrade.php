<?php
if(!pdo_tableexists('str_order_print')) {
	pdo_query("CREATE TABLE IF NOT EXISTS `ims_str_order_print` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
		  `sid` int(10) unsigned NOT NULL DEFAULT '0',
		  `pid` tinyint(3) unsigned NOT NULL DEFAULT '0',
		  `oid` int(10) unsigned NOT NULL DEFAULT '0',
		  `foid` varchar(50) NOT NULL,
		  `status` tinyint(3) unsigned NOT NULL DEFAULT '2',
		  `addtime` int(10) unsigned NOT NULL,
		  PRIMARY KEY (`id`),
		  KEY `addtime` (`addtime`),
		  KEY `foid` (`foid`),
		  KEY `uniacid` (`uniacid`),
		  KEY `pid` (`pid`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
	");
}
$sql = "
CREATE TABLE IF NOT EXISTS `ims_str_print` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
		  `sid` int(10) unsigned NOT NULL,
		  `name` varchar(20) NOT NULL,
		  `print_no` varchar(30) NOT NULL,
		  `key` varchar(30) NOT NULL,
		  `print_nums` tinyint(3) unsigned NOT NULL DEFAULT '1',
		  `qrcode_link` varchar(100) NOT NULL,
		  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
		  PRIMARY KEY (`id`),
		  KEY `uniacid` (`uniacid`),
		  KEY `sid` (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `ims_str_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `realname` varchar(15) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `is_verify` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `address` varchar(50) NOT NULL,
  `is_default` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_area` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(30) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_assign_board` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `queue_id` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `mobile` varchar(15) NOT NULL,
  `openid` varchar(64) NOT NULL,
  `guest_num` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `number` varchar(20) NOT NULL,
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `is_notify` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_assign_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(20) NOT NULL,
  `guest_num` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `notify_num` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `starttime` varchar(10) NOT NULL,
  `endtime` varchar(10) NOT NULL,
  `prefix` varchar(10) NOT NULL COMMENT '前缀',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `position` int(10) unsigned NOT NULL DEFAULT '1',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '根据这个时间,判断是否将position重新至0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_clerk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(15) NOT NULL,
  `nickname` varchar(15) NOT NULL,
  `openid` varchar(60) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `is_sys` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(20) NOT NULL,
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  `guest_num` tinyint(3) unsigned DEFAULT '0',
  `scan_num` int(10) unsigned NOT NULL DEFAULT '0',
  `qrcode` varchar(500) NOT NULL,
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid_sid` (`uniacid`,`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_tables_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(20) NOT NULL,
  `limit_price` varchar(20) NOT NULL,
  `reservation_price` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_tables_scan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `table_id` int(10) unsigned NOT NULL DEFAULT '0',
  `openid` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `sid` (`sid`),
  KEY `table_id` (`table_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_user_trash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(15) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `sid` (`sid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `realname` varchar(20) CHARACTER SET latin1 NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `rid` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `table_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_reserve` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `time` varchar(15) NOT NULL,
  `table_cid` int(10) unsigned NOT NULL DEFAULT '0',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_stat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `dish_id` int(10) unsigned NOT NULL DEFAULT '0',
  `dish_num` int(10) unsigned NOT NULL DEFAULT '0',
  `dish_title` varchar(30) NOT NULL,
  `dish_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `addtime` int(10) NOT NULL DEFAULT '0',
  `is_complete` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `sid` (`sid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_order_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `groupid` int(10) unsigned NOT NULL DEFAULT '0',
  `num` int(10) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `grant_credit` int(10) unsigned NOT NULL DEFAULT '0',
  `data` varchar(3000) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid_sid` (`uniacid`,`sid`),
  KEY `uid` (`uniacid`,`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_order_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `taste` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `serve` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `speed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL,
  `addtime` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `sid` (`sid`),
  KEY `oid` (`oid`),
  KEY `addtime` (`addtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_str_order_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0',
  `sid` int(10) unsigned NOT NULL DEFAULT '0',
  `oid` int(10) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) NOT NULL,
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `sid` (`sid`),
  KEY `oid` (`oid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
";
pdo_query($sql);

if(!pdo_fieldexists('str_order', 'print_nums')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD `print_nums` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' AFTER `comment`;");
}
if(!pdo_fieldexists('str_store', 'notice_acid')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD `notice_acid` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `displayorder`;");
}
if(!pdo_fieldexists('str_store', 'groupid')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD `groupid` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `notice_acid`;");
}
if(!pdo_fieldexists('str_store', 'mobile')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD  `mobile` VARCHAR(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接收短信的手机';");
}
if(!pdo_fieldexists('str_store', 'is_sms')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD `is_sms` INT(10) NOT NULL COMMENT '是否开启短信';");
}
if(!pdo_fieldexists('str_store', 'sms_id')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD `sms_id` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '短信模板ID';");
}		
if(!pdo_fieldexists('str_config', 'version')) {
	pdo_query("ALTER TABLE ".tablename('str_config')." ADD  `version` tinyint(3) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('str_config', 'default_sid')) {
	pdo_query("ALTER TABLE ".tablename('str_config')." ADD  `default_sid` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('str_config', 'sms')) {
	pdo_query("ALTER TABLE ".tablename('str_config')." ADD  `sms` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('str_config', 'notice')) {
	pdo_query("ALTER TABLE ".tablename('str_config')." ADD  `notice` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists('str_config', 'area_search')) {
	pdo_query("ALTER TABLE ".tablename('str_config')." ADD  `area_search` tinyint(3) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('str_config', 'num_limit')) {
	pdo_query("ALTER TABLE ".tablename('str_config')." ADD  `num_limit` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '门店数量限制';");
} 
if(!pdo_fieldexists('str_dish', 'unitname')) {
	pdo_query("ALTER TABLE ".tablename('str_dish')." ADD `unitname` varchar(10) NOT NULL DEFAULT '份';");
} 
if(!pdo_fieldexists('str_dish', 'grant_credit')) {
	pdo_query("ALTER TABLE ".tablename('str_dish')." ADD  `grant_credit` int(10) unsigned NOT NULL DEFAULT '0';");
} 
if(!pdo_fieldexists('str_dish', 'recommend')) {
	pdo_query("ALTER TABLE ".tablename('str_dish')." ADD `recommend` tinyint(3) unsigned NOT NULL DEFAULT '2';");
} 
if(!pdo_fieldexists('str_dish', 'label')) {
	pdo_query("ALTER TABLE ".tablename('str_dish')." ADD  `label` varchar(5) NOT NULL;");
} 
if(!pdo_fieldexists('str_dish', 'show_group_price')) {
	pdo_query("ALTER TABLE ".tablename('str_dish')." ADD  `show_group_price` tinyint(3) unsigned NOT NULL DEFAULT '1';");
} 
if(!pdo_fieldexists('str_dish', 'first_order_limit')) {
	pdo_query("ALTER TABLE ".tablename('str_dish')." ADD  `first_order_limit` tinyint(3) unsigned NOT NULL DEFAULT '2';");
} 
if(!pdo_fieldexists('str_dish', 'buy_limit')) {
	pdo_query("ALTER TABLE ".tablename('str_dish')." ADD  `buy_limit` tinyint(3) unsigned NOT NULL DEFAULT '0';");
} 
if(!pdo_fieldexists('str_order', 'acid')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD  `acid` int(10) unsigned NOT NULL DEFAULT '0';");
} 
if(!pdo_fieldexists('str_order', 'groupid')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `groupid` int(10) unsigned NOT NULL DEFAULT '0';");
} 
if(!pdo_fieldexists('str_order', 'order_type')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `order_type` tinyint(3) unsigned NOT NULL DEFAULT '1';");
} 
if(!pdo_fieldexists('str_order', 'openid')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `openid` varchar(50) NOT NULL;");
} 
if(!pdo_fieldexists('str_order', 'is_notice')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD      `is_notice` tinyint(3) NOT NULL DEFAULT '0';");
} 
if(!pdo_fieldexists('str_order', 'person_num')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD  	  `person_num` tinyint(3) unsigned NOT NULL DEFAULT '1';");
} 
if(!pdo_fieldexists('str_order', 'table_id')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `table_id` int(10) unsigned NOT NULL DEFAULT '0';");
} 
if(!pdo_fieldexists('str_order', 'table_info')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `table_info` varchar(20) NOT NULL;");
} 
if(!pdo_fieldexists('str_order', 'delivery_fee')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `delivery_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '外卖配送费';");
} 
if(!pdo_fieldexists('str_order', 'grant_credit')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `grant_credit` int(10) unsigned NOT NULL DEFAULT '0';");
} 
if(!pdo_fieldexists('str_order', 'is_grant')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `is_grant` tinyint(3) unsigned NOT NULL DEFAULT '0';");
} 
if(!pdo_fieldexists('str_order', 'is_back')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `is_back` tinyint(3) unsigned NOT NULL DEFAULT '0';");
} 
 if(!pdo_fieldexists('str_order', 'is_usecard')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD   `is_usecard` tinyint(3) unsigned NOT NULL DEFAULT '0';");
} 
if(!pdo_fieldexists('str_order', 'card_type')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `card_type` tinyint(3) unsigned NOT NULL DEFAULT '0';");
} 
if(!pdo_fieldexists('str_order', 'card_fee')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `card_fee` varchar(20) NOT NULL;");
} 
if(!pdo_fieldexists('str_order', 'card_id')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `card_id` varchar(50) NOT NULL;");
} 
if(!pdo_fieldexists('str_order', 'reserve_time')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." ADD    `reserve_time` int(10) unsigned NOT NULL DEFAULT '0';");
} 
if(!pdo_fieldexists('str_order', 'status')) {
	pdo_query("ALTER TABLE ".tablename('str_order')." CHANGE    `status`  `status` tinyint(3) NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('str_order_print', 'print_type')) {
	pdo_query("ALTER TABLE ".tablename('str_order_print')." ADD    `print_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '打印机品牌1：飞蛾，2：宏信';");
}
if(!pdo_fieldexists('str_print', 'type')) {
	pdo_query("ALTER TABLE ".tablename('str_print')." ADD  `type` tinyint(3) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('str_print', 'print_header')) {
	pdo_query("ALTER TABLE ".tablename('str_print')." ADD   `print_header` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('str_print', 'print_footer')) {
	pdo_query("ALTER TABLE ".tablename('str_print')." ADD   `print_footer` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('str_store', 'dish_style')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `dish_style` tinyint(3) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('str_store', 'print_type')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `print_type` tinyint(3) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('str_store', 'is_meal')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `is_meal` tinyint(3) unsigned DEFAULT '1';");
}
if(!pdo_fieldexists('str_store', 'is_takeout')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `is_takeout` tinyint(3) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('str_store', 'is_assign')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `is_assign` tinyint(3) unsigned NOT NULL DEFAULT '2';");
}
if(!pdo_fieldexists('str_store', 'is_reserve')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `is_reserve` tinyint(3) unsigned NOT NULL DEFAULT '2';");
}
if(!pdo_fieldexists('str_store', 'is_fast')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `is_fast` tinyint(3) unsigned NOT NULL DEFAULT '2';");
}
 if(!pdo_fieldexists('str_store', 'mobile_verify')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD  `mobile_verify` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('str_store', 'sns')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `sns` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('str_store', 'forward_mode')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `forward_mode` tinyint(3) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('str_store', 'comment_status')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `comment_status` tinyint(3) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('str_store', 'comment_set')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `comment_set` tinyint(3) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('str_store', 'notice')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `notice` varchar(100) NOT NULL COMMENT '公告';");
}
if(!pdo_fieldexists('str_store', 'content')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `content` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('str_store', 'area_id')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `area_id` int(10) unsigned NOT NULL DEFAULT '0';");
}
if(!pdo_fieldexists('str_store', 'copyright')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `copyright` varchar(255) NOT NULL;");
}
if(!pdo_fieldexists('str_store', 'sms')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `sms` varchar(255) NOT NULL;");
}
 if(!pdo_fieldexists('str_store', 'assign_mode')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD  `assign_mode` tinyint(3) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('str_store', 'store_qrcode')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `store_qrcode` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists('str_store', 'assign_qrcode')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `assign_qrcode` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists('str_store', 'table_qrcode_mode')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD   `table_qrcode_mode` tinyint(3) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('str_store', 'slide_status')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD  `slide_status` tinyint(3) unsigned NOT NULL DEFAULT '2';");
}
if(!pdo_indexexists('str_store', 'area_id')) {
	pdo_query("ALTER TABLE ".tablename('str_store')." ADD  INDEX `area_id` (`area_id`);");
}
if(pdo_fieldexists('str_dish', 'price')) {
	pdo_query("ALTER TABLE ".tablename('str_dish')." CHANGE `price` `price` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL; ");
}