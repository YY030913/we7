<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Perm_EweiShopV2ComModel extends ComModel
{
	public function allPerms()
	{
		$perms = array('shop' => $this->perm_shop(), 'goods' => $this->perm_goods(), 'member' => $this->perm_member(), 'order' => $this->perm_order(), 'finance' => $this->perm_finance(), 'statistics' => $this->perm_statistics(), 'sysset' => $this->perm_sysset(), 'sale' => $this->perm_sale(), 'commission' => $this->perm_commission(), 'diyform' => $this->perm_diyform(), 'poster' => $this->perm_poster(), 'postera' => $this->perm_postera(), 'taobao' => $this->perm_taobao(), 'article' => $this->perm_article(), 'creditshop' => $this->perm_creditshop(), 'exhelper' => $this->perm_exhelper(), 'perm' => $this->perm_perm());
		return $perms;
	}

	protected function perm_shop()
	{
		return array(
	'text'          => '商城管理',
	'adv'           => array(
		'text'   => '幻灯片',
		'main'   => '查看列表',
		'view'   => '查看内容',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('displayorder' => 'edit', 'enabled' => 'edit')
		),
	'nav'           => array(
		'text'   => '首页导航图标',
		'main'   => '查看列表',
		'view'   => '查看内容',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('displayorder' => 'edit', 'status' => 'edit')
		),
	'banner'        => array(
		'text'   => '首页广告',
		'main'   => '查看列表',
		'view'   => '查看内容',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('displayorder' => 'edit', 'enabled' => 'edit', 'setswipe' => 'edit')
		),
	'cube'          => array('text' => '首页魔方', 'main' => '查看', 'edit' => '修改-log'),
	'recommand'     => array('text' => '首页商品推荐', 'main' => '编辑推荐商品-log', 'setstyle' => '设置商品组样式-log'),
	'sort'          => array('text' => '首页元素排版', 'main' => '修改-log'),
	'dispatch'      => array(
		'text'   => '配送方式',
		'main'   => '查看列表',
		'view'   => '查看内容',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('displayorder' => 'edit', 'enabled' => 'edit', 'setdefault' => 'edit')
		),
	'notice'        => array(
		'text'   => '公告',
		'main'   => '查看列表',
		'view'   => '查看内容',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('displayorder' => 'edit', 'status' => 'edit')
		),
	'comment'       => array('text' => '评价', 'main' => '查看列表', 'add' => '添加-log', 'edit' => '编辑-log', 'post' => '回复-log', 'delete' => '删除-log'),
	'refundaddress' => array(
		'text'   => '退货地址',
		'main'   => '查看列表',
		'view'   => '查看内容',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('setdefault' => 'edit')
		),
	'verify'        => $this->isopen('verify', true) && $this->is_perm_plugin('verify', true) ? array(
	'text'  => 'O2O核销',
	'saler' => array(
		'text'   => '店员管理',
		'main'   => '查看列表',
		'view'   => '查看内容',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('status' => 'edit')
		),
	'store' => array(
		'text'   => '门店管理',
		'main'   => '查看列表',
		'view'   => '查看内容',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('displayorder' => 'edit', 'status' => 'edit')
		),
	'set'   => array('text' => '关键词设置', 'main' => '查看', 'edit' => '编辑-log')
	) : array()
	);
	}

	protected function perm_goods()
	{
		return array(
	'text'     => '商品管理',
	'main'     => '浏览列表',
	'view'     => '查看详情',
	'add'      => '添加-log',
	'edit'     => '修改-log',
	'delete'   => '删除-log',
	'delete1'  => '彻底删除-log',
	'restore'  => '恢复到仓库-log',
	'xxx'      => array('status' => 'edit', 'property' => 'edit', 'change' => 'edit'),
	'category' => array(
		'text'   => '商品分类',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('enabled' => 'edit')
		),
	'virtual'  => $this->isopen('virtual', true) && $this->is_perm_plugin('virtual', true) ? array(
	'text'     => '虚拟卡密',
	'temp'     => array('text' => '卡密模板管理', 'view' => '浏览', 'add' => '添加-log', 'edit' => '修改-log', 'delete' => '删除-log'),
	'category' => array('text' => '卡密分类管理', 'add' => '添加-log', 'edit' => '编辑-log', 'delete' => '删除-log'),
	'data'     => array('text' => '卡密数据', 'add' => '添加-log', 'edit' => '修改-log', 'delete' => '删除-log', 'export' => '导出-log', 'temp' => '下载模板', 'import' => '导入-log')
	) : array()
	);
	}

	protected function perm_member()
	{
		return array(
	'text'     => '会员管理',
	'group'    => array('text' => '会员组', 'main' => '查看列表', 'add' => '添加-log', 'edit' => '修改-log', 'delete' => '删除-log'),
	'level'    => array(
		'text'   => '会员等级',
		'main'   => '查看列表',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('enable' => 'edit')
		),
	'list'     => array(
		'text'   => '会员管理',
		'view'   => '浏览',
		'edit'   => '修改-log',
		'detail' => '查看修改资料-log',
		'delete' => '删除-log',
		'xxx'    => array('setblack' => 'edit')
		),
	'rank'     => array('text' => '排行榜', 'main' => '查看', 'edit' => '修改-log'),
	'tmessage' => array(
		'text' => '会员群发',
		'send' => '群发消息-log',
		'xxx'  => array('sendmessage' => 'send')
		)
	);
	}

	protected function perm_sale()
	{
		$array = array('text' => '营销', 'coupon' => $this->isopen('coupon', true) && $this->is_perm_plugin('coupon', true) ? array(
	'text'     => '优惠券管理',
	'view'     => '浏览',
	'add'      => '添加-log',
	'edit'     => '修改-log',
	'delete'   => '删除-log',
	'send'     => '发放-log',
	'set'      => '修改设置-log',
	'xxx'      => array('displayorder' => 'edit'),
	'category' => array('text' => '优惠券分类', 'main' => '查看', 'edit' => '修改-log'),
	'log'      => array('text' => '优惠券记录', 'main' => '查看', 'export' => '导出记录')
	) : array());
		if ($this->isopen('sale', true) && $this->is_perm_plugin('sale', true)) {
			$sale = array('deduct' => '修改抵扣设置-log', 'enough' => '修改满额立减-log', 'enoughfree' => '修改满额包邮-log', 'recharge' => '修改充值优惠设置-log');
			$array = array_merge($array, $sale);
		}

		return $array;
	}

	protected function perm_finance()
	{
		return array(
	'text'         => '财务管理',
	'log'          => array('text' => '财务管理', 'recharge' => '充值记录', 'withdraw' => '提现申请', 'refund' => '充值退款-log', 'wechat' => '微信提现-log', 'manual' => '手动提现-log', 'refuse' => '拒绝提现-log', 'recharge.export' => '充值记录导出-log', 'withdraw.export' => '提现申请导出-log'),
	'downloadbill' => array('text' => '对账单', 'main' => '下载-log'),
	'recharge'     => array('text' => '充值', 'credit1' => '充值积分-log', 'credit2' => '充值余额-log'),
	'credit'       => array('text' => '积分余额明细', 'credit1' => '积分明细', 'credit1.export' => '导出积分明细', 'credit2' => '余额明细', 'credit2.export' => '导出余额明细')
	);
	}

	protected function perm_statistics()
	{
		return array(
	'text'            => '数据统计',
	'sale'            => array('text' => '销售统计', 'main' => '查看', 'export' => '导出-log'),
	'sale_analysis'   => array('text' => '销售指标', 'main' => '查看'),
	'order'           => array('text' => '订单统计', 'main' => '查看', 'export' => '导出-log'),
	'goods'           => array('text' => '商品销售明细', 'main' => '查看', 'export' => '导出-log'),
	'goods_rank'      => array('text' => '商品销售排行', 'main' => '查看', 'export' => '导出-log'),
	'goods_trans'     => array('text' => '商品销售转化率', 'main' => '查看', 'export' => '导出-log'),
	'member_cost'     => array('text' => '会员消费排行', 'main' => '查看', 'export' => '导出-log'),
	'member_increase' => array('text' => '会员增长趋势', 'main' => '查看')
	);
	}

	protected function perm_order()
	{
		return array(
	'text'      => '订单',
	'detail'    => array('text' => '订单详情', 'edit' => '编辑'),
	'export'    => array(
		'text' => '自定义导出-log',
		'main' => '浏览页面',
		'xxx'  => array('save' => 'main', 'delete' => 'main', 'gettemplate' => 'main', 'reset' => 'main')
		),
	'batchsend' => array(
		'text' => '批量发货',
		'main' => '批量发货-log',
		'xxx'  => array('import' => 'main')
		),
	'list'      => array('text' => '订单管理', 'main' => '浏览全部订单', 'status_1' => '浏览关闭订单', 'status0' => '浏览待付款订单', 'status1' => '浏览已付款订单', 'status2' => '浏览已发货订单', 'status3' => '浏览完成的订单', 'status4' => '浏览退货申请订单', 'status5' => '浏览已退货订单'),
	'op'        => array(
		'text'          => '操作',
		'delete'        => '订单删除-log',
		'pay'           => '确认付款-log',
		'send'          => '发货-log',
		'sendcancel'    => '取消发货-log',
		'finish'        => '确认收货(快递单)-log',
		'verify'        => '确认核销(核销单)-log',
		'fetch'         => '确认取货(自提单)-log',
		'close'         => '关闭订单-log',
		'changeprice'   => '订单改价-log',
		'changeaddress' => '修改收货地址-log',
		'remarksaler'   => '订单备注-log',
		'paycancel'     => '订单取消付款-log',
		'fetchcancel'   => '订单取消取货-log',
		'changeexpress' => '修改快递状态',
		'refund'        => array('text' => '维权', 'main' => '维权信息', 'submit' => '提交维权申请')
		)
	);
	}

	protected function perm_sysset()
	{
		return array(
	'text'     => '设置',
	'shop'     => array('text' => '商城设置', 'main' => '查看', 'edit' => '修改-log'),
	'follow'   => array('text' => '分享及关注', 'main' => '查看', 'edit' => '修改-log'),
	'notice'   => array('text' => '消息提醒', 'edit' => '编辑-log'),
	'trade'    => array('text' => '交易设置', 'main' => '查看', 'edit' => '修改-log'),
	'payset'   => array('text' => '支付方式', 'edit' => '修改-log'),
	'templat'  => array('text' => '模板设置', 'main' => '查看', 'edit' => '修改-log'),
	'member'   => array('text' => '会员等级设置', 'main' => '查看', 'edit' => '修改-log'),
	'category' => array('text' => '分类层级', 'main' => '查看', 'edit' => '修改-log'),
	'contact'  => array('text' => '联系方式', 'main' => '查看', 'edit' => '修改-log'),
	'qiniu'    => $this->isopen('qiniu', true) && $this->is_perm_plugin('qiniu', true) ? array('text' => '七牛存储', 'main' => '查看', 'edit' => '修改-log') : array(),
	'close'    => array('text' => '商城关闭', 'main' => '查看', 'edit' => '修改-log'),
	'tmessage' => array('text' => '模板消息库', 'main' => '查看', 'add' => '添加-log', 'edit' => '修改-log', 'delete' => '删除-log'),
	'cover'    => array(
		'shop'     => array('text' => '商城入口', 'main' => '查看', 'edit' => '修改-log'),
		'member'   => array('text' => '会员中心入口', 'main' => '查看', 'edit' => '修改-log'),
		'favorite' => array('text' => '收藏入口', 'main' => '查看', 'edit' => '修改-log'),
		'cart'     => array('text' => '购物车入口', 'main' => '查看', 'edit' => '修改-log'),
		'order'    => array('text' => '订单入口', 'main' => '查看', 'edit' => '修改-log'),
		'coupon'   => array('text' => '优惠券入口', 'main' => '查看', 'edit' => '修改-log')
		)
	);
	}

	protected function perm_commission()
	{
		return $this->isopen('commission') && $this->is_perm_plugin('commission') ? array(
	'text'     => m('plugin')->getName('commission'),
	'agent'    => array(
		'text'   => '分销商管理',
		'main'   => '查看列表',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'user'   => '查看下线',
		'export' => '导出-log',
		'xxx'    => array('check' => 'edit', 'agentblack' => 'edit')
		),
	'level'    => array('text' => '分销商等级', 'main' => '查看列表', 'add' => '添加-log', 'edit' => '修改-log', 'delete' => '删除-log'),
	'apply'    => array('text' => '佣金审核', 'view1' => '待审核浏览', 'view2' => '待打款浏览', 'view3' => '已打款浏览', 'view_1' => '无效佣金浏览', 'detail' => '详细佣金', 'check' => '审核-log', 'pay' => '打款-log', 'cancel' => '重新审核-log', 'refuse' => '驳回申请-log', 'changecommission' => '修改佣金-log'),
	'increase' => array('text' => '分销商趋势图', 'main' => '查看'),
	'rank'     => array('text' => '佣金排行榜', 'main' => '查看', 'edit' => '修改-log', 'delete' => 'edit'),
	'notice'   => array('text' => '通知设置', 'main' => '查看', 'edit' => '修改-log'),
	'cover'    => array('text' => '入口设置', 'main' => '查看', 'edit' => '修改-log'),
	'set'      => array('text' => '基本设置', 'main' => '查看', 'edit' => '修改-log')
	) : array();
	}

	protected function perm_diyform()
	{
		return $this->isopen('diyform') && $this->is_perm_plugin('diyform') ? array(
	'text'     => m('plugin')->getName('diyform'),
	'temp'     => array('text' => '模板', 'main' => '查看列表', 'view' => '查看', 'add' => '添加-log', 'edit' => '修改-log', 'delete' => '删除-log'),
	'data'     => array('text' => '数据', 'main' => '查看'),
	'category' => array(
		'text' => '分类',
		'main' => '查看',
		'edit' => '修改-log',
		'xxx'  => array('delete' => 'edit', 'add' => 'edit')
		),
	'set'      => array('text' => '设置', 'main' => '查看', 'edit' => '修改-log')
	) : array();
	}

	protected function perm_poster()
	{
		return $this->isopen('poster') && $this->is_perm_plugin('poster') ? array(
	'text'   => m('plugin')->getName('poster'),
	'main'   => '查看列表',
	'view'   => '查看',
	'add'    => '添加-log',
	'edit'   => '修改-log',
	'delete' => '删除-log',
	'clear'  => '清除缓存-log',
	'xxx'    => array('setdefault' => 'edit'),
	'log'    => array('text' => '关注记录', 'main' => '查看'),
	'scan'   => array('text' => '扫描记录', 'main' => '查看')
	) : array();
	}

	protected function perm_postera()
	{
		return $this->isopen('postera') && $this->is_perm_plugin('postera') ? array(
	'text'   => m('plugin')->getName('postera'),
	'main'   => '查看列表',
	'view'   => '查看',
	'add'    => '添加-log',
	'edit'   => '修改-log',
	'delete' => '删除-log',
	'clear'  => '清除缓存-log',
	'xxx'    => array('setdefault' => 'edit'),
	'log'    => array('text' => '关注记录', 'main' => '查看')
	) : array();
	}

	protected function perm_taobao()
	{
		return $this->isopen('taobao') && $this->is_perm_plugin('taobao') ? array('text' => m('plugin')->getName('taobao'), 'main' => '获取宝贝') : array();
	}

	protected function perm_article()
	{
		return $this->isopen('article') && $this->is_perm_plugin('article') ? array(
	'text'     => m('plugin')->getName('article'),
	'main'     => '查看列表',
	'add'      => '添加-log',
	'edit'     => '修改-log',
	'delete'   => '删除-log',
	'record'   => '查看统计',
	'xxx'      => array('displayorder' => 'edit', 'state' => 'edit'),
	'category' => array('text' => '分类管理', 'main' => '查看', 'edit' => '修改-log', 'delete' => '删除-log'),
	'report'   => array('text' => '举报记录', 'main' => '查看'),
	'set'      => array('text' => '其他设置', 'view' => '查看', 'edit' => '修改-log')
	) : array();
	}

	protected function perm_creditshop()
	{
		return $this->isopen('creditshop') && $this->is_perm_plugin('creditshop') ? array(
	'text'     => m('plugin')->getName('creditshop'),
	'goods'    => array(
		'text'   => '商品',
		'main'   => '查看列表',
		'view'   => '查看详细',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('property' => 'edit')
		),
	'category' => array(
		'text'   => '分类',
		'main'   => '查看列表',
		'view'   => '查看详细',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('enabled' => 'edit', 'displayorder' => 'edit')
		),
	'adv'      => array(
		'text'   => '幻灯片',
		'main'   => '查看列表',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'view'   => '查看详细',
		'delete' => '删除-log',
		'xxx'    => array('displayorder' => 'edit', 'enabled' => 'edit')
		),
	'log'      => array('text' => '兑换记录', 'main' => '查看', 'detail' => '详情', 'exchange' => '确认兑换-log', 'export' => '导出明细-log'),
	'cover'    => array('text' => '入口设置', 'main' => '查看', 'edit' => '修改-log'),
	'notice'   => array('text' => '通知设置', 'main' => '查看', 'edit' => '修改-log'),
	'set'      => array('text' => '基础设置', 'main' => '查看', 'edit' => '修改-log')
	) : array();
	}

	protected function perm_exhelper()
	{
		return $this->isopen('exhelper') && $this->is_perm_plugin('exhelper') ? array(
	'text'     => m('plugin')->getName('exhelper'),
	'print'    => array(
		'single' => array('text' => '单个打印', 'express' => '打印快递单-log', 'invoice' => '打印发货单-log', 'dosend' => '一键发货-log'),
		'batch'  => array('text' => '批量打印', 'express' => '打印快递单-log', 'invoice' => '打印发货单-log', 'dosend' => '一键发货-log')
		),
	'temp'     => array(
		'express' => array(
			'text'   => '快递单模板管理',
			'add'    => '添加-log',
			'edit'   => '修改-log',
			'delete' => '删除-log',
			'xxx'    => array('setdefault' => 'edit')
			),
		'invoice' => array(
			'text'   => '发货单模板管理',
			'add'    => '添加-log',
			'edit'   => '修改-log',
			'delete' => '删除-log',
			'xxx'    => array('setdefault' => 'edit')
			)
		),
	'sender'   => array(
		'text'   => '发货人信息管理',
		'main'   => '查看列表',
		'view'   => '查看',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('setdefault' => 'edit')
		),
	'short'    => array('text' => '商品简称', 'main' => '查看', 'edit' => '修改-log'),
	'printset' => array('text' => '打印端口设置', 'main' => '查看', 'edit' => '修改-log')
	) : array();
	}

	protected function perm_perm()
	{
		return array(
	'text' => '权限系统',
	'log'  => array('text' => '操作日志', 'main' => '查看列表'),
	'role' => array(
		'text'   => '角色管理',
		'main'   => '查看列表',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('status' => 'edit', 'query' => 'main')
		),
	'user' => array(
		'text'   => '操作员管理',
		'main'   => '查看列表',
		'add'    => '添加-log',
		'edit'   => '修改-log',
		'delete' => '删除-log',
		'xxx'    => array('status' => 'edit')
		)
	);
	}

	public function isopen($pluginname = '', $iscom = false)
	{
		if (empty($pluginname)) {
			return false;
		}

		$plugins = m('plugin')->getAll($iscom);
		$plugins_name = array_map(function($val) {
			return $val['identity'];
		}, $plugins);

		if (in_array($pluginname, $plugins_name)) {
			foreach ($plugins as $plugin) {
				if ($plugin['identity'] == strtolower($pluginname)) {
					if (empty($plugin['status'])) {
						return false;
					}
				}
			}
		}
		else {
			return false;
		}

		return true;
	}

	public function is_perm_plugin($pluginname = '', $iscom = false)
	{
		global $_W;

		if (empty($pluginname)) {
			return false;
		}

		$perm_plugin = pdo_fetch('SELECT * FROM ' . tablename('ewei_shop_perm_plugin') . ' WHERE acid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));

		if (!empty($perm_plugin)) {
			$plugins = explode(',', $perm_plugin['plugins']);
			$coms = explode(',', $perm_plugin['coms']);

			if ($iscom) {
				return in_array($pluginname, $coms);
			}

			return in_array($pluginname, $plugins);
		}

		return true;
	}

	public function check_edit($permtype = '', $item = array())
	{
		if (empty($permtype)) {
			return false;
		}

		if (!$this->check_perm($permtype)) {
			return false;
		}

		if (empty($item['id'])) {
			$add_perm = $permtype . '.add';

			if (!$this->check($add_perm)) {
				return false;
			}

			return true;
		}

		$edit_perm = $permtype . '.edit';

		if (!$this->check($edit_perm)) {
			return false;
		}

		return true;
	}

	public function check_perm($permtypes = '')
	{
		global $_W;
		$check = true;

		if (empty($permtypes)) {
			return false;
		}

		if (!strexists($permtypes, '&') && !strexists($permtypes, '|')) {
			$check = $this->check($permtypes);
		}
		else if (strexists($permtypes, '&')) {
			$pts = explode('&', $permtypes);

			foreach ($pts as $pt) {
				$check = $this->check($pt);

				if (!$check) {
					break;
				}
			}
		}
		else {
			if (strexists($permtypes, '|')) {
				$pts = explode('|', $permtypes);

				foreach ($pts as $pt) {
					$check = $this->check($pt);

					if ($check) {
						break;
					}
				}
			}
		}

		return $check;
	}

	private function check($permtype = '')
	{
		global $_W;
		global $_GPC;
		if (($_W['role'] == 'manager') || ($_W['role'] == 'founder')) {
			return true;
		}

		$uid = $_W['uid'];

		if (empty($permtype)) {
			return false;
		}

		$user = pdo_fetch('select u.status as userstatus,r.status as rolestatus,u.perms2 as userperms,r.perms2 as roleperms,u.roleid from ' . tablename('ewei_shop_perm_user') . ' u ' . ' left join ' . tablename('ewei_shop_perm_role') . ' r on u.roleid = r.id ' . ' where u.uid=:uid limit 1 ', array(':uid' => $uid));
		if (empty($user) || empty($user['userstatus'])) {
			return false;
		}

		if (!empty($user['role']) && empty($user['rolestatus'])) {
			return false;
		}

		$role_perms = explode(',', $user['roleperms']);
		$user_perms = explode(',', $user['userperms']);
		$perms = array_merge($role_perms, $user_perms);

		if (empty($perms)) {
			return false;
		}

		$is_xxx = $this->check_xxx($permtype);

		if ($is_xxx) {
			if (!in_array($is_xxx, $perms)) {
				return false;
			}
		}
		else {
			if (!in_array($permtype, $perms)) {
				return false;
			}
		}

		return true;
	}

	public function check_xxx($permtype)
	{
		if ($permtype) {
			$allPerm = $this->allPerms();
			$permarr = explode('.', $permtype);

			if (isset($permarr[3])) {
				$is_xxx = (isset($allPerm[$permarr[0]][$permarr[1]][$permarr[2]]['xxx'][$permarr[3]]) ? $allPerm[$permarr[0]][$permarr[1]][$permarr[2]]['xxx'][$permarr[3]] : false);
			}
			else if (isset($permarr[2])) {
				$is_xxx = (isset($allPerm[$permarr[0]][$permarr[1]]['xxx'][$permarr[2]]) ? $allPerm[$permarr[0]][$permarr[1]]['xxx'][$permarr[2]] : false);
			}
			else if (isset($permarr[1])) {
				$is_xxx = (isset($allPerm[$permarr[0]]['xxx'][$permarr[1]]) ? $allPerm[$permarr[0]]['xxx'][$permarr[1]] : false);
			}
			else {
				$is_xxx = false;
			}

			if ($is_xxx) {
				$permarr = explode('.', $permtype);
				array_pop($permarr);
				$is_xxx = implode('.', $permarr) . '.' . $is_xxx;
			}

			return $is_xxx;
		}

		return false;
	}

	public function check_plugin($pluginname = '')
	{
		global $_W;
		global $_GPC;
		$permset = $this->getPermset();

		if (empty($permset)) {
			return true;
		}

		if (($_W['role'] == 'founder') || empty($_W['role'])) {
			return true;
		}

		$isopen = $this->isopen($pluginname);

		if (!$isopen) {
			return false;
		}

		$allow = true;
		$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		$ac_perm = pdo_fetch('select  plugins from ' . tablename('ewei_shop_perm_plugin') . ' where acid=:acid limit 1', array(':acid' => $acid));

		if (!empty($ac_perm)) {
			$allow_plugins = explode(',', $ac_perm['plugins']);

			if (!in_array($pluginname, $allow_plugins)) {
				$allow = false;
			}
		}
		else {
			load()->model('account');
			$accounts = uni_owned($_W['founder']);

			if (in_array($_W['uniacid'], array_keys($accounts))) {
				$allow = true;
			}
			else {
				$allow = false;
			}
		}

		if (!$allow) {
			return false;
		}

		return true;
	}

	public function getPermset()
	{
		$set = m('cache')->getString('permset2', 'global');

		if ($set == '') {
			m('cache')->set('permset2', 'false', 'global');
			return false;
		}

		return $set;
	}

	public function check_com($comname = '')
	{
		global $_W;
		global $_GPC;
		$permset = $this->getPermset();

		if (empty($permset)) {
			return true;
		}

		if (($_W['role'] == 'founder') || empty($_W['role'])) {
			return true;
		}

		$isopen = $this->isopen($comname, true);

		if (!$isopen) {
			return false;
		}

		$allow = true;
		$acid = pdo_fetchcolumn('SELECT acid FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid LIMIT 1', array(':uniacid' => $_W['uniacid']));
		$ac_perm = pdo_fetch('select  coms from ' . tablename('ewei_shop_perm_plugin') . ' where acid=:acid limit 1', array(':acid' => $acid));

		if (!empty($ac_perm)) {
			$allow_coms = explode(',', $ac_perm['coms']);

			if (!in_array($comname, $allow_coms)) {
				$allow = false;
			}
		}
		else {
			load()->model('account');
			$accounts = uni_owned($_W['founder']);

			if (in_array($_W['uniacid'], array_keys($accounts))) {
				$allow = true;
			}
			else {
				$allow = false;
			}
		}

		if (!$allow) {
			return false;
		}

		return true;
	}

	public function getLogName($type = '', $logtypes = NULL)
	{
		if (!$logtypes) {
			$logtypes = $this->getLogTypes();
		}

		foreach ($logtypes as $t) {
			if ($t['value'] == $type) {
				return $t['text'];
			}
		}

		return '';
	}

	public function getLogTypes($all = false)
	{
		$perms = $this->allPerms();
		$array = array();
		array_walk($perms, function($value, $key) use(&$array, $all) {
			if (is_array($value)) {
				array_walk($value, function($val, $ke) use(&$array, $value, $key, $all) {
					if (!is_array($val)) {
						if ($all) {
							if ($ke == 'text') {
								$text = str_replace('-log', '', $value['text']);
							}
							else {
								$text = str_replace('-log', '', $value['text'] . '-' . $val);
							}

							$array[] = array('text' => $text, 'value' => str_replace('.text', '', $key . '.' . $ke));
						}
						else {
							if (strexists($val, '-log')) {
								$text = str_replace('-log', '', $value['text'] . '-' . $val);

								if ($ke == 'text') {
									$text = str_replace('-log', '', $value['text']);
								}

								$array[] = array('text' => $text, 'value' => str_replace('.text', '', $key . '.' . $ke));
							}
						}
					}

					if (is_array($val) && ($ke != 'xxx')) {
						array_walk($val, function($v, $k) use(&$array, $value, $key, $val, $ke, $all) {
							if (!is_array($v)) {
								if ($all) {
									if ($ke == 'text') {
										$text = str_replace('-log', '', $value['text'] . '-' . $val['text']);
									}
									else {
										$text = str_replace('-log', '', $value['text'] . '-' . $val['text'] . '-' . $v);
									}

									$array[] = array('text' => $text, 'value' => str_replace('.text', '', $key . '.' . $ke . '.' . $k));
								}
								else {
									if (strexists($v, '-log')) {
										$text = str_replace('-log', '', $value['text'] . '-' . $val['text'] . '-' . $v);

										if ($k == 'text') {
											$text = str_replace('-log', '', $value['text'] . '-' . $val['text']);
										}

										$array[] = array('text' => $text, 'value' => str_replace('.text', '', $key . '.' . $ke . '.' . $k));
									}
								}
							}

							if (is_array($v) && ($k != 'xxx')) {
								array_walk($v, function($vv, $kk) use(&$array, $value, $key, $val, $ke, $v, $k, $all) {
									if (!is_array($vv)) {
										if ($all) {
											if ($ke == 'text') {
												$text = str_replace('-log', '', $value['text'] . '-' . $val['text'] . '-' . $v['text']);
											}
											else {
												$text = str_replace('-log', '', $value['text'] . '-' . $val['text'] . '-' . $v['text'] . '-' . $vv);
											}

											$array[] = array('text' => $text, 'value' => str_replace('.text', '', $key . '.' . $ke . '.' . $k . '.' . $kk));
											return NULL;
										}

										if (strexists($vv, '-log')) {
											if (empty($val['text'])) {
												$text = str_replace('-log', '', $value['text'] . '-' . $v['text'] . '-' . $vv);
											}
											else {
												$text = str_replace('-log', '', $value['text'] . '-' . $val['text'] . '-' . $v['text'] . '-' . $vv);
											}

											if ($kk == 'text') {
												$text = str_replace('-log', '', $value['text'] . '-' . $val['text'] . '-' . $v['text']);
											}

											$array[] = array('text' => $text, 'value' => str_replace('.text', '', $key . '.' . $ke . '.' . $k . '.' . $kk));
										}
									}
								});
							}
						});
					}
				});
			}
		});
		return $array;
	}

	public function log($type = '', $op = '')
	{
		global $_W;
		$this->check_xxx($type);

		if ($is_xxx = $this->check_xxx($type)) {
			$type = $is_xxx;
		}

		static $_logtypes;

		if (!$_logtypes) {
			$_logtypes = $this->getLogTypes();
		}

		$log = array('uniacid' => $_W['uniacid'], 'uid' => $_W['uid'], 'name' => $this->getLogName($type, $_logtypes), 'type' => $type, 'op' => $op, 'ip' => CLIENT_IP, 'createtime' => time());
		pdo_insert('ewei_shop_perm_log', $log);
	}

	public function formatPerms()
	{
		$perms = $this->allPerms();
		$array = array();
		array_walk($perms, function($value, $key) use(&$array) {
			if (is_array($value)) {
				array_walk($value, function($val, $ke) use(&$array, $key) {
					if (!is_array($val)) {
						$array['parent'][$key][$ke] = $val;
					}

					if (is_array($val) && ($ke != 'xxx')) {
						array_walk($val, function($v, $k) use(&$array, $key, $ke) {
							if (!is_array($v)) {
								$array['son'][$key][$ke][$k] = $v;
							}

							if (is_array($v) && ($k != 'xxx')) {
								array_walk($v, function($vv, $kk) use(&$array, $key, $ke, $k) {
									if (!is_array($vv)) {
										$array['grandson'][$key][$ke][$k][$kk] = $vv;
									}
								});
							}
						});
					}
				});
			}
		});
		return $array;
	}
}

?>
