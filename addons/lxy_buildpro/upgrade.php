<?php
/**
 */
if(!pdo_fieldexists('lxy_buildpro_album', 'subtitle')) {
   pdo_query("ALTER TABLE ".tablename('lxy_buildpro_album')." ADD `subtitle` varchar(255) DEFAULT NULL;");
}