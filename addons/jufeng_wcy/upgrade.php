<?php

if(!pdo_fieldexists('jufeng_wcy_category', 'count1')) {
	pdo_query("ALTER TABLE ".tablename('jufeng_wcy_category')." ADD  `count1` varchar(20) NOT NULL;");
}
if(!pdo_fieldexists('jufeng_wcy_category', 'count2')) {
	pdo_query("ALTER TABLE ".tablename('jufeng_wcy_category')." ADD  `count2` varchar(20) NOT NULL;");
}
if(!pdo_fieldexists('jufeng_wcy_category', 'count3')) {
	pdo_query("ALTER TABLE ".tablename('jufeng_wcy_category')." ADD  `count3` varchar(20) NOT NULL;");
}

if(!pdo_fieldexists('jufeng_wcy_sms', 'is_sms')) {
	pdo_query("ALTER TABLE ".tablename('jufeng_wcy_sms')." ADD  `is_sms` INT(10) NOT NULL DEFAULT '0' COMMENT '是否开启全局短信';");
}
if(!pdo_fieldexists('jufeng_wcy_sms', 'sms_id')) {
	pdo_query("ALTER TABLE ".tablename('jufeng_wcy_sms')." ADD `sms_id` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '短信模板ID';");
}