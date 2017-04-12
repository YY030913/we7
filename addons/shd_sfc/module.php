<?php

defined('IN_IA') or exit('Access Denied');
class Shd_chatModule extends WeModule
{
    public $table_reply = 'shd_chat_reply';
    public function fieldsFormDisplay($rid = 0)
    {
        load()->model('mc');
        global $_W, $_GPC;
        load()->func('tpl');
        if ($rid == 0) {
            $reply  = array(
                'title' => '来吧来吧，一起嗨吧!',
                'description' => '聊天交友，把酒言欢',
                'tips' => '我们只需要灵魂上的沟通~',
                'remark' => '备注',
                'starttime' => time(),
                'endtime' => time() + 10 * 84400,
                'share_title' => '欢迎加入一起嗨聊天室',
                'share_content' => '聊天交友'
            );
            $prizes = array(
                'p1_type' => 'credit1'
            );
        } else {
            $reply  = pdo_fetch("SELECT * FROM " . tablename($this->table_reply) . " WHERE rid = :rid ORDER BY `id` DESC", array(
                ':rid' => $rid
            ));
            $prizes = iunserializer($reply['prizes']);
        }
        include $this->template('form');
    }
    public function fieldsFormValidate($rid = 0)
    {
        return '';
    }
    public function fieldsFormSubmit($rid)
    {
        global $_W, $_GPC;
        $insert = array(
            'rid' => $rid,
            'uniacid' => $_W['uniacid'],
            'title' => $_GPC['title'],
            'thumb' => $_GPC['thumb'],
            'description' => $_GPC['description'],
            'starttime' => strtotime($_GPC['time'][start]),
            'endtime' => strtotime($_GPC['time'][end]),
            'tips' => $_GPC['tips'],
            'remark' => $_GPC['remark'],
            'share_title' => $_GPC['share_title'],
            'share_url' => $_GPC['share_url'],
            'share_content' => $_GPC['share_content'],
            'createtime' => time()
        );
        if (empty($id)) {
            pdo_insert($this->table_reply, $insert);
        } else {
            unset($insert['createtime']);
            pdo_update($this->table_reply, $insert, array(
                'id' => $id
            ));
        }
    }
    public function ruleDeleted($rid)
    {
        $replies  = pdo_fetchall("SELECT id  FROM " . tablename($this->table_reply) . " WHERE rid = '$rid'");
        $deleteid = array();
        if (!empty($replies)) {
            foreach ($replies as $index => $row) {
                $deleteid[] = $row['id'];
            }
        }
        pdo_delete($this->table_reply, "id IN ('" . implode("','", $deleteid) . "')");
    }
    public function settingsDisplay($settings)
    {
        global $_W, $_GPC;
        if (checksubmit()) {
            $this->saveSettings($dat);
        }
        include $this->template('settings');
    }
}