<?php
$sql = "
CREATE TABLE IF NOT EXISTS `ims_xcommunity_activity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `regionid` varchar(5000) NOT NULL,
  `starttime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  `enddate` varchar(30) NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `number` int(11) NOT NULL DEFAULT '1',
  `content` varchar(2000) NOT NULL,
  `status` int(1) NOT NULL COMMENT '1置顶',
  `price` decimal(12,2) NOT NULL,
  `createtime` int(11) unsigned NOT NULL,
  `resnumber` int(11) unsigned NOT NULL COMMENT '报名人数',
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_xcommunity_admap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `regionid` int(11) NOT NULL,
  `adid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_alipayment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL COMMENT '公众号ID',
  `pid` int(11) NOT NULL,
  `account` varchar(50) NOT NULL COMMENT '支付宝账号',
  `partner` varchar(50) NOT NULL COMMENT '合作者身份',
  `secret` varchar(50) NOT NULL COMMENT '校验密钥',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='独立支付宝配置' AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS  `ims_xcommunity_announcement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `regionid` int(10) unsigned NOT NULL COMMENT '小区编号',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `author` varchar(50) NOT NULL COMMENT '作者',
  `createtime` int(10) unsigned NOT NULL,
  `starttime` int(11) unsigned NOT NULL COMMENT '开始时间',
  `endtime` int(11) unsigned NOT NULL COMMENT '结束时间',
  `status` tinyint(1) NOT NULL COMMENT '1禁用，2启用',
  `enable` tinyint(1) NOT NULL COMMENT '模板类型',
  `datetime` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL COMMENT '通知范围',
  `reason` varchar(100) NOT NULL COMMENT '通知范围',
  `remark` varchar(100) NOT NULL COMMENT '通知备注',
  `pid` int(10) unsigned NOT NULL COMMENT '物业ID',
  `tit` varchar(255) NOT NULL COMMENT '标题',
  `time` varchar(100) NOT NULL COMMENT '门禁卡失效时间',
  `scope` varchar(100) NOT NULL COMMENT '门禁卡失效范围',
  `method` varchar(300) NOT NULL COMMENT '门禁卡重新激活办法',
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='发布公告';

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_business` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `qq` int(11) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `status` int(1) unsigned NOT NULL COMMENT '0未审核，1审核',
  `balance` decimal(10,2) NOT NULL COMMENT '商家余额',
  `commission` float NOT NULL COMMENT '分成，0-1之间',
  `alipay` varchar(100) NOT NULL COMMENT '支付宝账户',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_carpool` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `seat` int(2) unsigned NOT NULL,
  `sprice` int(10) unsigned NOT NULL,
  `month` int(2) unsigned NOT NULL,
  `yday` int(2) unsigned NOT NULL,
  `contact` varchar(50) NOT NULL,
  `mobile` varchar(13) NOT NULL,
  `openid` varchar(50) NOT NULL,
  `start_position` varchar(100) NOT NULL,
  `end_position` varchar(100) NOT NULL,
  `startMinute` int(10) unsigned NOT NULL,
  `startSeconds` int(10) unsigned NOT NULL,
  `license_number` varchar(100) NOT NULL,
  `car_model` varchar(100) NOT NULL,
  `car_brand` varchar(100) NOT NULL,
  `content` varchar(300) NOT NULL,
  `enable` int(1) NOT NULL COMMENT '1开启,0关闭',
  `status` int(11) NOT NULL,
  `gotime` varchar(10) NOT NULL COMMENT '出发时间',
  `backtime` varchar(10) NOT NULL COMMENT '返回时间',
  `createtime` int(10) unsigned NOT NULL,
  `regionid` int(10) unsigned NOT NULL,
  `type` int(11) NOT NULL COMMENT '类型1司机，2乘客',
  `thumb` varchar(2000) NOT NULL COMMENT '图片',
  `black` int(1) NOT NULL COMMENT '1设置黑名单',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `goodsid` int(11) NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `total` int(10) unsigned NOT NULL,
  `marketprice` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='购物车表' AUTO_INCREMENT=13 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_cash_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `cash` decimal(10,2) NOT NULL,
  `status` int(1) NOT NULL,
  `createtime` int(11) NOT NULL,
  `ordersn` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='提现订单';

CREATE TABLE IF NOT EXISTS `ims_xcommunity_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned DEFAULT NULL,
  `parentid` int(10) unsigned DEFAULT NULL,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `description` varchar(50) NOT NULL COMMENT '分类描述',
  `thumb` varchar(100) NOT NULL COMMENT '分类图片',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `type` int(10) unsigned NOT NULL COMMENT '1家政，2报修，3投诉，4二手，5超市，6商家',
  `price` decimal(12,2) DEFAULT NULL,
  `gtime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='类型表' AUTO_INCREMENT=20 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_cost` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `regionid` int(10) unsigned NOT NULL,
  `costtime` varchar(30) NOT NULL COMMENT '费用时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='物业费用时间表' AUTO_INCREMENT=2 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_cost_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `regionid` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL COMMENT '费用时间id',
  `mobile` varchar(13) NOT NULL,
  `username` varchar(30) NOT NULL,
  `homenumber` varchar(30) NOT NULL,
  `costtime` varchar(30) NOT NULL,
  `propertyfee` varchar(50) NOT NULL,
  `otherfee` varchar(100) NOT NULL,
  `total` varchar(10) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `status` varchar(3) NOT NULL COMMENT '是代表缴费，否代表未缴费',
  `paytype` tinyint(1) unsigned NOT NULL COMMENT '1为余额，2为在线，3为到付',
  `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='物业费表' AUTO_INCREMENT=5 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_dp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `uid` int(11) NOT NULL,
  `regionid` varchar(5000) NOT NULL,
  `sjname` varchar(30) NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `contactname` varchar(30) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `qq` int(11) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `dist` varchar(50) NOT NULL,
  `address` varchar(150) NOT NULL,
  `shopdesc` varchar(500) NOT NULL,
  `businnesstime` varchar(20) NOT NULL,
  `businessurl` varchar(100) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `lat` varchar(20) NOT NULL,
  `lng` varchar(20) NOT NULL,
  `businesstime` varchar(50) DEFAULT NULL,
  `parent` varchar(20) DEFAULT NULL,
  `child` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_fled` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `title` varchar(20) NOT NULL,
  `rolex` varchar(30) NOT NULL,
  `category` varchar(30) NOT NULL,
  `yprice` int(10) NOT NULL,
  `zprice` int(10) NOT NULL,
  `realname` varchar(18) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `description` varchar(100) NOT NULL,
  `regionid` int(10) NOT NULL,
  `createtime` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `images` text,
  `black` int(1) NOT NULL COMMENT '1设置黑名单',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `pcate` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `thumb_url` text,
  `unit` varchar(5) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `marketprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '销售价',
  `productprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `total` int(10) NOT NULL DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL,
  `credit` int(11) DEFAULT '0',
  `isrecommand` int(11) DEFAULT '0',
  `description` text,
  `dpid` int(11) DEFAULT NULL,
  `sold` int(11) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `regionid` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品表' AUTO_INCREMENT=15 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_homemaking` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `regionid` int(10) unsigned NOT NULL,
  `category` int(11) NOT NULL COMMENT '服务类型',
  `servicetime` varchar(30) NOT NULL COMMENT '服务时间',
  `realname` varchar(30) NOT NULL COMMENT '姓名',
  `mobile` varchar(15) NOT NULL COMMENT '电话',
  `address` varchar(15) NOT NULL COMMENT '地址',
  `content` varchar(500) NOT NULL COMMENT '说明',
  `status` int(10) unsigned NOT NULL COMMENT '0未完成,1已完成',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='家政服务表' AUTO_INCREMENT=9 ;

