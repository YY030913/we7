<?php
if (!pdo_fieldexists('mon_jgg', 'prize_num_1')) {
    pdo_query("ALTER TABLE " . tablename('mon_jgg') . " ADD  `prize_num_1` int(10) NOT NULL default 0;");
}
if (!pdo_fieldexists('mon_jgg', 'prize_num_2')) {
    pdo_query("ALTER TABLE " . tablename('mon_jgg') . " ADD  `prize_num_2` int(10) NOT NULL default 0;");
}
if (!pdo_fieldexists('mon_jgg', 'prize_num_3')) {
    pdo_query("ALTER TABLE " . tablename('mon_jgg') . " ADD  `prize_num_3` int(10) NOT NULL default 0;");
}

if (!pdo_fieldexists('mon_jgg', 'prize_num_4')) {
    pdo_query("ALTER TABLE " . tablename('mon_jgg') . " ADD  `prize_num_4` int(10) NOT NULL default 0;");

}

if (!pdo_fieldexists('mon_jgg', 'prize_num_5')) {
    pdo_query("ALTER TABLE " . tablename('mon_jgg') . " ADD  `prize_num_5` int(10) NOT NULL default 0;");

}

if (!pdo_fieldexists('mon_jgg', 'prize_num_6')) {
    pdo_query("ALTER TABLE " . tablename('mon_jgg') . " ADD  `prize_num_6` int(10) NOT NULL default 0;");

}
if (!pdo_fieldexists('mon_jgg', 'prize_num_7')) {
    pdo_query("ALTER TABLE " . tablename('mon_jgg') . " ADD  `prize_num_7` int(10) NOT NULL default 0;");

}

if (!pdo_fieldexists('mon_jgg_user_award', 'level')) {
    pdo_query("ALTER TABLE " . tablename('mon_jgg_user_award') . "ADD  `level` int(3) default 0 ;");

}

if (!pdo_fieldexists('mon_jgg_user_record', 'level')) {
    pdo_query("ALTER TABLE " . tablename('mon_jgg_user_record') . "ADD   `level` int(3) default 0  ;");

}

if (!pdo_fieldexists('mon_jgg', 'day_award_count')) {
    pdo_query("ALTER TABLE " . tablename('mon_jgg') . "ADD     `day_award_count` int(10) DEFAULT '0';");
}
if (!pdo_fieldexists('mon_jgg', 'bg')) {
    pdo_query("ALTER TABLE " . tablename('mon_jgg') . "ADD     `bg` varchar(1000) DEFAULT NULL;");
}
if (!pdo_fieldexists('mon_jgg', 'bgcolor')) {
    pdo_query("ALTER TABLE " . tablename('mon_jgg') . "ADD     `bgcolor` varchar(40) DEFAULT NULL;");
}




