<?php
defined('IN_IA') or exit('Access Denied');
class wdl_dbdzbModuleReceiver extends WeModuleReceiver
{
    public function receive()
    {
        $type = $this->message['type'];
    }
}