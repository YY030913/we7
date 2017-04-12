<?php
$sql = "
	CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_iplist` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
	  `weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
	  `uniacid` int(10) unsigned NOT NULL COMMENT '公众号ID',
	  `iparr` varchar(2000) NOT NULL DEFAULT '' COMMENT 'IP区域',
	  `ipadd` varchar(200) NOT NULL DEFAULT '' COMMENT 'IP区域',
	  `createtime` int unsigned NOT NULL COMMENT '时间',
	  PRIMARY KEY (`id`),KEY `indx_uniacid` (`uniacid`),KEY `indx_createtime` (`createtime`)
	) ENGINE = MYISAM DEFAULT CHARSET = utf8;
	
	CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_iplistlog` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
	  `uniacid` int(10) unsigned NOT NULL COMMENT '公众号ID',
	  `avatar` varchar(200) NOT NULL DEFAULT '' COMMENT '微信头像', 
	  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称',
	  `from_user` varchar(255) NOT NULL DEFAULT '' COMMENT 'openid',
	  `ip` varchar(255) NOT NULL DEFAULT '' COMMENT 'IP',
	  `hitym` varchar(255) NOT NULL DEFAULT '' COMMENT '点击页面',
	  `createtime` int(11) NOT NULL COMMENT '初始时间',
	  PRIMARY KEY (`id`),KEY `indx_uniacid` (`uniacid`),KEY `indx_createtime` (`createtime`)
	) ENGINE=MYISAM DEFAULT CHARSET=utf8;
	
	CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_announce` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
	  `weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
	  `uniacid` int(10) unsigned NOT NULL COMMENT '公众号ID',
	  `content` varchar(2000) NOT NULL DEFAULT '' COMMENT '公告',
	  `nickname` varchar(200) NOT NULL DEFAULT '' COMMENT '公告',
	  `createtime` int unsigned NOT NULL COMMENT '时间',
	  PRIMARY KEY (`id`),KEY `indx_uniacid` (`uniacid`),KEY `indx_createtime` (`createtime`)
	) ENGINE = MYISAM DEFAULT CHARSET = utf8;
	
	CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_provevote_voice` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
	  `uniacid` int(10) unsigned NOT NULL COMMENT '公众号ID',
	  `from_user` varchar(200) NOT NULL DEFAULT '' COMMENT 'openid',
	  `mediaid` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐id',
	  `timelength` varchar(200) NOT NULL DEFAULT '' COMMENT '时间轴',
	  `voice` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `fmmid` varchar(200) NOT NULL DEFAULT '' COMMENT '识别',
	  `ip` varchar(255) NOT NULL DEFAULT '' COMMENT 'IP',
	  `createtime` int(11) NOT NULL COMMENT '初始时间',
	  PRIMARY KEY (`id`),KEY `indx_uniacid` (`uniacid`),KEY `indx_createtime` (`createtime`)
	) ENGINE=MYISAM DEFAULT CHARSET=utf8;
	
	CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_provevote_name` (
	  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
	  `uniacid` int(10) unsigned NOT NULL,
	  `from_user` varchar(255) NOT NULL DEFAULT '' COMMENT '用户openid',
	  `musicname` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `photoname` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `picarr_1_name` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `picarr_2_name` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `picarr_3_name` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `picarr_4_name` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `picarr_5_name` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `picarr_6_name` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `picarr_7_name` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `picarr_8_name` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `musicnamefop` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `voicename` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `voicenamefop` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
	  `vedioname` varchar(200) NOT NULL DEFAULT '' COMMENT '视频',
	  `vedionamefop` varchar(200) NOT NULL DEFAULT '' COMMENT '视频',
	  PRIMARY KEY (`id`),KEY `indx_uniacid` (`uniacid`),KEY `indx_rid` (`rid`)
	) ENGINE = MYISAM DEFAULT CHARSET = utf8;
CREATE TABLE  IF NOT EXISTS `ims_fm_photosvote_templates_designer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
  `uniacid` int(10) unsigned NOT NULL,
  `weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `stylename` varchar(30) NOT NULL,
  `pagename` varchar(255) NOT NULL DEFAULT '' COMMENT '页面名称',
  `pagetype` tinyint(3) NOT NULL DEFAULT '0' COMMENT '页面类型',
  `pageinfo` text NOT NULL,
  `keyword` varchar(255) DEFAULT '',
  `savetime` varchar(255) NOT NULL DEFAULT '' COMMENT '页面最后保存时间',
  `setdefault` tinyint(3) NOT NULL DEFAULT '0' COMMENT '默认页面',
  `datas` text NOT NULL COMMENT '数据',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_pagetype` (`pagetype`),
  FULLTEXT KEY `idx_keyword` (`keyword`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT  EXISTS `ims_fm_photosvote_templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
  `uniacid` int(10) unsigned NOT NULL,
  `weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `name` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL,
  `version` varchar(64) NOT NULL,
  `author` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `sections` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`)
) ENGINE=MYISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_fm_photosvote_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
  `uniacid` int(10) unsigned NOT NULL,
  `weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `title` varchar(100) NOT NULL DEFAULT '',
  `icon` varchar(200) NOT NULL DEFAULT '',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`uniacid`),
  KEY `indx_createtime` (`createtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_reply_huihua` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
  `command` varchar(10) NOT NULL COMMENT '报名命令',
  `tcommand` varchar(10) NOT NULL COMMENT '报名命令',
  `ishuodong` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1 开启',
  `huodongname` varchar(20) NOT NULL COMMENT '活动名字',
  `huodongdes` varchar(50) NOT NULL COMMENT '活动简介',
  `huodongurl` varchar(125) NOT NULL COMMENT '活动链接',
  `hhhdpicture` varchar(125) NOT NULL COMMENT '活动图片',
  `regmessagetemplate` varchar(50) NOT NULL COMMENT '投票创建成功通知报名成功',
  `messagetemplate` varchar(50) NOT NULL COMMENT '投票创建成功通知',
  `shmessagetemplate` varchar(50) NOT NULL COMMENT '投票创建成功通知投票审核成功',
  `fmqftemplate` varchar(50) NOT NULL COMMENT '投票创建成功通知群发消息',
  `msgtemplate` varchar(50) NOT NULL COMMENT '评论通知消息',
  PRIMARY KEY (`id`),
  KEY `indx_rid` (`rid`)
) ENGINE=MYISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_fm_photosvote_reply_share` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
  `subscribe` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否强制需要关注公众号才能参与',
  `shareurl` varchar(255) NOT NULL COMMENT '活动网址',
  `sharetitle` varchar(50) NOT NULL COMMENT '分享标题',
  `sharephoto` varchar(225) NOT NULL COMMENT 'fx图片',
  `sharecontent` varchar(100) NOT NULL COMMENT '分享简介',
  `subscribedes` varchar(200) NOT NULL COMMENT '分享提示语',
  PRIMARY KEY (`id`),
  KEY `indx_rid` (`rid`)
) ENGINE=MYISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_fm_photosvote_reply_vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
  `iscode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启投票验证码',
  `codekey` varchar(255) NOT NULL COMMENT '验证码key',
  `addpvapp` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '前端是否允许用户报名',
  `isfans` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0只保存本模块下1同步更新至官方FANS表',
  `mediatype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '上传模式',
  `mediatypem` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '上传模式',
  `mediatypev` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '上传模式',
  `voicemoshi` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '语音室模式',
  `moshi` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '展示模式： 1 相册模式  2 详情模式',
  `webinfo` text NOT NULL COMMENT '内容',
  `cqtp` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否可重复投票',
  `tpsh` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '投稿是否需审核',
  `isbbsreply` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启评论',
  `tmyushe` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '弹幕评论是否同步到数据库',
  `tmreply` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '弹幕评论是否同步到数据库',
  `isipv` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启IP作弊限制',
  `ipturl` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '存在作弊ip后是否继续允许查看，投票，评论等',
  `ipstopvote` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '存在作弊ip后是否继续允许查看，投票，评论等',
  `iplocallimit` varchar(100) NOT NULL COMMENT '地区限制',
  `iplocaldes` varchar(100) NOT NULL COMMENT '地区限制',
  `tpxz` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '投稿照片数限制',
  `autolitpic` int(10) unsigned NOT NULL DEFAULT '50' COMMENT '裁剪大小',
  `autozl` int(10) unsigned NOT NULL DEFAULT '50' COMMENT '裁剪质量',
  `limitip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '投票ip每天限制数',
  `daytpxz` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '每日投票数限制',
  `dayonetp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '同一选手投票数限制',
  `allonetp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '同一选手最高投票数',
  `fansmostvote` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户最高投票数',
  `userinfo` varchar(200) NOT NULL COMMENT '输入姓名或手机时的提示词',
  `votesuccess` varchar(200) NOT NULL COMMENT '投票成功提示语',
  `limitsd` varchar(20) NOT NULL COMMENT '全体限速',
  `limitsdps` varchar(20) NOT NULL COMMENT '全体限速投机票',
  PRIMARY KEY (`id`),
  KEY `indx_rid` (`rid`)
) ENGINE=MYISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_reply_display` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
  `istopheader` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '顶部导航',
  `ipannounce` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '顶部公告',
  `isbgaudio` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '背景音乐',
  `bgmusic` varchar(125) NOT NULL COMMENT '背景音乐链接',
  `isedes` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启首页显示说明',
  `tmoshi` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '首页显示模式',
  `indextpxz` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '首页列表显示数',
  `indexorder` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '首页排序',
  `indexpx` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '活动首页显示,0 按最新排序 1 按人气排序 3 按投票数排序',
  `phbtpxz` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '人气榜显示个数',
  `zanzhums` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '赞助商显示',
  `xuninum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '虚拟人数',
  `hits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击量',
  `xuninumtime` int(10) unsigned NOT NULL DEFAULT '86400' COMMENT '虚拟间隔时间',
  `xuninuminitial` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '虚拟随机数值1',
  `xuninumending` int(10) unsigned NOT NULL DEFAULT '50' COMMENT '虚拟随机数值2',
  `xuninum_time` int(10) unsigned NOT NULL COMMENT '虚拟随机数值',
  `isrealname` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要输入姓名0为不需要1为需要',
  `ismobile` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要输入手机号0为不需要1为需要',
  `isweixin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要输入微信号0为不需要1为需要',
  `isqqhao` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要输入QQ号0为不需要1为需要',
  `isemail` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要输入邮箱0为不需要1为需要',
  `isjob` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要输入职业0为不需要1为需要',
  `isxingqu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要输入兴趣0为不需要1为需要',
  `isaddress` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要输入地址0为不需要1为需要',
  `isindex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否首页显示0为不需要1为需要',
  `isreg` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否报名页显示0为不需要1为需要',
  `isdes` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否描述页显示0为不需要1为需要',
  `isvotexq` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否详情页显示0为不需要1为需要',
  `ispaihang` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否排行页显示0为不需要1为需要',
  `lapiao` varchar(5) NOT NULL COMMENT '拉票',
  `sharename` varchar(2) NOT NULL COMMENT '分享名字',
  `tpname` varchar(100) NOT NULL COMMENT '投票名称',
  `tpsname` varchar(100) NOT NULL COMMENT '投票数名称',
  `rqname` varchar(100) NOT NULL COMMENT '人气名称',
  `csrs` varchar(10) NOT NULL COMMENT '参赛作品',
  `ljtp` varchar(10) NOT NULL COMMENT '累计投票',
  `cyrs` varchar(10) NOT NULL COMMENT '参与人数',
  `iscopyright` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0显示公众号版权1为显示自定义版权',
  `copyrighturl` varchar(255) NOT NULL COMMENT '版权链接',
  `copyright` varchar(50) NOT NULL COMMENT '版权',
  `isvoteusers` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示投票人',
  `regtitlearr` varchar(500) NOT NULL COMMENT '姓名自定义',
  PRIMARY KEY (`id`),
  KEY `indx_rid` (`rid`)
) ENGINE=MYISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;


