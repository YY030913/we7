<?php
$sql = "
CREATE TABLE IF NOT EXISTS " . tablename('mon_wkj_user') . " (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kid` int(10) NOT NULL,
  `openid` varchar(200) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `headimgurl` varchar(200) NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `createtime` int(10) DEFAULT '0',
  `ip` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

pdo_query($sql);

if (!pdo_fieldexists('mon_wkj', 'friend_help_limit')) {
    pdo_query("ALTER TABLE " . tablename('mon_wkj') . "ADD   `friend_help_limit` int(10) DEFAULT NULL;");

}



