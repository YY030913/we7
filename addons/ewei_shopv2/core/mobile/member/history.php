<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class History_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		include $this->template();
	}

	public function get_list()
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$condition = ' and f.uniacid = :uniacid and f.openid=:openid and f.deleted=0';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_member_history') . ' f where 1 ' . $condition;
		$total = pdo_fetchcolumn($sql, $params);
		$sql = 'SELECT f.id,f.goodsid,g.title,g.thumb,g.marketprice,g.productprice,f.createtime FROM ' . tablename('ewei_shop_member_history') . ' f ' . ' left join ' . tablename('ewei_shop_goods') . ' g on f.goodsid = g.id ' . ' where 1 ' . $condition . ' ORDER BY `id` DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
		$list = pdo_fetchall($sql, $params);

		foreach ($list as &$row) {
			$row['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
			$row['thumb'] = tomedia($row['thumb']);
		}

		unset($row);
		show_json(1, array('list' => $list, 'total' => $total, 'pagesize' => $psize));
	}

	public function remove()
	{
		global $_W;
		global $_GPC;
		$ids = $_GPC['ids'];
		if (empty($ids) || !is_array($ids)) {
			show_json(0, '参数错误');
		}

		$sql = 'update ' . tablename('ewei_shop_member_history') . ' set deleted=1 where openid=:openid and id in (' . implode(',', $ids) . ')';
		pdo_query($sql, array(':openid' => $_W['openid']));
		show_json(1);
	}
}

?>
