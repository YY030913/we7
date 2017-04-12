<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
        global $_GPC, $_W;
        $GLOBALS['frames'] = $this->getNaveMenu();
        $weid = $this->_weid;
        $action = 'kecheng';
	    $schoolid = intval($_GPC['schoolid']);
		$kcid1 = intval($_GPC['kcid']);
		
		$school = pdo_fetch("SELECT * FROM " . tablename($this->table_index) . " where id = :id ORDER BY ssort DESC", array(':id' => $schoolid));
		
		$kecheng = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " where id = :id", array(':id' => $kcid1));

        $student = pdo_fetchall("SELECT * FROM " . tablename($this->table_students) . " WHERE weid =  '{$_W['uniacid']}' AND schoolid ={$schoolid} ORDER BY id ASC, id DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');

		$user = pdo_fetchall("SELECT * FROM " . tablename($this->table_user) . " WHERE weid =  '{$_W['uniacid']}' AND schoolid ={$schoolid} ORDER BY id ASC, id DESC", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
		
		
		
		$kc = pdo_fetchall("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE weid =  '{$_W['uniacid']}' AND schoolid ={$schoolid}", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid), 'id');
		
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
        if ($operation == 'post') {
            load()->func('tpl');
            $id = intval($_GPC['id']);
            if (!empty($id)) {
                $item = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = :id ", array(':id' => $id));
                if (empty($item)) {   
                    message('抱歉，本条信息不存在在或是已经删除！', '', 'error');
                }
            }
        } elseif ($operation == 'display') {

            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;
            $condition = '';
			
		    if (!empty($_GPC['name'])) {
                $condition .= " AND id LIKE '%{$_GPC['name']}%' ";
            }
						
            if (!empty($_GPC['kcid'])) {
                $kcid = intval($_GPC['kcid']);
                $condition .= " AND kcid = '{$kcid}'";
            }
			
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE weid = '{$_W['uniacid']}' AND schoolid ={$schoolid} $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);

            $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->table_order) . " WHERE weid = '{$_W['uniacid']}' AND schoolid ={$schoolid} $condition");

            $pager = pagination($total, $pindex, $psize);
        } elseif ($operation == 'delete') {
            $id = intval($_GPC['id']);
            if (empty($id)) {
                message('抱歉，本条信息不存在在或是已经被删除！');
            }
            pdo_delete($this->table_order, array('id' => $id));
            message('删除成功！', referer(), 'success');
        } elseif ($operation == 'deleteall') {
            $rowcount = 0;
            $notrowcount = 0;
            foreach ($_GPC['idArr'] as $k => $id) {
                $id = intval($id);
                if (!empty($id)) {
                    $goods = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = :id", array(':id' => $id));
                    if (empty($goods)) {
                        $notrowcount++;
                        continue;
                    }
                    pdo_delete($this->table_order, array('id' => $id, 'weid' => $_W['uniacid']));
                    $rowcount++;
                }
            }
            $this->message("操作成功！共删除{$rowcount}条数据,{$notrowcount}条数据不能删除!", '', 0);
        }	
        include $this->template ( 'web/baoming' );
?>