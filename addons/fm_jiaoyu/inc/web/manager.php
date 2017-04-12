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

        $operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		$set = pdo_fetch("SELECT * FROM " . tablename($this->table_set) . " WHERE :weid = weid", array(':weid' => $_W['uniacid'])); 
		if ($operation == 'post') {
				$fansgroup = pdo_fetchall("SELECT * FROM " . tablename($this->table_group) . " WHERE weid = '{$_W['uniacid']}'");
				$group = pdo_fetch("select * from " . tablename($this->table_group) . " where id=:id and weid =:weid", array(':id' => $_GPC['group_id'], ':weid' => $_W['uniacid']));
                $qrinfo = pdo_fetch("select * from " . tablename($this->table_qrinfo) . " where group_id=:group_id and weid =:weid", array(':group_id' => $group['group_id'], ':weid' => $_W['uniacid']));
			if (checksubmit('submit')) {
				$barcode = array(
				'expire_seconds' => '',
				'action_name' => '',
				'action_info' => array(
								'scene' => array(
										'scene_id' => ''
										),
									),
								);
				$uniacccount = WeAccount::create($_W['uniacid']);
				$qrctype = 2;
				$id = intval($_GPC['id']);
				if (!empty($id)) {
						$qrcrow = pdo_fetch("SELECT * FROM " . tablename($this->table_qrinfo) . " WHERE id = '{$id}'");
						$update = array(
							'keyword' => $group['name'],
							'name' => $group['name'],
							'gpid' => $_GPC['group_id'],
							'status' => '1',
							);
						$barcode['action_info']['scene']['scene_id'] = $qrcrow['qrcid'];
						$barcode['action_name'] = 'QR_LIMIT_SCENE';
						$result = $uniacccount->barCodeCreateFixed($barcode);
					if (is_error($result)) {
						message($result['message'], referer(), 'fail');
					}
						$update['ticket'] = $result['ticket'];
						$update['show_url'] = $this->createImageUrlCenter("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $result['ticket'], $group['schoolid']);
						$update['group_id'] = $group['group_id'];
						$update['createtime'] = TIMESTAMP;
							$temp1 = array(
								'type' => 1
								);
						pdo_update($this->table_group, $temp1, array('id' => $_GPC['group_id']));
						pdo_update($this->table_qrinfo, $update, array('id' => $id));
						message('恭喜，更新带参数二维码成功！', $this->createWebUrl('manager'), 'success');
				}
				$qrcid = pdo_fetchcolumn("SELECT qrcid FROM " . tablename($this->table_qrinfo) . " WHERE model = '2' ORDER BY qrcid DESC");
				$barcode['action_info']['scene']['scene_id'] = !empty($qrcid) ? ($qrcid + 1) : 1;
				if ($barcode['action_info']['scene']['scene_id'] > 100000) {
				message('抱歉，永久二维码已经生成最大数量，请先删除一些。');
				}
				if (!empty($qrinfo)) {
				message('抱歉，该学校分组已经拥有独立二维码');
				}
				$barcode['action_name'] = 'QR_LIMIT_SCENE';
				$result = $uniacccount->barCodeCreateFixed($barcode);
				if (is_error($result)) {
				message($result['message'], referer(), 'fail');
				}
				
				if (!is_error($result)) {
					$insert = array(
					'weid' => $_W['weid'], 
					'qrcid' => $barcode['action_info']['scene']['scene_id'], 
					'keyword' => $group['name'],
					'gpid' => $_GPC['group_id'],
					'name' => $group['name'], 
					'model' => 2,
					'group_id' => $group['group_id'], 
					'ticket' => $result['ticket'], 
					'show_url' => $this->createImageUrlCenter("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $result['ticket'], $group['schoolid']), 
					'expire' => $result['expire_seconds'], 
					'createtime' => TIMESTAMP,
					'status' => '1',
					);
					$temp2 = array(
					'type' => 1
					);
				pdo_update($this->table_group, $temp2, array('id' => $_GPC['group_id']));
				pdo_insert($this->table_qrinfo, $insert);
				message('恭喜，生成带参数二维码成功！', $this->createWebUrl('manager'), 'success');
				} else {
				message("公众平台返回接口错误. <br />错误代码为: {$result['errorcode']} <br />错误信息为: {$result['message']}");
				}
			}
			$id = intval($_GPC['id']);
			$row = pdo_fetch("SELECT * FROM " . tablename($this->table_qrinfo) . " WHERE id = '{$id}'");
		} elseif ($operation == 'display') {
			
            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;

			$condition = '';
            if (!empty($_GPC['keyword'])) {
                $condition .= " AND keyword LIKE '%{$_GPC['keyword']}%'";
            }
			
            $where = "WHERE weid = '{$_W['uniacid']}'";
            $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_qrinfo) . " {$where} $condition ORDER BY qrcid DESC LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            if (!empty($list)) {
                $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_qrinfo) . " $where");
                $pager = pagination($total, $pindex, $psize);  				
            }			
			
		} elseif ($operation == 'delete') {
		
			$id = $_GPC['id'];
				$temp3 = array(
					'type' => 0
					);
			pdo_update($this->table_group, $temp3, array('id' => $_GPC['gpid']));			
			pdo_delete($this->table_qrinfo, array('id' => $id));
			//pdo_delete('qrcode_statinfo', array('qid' => $id));
			message('删除成功', $this->createWebUrl('manager'), 'success');

        }
		
   include $this->template ( 'web/manager' );
?>