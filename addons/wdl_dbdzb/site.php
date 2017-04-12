<?php

defined('IN_IA') or exit('Access Denied');

class wdl_dbdzbModuleSite extends WeModuleSite {
    public function __construct() {
            global $_W, $_GPC;
            if (0 && empty($_W['openid'])) {
                    echo '请在微信下使用！';
                    exit;
            }            
    }
    /**
     * 第八代装逼神器大合集主页
     */
	public function doMobilePlay() {
	    global $_W, $_GPC;
 	    
	    include $this->template('index');
	}

}