<?php

pdo_query("DROP TABLE IF EXISTS ".tablename('mon_qmshake').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_qmshake_prize').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_qmshake_user').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_qshake_record').";");
pdo_query("DROP TABLE IF EXISTS ".tablename('mon_qmshake_share').";");