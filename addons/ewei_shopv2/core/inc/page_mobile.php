<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class MobilePage extends Page
{
	public $footer = array();
	public $followBar = false;

	public function __construct()
	{
		global $_W;
		global $_GPC;
		m('shop')->checkClose();
		if (($_GPC['site'] == 'createStaticFile') && !is_weixin()) {
			$_W['openid'] = 'oOd-atwmqYv5YZaMd5k_0atIW9cA';
		}

		if (EWEI_SHOPV2_DEBUG) {
			$_W['openid'] = 'oOd-atwmqYv5YZaMd5k_0atIW9cA';
		}

		$member = m('member')->checkMember();
		$_W['mid'] = !empty($member) ? $member['id'] : '';
		$_W['mopenid'] = !empty($member) ? $member['openid'] : '';
	}

	public function followBar()
	{
		global $_W;
		global $_GPC;
		$openid = $_W['openid'];
		$followed = m('user')->followed($openid);
		$mid = intval($_GPC['mid']);
		$memberid = m('member')->getMid();
		@session_start();
		if (!$followed && ($memberid != $mid)) {
			$set = $_W['shopset'];
			$followbar = array('followurl' => $set['share']['followurl'], 'shoplogo' => tomedia($set['shop']['logo']), 'shopname' => $set['shop']['name'], 'qrcode' => tomedia($set['share']['followqrcode']), 'share_member' => false);
			$friend = false;

			if (!empty($mid)) {
				if (!empty($_SESSION[EWEI_SHOPV2_PREFIX . '_shareid']) && ($_SESSION[EWEI_SHOPV2_PREFIX . '_shareid'] == $mid)) {
					$mid = $_SESSION[EWEI_SHOPV2_PREFIX . '_shareid'];
				}

				$member = m('member')->getMember($mid);

				if (!empty($member)) {
					$_SESSION[EWEI_SHOP_PREFIX . '_shareid'] = $mid;
					$friend = true;
					$followbar['share_member'] = array('id' => $member['id'], 'nickname' => $member['nickname'], 'realname' => $member['realname'], 'avatar' => $member['avatar']);
				}
			}

			include $this->template('_followbar');
		}
	}

	public function footerMenus()
	{
		global $_W;
		global $_GPC;
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$cartcount = pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('ewei_shop_member_cart') . ' where uniacid=:uniacid and openid=:openid and deleted=0 and selected =1', $params);
		$commission = array();
		if (p('commission') && intval(0 < $_W['shopset']['commission']['level'])) {
			$member = m('member')->getMember($_W['openid']);

			if (!$member['agentblack']) {
				if (($member['isagent'] == 1) && ($member['status'] == 1)) {
					$commission = array('url' => mobileUrl('commission'), 'text' => empty($_W['shopset']['commission']['texts']['center']) ? '分销中心' : $_W['shopset']['commission']['texts']['center']);
				}
				else {
					$commission = array('url' => mobileUrl('commission/register'), 'text' => empty($_W['shopset']['commission']['texts']['become']) ? '成为分销商' : $_W['shopset']['commission']['texts']['become']);
				}
			}
		}

		include $this->template('_menu');
	}

	public function shopShare()
	{
		global $_W;
		global $_GPC;
		$trigger = false;

		if (empty($_W['shopshare'])) {
			$set = $_W['shopset'];
			$_W['shopshare'] = array('title' => empty($set['share']['title']) ? $set['shop']['name'] : $set['share']['title'], 'imgUrl' => empty($set['share']['icon']) ? tomedia($set['shop']['logo']) : tomedia($set['share']['icon']), 'desc' => empty($set['share']['desc']) ? $set['shop']['description'] : $set['share']['desc'], 'link' => mobileUrl('', NULL, true));
			$plugin_commission = p('commission');

			if ($plugin_commission) {
				$set = $plugin_commission->getSet();

				if (!empty($set['level'])) {
					$openid = $_W['openid'];
					$member = m('member')->getMember($openid);
					if (!empty($member) && ($member['status'] == 1) && ($member['isagent'] == 1)) {
						if (empty($set['closemyshop'])) {
							$myshop = $plugin_commission->getShop($member['id']);
							$_W['shopshare'] = array('title' => $myshop['name'], 'imgUrl' => tomedia($myshop['logo']), 'desc' => $myshop['desc'], 'link' => mobileUrl('commission/myshop', array('mid' => $member['id']), true));
						}
						else {
							$_W['shopshare']['link'] = mobileUrl('', array('mid' => $member['id']), true);
						}

						if (empty($set['become_reg']) && (empty($member['realname']) || empty($member['mobile']))) {
							$trigger = true;
						}
					}
					else {
						if (!empty($_GPC['mid'])) {
							$m = m('member')->getMember($_GPC['mid']);
							if (!empty($m) && ($m['status'] == 1) && ($m['isagent'] == 1)) {
								if (empty($set['closemyshop'])) {
									$myshop = $plugin_commission->getShop($_GPC['mid']);
									$_W['shopshare'] = array('title' => $myshop['name'], 'imgUrl' => tomedia($myshop['logo']), 'desc' => $myshop['desc'], 'link' => mobileUrl('commission/myshop', array('mid' => $member['id']), true));
								}
								else {
									$_W['shopshare']['link'] = mobileUrl('commission/myshop', array('mid' => $_GPC['mid']), true);
								}
							}
							else {
								$_W['shopshare']['link'] = mobileUrl('', array('mid' => $_GPC['mid']), true);
							}
						}
					}
				}
			}
		}

		return $trigger;
	}
}

?>
