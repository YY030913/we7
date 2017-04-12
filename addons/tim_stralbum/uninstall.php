<?php

$sql =<<<EOF
DROP TABLE IF EXISTS `ims_stralbum`;
DROP TABLE IF EXISTS `ims_stralbum_category`;
DROP TABLE IF EXISTS `ims_stralbum_photo`;
DROP TABLE IF EXISTS `ims_stralbum_reply`;
EOF;
pdo_run($sql);