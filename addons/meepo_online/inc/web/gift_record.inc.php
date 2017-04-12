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
	message('直播id不存在',$this->createWebUrl('live_manage'),'error');
}
if($op=='list'){
	$total_success_money = pdo_fetchcolumn("SELECT SUM(money) FROM ".tablename($this->pinglun_table)." WHERE  weid=:weid AND listid=:listid AND status=:status  AND type != '0' AND type != 'redpack'",array(':weid'=>$weid,':listid'=>$listid,':status'=>1));
	$total_fail_money = pdo_fetchcolumn("SELECT SUM(money) FROM ".tablename($this->pinglun_table)." WHERE  weid=:weid AND listid=:listid AND status=:status AND type != '0' AND type != 'redpack'",array(':weid'=>$weid,':listid'=>$listid,':status'=>0));
	$condition = " AND type != '0' AND type != 'redpack'";
	if(!empty($_GPC['nickname'])){
		$nickname = $_GPC['nickname'];
		$condition .= " AND nickname LIKE '%{$_GPC['nickname']}%'";
	}
	$status = empty($_GPC['status'])? '1':intval($_GPC['status']);
	if($status==2){
		$status = 0;
	}
	$paras = array(':weid'=>$weid,':listid'=>$listid,':status'=>$status);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$llists = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND listid=:listid AND status=:status $condition  ORDER BY createtime DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",$paras);
	$lists = array();
	if(!empty($llists)){
		foreach($llists as $row){
			$row['cansay'] = pdo_fetchcolumn("SELECT `cansay` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid",array(':openid'=>$row['openid'],':weid'=>$weid,':listid'=>$listid));
			$lists[] = $row;
		}
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->pinglun_table) . " WHERE weid=:weid
	AND listid=:listid AND status=:status $condition",$paras);
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='post'){
	$id = intval($_GPC['id']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND id=:id AND listid=:listid",array(':weid'=>$weid,':id'=>$id,':listid'=>$listid));
	if(empty($list)){
		message('此项不存在或是已经被删除',$this->createWebUrl('gift_record',array('listid'=>$listid,'status'=>$status)),'error');
	}else{
		pdo_update($this->pinglun_table,array('status'=>1),array('id'=>$id,'weid'=>$weid));
	}
	message('审核成功',$this->createWebUrl('gift_record',array('listid'=>$listid,'status'=>'2')),'success');
}elseif($op=='cansay'){
	$cansay = intval($live['cansay']);
	if(!$cansay){
		$cansay = 1;
		$message = '开启禁止评论成功';
	}else{
		$cansay = 0;
		$message = '开启准许评论成功';
	}
	pdo_update($this->list_table,array('cansay'=>$cansay),array('id'=>$listid,'weid'=>$weid));
	message($message,$this->createWebUrl('gift_record',array('listid'=>$listid,'status'=>'2')),'success');
	
}elseif($op=='status'){
	$status = intval($live['status']);
	if(!$status){
		$status = 1;
		$message = '开启审核成功';
	}else{
		$status = 0;
		$message = '关闭审核成功';
	}
	pdo_update($this->list_table,array('status'=>$status),array('id'=>$listid,'weid'=>$weid));
	message($message,$this->createWebUrl('gift_record',array('listid'=>$listid,'status'=>'2')),'success');
	
}elseif($op=='ajax'){
	$id = intval($_GPC['id']);
	$listid = intval($_GPC['listid']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->pinglun_table)." WHERE weid=:weid AND id=:id AND listid=:listid",array(':weid'=>$weid,':id'=>$id,':listid'=>$listid));
	if(empty($list)){
		die(json_encode(error(-1,'此项不存在或是已经被删除')));
	}else{
		$ajax_type = trim($_GPC['ajax_type']);
		if($ajax_type=='del'){
			if($list['status']=='1'){
					pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun - 1 WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
			}
			pdo_delete($this->pinglun_table,array('id'=>$id,'weid'=>$weid,'listid'=>$listid));
			die(json_encode(error(0,'success')));
		}elseif($ajax_type=='pass'){
			pdo_update($this->pinglun_table,array('status'=>1),array('id'=>$id,'weid'=>$weid,'listid'=>$listid));
			pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun + 1 WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$listid));
			die(json_encode(error(0,'success')));
		}elseif($ajax_type=='forbide'){
			$openid = $_GPC['openid'];
			$cansay = pdo_fetchcolumn("SELECT `cansay` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid",array(':openid'=>$openid,':weid'=>$weid,':listid'=>$listid));
			if($cansay=='1'){
				$cansay = 0;
			}else{
				$cansay = 1;
			}
			pdo_update($this->list_user_table,array('cansay'=>$cansay),array('listid'=>$listid,'weid'=>$weid,'openid'=>$openid));
			die(json_encode(error(0,'success')));
		}
	}
	
}
if(checksubmit('down')){
			if(empty($_GPC['select'])){
					message("请先选择导出项",referer(),'error');
			}
			
			$up_list = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE  weid=:weid  AND listid=:listid AND status=:status AND type!=:type1 AND type!=:type2 AND id  IN  ('".implode("','", $_GPC['select'])."')", array(':weid'=>$weid,':listid'=>$listid,':status'=>$status,':type1'=>'0',':type2'=>'redpack'));
					

					
					//导出
						include_once ('../framework/library/phpexcel/PHPExcel.php');
						$objPHPExcel = new PHPExcel();
						$objDrawing = new PHPExcel_Worksheet_Drawing();

						$objPHPExcel->getProperties()->setCreator("Meepo");
						$objPHPExcel->getProperties()->setLastModifiedBy("Meepo");
						$objPHPExcel->getProperties()->setTitle("Meepo");

						$objPHPExcel->getActiveSheet()->setCellValue('A1', '粉丝昵称');
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
						$objPHPExcel->getActiveSheet()->setCellValue('B1', '赠送奖品');
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('C1', '赠送奖目');
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('D1', '消费金额');
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('E1', '支付状态');
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F1', '赠送时间');
						$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
						foreach ($up_list as $key => $value) {
							$objPHPExcel->getActiveSheet()->setCellValue('A'.($key+2), ' '.$value['nickname']);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.($key+2), $value['content']);
							$objPHPExcel->getActiveSheet()->setCellValue('C'.($key+2), $value['num'].'个');
							$objPHPExcel->getActiveSheet()->setCellValue('D'.($key+2),round($value['money'],2));
							
							$objPHPExcel->getActiveSheet()->setCellValue('E'.($key+2),$value['status']=='1' ? '支付成功':'支付失败');
							$objPHPExcel->getActiveSheet()->setCellValue('F'.($key+2),date('Y-m-d H:i:s',$value['createtime']));
						}

						$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

						header("Pragma: public");
						header("Expires: 0");
						header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
						header("Content-Type:application/force-download");
						header("Content-Type:application/vnd.ms-execl");
						header("Content-Type:application/octet-stream");
						header("Content-Type:application/download");;
						header('Content-Disposition:attachment;filename="送礼会员名单.xls"');
						header("Content-Transfer-Encoding:binary");
						$objWriter->save('php://output');

						exit();
}
if(checksubmit('downall')){
			$up_list = pdo_fetchall("SELECT * FROM ".tablename($this->pinglun_table)." WHERE  weid=:weid  AND listid=:listid AND status=:status AND type!=:type1 AND type!=:type2", array(':weid'=>$weid,':listid'=>$listid,':status'=>$status,':type1'=>'0',':type2'=>'redpack'));
					

					
					//导出
						include_once ('../framework/library/phpexcel/PHPExcel.php');
						$objPHPExcel = new PHPExcel();
						$objDrawing = new PHPExcel_Worksheet_Drawing();

						$objPHPExcel->getProperties()->setCreator("Meepo");
						$objPHPExcel->getProperties()->setLastModifiedBy("Meepo");
						$objPHPExcel->getProperties()->setTitle("Meepo");

						$objPHPExcel->getActiveSheet()->setCellValue('A1', '粉丝昵称');
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
						$objPHPExcel->getActiveSheet()->setCellValue('B1', '赠送奖品');
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('C1', '赠送奖目');
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('D1', '消费金额');
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('E1', '支付状态');
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F1', '赠送时间');
						$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
						foreach ($up_list as $key => $value) {
							$objPHPExcel->getActiveSheet()->setCellValue('A'.($key+2), ' '.$value['nickname']);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.($key+2), $value['content']);
							$objPHPExcel->getActiveSheet()->setCellValue('C'.($key+2), $value['num'].'个');
							$objPHPExcel->getActiveSheet()->setCellValue('D'.($key+2),round($value['money'],2));
							
							$objPHPExcel->getActiveSheet()->setCellValue('E'.($key+2),$value['status']=='1' ? '支付成功':'支付失败');
							$objPHPExcel->getActiveSheet()->setCellValue('F'.($key+2),date('Y-m-d H:i:s',$value['createtime']));
						}

						$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

						header("Pragma: public");
						header("Expires: 0");
						header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
						header("Content-Type:application/force-download");
						header("Content-Type:application/vnd.ms-execl");
						header("Content-Type:application/octet-stream");
						header("Content-Type:application/download");
						if($status=='1'){
							header('Content-Disposition:attachment;filename="送礼成功会员名单.xls"');
						}else{
							header('Content-Disposition:attachment;filename="送礼失败会员名单.xls"');
						}
						header("Content-Transfer-Encoding:binary");
						$objWriter->save('php://output');

						exit();
}
include $this->template('gift_record');