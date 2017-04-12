<?php
if (!pdo_fieldexists('dayu_form', 'isdel')) {
    pdo_query('ALTER TABLE ' . tablename('dayu_form') . " ADD    `isdel` tinyint(1) NOT NULL DEFAULT '0';");
}