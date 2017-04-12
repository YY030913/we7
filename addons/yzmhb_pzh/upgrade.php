<?php
/**
 */
$sql = "
CREATE TABLE IF NOT EXISTS `ims_pzh_excelinfo` (
  `uniacid` int(10) NOT NULL,
  `createtime` varchar(35) DEFAULT NULL,
  `username` varchar(35) DEFAULT NULL,
  `userphone` varchar(35) DEFAULT NULL,
  `idcard` varchar(35) DEFAULT NULL,
  `money` varchar(35) DEFAULT NULL,
  `openacounttime` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `receivetime` varchar(35) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
pdo_query($sql);
