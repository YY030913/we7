<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Category_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		global $_W;
		$category_set = $_W['shopset']['category'];
		$category_set['advimg'] = tomedia($category_set['advimg']);

		if ($category_set['level'] == -1) {
			$this->message('暂时未开启分类', '', 'error');
		}

		$category = $this->getCategory($category_set['level']);
		include $this->template();
	}

	protected function getCategory($level)
	{
		$level = intval($level);
		$category = m('shop')->getCategory();
		$category_parent = array();
		$category_children = array();
		$category_grandchildren = array();
		array_walk($category['parent'], function($value) use(&$category_parent, &$category_children, &$category_grandchildren, $category, $level) {
			if ($value['enabled'] == 1) {
				$value['thumb'] = tomedia($value['thumb']);
				$value['advimg'] = tomedia($value['advimg']);
				$category_parent[$value['parentid']][] = $value;
				if (!empty($category['children'][$value['id']]) && (2 <= $level)) {
					array_walk($category['children'][$value['id']], function($val) use(&$category_children, &$category_grandchildren, $category, $level) {
						if ($val['enabled'] == 1) {
							$val['thumb'] = tomedia($val['thumb']);
							$val['advimg'] = tomedia($val['advimg']);
							$category_children[$val['parentid']][] = $val;
							if (!empty($category['children'][$val['id']]) && (3 <= $level)) {
								array_walk($category['children'][$val['id']], function($v) use(&$category_grandchildren) {
									if ($v['enabled'] == 1) {
										$v['thumb'] = tomedia($v['thumb']);
										$v['advimg'] = tomedia($v['advimg']);
										$category_grandchildren[$v['parentid']][] = $v;
									}
								});
							}
						}
					});
				}
			}
		});
		return array('parent' => $category_parent, 'children' => $category_children, 'grandchildren' => $category_grandchildren);
	}
}

?>
