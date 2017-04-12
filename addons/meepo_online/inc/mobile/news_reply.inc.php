<?php
include MODULE_ROOT.'/inc/mobile/__init.php';
$listid = intval($_GPC['listid']);
if(empty($listid)){
	message('直播不存在');
}
$title = pdo_fetchcolumn("SELECT `title` FROM ".tablename($this->list_table)." WHERE weid=:weid AND   id=:id",array(':weid'=>$weid,':id'=>$listid));
$news_id = intval($_GPC['news_id']);
if(empty($news_id)){
	message('图文id不存在');
}
$news_reply = pdo_fetchall("SELECT * FROM ".tablename($this->live_news_reply)." WHERE weid=:weid AND listid=:listid  AND newsid=:newsid ORDER BY createtime DESC LIMIT 0,10",array(':weid'=>$weid,':listid'=>$listid,':newsid'=>$news_id));
$reply_nums =  intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_reply)." WHERE weid=:weid AND listid=:listid  AND newsid=:newsid",array(':weid'=>$weid,':listid'=>$listid,':newsid'=>$news_id)));

include $this->template('news_reply');