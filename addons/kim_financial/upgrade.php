<?php
/**
 * 财务中心模块定义
 *
 * @author Kim 模块开发QQ:800083075
 * @url http://www.goodziyuan.com/
 */
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
