<?php
/**
 * 签到模块处理程序
 *
 * @author zhouchong
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Wei_qianModuleProcessor extends WeModuleProcessor {
	public function respond() {
		$content = $this->message['content'];
		//这里定义此模块进行消息处理时的具体过程, 请查看无妄文档来编写你的代码
	}
}