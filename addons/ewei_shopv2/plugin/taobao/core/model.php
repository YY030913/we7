<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class TaobaoModel extends PluginModel
{
	public function get_item_taobao($itemid = '', $taobaourl = '', $pcate = 0, $ccate = 0, $tcate = 0)
	{
		global $_W;
		$g = pdo_fetch('select * from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and taobaoid=:taobaoid limit 1', array(':uniacid' => $_W['uniacid'], ':taobaoid' => $itemid));

		if ($g) {
		}

		$url = $this->get_info_url($itemid);
		load()->func('communication');
		$response = ihttp_get($url);

		if (!isset($response['content'])) {
			return array('result' => '0', 'error' => '未从淘宝获取到商品信息!');
		}

		$content = $response['content'];

		if (strexists($response['content'], 'ERRCODE_QUERY_DETAIL_FAIL')) {
			return array('result' => '0', 'error' => '宝贝不存在!');
		}

		$arr = json_decode($content, true);
		$data = $arr['data'];
		$itemInfoModel = $data['itemInfoModel'];
		$item = array();
		$item['id'] = $g['id'];
		$item['pcate'] = $pcate;
		$item['ccate'] = $ccate;
		$item['tcate'] = $tcate;
		$item['cates'] = $pcate . ',' . $ccate . ',' . $tcate;
		$item['itemId'] = $itemInfoModel['itemId'];
		$item['title'] = $itemInfoModel['title'];
		$item['pics'] = $itemInfoModel['picsPath'];
		$params = array();

		if (isset($data['props'])) {
			$props = $data['props'];

			foreach ($props as $pp) {
				$params[] = array('title' => $pp['name'], 'value' => $pp['value']);
			}
		}

		$item['params'] = $params;
		$specs = array();
		$options = array();

		if (isset($data['skuModel'])) {
			$skuModel = $data['skuModel'];

			if (isset($skuModel['skuProps'])) {
				$skuProps = $skuModel['skuProps'];

				foreach ($skuProps as $prop) {
					$spec_items = array();

					foreach ($prop['values'] as $spec_item) {
						$spec_items[] = array('valueId' => $spec_item['valueId'], 'title' => $spec_item['name'], 'thumb' => !empty($spec_item['imgUrl']) ? $this->save_image($spec_item['imgUrl']) : '');
					}

					$spec = array('propId' => $prop['propId'], 'title' => $prop['propName'], 'items' => $spec_items);
					$specs[] = $spec;
				}
			}

			if (isset($skuModel['ppathIdmap'])) {
				$ppathIdmap = $skuModel['ppathIdmap'];

				foreach ($ppathIdmap as $key => $skuId) {
					$option_specs = array();
					$m = explode(';', $key);

					foreach ($m as $v) {
						$mm = explode(':', $v);
						$option_specs[] = array('propId' => $mm[0], 'valueId' => $mm[1]);
					}

					$options[] = array('option_specs' => $option_specs, 'skuId' => $skuId, 'stock' => 0, 'marketprice' => 0, 'specs' => '');
				}
			}
		}

		$item['specs'] = $specs;
		$stack = $data['apiStack'][0]['value'];
		$value = json_decode($stack, true);
		$item1 = array();
		$data1 = $value['data'];
		$itemInfoModel1 = $data1['itemInfoModel'];
		$item['total'] = $itemInfoModel1['quantity'];
		$item['sales'] = $itemInfoModel1['totalSoldQuantity'];

		if (isset($data1['skuModel'])) {
			$skuModel1 = $data1['skuModel'];

			if (isset($skuModel1['skus'])) {
				$skus = $skuModel1['skus'];

				foreach ($skus as $key => $val) {
					$sku_id = $key;

					foreach ($options as &$o) {
						if ($o['skuId'] == $sku_id) {
							$o['stock'] = $val['quantity'];

							foreach ($val['priceUnits'] as $p) {
								$o['marketprice'] = $p['price'];
							}

							$titles = array();

							foreach ($o['option_specs'] as $osp) {
								foreach ($specs as $sp) {
									if ($sp['propId'] == $osp['propId']) {
										foreach ($sp['items'] as $spitem) {
											if ($spitem['valueId'] == $osp['valueId']) {
												$titles[] = $spitem['title'];
											}
										}
									}
								}
							}

							$o['title'] = $titles;
						}
					}

					unset($o);
				}
			}
			else {
				$mprice = 0;

				foreach ($itemInfoModel1['priceUnits'] as $p) {
					$mprice = $p['price'];
				}

				$item['marketprice'] = $mprice;
			}
		}
		else {
			$mprice = 0;

			foreach ($itemInfoModel1['priceUnits'] as $p) {
				$mprice = $p['price'];
			}

			$item['marketprice'] = $mprice;
		}

		$item['options'] = $options;
		$item['content'] = array();
		$url = $this->get_detail_url($itemid);
		load()->func('communication');
		$response = ihttp_get($url);
		$item['content'] = $response;
		return $this->save_goods($item, $taobaourl);
	}

	public function save_goods($item = array(), $taobaourl = '')
	{
		global $_W;
		$data = array('uniacid' => $_W['uniacid'], 'taobaoid' => $item['itemId'], 'taobaourl' => $taobaourl, 'title' => $item['title'], 'total' => $item['total'], 'marketprice' => $item['marketprice'], 'pcate' => $item['pcate'], 'ccate' => $item['ccate'], 'tcate' => $item['tcate'], 'cates' => $item['cates'], 'sales' => $item['sales'], 'createtime' => time(), 'updatetime' => time(), 'hasoption' => 0 < count($item['options']) ? 1 : 0, 'status' => 0, 'deleted' => 0, 'buylevels' => '', 'showlevels' => '', 'buygroups' => '', 'showgroups' => '', 'noticeopenid' => '', 'storeids' => '');
		$thumb_url = array();
		$pics = $item['pics'];
		$piclen = count($pics);

		if (0 < $piclen) {
			$data['thumb'] = $this->save_image($pics[0]);

			if (1 < $piclen) {
				$i = 1;

				while ($i < $piclen) {
					$img = $this->save_image($pics[$i]);
					$thumb_url[] = $img;
					++$i;
				}
			}
		}

		$data['thumb_url'] = serialize($thumb_url);
		$goods = pdo_fetch('select * from ' . tablename('ewei_shop_goods') . ' where  taobaoid=:taobaoid and uniacid=:uniacid', array(':taobaoid' => $item['itemId'], ':uniacid' => $_W['uniacid']));

		if (empty($goods)) {
			pdo_insert('ewei_shop_goods', $data);
			$goodsid = pdo_insertid();
		}
		else {
			$goodsid = $goods['id'];
			unset($data['createtime']);
			pdo_update('ewei_shop_goods', $data, array('id' => $goodsid));
		}

		$goods_params = pdo_fetchall('select * from ' . tablename('ewei_shop_goods_param') . ' where goodsid=:goodsid ', array(':goodsid' => $goodsid));
		$params = $item['params'];
		$paramids = array();
		$displayorder = 0;

		foreach ($params as $p) {
			$oldp = pdo_fetch('select * from ' . tablename('ewei_shop_goods_param') . ' where goodsid=:goodsid and title=:title limit 1', array(':goodsid' => $goodsid, ':title' => $p['title']));
			$paramid = 0;
			$d = array('uniacid' => $_W['uniacid'], 'goodsid' => $goodsid, 'title' => $p['title'], 'value' => $p['value'], 'displayorder' => $displayorder);

			if (empty($oldp)) {
				pdo_insert('ewei_shop_goods_param', $d);
				$paramid = pdo_insertid();
			}
			else {
				pdo_update('ewei_shop_goods_param', $d, array('id' => $oldp['id']));
				$paramid = $oldp['id'];
			}

			$paramids[] = $paramid;
			++$displayorder;
		}

		if (0 < count($paramids)) {
			pdo_query('delete from ' . tablename('ewei_shop_goods_param') . ' where goodsid=:goodsid and id not in (' . implode(',', $paramids) . ')', array(':goodsid' => $goodsid));
		}
		else {
			pdo_query('delete from ' . tablename('ewei_shop_goods_param') . ' where goodsid=:goodsid ', array(':goodsid' => $goodsid));
		}

		$specs = $item['specs'];
		$specids = array();
		$displayorder = 0;
		$newspecs = array();

		foreach ($specs as $spec) {
			$oldspec = pdo_fetch('select * from ' . tablename('ewei_shop_goods_spec') . ' where goodsid=:goodsid and propId=:propId limit 1', array(':goodsid' => $goodsid, ':propId' => $spec['propId']));
			$specid = 0;
			$d_spec = array('uniacid' => $_W['uniacid'], 'goodsid' => $goodsid, 'title' => $spec['title'], 'displayorder' => $displayorder, 'propId' => $spec['propId']);

			if (empty($oldspec)) {
				pdo_insert('ewei_shop_goods_spec', $d_spec);
				$specid = pdo_insertid();
			}
			else {
				pdo_update('ewei_shop_goods_spec', $d_spec, array('id' => $oldspec['id']));
				$specid = $oldspec['id'];
			}

			$d_spec['id'] = $specid;
			$specids[] = $specid;
			++$displayorder;
			$spec_items = $spec['items'];
			$spec_itemids = array();
			$displayorder_item = 0;
			$newspecitems = array();

			foreach ($spec_items as $spec_item) {
				$d = array('uniacid' => $_W['uniacid'], 'specid' => $specid, 'title' => $spec_item['title'], 'thumb' => $this->save_image($spec_item['thumb']), 'valueId' => $spec_item['valueId'], 'show' => 1, 'displayorder' => $displayorder_item);
				$oldspecitem = pdo_fetch('select * from ' . tablename('ewei_shop_goods_spec_item') . ' where specid=:specid and valueId=:valueId limit 1', array(':specid' => $specid, ':valueId' => $spec_item['valueId']));
				$spec_item_id = 0;

				if (empty($oldspecitem)) {
					pdo_insert('ewei_shop_goods_spec_item', $d);
					$spec_item_id = pdo_insertid();
				}
				else {
					pdo_update('ewei_shop_goods_spec_item', $d, array('id' => $oldspecitem['id']));
					$spec_item_id = $oldspecitem['id'];
				}

				++$displayorder_item;
				$spec_itemids[] = $spec_item_id;
				$d['id'] = $spec_item_id;
				$newspecitems[] = $d;
			}

			$d_spec['items'] = $newspecitems;
			$newspecs[] = $d_spec;

			if (0 < count($spec_itemids)) {
				pdo_query('delete from ' . tablename('ewei_shop_goods_spec_item') . ' where specid=:specid and id not in (' . implode(',', $spec_itemids) . ')', array(':specid' => $specid));
			}
			else {
				pdo_query('delete from ' . tablename('ewei_shop_goods_spec_item') . ' where specid=:specid ', array(':specid' => $specid));
			}

			pdo_update('ewei_shop_goods_spec', array('content' => serialize($spec_itemids)), array('id' => $oldspec['id']));
		}

		if (0 < count($specids)) {
			pdo_query('delete from ' . tablename('ewei_shop_goods_spec') . ' where goodsid=:goodsid and id not in (' . implode(',', $specids) . ')', array(':goodsid' => $goodsid));
		}
		else {
			pdo_query('delete from ' . tablename('ewei_shop_goods_spec') . ' where goodsid=:goodsid ', array(':goodsid' => $goodsid));
		}

		$minprice = 0;
		$options = $item['options'];

		if (0 < count($options)) {
			$minprice = $options[0]['marketprice'];
		}

		$optionids = array();
		$displayorder = 0;

		foreach ($options as $o) {
			$option_specs = $o['option_specs'];
			$ids = array();
			$valueIds = array();

			foreach ($option_specs as $os) {
				foreach ($newspecs as $nsp) {
					foreach ($nsp['items'] as $nspitem) {
						if ($nspitem['valueId'] == $os['valueId']) {
							$ids[] = $nspitem['id'];
							$valueIds[] = $nspitem['valueId'];
						}
					}
				}
			}

			$ids = implode('_', $ids);
			$valueIds = implode('_', $valueIds);
			$do = array('uniacid' => $_W['uniacid'], 'displayorder' => $displayorder, 'goodsid' => $goodsid, 'title' => implode('+', $o['title']), 'specs' => $ids, 'stock' => $o['stock'], 'marketprice' => $o['marketprice'], 'skuId' => $o['skuId']);

			if ($o['marketprice'] < $minprice) {
				$minprice = $o['marketprice'];
			}

			$oldoption = pdo_fetch('select * from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid and skuId=:skuId limit 1', array(':goodsid' => $goodsid, ':skuId' => $o['skuId']));
			$option_id = 0;

			if (empty($oldoption)) {
				pdo_insert('ewei_shop_goods_option', $do);
				$option_id = pdo_insertid();
			}
			else {
				pdo_update('ewei_shop_goods_option', $do, array('id' => $oldoption['id']));
				$option_id = $oldoption['id'];
			}

			++$displayorder;
			$optionids[] = $option_id;
		}

		if (0 < count($optionids)) {
			pdo_query('delete from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid and id not in (' . implode(',', $optionids) . ')', array(':goodsid' => $goodsid));
		}
		else {
			pdo_query('delete from ' . tablename('ewei_shop_goods_option') . ' where goodsid=:goodsid ', array(':goodsid' => $goodsid));
		}

		$response = $item['content'];
		$content = $response['content'];
		preg_match_all('/<img.*?src=[\\\'| \\"](.*?(?:[\\.gif|\\.jpg]?))[\\\'|\\"].*?[\\/]?>/', $content, $imgs);

		if (isset($imgs[1])) {
			foreach ($imgs[1] as $img) {
				$taobaoimg = $img;

				if (substr($taobaoimg, 0, 2) == '//') {
					$img = 'http://' . substr($img, 2);
				}

				$im = array('taobao' => $taobaoimg, 'system' => $this->save_image($img));
				$images[] = $im;
			}
		}

		preg_match('/tfsContent : \'(.*)\'/', $content, $html);
		$html = iconv('GBK', 'UTF-8', $html[1]);

		if (isset($images)) {
			foreach ($images as $img) {
				$html = str_replace($img['taobao'], $img['system'], $html);
			}
		}

		$hasoption = 0;

		if (0 < count($options)) {
			$hasoption = 1;
		}

		$d = array('content' => $html, 'hasoption' => $hasoption);

		if (0 < $minprice) {
			$d['marketprice'] = $minprice;
		}

		pdo_update('ewei_shop_goods', $d, array('id' => $goodsid));

		if ($d['hasoption']) {
			$sql = 'update ' . tablename('ewei_shop_goods') . " g set\r\n            g.minprice = (select min(marketprice) from " . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $goodsid . " and marketprice > 0),\r\n            g.maxprice = (select max(marketprice) from " . tablename('ewei_shop_goods_option') . ' where goodsid = ' . $goodsid . ")\r\n            where g.id = " . $goodsid . ' and g.hasoption=1';
		}
		else {
			$sql = 'update ' . tablename('ewei_shop_goods') . ' set minprice = marketprice,maxprice = marketprice where id = ' . $goodsid . ' and hasoption=0;';
		}

		pdo_query($sql);
		return array('result' => '1', 'goodsid' => $goodsid);
	}

	public function get_info_url($itemid)
	{
		return 'http://hws.m.taobao.com/cache/wdetail/5.0/?id=' . $itemid;
	}

	public function get_detail_url($itemid)
	{
		return 'http://hws.m.taobao.com/cache/wdesc/5.0/?id=' . $itemid;
	}

	public function check_remote_file_exists($url)
	{
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		$result = curl_exec($curl);
		$found = false;

		if ($result !== false) {
			$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

			if ($statusCode == 200) {
				$found = true;
			}
		}

		curl_close($curl);
		return $found;
	}

	public function save_image($url)
	{
		global $_W;
		$url = save_media($url, true);
		$ext = strrchr($url, '.');
		if (($ext != '.jpeg') && ($ext != '.gif') && ($ext != '.jpg') && ($ext != '.png')) {
			return '';
		}

		if (strexists($url, 'http://') || strexists($url, 'https://')) {
			if (!empty($_W['setting']['remote']['type'])) {
				$file = file_get_contents($url);
				$key = md5($file) . $ext;
				$local = ATTACHMENT_ROOT . 'ewei_shopv2_temp/';
				load()->func('file');

				if (!is_dir($local)) {
					mkdirs($local);
				}

				$filename = $local . $key;
				file_put_contents($filename, $file);
				$remotestatus = file_remote_upload('ewei_shopv2_temp/' . $key);

				if (is_error($remotestatus)) {
					message('远程附件上传失败，请检查配置并重新上传');
				}
				else {
					$remoteurl = tomedia('ewei_shopv2_temp/' . $key);
					return $remoteurl;
				}
			}
		}

		return $url;
	}

	public function get_pageno_url($url = '', $pageNo = 1)
	{
		$url .= '/search.htm?pageNo=' . $pageNo;
		return $url;
	}

	public function get_total_page($url = '', $taobao = false)
	{
		if (empty($url)) {
			return array('totalpage' => 0);
		}

		$content = $this->get_page_content($url);
		exit($content);
		$str = '';

		if ($taobao) {
			$str = '/<span class="page-info">(.*)<\\/span>/';
		}
		else {
			$str = '/<b class="ui-page-s-len">(.*)<\\/b>/';
		}

		preg_match($str, $content, $p);

		if (is_array($p)) {
			$pages = explode('/', $p[1]);
			return array('totalpage' => $pages[1]);
		}

		return array('totalpage' => 0);
	}

	public function httpGet($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 500);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_URL, $url);
		$res = curl_exec($curl);
		curl_close($curl);
		return $res;
	}

	public function get_page_content($url = '', $pageNo = 1)
	{
		if (empty($url)) {
			return array('totalpage' => 0);
		}

		$url = $this->get_pageno_url($url, $pageNo);
		load()->func('communication');
		$response = ihttp_get($url);

		if (!isset($response['content'])) {
			return array('result' => 0);
		}

		return $response['content'];
	}

	public function getRealURL($url)
	{
		if (function_exists('stream_context_set_default')) {
			stream_context_set_default(array(
	'http' => array('method' => 'HEAD')
	));
		}

		$header = get_headers($url, 1);
		if (strpos($header[0], '301') || strpos($header[0], '302')) {
			if (is_array($header['Location'])) {
				return $header['Location'][count($header['Location']) - 1];
			}

			return $header['Location'];
		}

		return $url;
	}

	public function get_pag_items($pageContent = '')
	{
		$str = '/data-id="(.*)"/U';
		preg_match_all($str, $pageContent, $items);

		if (isset($items[1])) {
			return $items[1];
		}

		return array();
	}
}

?>