CREATE TABLE IF NOT EXISTS `ims_xcommunity_houselease` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `regionid` int(10) unsigned NOT NULL,
  `category` int(11) NOT NULL COMMENT '1出租，2求租，3出售，4求购',
  `way` varchar(20) NOT NULL COMMENT '出租方式',
  `model_room` int(11) NOT NULL,
  `model_hall` int(11) NOT NULL,
  `model_toilet` int(11) NOT NULL,
  `model_area` varchar(15) NOT NULL COMMENT '房屋面积',
  `floor_layer` int(11) NOT NULL,
  `floor_number` int(11) NOT NULL,
  `fitment` varchar(40) NOT NULL COMMENT '装修情况',
  `house` varchar(40) NOT NULL COMMENT '住宅类别',
  `allocation` varchar(500) NOT NULL COMMENT '房屋配置',
  `price_way` varchar(30) NOT NULL COMMENT '押金方式',
  `price` int(10) unsigned NOT NULL COMMENT '租金',
  `checktime` varchar(30) NOT NULL COMMENT '入住时间',
  `title` varchar(30) NOT NULL COMMENT '标题',
  `realname` varchar(30) NOT NULL COMMENT '姓名',
  `mobile` varchar(15) NOT NULL COMMENT '电话',
  `content` varchar(500) NOT NULL COMMENT '说明',
  `status` int(10) unsigned NOT NULL COMMENT '0未成交,1已成交',
  `createtime` int(10) unsigned NOT NULL,
  `images` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='房屋租赁表' AUTO_INCREMENT=5 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `src` varchar(255) DEFAULT NULL,
  `file` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='图片表' AUTO_INCREMENT=7 ;
CREATE TABLE IF NOT EXISTS  `ims_xcommunity_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) unsigned NOT NULL,
  `regionid` int(10) unsigned NOT NULL COMMENT '小区编号',
  `openid` varchar(50) NOT NULL,
  `memberid` int(11) NOT NULL,
  `realname` varchar(50) NOT NULL COMMENT '真实姓名',
  `mobile` varchar(15) NOT NULL COMMENT '手机号',
  `regionname` varchar(50) NOT NULL COMMENT '小区名称',
  `address` varchar(100) NOT NULL COMMENT '楼栋门牌',
  `remark` varchar(1000) NOT NULL COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `manage_status` tinyint(1) unsigned NOT NULL COMMENT '授权管理员',
  `type` tinyint(1) unsigned NOT NULL COMMENT '业主类型',
  PRIMARY KEY (`id`),
  KEY `idx_openid` (`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=289 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='注册用户';

CREATE TABLE IF NOT EXISTS `ims_xcommunity_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `pcate` int(10) NOT NULL,
  `title` varchar(30) NOT NULL COMMENT '菜单标题',
  `url` varchar(1000) NOT NULL COMMENT '菜单链接',
  `do` varchar(20) NOT NULL COMMENT '动作',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='后台菜单管理' AUTO_INCREMENT=165 ;
CREATE TABLE IF NOT EXISTS  `ims_xcommunity_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `enable` int(11) NOT NULL,
  `displayorder` int(10) NOT NULL,
  `pcate` int(10) NOT NULL,
  `title` varchar(30) NOT NULL COMMENT '菜单标题',
  `url` varchar(1000) NOT NULL COMMENT '菜单链接',
  `styleid` int(10) NOT NULL COMMENT '风格id',
  `status` int(1) NOT NULL COMMENT '状态',
  `icon` varchar(50) NOT NULL COMMENT '系统图标',
  `bgcolor` varchar(20) NOT NULL COMMENT '背景颜色',
  `regionid` varchar(2000) NOT NULL COMMENT '小区id',
  `do` varchar(20) NOT NULL COMMENT '动作',
  `thumb` varchar(500) NOT NULL COMMENT '菜单图片',
  `isshow` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1194 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_navextension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `navurl` varchar(100) NOT NULL,
  `icon` varchar(20) NOT NULL,
  `content` text NOT NULL COMMENT '说明',
  `cate` int(1) NOT NULL,
  `bgcolor` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_notice_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `regionid` int(10) unsigned NOT NULL,
  `template_id_1` varchar(100) NOT NULL,
  `template_id_2` varchar(100) NOT NULL,
  `template_id_3` varchar(100) NOT NULL,
  `template_id_4` varchar(100) NOT NULL,
  `template_id_5` varchar(100) NOT NULL,
  `template_id_6` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='公告模板消息ID设置';

CREATE TABLE IF NOT EXISTS `ims_xcommunity_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `ordersn` varchar(20) NOT NULL COMMENT '订单编号',
  `price` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1取消状态，0普通状态，1为已付款，2为已发货，3已成功',
  `paytype` tinyint(1) unsigned NOT NULL COMMENT '1为余额，2为在线，3为到付',
  `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号',
  `goodstype` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `remark` varchar(1000) NOT NULL DEFAULT '',
  `goodsprice` decimal(10,2) DEFAULT '0.00' COMMENT '商品总价',
  `createtime` int(10) unsigned NOT NULL,
  `regionid` int(11) unsigned NOT NULL COMMENT '当前小区ID',
  `gid` int(11) unsigned NOT NULL COMMENT '优惠券id',
  `type` varchar(10) NOT NULL COMMENT '订单来源类型',
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `pid` int(11) unsigned NOT NULL COMMENT '物业费id',
  `aid` int(11) unsigned NOT NULL COMMENT '活动预约id',
  `couponsn` varchar(20) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `enable` tinyint(4) DEFAULT NULL,
  `usetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单表' AUTO_INCREMENT=66 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `goodsid` int(10) unsigned NOT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `total` int(10) unsigned NOT NULL DEFAULT '1',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单商品附表' AUTO_INCREMENT=50 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_pay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `pay` varchar(200) NOT NULL,
  `type` int(1) NOT NULL COMMENT '1超市2物业费3商家',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='支付方式配置表' AUTO_INCREMENT=32 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) NOT NULL COMMENT '公众号ID',
  `pid` int(11) NOT NULL,
  `account` varchar(50) NOT NULL COMMENT '支付宝账号',
  `partner` varchar(50) NOT NULL COMMENT '合作者身份',
  `secret` varchar(50) NOT NULL COMMENT '校验密钥',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='支付设置';

CREATE TABLE IF NOT EXISTS `ims_xcommunity_phone` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(11) unsigned NOT NULL COMMENT '公众号',
  `phone` varchar(50) NOT NULL COMMENT '号码',
  `content` varchar(50) NOT NULL COMMENT '描述',
  `regionid` varchar(5000) NOT NULL COMMENT '小区编号',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `thumb` varchar(100) NOT NULL COMMENT '图片',
  `displayorder` int(10) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='常用电话';

DROP TABLE IF EXISTS  `ims_xcommunity_print`;
CREATE TABLE `ims_xcommunity_print` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `print_status` int(10) unsigned NOT NULL,
  `print_type` int(10) unsigned NOT NULL COMMENT '1报修,2投诉，3超市订单，0全部打印',
  `member_code` varchar(80) NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `deviceNo` varchar(50) NOT NULL,
  `regionid` varchar(2000) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='打印机表';

CREATE TABLE IF NOT EXISTS `ims_xcommunity_property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `topPicture` varchar(255) NOT NULL COMMENT '照片',
  `mcommunity` varchar(255) NOT NULL COMMENT '微社区URL',
  `content` varchar(2000) NOT NULL COMMENT '内容',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `regionid` mediumtext NOT NULL COMMENT '小区id',
  `telphone` varchar(13) NOT NULL COMMENT '物业电话',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='物业介绍';

