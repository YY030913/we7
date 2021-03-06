<?php
/**
 * 种植乐园模块

 * @author 微赞
 */
defined('IN_IA') or exit('Access Denied');
 

class Stonefish_plantingModuleProcessor extends WeModuleProcessor {

    public function respond() {
        global $_W;
        $rid = $this->rule;
		$from_user = $this->message ['from'];
        $sql = "SELECT title,description,start_picurl,isshow,starttime,endtime,end_theme,end_instruction,end_picurl FROM " . tablename('stonefish_planting_reply') . " WHERE `rid`=:rid LIMIT 1";
        $row = pdo_fetch($sql, array(':rid' => $rid));

        if ($row == false) {
            return $this->respText("活动已取消...");
        }

        if ($row['isshow'] == 0) {
            return $this->respText("活动暂停，请稍后...");
        }

        if ($row['starttime'] > time()) {
            return $this->respText("活动未开始，请等待...");
        }

        $endtime = $row['endtime'];
        if ( $endtime < time()) {
            return $this->respNews(array(
                        'Title' => $row['end_theme'],
                        'Description' => $row['end_instruction'],
                        'PicUrl' => toimage($row['end_picurl']),
                        'Url' => $this->createMobileUrl('index', array('rid' => $rid,'from_user' => base64_encode(authcode($from_user, 'ENCODE')))),
            ));
        } else {
            return $this->respNews(array(
                        'Title' => $row['title'],
                        'Description' => $row['description'],
                        'PicUrl' => toimage($row['start_picurl']),
                        'Url' => $this->createMobileUrl('index', array('rid' => $rid,'from_user' => base64_encode(authcode($from_user, 'ENCODE')))),
            ));
        }
    }

}
