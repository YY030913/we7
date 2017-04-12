<?php
/*
*/
if(!pdo_fieldexists('feng_wechat', 'win_mess')) {  
	pdo_query("ALTER TABLE ".tablename('feng_wechat')." ADD `win_mess` varchar(200) DEFAULT NULL;");
}
$sql = "
CREATE TABLE IF NOT EXISTS `ims_feng_rebate_changci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) NOT NULL,
  `goodsn` varchar(45) NOT NULL,
  `createtime` varchar(45) NOT NULL,
  `uniacid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `ims_feng_rebate_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gname` varchar(45) NOT NULL,
  `thumb` varchar(115) NOT NULL,
  `price` varchar(45) NOT NULL,
  `num` int(11) NOT NULL,
  `status` int(4) NOT NULL,
  `gdesc` varchar(1024) NOT NULL COMMENT '商品描述',
  `hours` int(11) NOT NULL COMMENT '限时抢购',
  `uniacid` int(11) NOT NULL,
  `createtime` varchar(45) NOT NULL,
  `goodsn` varchar(45) NOT NULL COMMENT '商品每日上架标识',
  `uptime` varchar(45) NOT NULL COMMENT '上架时间',
  `fanli` varchar(45) NOT NULL COMMENT '返利倍数',
  `fanli_num` varchar(45) NOT NULL COMMENT '返利倍数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `ims_feng_rebate_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(45) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `avatar` varchar(45) NOT NULL,
  `nickname` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `ims_feng_rebate_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordersn` varchar(45) NOT NULL,
  `goodsid` int(11) NOT NULL,
  `transid` int(11) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(45) NOT NULL,
  `pay_type` int(11) NOT NULL,
  `createtime` varchar(45) NOT NULL,
  `status` int(11) NOT NULL,
  `ptime` varchar(45) NOT NULL,
  `price` varchar(45) NOT NULL,
  `goodsn` varchar(45) NOT NULL COMMENT '商品上架标识',
  `get` int(11) NOT NULL COMMENT '0未中1已中奖',
  `recvname` varchar(45) NOT NULL COMMENT '收货人名',
  `mobile` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `zjm` varchar(45) NOT NULL COMMENT '中奖码',
  `express` varchar(45) NOT NULL COMMENT '快递公司',
  `expresssn` varchar(45) NOT NULL COMMENT '快递单号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `ims_feng_rebate_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(45) NOT NULL,
  `uniacid` int(11) NOT NULL,
  `createtime` varchar(45) NOT NULL,
  `goodsid` int(11) NOT NULL COMMENT '商品id',
  `yqm` varchar(45) NOT NULL COMMENT '邀请码',
  `cjm` varchar(11) NOT NULL COMMENT '抽奖码1',
  `goodsn` varchar(45) NOT NULL COMMENT '商品上架标识',
  `ordersn` varchar(45) NOT NULL,
  `cjmfromopenid` varchar(45) NOT NULL COMMENT '抽奖码来自的openid',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

pdo_query($sql);

?>