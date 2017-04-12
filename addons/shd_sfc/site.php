<?php

defined('IN_IA') or exit('Access Denied');
class Shd_chatModuleSite extends WeModuleSite
{
    public $table_reply = 'shd_chat_reply';
    public $table_records = 'shd_chat_records';
    public $table_fans = 'shd_chat_fans';
    public function doWebClearmsg()
    {
        pdo_delete($this->table_records);
        message('清空成功！', '', 'success');
    }
    public function doMobileIndex()
    {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        load()->model('mc');
        $id         = intval($_GPC['id']);
        $reply      = pdo_fetch("SELECT * FROM " . tablename($this->table_reply) . " WHERE id = :id", array(
            ':id' => $id
        ));
        $share_from = base64_decode(urldecode($_GPC['share_from']));
        $share_from = isset($_GPC['share_from']) ? $share_from : $_W['openid'];
        $msg_list   = pdo_fetchall('select content from ' . tablename($this->table_records) . ' where reply_id=:id order by chat_time desc limit 6', array(
            ':id' => $id
        ));
        $top_msg    = pdo_fetch('select * from ' . tablename($this->table_records) . ' order by chat_time desc limit 1');
        if (!empty($reply)) {
            if (empty($_W['fans']['from_user'])) {
                message('亲，请先关注我们公众号哦~', '', error);
            }
            include $this->template('index');
        } else {
            exit('参数错误');
        }
    }
    public function doMobileAddMsg()
    {
        global $_W, $_GPC;
        $msg         = $_GPC['msg_txt'];
        $from_user   = $_W['fans']['from_user'];
        $replyid     = intval($_GPC['id']);
        $insert_data = array(
            'fans_name' => $from_user,
            'reply_id' => $replyid,
            'chat_time' => time(),
            'content' => $msg
        );
        pdo_insert($this->table_records, $insert_data);
    }
    public function doMobileMsglist()
    {
        global $_W, $_GPC;
        $replyid  = $_GPC['replyid'];
        $msg_json = pdo_fetchall('select content from ' . tablename($this->table_records) . ' order by chat_time desc limit 6');
        echo json_encode($msg_json);
        exit;
    }
    public function doMobileShareData()
    {
        global $_W, $_GPC;
        if (empty($_SERVER["HTTP_X_REQUESTED_WITH"]) || strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) != "xmlhttprequest") {
            exit('非法访问');
        }
        $id   = intval($_GPC['id']);
        $data = array(
            'uinacid' => $_W['uniacid'],
            'reply_id' => $id,
            'share_from' => $_GPC['from'],
            'share_time' => time()
        );
        pdo_insert($this->table_share, $data);
        echo json_encode($data);
    }
}