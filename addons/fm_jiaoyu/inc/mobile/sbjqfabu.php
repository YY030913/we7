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
        
        //查询是否用户登录		
		$userid = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where :schoolid = schoolid And :weid = weid And :openid = openid And :tid = tid", array(':weid' => $weid, ':schoolid' => $schoolid, ':openid' => $openid, ':tid' => 0), 'id');
		$it = pdo_fetch("SELECT * FROM " . tablename($this->table_user) . " where weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $weid, ':id' => $userid['id']));
		$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $it['sid']));
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $schoolid));
		
		$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE weid =  '{$_W['uniacid']}' AND schoolid ={$schoolid} ORDER BY sid ASC, ssort DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'sid');
				
        $bj_id = $category[$students['bj_id']]['sid'];
		
        $bjidname = $category[$students['bj_id']]['sname'];		
			
        $shenfen = "";
		
		if ($it['pard'] == 2){
			$shenfen = "母亲";
		}else if($it['pard'] == 3){	
		    $shenfen = "父亲";
		}else if($it['pard'] == 4){	
		    $shenfen = "本人";			
		}
			
        if(!empty($userid['id'])){
            
			//$isbzr = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $_W ['uniacid'], ':id' => $it['tid']));
			
		 include $this->template(''.$school['style2'].'/sbjqfabu');
         
		  }else{
         
		 include $this->template('bangding');
        
		}        
?>