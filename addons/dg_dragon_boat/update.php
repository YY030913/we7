<?php
pdo_query("
CREATE TABLE IF NOT EXISTS `ims_longzhou_help` (
  `HelpId` int(32) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(100) NOT NULL COMMENT '规则id',
  `iacid` varchar(100) DEFAULT NULL COMMENT '微信公众号标识',
  `uniacid` varchar(100) DEFAULT NULL,
  `HelpOpenId` varchar(300) DEFAULT NULL COMMENT '助力者微信标识',
  `HelpHead` varchar(300) DEFAULT NULL COMMENT '助力者头像',
  `HelpName` varchar(100) DEFAULT NULL COMMENT '助力者昵称',
  `HelpDistance` int(32) DEFAULT '0' COMMENT '助力距离',
  `HelpTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '助力时间',
  `HelpPlayer` int(32) DEFAULT NULL COMMENT '玩家主键id（PlayerId）',
  PRIMARY KEY (`HelpId`)
) ENGINE=MyISAM AUTO_INCREMENT=2509 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longzhou_player` (
  `PlayerId` int(32) NOT NULL AUTO_INCREMENT,
  `rid` int(100) DEFAULT NULL COMMENT '规则id',
  `iacid` varchar(100) DEFAULT NULL COMMENT '微信公众号标识',
  `uniacid` varchar(100) DEFAULT NULL,
  `OpenId` varchar(100) DEFAULT NULL COMMENT '微信标识',
  `WeixinName` varchar(32) DEFAULT NULL COMMENT '昵称',
  `WeixinHead` varchar(200) DEFAULT NULL COMMENT '头像',
  `Time` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '参与时间',
  `Distance` int(32) DEFAULT '0' COMMENT '距离（成绩）',
  `BoatIndex` int(32) DEFAULT '1' COMMENT '选船',
  PRIMARY KEY (`PlayerId`)
) ENGINE=MyISAM AUTO_INCREMENT=1482 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_longzhou_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) DEFAULT '0' COMMENT '规则id',
  `iacid` int(10) DEFAULT NULL COMMENT '公众号ID',
  `uniacid` int(10) DEFAULT NULL,
  `huodongname` varchar(255) DEFAULT NULL COMMENT '活动名称',
  `huodongdesc` text COMMENT '活动说明',
  `hdpicture` varchar(255) DEFAULT NULL COMMENT '活动图片',
  `status` tinyint(1) DEFAULT '1' COMMENT '开关状态',
  `subscribe` tinyint(1) DEFAULT '1' COMMENT '是否强制需要关注公众号才能参与',
  `sharetitle` varchar(100) DEFAULT NULL COMMENT '分享标题',
  `shareurl` varchar(255) DEFAULT NULL COMMENT '分享链接',
  `sharecontent` varchar(255) DEFAULT NULL COMMENT '分享简介',
  `start_time` int(10) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(10) DEFAULT NULL COMMENT '结束时间',
  `shareimg` varchar(255) DEFAULT NULL COMMENT '分享图片',
  `followdesc` varchar(255) DEFAULT NULL COMMENT '关注说明',
  `gamegzjp` text COMMENT '游戏规则及奖品',
  `gamemusic` varchar(255) DEFAULT NULL COMMENT '游戏背景音乐',
  `qylogo` varchar(255) DEFAULT NULL COMMENT '企业logo',
  `qyname` varchar(100) DEFAULT NULL COMMENT '企业名称',
  `qylink` varchar(255) DEFAULT NULL COMMENT '企业链接',
  `ggimg` varchar(255) DEFAULT NULL COMMENT '广告图片',
  `gglink` varchar(255) DEFAULT NULL COMMENT '广告链接',
  `gametime` int(10) DEFAULT NULL COMMENT '游戏时间',
  `iscaiji` tinyint(1) DEFAULT '1' COMMENT '是否支持采集信息',
  PRIMARY KEY (`id`),
  KEY `indx_rid` (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_longzhou_userinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) DEFAULT NULL,
  `iacid` int(10) DEFAULT NULL,
  `uniacid` int(10) DEFAULT NULL,
  `openid` varchar(100) DEFAULT NULL COMMENT '微信标识',
  `name` varchar(255) DEFAULT NULL COMMENT '姓名',
  `phone` varchar(11) DEFAULT NULL COMMENT '手机号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
");
if (pdo_tableexists('longzhou_help')) {
    if (!pdo_fieldexists('longzhou_help', 'HelpId')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_help') . " ADD `HelpId` int(32) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('longzhou_help')) {
    if (!pdo_fieldexists('longzhou_help', 'rid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_help') . " ADD `rid` int(100) NOT NULL   COMMENT '规则id';");
    }
}
if (pdo_tableexists('longzhou_help')) {
    if (!pdo_fieldexists('longzhou_help', 'iacid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_help') . " ADD `iacid` varchar(100)    COMMENT '微信公众号标识';");
    }
}
if (pdo_tableexists('longzhou_help')) {
    if (!pdo_fieldexists('longzhou_help', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_help') . " ADD `uniacid` varchar(100)    COMMENT '';");
    }
}
if (pdo_tableexists('longzhou_help')) {
    if (!pdo_fieldexists('longzhou_help', 'HelpOpenId')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_help') . " ADD `HelpOpenId` varchar(300)    COMMENT '助力者微信标识';");
    }
}
if (pdo_tableexists('longzhou_help')) {
    if (!pdo_fieldexists('longzhou_help', 'HelpHead')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_help') . " ADD `HelpHead` varchar(300)    COMMENT '助力者头像';");
    }
}
if (pdo_tableexists('longzhou_help')) {
    if (!pdo_fieldexists('longzhou_help', 'HelpName')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_help') . " ADD `HelpName` varchar(100)    COMMENT '助力者昵称';");
    }
}
if (pdo_tableexists('longzhou_help')) {
    if (!pdo_fieldexists('longzhou_help', 'HelpDistance')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_help') . " ADD `HelpDistance` int(32)   DEFAULT 0 COMMENT '助力距离';");
    }
}
if (pdo_tableexists('longzhou_help')) {
    if (!pdo_fieldexists('longzhou_help', 'HelpTime')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_help') . " ADD `HelpTime` timestamp   DEFAULT CURRENT_TIMESTAMP COMMENT '助力时间';");
    }
}
if (pdo_tableexists('longzhou_help')) {
    if (!pdo_fieldexists('longzhou_help', 'HelpPlayer')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_help') . " ADD `HelpPlayer` int(32)    COMMENT '玩家主键id（PlayerId）';");
    }
}
if (pdo_tableexists('longzhou_player')) {
    if (!pdo_fieldexists('longzhou_player', 'PlayerId')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_player') . " ADD `PlayerId` int(32) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('longzhou_player')) {
    if (!pdo_fieldexists('longzhou_player', 'rid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_player') . " ADD `rid` int(100)    COMMENT '规则id';");
    }
}
if (pdo_tableexists('longzhou_player')) {
    if (!pdo_fieldexists('longzhou_player', 'iacid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_player') . " ADD `iacid` varchar(100)    COMMENT '微信公众号标识';");
    }
}
if (pdo_tableexists('longzhou_player')) {
    if (!pdo_fieldexists('longzhou_player', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_player') . " ADD `uniacid` varchar(100)    COMMENT '';");
    }
}
if (pdo_tableexists('longzhou_player')) {
    if (!pdo_fieldexists('longzhou_player', 'OpenId')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_player') . " ADD `OpenId` varchar(100)    COMMENT '微信标识';");
    }
}
if (pdo_tableexists('longzhou_player')) {
    if (!pdo_fieldexists('longzhou_player', 'WeixinName')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_player') . " ADD `WeixinName` varchar(32)    COMMENT '昵称';");
    }
}
if (pdo_tableexists('longzhou_player')) {
    if (!pdo_fieldexists('longzhou_player', 'WeixinHead')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_player') . " ADD `WeixinHead` varchar(200)    COMMENT '头像';");
    }
}
if (pdo_tableexists('longzhou_player')) {
    if (!pdo_fieldexists('longzhou_player', 'Time')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_player') . " ADD `Time` timestamp   DEFAULT CURRENT_TIMESTAMP COMMENT '参与时间';");
    }
}
if (pdo_tableexists('longzhou_player')) {
    if (!pdo_fieldexists('longzhou_player', 'Distance')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_player') . " ADD `Distance` int(32)   DEFAULT 0 COMMENT '距离（成绩）';");
    }
}
if (pdo_tableexists('longzhou_player')) {
    if (!pdo_fieldexists('longzhou_player', 'BoatIndex')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_player') . " ADD `BoatIndex` int(32)   DEFAULT 1 COMMENT '选船';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `id` int(10) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'rid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `rid` int(10)   DEFAULT 0 COMMENT '规则id';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'iacid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `iacid` int(10)    COMMENT '公众号ID';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `uniacid` int(10)    COMMENT '';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'huodongname')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `huodongname` varchar(255)    COMMENT '活动名称';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'huodongdesc')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `huodongdesc` text    COMMENT '活动说明';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'hdpicture')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `hdpicture` varchar(255)    COMMENT '活动图片';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `status` tinyint(1)   DEFAULT 1 COMMENT '开关状态';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'subscribe')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `subscribe` tinyint(1)   DEFAULT 1 COMMENT '是否强制需要关注公众号才能参与';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'sharetitle')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `sharetitle` varchar(100)    COMMENT '分享标题';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'shareurl')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `shareurl` varchar(255)    COMMENT '分享链接';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'sharecontent')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `sharecontent` varchar(255)    COMMENT '分享简介';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'start_time')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `start_time` int(10)    COMMENT '开始时间';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'end_time')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `end_time` int(10)    COMMENT '结束时间';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'shareimg')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `shareimg` varchar(255)    COMMENT '分享图片';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'followdesc')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `followdesc` varchar(255)    COMMENT '关注说明';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'gamegzjp')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `gamegzjp` text    COMMENT '游戏规则及奖品';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'gamemusic')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `gamemusic` varchar(255)    COMMENT '游戏背景音乐';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'qylogo')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `qylogo` varchar(255)    COMMENT '企业logo';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'qyname')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `qyname` varchar(100)    COMMENT '企业名称';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'qylink')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `qylink` varchar(255)    COMMENT '企业链接';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'ggimg')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `ggimg` varchar(255)    COMMENT '广告图片';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'gglink')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `gglink` varchar(255)    COMMENT '广告链接';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'gametime')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `gametime` int(10)    COMMENT '游戏时间';");
    }
}
if (pdo_tableexists('longzhou_reply')) {
    if (!pdo_fieldexists('longzhou_reply', 'iscaiji')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_reply') . " ADD `iscaiji` tinyint(1)   DEFAULT 1 COMMENT '是否支持采集信息';");
    }
}
if (pdo_tableexists('longzhou_userinfo')) {
    if (!pdo_fieldexists('longzhou_userinfo', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_userinfo') . " ADD `id` int(10) unsigned NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('longzhou_userinfo')) {
    if (!pdo_fieldexists('longzhou_userinfo', 'rid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_userinfo') . " ADD `rid` int(10)    COMMENT '';");
    }
}
if (pdo_tableexists('longzhou_userinfo')) {
    if (!pdo_fieldexists('longzhou_userinfo', 'iacid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_userinfo') . " ADD `iacid` int(10)    COMMENT '';");
    }
}
if (pdo_tableexists('longzhou_userinfo')) {
    if (!pdo_fieldexists('longzhou_userinfo', 'uniacid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_userinfo') . " ADD `uniacid` int(10)    COMMENT '';");
    }
}
if (pdo_tableexists('longzhou_userinfo')) {
    if (!pdo_fieldexists('longzhou_userinfo', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_userinfo') . " ADD `openid` varchar(100)    COMMENT '微信标识';");
    }
}
if (pdo_tableexists('longzhou_userinfo')) {
    if (!pdo_fieldexists('longzhou_userinfo', 'name')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_userinfo') . " ADD `name` varchar(255)    COMMENT '姓名';");
    }
}
if (pdo_tableexists('longzhou_userinfo')) {
    if (!pdo_fieldexists('longzhou_userinfo', 'phone')) {
        pdo_query('ALTER TABLE ' . tablename('longzhou_userinfo') . " ADD `phone` varchar(11)    COMMENT '手机号';");
    }
}