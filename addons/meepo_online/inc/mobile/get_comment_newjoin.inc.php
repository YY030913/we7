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
		$num =  pdo_fetchcolumn("SELECT	COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid  AND status=:status ",array(':weid'=>$weid,':listid'=>$listid,':status'=>'1'));
		if(!$num){
			$data['num'] = 0;
		}else{	
			$data['num'] = $num;
		}
		$psize = $num-$max;
		if($psize > 0){
			$lists = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid  AND status=:status ORDER BY createtime ASC LIMIT ".$max.",{$psize}",array(':weid'=>$weid,':listid'=>$listid,':status'=>'1'));
			
		}else{
			$lists = array();
		}
		$data['errno'] = '1';
		$comment_html = '';
		if(is_array($lists) && !empty($lists)){
				
				foreach($lists as $row){
						if($row['type']=='redpack'){
							$content='<span style="color: red">送出 <img class="gift_img" style="width: 20px;height: 20px;vertical-align: middle;" src="../addons/meepo_online/template/mobile/images/redpack.png"> '.$row['money'].'元红包</span>';
						}elseif($row['type']=='0'){
							$content=$this->emo($row['content']);
						}else{
							$gift_img = tomedia(pdo_fetchcolumn("SELECT `img` FROM ".tablename($this->gift_table)." WHERE id=:id AND listid=:listid AND weid=:weid",array(':id'=>intval($row['type']),':listid'=>$listid,':weid'=>$weid)));
							$content='<span style="color: red">送出 <img class="gift_img" style="width: 20px;height: 20px;vertical-align: middle;" src="'.$gift_img.'"> '.$row['content'].'、数量'.$row['num'].'</span>';						
						}	
						
					
						$comment_html .= 
						'<li class="comment clearfix"><img src="'.$row['avatar'].'" class="cmt-ava">
							<p class="cmt-info">
							<span class="cmt-user">'.$row['nickname'].'</span>
							<span class="cmt-time">'.date("Y-m-d H:i:s",$row['createtime']).'</span>
							</p>
							<div class="cmt-content">'.$content.'</div>
						</li>';
				}
				$data['html'] = $comment_html;
		}else{
				$data['html'] = '';
		}
		$data['zan'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->zan_table)." WHERE listid=:listid AND weid=:weid",array(':listid'=>$listid,':weid'=>$weid));
		$news_zan_nums = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_zan)." WHERE weid=:weid AND listid=:listid",array(':weid'=>$weid,':listid'=>$listid)));
		$data['zan'] = $data['zan'] + $news_zan_nums;
		$news_pl_nums = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->live_news_reply)." WHERE weid=:weid AND listid=:listid",array(':weid'=>$weid,':listid'=>$listid)));
		$data['allnum'] = $data['num'] + $news_pl_nums;
		$data['online_user'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->list_user_table)." WHERE listid=:listid AND weid=:weid",array(':listid'=>$listid,':weid'=>$weid));
		die(json_encode($data));
	}
}