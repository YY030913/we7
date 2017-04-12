<?php
defined('IN_IA') or exit('Access Denied');
class Shd_chatModuleProcessor extends WeModuleProcessor
{
    public $table_reply = 'shd_chat_reply';
    public function respond()
    {
        $content  = $this->message['content'];
        $rid      = $this->rule;
        $fromuser = $this->message['from'];
        if ($rid) {
            $reply = pdo_fetch("SELECT * FROM " . tablename($this->table_reply) . " WHERE rid = :rid", array(
                ':rid' => $rid
            ));
            if ($reply) {
                $news   = array();
                $news[] = array(
                    'title' => $reply['title'],
                    'description' => $reply['description'],
                    'picurl' => $reply['thumb'],
                    'url' => $this->createMobileUrl('index', array(
                        'id' => $reply['id']
                    ))
                );
                return $this->respNews($news);
            }
        }
        return null;
    }
}