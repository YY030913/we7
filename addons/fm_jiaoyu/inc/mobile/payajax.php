<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */global $_W, $_GPC;
   $operation = in_array ( $_GPC ['op'], array ('default','sigeup','deleteclass','creatorder') ) ? $_GPC ['op'] : 'default';

     if ($operation == 'default') {
	           die ( json_encode ( array (
			         'result' => false,
			         'msg' => '非法请求！'
	                ) ) );
              }			

	if ($operation == 'sigeup') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	         }
				  
        $setting = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_GPC['weid']));
		
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " WHERE :id = id", array(':id' => $_GPC['schoolid']));
		
		$user = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " WHERE :weid = weid And :schoolid = schoolid And :id = id", array(':weid' => $_GPC['weid'], ':schoolid' => $_GPC['schoolid'], ':id' => $_GPC['user']));
		
		$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE :weid = weid And :schoolid = schoolid And :id = id", array(':weid' => $_GPC['weid'], ':schoolid' => $_GPC['schoolid'], ':id' => $_GPC['sid']));
	    
		$cose = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE :weid = weid And :schoolid = schoolid And :id = id", array(':weid' => $_GPC['weid'], ':schoolid' => $_GPC['schoolid'], ':id' => $_GPC['kcid'])); 

		$issale = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE :weid = weid And :schoolid = schoolid And :kcid = kcid And :sid = sid", array(':weid' => $_GPC['weid'], ':schoolid' => $_GPC['schoolid'], ':kcid' => $_GPC['kcid'], ':sid' => $_GPC['sid'])); 
		
		$userinfo = iunserializer($user['userinfo']);
		
		if ($cose['xq_id'] != 0) {
			if ($cose['xq_id'] != $student['xq_id']) {
					die ( json_encode ( array (
						'result' => false,
						'msg' => '本课程只限本年级学生报名！'
						) ) );
            }					   
		}
		
		if (empty($userinfo['name'])) {
            die ( json_encode ( array (
                    'result' => false,
                    'msg' => '请前往个人中学完善您的联系方式'
		               ) ) );			
		}		
		
		if ($cose['yibao'] >= $cose['minge']) {
            die ( json_encode ( array (
                    'result' => false,
                    'msg' => '本课程已经报满'
		               ) ) );			
		}
		
		if (!empty($issale)) {
            die ( json_encode ( array (
                    'result' => false,
                    'msg' => '抱歉,您已报名本课程,请查看订单'
		               ) ) );			
		}		
		
		if (time() >= $cose['end']) {
            die ( json_encode ( array (
                    'result' => false,
                    'msg' => '本课程已经结束'
		               ) ) );
		}		
		
		if (empty($_GPC['openid'])) {
            die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求'
		               ) ) );			

		}else{
			
			$schoolid = $_GPC['schoolid'];
			
			$weid = $_GPC['weid'];
			
			$sid = $_GPC['sid'];
			
			$userid = $_GPC['uid'];
						
			$orderid = "{$userid}{$sid}";
			if ($school['issale'] == 1 || $school['issale'] == 2) {
			$temp = array(
					'weid' =>  $_GPC ['weid'],
					'schoolid' => $_GPC ['schoolid'],
					'sid' => $_GPC ['sid'],
					'userid' => $_GPC ['user'],
					'type' => 1,
					'status' => 1,
					'kcid' => $_GPC ['kcid'],
					'uid' => $_GPC['uid'],
					'cose' => $cose['cose'],
					'orderid' => $orderid,
					'createtime' => time(),
			);
			}
			if ($school['issale'] == 3 || $school['issale'] == 4) {
			$temp = array(
					'weid' =>  $_GPC ['weid'],
					'schoolid' => $_GPC ['schoolid'],
					'sid' => $_GPC ['sid'],
					'userid' => $_GPC ['user'],
					'type' => 2,
					'kcid' => $_GPC ['kcid'],
					'uid' => $_GPC['uid'],
					'cose' => $cose['cose'],
					'orderid' => $orderid,
					'createtime' => time(),
			);
			}			
			pdo_insert($this->table_order, $temp);
   
			$order_id = pdo_insertid();
						
			$data ['result'] = true;
			
			$data ['msg'] = '报名成功,请前往个人中心查看';

		 die ( json_encode ( $data ) );
		}
    }

	if ($operation == 'deleteclass') {
		$data = explode ( '|', $_GPC ['json'] );
		if (! $_GPC ['schoolid'] || ! $_GPC ['weid']) {
               die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
	         }
						 		 		 			  				  
		if (empty($_GPC['openid'])) {
                  die ( json_encode ( array (
                    'result' => false,
                    'msg' => '非法请求！' 
		               ) ) );
		}else{
			
			pdo_delete($this->table_order, array('id' => $_GPC['kcid']));	
   			
			$data ['result'] = true;
			
			$data ['msg'] = '删除成功！';	
			
          die ( json_encode ( $data ) );
		  
		}
    }
	if ($operation == 'creatorder') {
		$data = explode ( '|', $_GPC ['json'] );
				
		$od1 = $_GPC ['od1'];
		$od2 = $_GPC ['od2'];
		$od3 = $_GPC ['od3'];
		$od4 = $_GPC ['od4'];
		$od5 = $_GPC ['od5'];
		$kc1 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid AND schoolid=:schoolid AND id=:id ORDER BY id DESC", array(':weid' => $_GPC ['weid'], ':schoolid' => $_GPC ['schoolid'], ':id' => $od1)); 
        $kc2 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid AND schoolid=:schoolid AND id=:id ORDER BY id DESC", array(':weid' => $_GPC ['weid'], ':schoolid' => $_GPC ['schoolid'], ':id' => $od2));			
		$kc3 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid AND schoolid=:schoolid AND id=:id ORDER BY id DESC", array(':weid' => $_GPC ['weid'], ':schoolid' => $_GPC ['schoolid'], ':id' => $od3));			
		$kc4 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid AND schoolid=:schoolid AND id=:id ORDER BY id DESC", array(':weid' => $_GPC ['weid'], ':schoolid' => $_GPC ['schoolid'], ':id' => $od4));
		$kc5 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid AND schoolid=:schoolid AND id=:id ORDER BY id DESC", array(':weid' => $_GPC ['weid'], ':schoolid' => $_GPC ['schoolid'], ':id' => $od5));
        $cose = $kc1['cose'] + $kc2['cose'] + $kc3['cose'] + $kc4['cose'] + $kc5['cose'];
		
		$temp = array(
		   'weid' => $_GPC ['weid'],
           'schoolid' => $_GPC ['schoolid'],	   
		   'od1' => $od1,
		   'od2' => $od2,
		   'od3' => $od3,
		   'od4' => $od4,
		   'od5' => $od5,
		   'cose' => $cose,
		  'status'=>1
		);
						 		 		 			  				  	
		pdo_insert($this->table_wxpay, $temp);
			
		$wxpay_id = pdo_insertid();	
   			
		$data ['result'] = true;
		$url = $this->createMobileUrl('pay', array('schoolid' => $_GPC['schoolid'], 'cose' => $cose, 'wxpay' => $wxpay_id));		
		$data ['msg'] = $url;
						
        die ( json_encode ( $data ) );
    }	
?>