CREATE TABLE IF NOT EXISTS `ims_xcommunity_rank` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `type` int(1) unsigned NOT NULL COMMENT '1商家,2超市',
  `content` varchar(2000) NOT NULL COMMENT '评价内容',
  `dpid` int(11) DEFAULT '0' COMMENT '商家店铺id',
  `openid` varchar(100) NOT NULL COMMENT '粉丝openid',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='评价表';
CREATE TABLE IF NOT EXISTS  `ims_xcommunity_propertyfree` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `mobile` varchar(13) NOT NULL,
  `username` varchar(30) NOT NULL,
  `homenumber` varchar(15) NOT NULL,
  `profree` varchar(10) NOT NULL,
  `tcf` varchar(10) NOT NULL,
  `gtsf` varchar(10) NOT NULL,
  `gtdf` varchar(10) NOT NULL,
  `protimeid` int(10) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `status` int(1) unsigned NOT NULL COMMENT '1代表缴费，0代表未缴费',
  `paytype` tinyint(1) unsigned NOT NULL COMMENT '1为余额，2为在线，3为到付',
  `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=676 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_xcommunity_protime` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `protime` varchar(30) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `companyid` int(10) unsigned NOT NULL,
  `regionid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_xcommunity_reading_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `aid` int(10) unsigned NOT NULL COMMENT '公告id',
  `openid` varchar(50) NOT NULL,
  `status` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='公告阅读记录表' AUTO_INCREMENT=44 ;
CREATE TABLE IF NOT EXISTS  `ims_xcommunity_region` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `linkmen` varchar(50) NOT NULL COMMENT '联系人',
  `linkway` varchar(50) NOT NULL COMMENT '联系电话',
  `lng` varchar(10) NOT NULL,
  `lat` varchar(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `pid` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `thumb` varchar(100) NOT NULL,
  `qq` int(11) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `dist` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='添加小区信息';

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `reportid` int(10) unsigned NOT NULL COMMENT '报告ID',
  `isreply` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否是回复',
  `content` varchar(5000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_xcommunity_report` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL COMMENT '用户身份',
  `weid` int(11) unsigned NOT NULL COMMENT '公众号ID',
  `regionid` int(10) unsigned NOT NULL COMMENT '小区编号',
  `type` tinyint(1) NOT NULL COMMENT '1为报修，2为投诉',
  `category` varchar(50) NOT NULL DEFAULT '' COMMENT '类目',
  `content` varchar(255) NOT NULL COMMENT '投诉内容',
  `requirement` varchar(1000) NOT NULL,
  `createtime` int(11) unsigned NOT NULL COMMENT '投诉日期',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态,1已处理,2未处理,3受理中',
  `newmsg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有新信息',
  `rank` tinyint(3) unsigned NOT NULL COMMENT '评级 1满意，2一般，3不满意',
  `comment` varchar(1000) NOT NULL,
  `resolve` varchar(1000) NOT NULL COMMENT '处理结果',
  `resolver` varchar(50) NOT NULL COMMENT '处理人',
  `resolvetime` int(10) NOT NULL COMMENT '处理时间',
  `address` varchar(80) NOT NULL COMMENT '地址',
  `images` text,
  `print_sta` int(3) NOT NULL COMMENT '打印状态',
  PRIMARY KEY (`id`),
  KEY `idx_weid_regionid` (`weid`,`regionid`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS  `ims_xcommunity_res` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `openid` varchar(100) NOT NULL,
  `truename` varchar(30) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `num` int(2) unsigned NOT NULL COMMENT '报名人数',
  `aid` int(11) unsigned NOT NULL COMMENT '活动id',
  `rid` int(11) unsigned NOT NULL,
  `sex` varchar(6) NOT NULL,
  `createtime` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_xcommunity_room` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL COMMENT '公众号ID',
  `mobile` varchar(13) NOT NULL,
  `room` varchar(50) NOT NULL,
  `code` varchar(10) NOT NULL,
  `regionid` int(10) unsigned NOT NULL,
  `pid` INT(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='房号表' AUTO_INCREMENT=10 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_search` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `sname` varchar(30) NOT NULL,
  `surl` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `regionid` varchar(2000) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_service` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `regionid` int(10) unsigned NOT NULL,
  `servicecategory` int(10) unsigned NOT NULL COMMENT '生活服务大分类 1家政服务，2租赁服务',
  `servicesmallcategory` varchar(50) NOT NULL COMMENT '生活服务小分类',
  `requirement` varchar(255) NOT NULL COMMENT '精准要求,如保洁需要填写 平米大小',
  `remark` varchar(500) NOT NULL COMMENT '备注',
  `contacttype` int(10) unsigned NOT NULL COMMENT '联系类型:1.随时联系;2.白天联系;3:晚上联系;4:自定义',
  `contactdesc` varchar(255) NOT NULL COMMENT '联系描述',
  `status` int(10) unsigned NOT NULL COMMENT '状态',
  `createtime` int(10) unsigned NOT NULL,
  `images` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_xcommunity_servicecategory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned DEFAULT NULL,
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `description` varchar(50) NOT NULL COMMENT '分类描述',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_xcommunity_set` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `code_status` int(10) unsigned NOT NULL COMMENT '验证码开启',
  `range` int(10) unsigned NOT NULL COMMENT 'lbs范围',
  `room_status` int(11) DEFAULT NULL,
  `room_enable` int(11) DEFAULT NULL,
  `h_status` int(10) DEFAULT NULL,
  `s_status` int(10) DEFAULT NULL,
  `c_status` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='小区设置' AUTO_INCREMENT=3 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_shopping_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `realname` varchar(20) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `area` varchar(30) NOT NULL,
  `address` varchar(300) NOT NULL,
  `isdefault` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `regionid` int(11) unsigned NOT NULL COMMENT '当前小区ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `goodsid` int(11) NOT NULL,
  `goodstype` tinyint(1) NOT NULL DEFAULT '1',
  `from_user` varchar(50) NOT NULL,
  `total` int(10) unsigned NOT NULL,
  `optionid` int(10) DEFAULT '0',
  `marketprice` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `idx_openid` (`from_user`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `thumb` varchar(255) NOT NULL COMMENT '分类图片',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `isrecommand` int(10) DEFAULT '0',
  `description` varchar(500) NOT NULL COMMENT '分类介绍',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `regionid` varchar(1000) NOT NULL COMMENT '小区ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='超市商品分类';

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_dispatch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `dispatchname` varchar(50) DEFAULT '',
  `dispatchtype` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `firstprice` decimal(10,2) DEFAULT '0.00',
  `secondprice` decimal(10,2) DEFAULT '0.00',
  `firstweight` int(11) DEFAULT '0',
  `secondweight` int(11) DEFAULT '0',
  `express` int(11) DEFAULT '0',
  `description` text,
  `regionid` varchar(1000) NOT NULL COMMENT '小区ID',
  `enable` int(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`weid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_express` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `express_name` varchar(50) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `express_price` varchar(10) DEFAULT '',
  `express_area` varchar(100) DEFAULT '',
  `express_url` varchar(255) DEFAULT '',
  `regionid` varchar(1000) NOT NULL COMMENT '小区ID',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`weid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1为维权，2为告擎',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0未解决，1用户同意，2用户拒绝',
  `feedbackid` varchar(30) NOT NULL COMMENT '投诉单号',
  `transid` varchar(30) NOT NULL COMMENT '订单号',
  `reason` varchar(1000) NOT NULL COMMENT '理由',
  `solution` varchar(1000) NOT NULL COMMENT '期待解决方案',
  `remark` varchar(1000) NOT NULL COMMENT '备注',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_weid` (`weid`),
  KEY `idx_feedbackid` (`feedbackid`),
  KEY `idx_createtime` (`createtime`),
  KEY `idx_transid` (`transid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `pcate` int(10) unsigned NOT NULL DEFAULT '0',
  `ccate` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1为实体，2为虚拟',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `unit` varchar(5) NOT NULL DEFAULT '',
  `description` varchar(1000) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `goodssn` varchar(50) NOT NULL DEFAULT '',
  `productsn` varchar(50) NOT NULL DEFAULT '',
  `marketprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `productprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `costprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `originalprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `total` int(10) NOT NULL DEFAULT '0',
  `totalcnf` int(11) DEFAULT '0' COMMENT '0 拍下减库存 1 付款减库存 2 永久不减',
  `sales` int(10) unsigned NOT NULL DEFAULT '0',
  `spec` varchar(5000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `weight` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credit` int(11) DEFAULT '0',
  `maxbuy` int(11) DEFAULT '0',
  `hasoption` int(11) DEFAULT '0',
  `dispatch` int(11) DEFAULT '0',
  `thumb_url` text,
  `isnew` int(11) DEFAULT '0',
  `ishot` int(11) DEFAULT '0',
  `isdiscount` int(11) DEFAULT '0',
  `isrecommand` int(11) DEFAULT '0',
  `istime` int(11) DEFAULT '0',
  `timestart` int(11) DEFAULT '0',
  `timeend` int(11) DEFAULT '0',
  `viewcount` int(11) DEFAULT '0',
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `regionid` varchar(1000) NOT NULL COMMENT '小区ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_goods_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `thumb` varchar(60) DEFAULT '',
  `productprice` decimal(10,2) DEFAULT '0.00',
  `marketprice` decimal(10,2) DEFAULT '0.00',
  `costprice` decimal(10,2) DEFAULT '0.00',
  `stock` int(11) DEFAULT '0',
  `weight` decimal(10,2) DEFAULT '0.00',
  `displayorder` int(11) DEFAULT '0',
  `specs` text,
  PRIMARY KEY (`id`),
  KEY `indx_goodsid` (`goodsid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_goods_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `value` text,
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_goodsid` (`goodsid`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `ordersn` varchar(20) NOT NULL,
  `price` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1取消状态，0普通状态，1为已付款，2为已发货，3为成功',
  `sendtype` tinyint(1) unsigned NOT NULL COMMENT '1为快递，2为自提',
  `paytype` tinyint(1) unsigned NOT NULL COMMENT '1为余额，2为在线，3为到付',
  `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号',
  `goodstype` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `remark` varchar(1000) NOT NULL DEFAULT '',
  `addressid` int(10) unsigned NOT NULL,
  `expresscom` varchar(30) NOT NULL DEFAULT '',
  `expresssn` varchar(50) NOT NULL DEFAULT '',
  `express` varchar(200) NOT NULL DEFAULT '',
  `goodsprice` decimal(10,2) DEFAULT '0.00',
  `dispatchprice` decimal(10,2) DEFAULT '0.00',
  `dispatch` int(10) DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL,
  `regionid` int(11) unsigned NOT NULL COMMENT '当前小区ID',
  `gid` int(11) unsigned NOT NULL COMMENT '优惠券id',
  `type` varchar(10) NOT NULL COMMENT '订单来源类型',
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `pid` int(11) unsigned NOT NULL COMMENT '物业费id',
  `aid` int(11) unsigned NOT NULL COMMENT '活动预约id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `goodsid` int(10) unsigned NOT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `total` int(10) unsigned NOT NULL DEFAULT '1',
  `optionid` int(10) DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL,
  `optionname` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_xcommunity_shopping_print` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `print_status` int(10) unsigned NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `deviceNo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='超市打印机表';

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goodsid` int(11) NOT NULL,
  `productsn` varchar(50) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `marketprice` decimal(10,0) unsigned NOT NULL,
  `productprice` decimal(10,0) unsigned NOT NULL,
  `total` int(11) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `spec` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_goodsid` (`goodsid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_set` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `notice` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `regionid` varchar(1000) NOT NULL COMMENT '小区ID',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`weid`),
  KEY `indx_enabled` (`enabled`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_spec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `displaytype` tinyint(3) unsigned NOT NULL,
  `content` text NOT NULL,
  `goodsid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE IF NOT EXISTS `ims_xcommunity_sjdp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `uid` int(11) NOT NULL,
  `regionid` varchar(5000) NOT NULL,
  `sjname` varchar(30) NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `contactname` varchar(30) NOT NULL,
  `mobile` varchar(12) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `qq` int(11) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `dist` varchar(50) NOT NULL,
  `address` varchar(150) NOT NULL,
  `shopdesc` varchar(500) NOT NULL,
  `businnesstime` varchar(20) NOT NULL,
  `businessurl` varchar(100) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `lat` varchar(20) NOT NULL,
  `lng` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_sjdp_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `sid` int(11) NOT NULL COMMENT '店铺id',
  `goodsname` varchar(80) NOT NULL,
  `thumb` varchar(80) NOT NULL,
  `marketprice` varchar(80) NOT NULL,
  `originalprice` varchar(80) NOT NULL,
  `total` int(11) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商家商品' AUTO_INCREMENT=3 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_sjdp_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `orderid` int(10) unsigned NOT NULL COMMENT '订单ID',
  `gid` int(10) unsigned NOT NULL COMMENT '优惠券id',
  `openid` varchar(30) NOT NULL,
  `couponsn` varchar(60) NOT NULL,
  `type` int(1) NOT NULL COMMENT '是否被使用 1未使用，2已使用',
  `createtime` int(11) NOT NULL COMMENT '领取时间',
  `usetime` int(11) NOT NULL COMMENT '使用时间',
  `uid` int(10) unsigned NOT NULL COMMENT '商家id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='优惠劵' AUTO_INCREMENT=3 ;
CREATE TABLE IF NOT EXISTS  `ims_xcommunity_shopping_spec_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) DEFAULT '0',
  `specid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `show` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indx_weid` (`weid`),
  KEY `indx_specid` (`specid`),
  KEY `indx_show` (`show`),
  KEY `indx_displayorder` (`displayorder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weid` int(11) NOT NULL,
  `displayorder` int(10) NOT NULL,
  `title` varchar(30) NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `url` varchar(100) NOT NULL,
  `regionid` varchar(2000) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1小区首页,2超市',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='幻灯管理' AUTO_INCREMENT=3 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `styleid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='模板设置' AUTO_INCREMENT=7 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `companyid` int(11) NOT NULL,
  `regionid` int(11) NOT NULL,
  `menus` varchar(500) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `commission` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=3 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_verifycode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `verifycode` varchar(6) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `total` tinyint(3) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_wechat_notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `regionid` varchar(5000) NOT NULL,
  `fansopenid` varchar(30) NOT NULL,
  `repair_status` int(1) NOT NULL,
  `report_status` int(1) NOT NULL,
  `shopping_status` int(1) NOT NULL,
  `type` int(1) NOT NULL COMMENT '1模板消息通知,2短信通知，3全部通知',
  `uid` int(11) DEFAULT NULL,
  `homemaking_status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='通知设置' AUTO_INCREMENT=3 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_wechat_smsid` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `shopping_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `sms_account` varchar(80) NOT NULL,
  `verify` int(1) NOT NULL,
  `businesscode` int(1) NOT NULL,
  `verifycode` int(1) NOT NULL,
  `report_type` int(1) NOT NULL,
  `shopping_status` int(1) NOT NULL,
  `property_status` int(1) NOT NULL,
  `reportid` int(11) NOT NULL,
  `resgisterid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='短信设置' AUTO_INCREMENT=4 ;
CREATE TABLE IF NOT EXISTS `ims_xcommunity_wechat_tplid` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `property_tplid` varchar(80) NOT NULL,
  `water_tplid` varchar(80) NOT NULL,
  `gas_tplid` varchar(80) NOT NULL,
  `power_tplid` varchar(80) NOT NULL,
  `guard_tplid` varchar(80) NOT NULL,
  `lift_tplid` varchar(80) NOT NULL,
  `car_tplid` varchar(80) NOT NULL,
  `shopping_tplid` varchar(80) NOT NULL,
  `repair_tplid` varchar(80) NOT NULL,
  `report_tplid` varchar(80) NOT NULL,
  `other_tplid` varchar(80) NOT NULL,
  `good_tplid` varchar(80) NOT NULL,
  `grab_wc_tplid` varchar(80) NOT NULL,
  `report_wc_tplid` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='模板设置' AUTO_INCREMENT=3 ;
CREATE TABLE  IF NOT EXISTS `ims_xfcommunity_images` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `src` varchar(255) DEFAULT NULL,
    `file` longtext,
    `type` int(11) NOT NULL COMMENT '报修1，租赁2',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `realname` varchar(20) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `area` varchar(30) NOT NULL,
  `address` varchar(300) NOT NULL,
  `isdefault` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `regionid` int(11) unsigned NOT NULL COMMENT '当前小区ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `goodsid` int(11) NOT NULL,
  `goodstype` tinyint(1) NOT NULL DEFAULT '1',
  `from_user` varchar(50) NOT NULL,
  `total` int(10) unsigned NOT NULL,
  `optionid` int(10) DEFAULT '0',
  `marketprice` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `thumb` varchar(255) NOT NULL COMMENT '分类图片',
  `parentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID,0为第一级',
  `description` varchar(500) NOT NULL COMMENT '分类介绍',
  `displayorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启',
  `regionid` int(11) NOT NULL COMMENT '小区id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='超市商品分类' AUTO_INCREMENT=12 ;


CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_dispatch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `dispatchname` varchar(50) DEFAULT '',
  `dispatchtype` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  `firstprice` decimal(10,2) DEFAULT '0.00',
  `secondprice` decimal(10,2) DEFAULT '0.00',
  `firstweight` int(11) DEFAULT '0',
  `secondweight` int(11) DEFAULT '0',
  `express` int(11) DEFAULT '0',
  `description` text,
  `regionid` varchar(1000) NOT NULL COMMENT '小区ID',
  `uid` int(11) NOT NULL,
  `enable` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='超市配送表' AUTO_INCREMENT=6 ;


CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_express` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `express_name` varchar(50) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `express_price` varchar(10) DEFAULT '',
  `express_area` varchar(100) DEFAULT '',
  `express_url` varchar(255) DEFAULT '',
  `regionid` varchar(1000) NOT NULL COMMENT '小区ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='超市物流表' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `openid` varchar(50) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1为维权，2为告擎',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态0未解决，1用户同意，2用户拒绝',
  `feedbackid` varchar(30) NOT NULL COMMENT '投诉单号',
  `transid` varchar(30) NOT NULL COMMENT '订单号',
  `reason` varchar(1000) NOT NULL COMMENT '理由',
  `solution` varchar(1000) NOT NULL COMMENT '期待解决方案',
  `remark` varchar(1000) NOT NULL COMMENT '备注',
  `createtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='超市维权表' AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `pcate` int(10) unsigned NOT NULL DEFAULT '0',
  `ccate` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1为实体，2为虚拟',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `unit` varchar(5) NOT NULL DEFAULT '',
  `description` varchar(1000) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `goodssn` varchar(50) NOT NULL DEFAULT '',
  `productsn` varchar(50) NOT NULL DEFAULT '',
  `marketprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `productprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `costprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `originalprice` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '原价',
  `total` int(10) NOT NULL DEFAULT '0',
  `totalcnf` int(11) DEFAULT '0' COMMENT '0 拍下减库存 1 付款减库存 2 永久不减',
  `sales` int(10) unsigned NOT NULL DEFAULT '0',
  `spec` varchar(5000) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `weight` decimal(10,2) NOT NULL DEFAULT '0.00',
  `credit` int(11) DEFAULT '0',
  `maxbuy` int(11) DEFAULT '0',
  `hasoption` int(11) DEFAULT '0',
  `dispatch` int(11) DEFAULT '0',
  `thumb_url` text,
  `isnew` int(11) DEFAULT '0',
  `ishot` int(11) DEFAULT '0',
  `isdiscount` int(11) DEFAULT '0',
  `isrecommand` int(11) DEFAULT '0',
  `istime` int(11) DEFAULT '0',
  `timestart` int(11) DEFAULT '0',
  `timeend` int(11) DEFAULT '0',
  `viewcount` int(11) DEFAULT '0',
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `regionid` varchar(1000) NOT NULL COMMENT '小区ID',
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_goods_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `thumb` varchar(60) DEFAULT '',
  `productprice` decimal(10,2) DEFAULT '0.00',
  `marketprice` decimal(10,2) DEFAULT '0.00',
  `costprice` decimal(10,2) DEFAULT '0.00',
  `stock` int(11) DEFAULT '0',
  `weight` decimal(10,2) DEFAULT '0.00',
  `displayorder` int(11) DEFAULT '0',
  `specs` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_goods_param` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `value` text,
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `ordersn` varchar(20) NOT NULL,
  `price` varchar(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '-1取消状态，0普通状态，1为已付款，2为已发货，3为成功',
  `sendtype` tinyint(1) unsigned NOT NULL COMMENT '1为快递，2为自提',
  `paytype` tinyint(1) unsigned NOT NULL COMMENT '1为余额，2为在线，3为到付',
  `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号',
  `goodstype` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `remark` varchar(1000) NOT NULL DEFAULT '',
  `addressid` int(10) unsigned NOT NULL,
  `expresscom` varchar(30) NOT NULL DEFAULT '',
  `expresssn` varchar(50) NOT NULL DEFAULT '',
  `express` varchar(200) NOT NULL DEFAULT '',
  `goodsprice` decimal(10,2) DEFAULT '0.00',
  `dispatchprice` decimal(10,2) DEFAULT '0.00',
  `dispatch` int(10) DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL,
  `regionid` int(11) unsigned NOT NULL COMMENT '当前小区ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `goodsid` int(10) unsigned NOT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `total` int(10) unsigned NOT NULL DEFAULT '1',
  `optionid` int(10) DEFAULT '0',
  `createtime` int(10) unsigned NOT NULL,
  `optionname` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;


CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_print` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `print_status` int(10) unsigned NOT NULL,
  `api_key` varchar(50) NOT NULL,
  `deviceNo` varchar(50) NOT NULL,
  `regionid` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='便利店打印机表' AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goodsid` int(11) NOT NULL,
  `productsn` varchar(50) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `marketprice` decimal(10,0) unsigned NOT NULL,
  `productprice` decimal(10,0) unsigned NOT NULL,
  `total` int(11) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `spec` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_set` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weid` int(10) unsigned NOT NULL,
  `notice` varchar(100) NOT NULL,
  `regionid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `advname` varchar(50) DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `displayorder` int(11) DEFAULT '0',
  `enabled` int(11) DEFAULT '0',
  `regionid` varchar(1000) NOT NULL COMMENT '小区ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='超市幻灯表' AUTO_INCREMENT=6 ;


CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_spec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `displaytype` tinyint(3) unsigned NOT NULL,
  `content` text NOT NULL,
  `goodsid` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_store_spec_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) DEFAULT '0',
  `specid` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT '',
  `thumb` varchar(255) DEFAULT '',
  `show` int(11) DEFAULT '0',
  `displayorder` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `uid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `ims_xiaofeng_users_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `title` varchar(50) NOT NULL,
  `maxaccount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

CREATE TABLE IF NOT EXISTS `ims_xcommunity_users_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uniacid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属帐号',
  `title` varchar(50) NOT NULL,
  `maxaccount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
";
pdo_query($sql);

if(!pdo_fieldexists('xcommunity_carpool', 'status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_carpool')." ADD `status` int( 1 ) NOT NULL ;");
}

if(!pdo_fieldexists('xcommunity_announcement', 'enable')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')." ADD   `enable` tinyint(1) NOT NULL COMMENT '模板类型' ;");
}
if(!pdo_fieldexists('xcommunity_announcement', 'datetime')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')." ADD     `datetime` varchar(100)  NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_announcement', 'location')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')." ADD     `location` varchar(100) NOT NULL COMMENT '通知范围';");
}
if(!pdo_fieldexists('xcommunity_announcement', 'reason')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')." ADD     `reason` varchar(100) NOT NULL COMMENT '通知范围';");
}
if(!pdo_fieldexists('xcommunity_announcement', 'remark')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')." ADD     `remark` varchar(100) NOT NULL COMMENT '通知备注';");
}

if(pdo_fieldexists('xcommunity_sjdp', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_sjdp')." change   `regionid`  `regionid`   varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_sjdp', 'businessurl')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_sjdp')." ADD   `businessurl` varchar(100)  NOT NULL;");
}

if(pdo_fieldexists('xcommunity_propertyfree', 'homenumber')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  change   `homenumber`  `homenumber` varchar(15)  NOT NULL;");
}
if(pdo_fieldexists('xcommunity_propertyfree', 'profree')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  change   `profree` `profree` varchar(10)  NOT NULL;");
}
if(pdo_fieldexists('xcommunity_propertyfree', 'tcf')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  change    `tcf`  `tcf` varchar(10)  NOT NULL;");
}
if(pdo_fieldexists('xcommunity_propertyfree', 'gtsf')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  change   `gtsf`  `gtsf` varchar(10)  NOT NULL;");
}
if(pdo_fieldexists('xcommunity_propertyfree', 'gtdf')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  change    `gtdf`  `gtdf` varchar(10)  NOT NULL;");
}

if(!pdo_fieldexists('xcommunity_propertyfree', 'status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  add     `status` int(1) unsigned NOT NULL COMMENT '1代表缴费，0代表未缴费';");
}
if(!pdo_fieldexists('xcommunity_propertyfree', 'paytype')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  add     `paytype` tinyint(1) unsigned NOT NULL COMMENT '1为余额，2为在线，3为到付';");
}
if(!pdo_fieldexists('xcommunity_propertyfree', 'transid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  add     `transid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信支付单号';");
}

if(!pdo_fieldexists('xcommunity_slide', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_slide')."  add     `regionid` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_slide', 'type')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_slide')."  add   `type` int(11) NOT NULL COMMENT '1小区首页,2超市';");
}
if(!pdo_fieldexists('xcommunity_property', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_property')."  add    `regionid` varchar(50000) NOT NULL COMMENT '小区id';");
}
if(!pdo_fieldexists('xcommunity_property', 'telphone')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_property')."  add    `telphone` varchar(13) NOT NULL COMMENT '物业电话';");
}

if(!pdo_fieldexists('xcommunity_announcement', 'pid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')."  add    `pid` int(10) unsigned NOT NULL COMMENT '物业ID';");
}
if(!pdo_fieldexists('xcommunity_announcement', 'tit')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')."  add      `tit` varchar(255) NOT NULL COMMENT '标题';");
}
if(!pdo_fieldexists('xcommunity_announcement', 'time')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')."  add    `time` varchar(100) NOT NULL COMMENT '门禁卡失效时间';");
}
if(!pdo_fieldexists('xcommunity_announcement', 'scope')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')."  add      `scope` varchar(100) NOT NULL COMMENT '门禁卡失效范围';");
}
if(!pdo_fieldexists('xcommunity_announcement', 'method')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')."  add      `method` varchar(300) NOT NULL COMMENT '门禁卡重新激活办法';");
}
if(!pdo_fieldexists('xcommunity_member', 'type')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_member')."  add     `type` tinyint(1) unsigned NOT NULL COMMENT '业主类型';");
}
if(pdo_fieldexists('xcommunity_phone', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_phone')."  CHANGE    `regionid`  `regionid` varchar(5000) NOT NULL COMMENT '小区编号';");
}
if(!pdo_fieldexists('xcommunity_phone', 'content')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_phone')."  ADD    `content` varchar(50) NOT NULL COMMENT '描述';");
}
if(!pdo_fieldexists('xcommunity_phone', 'displayorder')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_phone')."  ADD    `displayorder` int(10) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_region', 'lng')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_region')."  ADD     `lng` varchar(10) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_region', 'lat')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_region')."  ADD      `lat` varchar(10) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_region', 'address')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_region')."  ADD    `address` varchar(50) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_region', 'pid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_region')."  ADD      `pid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_region', 'url')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_region')."  ADD     `url` varchar(100) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_activity', 'price')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_activity')."  ADD     `price` decimal(12,2) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_res', 'status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_res')."  ADD     `status` int(1) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_search', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_search')."  ADD     `regionid` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_business', 'balance')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_business')."  ADD      `balance` decimal(10,2)   NOT NULL COMMENT '商家余额';");
}
if(!pdo_fieldexists('xcommunity_business', 'commission')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_business')."  ADD      `commission` float NOT NULL COMMENT '分成，0-1之间';");
}
if(!pdo_fieldexists('xcommunity_business', 'alipay')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_business')."  ADD     `alipay` varchar(100) NOT NULL COMMENT '支付宝账户';");
}
if(pdo_fieldexists('xcommunity_sjdp', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_sjdp')."  CHANGE    `regionid`  `regionid`   varchar(5000) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_sjdp', 'lat')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_sjdp')."  ADD   `lat` varchar(20)  NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_sjdp', 'lng')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_sjdp')."  ADD     `lng` varchar(20) NOT NULL;");
}

