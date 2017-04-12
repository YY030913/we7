<?php
//ini_set("display_errors", "On");
//error_reporting(E_ALL | E_STRICT);
global $_W,$_GPC;
$openid = $_W['openid'];
$weid = $_W['uniacid'];

$data = array();
if($_W['isajax']){
	$listid  = intval($_GPC['listid']);
	if(empty($listid)){
		die(json_encode(error(-1,'直播id错误')));
	}else{
		$pingluns = array();
		$pindex = max(2, intval($_GPC['page']));
		$update_time = intval($_GPC['update_time']);
		$condition = '';
		if($update_time >0 ){
				$condition .= " AND createtime < '{$update_time}'";
		}
		$psize = 5;
		$lists = pdo_fetchall("SELECT * FROM ".tablename($this->live_news_table)." WHERE weid=:weid AND listid=:listid $condition ORDER BY createtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':weid'=>$weid,':listid'=>$listid));
		$comment_html = '';
		if(is_array($lists) && !empty($lists)){
				$host = iunserializer(pdo_fetchcolumn("SELECT `settings` FROM ".tablename($this->listmenu_table)." WHERE weid=:weid AND listid=:listid AND isshow=:isshow AND type=:type",array(':weid'=>$weid,':listid'=>$listid,':isshow'=>'1',':type'=>'news')));
				foreach($lists as $news_row){
						$comment_html .= '<li class="item">
						<a class="headImg"><img src="'.tomedia($host['host_img']).'"></a>
						<div class="uInfo"><a class="nick"><font color=red>直播员</font>|'.$host['host_name'].'</a><div class="time">'.date("Y-m-d H:i:s",$news_row['createtime']).'</div></div>
						<div class="content">'.$this->emo($news_row['content']).'</div>';
						if($news_row['imgs']!='no_imgs'){
							$new_imgs = iunserializer($news_row['imgs']);
							$comment_html .= '<ul class="one extras j_p_gallery">'; 
							foreach($new_imgs as $rval){
								$comment_html .= '<li class="cell">     
								<a href="javascript:;"><img class="j_fullppt"   src="'.tomedia($rval).'"></a>
								</li>';
							}
							$comment_html .= '</ul>';
						}
						$pl_nums = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_reply)." WHERE weid=:weid AND listid=:listid AND newsid=:newsid",array(':weid'=>$weid,':listid'=>$listid,':newsid'=>$news_row['id']));
						$zan_nums = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_zan)." WHERE weid=:weid AND listid=:listid AND newsid=:newsid",array(':weid'=>$weid,':listid'=>$listid,':newsid'=>$news_row['id']));
						$comment_html .= '<div class="addFun">
						  <a class="comment" href="'.$this->createMobileUrl('news_reply',array('listid'=>$listid,'news_id'=>$news_row['id'])).'"><i class="iconfont news_icon">&#xe638;</i>&nbsp;&nbsp;&nbsp;评论('.$pl_nums.')</a>
						  <a href="javascript:void(0);" class="share" onclick="news_zan('.$news_row['id'].')"><i class="iconfont news_icon">&#xe63f;</i>&nbsp;&nbsp;&nbsp;赞(<font id="zan_"'.$news_row['id'].'">'.$zan_nums.'</font>)</a>
						</div>
					  </li>';
				}
				$data = error(0,$comment_html);
		}else{
			$data = error(1,'over');
		}
		die(json_encode($data));
	}
}