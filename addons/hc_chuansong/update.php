<?php
pdo_query("
CREATE TABLE IF NOT EXISTS `ims_hc_chuansong_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `str1` varchar(50) DEFAULT NULL,
  `page_title` varchar(50) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `valid_valid` int(11) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `page_parttime` int(11) NOT NULL,
  `part_time` int(11) NOT NULL COMMENT '两次领奖的时间间隔',
  `total_nums` int(11) NOT NULL,
  `join_nums` int(11) NOT NULL COMMENT '参加人数',
  `limit_nums` int(11) NOT NULL,
  `is_default` tinyint(4) NOT NULL,
  `result_thumb` varchar(255) NOT NULL,
  `houxuan_thumb` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `create_time` int(10) NOT NULL,
  `share_title` varchar(50) DEFAULT NULL,
  `share_thumb` varchar(255) DEFAULT NULL,
  `share_desc` varchar(255) DEFAULT NULL,
  `share_link` varchar(255) DEFAULT NULL,
  `home_color` varchar(20) DEFAULT NULL,
  `regist_color` varchar(20) DEFAULT NULL,
  `share_detail` text,
  `share_kouhao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_hc_chuansong_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  `istype` tinyint(1) DEFAULT NULL,
  `hc_chuansongid` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `desc` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_hc_chuansong_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `from_user` varchar(50) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `headimgurl` varchar(255) DEFAULT NULL,
  `realname` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `award_no` int(11) NOT NULL,
  `hits` int(11) NOT NULL,
  `create_time` int(10) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `is_award` tinyint(1) NOT NULL COMMENT '是否获奖',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'weid')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `weid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `title` varchar(50)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'thumb')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `thumb` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'str1')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `str1` varchar(50)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'page_title')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `page_title` varchar(50)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `desc` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'valid_valid')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `valid_valid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'starttime')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `starttime` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'endtime')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `endtime` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'page_parttime')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `page_parttime` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'part_time')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `part_time` int(11) NOT NULL   COMMENT '两次领奖的时间间隔';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'total_nums')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `total_nums` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'join_nums')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `join_nums` int(11) NOT NULL   COMMENT '参加人数';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'limit_nums')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `limit_nums` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'is_default')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `is_default` tinyint(4) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'result_thumb')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `result_thumb` varchar(255) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'houxuan_thumb')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `houxuan_thumb` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `status` tinyint(4) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'create_time')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `create_time` int(10) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'share_title')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `share_title` varchar(50)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'share_thumb')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `share_thumb` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'share_desc')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `share_desc` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'share_link')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `share_link` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'home_color')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `home_color` varchar(20)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'regist_color')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `regist_color` varchar(20)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'share_detail')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `share_detail` text    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_list')) {
    if (!pdo_fieldexists('hc_chuansong_list', 'share_kouhao')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_list') . " ADD `share_kouhao` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_reply')) {
    if (!pdo_fieldexists('hc_chuansong_reply', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_reply') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_reply')) {
    if (!pdo_fieldexists('hc_chuansong_reply', 'weid')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_reply') . " ADD `weid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_reply')) {
    if (!pdo_fieldexists('hc_chuansong_reply', 'rid')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_reply') . " ADD `rid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_reply')) {
    if (!pdo_fieldexists('hc_chuansong_reply', 'istype')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_reply') . " ADD `istype` tinyint(1)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_reply')) {
    if (!pdo_fieldexists('hc_chuansong_reply', 'hc_chuansongid')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_reply') . " ADD `hc_chuansongid` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_reply')) {
    if (!pdo_fieldexists('hc_chuansong_reply', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_reply') . " ADD `title` varchar(50)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_reply')) {
    if (!pdo_fieldexists('hc_chuansong_reply', 'cover')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_reply') . " ADD `cover` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_reply')) {
    if (!pdo_fieldexists('hc_chuansong_reply', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_reply') . " ADD `desc` text    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `id` int(11) NOT NULL auto_increment  COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'weid')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `weid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'pid')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `pid` int(11)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'from_user')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `from_user` varchar(50)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'nickname')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `nickname` varchar(50)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'headimgurl')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `headimgurl` varchar(255)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'realname')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `realname` varchar(50)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'mobile')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `mobile` varchar(20)    COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'award_no')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `award_no` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'hits')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `hits` int(11) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'create_time')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `create_time` int(10) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'status')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `status` tinyint(2) NOT NULL   COMMENT '';");
    }
}
if (pdo_tableexists('hc_chuansong_user')) {
    if (!pdo_fieldexists('hc_chuansong_user', 'is_award')) {
        pdo_query('ALTER TABLE ' . tablename('hc_chuansong_user') . " ADD `is_award` tinyint(1) NOT NULL   COMMENT '是否获奖';");
    }
}