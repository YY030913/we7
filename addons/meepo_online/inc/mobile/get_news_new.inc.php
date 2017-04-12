<?php
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
		$max = intval($_GPC['max']);
		$num =  pdo_fetchcolumn("SELECT	COUNT(*) FROM ".tablename($this->live_news_table)." WHERE weid=:weid AND listid=:listid",array(':weid'=>$weid,':listid'=>$listid));
		if(!$num){
			$data['num'] = 0;
		}else{	
			$data['num'] = $num;
		}
		$psize = $num-$max;
		if($psize > 0){
			$lists = pdo_fetchall("SELECT * FROM ".tablename($this->live_news_table)." WHERE weid=:weid AND listid=:listid  ORDER BY createtime ASC LIMIT ".$max.",{$psize}",array(':weid'=>$weid,':listid'=>$listid));
			
		}else{
			$lists = array();
		}	
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
						$comment_html .= '<div class="addFun">
						  <a class="comment" href="'.$this->createMobileUrl('news_reply',array('listid'=>$listid,'news_id'=>$news_row['id'])).'"><i class="iconfont news_icon">&#xe638;</i>&nbsp;&nbsp;&nbsp;评论(0)</a>
						  <a href="javascript:void(0);" class="share" onclick="news_zan('.$news_row['id'].')"><i class="iconfont news_icon">&#xe63f;</i>&nbsp;&nbsp;&nbsp;赞(<font id="zan_"'.$news_row['id'].'">0</font>)</a>
						</div>
					  </li>';
				}
		}
		$data['error'] = 0;
		$data['html'] = $comment_html;
		$data['zan'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->zan_table)." WHERE listid=:listid AND weid=:weid",array(':listid'=>$listid,':weid'=>$weid));
		$zan_nums = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_zan)." WHERE weid=:weid AND listid=:listid",array(':weid'=>$weid,':listid'=>$listid)));
		$data['zan'] = $data['zan'] + $zan_nums;
		$pl_nums = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid  AND status=:status",array(':weid'=>$weid,':listid'=>$listid,':status'=>'1')));
		$news_pl_nums = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_reply)." WHERE weid=:weid AND listid=:listid",array(':weid'=>$weid,':listid'=>$listid)));
		$data['allnum'] = $news_pl_nums + $pl_nums;
		$data['online_user'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->list_user_table)." WHERE listid=:listid AND weid=:weid",array(':listid'=>$listid,':weid'=>$weid));
		die(json_encode($data));
	}
}