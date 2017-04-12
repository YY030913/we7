<?php
defined('IN_IA') or exit('Access Denied');

if(!pdo_fieldexists('enjoy_circle_reply', 'subscribe')) {
	pdo_query("ALTER TABLE ".tablename('enjoy_circle_reply')." ADD   `subscribe` int(2) DEFAULT '0';");
}