if(!pdo_fieldexists('xcommunity_protime', 'companyid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_protime')."  ADD   `companyid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_protime', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_protime')."  ADD  `regionid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_nav', 'enable')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_nav')."  ADD   `enable` int(11) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_nav', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_nav')."  ADD    `regionid` varchar(2000) NOT NULL COMMENT '小区id';");
}
if(!pdo_fieldexists('xcommunity_shopping_dispatch', 'enable')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_shopping_dispatch')."  ADD      `enable` int(1) DEFAULT '0';");
}
if(!pdo_fieldexists('xcommunity_shopping_order', 'gid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_shopping_order')."  ADD      `gid` int(11) unsigned NOT NULL COMMENT '优惠券id';");
}
if(!pdo_fieldexists('xcommunity_shopping_order', 'type')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_shopping_order')."  ADD       `type` varchar(10) NOT NULL COMMENT '订单来源类型';");
}
if(!pdo_fieldexists('xcommunity_shopping_order', 'uid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_shopping_order')."  ADD       `uid` int(11) unsigned NOT NULL COMMENT '用户id';");
}
if(!pdo_fieldexists('xcommunity_shopping_order', 'pid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_shopping_order')."  ADD        `pid` int(11) unsigned NOT NULL COMMENT '物业费id';");
}
if(!pdo_fieldexists('xcommunity_shopping_order', 'aid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_shopping_order')."  ADD         `aid` int(11) unsigned NOT NULL COMMENT '活动预约id';");
}
if(!pdo_fieldexists('xcommunity_wechat_notice', 'shopping_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_notice')."  ADD      `shopping_status` int(1) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_carpool', 'gotime')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_carpool')."  ADD     `gotime` varchar(10) NOT NULL COMMENT '出发时间';");
}
if(!pdo_fieldexists('xcommunity_carpool', 'backtime')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_carpool')."  ADD    `backtime` varchar(10) NOT NULL COMMENT '返回时间';");
}
if(!pdo_fieldexists('xcommunity_carpool', 'thumb')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_carpool')."  ADD      `thumb` varchar(2000) NOT NULL COMMENT '图片';");
}
if(!pdo_fieldexists('xcommunity_carpool', 'type')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_carpool')."  ADD      `type` int(11) NOT NULL COMMENT '类型1司机，2乘客';");
}
if(!pdo_fieldexists('xcommunity_carpool', 'black')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_carpool')."  ADD      `black` int(1) NOT NULL COMMENT '1设置黑名单';");
}
if(!pdo_fieldexists('xcommunity_fled', 'black')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_fled')."  ADD    `black` int(1) NOT NULL COMMENT '1设置黑名单';");
}
if(!pdo_fieldexists('xcommunity_nav', 'do')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_nav')."  ADD    `do` varchar(20) NOT NULL COMMENT '动作';");
}
if(!pdo_fieldexists('xcommunity_nav', 'thumb')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_nav')."  ADD    `thumb` varchar(500) NOT NULL COMMENT '菜单图片';");
}
if(!pdo_fieldexists('xcommunity_nav', 'isshow')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_nav')."  ADD     `isshow` int(1) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_phone', 'thumb')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_phone')."  ADD   `thumb` varchar(100) NOT NULL COMMENT '图片';");
}
if(pdo_fieldexists('xcommunity_print', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_print')."  CHANGE    `regionid` `regionid` varchar(2000) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_region', 'thumb')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_region')."  ADD   `thumb` varchar(100) NOT NULL COMMENT '图片';");
}
if(!pdo_fieldexists('xcommunity_report', 'address')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_report')."  ADD    `address` varchar(80) NOT NULL COMMENT '地址';");
}
if(!pdo_fieldexists('xcommunity_res', 'aid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_res')."  ADD    `aid` int(11) unsigned NOT NULL COMMENT '活动id';");
}
if(!pdo_fieldexists('xcommunity_wechat_smsid', 'verify')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')."  ADD     `verify` int(1) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_smsid', 'businesscode')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')."  ADD     `businesscode` int(1) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_smsid', 'verifycode')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')."  ADD     `verifycode` int(1) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_smsid', 'report_type')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')."  ADD     `report_type` int(1) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_smsid', 'shopping_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')."  ADD    `shopping_status` int(1) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_smsid', 'property_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')."  ADD     `property_status` int(1) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_smsid', 'reportid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')."  ADD     `reportid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_smsid', 'resgisterid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')."  ADD      `resgisterid` int(11) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_member', 'memberid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_member')."  add    `memberid` int(11) NOT NULL;");
}

