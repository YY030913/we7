<?php
global $_W,$_GPC;
$type = $_GPC['type'];

if($type=='oauth_pay'){
		$sl = $_GPC['ps'];
    $params = @json_decode(base64_decode($sl) , true);
		$pay_id  =  substr($params['uniontid'],10);
		if ($_GPC['done'] == '1') {
				$sql = 'SELECT * FROM ' . tablename($this->pinglun_table) . ' WHERE `id`=:id';
				$log = pdo_fetch($sql, array(
						':id' =>$pay_id 
				));
				if(empty($log)){
					die('错误订单'.$pay_id.'不存在或是已经被删除！');
				}
				$go_url = "index.php?c=entry&do=detail&m=meepo_online&i=".$log['weid']."&listid=".$log['listid'];
				header("location: " . $_W['siteroot'] . '/app/' . $go_url);	
				exit();
		}
		
		$sql = 'SELECT * FROM ' . tablename($this->pinglun_table) . ' WHERE `id`=:id';
    $log = pdo_fetch($sql, array(
        ':id' =>$pay_id 
    ));
		if(empty($log)){
			exit('错误订单不存在或是已经被删除！');
		}
    if (!empty($log) && $log['status'] != '0') {
        exit('这个订单已经支付成功, 不需要重复支付.');
    }
		$auth = sha1($sl . $_W['uniacid'] . $_W['config']['setting']['authkey']);
    if ($auth != $_GPC['auth']) {
        exit('参数传输错误.');
    }
		$setting = uni_setting($_W['uniacid'], array('payment'));
		if(!is_array($setting['payment']['wechat']) || !$setting['payment']['wechat']['switch']) {
			//pdo_delete($this->pinglun_table,array('id'=>$pay_id));
			exit('没有设定支付参数');
		}

		$wechat = $setting['payment']['wechat'];
		
		$sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `acid`=:acid';
		$row = pdo_fetch($sql, array(':acid' => $wechat['account']));
		$wechat['appid'] = $row['key'];
		$wechat['secret'] = $row['secret'];
		
		$wOpt = $this->wechat_oauth_build($params, $wechat);
		if (is_error($wOpt)) {
			//pdo_delete($this->pinglun_table,array('id'=>$pay_id));
			exit($wOpt['message']);
		}
		
	
		
	
}
?>
<script type="text/javascript">
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
	WeixinJSBridge.invoke('getBrandWCPayRequest', {
		'appId' : '<?php
echo $wOpt['appId']; ?>',
		'timeStamp': '<?php
echo $wOpt['timeStamp']; ?>',
		'nonceStr' : '<?php
echo $wOpt['nonceStr']; ?>',
		'package' : '<?php
echo $wOpt['package']; ?>',
		'signType' : '<?php
echo $wOpt['signType']; ?>',
		'paySign' : '<?php
echo $wOpt['paySign']; ?>'
	}, function(res) {
		if(res.err_msg == 'get_brand_wcpay_request:ok') {
				location.search += '&done=1';
		} else {
				alert(res.err_code + res.err_desc + res.err_msg);
				history.go(-1);
		}
	});
}, false);
</script>