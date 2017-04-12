<?php

defined('IN_IA') or exit('Access Denied');
class Dg_dragon_boatModuleProcessor extends WeModuleProcessor
{
    public function respond()
    {
        global $_W;
        $rid           = $this->rule;
        $longzhoureply = pdo_fetch("SELECT * FROM " . tablename('longzhou_reply') . " WHERE rid = :rid LIMIT 1", array(
            ':rid' => $rid
        ));
        $from          = $this->message['from'];
        if ($longzhoureply == false) {
            return $this->respText("抱歉,活动已取消...");
        }
        if ($longzhoureply['start_time'] > time()) {
            return $this->respText("抱歉,活动将于" . date('Y-m-d H:i:s', $row['start_time']) . "开始，请耐心等待...");
        }
        if ($longzhoureply['end_time'] < time()) {
            return $this->respText("抱歉,活动已经结束...");
        }
        if ($longzhoureply['status'] == 0) {
            return $this->respText("抱歉,活动已经被管理员暂停...");
        }
        return $this->respNews(array(
            'Title' => $longzhoureply["huodongname"],
            'Description' => $longzhoureply["huodongdesc"],
            'PicUrl' => $longzhoureply["hdpicture"],
            'Url' => $this->createMobileUrl('index', array(
                'rid' => $rid
            ))
        ));
    }
}