CREATE TABLE IF NOT EXISTS  `ims_fm_photosvote_reply_body` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
  `zbgcolor` varchar(10) NOT NULL COMMENT '背景色',
  `zbg` varchar(125) NOT NULL COMMENT '背景图',
  `voicebg` varchar(125) NOT NULL COMMENT '录音室背景',
  `zbgtj` varchar(125) NOT NULL COMMENT '背景图',
  `topbgcolor` varchar(10) NOT NULL COMMENT '背景图',
  `topbg` varchar(125) NOT NULL COMMENT '背景图',
  `topbgtext` varchar(125) NOT NULL COMMENT '背景图',
  `topbgrightcolor` varchar(10) NOT NULL COMMENT '背景图',
  `topbgright` varchar(125) NOT NULL COMMENT '背景图',
  `foobg1` varchar(125) NOT NULL COMMENT '背景图',
  `foobg2` varchar(125) NOT NULL COMMENT '背景图',
  `foobgtextn` varchar(125) NOT NULL COMMENT '背景图',
  `foobgtexty` varchar(125) NOT NULL COMMENT '背景图',
  `foobgtextmore` varchar(125) NOT NULL COMMENT '背景图',
  `foobgmorecolor` varchar(10) NOT NULL COMMENT '背景图',
  `foobgmore` varchar(125) NOT NULL COMMENT '背景图',
  `bodytextcolor` varchar(10) NOT NULL COMMENT '背景图',
  `bodynumcolor` varchar(10) NOT NULL COMMENT '背景图',
  `inputcolor` varchar(10) NOT NULL COMMENT '背景图',
  `bodytscolor` varchar(10) NOT NULL COMMENT '背景图',
  `bodytsbg` varchar(125) NOT NULL COMMENT '背景图',
  `xinbg` varchar(125) NOT NULL COMMENT '背景图',
  `copyrightcolor` varchar(10) NOT NULL COMMENT '背景图',
  PRIMARY KEY (`id`),
  KEY `indx_rid` (`rid`)
) ENGINE=MYISAM  AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_provevote_voice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
  `uniacid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `from_user` varchar(555) NOT NULL DEFAULT '' COMMENT 'openid',
  `mediaid` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐id',
  `timelength` varchar(200) NOT NULL DEFAULT '' COMMENT '时间轴',
  `voice` varchar(200) NOT NULL DEFAULT '' COMMENT '音乐',
  `fmmid` varchar(200) NOT NULL DEFAULT '' COMMENT '识别',
  `ip` varchar(255) NOT NULL DEFAULT '' COMMENT 'IP',
  `createtime` int(11) NOT NULL COMMENT '初始时间',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`uniacid`),
  KEY `indx_createtime` (`createtime`),
  KEY `indx_from_user` (`from_user`(255)),
  KEY `indx_rid` (`rid`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_provevote_picarr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
  `mid` int(10) unsigned NOT NULL,
  `lastmid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `from_user` varchar(255) NOT NULL DEFAULT '' COMMENT '用户openid',
  `photos` varchar(200) NOT NULL DEFAULT '' COMMENT '图片',
  `photoname` varchar(200) NOT NULL DEFAULT '' COMMENT '图片名字',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `isfm` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否设置为封面',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`uniacid`),
  KEY `indx_rid` (`rid`),
  KEY `indx_from_user` (`from_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_templates_designer_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `menuname` varchar(255) DEFAULT '',
  `isdefault` tinyint(3) DEFAULT '0',
  `createtime` int(11) DEFAULT '0',
  `menus` text,
  `params` text,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_isdefault` (`isdefault`),
  KEY `idx_createtime` (`createtime`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_voteer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `realname` varchar(30) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `ip` varchar(100) NOT NULL DEFAULT '' COMMENT 'ip',
  `iparr` varchar(200) NOT NULL DEFAULT '' COMMENT 'IP区域',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_rid` (`rid`),
  KEY `idx_from_user` (`from_user`),
  KEY `idx_mobile` (`mobile`),
  KEY `idx_createtime` (`createtime`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_onlyoauth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteid` int(10) unsigned NOT NULL,
  `fmauthtoken` varchar(255) NOT NULL,
  `modules` varchar(120) NOT NULL,
  `oauthurl` varchar(120) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `visitorsip` varchar(100) NOT NULL DEFAULT '' COMMENT 'ip',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_siteid` (`siteid`),
  KEY `idx_createtime` (`createtime`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `tfrom_user` varchar(50) NOT NULL,
  `ordersn` varchar(50) NOT NULL,
  `price` varchar(10) NOT NULL,
  `vote_times` varchar(10) NOT NULL,
  `realname` varchar(30) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `payyz` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1取消状态，0普通状态，1为已付款，2为已发货，3为成功',
  `paytype` tinyint(1) unsigned NOT NULL COMMENT '1为余额，2为在线，3为到付',
  `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号',
  `remark` varchar(1000) NOT NULL DEFAULT '',
  `paytime` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_rid` (`rid`),
  KEY `idx_from_user` (`from_user`),
  KEY `idx_tfrom_user` (`tfrom_user`),
  KEY `idx_ordersn` (`ordersn`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_pnametag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规则id',
  `weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `uniacid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `title` varchar(350) NOT NULL DEFAULT '' COMMENT '默认口号',
  `createtime` int(10) unsigned NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `indx_uniacid` (`uniacid`),
  KEY `indx_createtime` (`createtime`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS
 `ims_fm_photosvote_qunfa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `avatar` varchar(200) NOT NULL DEFAULT '' COMMENT '微信头像',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `type` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `lasttime` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_rid` (`rid`),
  KEY `idx_from_user` (`from_user`),
  KEY `idx_createtime` (`createtime`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_fm_photosvote_vote_shuapiao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `uniacid` int(10) unsigned NOT NULL,
  `rid` int(10) unsigned NOT NULL,
  `from_user` varchar(150) NOT NULL,
  `ip` varchar(100) NOT NULL DEFAULT '' COMMENT 'ip',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uniacid` (`uniacid`),
  KEY `idx_rid` (`rid`),
  KEY `idx_from_user` (`from_user`),
  KEY `idx_ip` (`ip`)
) ENGINE=MYISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
";

pdo_run($sql);



 if(!pdo_fieldexists('fm_photosvote_reply', 'autolitpic')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `autolitpic` int(10) unsigned NOT NULL DEFAULT '50' COMMENT '裁剪大小';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'autozl')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `autozl` int(10) unsigned NOT NULL DEFAULT '50' COMMENT '裁剪质量';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'zbgcolor')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD  `zbgcolor` varchar(50) NOT NULL COMMENT '背景色';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'zbg')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `zbg` varchar(255) NOT NULL COMMENT '背景图';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'zbgtj')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `zbgtj` varchar(255) NOT NULL COMMENT '背景图';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'lapiao')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `lapiao` varchar(5) NOT NULL COMMENT '拉票';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'sharename')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `sharename` varchar(2) NOT NULL COMMENT '分享';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'ishuodong')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `ishuodong` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'huodongname')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `huodongname` varchar(100) NOT NULL COMMENT '活动名称';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'huodongurl')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `huodongurl` varchar(255) NOT NULL COMMENT '活动链接网址';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'ishuodong')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `ishuodong` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'isindex')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `isindex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否首页显示0为不需要1为需要';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'isvotexq')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `isvotexq` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否详情页显示0为不需要1为需要';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'ispaihang')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `ispaihang` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否排行页显示0为不需要1为需要';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'isreg')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `isreg` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否报名页显示0为不需要1为需要';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'isdes')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `isdes` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否描述页显示0为不需要1为需要';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'addpv')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `addpv` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启添加投稿';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'addpvapp')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `addpvapp` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '前端是否允许用户报名';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'messagetemplate')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `messagetemplate` varchar(255) NOT NULL COMMENT '投票模板ID';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'regmessagetemplate')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `regmessagetemplate` varchar(255) NOT NULL COMMENT '报名模板ID';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'shmessagetemplate')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `shmessagetemplate` varchar(255) NOT NULL COMMENT '报名模板ID';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'iscode')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `iscode` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启投票验证码';");
}
 if(!pdo_fieldexists('fm_photosvote_reply', 'isedes')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `isedes` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启首页显示说明';");
}

//字段长度
if(pdo_fieldexists('fm_photosvote_provevote', 'picarr')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_provevote')." CHANGE `picarr` `picarr` varchar(5000) DEFAULT '';");
}
//颜色及背景配置
if(!pdo_fieldexists('fm_photosvote_reply', 'bgarr')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `bgarr` varchar(5000) NOT NULL DEFAULT '';");
}

if(!pdo_fieldexists('fm_photosvote_reply', 'tstart_time')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `tstart_time` int(10) unsigned NOT NULL COMMENT '投票开始时间';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'tend_time')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `tend_time` int(10) unsigned NOT NULL COMMENT '投票结束时间';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'bstart_time')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `bstart_time` int(10) unsigned NOT NULL COMMENT '报名开始时间';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'bend_time')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `bend_time` int(10) unsigned NOT NULL COMMENT '报名结束时间';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'ttipstart')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `ttipstart` varchar(255) NOT NULL COMMENT '投票开始时间';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'ttipend')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `ttipend` varchar(255) NOT NULL COMMENT '投票结束时间';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'btipstart')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `btipstart` varchar(255) NOT NULL COMMENT '报名开始时间';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'btipend')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `btipend` varchar(255) NOT NULL COMMENT '报名结束时间';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'tmreply')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `tmreply` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '弹幕评论是否同步到数据库';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'tmyushe')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `tmyushe` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '弹幕评论是否同步到数据库';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'isipv')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `isipv` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启IP作弊限制';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'ipturl')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `ipturl` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '存在作弊ip后是否继续允许查看，投票，评论等';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'ipstopvote')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `ipstopvote` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '存在作弊ip后是否继续允许查看，投票，评论等';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'ipannounce')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `ipannounce` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启公告';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'tmoshi')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `tmoshi` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '首页显示模式';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'mediatype')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `mediatype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '上传模式';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'music')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `music` varchar(512) NOT NULL DEFAULT '' COMMENT '音乐';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'mediaid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `mediaid` varchar(512) NOT NULL DEFAULT '' COMMENT 'voiceid';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'vedio')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `vedio` varchar(512) NOT NULL DEFAULT '' COMMENT '视频';");
}
if(!pdo_fieldexists('fm_photosvote_data', 'tfrom_user')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_data')." ADD `tfrom_user` varchar(150) NOT NULL DEFAULT '' COMMENT '被分享用户openid';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'tpname')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `tpname` varchar(255) NOT NULL COMMENT '投票名字';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'rqname')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `rqname` varchar(255) NOT NULL COMMENT '人气名字';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'tpsname')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `tpsname` varchar(255) NOT NULL COMMENT '投票数名字';");
}
if(!pdo_fieldexists('fm_photosvote_announce', 'url')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_announce')." ADD `url` varchar(500) NOT NULL DEFAULT '' COMMENT '公告链接';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'votesuccess')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `votesuccess` varchar(555) NOT NULL COMMENT '投票成功提示语';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'subscribedes')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `subscribedes` varchar(555) NOT NULL COMMENT '分享提示语';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'csrs')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `csrs` varchar(555) NOT NULL COMMENT '参赛作品';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'ljtp')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `ljtp` varchar(555) NOT NULL COMMENT '累计投票';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'cyrs')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `cyrs` varchar(555) NOT NULL COMMENT '参与人数';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'voicebg')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `voicebg` varchar(555) NOT NULL COMMENT '背景';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'voice')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `voice` varchar(512) NOT NULL DEFAULT '' COMMENT '视频';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'timelength')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `timelength` varchar(512) NOT NULL DEFAULT '' COMMENT '时间轴';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'fmmid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `fmmid` varchar(512) NOT NULL DEFAULT '' COMMENT '文件名';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'voicemoshi')) {
	pdo_query("ALTER TABLE  ".tablename('fm_photosvote_reply')." ADD `voicemoshi` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '语音室模式';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'qiniu')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `qiniu` varchar(5000) NOT NULL DEFAULT '' COMMENT 'qiniu';");
}	  
	 
