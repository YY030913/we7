<?php
/**
 * 财务中心模块定义
 *
 * @author Kim 模块开发QQ:800083075
 * @url http://www.goodziyuan.com/
 */
$sql =<<<EOF
DROP TABLE IF EXISTS `ims_users_credits_record`;
DROP TABLE IF EXISTS `ims_users_packages`;
DROP TABLE IF EXISTS `ims_uni_payorder`;
EOF;
//if(pdo_fieldexists('users', 'credit1')) {
//$sql .= <<<EOF
//ALTER TABLE `ims_users`
//        DROP COLUMN `credit1`;
//EOF;
//}
//if(pdo_fieldexists('users', 'credit2')) {
//$sql .= <<<EOF
//ALTER TABLE `ims_users`
//        DROP COLUMN `credit2`;
//EOF;
//}
pdo_run($sql);