if(!pdo_fieldexists('xcommunity_wechat_notice', 'type')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_notice')."  add     `type` int(1) NOT NULL COMMENT '1模板消息通知,2短信通知，3全部通知';");
}
if(!pdo_fieldexists('xcommunity_wechat_notice', 'uid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_notice')."  add   `uid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_notice', 'homemaking_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_notice')."  add    `homemaking_status` int(1) DEFAULT NULL;");
}
if(pdo_fieldexists('xcommunity_wechat_notice', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_notice')."  CHANGE  `regionid`  `regionid` varchar(5000) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_users', 'balance')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_users')."  ADD    `balance` decimal(10,2) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_users', 'commission')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_users')."  ADD    `commission` float DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_users', 'menus')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_users')."  ADD   `menus` varchar(500) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_set', 'h_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_set')."  ADD    `h_status` int(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_set', 's_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_set')."  ADD    `s_status` int(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_set', 'c_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_set')."  ADD    `c_status` int(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_search', 'uid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_search')."  ADD  `uid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_region', 'qq')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_region')."  ADD  `qq` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_region', 'province')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_region')."  ADD  `province` varchar(50) DEFAULT NULL;");
} 
if(!pdo_fieldexists('xcommunity_region', 'city')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_region')."  ADD `city` varchar(50) DEFAULT NULL;");
} 
if(!pdo_fieldexists('xcommunity_region', 'dist')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_region')."  ADD  `dist` varchar(50) DEFAULT NULL;");
} 
if(!pdo_fieldexists('xcommunity_print', 'uid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_print')."  ADD   `uid` int(11) DEFAULT NULL;");
} 
if(!pdo_fieldexists('xcommunity_phone', 'uid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_phone')."  ADD   `uid` int(11) DEFAULT NULL;");
} 
if(!pdo_fieldexists('xcommunity_order', 'couponsn')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_order')."  ADD   `couponsn` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_order', 'num')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_order')."  ADD   `num` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_order', 'enable')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_order')."  ADD    `enable` tinyint(4) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_order', 'usetime')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_order')."  ADD    `usetime` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_goods', 'description')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_goods')."  ADD  `description` text;");
}
if(!pdo_fieldexists('xcommunity_goods', 'dpid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_goods')."  ADD  `dpid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_goods', 'sold')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_goods')."  ADD   `sold` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_goods', 'type')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_goods')."  ADD  `type` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_goods', 'uid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_goods')."  ADD   `uid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_goods', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_goods')."  ADD   `regionid` mediumtext;");
}
if(!pdo_fieldexists('xcommunity_goods', 'businesstime')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_goods')."  ADD     `businesstime` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_goods', 'parent')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_goods')."  ADD   `parent` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_goods', 'child')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_goods')."  ADD   `child` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_category', 'price')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_category')."  ADD   `price` decimal(12,2) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_category', 'gtime')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_category')."  ADD   `gtime` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_announcement', 'uid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')."  ADD   `uid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_activity', 'uid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_activity')."  ADD   `uid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_dp', 'businesstime')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_dp')."  ADD   `businesstime` varchar(50) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_dp', 'parent')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_dp')."  ADD    `parent` varchar(20) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_dp', 'child')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_dp')."  ADD   `child` varchar(20) DEFAULT NULL;");
}
if(pdo_fieldexists('xcommunity_announcement', 'datetime')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')."  CHANGE  `datetime` `datetime` int(10) NOT NULL;");
}
if(pdo_fieldexists('xcommunity_announcement', 'reason')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_announcement')."  CHANGE    `reason` `reason` varchar(1000) NOT NULL;");
}