if(!pdo_fieldexists('fm_photosvote_reply', 'votetime')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `votetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户投票时间';");
}
if(pdo_fieldexists('fm_photosvote_reply', 'votetime')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." CHANGE  `votetime` `votetime` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '用户投票时间';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'ttipvote')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `ttipvote` varchar(100) NOT NULL COMMENT '用户投票时间结束提示语';");
}

if(!pdo_fieldexists('fm_photosvote_reply', 'mediatypem')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `mediatypem` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '上传模式';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'mediatypev')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `mediatypev` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '上传模式';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'isdaojishi')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `isdaojishi` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '倒计时';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'picarr_1')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `picarr_1` varchar(500) NOT NULL DEFAULT '' COMMENT '照片组';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'picarr_2')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `picarr_2` varchar(500) NOT NULL DEFAULT '' COMMENT '照片组';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'picarr_3')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `picarr_3` varchar(500) NOT NULL DEFAULT '' COMMENT '照片组';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'picarr_4')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `picarr_4` varchar(500) NOT NULL DEFAULT '' COMMENT '照片组';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'picarr_5')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `picarr_5` varchar(500) NOT NULL DEFAULT '' COMMENT '照片组';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'picarr_6')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `picarr_6` varchar(500) NOT NULL DEFAULT '' COMMENT '照片组';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'picarr_7')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `picarr_7` varchar(500) NOT NULL DEFAULT '' COMMENT '照片组';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'picarr_8')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `picarr_8` varchar(500) NOT NULL DEFAULT '' COMMENT '照片组';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'isjob')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD  `isjob` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要输入职业0为不需要1为需要';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'isxingqu')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD  `isxingqu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要输入兴趣0为不需要1为需要';");
}

