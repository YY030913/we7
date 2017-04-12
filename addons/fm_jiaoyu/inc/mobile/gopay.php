<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_W, $_GPC;
        $weid = $this->weid;
        $from_user = $this->_fromuser;
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$data = explode ( ',', $_GPC ['str'] );
		
		$od1 = $data[0];
		$od2 = $data[1];
		$od3 = $data[2];
		$od4 = $data[3];
		$od5 = $data[4];
		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :tid = tid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':tid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $userid['id']));		
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id ORDER BY ssort DESC", array(':weid' => $weid, ':id' => $schoolid));
		
        if(!empty($userid['id'])){
            
            $kc1 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $od1)); 
			
			$kc2 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $od2));
			
			$kc3 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $od3));
			
			$kc4 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $od4));
			
			$kc5 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $od5));
            			
			$kecheng = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
		    
			$teacher = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
			
		
		 include $this->template(''.$school['style2'].'/gopay');
          }else{
         include $this->template('bangding');
          }        
?>