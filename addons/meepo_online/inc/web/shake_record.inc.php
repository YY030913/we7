<?php
//ini_set("display_errors", "On");
//error_reporting(E_ALL | E_STRICT);
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
$awards = pdo_fetchall("SELECT  * FROM " . tablename($this->shake_award_table) . " WHERE weid=:weid AND listid=:listid ORDER BY gailv ASC", array(":weid" =>$weid,':listid'=>$listid));
if($op=='list'){
	
	$condition = "";
	if(!empty($_GPC['nickname'])){
		$nickname = $_GPC['nickname'];
		$condition .= " AND nickname LIKE '%{$_GPC['nickname']}%'";
	}
	if(!empty($_GPC['award_id'])){
				$award_id = intval($_GPC['award_id']);
				$condition .= " AND award_id = '{$award_id}'";
	}
	$paras = array(':weid'=>$weid,':listid'=>$listid);
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$llists = pdo_fetchall("SELECT * FROM ".tablename($this->shake_record_table)." WHERE weid=:weid AND listid=:listid $condition  ORDER BY createtime DESC  LIMIT ".($pindex - 1) * $psize.",{$psize}",$paras);
	$lists = array();
	if(!empty($llists)){
		foreach($llists as $row){
			$temp = pdo_fetch("SELECT `name`,`img` FROM ".tablename($this->shake_award_table)." WHERE weid=:weid AND listid=:listid AND id=:id",array(':weid'=>$weid,':listid'=>$listid,':id'=>$row['award_id']));
			$user = pdo_fetch("SELECT	`realname`,`mobile`,`address` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND listid=:listid",array(':openid'=>$row['openid'],':listid'=>$listid));
			$row['award_name']  = $temp['name'];
			$row['award_img']  = $temp['img'];
			$row['realname'] = $user['realname'];
			$row['mobile'] = $user['mobile'];
			$row['address'] = $user['address'];
			$lists[] = $row;
		}
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->shake_record_table) . " WHERE weid=:weid
	AND listid=:listid $condition",$paras);
	$pager = pagination($total, $pindex, $psize);
}elseif($op=='del'){
	$id = intval($_GPC['id']);
	$check = pdo_fetch("SELECT * FROM ".tablename($this->shake_record_table)." WHERE weid=:weid AND listid=:listid AND id=:id",array(':weid'=>$weid,':listid'=>$listid,':id'=>$id));
	if(empty($check)){
		message('此项不存在或是已经被删除！');
	}else{
	 if($check['award_id']!='0'){
				pdo_query("UPDATE ".tablename($this->shake_award_table)." SET had_get_num = had_get_num -1 WHERE weid = :weid AND listid=:listid AND id=:id",array(':weid'=>$weid,':listid'=>$listid,':id'=>$check['award_id']));
	 }
	 pdo_delete($this->shake_record_table,array('id'=>$id,'listid'=>$listid,'weid'=>$weid));
	 message('删除成功','referer','success');	
	}
}elseif($op=='delall'){
	pdo_delete($this->shake_record_table,array('listid'=>$listid,'weid'=>$weid));
	pdo_update($this->shake_award_table,array('had_get_num'=>0),array('listid'=>$listid,'weid'=>$weid));
	message('清除成功',$this->createWebUrl('shake_record',array('listid'=>$listid)),'success');	
}
if(checksubmit('down')){
			if(empty($_GPC['select'])){
					message("请先选择导出项",referer(),'error');
			}
			
				$up_list = pdo_fetchall("SELECT * FROM ".tablename($this->shake_record_table)." WHERE  weid=:weid  AND listid=:listid  AND id  IN  ('".implode("','", $_GPC['select'])."')", array(':weid'=>$weid,':listid'=>$listid));
				

					
					//导出
						include_once ('../framework/library/phpexcel/PHPExcel.php');
						$objPHPExcel = new PHPExcel();
						$objDrawing = new PHPExcel_Worksheet_Drawing();

						$objPHPExcel->getProperties()->setCreator("Meepo");
						$objPHPExcel->getProperties()->setLastModifiedBy("Meepo");
						$objPHPExcel->getProperties()->setTitle("Meepo");

						$objPHPExcel->getActiveSheet()->setCellValue('A1', '粉丝昵称');
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
						$objPHPExcel->getActiveSheet()->setCellValue('B1', '中奖状态');
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('C1', '奖品名称');
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('D1', '姓名');
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('E1', '手机号码');
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F1', '联系方式');
						$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('G1', '参与时间');
						$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
						foreach ($up_list as $key => $value) {
							$objPHPExcel->getActiveSheet()->setCellValue('A'.($key+2), ' '.$value['nickname']);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.($key+2), $value['award_id']=='0'?'未中奖':'中奖');
							$temp_name = pdo_fetchcolumn("SELECT `name` FROM ".tablename($this->shake_award_table)." WHERE weid=:weid AND listid=:listid AND id=:id",array(':weid'=>$weid,':listid'=>$listid,':id'=>$value['award_id']));
							$objPHPExcel->getActiveSheet()->setCellValue('C'.($key+2), empty($temp_name)?'未中奖':$temp_name);
							$tem_user = pdo_fetch("SELECT `realname`,`mobile`,`address` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid));
							$objPHPExcel->getActiveSheet()->setCellValue('D'.($key+2), empty($tem_user['realname'])?'待完善':$tem_user['realname']);
							$objPHPExcel->getActiveSheet()->setCellValue('E'.($key+2), empty($tem_user['mobile'])?'待完善':" ".$tem_user['mobile']);
							$objPHPExcel->getActiveSheet()->setCellValue('F'.($key+2), empty($tem_user['address'])?'待完善':$tem_user['address']);
							$objPHPExcel->getActiveSheet()->setCellValue('G'.($key+2),date('Y-m-d H:i:s',$value['createtime']));
						}

						$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

						header("Pragma: public");
						header("Expires: 0");
						header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
						header("Content-Type:application/force-download");
						header("Content-Type:application/vnd.ms-execl");
						header("Content-Type:application/octet-stream");
						header("Content-Type:application/download");;
						header('Content-Disposition:attachment;filename="摇一摇会员名单.xls"');
						header("Content-Transfer-Encoding:binary");
						$objWriter->save('php://output');

						exit();
}
if(checksubmit('downall')){
			
			
				$up_list = pdo_fetchall("SELECT * FROM ".tablename($this->shake_record_table)." WHERE  weid=:weid  AND listid=:listid", array(':weid'=>$weid,':listid'=>$listid));
				

					
					//导出
						include_once ('../framework/library/phpexcel/PHPExcel.php');
						$objPHPExcel = new PHPExcel();
						$objDrawing = new PHPExcel_Worksheet_Drawing();

						$objPHPExcel->getProperties()->setCreator("Meepo");
						$objPHPExcel->getProperties()->setLastModifiedBy("Meepo");
						$objPHPExcel->getProperties()->setTitle("Meepo");

						$objPHPExcel->getActiveSheet()->setCellValue('A1', '粉丝昵称');
						$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(60);
						$objPHPExcel->getActiveSheet()->setCellValue('B1', '中奖状态');
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('C1', '奖品名称');
						$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
						$objPHPExcel->getActiveSheet()->setCellValue('D1', '姓名');
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('E1', '手机号码');
						$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F1', '联系方式');
						$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('G1', '参与时间');
						$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
						foreach ($up_list as $key => $value) {
							$objPHPExcel->getActiveSheet()->setCellValue('A'.($key+2), ' '.$value['nickname']);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.($key+2), $value['award_id']=='0'?'未中奖':'中奖');
							$temp_name = pdo_fetchcolumn("SELECT `name` FROM ".tablename($this->shake_award_table)." WHERE weid=:weid AND listid=:listid AND id=:id",array(':weid'=>$weid,':listid'=>$listid,':id'=>$value['award_id']));
							$objPHPExcel->getActiveSheet()->setCellValue('C'.($key+2), empty($temp_name)?'未中奖':$temp_name);
							$tem_user = pdo_fetch("SELECT `realname`,`mobile`,`address` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid AND listid=:listid",array(':openid'=>$value['openid'],':weid'=>$weid,':listid'=>$listid));
							$objPHPExcel->getActiveSheet()->setCellValue('D'.($key+2), empty($tem_user['realname'])?'待完善':$tem_user['realname']);
							$objPHPExcel->getActiveSheet()->setCellValue('E'.($key+2), empty($tem_user['mobile'])?'待完善':" ".$tem_user['mobile']);
							$objPHPExcel->getActiveSheet()->setCellValue('F'.($key+2), empty($tem_user['address'])?'待完善':$tem_user['address']);
							$objPHPExcel->getActiveSheet()->setCellValue('G'.($key+2),date('Y-m-d H:i:s',$value['createtime']));
						}

						$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

						header("Pragma: public");
						header("Expires: 0");
						header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
						header("Content-Type:application/force-download");
						header("Content-Type:application/vnd.ms-execl");
						header("Content-Type:application/octet-stream");
						header("Content-Type:application/download");;
						header('Content-Disposition:attachment;filename="摇一摇会员名单.xls"');
						header("Content-Transfer-Encoding:binary");
						$objWriter->save('php://output');

						exit();
}
include $this->template('shake_record');