if(!pdo_fieldexists('fm_photosvote_reply', 'limitip')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD   `limitip` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '投票ip每天限制数';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'webinfo')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD   `webinfo` text NOT NULL COMMENT '内容';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'bgarr')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD  `bgarr` varchar(1000) NOT NULL COMMENT '颜色及背景配置';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'votesuccess')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD  `votesuccess` varchar(200) NOT NULL COMMENT '投票成功提示语';");
}

if(!pdo_fieldexists('fm_photosvote_reply', 'subscribedes')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD   `subscribedes` varchar(200) NOT NULL COMMENT '分享提示语';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'voicebg')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD   `voicebg` varchar(200) NOT NULL COMMENT '录音室背景';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'qiniu')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD    `qiniu` varchar(600) NOT NULL COMMENT '七牛';");
}

if(!pdo_fieldexists('fm_photosvote_provevote', 'youkuurl')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD   `youkuurl` varchar(200) NOT NULL DEFAULT '' COMMENT '视频';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'job')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD    `job` varchar(20) NOT NULL DEFAULT '' COMMENT '职业';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'xingqu')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD     `xingqu` varchar(20) NOT NULL DEFAULT '' COMMENT '兴趣';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'iparr')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD   `iparr` varchar(200) NOT NULL DEFAULT '' COMMENT 'ip地区';");
}

