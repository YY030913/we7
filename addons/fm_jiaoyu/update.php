<?php
$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_user' ) . "(
  	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`sid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '学生ID',	
	`tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '教师ID',
  	`weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  	`schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
	`uid` int(10) unsigned NOT NULL COMMENT '微赞系统memberID',	
  	`openid` varchar(30) NOT NULL COMMENT 'openid',
	`userinfo` text COMMENT '用户信息',
	`pard` int(1) unsigned NOT NULL COMMENT '关系',
  	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户状态',
  	`createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  	PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
	";
pdo_run($sql);

$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_set' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `weid` int(10) unsigned NOT NULL,
    `istplnotice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否模版通知',
    `xsqingjia` varchar(200) DEFAULT '' COMMENT '学生请假申请ID',
	`xsqjsh` varchar(200) DEFAULT '' COMMENT '学生请假审核通知ID',
	`jsqingjia` varchar(200) DEFAULT '' COMMENT '教员请假申请体提醒ID',
	`jsqjsh` varchar(200) DEFAULT '' COMMENT '教员请假审核通知ID',
	`xxtongzhi` varchar(200) DEFAULT '' COMMENT '学校通知ID',
	`liuyan` varchar(200) DEFAULT '' COMMENT '家长留言ID',
	`liuyanhf` varchar(200) DEFAULT '' COMMENT '教师回复家长留言ID',
	`bjtz` varchar(200) DEFAULT '' COMMENT '班级通知ID',
       PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
	";
pdo_run($sql);

