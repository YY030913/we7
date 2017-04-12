<?php
global $_W,$_GPC;
$weid = $_W['uniacid'];
$op = empty($_GPC['op'])? 'list':$_GPC['op'];
$listid = intval($_GPC['listid']);
if(empty($listid)){
	message('直播id不存在',$this->createWebUrl('live_manage'),'error');
}
$live = pdo_fetch("SELECT * FROM ".tablename($this->list_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
if(empty($live)){
	message('直播不存在',$this->createWebUrl('live_manage'),'error');
}
$op = empty($_GPC['op'])? 'list':$_GPC['op'];
if($op=='list'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$weid = $_W['uniacid'];
	$condition = '';
	if(!empty($_GPC['nickname'])){
		$nickname = $_GPC['nickname'];
		$condition .= " AND nickname LIKE '%{$_GPC['nickname']}%'";
	}
	$ffans = pdo_fetchall("SELECT * FROM ".tablename($this->list_user_table)." WHERE weid=:weid  AND listid=:listid $condition ORDER BY createtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':weid'=>$weid,':listid'=>$listid));
	$fans = array();
	if(is_array($ffans) && !empty($ffans)){
			foreach($ffans as $row){
				if(!empty($row['father_id'])){
					$row['f_nickname'] = pdo_fetchcolumn("SELECT `nickname` FROM ".tablename($this->list_user_table)." WHERE weid=:weid  AND id=:id",array(":weid"=>$weid,':id'=>$row['father_id']));
				}
				if(!empty($row['father_id'])){
					$row['f_avatar'] = pdo_fetchcolumn("SELECT `avatar` FROM ".tablename($this->list_user_table)." WHERE weid=:weid  AND id=:id",array(":weid"=>$weid,':id'=>$row['father_id']));
				}
				$row['say_nums'] = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid  AND listid=:listid AND openid=:openid AND type=:type AND status=:status",array(":weid"=>$weid,':listid'=>$listid,':openid'=>$row['openid'],':type'=>'0',':status'=>'1')));
				$row['dashang_times'] = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid  AND listid=:listid AND openid=:openid AND type=:type AND status=:status",array(":weid"=>$weid,':listid'=>$listid,':openid'=>$row['openid'],':type'=>'redpack',':status'=>'1')));
				$row['dashang_money'] = pdo_fetchcolumn("SELECT SUM(money) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid  AND listid=:listid AND openid=:openid AND type=:type AND status=:status",array(":weid"=>$weid,':listid'=>$listid,':openid'=>$row['openid'],':type'=>'redpack',':status'=>'1'));
				$row['gift_times'] = intval(pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid  AND listid=:listid AND openid=:openid AND type!=:type1  AND type!=:type2 AND status=:status",array(":weid"=>$weid,':listid'=>$listid,':openid'=>$row['openid'],':type1'=>'redpack',':type2'=>'0',':status'=>'1')));
				$row['gift_money'] = pdo_fetchcolumn("SELECT SUM(money) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid  AND listid=:listid AND openid=:openid AND type!=:type1  AND type!=:type2 AND status=:status",array(":weid"=>$weid,':listid'=>$listid,':openid'=>$row['openid'],':type1'=>'redpack',':type2'=>'0',':status'=>'1'));
				
				$fans[] = $row;
			}
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->list_user_table) . " WHERE weid=:weid		AND listid=:listid $condition", array(':weid'=>$weid,':listid'=>$listid));
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='cansay'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('粉丝不存在、或是已经被删除');
	}else{
			$cansay = intval($_GPC['cansay']);
			if($cansay==0){
				$cansay = 1;
			}else{
				$cansay = 0;
			}
			pdo_update($this->list_user_table,array('cansay'=>$cansay),array('listid'=>$listid,'weid'=>$weid,'id'=>$id));
			message('操作成功',referer(),'success');
	}
}elseif($op=='del'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		message('粉丝不存在、或是已经被删除');
	}else{
			$fans_openid  = pdo_fetchcolumn("SELECT	`openid` FROM ".tablename($this->list_user_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
			$fans_pls  = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid AND openid=:openid AND status=:status",array(':weid'=>$weid,':listid'=>$listid,':openid'=>$fans_openid,':status'=>'1'));
			pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun - '{$fans_pls}' WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
			pdo_delete($this->pinglun_table,array('listid'=>$listid,'weid'=>$weid,'openid'=>$fans_openid));
			$fans_zans  = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->zan_table)." WHERE weid=:weid AND listid=:listid AND openid=:openid",array(':weid'=>$weid,':listid'=>$listid,':openid'=>$fans_openid));
			pdo_query("UPDATE ".tablename($this->list_table)." SET zan = zan - '{$fans_zans}' WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
			pdo_delete($this->zan_table,array('listid'=>$listid,'weid'=>$weid,'openid'=>$fans_openid));
			pdo_delete($this->share_table,array('listid'=>$listid,'weid'=>$weid,'openid'=>$fans_openid));
			pdo_delete($this->list_user_table,array('listid'=>$listid,'weid'=>$weid,'id'=>$id));
			pdo_delete($this->shake_record_table,array('listid'=>$listid,'openid'=>$fans_openid,'weid'=>$weid));
				pdo_delete($this->share_table,array('listid'=>$listid,'openid'=>$fans_openid,'weid'=>$weid));
			message('删除成功',referer(),'success');
	}
}elseif($op=='ajax'){
	$id = intval($_GPC['id']);
	if(empty($id)){
		die('粉丝不存在、或是已经被删除');
	}else{
			$need_info  = pdo_fetchcolumn("SELECT	`need_info` FROM ".tablename($this->list_user_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
			$need_info  = iunserializer($need_info);
			if($_GPC['type']=='show'){
				if(empty($need_info)){
					die('未填写资料');
				}else{
					$html = '';
					foreach($need_info as $key=>$rrow){
						if($key!='listid'){
							$input_name = pdo_fetchcolumn("SELECT `name` FROM ".tablename($this->need_input_table)." WHERE weid=:weid AND code=:code AND listid=:listid",array(':weid' =>$weid,':code'=>$key,':listid'=>$listid));
							$html .= '<p class="form-control-static" style="word-break:break-all">'.$input_name.'&nbsp;&nbsp;:&nbsp;&nbsp;'.$rrow.'</p>';
						}
					}
					die($html);
				}
			}else{
				
				if(!empty($need_info)){
					pdo_update($this->list_user_table,array('need_info'=>''),array('id'=>$id));
					die('success');
				}else{
					die('fail');
				}
				
			}
	}
}
if(checksubmit('del_some')){
		if(empty($_GPC['select'])){
					message("请先选择导出项",referer(),'error');
		}
		foreach($_GPC['select'] as $val){
				$fans_openid  = pdo_fetchcolumn("SELECT	`openid` FROM ".tablename($this->list_user_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$val));
			$fans_pls  = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid AND openid=:openid AND status=:status",array(':weid'=>$weid,':listid'=>$listid,':openid'=>$fans_openid,':status'=>'1'));
			pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun - '{$fans_pls}' WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
			pdo_delete($this->pinglun_table,array('listid'=>$listid,'weid'=>$weid,'openid'=>$fans_openid));
			$fans_zans  = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->zan_table)." WHERE weid=:weid AND listid=:listid AND openid=:openid",array(':weid'=>$weid,':listid'=>$listid,':openid'=>$fans_openid));
			pdo_query("UPDATE ".tablename($this->list_table)." SET zan = zan - '{$fans_zans}' WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
			pdo_delete($this->zan_table,array('listid'=>$listid,'weid'=>$weid,'openid'=>$fans_openid));
			pdo_delete($this->share_table,array('listid'=>$listid,'weid'=>$weid,'openid'=>$fans_openid));
			pdo_delete($this->list_user_table,array('listid'=>$listid,'weid'=>$weid,'id'=>$val));
			pdo_delete($this->shake_record_table,array('listid'=>$listid,'openid'=>$fans_openid,'weid'=>$weid));
				pdo_delete($this->share_table,array('listid'=>$listid,'openid'=>$fans_openid,'weid'=>$weid));
		}
		message('删除成功',referer(),'success');
}
if(checksubmit('down')){
			if(empty($_GPC['select'])){
					message("请先选择导出项",referer(),'error');
			}
			$up_list = pdo_fetchall("SELECT * FROM ".tablename($this->list_user_table)." WHERE  weid=:weid  AND id  IN  ('".implode("','", $_GPC['select'])."')", array(':weid'=>$weid));
					

					
					//导出
						include_once ('../framework/library/phpexcel/PHPExcel.php');
						$objPHPExcel = new PHPExcel();
						$objDrawing = new PHPExcel_Worksheet_Drawing();

						$objPHPExcel->getProperties()->setCreator("Meepo");
						$objPHPExcel->getProperties()->setLastModifiedBy("Meepo");
						$objPHPExcel->getProperties()->setTitle("Meepo");

						$objPHPExcel->getActiveSheet()->setCellValue('A1', '粉丝昵称');
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
						$objPHPExcel->getActiveSheet()->setCellValue('B1', '粉丝姓名');
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('C1', '手机号码');
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('D1', '收货地址');
						$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('E1', '打赏次数');
						$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F1', '打赏消费');
						$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('G1', '送礼次数');
						$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('H1', '送礼个数');
						$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('I1', '送礼消费');
						$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('J1', '评论次数');
						$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('K1', '点赞次数');
						$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('L1', '最近登录时间');
						$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('M1', '附加资料');
						$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(100);
						foreach ($up_list as $key => $value) {
							
							$objPHPExcel->getActiveSheet()->setCellValue('A'.($key+2), ' '.$value['nickname']);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.($key+2), empty($value['realname'])?'待完善':$value['realname']);
							$objPHPExcel->getActiveSheet()->setCellValue('C'.($key+2), empty($value['mobile'])?'待完善':$value['mobile']);
							$objPHPExcel->getActiveSheet()->setCellValue('D'.($key+2), empty($value['address'])?'待完善':$value['address']);
							$value['dashang_times'] = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid AND type=:type AND status=:status",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid,':type'=>'redpack',':status'=>'1'));
							$value['dashang_money'] = pdo_fetchcolumn("SELECT SUM(money) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid AND type=:type AND status=:status",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid,':type'=>'redpack',':status'=>'1'));
							$value['gift_times'] = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid AND type!=:type1 AND type!=:type2 AND status=:status",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid,':type1'=>'redpack',':type2'=>'0',':status'=>'1'));
							$value['gift_nums'] = pdo_fetchcolumn("SELECT SUM(num) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid AND type!=:type1 AND type!=:type2 AND status=:status",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid,':type1'=>'redpack',':type2'=>'0',':status'=>'1'));
							$value['gift_money'] = pdo_fetchcolumn("SELECT SUM(money) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid AND type!=:type1 AND type!=:type2 AND status=:status",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid,':type1'=>'redpack',':type2'=>'0',':status'=>'1'));
							$value['pinglun_nums'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid AND type=:type AND status=:status",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid,':type'=>'0',':status'=>'1'));
							$value['zan_nums'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->zan_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid));
							
							$objPHPExcel->getActiveSheet()->setCellValue('E'.($key+2), intval($value['dashang_times']).'次');
							$objPHPExcel->getActiveSheet()->setCellValue('F'.($key+2), round($value['dashang_money'],2).'元');
							$objPHPExcel->getActiveSheet()->setCellValue('G'.($key+2),intval($value['gift_times']).'次');
							$objPHPExcel->getActiveSheet()->setCellValue('H'.($key+2),intval($value['gift_times']).'次');
							$objPHPExcel->getActiveSheet()->setCellValue('I'.($key+2),round($value['gift_money'],2).'元');
							$objPHPExcel->getActiveSheet()->setCellValue('J'.($key+2),intval($value['pinglun_nums']).'次');
							$objPHPExcel->getActiveSheet()->setCellValue('K'.($key+2),intval($value['zan_nums']).'次');
							$objPHPExcel->getActiveSheet()->setCellValue('L'.($key+2),date('Y-m-d H:i:s',$value['createtime']));
						
							$need_info  = pdo_fetchcolumn("SELECT	`need_info` FROM ".tablename($this->list_user_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$value['id']));
							$need_info  = iunserializer($need_info);
							if(empty($need_info)){
								  $fan_info_it  = '未填写';
							}else{
								foreach($need_info as $key=>$rrow){
									if($key!='listid'){
										$input_name = pdo_fetchcolumn("SELECT `name` FROM ".tablename($this->need_input_table)." WHERE weid=:weid AND code=:code AND listid=:listid",array(':weid' =>$weid,':code'=>$key,':listid'=>$listid));
										$fan_info_it .= $input_name.'-->'.$rrow."||";
									}
								}
								
							}
							$objPHPExcel->getActiveSheet()->setCellValue('M'.($key+2),$fan_info_it);
						}

						$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

						header("Pragma: public");
						header("Expires: 0");
						header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
						header("Content-Type:application/force-download");
						header("Content-Type:application/vnd.ms-execl");
						header("Content-Type:application/octet-stream");
						header("Content-Type:application/download");;
						header('Content-Disposition:attachment;filename="会员名单.xls"');
						header("Content-Transfer-Encoding:binary");
						$objWriter->save('php://output');

						exit();
}
if(checksubmit('downall')){
			
			$up_list = pdo_fetchall("SELECT * FROM ".tablename($this->list_user_table)." WHERE  weid=:weid  AND listid=:listid", array(':weid'=>$weid,':listid'=>$listid));
					

					
					//导出
						include_once ('../framework/library/phpexcel/PHPExcel.php');
						$objPHPExcel = new PHPExcel();
						$objDrawing = new PHPExcel_Worksheet_Drawing();

						$objPHPExcel->getProperties()->setCreator("Meepo");
						$objPHPExcel->getProperties()->setLastModifiedBy("Meepo");
						$objPHPExcel->getProperties()->setTitle("Meepo");

						$objPHPExcel->getActiveSheet()->setCellValue('A1', '粉丝昵称');
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
						$objPHPExcel->getActiveSheet()->setCellValue('B1', '粉丝姓名');
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('C1', '手机号码');
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('D1', '收货地址');
						$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('E1', '打赏次数');
						$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F1', '打赏消费');
						$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('G1', '送礼次数');
						$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('H1', '送礼个数');
						$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('I1', '送礼消费');
						$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('J1', '评论次数');
						$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('K1', '点赞次数');
						$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('L1', '最近登录时间');
						$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
							$objPHPExcel->getActiveSheet()->setCellValue('M1', '附加资料');
							$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(100);
						foreach ($up_list as $key => $value) {
							
							$objPHPExcel->getActiveSheet()->setCellValue('A'.($key+2), ' '.$value['nickname']);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.($key+2), empty($value['realname'])?'待完善':$value['realname']);
							$objPHPExcel->getActiveSheet()->setCellValue('C'.($key+2), empty($value['mobile'])?'待完善':$value['mobile']);
							$objPHPExcel->getActiveSheet()->setCellValue('D'.($key+2), empty($value['address'])?'待完善':$value['address']);
							$value['dashang_times'] = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid AND type=:type AND status=:status",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid,':type'=>'redpack',':status'=>'1'));
							$value['dashang_money'] = pdo_fetchcolumn("SELECT SUM(money) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid AND type=:type AND status=:status",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid,':type'=>'redpack',':status'=>'1'));
							$value['gift_times'] = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid AND type!=:type1 AND type!=:type2 AND status=:status",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid,':type1'=>'redpack',':type2'=>'0',':status'=>'1'));
							$value['gift_nums'] = pdo_fetchcolumn("SELECT SUM(num) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid AND type!=:type1 AND type!=:type2 AND status=:status",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid,':type1'=>'redpack',':type2'=>'0',':status'=>'1'));
							$value['gift_money'] = pdo_fetchcolumn("SELECT SUM(money) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid AND type!=:type1 AND type!=:type2 AND status=:status",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid,':type1'=>'redpack',':type2'=>'0',':status'=>'1'));
							$value['pinglun_nums'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid AND type=:type AND status=:status",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid,':type'=>'0',':status'=>'1'));
							$value['zan_nums'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->zan_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid));
							$objPHPExcel->getActiveSheet()->setCellValue('E'.($key+2), intval($value['dashang_times']).'次');
							$objPHPExcel->getActiveSheet()->setCellValue('F'.($key+2), round($value['dashang_money'],2).'元');
							$objPHPExcel->getActiveSheet()->setCellValue('G'.($key+2),intval($value['gift_times']).'次');
							$objPHPExcel->getActiveSheet()->setCellValue('H'.($key+2),intval($value['gift_times']).'次');
							$objPHPExcel->getActiveSheet()->setCellValue('I'.($key+2),round($value['gift_money'],2).'元');
							$objPHPExcel->getActiveSheet()->setCellValue('J'.($key+2),intval($value['pinglun_nums']).'次');
							$objPHPExcel->getActiveSheet()->setCellValue('K'.($key+2),intval($value['zan_nums']).'次');
							$objPHPExcel->getActiveSheet()->setCellValue('L'.($key+2),date('Y-m-d H:i:s',$value['createtime']));
							$need_info  = pdo_fetchcolumn("SELECT	`need_info` FROM ".tablename($this->list_user_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$value['id']));
							$need_info  = iunserializer($need_info);
							if(empty($need_info)){
								  $fan_info_it  = '未填写';
							}else{
								foreach($need_info as $key=>$rrow){
									if($key!='listid'){
										$input_name = pdo_fetchcolumn("SELECT `name` FROM ".tablename($this->need_input_table)." WHERE weid=:weid AND code=:code AND listid=:listid",array(':weid' =>$weid,':code'=>$key,':listid'=>$listid));
										$fan_info_it .= $input_name.'-->'.$rrow."||";
									}
								}
								
							}
							$objPHPExcel->getActiveSheet()->setCellValue('M'.($key+2),$fan_info_it);
						}

						$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

						header("Pragma: public");
						header("Expires: 0");
						header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
						header("Content-Type:application/force-download");
						header("Content-Type:application/vnd.ms-execl");
						header("Content-Type:application/octet-stream");
						header("Content-Type:application/download");;
						header('Content-Disposition:attachment;filename="会员名单.xls"');
						header("Content-Transfer-Encoding:binary");
						$objWriter->save('php://output');

						exit();
}
include $this->template('list_fans');