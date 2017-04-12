<?php

if(!pdo_fieldexists('mon_egg', 'exchangeEnable')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD   `exchangeEnable` int(1) DEFAULT NULL ;");
}

if(!pdo_fieldexists('mon_egg', 'xhjf_enable')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD   `xhjf_enable` int(1) DEFAULT NULL;");
}

if(!pdo_fieldexists('mon_egg', 'xhjf')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD    `xhjf` int(10) DEFAULT NULL;");
}

if(!pdo_fieldexists('mon_egg', 'mch_id')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD  `mch_id` varchar(1000) DEFAULT NULL;");
}
if(!pdo_fieldexists('mon_egg', 'wxappid')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD  `wxappid` varchar(1000) DEFAULT NULL;");
}
if(!pdo_fieldexists('mon_egg', 'act_name')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD  `act_name` varchar(1000) DEFAULT NULL;");
}
if(!pdo_fieldexists('mon_egg', 'mch_key')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD  `mch_key` varchar(1000) DEFAULT NULL;");
}
if(!pdo_fieldexists('mon_egg', 'apiclient_cert')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD  `apiclient_cert` text;");
}
if(!pdo_fieldexists('mon_egg', 'apiclient_key')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD  `apiclient_key` text;");
}
if(!pdo_fieldexists('mon_egg', 'rootca')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD  `rootca` text;");
}
if(!pdo_fieldexists('mon_egg', 'wishing')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD  `wishing` text;");
}
if(!pdo_fieldexists('mon_egg', 'remark')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD  `remark` text;");
}
if(!pdo_fieldexists('mon_egg', 'send_name')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg')." ADD  `send_name` varchar(200) DEFAULT NULL;");
}
if(!pdo_fieldexists('mon_egg_prize', 'rb')) {
	pdo_query("ALTER TABLE ".tablename('mon_egg_prize')." ADD   `rb` float(10,2) DEFAULT NULL;");
}