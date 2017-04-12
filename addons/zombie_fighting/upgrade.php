<?php
$sql = "
CREATE TABLE IF NOT EXISTS  `ims_fighting_sysset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `copyright` varchar(255) DEFAULT '' COMMENT '版权',
  `appid_share` varchar(255) DEFAULT '',
  `appsecret_share` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`weid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
pdo_run($sql);
if(!pdo_fieldexists('fighting_setting', 'followurl')) {
    pdo_query("ALTER TABLE ".tablename('fighting_setting')." ADD  `followurl` varchar(1000) DEFAULT '';");
}
if(!pdo_fieldexists('fighting_setting', 'thumb')) {
    pdo_query("ALTER TABLE ".tablename('fighting_setting')." ADD    `thumb` varchar(100) NOT NULL COMMENT '广告';");
}

if(!pdo_fieldexists('fighting_setting', 'thumb_url')) {
    pdo_query("ALTER TABLE ".tablename('fighting_setting')." ADD    `thumb_url` varchar(100) NOT NULL COMMENT '广告URL';");
}

if(!pdo_fieldexists('fighting_question_bank', 'sid')) {
    pdo_query("ALTER TABLE ".tablename('fighting_question_bank')." ADD   `sid` int(10) unsigned NOT NULL COMMENT '广告URL';");
}
if(pdo_fieldexists('fighting_question_bank', 'figure')) {
    pdo_query("ALTER TABLE ".tablename('fighting_question_bank')." CHANGE `figure`  `figure` varchar(30) NOT NULL;");
}
if(!pdo_fieldexists('fighting_setting', 'share_title')) {
    pdo_query("ALTER TABLE ".tablename('fighting_setting')." ADD    `share_title` varchar(20) NOT NULL COMMENT '分享标题';");
}
if(!pdo_fieldexists('fighting_setting', 'share_picture')) {
    pdo_query("ALTER TABLE ".tablename('fighting_setting')." ADD    `share_picture` varchar(500) NOT NULL COMMENT '分享图片';");
}