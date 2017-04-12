<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'creditshop/core/page_mobile.php';
class Index_EweiShopV2Page extends CreditshopMobilePage
{
	public function main()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$uniacid = $_W['uniacid'];
		$shop = m('common')->getSysset('shop');
		$advs = pdo_fetchall('select id,advname,link,thumb from ' . tablename('ewei_shop_creditshop_adv') . ' where uniacid=:uniacid and enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$advs = set_medias($advs, 'thumb');
		$credit = m('member')->getCredit($openid, 'credit1');
		$category = pdo_fetchall('select id,name,thumb,isrecommand from ' . tablename('ewei_shop_creditshop_category') . ' where uniacid=:uniacid and  enabled=1 order by displayorder desc', array(':uniacid' => $uniacid));
		$category = set_medias($category, 'thumb');
		$tops = pdo_fetchall('select id,title,subtitle,credit,thumb,type from ' . tablename('ewei_shop_creditshop_goods') . ' where uniacid=:uniacid and istop=1 and  status=1 and deleted=0 order by displayorder desc', array(':uniacid' => $uniacid));
		$tops = set_medias($tops, 'thumb');
		$times = pdo_fetchall('select id,title,subtitle,credit,thumb,type from ' . tablename('ewei_shop_creditshop_goods') . ' where uniacid=:uniacid and istime=1 and timestart<:nowtime and timeend>:nowtime and status=1 and deleted=0  order by displayorder desc limit 10', array(':nowtime' => time(), ':uniacid' => $uniacid));
		$times = set_medias($times, 'thumb');
		$recommands = pdo_fetchall('select id,title,credit,subtitle,thumb,type from ' . tablename('ewei_shop_creditshop_goods') . ' where uniacid=:uniacid and isrecommand=1 and status=1 and deleted=0  order by displayorder desc limit 10', array(':uniacid' => $uniacid));
		$recommands = set_medias($recommands, 'thumb');
		$member = m('member')->getMember($openid);
		$groupid = intval($member['groupid']);
		$levelid = intval($member['level']);
		$vips = pdo_fetchall('select id,title,credit,subtitle,thumb,type from ' . tablename('ewei_shop_creditshop_goods') . ' ' . ' where uniacid=:uniacid ' . ' and ( FIND_IN_SET( ' . $levelid . ',showlevels)<>0 or FIND_IN_SET( ' . $groupid . ',showgroups)<>0 ) ' . ' and status=1 and deleted=0 order by displayorder desc limit 10', array(':uniacid' => $uniacid));
		$vips = set_medias($vips, 'thumb');
		$reccategory = array();

		foreach ($category as $c) {
			if (!empty($c['isrecommand'])) {
				$goods = pdo_fetchall('select id,title,subtitle,credit,thumb,type from ' . tablename('ewei_shop_creditshop_goods') . ' where uniacid=:uniacid and cate=:cate and isrecommand=1 and status=1 and deleted=0 order by displayorder desc limit 10', array(':uniacid' => $uniacid, ':cate' => $c['id']));
				$goods = set_medias($goods, 'thumb');
				$c['goods'] = $goods;
				$reccategory[] = $c;
			}
		}

		$_W['shopshare'] = array('title' => $this->set['share_title'], 'imgUrl' => tomedia($this->set['share_icon']), 'link' => mobileUrl('creditshop', array(), true), 'desc' => $this->set['share_desc']);
		$com = p('commission');

		if ($com) {
			$cset = $com->getSet();

			if (!empty($cset)) {
				if (($member['isagent'] == 1) && ($member['status'] == 1)) {
					$_W['shopshare']['link'] = mobileUrl('creditshop', array('mid' => $member['id']), true);
					if (empty($cset['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
						$trigger = true;
					}
				}
				else {
					if (!empty($_GPC['mid'])) {
						$_W['shopshare']['link'] = mobileUrl('creditshop/detail', array('mid' => $_GPC['mid']), true);
					}
				}
			}
		}

		include $this->template();
	}
}

?>
