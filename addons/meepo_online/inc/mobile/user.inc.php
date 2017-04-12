<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
checkauth();
$credit1 = intval($_W['member']['credit1']);
$live_nums = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid",array(':openid'=>$openid,':weid'=>$weid));
$gift_nums = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND status=:status AND type!=:type1 AND type!=:type2",array(':openid'=>$openid,':weid'=>$weid,':weid'=>$weid,':status'=>'1',':type1'=>'0',':type2'=>'redpack'));
$dashang_nums = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND status=:status AND type=:type",array(':openid'=>$openid,':weid'=>$weid,':status'=>'1',':type'=>'redpack'));
include $this->template('user');