if(!pdo_fieldexists('fm_photosvote_votelog', 'iparr')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_votelog')." ADD   `iparr` varchar(200) NOT NULL DEFAULT '' COMMENT 'ip地区';");
}

if(!pdo_fieldexists('fm_photosvote_bbsreply', 'iparr')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_bbsreply')." ADD `iparr` varchar(200) NOT NULL DEFAULT '' COMMENT 'ip地区';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'job')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `job` varchar(50) NOT NULL DEFAULT '' COMMENT '职业';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'xingqu')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `xingqu` varchar(50) NOT NULL DEFAULT '' COMMENT '兴趣';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'isjob')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `isjob` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要输入职业0为不需要1为需要';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'isxingqu')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `isxingqu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要输入兴趣0为不需要1为需要';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'indexorder')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `indexorder` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '首页排序';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'istopheader')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `istopheader` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '最上方';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'isid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `isid` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'isid';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'zanzhums')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `zanzhums` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '赞助商显示';");
}

if(!pdo_fieldexists('fm_photosvote_reply', 'codekey')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD  `codekey` varchar(64) NOT NULL COMMENT '验证码key';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'youkuurl')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `youkuurl` varchar(255) NOT NULL DEFAULT '' COMMENT 'youkuurl';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'ysid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `ysid` int(10) unsigned NOT NULL COMMENT 'ysid';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'ewm')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `ewm` varchar(200) NOT NULL DEFAULT '' COMMENT '二维码地址';");
}

if(!pdo_fieldexists('fm_photosvote_advs', 'ismiaoxian')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_advs')." ADD `ismiaoxian` int(10) unsigned NOT NULL COMMENT 'ismiaoxian';");
}

if(!pdo_fieldexists('fm_photosvote_advs', 'issuiji')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_advs')." ADD `issuiji` int(10) unsigned NOT NULL COMMENT 'ismiaoxian';");
}

if(!pdo_fieldexists('fm_photosvote_advs', 'times')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_advs')." ADD `times` int(10) unsigned NOT NULL COMMENT 'ismiaoxian';");
}

if(!pdo_fieldexists('fm_photosvote_advs', 'nexttime')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_advs')." ADD `nexttime` int(10) unsigned NOT NULL COMMENT 'ismiaoxian';");
}

if(!pdo_fieldexists('fm_photosvote_provevote', 'tfrom_user')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD `tfrom_user` varchar(150) NOT NULL DEFAULT '' COMMENT '被分享用户openid';");
}
if(!pdo_fieldexists('fm_photosvote_advs', 'description')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_advs')." ADD `description` varchar(150) NOT NULL DEFAULT '' COMMENT '描述';");
}

if(!pdo_fieldexists('fm_photosvote_reply', 'hhhdpicture')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD  `hhhdpicture` varchar(150) NOT NULL COMMENT '会话活动图片';");
}
//0731
if(!pdo_fieldexists('fm_photosvote_reply', 'fansmostvote')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD   `fansmostvote` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户最高投票数';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'mtemplates')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD  `mtemplates` varchar(500) NOT NULL COMMENT '模板ID';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'huodong')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD    `huodong` varchar(500) NOT NULL COMMENT '活动';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'command')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD   `command` varchar(10) NOT NULL COMMENT '报名命令';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'istop')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD  `istop` varchar(300) NOT NULL COMMENT '顶部设置';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'isid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD    `isid` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'isid';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'hhhdpicture')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD      `hhhdpicture` varchar(150) NOT NULL COMMENT '会话活动图片';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'iplocallimit')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD    `iplocallimit` varchar(100) NOT NULL COMMENT '地区限制';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'iplocaldes')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD    `iplocaldes` varchar(100) NOT NULL COMMENT '地区限制';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'ysid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD   `ysid` int(10) unsigned NOT NULL COMMENT 'ysid';");
}
//0824
if(pdo_fieldexists('fm_photosvote_reply', 'start_time')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." CHANGE   `start_time` `start_time` int(10) unsigned NOT NULL COMMENT '开始时间';");
}
if(pdo_fieldexists('fm_photosvote_reply', 'end_time')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." CHANGE   `end_time`   `end_time` int(10) unsigned NOT NULL COMMENT '结束时间';");
}
if(pdo_fieldexists('fm_photosvote_reply', 'tstart_time')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." CHANGE   `tstart_time`   `tstart_time` int(10) unsigned NOT NULL COMMENT '投票开始时间';");
}
if(pdo_fieldexists('fm_photosvote_reply', 'tend_time')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." CHANGE   `tend_time`   `tend_time` int(10) unsigned NOT NULL COMMENT '投票结束时间';");
}
if(pdo_fieldexists('fm_photosvote_reply', 'bstart_time')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." CHANGE   `bstart_time`   `bstart_time` int(10) unsigned NOT NULL COMMENT '报名开始时间';");
}
if(pdo_fieldexists('fm_photosvote_reply', 'bend_time')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." CHANGE   `bend_time`    `bend_time` int(10) unsigned NOT NULL COMMENT '报名结束时间';");
}
if(pdo_fieldexists('fm_photosvote_reply', 'command')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." CHANGE   `command`    `command` varchar(10) NOT NULL COMMENT '报名命令';");
}
if(pdo_fieldexists('fm_photosvote_provevote', 'picarr')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." CHANGE   `picarr`   `picarr` varchar(2000) DEFAULT '';");
}
if(pdo_fieldexists('fm_photosvote_provevote', 'lasttime')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." CHANGE   `lasttime`    `lasttime` int(10) unsigned NOT NULL COMMENT '最后编辑时间';");
}
if(pdo_fieldexists('fm_photosvote_provevote', 'picarr')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." CHANGE   `sharetime`    `sharetime` int(10) unsigned NOT NULL COMMENT '最后分享时间';");
}
if(pdo_fieldexists('fm_photosvote_provevote', 'sharenum')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." CHANGE   `sharenum`    `sharenum` int(10) unsigned NOT NULL COMMENT '最后分享';");
}
if(pdo_fieldexists('fm_photosvote_provevote', 'createtime')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." CHANGE   `createtime`     `createtime` int(10) unsigned NOT NULL COMMENT '注册时间';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'sex')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." add  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别，1、男 2、女 0 、未知';");
}

if(pdo_fieldexists('fm_photosvote_votelog', 'createtime')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_votelog')." CHANGE   `createtime`       `createtime` int(10) unsigned NOT NULL COMMENT '投票时间';");
}

if(pdo_fieldexists('fm_photosvote_announce', 'createtime')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_announce')." CHANGE   `createtime`     `createtime` int(10) unsigned NOT NULL COMMENT '时间';");
}
if(pdo_fieldexists('fm_photosvote_iplist', 'createtime')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_iplist')." CHANGE   `createtime`     `createtime` int(10) unsigned NOT NULL COMMENT '时间';");
}
if(pdo_fieldexists('fm_photosvote_data', 'visitorstime')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_data')." CHANGE   `visitorstime`      `visitorstime` int(10) unsigned NOT NULL COMMENT '访问时间';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'stopping')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD `stopping` varchar(225) NOT NULL COMMENT 'fx图片';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'nostart')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD    `nostart` varchar(225) NOT NULL COMMENT 'fx图片';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'end')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD    `end` varchar(225) NOT NULL COMMENT 'fx图片';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'templates')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD    `templates` varchar(50) NOT NULL DEFAULT 'default' COMMENT '默认模板';");
}
if(!pdo_fieldexists('fm_photosvote_provevote_voice', 'weid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote_voice')." ADD   `weid` int(10) unsigned NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists('fm_photosvote_provevote_name', 'weid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote_name')." ADD   `weid` int(10) unsigned NOT NULL COMMENT '公众号ID';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'uid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD    `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户编号';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'tagid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD    `tagid` int(10) unsigned NOT NULL COMMENT '分组id';");
}
if(pdo_fieldexists('fm_photosvote_provevote', 'description')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." CHANGE `description` `description` text NOT NULL COMMENT '简介，描述';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'zans')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD    `zans` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'isadmin')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD    `isadmin` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否设置为管理员';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'istuijian')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD   `istuijian` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否设置为推荐';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'limitsd')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD    `limitsd` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '限速';");
}
/*if(!pdo_fieldexists('fm_photosvote_provevote', 'uk_uid2')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD INDEX `uk_uid` (`uid`);");
}
if(!pdo_fieldexists('fm_photosvote_data', 'uk_uid2')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_data')." ADD  INDEX `IDX_FROMUSER` (`fromuser`);");
}
if(!pdo_fieldexists('fm_photosvote_data', 'uk_uid2')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_data')." ADD  INDEX `IDX_TFROM_USER` (`tfrom_user`);");
}*/
if(!pdo_fieldexists('fm_photosvote_bbsreply', 'zan')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_bbsreply')." ADD   `zan` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '点赞数';");
}
/*
if(!pdo_fieldexists('fm_photosvote_votelog', 'uk_uid2')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_votelog')." ADD  INDEX  `IDX_IP_CREATETIME` (`ip`,`createtime`);");
}
if(!pdo_fieldexists('fm_photosvote_votelog', 'uk_uid2')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_votelog')." ADD  INDEX  `IDX_TFROM_USER` (`tfrom_user`);");
}
*/

