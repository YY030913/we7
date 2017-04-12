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
		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :tid = tid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':tid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $userid['id']));	
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $schoolid));
		$rest = pdo_fetchcolumn("SELECT count(*) FROM ".tablename($this->table_order)." WHERE sid = {$it['sid']} And status = '1'");
		
		
        if(!empty($userid['id'])){
            
			$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $it['sid']));
			//$item = pdo_fetch("SELECT * FROM " . tablename ( 'mc_members' ) . " where uniacid = :uniacid AND uid=:uid ORDER BY uid DESC", array(':uid' => $it['uid'], ':uniacid' => $_W ['uniacid'])); 
       		//$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$_W['uniacid']}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'sid');
            
			$kecheng = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
		    
			$teacher = pdo_fetchall("SELECT * FROM " . tablename($this->table_teachers) . " WHERE :schoolid = schoolid And :weid = weid", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
			
			$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " where :schoolid = schoolid And :weid = weid And :sid = sid And :type = type ORDER BY createtime DESC", array(
		         ':weid' => $weid,
				 ':schoolid' => $schoolid,
				 ':sid' => $it['sid'],
				 ':type' => 1
				 ));
		    $list1 = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " where :schoolid = schoolid And :weid = weid And :sid = sid And :type = type And :status = status ORDER BY createtime DESC", array(
		         ':weid' => $weid,
				 ':schoolid' => $schoolid,
				 ':sid' => $it['sid'],
				 ':status' => 1,
				 ':type' => 1
				 ));
		    $list2 = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " where :schoolid = schoolid And :weid = weid And :sid = sid And :type = type And :status = status ORDER BY createtime DESC", array(
		         ':weid' => $weid,
				 ':schoolid' => $schoolid,
				 ':sid' => $it['sid'],
				 ':status' => 2,
				 ':type' => 1
				 ));
		    $list3 = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " where :schoolid = schoolid And :weid = weid And :sid = sid And :type = type And :status = status ORDER BY createtime DESC", array(
		         ':weid' => $weid,
				 ':schoolid' => $schoolid,
				 ':sid' => $it['sid'],
				 ':status' => 3,
				 ':type' => 1
				 ));				 
            $item = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = :id ", array(':id' => $id));
		
		 include $this->template(''.$school['style2'].'/order');
          }else{
         include $this->template('bangding');
          }        
?>