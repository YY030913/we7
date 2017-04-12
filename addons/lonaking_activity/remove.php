<?php
/**
 * Created by PhpStorm.
 * User: leon
 * Date: 15/10/9
 * Time: 下午6:17
 */


if(!pdo_tableexists('lonaking_activity_activity')){
    $tableName = tablename('lonaking_activity_activity');
    $sql = "DROP TABLE IF EXISTS ".$tableName.";";
    pdo_query($sql);
}

if(!pdo_tableexists('lonaking_activity_enroll')){
    $tableName = tablename('lonaking_activity_enroll');
    $sql = "DROP TABLE IF EXISTS ".$tableName.";";
    pdo_query($sql);
}



