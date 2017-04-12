<?php
pdo_query("
CREATE TABLE IF NOT EXISTS `ims_lwx_addwish` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `weid` int(10) NOT NULL COMMENT '公众号id',
  `openid` varchar(100) DEFAULT NULL COMMENT '当前粉丝openid',
  `content` varchar(500) NOT NULL COMMENT '祝福语',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `ims_lwx_shareset` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(50) NOT NULL COMMENT '分享标题',
  `thumb` varchar(100) NOT NULL COMMENT '分享图片',
  `desc` varchar(100) DEFAULT NULL COMMENT '分享描述',
  `okalert` varchar(20) NOT NULL DEFAULT '分享成功' COMMENT '成功分享提示语',
  `chalealert` varchar(20) NOT NULL DEFAULT '取消分享' COMMENT '取消分享提示语',
  `weid` int(10) DEFAULT NULL COMMENT '公众号id',
  `iffollow` int(2) DEFAULT '1' COMMENT '是否强制关注 1不需要 2需要',
  `followurl` varchar(120) DEFAULT NULL COMMENT '关注链接',
  `authinfo` varchar(50) DEFAULT NULL COMMENT '版权信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
");
if (pdo_tableexists('lwx_addwish')) {
    if (!pdo_fieldexists('lwx_addwish', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_addwish') . " ADD `id` int(10) unsigned NOT NULL auto_increment  COMMENT '主键';");
    }
}
if (pdo_tableexists('lwx_addwish')) {
    if (!pdo_fieldexists('lwx_addwish', 'weid')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_addwish') . " ADD `weid` int(10) NOT NULL   COMMENT '公众号id';");
    }
}
if (pdo_tableexists('lwx_addwish')) {
    if (!pdo_fieldexists('lwx_addwish', 'openid')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_addwish') . " ADD `openid` varchar(100)    COMMENT '当前粉丝openid';");
    }
}
if (pdo_tableexists('lwx_addwish')) {
    if (!pdo_fieldexists('lwx_addwish', 'content')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_addwish') . " ADD `content` varchar(500) NOT NULL   COMMENT '祝福语';");
    }
}
if (pdo_tableexists('lwx_shareset')) {
    if (!pdo_fieldexists('lwx_shareset', 'id')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_shareset') . " ADD `id` int(10) unsigned NOT NULL auto_increment  COMMENT '主键';");
    }
}
if (pdo_tableexists('lwx_shareset')) {
    if (!pdo_fieldexists('lwx_shareset', 'title')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_shareset') . " ADD `title` varchar(50) NOT NULL   COMMENT '分享标题';");
    }
}
if (pdo_tableexists('lwx_shareset')) {
    if (!pdo_fieldexists('lwx_shareset', 'thumb')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_shareset') . " ADD `thumb` varchar(100) NOT NULL   COMMENT '分享图片';");
    }
}
if (pdo_tableexists('lwx_shareset')) {
    if (!pdo_fieldexists('lwx_shareset', 'desc')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_shareset') . " ADD `desc` varchar(100)    COMMENT '分享描述';");
    }
}
if (pdo_tableexists('lwx_shareset')) {
    if (!pdo_fieldexists('lwx_shareset', 'okalert')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_shareset') . " ADD `okalert` varchar(20) NOT NULL  DEFAULT 分享成功 COMMENT '成功分享提示语';");
    }
}
if (pdo_tableexists('lwx_shareset')) {
    if (!pdo_fieldexists('lwx_shareset', 'chalealert')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_shareset') . " ADD `chalealert` varchar(20) NOT NULL  DEFAULT 取消分享 COMMENT '取消分享提示语';");
    }
}
if (pdo_tableexists('lwx_shareset')) {
    if (!pdo_fieldexists('lwx_shareset', 'weid')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_shareset') . " ADD `weid` int(10)    COMMENT '公众号id';");
    }
}
if (pdo_tableexists('lwx_shareset')) {
    if (!pdo_fieldexists('lwx_shareset', 'iffollow')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_shareset') . " ADD `iffollow` int(2)   DEFAULT 1 COMMENT '是否强制关注 1不需要 2需要';");
    }
}
if (pdo_tableexists('lwx_shareset')) {
    if (!pdo_fieldexists('lwx_shareset', 'followurl')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_shareset') . " ADD `followurl` varchar(120)    COMMENT '关注链接';");
    }
}
if (pdo_tableexists('lwx_shareset')) {
    if (!pdo_fieldexists('lwx_shareset', 'authinfo')) {
        pdo_query('ALTER TABLE ' . tablename('lwx_shareset') . " ADD `authinfo` varchar(50)    COMMENT '版权信息';");
    }
}