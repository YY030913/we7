<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */

        global $_GPC, $_W;
        $GLOBALS['frames'] = $this->getNaveMenu();
		$weid = $this->_weid;
		load()->func('tpl');

		
		$schoolinfo = pdo_fetchall("SELECT * FROM " . tablename($this->table_index) . " WHERE weid = :weid", array(':weid' => $_W['uniacid']), 'id');
        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';    
        if ($operation == 'display') {

            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;

			$condition = '';
            if (!empty($_GPC['keyword'])) {
                $condition .= " AND name LIKE '%{$_GPC['keyword']}%'";
            }
			
            $where = "WHERE weid = '{$_W['uniacid']}'";
            $fenzulist = pdo_fetchall("SELECT * FROM " . tablename($this->table_group) . " {$where} $condition ORDER BY ssort DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            if (!empty($fenzulist)) {
                $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_group) . " $where");
                $pager = pagination($total, $pindex, $psize);  				
            }	

        } elseif ($operation == 'post') {
		    load()->func('tpl');
            $id = intval($_GPC['id']);
            $reply = pdo_fetch("select * from " . tablename($this->table_group) . " where id=:id and weid =:weid", array(':id' => $id, ':weid' => $_W['uniacid']));
			$school = pdo_fetchall("SELECT * FROM " . tablename($this->table_index) . " where weid = '{$_W['uniacid']}' ORDER BY ssort DESC", array(':weid' => $_W['uniacid']));
			
            if (checksubmit('submit')) {
                $data = array(
                    'weid' => intval($_W['uniacid']),
                    'schoolid' => intval($_GPC['schoolid']),
                    'name' => trim($_GPC['name']),
                    'group_desc' => trim($_GPC['group_desc']),
					'ssort' => intval($_GPC['order']),
                    'createtime' => time(),
                );

                if (istrlen($data['name']) == 0) {
                    message('没有输入分组名称.', '', 'error');
                }
                if (istrlen($data['name']) > 8) {
                    message('分组名称不能多于8个字。', '', 'error');
                }
                if (empty($_GPC['schoolid'])) {
                    message('请选择关联学校', '', 'error');
                }

                if (!empty($id)) {
                    unset($data['createtime']);
					$url = "https://api.weixin.qq.com/cgi-bin/groups/update?access_token=%s";
					$weixindata = "{\"group\":{\"id\":{$_GPC['group_id']},\"name\":\"{$_GPC['name']}\"}}";
					$fans = $this->weixin_fans_group($url, $weixindata);
					//pdo_update('fans_group', $data, array("id" => $_GPC['id']));					
                    pdo_update($this->table_group, $data, array('id' => $id, 'weid' => $_W['uniacid']));
                } else {
					$url = "https://api.weixin.qq.com/cgi-bin/groups/create?access_token=%s";
					$weixindata = "{\"group\":{\"name\":\"{$_GPC['name']}\"}}";
					$fans = $this->weixin_fans_group($url, $weixindata);
					$data["group_id"] = $fans['group']['id'];					
                    pdo_insert($this->table_group, $data);
                }
				message('操作成功', $this->createWebUrl('fenzu', array('op' => 'display')), 'success');
            }			
		} elseif ($operation == 'delete') {
		    $id = intval($_GPC['id']);
            $groups = pdo_fetch("SELECT id FROM " . tablename($this->table_group) . " WHERE id = '$id'");
			if (empty($_GPC['group_id'])) {
				message('group_id不得为空', $this->createWebUrl('fenzu', array('op' => 'display')), 'error');
			}
			$url = "https://api.weixin.qq.com/cgi-bin/groups/delete?access_token=%s";
			$weixindata = "{\"group\":{\"id\":{$_GPC['group_id']}}}";
			$this->weixin_fans_group($url, $weixindata);			
            pdo_delete($this->table_group, array('group_id' => $_GPC['group_id'], 'weid' => $_W['uniacid']));
            message('删除成功', $this->createWebUrl('fenzu', array('op' => 'display')), 'success');		
		} else if ($operation == "sync") {
			$url = "https://api.weixin.qq.com/cgi-bin/groups/get?access_token=%s";
			$weixindata = "";
			$ret = $this->weixin_fans_group($url, $weixindata);
			if ($ret && $ret['groups']) {
				$data = array('weid' => $_W['uniacid'], 'name' => $_GPC['name'], 'createtime' => time(), 'group_desc' => $_GPC['group_desc']);
				//pdo_delete($this->table_group, array('weid' => $_W['uniacid']));
				foreach ($ret['groups'] as $group) {
					$data["name"] = $group['name'];
					$data["count"] = $group['count'];
					pdo_update($this->table_group, $data, array('group_id' => $group['id'], 'weid' => $_W['uniacid']));
				}
				message('同步成功', $this->createWebUrl('fenzu'), 'success');
			} else {
				message('同步失败', $this->createWebUrl('fenzu'), 'fail');
			}
		}			
		
   include $this->template ( 'web/fenzu' );
?>