$sql = "
	CREATE TABLE IF NOT EXISTS " . tablename ( 'wx_school_leave' ) . "(
    `id` int(10) NOT NULL AUTO_INCREMENT,
	`leaveid` int(10) unsigned NOT NULL,
    `weid` int(10) unsigned NOT NULL,
	`schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
	`uid` int(10) unsigned NOT NULL COMMENT '微赞UID',
	`tuid` int(10) unsigned NOT NULL COMMENT '老师微赞UID',	
	`openid` varchar(200) DEFAULT '' COMMENT 'openid',
	`sid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '学生ID',	
	`tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '教师ID',
	`type` varchar(10) DEFAULT '' COMMENT '请假类型',
    `startime` varchar(200) DEFAULT '' COMMENT '开始时间',
	`endtime` varchar(200) DEFAULT '' COMMENT '结束时间',
	`conet` varchar(200) DEFAULT '' COMMENT '详细内容',
	`createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
	`cltime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理时间',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态',
	`bj_id` int(10) unsigned NOT NULL COMMENT '班级ID',
	`isliuyan` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否留言',
       PRIMARY KEY (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;
CREATE TABLE IF NOT EXISTS `ims_wx_school_leave` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `leaveid` int(10) unsigned NOT NULL,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
  `uid` int(10) unsigned NOT NULL COMMENT '微赞UID',
  `tuid` int(10) unsigned NOT NULL COMMENT '老师微赞UID',
  `openid` varchar(200) DEFAULT '' COMMENT 'openid',
  `sid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '学生ID',
  `tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '教师ID',
  `type` varchar(10) DEFAULT '' COMMENT '请假类型',
  `startime` varchar(200) DEFAULT '' COMMENT '开始时间',
  `endtime` varchar(200) DEFAULT '' COMMENT '结束时间',
  `conet` varchar(200) DEFAULT '' COMMENT '详细内容',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `cltime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '审核状态',
  `bj_id` int(10) unsigned NOT NULL COMMENT '班级ID',
  `isliuyan` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否留言',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_wx_school_notice` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
  `tid` int(10) unsigned NOT NULL COMMENT '教师ID',
  `tname` varchar(10) DEFAULT '' COMMENT '发布老师名字',
  `title` varchar(50) DEFAULT '' COMMENT '文章名称',
  `content` text NOT NULL COMMENT '详细内容',
  `picarr` text COMMENT '用户信息',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `bj_id` int(10) unsigned NOT NULL COMMENT '班级ID',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否班级通知',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS  `ims_wx_school_bjq` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
  `content` text NOT NULL COMMENT '详细内容或评价',
  `uid` int(10) unsigned NOT NULL COMMENT '发布者UID',
  `weixin` varchar(30) NOT NULL DEFAULT '0' COMMENT '0',
  `bj_id1` int(10) unsigned NOT NULL COMMENT '班级ID1',
  `bj_id2` int(10) unsigned NOT NULL COMMENT '班级ID2',
  `bj_id3` int(10) unsigned NOT NULL COMMENT '班级ID3',
  `sherid` int(10) unsigned NOT NULL COMMENT '所属图文id',
  `shername` varchar(50) DEFAULT '' COMMENT '分享者名字',
  `openid` varchar(30) NOT NULL COMMENT '帖子所属openid',
  `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型0为班级圈1为评论',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS  `ims_wx_school_dianzan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
  `uid` int(10) unsigned NOT NULL COMMENT '发布者UID',
  `sherid` int(10) unsigned NOT NULL COMMENT '所属图文id',
  `zname` varchar(50) DEFAULT '' COMMENT '点赞人名字',
  `order` int(10) unsigned NOT NULL COMMENT '排序',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `w171` varchar(30) NOT NULL DEFAULT '0' COMMENT '图片路径',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_wx_school_media` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
  `uid` int(10) unsigned NOT NULL COMMENT '发布者UID',
  `picurl` varchar(255) DEFAULT '' COMMENT '图片',
  `bj_id1` int(10) unsigned NOT NULL COMMENT '班级ID1',
  `bj_id2` int(10) unsigned NOT NULL COMMENT '班级ID2',
  `bj_id3` int(10) unsigned NOT NULL COMMENT '班级ID3',
  `order` int(10) unsigned NOT NULL COMMENT '排序',
  `sherid` int(10) unsigned NOT NULL COMMENT '所属图文id',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS  `ims_wx_school_wxpay` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `w171` varchar(30) NOT NULL DEFAULT '0' COMMENT '订单ID',
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
  `orderid` int(10) unsigned NOT NULL COMMENT '返回订单ID',
  `od1` int(10) unsigned NOT NULL COMMENT '1',
  `od2` int(10) unsigned NOT NULL COMMENT '2',
  `od3` int(10) unsigned NOT NULL COMMENT '3',
  `od4` int(10) unsigned NOT NULL COMMENT '4',
  `od5` int(10) unsigned NOT NULL COMMENT '5',
  `cose` varchar(10) NOT NULL COMMENT '价格',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1未支付2为未支付3为已退款',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS  `ims_wx_school_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL COMMENT '学校ID',
  `orderid` int(10) unsigned NOT NULL COMMENT '订单ID',
  `userid` int(10) unsigned NOT NULL COMMENT '发布者UID',
  `uid` int(10) unsigned NOT NULL COMMENT '发布者UID',
  `sid` int(10) unsigned NOT NULL COMMENT '所属图文id',
  `kcid` int(10) unsigned NOT NULL COMMENT '课程ID',
  `obid` int(10) unsigned NOT NULL COMMENT '项目ID',
  `cose` varchar(10) NOT NULL COMMENT '价格',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1未支付2为未支付3为已退款',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1课程2项目3功能',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `w171` varchar(30) NOT NULL DEFAULT '0' COMMENT '支付LOGO',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wx_school_fans_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0',
  `schoolid` int(10) unsigned NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `group_desc` varchar(50) NOT NULL DEFAULT '',
  `ssort` int(10) unsigned NOT NULL COMMENT '排序',
  `type` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '二维码状态',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wx_school_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `schoolid` int(10) unsigned NOT NULL,
  `cateid` int(10) unsigned NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `picarr` text COMMENT '图片组',
  `displayorder` tinyint(3) unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_display` tinyint(3) unsigned NOT NULL,
  `is_show_home` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `click` int(10) unsigned NOT NULL,
  `dianzan` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_wx_school_qrcode_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0',
  `qrcid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二维码场景ID',
  `gpid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '场景名称',
  `keyword` varchar(100) NOT NULL COMMENT '关联关键字',
  `model` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '模式，1临时，2为永久',
  `ticket` varchar(250) NOT NULL DEFAULT '' COMMENT '标识',
  `show_url` varchar(550) NOT NULL DEFAULT '' COMMENT '图片地址',
  `expire` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `subnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注扫描次数',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '生成时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0为未启用，1为启用',
  `group_id` int(3) unsigned NOT NULL DEFAULT '0',
  `rid` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_qrcid` (`qrcid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_wx_school_qrcode_set` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bg` int(10) unsigned NOT NULL DEFAULT '0',
  `qrleft` int(10) unsigned NOT NULL DEFAULT '0',
  `qrtop` int(10) unsigned NOT NULL DEFAULT '0',
  `qrwidth` int(10) unsigned NOT NULL DEFAULT '0',
  `qrheight` int(10) unsigned NOT NULL DEFAULT '0',
  `model` int(10) unsigned NOT NULL DEFAULT '1',
  `logoheight` int(10) unsigned NOT NULL DEFAULT '0',
  `logowidth` int(10) unsigned NOT NULL DEFAULT '0',
  `logoqrheight` int(10) unsigned NOT NULL DEFAULT '0',
  `logoqrwidth` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_wx_school_qrcode_statinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0',
  `qid` int(10) unsigned NOT NULL,
  `openid` varchar(150) NOT NULL DEFAULT '' COMMENT '用户的唯一身份ID',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否发生在订阅时',
  `qrcid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二维码场景ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '场景名称',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '生成时间',
  `group_id` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	";
pdo_run($sql);

// 新增  一个学生绑定三个微信号 默认不绑定 
if(!pdo_fieldexists('wx_school_students', 'xjid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `xjid` int(11) unsigned NOT NULL COMMENT '学籍信息';");
}

if(!pdo_fieldexists('wx_school_students', 'mom')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `mom` varchar(30) NOT NULL DEFAULT '0' COMMENT '母亲微信';");
}

if(!pdo_fieldexists('wx_school_students', 'dad')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `dad` varchar(30) NOT NULL DEFAULT '0' COMMENT '父亲微信';");
}

if(!pdo_fieldexists('wx_school_students', 'ouid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `ouid` int(10) unsigned NOT NULL COMMENT '微赞系统memberID';");
}

if(!pdo_fieldexists('wx_school_students', 'muid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `muid` int(10) unsigned NOT NULL COMMENT '微赞系统memberID';");
}

if(!pdo_fieldexists('wx_school_students', 'duid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD `duid` int(10) unsigned NOT NULL COMMENT '微赞系统memberID';");
}

if(!pdo_fieldexists('wx_school_classify', 'erwei')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `erwei` varchar(200) NOT NULL DEFAULT '' COMMENT '群二维码';");
}

if(!pdo_fieldexists('wx_school_classify', 'qun')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `qun` varchar(200) NOT NULL DEFAULT '' COMMENT 'Q群链接';");
}

if(!pdo_fieldexists('wx_school_classify', 'tid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_classify')." ADD `tid` int(11) unsigned NOT NULL COMMENT '班级主任userid';");
}

if(!pdo_fieldexists('wx_school_teachers', 'code')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `code` int(11) unsigned NOT NULL COMMENT '绑定码';");
}

if(!pdo_fieldexists('wx_school_teachers', 'openid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `openid` varchar(30) NOT NULL DEFAULT '0' COMMENT '老师微信';");
}

if(!pdo_fieldexists('wx_school_teachers', 'uid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD `uid` int(10) unsigned NOT NULL COMMENT '微赞系统memberID';");
}

if(pdo_fieldexists('wx_school_students', 'wecha_id')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_students')." CHANGE `wecha_id` `own` varchar(30) NOT NULL DEFAULT '0' COMMENT '自己微信';");
}

if(pdo_fieldexists('wx_school_user', 'status')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_user')." CHANGE `status` `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户状态';");
}

