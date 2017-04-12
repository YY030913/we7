<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$allcategory = m('shop')->getCategory();
		$catlevel = intval($_W['shopset']['category']['level']);
		$opencategory = true;
		$plugin_commission = p('commission');
		if ($plugin_commission && (0 < intval($_W['shopset']['commission']['level']))) {
			$mid = intval($_GPC['mid']);

			if (!empty($mid)) {
				$shop = p('commission')->getShop($mid);

				if (empty($shop['selectcategory'])) {
					$opencategory = false;
				}
			}
		}

		include $this->template();
	}

	public function get_list()
	{
		global $_GPC;
		global $_W;
		$args = array('pagesize' => 10, 'page' => intval($_GPC['page']), 'isnew' => trim($_GPC['isnew']), 'ishot' => trim($_GPC['ishot']), 'isrecommand' => trim($_GPC['isrecommand']), 'isdiscount' => trim($_GPC['isdiscount']), 'istime' => trim($_GPC['istime']), 'issendfree' => trim($_GPC['issendfree']), 'keywords' => trim($_GPC['keywords']), 'cate' => trim($_GPC['cate']), 'order' => trim($_GPC['order']), 'by' => trim($_GPC['by']));

		if (isset($_GPC['nocommission'])) {
			$args['nocommission'] = intval($_GPC['nocommission']);
		}

		$plugin_commission = p('commission');
		if ($plugin_commission && (0 < intval($_W['shopset']['commission']['level']))) {
			$mid = intval($_GPC['mid']);

			if (!empty($mid)) {
				$shop = p('commission')->getShop($mid);

				if (!empty($shop['selectgoods'])) {
					$args['ids'] = $shop['goodsids'];
				}
			}
		}

		$goods = m('goods')->getList($args);
		show_json(1, array('list' => $goods['list'], 'total' => $goods['total'], 'pagesize' => $args['pagesize']));
	}

	public function query()
	{
		global $_GPC;
		global $_W;
		$args = array('pagesize' => 10, 'page' => intval($_GPC['page']), 'isnew' => trim($_GPC['isnew']), 'ishot' => trim($_GPC['ishot']), 'isrecommand' => trim($_GPC['isrecommand']), 'isdiscount' => trim($_GPC['isdiscount']), 'istime' => trim($_GPC['istime']), 'keywords' => trim($_GPC['keywords']), 'cate' => trim($_GPC['cate']), 'order' => trim($_GPC['order']), 'by' => trim($_GPC['by']));

		if (isset($_GPC['nocommission'])) {
			$args['nocommission'] = intval($_GPC['nocommission']);
		}

		$goods = m('goods')->getList($args);
		show_json(1, array('list' => $goods['list'], 'total' => $goods['total'], 'pagesize' => $args['pagesize']));
	}
}

?>
