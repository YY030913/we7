<?php

global $_W,$_GPC;
$weid = $_W['uniacid'];
$op = empty($_GPC['op'])? 'list':$_GPC['op'];
if($op=='list'){
	$condition = '';
	if(!empty($_GPC['nickname'])){
	$nickname = $_GPC['nickname'];
	$condition .= " AND nickname LIKE '%{$_GPC['nickname']}%'";
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$weid = $_W['uniacid'];
	$fans = pdo_fetchall("SELECT * FROM ".tablename($this->user_table)." WHERE weid=:weid $condition ORDER BY createtime DESC LIMIT ".($pindex - 1) * $psize.",{$psize}",array(':weid'=>$weid));
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->user_table) . " WHERE weid=:weid $condition", array(':weid'=>$weid));
	
		$pager = pagination($total, $pindex, $psize);
  
}elseif($op=='del'){
		$id = intval($_GPC['id']);
		$fans = pdo_fetchcolumn("SELECT	`openid` FROM ".tablename($this->user_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$id));
		if(empty($fans)){
			message('粉丝不存在或是已经被删除！');
		}else{
				$fans_join_lists = pdo_fetchall("SELECT `listid` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid",array(':openid'=>$fans,':weid'=>$weid));
				if(!empty($fans_join_lists) && is_array($fans_join_lists)){
					foreach($fans_join_lists as $row){
							$check_pingluns = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND listid=:listid AND weid=:weid AND status=:status",array(':openid'=>$fans,':listid'=>$row['listid'],':weid'=>$weid,':status'=>'1'));
							pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun - '{$check_pingluns}' WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$row['listid']));
							pdo_delete($this->pinglun_table,array('openid'=>$fans,'listid'=>$row['listid']));
							$check_zan = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->zan_table)." WHERE openid=:openid AND listid=:listid AND weid=:weid ",array(':openid'=>$fans,':listid'=>$row['listid'],':weid'=>$weid));
							pdo_query("UPDATE ".tablename($this->list_table)." SET zan = zan - '{$check_zan}' WHERE weid = 
			:weid AND id=:id",array(':weid'=>$weid,':id'=>$row['listid']));
							pdo_delete($this->zan_table,array('openid'=>$fans,'listid'=>$row['listid']));
					}
				}
				pdo_delete($this->list_user_table,array('openid'=>$fans,'weid'=>$weid));
				pdo_delete($this->shake_record_table,array('openid'=>$fans,'weid'=>$weid));
				pdo_delete($this->share_table,array('openid'=>$fans,'weid'=>$weid));
				pdo_delete($this->user_table,array('openid'=>$fans,'weid'=>$weid));
				message('删除成功',referer(),'success');
		}
	
}
if(checksubmit('del_some')){
		if(empty($_GPC['select'])){
					message("请先选择导出项",referer(),'error');
		}
		foreach($_GPC['select'] as $val){
			$fans = pdo_fetchcolumn("SELECT	`openid` FROM ".tablename($this->user_table)." WHERE weid=:weid AND id=:id",array(':weid'=>$weid,':id'=>$val));
			if(empty($fans)){
				message('删除的粉丝不存在或是已经被删除！');
			}else{
					$fans_join_lists = pdo_fetchall("SELECT `listid` FROM ".tablename($this->list_user_table)." WHERE openid=:openid AND weid=:weid",array(':openid'=>$fans,':weid'=>$weid));
					if(!empty($fans_join_lists) && is_array($fans_join_lists)){
						foreach($fans_join_lists as $row){
								$check_pingluns = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND listid=:listid AND weid=:weid AND status=:status",array(':openid'=>$fans,':listid'=>$row['listid'],':weid'=>$weid,':status'=>'1'));
								pdo_query("UPDATE ".tablename($this->list_table)." SET pinglun = pinglun - '{$check_pingluns}' WHERE weid = 
				:weid AND id=:id",array(':weid'=>$weid,':id'=>$row['listid']));
								pdo_delete($this->pinglun_table,array('openid'=>$fans,'listid'=>$row['listid']));
								$check_zan = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->zan_table)." WHERE openid=:openid AND listid=:listid AND weid=:weid ",array(':openid'=>$fans,':listid'=>$row['listid'],':weid'=>$weid));
								pdo_query("UPDATE ".tablename($this->list_table)." SET zan = zan - '{$check_zan}' WHERE weid = 
				:weid AND id=:id",array(':weid'=>$weid,':id'=>$row['listid']));
								pdo_delete($this->zan_table,array('openid'=>$fans,'listid'=>$row['listid']));
						}
					}
					pdo_delete($this->list_user_table,array('openid'=>$fans,'weid'=>$weid));
					pdo_delete($this->shake_record_table,array('openid'=>$fans,'weid'=>$weid));
					pdo_delete($this->share_table,array('openid'=>$fans,'weid'=>$weid));
					pdo_delete($this->user_table,array('openid'=>$fans,'weid'=>$weid));
					
			}
		}
		message('删除成功',referer(),'success');
}
if(checksubmit('down')){
			if(empty($_GPC['select'])){
					message("请先选择导出项",referer(),'error');
			}
			$up_list = pdo_fetchall("SELECT * FROM ".tablename($this->user_table)." WHERE  weid=:weid  AND id  IN  ('".implode("','", $_GPC['select'])."')", array(':weid'=>$weid));
					

					
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
						$objPHPExcel->getActiveSheet()->setCellValue('E1', '总消费金额');
						$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F1', '注册时间');
						$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('G1', '最近登录时间');
						$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
						foreach ($up_list as $key => $value) {
							$value['money'] = pdo_fetchcolumn("SELECT SUM(money) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid",array(':openid'=>$value['openid'],':weid'=>$weid));
							$objPHPExcel->getActiveSheet()->setCellValue('A'.($key+2), ' '.$value['nickname']);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.($key+2), empty($value['realname'])?'待完善':$value['realname']);
							$objPHPExcel->getActiveSheet()->setCellValue('C'.($key+2), empty($value['mobile'])?'待完善':$value['mobile']);
							$objPHPExcel->getActiveSheet()->setCellValue('D'.($key+2), empty($value['address'])?'待完善':$value['address']);
							$objPHPExcel->getActiveSheet()->setCellValue('E'.($key+2), round($value['money'],2).'元');
							$objPHPExcel->getActiveSheet()->setCellValue('F'.($key+2), date('Y-m-d H:i:s',$value['createtime']));
							$objPHPExcel->getActiveSheet()->setCellValue('G'.($key+2),date('Y-m-d H:i:s',$value['newjointime']));

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
			
			$up_list = pdo_fetchall("SELECT * FROM ".tablename($this->user_table)." WHERE  weid=:weid", array(':weid'=>$weid));
					

					
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
						$objPHPExcel->getActiveSheet()->setCellValue('E1', '总消费金额');
						$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('F1', '注册时间');
						$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
						$objPHPExcel->getActiveSheet()->setCellValue('G1', '最近登录时间');
						$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
						foreach ($up_list as $key => $value) {
							$value['money'] = pdo_fetchcolumn("SELECT SUM(money) FROM ".tablename($this->pinglun_table)." WHERE openid=:openid AND weid=:weid",array(':openid'=>$value['openid'],':weid'=>$weid));
							$objPHPExcel->getActiveSheet()->setCellValue('A'.($key+2), ' '.$value['nickname']);
							$objPHPExcel->getActiveSheet()->setCellValue('B'.($key+2), empty($value['realname'])?'待完善':$value['realname']);
							$objPHPExcel->getActiveSheet()->setCellValue('C'.($key+2), empty($value['mobile'])?'待完善':$value['mobile']);
							$objPHPExcel->getActiveSheet()->setCellValue('D'.($key+2), empty($value['address'])?'待完善':$value['address']);
							$objPHPExcel->getActiveSheet()->setCellValue('E'.($key+2), round($value['money'],2).'元');
							$objPHPExcel->getActiveSheet()->setCellValue('F'.($key+2), date('Y-m-d H:i:s',$value['createtime']));
							$objPHPExcel->getActiveSheet()->setCellValue('G'.($key+2),date('Y-m-d H:i:s',$value['newjointime']));

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
include $this->template('fans_manage');