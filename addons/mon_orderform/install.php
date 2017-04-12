<?php

/**
 *助力活动
 */
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_orderform') . " (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) NOT NULL,
  `weid` int(11) NOT NULL,
  `oname` varchar(200) DEFAULT NULL,
  `pname` varchar(200) DEFAULT NULL,
  `odesc` text,
  `address` varchar(200) DEFAULT NULL,
  `p_tel` varchar(50) DEFAULT NULL,
  `p_desc` text,
  `lng` decimal(18,10) NOT NULL DEFAULT '0.0000000000',
  `lat` decimal(18,10) NOT NULL DEFAULT '0.0000000000',
  `location_p` varchar(100) NOT NULL,
  `location_c` varchar(100) NOT NULL,
  `location_a` varchar(100) NOT NULL,
  `p_title_pg` varchar(500) DEFAULT NULL,
  `p_titile_url` varchar(500) DEFAULT NULL,
  `copyright` varchar(50) DEFAULT NULL,
  `follow_url` varchar(200) DEFAULT NULL,
  `new_title` varchar(200) DEFAULT NULL,
  `new_icon` varchar(200) DEFAULT NULL,
  `new_content` varchar(200) DEFAULT NULL,
  `share_title` varchar(200) DEFAULT NULL,
  `share_icon` varchar(200) DEFAULT NULL,
  `share_content` varchar(200) DEFAULT NULL,
  `createtime` int(10) DEFAULT NULL,
  `updatetime` int(10) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `emailenable` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);

/**
 * 订单项类型
 */
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_orderform_item') . " (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(10) DEFAULT NULL,
  `iname` varchar(200) DEFAULT NULL,
  `ititle` varchar(500) DEFAULT NULL,
  `ititle_pg` varchar(500) DEFAULT NULL,
  `ititle_url` varchar(500) DEFAULT NULL,
  `y_price` float(6,2) DEFAULT NULL,
  `x_price` float(6,2) DEFAULT NULL,
  `i_desc` text,
  `i_summary` varchar(50) DEFAULT NULL,
  `o_tel` varchar(50) DEFAULT NULL,
  `pay_type` int(1) DEFAULT NULL,
  `o_num` int(3) DEFAULT NULL,
  `displayorder` int(3) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
  `ipreview_pg` varchar(500) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);

/**
 * order
 */
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_orderform_order') . " (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orderno` varchar(100) DEFAULT NULL,
  `outno` varchar(300) DEFAULT NULL,
  `acid` varchar(100) DEFAULT NULL,
  `fid` int(10) DEFAULT NULL,
  `iid` int(10) DEFAULT NULL,
  `openid` varchar(200) NOT NULL,
  `nickname` varchar(300) DEFAULT NULL,
  `headimgurl` varchar(300) DEFAULT NULL,
  `uname` varchar(300) DEFAULT NULL,
  `utel` varchar(50) DEFAULT NULL,
  `ordertime` int(10) DEFAULT NULL,
  `paytime` int(10) DEFAULT NULL,
  `ordernum` int(3) DEFAULT NULL,
  `o_yprice` float(6,2) DEFAULT NULL,
  `o_xprice` float(6,2) DEFAULT NULL,
  `zf_price` float(6,2) DEFAULT NULL,
  `js_price` float(6,2) DEFAULT NULL,
  `pay_type` int(3) DEFAULT NULL,
  `remark` varchar(2000) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
 PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);
/**
 * 设置
 */
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_orderform_setting') . " (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `appid` varchar(200) DEFAULT NULL,
  `appsecret` varchar(200) DEFAULT NULL,
  `mchid` varchar(100) DEFAULT NULL,
  `shkey` varchar(100) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);

/**
 * 模板消息设置
 */
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_orderform_template') . " (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) NOT NULL,
  `ordertid` varchar(500) DEFAULT NULL,
  `orderenable` int(1) DEFAULT NULL,
  `payenable` int(1) DEFAULT NULL,
  `paytid` varchar(500) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
pdo_query($sql);
