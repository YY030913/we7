<?php
 if(!pdo_fieldexists('vote_reply', 'isshow')) {
	pdo_query("ALTER TABLE ".tablename('vote_reply')." ADD `isshow` int(11) NOT NULL DEFAULT '0';");
}
 if(pdo_fieldexists('vote_reply', 'status')) {
	pdo_query("ALTER TABLE ".tablename('vote_reply')." change   `status`  `status` tinyint(1) DEFAULT '1' COMMENT '状态';");
}