if(pdo_fieldexists('xcommunity_business', 'balance')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_business')."  CHANGE  `balance` `balance` varchar(100) DEFAULT NULL;");
}
if(pdo_fieldexists('xcommunity_business', 'commission')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_business')."  CHANGE   `commission` `commission` float DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_category', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_category')."  ADD   `regionid` int(11) DEFAULT NULL;");
}
if(pdo_fieldexists('xcommunity_cost_list', 'otherfee')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_cost_list')."  CHANGE  `otherfee`  `otherfee` varchar(1000) NOT NULL;");
}

if(!pdo_fieldexists('xcommunity_cost_list', 'fee')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_cost_list')." ADD `fee` varchar(500) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_cost_list', 'area')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_cost_list')." ADD `area` varchar(50) DEFAULT NULL;");
}

if(!pdo_fieldexists('xcommunity_goods', 'starttime')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_goods')." ADD  `starttime` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_goods', 'endtime')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_goods')." ADD  `endtime` int(11) DEFAULT NULL;");
}

if(!pdo_fieldexists('xcommunity_member', 'memberid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_member')." ADD   `memberid` int(10) NOT NULL;");
}

if(pdo_fieldexists('xcommunity_property', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_property')."  CHANGE  `regionid`  `regionid` varchar(100) NOT NULL DEFAULT '';");
}
if(pdo_fieldexists('xcommunity_property', 'telphone')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_property')."  CHANGE `telphone` `telphone` varchar(13) DEFAULT NULL;");
}

if(pdo_fieldexists('xcommunity_propertyfree', 'profree')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  CHANGE  `profree` `profree` int(4) NOT NULL;");
}
if(pdo_fieldexists('xcommunity_propertyfree', 'tcf')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  CHANGE  `tcf` `tcf` int(4) NOT NULL;");
}
if(pdo_fieldexists('xcommunity_propertyfree', 'gtsf')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  CHANGE  `gtsf` `gtsf` int(4) NOT NULL;");
}
if(pdo_fieldexists('xcommunity_propertyfree', 'gtdf')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')." CHANGE  `gtdf` `gtdf` int(4) NOT NULL;");
}
if(pdo_fieldexists('xcommunity_propertyfree', 'status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  CHANGE  `status`   `status` int(1) NOT NULL;");
}
if(pdo_fieldexists('xcommunity_propertyfree', 'paytype')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')." CHANGE  `paytype` `paytype` tinyint(1) NOT NULL;");
}
if(pdo_fieldexists('xcommunity_propertyfree', 'transid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_propertyfree')."  CHANGE  `transid` `transid` varchar(30) NOT NULL;");
}
if(pdo_fieldexists('xcommunity_res', 'status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_res')."  CHANGE `status` `status` int(11) DEFAULT NULL;");
}