if(!pdo_fieldexists('fm_photosvote_provevote', 'www')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD   `www` varchar(30) NOT NULL DEFAULT '0' COMMENT '0';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'com')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD   `com` varchar(30) NOT NULL DEFAULT '0' COMMENT '0';");
}
if(!pdo_fieldexists('fm_photosvote_votelog', 'ordersn')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_votelog')." ADD  `ordersn` varchar(55) NOT NULL DEFAULT '' COMMENT '投票付款订单号';");
}
if(!pdo_fieldexists('fm_photosvote_votelog', 'vote_times')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_votelog')." ADD    `vote_times` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '投票次数';");
}
if(!pdo_fieldexists('fm_photosvote_votelog', 'is_del')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_votelog')." ADD    `is_del` tinyint(2) DEFAULT '0' COMMENT '是否已删除 0-否 1-是';");
}
if(!pdo_fieldexists('fm_photosvote_templates', 'stylename')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_templates')." ADD    `stylename` varchar(30) NOT NULL;");
}
if(!pdo_fieldexists('fm_photosvote_tags', 'parentid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_tags')." ADD   `parentid` int(10) unsigned NOT NULL COMMENT 'pid';");
}
if(!pdo_fieldexists('fm_photosvote_tags', 'description')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_tags')." ADD    `description` varchar(200) NOT NULL DEFAULT '';");
}

