<?php
defined('IN_IA') or exit('Access Denied');
define('ROOT_PATH', str_replace('site.php', '', str_replace('\\', '/', preg_replace('@\(.*\(.*$@', '', __FILE__))));
define('INC_PATH', ROOT_PATH . 'inc/');
class Dg_dragon_boatModuleSite extends WeModuleSite
{
    public function doWebManage()
    {
        global $_GPC, $_W;
        load()->model('reply');
        $pindex            = max(1, intval($_GPC['page']));
        $psize             = 20;
        $params            = array();
        $acid              = empty($_W['account']['acid']) ? $_W['uniacid'] : $_W['account']['acid'];
        $total             = pdo_fetchcolumn("SELECT count(id) FROM " . tablename('longzhou_reply') . " WHERE iacid=" . $acid);
        $sql               = "uniacid = :iacid AND `module` = :module";
        $params            = array();
        $params[':iacid']  = $acid;
        $params[':module'] = 'dg_dragon_boat';
        if (isset($_GPC['keywords'])) {
            $sql .= ' AND `huodongname` LIKE :keywords';
            $params[':keywords'] = "%{$_GPC['keywords']}%";
        }
        $list    = reply_search($sql, $params, $pindex, $psize, $total);
        $pager   = pagination($total, $pindex, $psize);
        $lzreply = "";
        if (!empty($list)) {
            foreach ($list as &$item) {
                $condition         = "`rid`={$item['id']}";
                $item['keywords']  = reply_keywords_search($condition);
                $lzreply           = pdo_fetch("SELECT * FROM " . tablename('longzhou_reply') . " WHERE rid = :rid", array(
                    ':rid' => $item['id']
                ));
                $item['starttime'] = date('Y-m-d H:i', $lzreply['start_time']);
                $endtime           = $lzreply['end_time'] + 86399;
                $item['endtime']   = date('Y-m-d H:i', $endtime);
                $nowtime           = time();
                if ($lzreply['start_time'] > $nowtime) {
                    $item['status'] = '<span class="label label-warning">未开始</span>';
                } else if ($endtime < $nowtime) {
                    $item['status'] = '<span class="label label-default ">已结束</span>';
                } else {
                    if ($lzreply['status'] == 1) {
                        $item['status'] = '<span class="label label-success">已开始</span>';
                    } else {
                        $item['status'] = '<span class="label label-default ">已暂停</span>';
                    }
                }
            }
        }
        include $this->template('manage');
    }
    public function doWebDelete()
    {
        global $_GPC, $_W;
        $rid  = intval($_GPC['rid']);
        $rule = pdo_fetch("SELECT id, module FROM " . tablename('rule') . " WHERE id = :id and uniacid=:iacid", array(
            ':id' => $rid,
            ':iacid' => $_W['uniacid']
        ));
        if (empty($rule)) {
            message('抱歉，要修改的规则不存在或是已经被删除！');
        }
        if (pdo_delete('rule', array(
            'id' => $rid
        ))) {
            pdo_delete('rule_keyword', array(
                'rid' => $rid
            ));
            pdo_delete('stat_rule', array(
                'rid' => $rid
            ));
            pdo_delete('stat_keyword', array(
                'rid' => $rid
            ));
            $module = WeUtility::createModule($rule['module']);
            if (method_exists($module, 'ruleDeleted')) {
                $module->ruleDeleted($rid);
            }
            pdo_delete('longzhou_reply', array(
                'rid' => $rid
            ));
        }
        message('规则操作成功！', referer(), 'success');
    }
    public function doWebHdControl()
    {
        global $_GPC, $_W;
        $status = $_GPC['status'];
        $rid    = $_GPC["rid"];
        $data   = array(
            'status' => $status
        );
        $params = array(
            'rid' => $rid
        );
        $re     = pdo_update('longzhou_reply', $data, $params);
        if (!empty($re)) {
            message('操作成功！', referer(), 'success');
        } else {
            message('操作失败！', referer(), 'success');
        }
    }
    public function doWebRecord()
    {
        global $_GPC, $_W;
        load()->model('reply');
        load()->func('tpl');
        $rid    = $_GPC["rid"];
        $acid   = empty($_W['account']['acid']) ? $_W['uniacid'] : $_W['account']['acid'];
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 10;
        $params = array();
        $total  = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('longzhou_player') . " WHERE rid=" . $rid . ' and iacid=' . $acid);
        $sql    = "SELECT * FROM " . tablename('longzhou_player') . " as p left join " . tablename('longzhou_userinfo') . " as i on p.OpenId=i.openid WHERE p.rid = " . $rid . " and i.rid=" . $rid . " and p.iacid=" . $acid . ' ORDER BY p.Distance DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
        $list   = pdo_fetchall($sql, array());
        $pager  = pagination($total, $pindex, $psize);
        include $this->template('record');
    }
    public function doWebHelp()
    {
        global $_GPC, $_W;
        load()->model('reply');
        load()->func('tpl');
        $id     = $_GPC["id"];
        $rid    = $_GPC["rid"];
        $acid   = empty($_W['account']['acid']) ? $_W['uniacid'] : $_W['account']['acid'];
        $pindex = max(1, intval($_GPC['page']));
        $psize  = 10;
        $params = array();
        $total  = pdo_fetchcolumn("SELECT count(*) FROM " . tablename('longzhou_help') . " WHERE HelpPlayer=" . $id . ' and rid=' . $rid . ' and iacid=' . $acid);
        $sql    = "SELECT * FROM " . tablename('longzhou_help') . " WHERE HelpPlayer = " . $id . ' and rid=' . $rid . ' and iacid=' . $acid . ' ORDER BY HelpTime DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
        $list   = pdo_fetchall($sql, array());
        $pager  = pagination($total, $pindex, $psize);
        include $this->template('help');
    }
    public function doWebdeleterecord()
    {
        global $_GPC, $_W;
        $rid = intval($_GPC['rid']);
        $id  = $_GPC['id'];
        pdo_delete('longzhou_player', array(
            'PlayerId' => $id,
            'rid' => $rid
        ));
        pdo_delete('longzhou_help', array(
            'HelpPlayer' => $id,
            'rid' => $rid
        ));
        message('操作成功！', referer(), 'success');
    }
}
