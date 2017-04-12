<?php
/**
 * 财务中心模块定义
 *
 * @author Kim 模块开发QQ:800083075
 * @url http://www.goodziyuan.com/
 */
$sql = "
CREATE TABLE IF NOT EXISTS `ims_users_credits_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `uniacid` int(11) NOT NULL,
  `credittype` varchar(10) NOT NULL DEFAULT '',
  `num` decimal(10,2) NOT NULL,
  `operator` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `remark` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `uniacid` (`uniacid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户购买记录表\r\n模块开发QQ:800083075';
CREATE TABLE IF NOT EXISTS `ims_users_packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid`  int NULL COMMENT '公众号ID',
  `record_id` int(11) DEFAULT NULL COMMENT '消费记录ID',
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `package` int(11) DEFAULT NULL COMMENT '套餐ID',
  `buy_time` int(11) DEFAULT 0 NULL COMMENT '购买时间',
  `expiration_time` int(11) DEFAULT 0 NULL COMMENT '到期时间',
  `status`  int(1) NULL DEFAULT 0 COMMENT '状态 0 - 待付款 1-已付款',
  PRIMARY KEY (`id`),
  KEY `uid_package` (`uid`,`package`)
) ENGINE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8 COMMENT='用户购买的套餐\r\n模块开发QQ:800083075';
CREATE TABLE IF NOT EXISTS `ims_uni_payorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` varchar(200) DEFAULT NULL,
  `status` int(1) DEFAULT '0' COMMENT '0-未付款 1-已付款',
  `money` decimal(10,2) DEFAULT NULL,
  `pay_time` int(10) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `order_time` int(10) DEFAULT NULL,
  `credittype` varchar(20) DEFAULT NULL,
  `pay_type` int(1) DEFAULT 0 NULL,
  `order_no` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orderid` (`orderid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
";

pdo_query($sql);

if(!pdo_fieldexists('users', 'credit1')) {
	pdo_query("ALTER TABLE ".tablename('users')." ADD `credit1` decimal(11,2) NULL DEFAULT 0 COMMENT '用户积分';");
}

if(!pdo_fieldexists('users', 'credit2')) {
	pdo_query("ALTER TABLE ".tablename('users')." ADD  `credit2` decimal(11,2) NULL DEFAULT 0 COMMENT '交易币';");
}
if(!pdo_fieldexists('uni_group', 'price')) {
	pdo_query("ALTER TABLE ".tablename('uni_group')." ADD  `price` decimal(11,2) NULL DEFAULT 0 COMMENT '套餐价格';");
}
if(!pdo_fieldexists('uni_group', 'hide')) {
	pdo_query("ALTER TABLE ".tablename('uni_group')." ADD `hide` int(1) NULL DEFAULT 0 COMMENT '是否隐藏 0-否 1-是';");
}
if(!pdo_fieldexists('users_group', 'discount')) {
	pdo_query("ALTER TABLE ".tablename('users_group')." ADD  `discount` decimal(11,2) DEFAULT NULL COMMENT '打折';");
}
if(!pdo_fieldexists('uni_payorder', 'pay_type')) {
		pdo_query("ALTER TABLE ".tablename('uni_payorder')." ADD `pay_type` int(1) NULL DEFAULT 0 COMMENT '支付方式 0-百付宝 1-支付宝';");
}
if(!pdo_fieldexists('uni_payorder', 'order_no')) {
		pdo_query("ALTER TABLE ".tablename('uni_payorder')." ADD  `order_no` varchar(50) DEFAULT NULL COMMENT '第三方ORDER NO 0-百付宝 1-支付宝';");
}