if(!pdo_fieldexists('fm_photosvote_reply_vote', 'votepay')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD   `votepay` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启投票付费';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'votepaytitle')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `votepaytitle` varchar(50) NOT NULL COMMENT '付费名称';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'votepaydes')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `votepaydes` varchar(200) NOT NULL COMMENT '付费描述';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'votepayfee')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `votepayfee` varchar(50) NOT NULL COMMENT '付费金额';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'regpay')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `regpay` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启报名付费';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'regpaytitle')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `regpaytitle` varchar(50) NOT NULL COMMENT '报名名称';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'regpaydes')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `regpaydes` varchar(200) NOT NULL COMMENT '报名描述';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'regpayfee')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `regpayfee` varchar(50) NOT NULL COMMENT '报名金额';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'uni_fansmostvote')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `uni_fansmostvote` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '多用户最高投票数';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'uni_daytpxz')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `uni_daytpxz` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '多每日投票数限制';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'uni_allonetp')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `uni_allonetp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '多同一选手最高投票数';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'uni_dayonetp')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `uni_dayonetp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '多同一选手投票数限制';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'uni_all_users')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `uni_all_users` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '查看所有用户';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'votenumpiao')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `votenumpiao` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启投票用户自定投票数';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'voteerinfo')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `voteerinfo` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启投票用户填写信息';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'unimoshi')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `unimoshi` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '公众号模式';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'usersmostvote')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `usersmostvote` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '选手最高得票数';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'votestarttime')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `votestarttime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'voteendtime')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `voteendtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'ismediatypem')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `ismediatypem` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '上传模式';");
}
if(!pdo_fieldexists('fm_photosvote_reply_vote', 'ismediatypev')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD    `ismediatypev` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '上传模式';");
}