if(!pdo_fieldexists('xcommunity_set', 'r_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_set')." ADD  `r_status` int(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_set', 'r_enable')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_set')." ADD  `r_enable` int(10) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_set', 'tel')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_set')." ADD  `tel` varchar(30) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_set', 'region_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_set')." ADD  `region_status` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_set', 'business_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_set')." ADD  `business_status` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_users', 'good_tplid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_users')." ADD  `good_tplid` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_users', 'groupid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_users')." ADD    `groupid` int(11) DEFAULT NULL;");
}
if(pdo_fieldexists('xcommunity_wechat_notice', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_notice')."  CHANGE  `regionid`  `regionid` int(10) unsigned NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_tplid', 'homemaking_tplid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_tplid')."  ADD  `homemaking_tplid` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_tplid', 'report_wc_tplid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_tplid')."  ADD  `report_wc_tplid` varchar(80) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_menu', 'method')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_menu')."  ADD   `method` varchar(300) DEFAULT NULL;");
}
if(pdo_fieldexists('xcommunity_activity', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_activity')."  CHANGE  `regionid` `regionid` varchar(500) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_nav', 'view')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_nav')."  ADD    `view` int(1) DEFAULT '1';");
}
if(!pdo_fieldexists('xcommunity_nav', 'add')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_nav')."  ADD    `add` int(1) DEFAULT '1';");
}
if(pdo_fieldexists('xcommunity_print', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_print')."  CHANGE  `regionid`  `regionid` int(11) unsigned NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_region', 'rid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_region')."  ADD    `rid` int(11) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_room', 'realname')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_room')."  ADD  `realname` varchar(30) NOT NULL;");
}
if(!pdo_fieldexists('xcommunity_room', 'status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_room')."  ADD   `status` int(1) unsigned NOT NULL COMMENT '1注册 2未注册';");
}
if(!pdo_fieldexists('xcommunity_room', 'pid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_room')."  ADD `pid` int(10) unsigned NOT NULL COMMENT '物业id';");
}
if(!pdo_fieldexists('xcommunity_set', 'visitor_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_set')."  ADD   `visitor_status` int(1) DEFAULT NULL;");
}
if(pdo_fieldexists('xcommunity_sjdp', 'regionid')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_sjdp')."  CHANGE  `regionid`   `regionid` varchar(20000) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_notice', 'change_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_notice')."  ADD   `change_status` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_smsid', 'room_status')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')."  ADD    `room_status` int(1) DEFAULT NULL;");
}
if(!pdo_fieldexists('xcommunity_wechat_smsid', 'room_id')) {
  pdo_query("ALTER TABLE ".tablename('xcommunity_wechat_smsid')."  ADD    `room_id` int(11) DEFAULT NULL;");
}

if(!pdo_fieldexists('xcommunity_search', 'uid')) {
	pdo_query("ALTER TABLE ".tablename('xcommunity_search')." ADD `uid` int(10) ;");
}
if(!pdo_fieldexists('xcommunity_dp', 'rid')) {
	pdo_query("ALTER TABLE ".tablename('xcommunity_dp')." ADD `rid` int(11) ;");
}
		/**V6.5.4修复字段**/
		if(!pdo_fieldexists('xcommunity_set', 'shop_credit')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_set')." ADD `shop_credit` float ;");
		}
		if(!pdo_fieldexists('xcommunity_set', 'business_credit')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_set')." ADD `business_credit` float ;");
		}
		if(!pdo_fieldexists('xcommunity_set', 'cost_credit')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_set')." ADD `cost_credit` float;");
		}
		if(pdo_fieldexists('xcommunity_order', 'price')) {
		  pdo_query("ALTER TABLE ".tablename('xcommunity_order')." modify column `price` decimal(10,2) ;");
		}