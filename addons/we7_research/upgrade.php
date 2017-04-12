<?php
if(!pdo_fieldexists('research_fields', 'displayorder')) {
	pdo_query("ALTER TABLE ".tablename('research_fields')." ADD `displayorder` INT(11) UNSIGNED NOT NULL DEFAULT '0';");
}

if(!pdo_fieldexists('research', 'alltotal')) {
	pdo_query("ALTER TABLE ".tablename('research')." ADD   `alltotal` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '预约总人数';");
}
if(!pdo_fieldexists('research', 'uyan')) {
	pdo_query("ALTER TABLE ".tablename('research')." ADD   `uyan` int(20) NOT NULL;");
}
if(!pdo_fieldexists('research', 'mobile')) {
	pdo_query("ALTER TABLE ".tablename('research')." ADD   `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '通知手机号码';");
}

$sql = "
CREATE TABLE IF NOT EXISTS `ims_research_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `rerid` int(11) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `mobile` bigint(50) NOT NULL,
  `trans_id` varchar(255) DEFAULT NULL,
  `order_sn` varchar(20) NOT NULL,
  `price` decimal(11,2) DEFAULT '0.00',
  `status` tinyint(4) NOT NULL COMMENT '0已完成，1等待支付',
  `pay_type` tinyint(11) unsigned NOT NULL COMMENT '支付类型',
  `pay_pattern` int(1) DEFAULT '1' COMMENT '支付方式 1-在线付款，2-货到付款',
  `other` varchar(100) NOT NULL DEFAULT '',
  `update_time` int(10) unsigned DEFAULT '0' COMMENT '更新时间',
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_sn_uniacid` (`order_sn`,`uniacid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

";
pdo_query($sql);