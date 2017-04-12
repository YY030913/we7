<?php
defined('IN_IA') or exit('Access Denied');
include '../addons/bm_payx/phpqrcode.php';
class bm_payxModule extends WeModule
{
    public $weid;
    public function __construct()
    {
        global $_W;
        $this->weid = IMS_VERSION < 0.6 ? $_W['weid'] : $_W['uniacid'];
    }
    public function fieldsFormDisplay($rid = 0)
    {
        global $_W;
        if (!empty($rid)) {
            $dir = '../attachment/images/bm_payx';
            if (is_dir($dir)) {
            } else {
                mkdir("../attachment/images/bm_payx");
            }
            $reply = pdo_fetch("SELECT * FROM " . tablename('bm_payx_reply') . " WHERE rid = :rid ORDER BY `id` DESC", array(
                ':rid' => $rid
            ));
            if (empty($reply['qrcode'])) {
                if ($reply['qrtype'] == 0) {
                    $value                = $_W['siteroot'] . 'app/' . $this->createmobileurl('sign', array(
                        'rid' => $rid
                    ));
                    $errorCorrectionLevel = 'H';
                    $matrixPointSize      = '16';
                    $rand_file            = rand() . '.png';
                    $att_target_file      = 'qr-' . $rand_file;
                    $target_file          = '../attachment/images/bm_payx/' . $att_target_file;
                    QRcode::png($value, $target_file, $errorCorrectionLevel, $matrixPointSize);
                    $reply['qrcode'] = $target_file;
                } else {
                    $value                = $_W['siteroot'] . 'app/' . $this->createmobileurl('pay', array(
                        'rid' => $rid
                    ));
                    $errorCorrectionLevel = 'H';
                    $matrixPointSize      = '16';
                    $rand_file            = rand() . '.png';
                    $att_target_file      = 'qr-' . $rand_file;
                    $target_file          = '../attachment/images/bm_payx/' . $att_target_file;
                    QRcode::png($value, $target_file, $errorCorrectionLevel, $matrixPointSize);
                    $reply['qrcode'] = $target_file;
                }
            }
        }
        load()->func('tpl');
        include $this->template('form');
    }
    public function fieldsFormValidate($rid = 0)
    {
        return '';
    }
    public function fieldsFormSubmit($rid)
    {
        global $_W, $_GPC;
        $weid = $_W['uniacid'];
        $data = array(
            'rid' => $rid,
            'weid' => $weid,
            'n' => intval($_GPC['n']),
            'desc' => $_GPC['desc'],
            'pictype' => $_GPC['pictype'],
            'picurl' => $_GPC['picurl'],
            'urlx' => $_GPC['urlx'],
            'title' => $_GPC['title'],
            'starttime' => $_GPC['starttime'],
            'endtime' => $_GPC['endtime'],
            'qrcode' => $_GPC['qrcode'],
            'urly' => $_GPC['urly'],
            'url1' => $_GPC['url1'],
            'url2' => $_GPC['url2'],
            'memo1' => $_GPC['memo1'],
            'memo2' => $_GPC['memo2'],
            'play_times' => $_GPC['play_times'],
            'play_nums' => $_GPC['play_nums'],
            'play_type' => $_GPC['play_type'],
            'qrtype' => $_GPC['qrtype'],
            'qrmoney' => $_GPC['qrmoney'],
            'qrerrormemo' => $_GPC['qrerrormemo'],
            'qrerrorurl' => $_GPC['qrerrorurl'],
            'memo' => $_GPC['memo'],
            'qrinput' => $_GPC['qrinput'],
            'logo' => $_GPC['logo'],
            'templateid' => $_GPC['templateid'],
            'awaremethod' => $_GPC['awaremethod'],
            'awaretime' => $_GPC['awaretime'],
            'openid' => $_GPC['openid'],
            'templateid1' => $_GPC['templateid1'],
            'button' => $_GPC['button'],
            'tel' => $_GPC['tel'],
            'red' => $_GPC['red'],
            'redline' => $_GPC['redline'],
            'redlow' => $_GPC['redlow'],
            'redhigh' => $_GPC['redhigh'],
            'redrate' => $_GPC['redrate'],
            'button1' => $_GPC['button1'],
            'card' => $_GPC['card'],
            'cardline' => $_GPC['cardline'],
            'cardid' => $_GPC['cardid'],
            'cardname' => $_GPC['cardname'],
            'openid1' => $_GPC['openid1'],
            'headbg' => $_GPC['headbg'],
            'product' => $_GPC['product']
        );
        if ($_W['ispost']) {
            if (empty($_GPC['reply_id'])) {
                pdo_insert('bm_payx_reply', $data);
            } else {
                pdo_update('bm_payx_reply', $data, array(
                    'id' => $_GPC['reply_id']
                ));
            }
            message('更新成功', referer(), 'success');
        }
    }
    public function ruleDeleted($rid)
    {
        global $_W;
        $replies  = pdo_fetchall("SELECT *  FROM " . tablename('bm_payx_reply') . " WHERE rid = '$rid'");
        $deleteid = array();
        if (!empty($replies)) {
            foreach ($replies as $index => $row) {
                $deleteid[] = $row['id'];
            }
        }
        pdo_delete('bm_payx_reply', "id IN ('" . implode("','", $deleteid) . "')");
        return true;
    }
    public function settingsDisplay($settings)
    {
        global $_W, $_GPC;
        if (checksubmit()) {
            $filePath = dirname(preg_replace('@\(.*\(.*$@', '', preg_replace('@\(.*\(.*$@', '', __FILE__))) . '/cert/';
            if (($_FILES["rootca"]["size"] < 5000) && ($_FILES["rootca"]["size"] > 1)) {
                if ($_FILES["rootca"]["error"] > 0) {
                    message('rootca文件错误！', '', 'error');
                } else {
                    $filename   = $_FILES['rootca']['name'];
                    $tmp_name   = $_FILES['rootca']['tmp_name'];
                    $extend     = strrchr($filename, '.');
                    $uploadfile = $filePath . $filename . $_W['uniacid'];
                    $result     = move_uploaded_file($tmp_name, $uploadfile);
                }
            } else {
                message('rootca文件错误！', '', 'error');
            }
            if (($_FILES["apiclient_cert"]["size"] < 5000) && ($_FILES["apiclient_cert"]["size"] > 1)) {
                if ($_FILES["apiclient_cert"]["error"] > 0) {
                    message('rootca文件错误！', '', 'error');
                } else {
                    $filename   = $_FILES['apiclient_cert']['name'];
                    $tmp_name   = $_FILES['apiclient_cert']['tmp_name'];
                    $extend     = strrchr($filename, '.');
                    $uploadfile = $filePath . $filename . $_W['uniacid'];
                    $result     = move_uploaded_file($tmp_name, $uploadfile);
                }
            } else {
                message('rootca文件错误！', '', 'error');
            }
            if (($_FILES["apiclient_key"]["size"] < 5000) && ($_FILES["apiclient_key"]["size"] > 1)) {
                if ($_FILES["rootca"]["error"] > 0) {
                    message('rootca文件错误！', '', 'error');
                } else {
                    $filename   = $_FILES['apiclient_key']['name'];
                    $tmp_name   = $_FILES['apiclient_key']['tmp_name'];
                    $extend     = strrchr($filename, '.');
                    $uploadfile = $filePath . $filename . $_W['uniacid'];
                    $result     = move_uploaded_file($tmp_name, $uploadfile);
                }
            } else {
                message('rootca文件错误！', '', 'error');
            }
            $data = array(
                'rootca' => $_FILES['rootca']['name'],
                'apiclient_cert' => $_FILES['apiclient_cert']['name'],
                'apiclient_key' => $_FILES['apiclient_key']['name'],
                'srvip' => $_GPC['srvip']
            );
            if (!$this->saveSettings($data)) {
                message('保存信息失败', '', 'error');
            } else {
                message('保存信息成功', '', 'success');
            }
        }
        load()->func('tpl');
        include $this->template('setting');
    }
}
?><?php