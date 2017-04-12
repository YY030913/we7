<?php
defined('IN_IA') or exit('Access Denied');
include_once IA_ROOT . '/addons/amouse_article/model.php';
define('AMOUSE_ARTICLE', 'amouse_article');
define('RES', '../addons/' . AMOUSE_ARTICLE . '/style/');
require_once IA_ROOT . '/addons/amouse_article/WxPayPubHelper/WxPayPubHelper.php';
function get_timelineauction($pubtime)
{
    $time = time();
    if (idate('Y', $time) != idate('Y', $pubtime)) {
        return date('Y-m-d', $pubtime);
    }
    $seconds = $time - $pubtime;
    $days    = idate('z', $time) - idate('z', $pubtime);
    if ($days == 0) {
        if ($seconds < 3600) {
            if ($seconds < 60) {
                if (3 > $seconds) {
                    return '刚刚';
                } else {
                    return $seconds . '秒前';
                }
            }
            return intval($seconds / 60) . '分钟前';
        }
        return idate('H', $time) - idate('H', $pubtime) . '小时前';
    }
    if ($days == 1) {
        return '昨天 ' . date('H:i', $pubtime);
    }
    if ($days == 2) {
        return '前天 ' . date('H:i', $pubtime);
    }
    if ($days < 7) {
        return $days . '天前';
    }
    return date('n-j H:i', $pubtime);
}
class Amouse_articleModuleSite extends WeModuleSite
{
    public function __app($f_name)
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $set  = $this->getSysett($weid);
        include_once 'inc/app/' . strtolower(substr($f_name, 8)) . '.inc.php';
    }
    public function doMobileIndex()
    {
        $this->__app(__FUNCTION__);
    }
    public function doMobileSecond()
    {
        $this->__app(__FUNCTION__);
    }
    public function doMobileDetail()
    {
        $this->__app(__FUNCTION__);
    }
    public function doMobileJubao()
    {
        global $_GPC;
        $aid = $_GPC['artid'];
        include $this->template('report');
    }
    public function doMobileAjaxReport()
    {
        global $_GPC, $_W;
        $aid    = intval($_GPC['aid']);
        $openid = $_W['fans']['from_user'];
        if (empty($openid)) {
            $openid = getip();
        }
        $cate   = $_GPC['cate'];
        $cons   = $_GPC['cons'];
        $insert = array(
            'openid' => $openid,
            'aid' => $aid,
            'cate' => $cate,
            'cons' => $cons,
            'uniacid' => $_W['uniacid']
        );
        pdo_insert('fineness_article_report', $insert);
        die(json_encode(array(
            'result' => 'success'
        )));
    }
    public function doMobileComment()
    {
        $this->__app(__FUNCTION__);
    }
    public function doMobileAdmire()
    {
        $this->__app(__FUNCTION__);
    }
    public function doMobileLike()
    {
        global $_W, $_GPC;
        $weid      = $_W['uniacid'];
        $record_id = $_GPC['articleid'];
        $record    = pdo_fetch("SELECT * FROM " . tablename('fineness_article') . " WHERE id= $record_id ");
        if (empty($record)) {
            $res['ret'] = 501;
            return json_encode($res);
        }
        $openid = $_W['fans']['from_user'];
        if (empty($openid)) {
            $openid = getip();
        }
        if (!empty($record_id) && !empty($openid)) {
            $state = pdo_fetch("SELECT * FROM " . tablename('fineness_article_log') . " WHERE openid=:openid and aid=:aid and uniacid=:uniacid limit 1 ", array(
                ':openid' => $openid,
                ':aid' => $record_id,
                ':uniacid' => $weid
            ));
            if (empty($state['like'])) {
                pdo_update('fineness_article', 'zanNum=zanNum+1', array(
                    'id' => $record_id
                ));
                pdo_update('fineness_article_log', array(
                    'like' => $state['like'] + 1
                ), array(
                    'id' => $state['id']
                ));
                die(json_encode(array(
                    'result' => 200
                )));
            } else {
                pdo_update('fineness_article', 'zanNum=zanNum-1', array(
                    'id' => $record_id
                ));
                pdo_update('fineness_article_log', array(
                    'like' => $state['like'] - 1
                ), array(
                    'id' => $state['id']
                ));
                die(json_encode(array(
                    'result' => 201
                )));
            }
        }
    }
    public function doMobileAjaxcomment()
    {
        global $_W, $_GPC;
        $weid       = $_W['uniacid'];
        $aid        = $_GPC['articleid'];
        $set        = pdo_fetch("SELECT * FROM " . tablename('fineness_sysset') . " WHERE weid=:weid limit 1", array(
            ':weid' => $weid
        ));
        $follow_url = $set['guanzhuUrl'];
        $is_follow  = false;
        $record     = pdo_fetch("SELECT * FROM " . tablename('fineness_article') . " WHERE id= $aid ");
        if (empty($record)) {
            $res['code'] = 501;
            $res['msg']  = "文章不存在或者已经被删除。";
            return json_encode($res);
        }
        load()->model('mc');
        $openid   = $_W['fans']['from_user'];
        $acc      = WeiXinAccount::create($_W['acid']);
        $userinfo = $acc->fansQueryInfo($openid);
        if (empty($userinfo) && empty($userinfo['nickname'])) {
            $res['code'] = 202;
            $res['msg']  = "您还没有关注，请关注后参与。";
            return json_encode($res);
        }
        $data = array(
            'weid' => $weid,
            'js_cmt_input' => $_GPC['js_cmt_input'],
            'status' => 0,
            'aid' => $aid,
            'author' => $userinfo['nickname'],
            'thumb' => $userinfo['headimgurl'],
            'openid' => $userinfo['openid'],
            'createtime' => time()
        );
        if ($set && $set['iscomment'] == 1) {
            $data['status'] = 1;
        }
        pdo_insert('fineness_comment', $data);
        $res['code'] = 200;
        $res['msg']  = "评论成功，由公众帐号筛选后显示！";
        return json_encode($res);
    }
    public function doMobileDelComment()
    {
        global $_W, $_GPC;
        $commentid = $_GPC['commentid'];
        $record    = pdo_fetch("SELECT * FROM " . tablename('fineness_comment') . " WHERE id= $commentid ");
        if (empty($record)) {
            $res['code'] = 501;
            $res['msg']  = "记录不存在或者已经被删除。";
            return json_encode($res);
        }
        $temp        = pdo_delete("fineness_comment", array(
            'id' => $commentid
        ));
        $res['code'] = 200;
        $res['msg']  = '删除成功';
        return json_encode($res);
    }
    public function doMobileAjaxpraise()
    {
        global $_W, $_GPC;
        $commentid = $_GPC['commentid'];
        $weid      = $_W['uniacid'];
        $record    = pdo_fetch("SELECT * FROM " . tablename('fineness_comment') . " WHERE id= $commentid ");
        if (empty($record)) {
            $res['code'] = 501;
            $res['msg']  = "记录不存在或者已经被删除。";
            return json_encode($res);
        }
        $openid = $_W['fans']['from_user'];
        if (empty($openid)) {
            $openid = getip();
        }
        if (!empty($commentid) && !empty($openid)) {
            $state = pdo_fetch("SELECT * FROM " . tablename('fineness_article_log') . " WHERE openid=:openid and aid=:aid and uniacid=:uniacid limit 1 ", array(
                ':openid' => $openid,
                ':aid' => $commentid,
                ':uniacid' => $weid
            ));
            if (empty($state['comment'])) {
                pdo_update('fineness_comment', 'praise_num=praise_num+1', array(
                    'id' => $commentid
                ));
                pdo_update('fineness_article_log', array(
                    'comment' => $state['comment'] + 1
                ), array(
                    'id' => $state['id']
                ));
                die(json_encode(array(
                    'code' => 200
                )));
            } else {
                pdo_update('fineness_comment', 'praise_num=praise_num-1', array(
                    'id' => $commentid
                ));
                pdo_update('fineness_article_log', array(
                    'comment' => $state['comment'] - 1
                ), array(
                    'id' => $state['id']
                ));
                die(json_encode(array(
                    'code' => 201
                )));
            }
        }
    }
    public function doMobileAjaxPay()
    {
        global $_W, $_GPC;
        $price = $_GPC['price'];
        if ($price == 0) {
            $price = 0.01;
        }
        $uniacid = $_W['uniacid'];
        $set     = pdo_fetch("SELECT * FROM " . tablename('fineness_sysset') . " WHERE weid=:weid limit 1", array(
            ':weid' => $uniacid
        ));
        if (empty($set)) {
            $res['code'] = 501;
            $res['msg']  = "抱歉，基本参数没设置";
            return json_encode($res);
        }
        load()->model('mc');
        $userInfo = mc_oauth_userinfo();
        $jsApi    = new JsApi_pub($set);
        $jsApi->setOpenId($userInfo['openid']);
        $unifiedOrder = new UnifiedOrder_pub($set);
        $unifiedOrder->setParameter("openid", $userInfo['openid']);
        $unifiedOrder->setParameter("body", "赞赏");
        $timeStamp    = time();
        $out_trade_no = $set['appid'] . "$timeStamp";
        $unifiedOrder->setParameter("out_trade_no", $out_trade_no);
        $unifiedOrder->setParameter("total_fee", $price * 100);
        $notifyUrl = $_W['siteroot'] . "addons/" . AMOUSE_ARTICLE . "/notify.php";
        $unifiedOrder->setParameter("notify_url", $notifyUrl);
        $unifiedOrder->setParameter("trade_type", "JSAPI");
        $prepay_id = $unifiedOrder->getPrepayId();
        $jsApi->setPrepayId($prepay_id);
        $jsApiParameters = $jsApi->getParameters();
        $res['code']     = 200;
        $res['msg']      = $jsApiParameters;
        return json_encode($res);
    }
    public function doMobilePaySuccess()
    {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $price   = $_GPC['price'];
        $aid     = $_GPC['aid'];
        $article = pdo_fetch('select * from ' . tablename('fineness_article') . ' where weid=:weid AND id=:id', array(
            ':weid' => $uniacid,
            ':id' => $aid
        ));
        load()->model('mc');
        $userInfo = mc_oauth_userinfo();
        if (empty($userInfo) && empty($userInfo['nickname'])) {
            $res['code'] = 202;
            $res['msg']  = "您还没有关注，请关注后参与。";
            return json_encode($res);
        }
        load()->func('logging');
        if (!empty($article)) {
            $data = array(
                'weid' => $uniacid,
                'price' => $price,
                'aid' => $aid,
                'author' => $userInfo['nickname'],
                'thumb' => $userInfo['avatar'],
                'openid' => $userInfo['openid'],
                'createtime' => time()
            );
            pdo_insert('fineness_admire', $data);
        }
        $res['code'] = 200;
        $res['msg']  = 'sucess';
        return json_encode($res);
    }
    public function doMobileTuijian()
    {
        global $_GPC, $_W;
        $weid = $_W['uniacid'];
        $cfg  = $this->module['config'];
        $list = pdo_fetchall("SELECT * FROM " . tablename('wx_tuijian') . " WHERE weid=:weid ORDER BY createtime DESC ", array(
            ':weid' => $weid
        ));
        include $this->template('tuijian');
    }
    public function __web($f_name)
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        include_once 'inc/web/' . strtolower(substr($f_name, 5)) . '.inc.php';
    }
    public function doWebCategory()
    {
        $this->__web(__FUNCTION__);
    }
    public function doWebPaper()
    {
        $this->__web(__FUNCTION__);
    }
    public function doWebComment()
    {
        $this->__web(__FUNCTION__);
    }
    public function doWebSysset()
    {
        $this->__web(__FUNCTION__);
    }
    public function doWebHutui()
    {
        $this->__web(__FUNCTION__);
    }
    public function doWebSlide()
    {
        $this->__web(__FUNCTION__);
    }
    public function getSysett($weid)
    {
        return pdo_fetch("SELECT * FROM " . tablename('fineness_sysset') . " WHERE weid=:weid limit 1", array(
            ':weid' => $weid
        ));
    }
    public function doWebAdv()
    {
        $this->__web(__FUNCTION__);
    }
    public function doWebjiaocheng()
    {
        include $this->template('help');
    }
    public function get_contents($url)
    {
        $ch      = curl_init();
        $timeout = 100;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        return $file_contents;
    }
    public function cut($from, $start, $end, $lt = false, $gt = false)
    {
        $str = explode($start, $from);
        if (isset($str['1']) && $str['1'] != '') {
            $str  = explode($end, $str['1']);
            $strs = $str['0'];
        } else {
            $strs = '';
        }
        if ($lt) {
            $strs = $start . $strs;
        }
        if ($gt) {
            $strs .= $end;
        }
        return $strs;
    }
}
