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
		$pindex = max(2, intval($_GPC['page']));
		$update_time = intval($_GPC['update_time']);
		$condition = '';
		if($update_time >0 ){
				$condition .= " AND createtime < '{$update_time}'";
		}
		$psize = 8;
		$lists = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid AND status=:status $condition ORDER BY createtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':weid'=>$weid,':listid'=>$listid,':status'=>'1'));
		$data['num'] =  pdo_fetchcolumn("SELECT	COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid  AND status=:status",array(':weid'=>$weid,':listid'=>$listid,':status'=>'1'));
		if(!$data['num']){
			$data['num'] = 0;
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
				$data['length'] = count($lists);
		}else{
				$data['length'] = 0;
		}
		$data['html'] = $comment_html;
		die(json_encode($data));
	}
}