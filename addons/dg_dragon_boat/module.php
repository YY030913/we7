<?php

defined('IN_IA') or exit('Access Denied');
class Dg_dragon_boatModule extends WeModule
{
    public $tablename = 'longzhou_reply';
    public function fieldsFormDisplay($rid = 0)
    {
        global $_W;
        load()->func('tpl');
        if (!empty($rid)) {
            $reply   = pdo_fetch("SELECT * FROM " . tablename($this->tablename) . " WHERE rid = :rid ORDER BY `id` DESC", array(
                ':rid' => $rid
            ));
            $icolist = explode(",", $reply["jpicos"]);
        }
        if (!$reply) {
            $now   = time();
            $reply = array(
                "status" => "1",
                "subscribe" => "1",
                "start_time" => $now,
                "end_time" => strtotime(date("Y-m-d H:i", $now + 7 * 24 * 3600)),
                "iscaiji" => "1"
            );
        }
        include $this->template('boatsyscontrol');
    }
    public function fieldsFormValidate($rid = 0)
    {
    }
    public function fieldsFormSubmit($rid)
    {
        global $_GPC, $_W;
        load()->func('communication');
        $acid   = empty($_W['acid']) ? $_W['uniacid'] : $_W['acid'];
        $id     = intval($_GPC['reply_id']);
        $insert = array(
            'rid' => $rid,
            'iacid' => $acid,
            'uniacid' => $acid,
            'huodongname' => $_GPC['huodongname'],
            'huodongdesc' => $_GPC['huodongdesc'],
            'hdpicture' => $_GPC['hdpicture'],
            'status' => $_GPC['status'],
            'subscribe' => $_GPC['subscribe'],
            'sharetitle' => $_GPC['sharetitle'],
            'shareimg' => $_GPC['shareimg'],
            'sharecontent' => $_GPC['sharecontent'],
            'start_time' => strtotime($_GPC['datelimit']['start']),
            'end_time' => strtotime($_GPC['datelimit']['end']),
            'followdesc' => htmlspecialchars_decode($_GPC['followdesc']),
            'gamegzjp' => htmlspecialchars_decode($_GPC['gamegzjp']),
            'gamemusic' => $_GPC['gamemusic'],
            'qylogo' => $_GPC['qylogo'],
            'qyname' => $_GPC['qyname'],
            'qylink' => $_GPC['qylink'],
            'ggimg' => $_GPC['ggimg'],
            'gglink' => $_GPC['gglink'],
            'gametime' => $_GPC['gametime'],
            'iscaiji' => $_GPC['iscaiji']
        );
        if ($_GPC['subscribe'] == 0) {
            unset($insert["followpic"]);
            unset($insert["followdesc"]);
        }
        if (empty($id)) {
            pdo_insert($this->tablename, $insert);
        } else {
            pdo_update($this->tablename, $insert, array(
                'id' => $id
            ));
        }
    }
    public function ruleDeleted($rid)
    {
        pdo_delete('longzhou_reply', array(
            'rid' => $rid
        ));
    }
}