if(!pdo_fieldexists('fm_photosvote_reply_display', 'csrs_total')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_display')." ADD   `csrs_total` varchar(10) NOT NULL COMMENT '参赛作品总数';");
}
if(!pdo_fieldexists('fm_photosvote_reply_display', 'ljtp_total')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_display')." ADD   `ljtp_total` varchar(10) NOT NULL COMMENT '累计投票总数';");
}
if(!pdo_fieldexists('fm_photosvote_reply_display', 'xunips')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_display')." ADD  `xunips` varchar(10) NOT NULL COMMENT '虚拟累计投票总数';");
}
if(!pdo_fieldexists('fm_photosvote_reply_display', 'cyrs_total')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_display')." ADD   `cyrs_total` varchar(10) NOT NULL COMMENT '参与人数总数';");
}
if(!pdo_fieldexists('fm_photosvote_reply_display', 'unphotosnum')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_display')." ADD   `unphotosnum` varchar(10) NOT NULL COMMENT '取消票数';");
}
if(!pdo_fieldexists('fm_photosvote_reply_display', 'iscontent')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_display')." ADD   `iscontent` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启首页显示说明';");
}
if(!pdo_fieldexists('fm_photosvote_reply_display', 'isphotosname')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_display')." ADD   `isphotosname` tinyint(1) unsigned NOT NULL DEFAULT '1';");
}
if(!pdo_fieldexists('fm_photosvote_reply_display', 'isregdes')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_display')." ADD   `isregdes` tinyint(1) unsigned NOT NULL DEFAULT '1';");
}

if(!pdo_fieldexists('fm_photosvote_reply', 'binduniacid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD  `binduniacid` varchar(150) NOT NULL COMMENT '多公众号ID';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'unimoshi')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD  `unimoshi` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '公众号模式';");
}
if(!pdo_fieldexists('fm_photosvote_reply', 'menuid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply')." ADD  `menuid` int(10) unsigned NOT NULL COMMENT '底部导航ID';");
}

if(!pdo_fieldexists('fm_photosvote_provevote', 'wx')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD  `wx` varchar(30) NOT NULL DEFAULT '0' COMMENT '0';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'unionid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD   `unionid` varchar(255) NOT NULL DEFAULT '' COMMENT '统一用户openid';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'ordersn')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD   `ordersn` varchar(55) NOT NULL DEFAULT '' COMMENT '付款订单号';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'tagpid')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD   `tagpid` int(10) unsigned NOT NULL COMMENT '分组pid';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'tagpidtest')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD   `tagpidtest` int(10) unsigned NOT NULL COMMENT 'tagpidtest';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'unphotosnum')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD   `unphotosnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '减少的票数';");
}
if(!pdo_fieldexists('fm_photosvote_provevote', 'unhits')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_provevote')." ADD   `unhits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '减少的人气';");
}
if(!pdo_fieldexists('fm_photosvote_iplistlog', 'iparr')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_iplistlog')." ADD    `iparr` varchar(200) NOT NULL DEFAULT '' COMMENT 'IP区域';");
}

if(!pdo_fieldexists('fm_photosvote_reply_vote', 'ismediatype')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_reply_vote')." ADD   `ismediatype` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '上传模式';");
}
if(!pdo_fieldexists('fm_photosvote_votelog', 'shuapiao')) {
	pdo_query("ALTER TABLE ".tablename('fm_photosvote_votelog')." ADD   `shuapiao` tinyint(1) unsigned NOT NULL;");
}
