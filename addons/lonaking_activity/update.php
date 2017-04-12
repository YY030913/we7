<?php
if(!pdo_tableexists('lonaking_activity_activity')){
    $tableName = tablename('lonaking_activity_activity');
    $sql = "
		CREATE TABLE ".$tableName." (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uniacid` int(11) DEFAULT NULL COMMENT '公众号id',
  `name` varchar(255) DEFAULT '' COMMENT '活动标题',
  `admin_name` varchar(255) DEFAULT '' COMMENT '发布人姓名',
  `admin_pic` varchar(255) DEFAULT '' COMMENT '发布人头像',
  `start` date DEFAULT NULL COMMENT '开始时间',
  `end` date DEFAULT NULL COMMENT '结束时间',
  `address` varchar(255) DEFAULT '' COMMENT '地址',
  `enroll_stop` date DEFAULT NULL COMMENT '报名截止时间',
  `enroll_count` int(11) DEFAULT '0' COMMENT '报名人数',
  `enroll_limit` int(11) DEFAULT '0' COMMENT '限制报名人数',
  `content` text COMMENT '活动介绍',
  `click` int(11) DEFAULT '0' COMMENT '点击次数',
  `share` int(11) DEFAULT '0' COMMENT '分享次数',
  `share_logo` varchar(255) DEFAULT '' COMMENT '分享logo',
  `share_title` varchar(100) DEFAULT '' COMMENT '分享标题',
  `share_description` varchar(255) DEFAULT '' COMMENT '分享内容',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
	";
    pdo_query($sql);
}

if(!pdo_tableexists('lonaking_activity_enroll')){
    $tableName = tablename('lonaking_activity_enroll');
    $sql = "
		CREATE TABLE ".$tableName." (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uniacid` int(11) DEFAULT NULL COMMENT '公众号id',
  `activity_id` int(11) DEFAULT NULL COMMENT '活动id',
  `order_num` varchar(255) DEFAULT '' COMMENT '订单号',
  `openid` varchar(255) DEFAULT '' COMMENT 'openid',
  `pic` varchar(255) DEFAULT '' COMMENT '头像',
  `uid` int(11) DEFAULT NULL COMMENT '无妄uid',
  `name` varchar(255) DEFAULT '' COMMENT '姓名',
  `mobile` varchar(11) DEFAULT '' COMMENT '电话',
  `status` tinyint(1) DEFAULT '0' COMMENT '0 报名 1已经核销 2取消报名',
  `verificate_time` timestamp NULL DEFAULT NULL COMMENT '验证时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
	";
    pdo_query($sql);
}
