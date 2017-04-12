<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
if($_W['isajax']){
	$listid = intval($_GPC['listid']);
	if(empty($listid)){
		die(json_encode(error(-1,'直播不存在')));
	}
	$news_id = intval($_GPC['news_id']);
	if(empty($news_id)){
		die(json_encode(error(-1,'图文id不存在')));
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$news_reply = pdo_fetchall("SELECT * FROM ".tablename($this->live_news_reply)." WHERE weid=:weid AND listid=:listid  AND newsid=:newsid ORDER BY createtime DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':weid'=>$weid,':listid'=>$listid,':newsid'=>$news_id));
	$httm = '';
	if(!empty($news_reply) && is_array($news_reply)){
		 foreach($news_reply as $row){
				$html .= '<div class="cmnt_item">
					<img src="'.$row['avatar'].'" alt="" class="cmnt_pic">
					<div class="cmnt_info">
						<span class="cmnt_name cmnt_nick">'.$row['nickname'].'</span>
						
					</div>
					<div class="cmnt_floor"></div>
					<div class="cmnt_text">'.$this->emo($row['content']).'</div>
					<div class="cmnt_op">
						<div class="cmnt_num">
							<span class="cmnt_time">'. date("Y-m-d H:i:s",$row['createtime']).'</span>
						</div>
					</div>
				</div>';
		 }
		 die(json_encode(error(0,$html)));
	}else{
		die(json_encode(error(1,'over')));
	}
}