if(pdo_fieldexists('wx_school_bbsreply', 'iparr')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_bbsreply')." CHANGE `iparr` `shenfen` int(1) unsigned NOT NULL COMMENT '1为班主任，2为母亲，3为父亲，4为本人';");
}

if(pdo_fieldexists('wx_school_user', 'sid')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_user')." CHANGE `sid` `sid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '学生ID';");
}

if(pdo_fieldexists('wx_school_user', 'tid')) {
	pdo_query("ALTER TABLE  ".tablename('wx_school_user')." CHANGE `tid` `tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '老师ID';");
}
if(!pdo_fieldexists('wx_school_teachers', 'com')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD   `com` varchar(30) NOT NULL DEFAULT '0' COMMENT '0';");
}

if(!pdo_fieldexists('wx_school_students', 'weixin')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD   `weixin` varchar(30) NOT NULL DEFAULT '0' COMMENT '0';");
}
if(!pdo_fieldexists('wx_school_students', 'own')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD   `own` varchar(30) NOT NULL DEFAULT '0' COMMENT '自己微信';");
}
if(!pdo_fieldexists('wx_school_students', 'xjid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD   `xjid` int(11) unsigned NOT NULL COMMENT '学籍信息';");
}
if(!pdo_fieldexists('wx_school_students', 'mom')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD   `mom` varchar(30) NOT NULL DEFAULT '0' COMMENT '母亲微信';");
}
if(!pdo_fieldexists('wx_school_students', 'dad')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD     `dad` varchar(30) NOT NULL DEFAULT '0' COMMENT '父亲微信';");
}
if(!pdo_fieldexists('wx_school_students', 'ouid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD   `ouid` int(10) unsigned NOT NULL COMMENT '系统memberID';");
}
if(!pdo_fieldexists('wx_school_students', 'duid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD     `duid` int(10) unsigned NOT NULL COMMENT '系统memberID';");
}
if(!pdo_fieldexists('wx_school_students', 'muid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_students')." ADD    `muid` int(10) unsigned NOT NULL COMMENT '系统memberID';");
}
if(!pdo_fieldexists('wx_school_teachers', 'code')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD    `code` int(11) unsigned NOT NULL COMMENT '绑定码';");
}

if(!pdo_fieldexists('wx_school_teachers', 'openid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD     `openid` varchar(30) NOT NULL DEFAULT '0' COMMENT '老师微信';");
}

if(!pdo_fieldexists('wx_school_teachers', 'uid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD    `uid` int(10) unsigned NOT NULL COMMENT '系统memberID';");
}
if(!pdo_fieldexists('wx_school_notice', 'groupid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD   `groupid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1为全体师生2为全体教师3为全体家长和学生';");
}
if(!pdo_fieldexists('wx_school_user', 'status')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_user')." ADD    `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户状态';");
}

if(!pdo_fieldexists('wx_school_notice', 'km_id')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD     `km_id` int(10) unsigned NOT NULL COMMENT '科目ID';");
}

if(!pdo_fieldexists('wx_school_set', 'zuoye')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD    `zuoye` varchar(200) DEFAULT '' COMMENT '发布作业提醒ID';");
}

if(!pdo_fieldexists('wx_school_set', 'bjqshjg')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD   `bjqshjg` varchar(200) DEFAULT '';");
}
if(!pdo_fieldexists('wx_school_set', 'bjqshtz')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD   `bjqshtz` varchar(200) DEFAULT '';");
}
if(!pdo_fieldexists('wx_school_score', 'info')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_score')." ADD  `info` varchar(1000) NOT NULL DEFAULT '' COMMENT '教师评价';");
}
if(!pdo_fieldexists('wx_school_index', 'isopen')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD   `isopen` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0显示1否';");
}
if(!pdo_fieldexists('wx_school_index', 'qroce')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD   `qroce` varchar(200) NOT NULL DEFAULT '' COMMENT '二维码';");
}
if(!pdo_fieldexists('wx_school_index', 'issale')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD    `issale` tinyint(1) NOT NULL DEFAULT '5' COMMENT '5种状态';");
}
if(!pdo_fieldexists('wx_school_notice', 'km_id')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_notice')." ADD    `km_id` int(10) unsigned NOT NULL COMMENT '科目ID';");
}
if(!pdo_fieldexists('wx_school_set', 'guanli')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_set')." ADD   `guanli` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理方式';");
}
if(!pdo_fieldexists('wx_school_tcourse', 'yibao')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_tcourse')." ADD    `yibao` int(11) NOT NULL COMMENT '已报人数';");
}
if(!pdo_fieldexists('wx_school_tcourse', 'cose')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_tcourse')." ADD     `cose` varchar(11) NOT NULL COMMENT '价格';");
}
if(pdo_fieldexists('wx_school_index', 'style1')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." CHANGE   `style1` `style1` varchar(200) NOT NULL DEFAULT 'common' COMMENT '模版名称';");
}
if(!pdo_fieldexists('wx_school_index', 'zhaosheng')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD  `zhaosheng` text NOT NULL COMMENT '招生简章';");
}
if(!pdo_fieldexists('wx_school_index', 'uid')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '账户ID';");
}
if(!pdo_fieldexists('wx_school_index', 'style2')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD  `style2` varchar(200) NOT NULL DEFAULT 'students' COMMENT '模版名称2';");
}
if(!pdo_fieldexists('wx_school_index', 'style3')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_index')." ADD  `style3` varchar(200) NOT NULL DEFAULT 'teacher' COMMENT '模版名称3';");
}

if(!pdo_fieldexists('wx_school_kcbiao', 'isxiangqing')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_kcbiao')." ADD  `isxiangqing` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0显示1否';");
}
if(!pdo_fieldexists('wx_school_kcbiao', 'content')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_kcbiao')." ADD   `content` text NOT NULL COMMENT '课程内容';");
}
if(!pdo_fieldexists('wx_school_teachers', 'is_show')) {
	pdo_query("ALTER TABLE ".tablename('wx_school_teachers')." ADD   `is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示';");
}