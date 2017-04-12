<?php
if (!pdo_fieldexists('water_query2_info', 'ordercode')) {
    pdo_query("ALTER TABLE " . tablename('water_query2_info') . " ADD `ordercode` varchar(50) NOT NULL;");
}
