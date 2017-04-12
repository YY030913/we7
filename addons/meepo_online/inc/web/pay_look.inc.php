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
	$total_success_money = pdo_fetchcolumn("SELECT SUM(money) FROM ".tablename($this->online_pay_record)." WHERE  weid=:weid AND listid=:listid AND status=:status ",array(':weid'=>$weid,':listid'=>$listid,':status'=>1));
	$total_fail_money = pdo_fetchcolumn("SELECT SUM(money) FROM ".tablename($this->online_pay_record)." WHERE  weid=:weid AND listid=:listid AND status=:status",array(':weid'=>$weid,':listid'=>$listid,':status'=>0));
	$condition = '';
	if(!empty($_GPC['nickname'])){
		$nickname = $_GPC['nickname'];
		$bind = " AND nickname LIKE '%{$_GPC['nickname']}%'";
		$openid = pdo_fetchcolumn("SELECT `openid` FROM ".tablename($this->list_user_table)." WHERE  weid=:weid AND listid=:listid $bind ",array(':weid'=>$weid,':listid'=>$listid));
		if(!empty($openid)){
			$condition .= " AND openid='{$openid}'";
		}
		
	}
	$status = empty($_GPC['status'])? '1':intval($_GPC['status']);
	if($status==2){
		$status = 0;
	}
	$paras = array(':weid'=>$weid,':listid'=>$listid,':status'=>$status);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$llists = pdo_fetchall("SELECT * FROM ".tablename($this->online_pay_record)." WHERE weid=:weid AND listid=:listid AND status=:status $condition  ORDER BY createtime DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",$paras);
	$lists = array();
	if(!empty($llists)){
		foreach($llists as $row){
			$pay_user = pdo_fetch("SELECT `avatar`,`nickname` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid",array(':openid'=>$row['openid'],':weid'=>$weid,':listid'=>$listid));
			$row['nickname'] = $pay_user['nickname'];
			$row['avatar'] = $pay_user['avatar'];
			$lists[] = $row;
		}
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->online_pay_record) . " WHERE weid=:weid
	AND listid=:listid AND status=:status $condition",$paras);
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='post'){
	$id = intval($_GPC['id']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->online_pay_record)." WHERE weid=:weid AND id=:id AND listid=:listid",array(':weid'=>$weid,':id'=>$id,':listid'=>$listid));
	if(empty($list)){
		message('此项不存在或是已经被删除',$this->createWebUrl('pay_look',array('listid'=>$listid,'status'=>$status)),'error');
	}else{
		pdo_update($this->online_pay_record,array('status'=>1),array('id'=>$id,'weid'=>$weid));
	}
	message('审核成功',$this->createWebUrl('pay_look',array('listid'=>$listid,'status'=>'2')),'success');
}elseif($op=='ajax'){
	$id = intval($_GPC['id']);
	$listid = intval($_GPC['listid']);
	$list = pdo_fetch("SELECT * FROM ".tablename($this->online_pay_record)." WHERE weid=:weid AND id=:id AND listid=:listid",array(':weid'=>$weid,':id'=>$id,':listid'=>$listid));
	if(empty($list)){
		die(json_encode(error(-1,'此项不存在或是已经被删除')));
	}else{
		$ajax_type = trim($_GPC['ajax_type']);
		if($ajax_type=='del'){
			pdo_delete($this->online_pay_record,array('id'=>$id,'weid'=>$weid,'listid'=>$listid));
			die(json_encode(error(0,'success')));
		}
	}
	
}
if(checksubmit('down')){
			if(empty($_GPC['select'])){
					message("请先选择导出项",referer(),'error');
			}
			
			$up_list = pdo_fetchall("SELECT * FROM ".tablename($this->online_pay_record)." WHERE  weid=:weid  AND listid=:listid AND status=:status AND id  IN  ('".implode("','", $_GPC['select'])."')", array(':weid'=>$weid,':listid'=>$listid,':status'=>$status));
					

					
					//导出
						include_once ('../framework/library/phpexcel/PHPExcel.php');
						$objPHPExcel = new PHPExcel();
						$objDrawing = new PHPExcel_Worksheet_Drawing();

						$objPHPExcel->getProperties()->setCreator("Meepo");
						$objPHPExcel->getProperties()->setLastModifiedBy("Meepo");
						$objPHPExcel->getProperties()->setTitle("Meepo");

						$objPHPExcel->getActiveSheet()->setCellValue('A1', '粉丝昵称');
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
						$objPHPExcel->getActiveSheet()->setCellValue('B1', '付费金额');
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('C1', '支付状态');
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('D1', '付费时间');
						$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
						foreach ($up_list as $key => $value) {
							$value['nickname'] = pdo_fetchcolumn("SELECT `nickname` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid));
							$objPHPExcel->getActiveSheet()->setCellValue('A'.($key+2), ' '.$value['nickname']);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.($key+2), round($value['money'],2).'元');
							$objPHPExcel->getActiveSheet()->setCellValue('C'.($key+2), $value['status']=='1' ? '支付成功':'支付失败');
							$objPHPExcel->getActiveSheet()->setCellValue('D'.($key+2),date('Y-m-d H:i:s',$value['createtime']));
						}

						$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

						header("Pragma: public");
						header("Expires: 0");
						header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
						header("Content-Type:application/force-download");
						header("Content-Type:application/vnd.ms-execl");
						header("Content-Type:application/octet-stream");
						header("Content-Type:application/download");;
						header('Content-Disposition:attachment;filename="付费观看会员名单.xls"');
						header("Content-Transfer-Encoding:binary");
						$objWriter->save('php://output');

						exit();
}
if(checksubmit('downall')){
			
			
			$up_list = pdo_fetchall("SELECT * FROM ".tablename($this->online_pay_record)." WHERE  weid=:weid  AND listid=:listid AND status=:status", array(':weid'=>$weid,':listid'=>$listid,':status'=>$status));
					

					
					//导出
						include_once ('../framework/library/phpexcel/PHPExcel.php');
						$objPHPExcel = new PHPExcel();
						$objDrawing = new PHPExcel_Worksheet_Drawing();

						$objPHPExcel->getProperties()->setCreator("Meepo");
						$objPHPExcel->getProperties()->setLastModifiedBy("Meepo");
						$objPHPExcel->getProperties()->setTitle("Meepo");

						$objPHPExcel->getActiveSheet()->setCellValue('A1', '粉丝昵称');
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
						$objPHPExcel->getActiveSheet()->setCellValue('B1', '支付金额');
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('C1', '支付状态');
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('D1', '支付时间');
						$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
						foreach ($up_list as $key => $value) {
							$value['nickname'] = pdo_fetchcolumn("SELECT `nickname` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid));
							$objPHPExcel->getActiveSheet()->setCellValue('A'.($key+2), ' '.$value['nickname']);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.($key+2), round($value['money'],2).'元');
							$objPHPExcel->getActiveSheet()->setCellValue('C'.($key+2), $value['status']=='1' ? '支付成功':'支付失败');
							$objPHPExcel->getActiveSheet()->setCellValue('D'.($key+2),date('Y-m-d H:i:s',$value['createtime']));
							
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
							header('Content-Disposition:attachment;filename="付费观看支付成功会员名单.xls"');
						}else{
							header('Content-Disposition:attachment;filename="付费观看支付失败会员名单.xls"');
						}
						header("Content-Transfer-Encoding:binary");
						$objWriter->save('php://output');

						exit();
}
include $this->template('pay_look');