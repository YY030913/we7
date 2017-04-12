<?php
global $_W,$_GPC;
$openid = $_W['openid'];
$weid = $_W['uniacid'];
$data = array();
if($_W['isajax']){
	$pindex = max(1,intval($_GPC['page']));
	$psize = 10;
	$gift_id = $_GPC['gift_id'];
	$listid = intval($_GPC['listid']);
	if(empty($gift_id) || empty($listid)){
		die(json_encode(error('-1','参数错误！')));
	}
	
	$gift_records = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE listid=:listid AND weid=:weid  AND status=:status AND  type = :type ORDER BY createtime DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':listid'=>$listid,':weid'=>$weid,':status'=>'1',':type'=>$gift_id));
	$data['html'] = '';
	if(!empty($gift_records) && is_array($gift_records)){
			foreach($gift_records as $row){
				$data['html'] .= '<li>
        		<div class="Head">
        			  <img src="'.$row['avatar'].'" width="100%">
        		</div>
        		<div class="text">
        			<div class="his">
                    	<h1>'.$row['nickname'].'</h1>
          				<h2>'.date('Y-m-d H:i:s',$row['createtime']).'</h2>
        			</div>
                    
         			<div class="gift">
					<p>'.$row['money'].'<span>元</span></p>
					<p style="margin-top:4px;"><span>共</span>'.$row['num'].'<span>个</span></p>
					</div> 
        		</div>
      		</li>';
			}
			
	}
	die(json_encode(error('1',$data)));
}