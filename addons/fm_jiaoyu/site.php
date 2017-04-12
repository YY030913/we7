<?php
/**
 * 微教育模块
 *
 * @author 高贵血迹
 */
defined ( 'IN_IA' ) or exit ( 'Access Denied' );
define('OSSURL', '../addons/fm_jiaoyu/');
class Fm_jiaoyuModuleSite extends WeModuleSite {
	
	// ===============================================
	public $m = 'wx_school';
	public $table_classify = 'wx_school_classify';
	public $table_score = 'wx_school_score';
	public $table_news = 'wx_school_news';
	public $table_index = 'wx_school_index';
	public $table_students = 'wx_school_students';
	public $table_tcourse = 'wx_school_tcourse';
	public $table_teachers = 'wx_school_teachers';
	public $table_area = 'wx_school_area';
    public $table_type = 'wx_school_type';	
    public $table_kcbiao = 'wx_school_kcbiao';	
	public $table_cook = 'wx_school_cookbook';	
	public $table_reply = 'wx_school_reply';	
	public $table_banners = 'wx_school_banners';
	public $table_bbsreply = 'wx_school_bbsreply';	
	public $table_user = 'wx_school_user';
	public $table_set = 'wx_school_set';
	public $table_leave = 'wx_school_leave';
	public $table_notice = 'wx_school_notice';
	public $table_bjq = 'wx_school_bjq';
	public $table_media = 'wx_school_media';
	public $table_dianzan = 'wx_school_dianzan';
	public $table_order = 'wx_school_order';
    public $table_wxpay = 'wx_school_wxpay';
    public $table_group = 'wx_school_fans_group';
	public $table_qrinfo = 'wx_school_qrcode_info';
	public $table_qrset = 'wx_school_qrcode_set';
	public $table_qrstat = 'wx_school_qrcode_statinfo';
	
	// ===============================================
		
	
	// 载入逻辑方法
	private function getLogic($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		if ($type == 'web') {
			checkLogin ();
			include_once 'inc/web/' . strtolower ( substr ( $_name, 5 ) ) . '.php';
		} else if ($type == 'mobile') {
			 if ($auth) {
				  include_once 'inc/func/isauth.php';
			  }
			include_once 'inc/mobile/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		} else if ($type == 'func') {
			//checkAuth ();
			include_once 'inc/func/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		}
	}

	// ====================== Web =====================
	
	// 学校管理
	public function doWebSchool() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebIndexajax() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	

    public function doWebUpgrade() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }

    public function doWebFenzu() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }	
	
    public function doWebManager() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }	
	
	// 分类管理
	public function doWebSemester() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	// 教师管理
	public function doWebAssess() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	// 学生管理
	public function doWebStudents() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 成绩查询
	public function doWebChengji() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

    // 课程安排
	public function doWebKecheng() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	

	// 课表安排
	public function doWebKcbiao() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	
	
	// 课程预约
	public function doWebSubscribe() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 食谱安排
	public function doWebCookBook() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	// 首页导航
	public function doWebNave() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	//班级管理
	public function doWebTheclass() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	//成绩管理
	public function doWebScore() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	//科目管理
	public function doWebSubject() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
    //时段管理
	public function doWebTimeframe() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	
	
	//星期管理
	public function doWebWeek() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	


	public function doWebArea() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}


	public function doWebType() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	

	public function doWebBanner() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	

    public function doWebQuery() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }
	
    public function doWebBasic() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }

    public function doWebCook() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }
    //forSUTELIST
    public function doWebBaoming() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }	

    public function doWebArticle() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }

    public function doWebNews() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }

    public function doWebWenzhang() {
        $this->getLogic ( __FUNCTION__, 'web' ); 
    }	
	// ====================== Mobile =====================
	

	public function doMobileAuth() {
		$this->getLogic ( __FUNCTION__, 'func' );
	}
 	// 异步加载
	public function doMobileIndexajax() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}

	public function doMobileBjqajax() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}	
	
    public function doMobileDongtaiajax() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}
	
	public function doMobileGopay() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileZhaosheng() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileNewslist() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileNew() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	
	public function doMobileWapindex() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	

	public function doMobilePayajax() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileDetail() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileJianjie() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileKc() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	

    public function doMobileKcinfo() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileKcdg() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	

    public function doMobileTeachers() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTcinfo() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileChaxun() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileChengji() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileCooklist() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileCook() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileUser() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileBangding() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileBdajax() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMyinfo() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileJiaoliu() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMytecher() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileMyclass() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	

    public function doMobileMyschool() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}
    //for teacher
    public function doMobileQingjia() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	

    public function doMobileSqingjia() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	//for master
    public function doMobileTmssage() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTmcomet() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMnotice() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMnoticelist() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMfabu() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	
    // ====================== students =====================
    public function doMobileSmssage() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileSmcomet() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileXsqj() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSnoticelist() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSnotice() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSzuoye() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSzuoyelist() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	

    public function doMobileZfabu() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileBjqfabu() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSbjqfabu() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSbjq() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMybjqinfo() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileOrder() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMykcinfo() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMykcdetial() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	
		
	// ====================== teacher =====================	
	
    public function doMobileBjq() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileZuoye() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileZuoyelist() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	

    public function doMobileFabu() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileNoticelist() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileNotice() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}	

    public function doMobileTjiaoliulist() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTjiaoliu() {	
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

	
	// ====================== FUNC =====================		
    public function getNaveMenu() {
        global $_W, $_GPC;
        $do = $_GPC['do'];
        $navemenu = array();
        $navemenu[0] = array(
            'title' => '微教育',
            'items' => array(
                0 => array('title' => '学校管理', 'url' => $do != 'school' ? $this->createWebUrl('school', array('op' => 'display')) : ''),
                1 => array('title' => '校区设置', 'url' => $do != 'area' ? $this->createWebUrl('area', array('op' => 'display')) : ''),
                2 => array('title' => '分类设置', 'url' => $do != 'type' ? $this->createWebUrl('type', array('op' => 'display')) : ''),
                3 => array('title' => '基本设置', 'url' => $do != 'basic' ? $this->createWebUrl('basic', array('op' => 'display')) : ''),
				4 => array('title' => '平台功能', 'url' => $do != 'manager' ? $this->createWebUrl('manager', array('op' => 'display')) : ''),
            )
        );


        return $navemenu;
    }	

    public function set_tabbar1($action, $schoolid)  {
        $actions_titles1 = $this->actions_titles1;
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles1 as $key => $value) {
            $url = $this->createWebUrl($key, array('op' => 'display', 'schoolid' => $schoolid));
            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public $actions_titles1 = array(
	    'semester' => '分类管理',
        'assess' => '教师管理',
        'students' => '学生管理',
        'chengji' => '成绩查询',
        'kecheng' => '课程安排',
		'kcbiao' => '课表设置',
		'cook' => '食谱管理',
		'banner' => '幻灯片管理',	
		'article' => '文章系统',		
    );	
	
    public function set_tabbar($action, $schoolid) {
        $actions_titles = $this->actions_titles;
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles as $key => $value) {
            $url = $this->createWebUrl($key, array('op' => 'display', 'schoolid' => $schoolid));
            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
	
    public $actions_titles = array(
	    'semester' => '年级管理',
        'theclass' => '班级管理',
        'score' => '成绩管理',
        'subject' => '科目管理',
        'timeframe' => '时段管理',
        'week' => '星期管理',

    );

    public function set_tabbar2($action, $schoolid) {
        $actions_titles2 = $this->actions_titles2;
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles2 as $key => $value) {
            $url = $this->createWebUrl($key, array('op' => 'display', 'schoolid' => $schoolid));
            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
	
    public $actions_titles2 = array(
	    'article' => '校园公告',
        'news' => '校园新闻',
        'wenzhang' => '精选文章',
    );	
	
    public function showMessageAjax($msg, $code = 0){
        $result['code'] = $code;
        $result['msg'] = $msg;
        message($result, '', 'ajax');
    }

	public function sendtempmsg($template_id, $url, $data, $topcolor, $tousers = '') {
		load()->func('communication');		
		load()->classs('weixin.account');
		$access_token = WeAccount::token();
		if(empty($access_token)) {
			return;
		}
		$postarr = '{"touser":"'.$tousers.'","template_id":"'.$template_id.'","url":"'.$url.'","topcolor":"'.$topcolor.'","data":'.$data.'}';
		$res = ihttp_post('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token,$postarr);
		return true;
	}
	
	private function sendMobileBjqshtz($schoolid, $weid, $shername, $bj_id) {
		global $_GPC,$_W;
		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename($this->table_set)." WHERE :weid = weid", array(':weid' => $weid));	
        $template_id = $msgtemplate['bjqshtz'];//消息模板id 微信的模板id
		$bzj = pdo_fetch("SELECT * FROM " . tablename($this->table_classify) . " where weid = :weid And schoolid = :schoolid And sid = :sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':sid' => $bj_id));	
		$teachers = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id = :id", array(':weid' => $weid, ':id' => $bzj['tid']));	

	    $leibie = "班级圈内容审核";
		$zhuangtai = "未通过";
		$ttime = date('Y-m-d H:i:s', TIMESTAMP);
		$body = "点击本条消息快速审核 ";
	    $datas=array(
		'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
		'first'=>array('value'=>'老师您好,您收到了一条班级圈内容审核提醒','color'=>'#FF9E05'),
		'keyword1'=>array('value'=>$leibie,'color'=>'#1587CD'),
		'keyword2'=>array('value'=>$shername,'color'=>'#FF9E05'),
		'keyword3'=>array('value'=>$zhuangtai,'color'=>'#1587CD'),
		'keyword4'=>array('value'=>$ttime,'color'=>'#1587CD'),
		'remark'=> array('value'=>$body,'color'=>'#FF9E05')
	     );
	    $data=json_encode($datas); //发送的消息模板数据
        
		$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('bjq', array('schoolid' => $schoolid, 'bj_id' => $bj_id));
		

		if (!empty($template_id)) {
			$this->sendtempmsg($template_id, $url, $data, '#FF0000', $teachers['openid']);
		}
	}

	private function sendMobileBjqshjg($schoolid, $weid, $shername, $toopenid) {
		global $_GPC,$_W;
		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename($this->table_set)." WHERE :weid = weid", array(':weid' => $weid));	
        $template_id = $msgtemplate['bjqshjg'];//消息模板id 微信的模板id

	    $leibie = "班级圈内容审核";
		$zhuangtai = "审核通过";
		$ttime = date('Y-m-d H:i:s', TIMESTAMP);
		$body = "点击本条消息快速查看 ";
	    $datas=array(
		'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
		'first'=>array('value'=>'您好'.$shername.',您收到一条班级圈审核结果通知','color'=>'#FF9E05'),
		'keyword1'=>array('value'=>$leibie,'color'=>'#1587CD'),
		'keyword2'=>array('value'=>$zhuangtai,'color'=>'#FF9E05'),
		'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
		'remark'=> array('value'=>$body,'color'=>'#FF9E05')
	     );
	    $data=json_encode($datas); //发送的消息模板数据
        
		$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('sbjq', array('schoolid' => $schoolid));
		

		if (!empty($template_id)) {
			$this->sendtempmsg($template_id, $url, $data, '#FF0000', $toopenid);
		}
	}	
	
	private function sendMobileZuoye($notice_id, $schoolid, $weid, $tname, $bj_id) {
		global $_GPC,$_W;
		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename($this->table_set)." WHERE :weid = weid", array(':weid' => $weid));	
		$notice = pdo_fetch("SELECT * FROM ".tablename($this->table_notice)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $notice_id, ':schoolid' => $schoolid));

        $template_id = $msgtemplate['zuoye'];//消息模板id 微信的模板id
		$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE :weid = weid AND :schoolid =schoolid", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
					
		$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid And bj_id = :bj_id",array(':weid'=>$weid, ':schoolid'=>$schoolid, ':bj_id'=>$notice['bj_id']));
				
		foreach ($userinfo as $key => $value) {
								
			$openid = pdo_fetchcolumn("select openid from ".tablename($this->table_user)." where sid = '{$value['id']}' ORDER BY id DESC ");  
                
            $url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('szuoye', array('schoolid' => $schoolid,'id' => $notice_id));
		    
			$name  = "{$tname}老师";
			$title ="{$category[$notice['km_id']]['sname']}老师{$tname}发来一条作业消息!";
			$bjname  = "{$category[$notice['bj_id']]['sname']}";
			$body  = "点击本条消息查看详情 ";
			$datas=array(
				'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
				'first'=>array('value'=>$title,'color'=>'#1587CD'),
				'keyword1'=>array('value'=>$bjname,'color'=>'#1587CD'),
				'keyword2'=>array('value'=>$notice['title'],'color'=>'#2D6A90'),
				'remark'=> array('value'=>$body,'color'=>'#FF9E05')
						);
			$data = json_encode($datas); //发送的消息模板数据
			
			$this->sendtempmsg($template_id, $url, $data, '#FF0000', $openid);
		}
	}
	
	private function sendMobileXytz($notice_id, $schoolid, $weid, $tname, $groupid) {
		global $_GPC,$_W;
		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename($this->table_set)." WHERE :weid = weid", array(':weid' => $weid));	
		$notice = pdo_fetch("SELECT * FROM ".tablename($this->table_notice)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $notice_id, ':schoolid' => $schoolid));
		$school = pdo_fetch("SELECT * FROM ".tablename($this->table_index)." WHERE :weid = weid AND :id = id", array(':weid' => $weid, ':id' => $schoolid));
        $template_id = $msgtemplate['xxtongzhi'];//消息模板id 微信的模板id
		$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE :weid = weid AND :schoolid =schoolid", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
		
		if ($groupid == 1) {
			
		$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_user)." where weid = :weid And schoolid = :schoolid",array(':weid'=>$weid, ':schoolid'=>$schoolid));	
			
		}elseif ($groupid == 2) {
			
		$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_teachers)." where weid = :weid And schoolid = :schoolid",array(':weid'=>$weid, ':schoolid'=>$schoolid));	
		
		}elseif ($groupid == 3) {
			
		$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid",array(':weid'=>$weid, ':schoolid'=>$schoolid));
		
        }	
		
		foreach ($userinfo as $key => $value) {
			
			$openid = "";
			
				if ($groupid == 1) {
					
				$openid = pdo_fetchcolumn("select openid from ".tablename($this->table_user)." where id = '{$value['id']}' ");	
                
                $url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('snotice', array('schoolid' => $schoolid,'id' => $notice_id));				
			
		        }elseif ($groupid == 2) {
					
				$openid = pdo_fetchcolumn("select openid from ".tablename($this->table_user)." where tid = '{$value['id']}' ");	
				
				$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('mnotice', array('schoolid' => $schoolid,'id' => $notice_id)); 
					
				}elseif ($groupid == 3) {
					
				$openid = pdo_fetchcolumn("select openid from ".tablename($this->table_user)." where sid = '{$value['id']}' ");  
				
				$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('snotice', array('schoolid' => $schoolid,'id' => $notice_id));
				
				}
			$schoolname ="{$school['title']}";
			$name  = "{$tname}老师";
			$bjname  = "{$category[$notice['bj_id']]['sname']}";
			$ttime = date('Y-m-d H:i:s', $notice['createtime']);
			$body  = "点击本条消息查看详情 ";
			$datas=array(
				'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
				'first'=>array('value'=>'您收到一条学校通知','color'=>'#1587CD'),
				'keyword1'=>array('value'=>$schoolname,'color'=>'#1587CD'),
				'keyword2'=>array('value'=>$name,'color'=>'#2D6A90'),
				'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
				'keyword4'=>array('value'=>$notice['title'],'color'=>'#1587CD'),
				'remark'=> array('value'=>$body,'color'=>'#FF9E05')
						);
			$data = json_encode($datas); //发送的消息模板数据
			
			$this->sendtempmsg($template_id, $url, $data, '#FF0000', $openid);
		}
	}	

	private function sendMobileFxtz($schoolid, $weid, $tname, $bj_id) {
		global $_GPC,$_W;
		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename($this->table_set)." WHERE :weid = weid", array(':weid' => $weid));	
        $template_id = $msgtemplate['bjtz'];//消息模板id 微信的模板id
		$bname = pdo_fetch("SELECT * FROM ".tablename($this->table_classify)." WHERE :weid = weid AND :schoolid =schoolid And :sid = sid", array(':weid' => $weid, ':schoolid' => $schoolid, ':sid' => $bj_id));
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		
		$userinfo = pdo_fetchall("SELECT * FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid And bj_id = :bj_id",array(':weid'=>$weid, ':schoolid'=>$schoolid, ':bj_id'=>$bj_id));	
		
		foreach ($userinfo as $key => $value) {
			
			$openid = pdo_fetchcolumn("select openid from ".tablename($this->table_user)." where sid = '{$value['id']}' ");
			$s_name = pdo_fetchcolumn("select s_name from ".tablename($this->table_students)." where id = '{$value['id']}' ");


			$name  = "班主任-{$tname}";
			$title = "{$s_name}家长，您收到一条学生放学通知";
			$bjname  = "{$bname['sname']}";
			$ttime = date('Y-m-d H:i:s', TIMESTAMP);
			$notice  = "本班级已经放学，请家长注意学生放学后动态，确认是否安全回家";
			$body  = "";
			$datas=array(
				'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
				'first'=>array('value'=>$title,'color'=>'#FF9E05'),
				'keyword1'=>array('value'=>$bjname,'color'=>'#1587CD'),
				'keyword2'=>array('value'=>$name,'color'=>'#2D6A90'),
				'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
				'keyword4'=>array('value'=>$notice,'color'=>'#1587CD'),
				'remark'=> array('value'=>$body,'color'=>'#FF9E05')
						);
			$data = json_encode($datas); //发送的消息模板数据
			$url = "";
			$this->sendtempmsg($template_id, $url, $data, '#FF0000', $openid);
		}
	}	
	
	private function sendMobileBjtz($notice_id, $schoolid, $weid, $tname, $bj_id) {
		global $_GPC,$_W;
		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename($this->table_set)." WHERE :weid = weid", array(':weid' => $weid));	
		$notice = pdo_fetch("SELECT * FROM ".tablename($this->table_notice)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $notice_id, ':schoolid' => $schoolid));
        $template_id = $msgtemplate['bjtz'];//消息模板id 微信的模板id
		$category = pdo_fetchall("SELECT * FROM " . tablename($this->table_classify) . " WHERE :weid = weid AND :schoolid =schoolid", array(':weid' => $weid, ':schoolid' => $schoolid), 'sid');
		
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		
		$userinfo=pdo_fetchall("SELECT * FROM ".tablename($this->table_students)." where weid = :weid And schoolid = :schoolid And bj_id = :bj_id",array(':weid'=>$weid, ':schoolid'=>$schoolid, ':bj_id'=>$bj_id));	
		
		foreach ($userinfo as $key => $value) {
			
			$openid=pdo_fetchcolumn("select openid from ".tablename($this->table_user)." where sid = '{$value['id']}' ");
			
			$name  = "{$tname}老师";
			$bjname  = "{$category[$notice['bj_id']]['sname']}";
			$ttime = date('Y-m-d H:i:s', $notice['createtime']);
			$body  = "点击本条消息查看详情 ";
			$datas=array(
				'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
				'first'=>array('value'=>'您收到一条班级通知','color'=>'#1587CD'),
				'keyword1'=>array('value'=>$bjname,'color'=>'#1587CD'),
				'keyword2'=>array('value'=>$name,'color'=>'#2D6A90'),
				'keyword3'=>array('value'=>$ttime,'color'=>'#1587CD'),
				'keyword4'=>array('value'=>$notice['title'],'color'=>'#1587CD'),
				'remark'=> array('value'=>$body,'color'=>'#FF9E05')
						);
			$data = json_encode($datas); //发送的消息模板数据
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('snotice', array('schoolid' => $schoolid,'id' => $notice_id));
			$this->sendtempmsg($template_id, $url, $data, '#FF0000', $openid);
		}
	}
		
	private function sendMobileXsqj($leave_id, $schoolid, $weid, $tid) {
		global $_GPC,$_W;
		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename($this->table_set)." WHERE :weid = weid", array(':weid' => $weid));	
		$leave = pdo_fetch("SELECT * FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leave_id, ':schoolid' => $schoolid));
        $template_id = $msgtemplate['xsqingjia'];//消息模板id 微信的模板id
        $student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $leave['sid']));
        $teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $tid));
		
		$guanxi = "本人";
		
		if($student['muid'] == $leave['uid']){
			$guanxi = "妈妈";
		}else if($student['duid'] == $leave['uid']) {
			$guanxi = "爸爸";
		}  
  
        if (!empty($template_id)) {
		
		$shenfen = "{$student['s_name']}{$guanxi}";
	    $stime = $leave['startime'];
	    $etime = $leave['endtime'];
		$ttime = date('Y-m-d H:i:s', $leave['createtime']);
		$time  = "{$stime}至{$etime}";
		$body .= "消息时间：{$ttime} \n";
		$body .= "点击本条消息快速处理 ";
	    $datas=array(
		'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
		'first'=>array('value'=>'您收到了一条'.$shenfen.'的请假申请','color'=>'#1587CD'),
		'childName'=>array('value'=>$student['s_name'],'color'=>'#1587CD'),
		'time'=>array('value'=>$time,'color'=>'#2D6A90'),
		'score'=>array('value'=>$leave['conet'],'color'=>'#1587CD'),
		'remark'=> array('value'=>$body,'color'=>'#FF9E05')
	     );
	    $data=json_encode($datas); //发送的消息模板数据
        }
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('smcomet', array('schoolid' => $schoolid,'id' => $leave_id));
		//}

		if (!empty($template_id)) {
			$this->sendtempmsg($template_id, $url, $data, '#FF0000', $teacher['openid']);
		}
	}
	
	private function sendMobileXsqjsh($leaveid, $schoolid, $weid, $tname) {
		global $_GPC,$_W;
		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename($this->table_set)." WHERE :weid = weid", array(':weid' => $weid));	
		$leave = pdo_fetch("SELECT * FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leaveid, ':schoolid' => $schoolid));
		$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $leave['sid']));
        $template_id = $msgtemplate['xsqjsh'];//消息模板id 微信的模板id
        $jieguo = "";
		if($leave['status'] ==1){
			$jieguo = "同意";
		}else{
			$jieguo = "不同意";
		}
  
        if (!empty($template_id)) {
		$stime = $leave['startime'];
	    $etime = $leave['endtime'];
		$time = "{$stime}至{$etime}";
		$ctime = date('Y-m-d H:i:s', $leave['cltime']);
		$body .= "处理时间：{$ctime} \n";
		$body .= "";
	    $datas=array(
		'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
		'first'=>array('value'=>'您好，'.$tname.'老师已经回复了您的请假申请','color'=>'#1587CD'),
		'keyword1'=>array('value'=>$student['s_name'],'color'=>'#1587CD'),
		'keyword2'=>array('value'=>$time,'color'=>'#2D6A90'),
		'keyword3'=>array('value'=>$jieguo,'color'=>'#1587CD'),
		'keyword4'=>array('value'=>$tname,'color'=>'#1587CD'),
		'remark'=> array('value'=>$body,'color'=>'#FF9E05')
	     );
	    $data=json_encode($datas); //发送的消息模板数据
        }
			//$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('smcomet', array('schoolid' => $schoolid,'id' => $leaveid));
		//}
		
		if (!empty($template_id)) {
			$this->sendtempmsg($template_id, $url, $data, '#FF0000', $leave['openid']);
		}
	}
	
	private function sendMobileJzly($leave_id, $schoolid, $weid, $uid, $bj_id, $sid, $tid) {
		global $_GPC,$_W;

		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename($this->table_set)." WHERE :weid = weid", array(':weid' => $weid));
        $leave = pdo_fetch("SELECT * FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leave_id, ':schoolid' => $schoolid));	
		$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $sid));
		$msgs = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND schoolid=:schoolid AND status=:status", array(':weid' => $weid, ':schoolid' => $schoolid, ':status' => 2));
		$template_id = $msgtemplate['liuyan'];//消息模板id 微信的模板id
		$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $tid));//查询master
		
		$guanxi = "本人";
		
		if($students['muid'] == $uid){
			$guanxi = "妈妈";
		}else if($students['duid'] == $uid) {
			$guanxi = "爸爸";
		}
		
        if (!empty($template_id)) {
		$time = date('Y-m-d H:i:s', $leave['createtime']);
		$data1 = "{$students['s_name']}{$guanxi}";
		$body .= "留言摘要：{$leave['conet']} \n";
		$body .= "点击本条消息快速回复 ";
	    $datas=array(
		'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
		'first'=>array('value'=>'您收到了一条留言信息！','color'=>'#1587CD'),
		'keyword1'=>array('value'=>$data1,'color'=>'#1587CD'),
		'keyword2'=>array('value'=>$time,'color'=>'#2D6A90'),
		'remark'=> array('value'=>$body,'color'=>'#FF9E05')
	     );
	    $data=json_encode($datas); //发送的消息模板数据
        }	
		
		$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('tjiaoliu', array('schoolid' => $schoolid,'id' => $leave_id,'leaveid' => $leave['leaveid']));

		if (!empty($template_id)) {
			$this->sendtempmsg($template_id, $url, $data, '#FF0000', $teacher['openid']);
		}
	}
	
	private function sendMobileJzlyhf($leave_id, $schoolid, $weid, $topenid, $sid, $tname) {
		global $_GPC,$_W;

		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename($this->table_set)." WHERE :weid = weid", array(':weid' => $weid));
        $leave = pdo_fetch("SELECT * FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leave_id, ':schoolid' => $schoolid));	
		$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $sid));
		$msgs = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND schoolid=:schoolid AND status=:status", array(':weid' => $weid, ':schoolid' => $schoolid, ':status' => 2));
		$template_id = $msgtemplate['liuyanhf'];//消息模板id 微信的模板id
		$teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $tid));//查询master
		
		$guanxi = "";
		
		if($students['muid'] == $uid){
			$guanxi = "妈妈";
		}else if($students['duid'] == $uid) {
			$guanxi = "爸爸";
		}
		
        if (!empty($template_id)) {
		$time = date('Y-m-d H:i:s', $leave['createtime']);
		$data1 = "{$students['s_name']}{$guanxi},您收到了一条老师的留言回复信息！";
		$body = "点击本条消息快速回复 ";
	    $datas=array(
		'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
		'first'=>array('value'=>$data1,'color'=>'#1587CD'),
		'keyword1'=>array('value'=>$tname,'color'=>'#1587CD'),
		'keyword2'=>array('value'=>$time,'color'=>'#2D6A90'),
		'keyword3'=>array('value'=>$leave['conet'],'color'=>'#2D6A90'),
		'remark'=> array('value'=>$body,'color'=>'#FF9E05')
	     );
	    $data=json_encode($datas); //发送的消息模板数据
        }	

		$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('jiaoliu', array('schoolid' => $schoolid));

		if (!empty($template_id)) {
			$this->sendtempmsg($template_id, $url, $data, '#FF0000', $topenid);
		}
	}	
	
	private function sendMobileJsqj($leave_id, $schoolid, $weid) {
		global $_GPC,$_W;
		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename($this->table_set)." WHERE :weid = weid", array(':weid' => $weid));	
		$leave = pdo_fetch("SELECT * FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leave_id, ':schoolid' => $schoolid));
		$msgs = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND schoolid=:schoolid AND status=:status", array(':weid' => $weid, ':schoolid' => $schoolid, ':status' => 2));
        $template_id = $msgtemplate['jsqingjia'];//消息模板id 微信的模板id
        $teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $leave['tid']));
  
  
        if (!empty($template_id)) {
		
	    $stime = $leave['startime'];
	    $etime = $leave['endtime'];
		$time = "{$stime}至{$etime}";
		$body = "点击本条消息快速处理 ";
	    $datas=array(
		'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
		'first'=>array('value'=>'您收到了一条教师请假申请','color'=>'#1587CD'),
		'keyword1'=>array('value'=>$teacher['tname'],'color'=>'#1587CD'),
		'keyword2'=>array('value'=>$leave['type'],'color'=>'#2D6A90'),
		'keyword3'=>array('value'=>$time,'color'=>'#1587CD'),
		'keyword4'=>array('value'=>$leave['conet'],'color'=>'#173177'),
		'remark'=> array('value'=>$body,'color'=>'#FF9E05')
	     );
	    $data=json_encode($datas); //发送的消息模板数据
        }
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('tmcomet', array('schoolid' => $schoolid,'id' => $leave_id));
		//}
		

		if (!empty($template_id)) {
			$this->sendtempmsg($template_id, $url, $data, '#FF0000', $msgs['openid']);
		}
	}

	private function sendMobileJsqjsh($leaveid, $schoolid, $weid) {
		global $_GPC,$_W;
		$msgtemplate = pdo_fetch("SELECT * FROM ".tablename($this->table_set)." WHERE :weid = weid", array(':weid' => $weid));	
		$leave = pdo_fetch("SELECT * FROM ".tablename($this->table_leave)." WHERE :weid = weid AND :id = id AND :schoolid = schoolid", array(':weid' => $weid, ':id' => $leaveid, ':schoolid' => $schoolid));
		$msgs = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND schoolid=:schoolid AND status=:status", array(':weid' => $weid, ':schoolid' => $schoolid, ':status' => 2));
        $template_id = $msgtemplate['jsqjsh'];//消息模板id 微信的模板id
        $teacher = pdo_fetch("SELECT * FROM " . tablename($this->table_teachers) . " where weid = :weid AND id=:id", array(':weid' => $weid, ':id' => $leave['tid']));
        $jieguo = "";
		if($leave['status'] ==1){
			$jieguo = "同意";
		}else{
			$jieguo = "不同意";
		}
  
        if (!empty($template_id)) {
		
		$time = date('Y-m-d H:i:s', $leave['cltime']);
		$body = "点击本条消息查看详情 ";
	    $datas=array(
		'name'=>array('value'=>$_W['account']['name'],'color'=>'#173177'),
		'first'=>array('value'=>'请假审批结果通知','color'=>'#1587CD'),
		'keyword1'=>array('value'=>$jieguo,'color'=>'#1587CD'),
		'keyword2'=>array('value'=>$msgs['tname'],'color'=>'#2D6A90'),
		'keyword3'=>array('value'=>$time,'color'=>'#1587CD'),
		'remark'=> array('value'=>$body,'color'=>'#FF9E05')
	     );
	    $data=json_encode($datas); //发送的消息模板数据
        }
			$url =  $_W['siteroot'] .'app/'.$this->createMobileUrl('tmcomet', array('schoolid' => $schoolid,'id' => $leaveid));
		//}
		
		if (!empty($template_id)) {
			$this->sendtempmsg($template_id, $url, $data, '#FF0000', $leave['openid']);
		}
	}	

    protected function exportexcel($data = array(), $title = array(), $filename = 'report') {
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        if (!empty($title)) {
            foreach ($title as $k => $v) {
                $title[$k] = iconv("UTF-8", "GB2312", $v);
            }
            $title = implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck] = iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key] = implode("\t", $data[$key]);

            }
            echo implode("\n", $data);
        }
    }

    function uploadFile($file, $filetempname, $array) {
        //自己设置的上传文件存放路径
        $filePath = '../addons/fm_jiaoyu/public/upload/';

        include 'inc/func/phpexcelreader/reader.php';

        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('utf-8');

        //设置时区
        $time = date("y-m-d-H-i-s"); //去当前上传的时间
        $extend = strrchr($file, '.');
        //上传后的文件名
        $name = $time . $extend;
        $uploadfile = $filePath . $name; //上传后的文件名地址

        if (copy($filetempname, $uploadfile)) {
            if (!file_exists($filePath)) {
                echo '文件路径不存在.';
                return;
            }
            if (!is_readable($uploadfile)) {
                echo ("文件为只读,请修改文件相关权限.");
                return;
            }
            $data->read($uploadfile);
            error_reporting(E_ALL ^ E_NOTICE);
            $count = 0;
            for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { //$=2 第二行开始
                //以下注释的for循环打印excel表数据
                for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
                    //echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
                }

                $row = $data->sheets[0]['cells'][$i];
                //message($data->sheets[0]['cells'][$i][1]);

                if ($array['ac'] == "assess") {
                    $count = $count + $this->upload_assess($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "students") {
                    $count = $count + $this->upload_students($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "chengji") {
                    $count = $count + $this->upload_chengji($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "kecheng") {
                    $count = $count + $this->upload_kecheng($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "kcbiao") {
                    $count = $count + $this->upload_kcbiao($row, TIMESTAMP, $array);
                }
            }
        }
        if ($count == 0) {
            $msg = "表格设置错误请检查！";
        } else {
            $msg = 1;
        }

        return $msg;
    }

    function upload_assess($strs, $time, $array) {
        global $_W;
        $insert = array();
		$arr = explode('.',$_SERVER ['HTTP_HOST']);

		//时间处理
		$t = $strs[2]; //读取到的值
		$j = $strs[6];
        $birthdate = intval(($t - 25569) * 24*60*60); //转换成1970年以来的秒数	
		$jiontime = intval(($j - 25569) * 24*60*60); 
		//绑定码
		$randStr = str_shuffle('1234567890');
        $rand = substr($randStr,0,6);
		//年级处理
		$xueqi1 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[10], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		$xueqi2 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[11], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		$xueqi3 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[12], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//班级处理
		$banji1 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[13], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		$banji2 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[14], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		$banji3 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[15], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		//科目处理
		$kemu1 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[16], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));   
        $kemu2 = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[17], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid'])); 		
		$insert['weid'] = $_W['uniacid'];
        $insert['tname'] = $strs[1];  
        $insert['birthdate'] = $birthdate;
        $insert['tel'] = $strs[3];
        $insert['mobile'] = $strs[4];
        $insert['email'] = $strs[5];
        $insert['jiontime'] = $jiontime;
        $insert['headinfo'] = $strs[7];
        $insert['info'] = $strs[8];
        $insert['sex'] = $strs[9];
        $insert['xq_id1'] = empty($xueqi1) ? 0 : intval($xueqi1['sid']);
        $insert['xq_id2'] = empty($xueqi2) ? 0 : intval($xueqi2['sid']);
        $insert['xq_id3'] = empty($xueqi3) ? 0 : intval($xueqi3['sid']);		
        $insert['bj_id1'] = empty($banji1) ? 0 : intval($banji1['sid']);	
        $insert['bj_id2'] = empty($banji2) ? 0 : intval($banji2['sid']);
        $insert['bj_id3'] = empty($banji3) ? 0 : intval($banji3['sid']);
        $insert['km_id1'] = empty($kemu1) ? 0 : intval($kemu1['sid']);
        $insert['km_id2'] = empty($kemu2) ? 0 : intval($kemu2['sid']);		
		$insert['schoolid'] = $array['schoolid'];
        $insert['status'] = 1;
        $insert['sort'] = '';
		$insert['jinyan'] = $strs[18];
		$insert[$arr['2']] = 1;
		$insert['code'] = $rand;
		$insert['is_show'] = 0;
		$insert['openid'] = '';
		$insert['uid'] = 0;
		$insert['thumb'] = 'images/global/avatars/avatar_3.jpg';

        $assess = pdo_fetch("SELECT * FROM " . tablename('wx_school_teachers') . " WHERE tname=:tname AND mobile=:mobile AND weid=:weid And schoolid=:schoolid LIMIT 1", array(':tname' => $strs[1], ':mobile' => $strs[4], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));

        if (empty($assess)) {
            return pdo_insert('wx_school_teachers', $insert);
        } else {
            return 0;
        }
    }
	
    function upload_students($strs, $time, $array) {
        global $_W;
        $insert = array();
        //时间处理
		$b = $strs[3]; //读取到的值
		$s = $strs[6];
		$e = $strs[7];
        $birthdate = intval(($b - 25569) * 24*60*60); //转换成1970年以来的时间戳
		$start = intval(($s - 25569) * 24*60*60); 
		$end = intval(($e - 25569) * 24*60*60); 
		//年级处理
		$xueqi = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[9], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[10], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $insert['weid'] = $_W['uniacid'];
        $insert['s_name'] = $strs[1];
        $insert['sex'] = $strs[2];
        $insert['birthdate'] = $birthdate;
        $insert['mobile'] = $strs[4];
        $insert['homephone'] = $strs[5];
        $insert['seffectivetime'] = $start;
        $insert['stheendtime'] = $end;
        $insert['area_addr'] = $strs[8];
        $insert['xq_id'] = empty($xueqi) ? 0 : intval($xueqi['sid']);
        $insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
		$insert['schoolid'] = $array['schoolid'];
		$insert['createdate'] = '';		
		$insert['jf_statu'] = '';
		$insert['localdate_id'] = '';
		$insert['note'] = '';
		$insert['amount'] = '';
		$insert['area'] = '';
		$insert['own'] = '';

        $students = pdo_fetch("SELECT * FROM " . tablename('wx_school_students') . " WHERE s_name=:s_name AND mobile=:mobile AND weid=:weid And schoolid=:schoolid LIMIT 1", array(':s_name' => $strs[1], ':mobile' => $strs[4], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));

        if (empty($students)) {
            return pdo_insert('wx_school_students', $insert);
        } else {
            return 0;
        }
    }	

    function upload_chengji($strs, $time, $array) {
        global $_W;	
        $insert = array();
		//名字处理
		$sid = pdo_fetch("SELECT id FROM " . tablename('wx_school_students') . " WHERE s_name=:s_name AND weid=:weid And schoolid=:schoolid ", array(':s_name' => $strs[1], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		//年级处理
		$xueqi = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[2], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//期号处理
		$qihao = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[3], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[4], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		//科目处理
		$kemu = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[5], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
        $insert['sid'] = empty($sid) ? 0 : intval($sid['id']);
        $insert['xq_id'] = empty($xueqi) ? 0 : intval($xueqi['sid']);
		$insert['qh_id'] = empty($qihao) ? 0 : intval($qihao['sid']);
        $insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
        $insert['km_id'] = empty($kemu) ? 0 : intval($kemu['sid']);		
        $insert['my_score'] = $strs[6];
		$insert['info'] = $strs[7];
		$insert['schoolid'] = $array['schoolid'];
        $insert['weid'] = $_W['uniacid'];

        return pdo_insert('wx_school_score', $insert);
    }

    function upload_kecheng($strs, $time, $array) {
        global $_W;	
        $insert = array();
        //读取到的值
		$s = $strs[12];
		$e = $strs[13];
		$start = intval(($s - 25569) * 24*60*60); //转换成1970年以来的时间戳
		$end = intval(($e - 25569) * 24*60*60);		
		//名字处理
		$tid = pdo_fetch("SELECT id FROM " . tablename('wx_school_teachers') . " WHERE tname=:tname AND weid=:weid And schoolid=:schoolid ", array(':tname' => $strs[1], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		//年级处理
		$xueqi = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[2], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[4], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		//科目处理
		$kemu = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[5], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
        $insert['tid'] = empty($tid) ? 0 : intval($tid['id']);
        $insert['xq_id'] = empty($xueqi) ? 0 : intval($xueqi['sid']);
		$insert['name'] = $strs[3];
        $insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
        $insert['km_id'] = empty($kemu) ? 0 : intval($kemu['sid']);		
        $insert['minge'] = $strs[6];
		$insert['yibao'] = $strs[7];
		$insert['cose'] = $strs[8];
		$insert['dagang'] = $strs[9];
		$insert['adrr'] = $strs[10];
		$insert['is_hot'] = $strs[11];
		$insert['start'] = $start;
		$insert['end'] = $end;
		$insert['schoolid'] = $array['schoolid'];
        $insert['weid'] = $_W['uniacid'];

        return pdo_insert('wx_school_tcourse', $insert);
    }
	
    function upload_kcbiao($strs, $time, $array) {
        global $_W;	
        $insert = array();
		$times = $strs[5];
		$timess = intval(($times - 25569) * 24*60*60); //转换成1970年以来的时间戳
		//名字处理
		$kc = pdo_fetch("SELECT id FROM " . tablename('wx_school_tcourse') . " WHERE id=:id AND weid=:weid And schoolid=:schoolid ", array(':id' => $strs[1], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $tid = pdo_fetch("SELECT tid FROM " . tablename('wx_school_tcourse') . " WHERE id=:id AND weid=:weid And schoolid=:schoolid ", array(':id' => $strs[1], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $bj = pdo_fetch("SELECT bj_id FROM " . tablename('wx_school_tcourse') . " WHERE id=:id AND weid=:weid And schoolid=:schoolid ", array(':id' => $strs[1], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));	
        $km = pdo_fetch("SELECT km_id FROM " . tablename('wx_school_tcourse') . " WHERE id=:id AND weid=:weid And schoolid=:schoolid ", array(':id' => $strs[1], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));			
		//年级处理
		$xq = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[2], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//期号处理
		$shiduan = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => $strs[3], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));

        $insert['kcid'] = empty($kc) ? 0 : intval($kc['id']);
	    $insert['tid'] = empty($tid) ? 0 : intval($tid['tid']);
        $insert['xq_id'] = empty($xq) ? 0 : intval($xq['sid']);
		$insert['sd_id'] = empty($shiduan) ? 0 : intval($shiduan['sid']);
        $insert['bj_id'] = empty($bj) ? 0 : intval($bj['bj_id']);
        $insert['km_id'] = empty($km) ? 0 : intval($km['km_id']);
        $insert['nub'] = $strs[4];
		$insert['date'] = $timess;
		$insert['schoolid'] = $array['schoolid'];
        $insert['weid'] = $_W['uniacid'];

        return pdo_insert('wx_school_kcbiao', $insert);
    }
				
    private function checkUploadFileMIME($file) {
        // 1.through the file extension judgement 03 or 07
        $flag = 0;
        $file_array = explode(".", $file ["name"]);
        $file_extension = strtolower(array_pop($file_array));

        // 2.through the binary content to detect the file
        switch ($file_extension) {
            case "xls" :
                // 2003 excel
                $fh = fopen($file ["tmp_name"], "rb");
                $bin = fread($fh, 8);
                fclose($fh);
                $strinfo = @unpack("C8chars", $bin);
                $typecode = "";
                foreach ($strinfo as $num) {
                    $typecode .= dechex($num);
                }
                if ($typecode == "d0cf11e0a1b11ae1") {
                    $flag = 1;
                }
                break;
            case "xlsx" :
                // 2007 excel
                $fh = fopen($file ["tmp_name"], "rb");
                $bin = fread($fh, 4);
                fclose($fh);
                $strinfo = @unpack("C4chars", $bin);
                $typecode = "";
                foreach ($strinfo as $num) {
                    $typecode .= dechex($num);
                }
                echo $typecode . 'test';
                if ($typecode == "504b34") {
                    $flag = 1;
                }
                break;
        }

        // 3.return the flag
        return $flag;
    }

    public function doWebUploadExcel() {
        global $_GPC, $_W;

        if ($_GPC['leadExcel'] == "true") {
            $filename = $_FILES['inputExcel']['name'];
            $tmp_name = $_FILES['inputExcel']['tmp_name'];

            $flag = $this->checkUploadFileMIME($_FILES['inputExcel']);
            if ($flag == 0) {
                message('文件格式不对.');
            }

            if (empty($tmp_name)) {
                message('请选择要导入的Excel文件！');
            }

            $msg = $this->uploadFile($filename, $tmp_name, $_GPC);

            if ($msg == 1) {
                message('导入成功！', referer(), 'success');
            } else {
                message($msg, '', 'error');
            }
        }
    }
	
	public function weixin_fans_group($url, $data)
	{		
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		load()->classs('weixin.account');
		$accObj = WeixinAccount::create($weid);
		$access_token = WeAccount::token();
		$url = sprintf($url, $access_token);
		load()->func('communication');
		$response = ihttp_request($url, $data);
		if (is_error($response)) {
			return error(-1, "访问公众平台接口失败, 错误: {$response['message']}");
		}
		$result = @json_decode($response['content'], true);
		if (empty($result)) {
		} elseif (!empty($result['errcode'])) {
			message("访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']}");
		}
		return $result;
	}

	public function createImageUrlCenter($qr_file,$schoolid)
	{
		global $_W, $_GPC;
		$param = pdo_fetch("select * from " . tablename($this->table_qrset) . " where id = :id", array(':id' => 1));
		$school = pdo_fetch("select * from " . tablename($this->table_index) . " where id = :id And weid = :weid", array(':id' => $schoolid, ':weid' => $_W['uniacid']));
		load()->func('file');
		mkdirs('../attachment/fm_jiaoyu/' . date('Y/m/d'));
		$target_file = "../attachment/fm_jiaoyu/" . date("Y/m/d") . "/" . time() . rand(1, 1000) . ".jpg";

		// if (!empty($_W['setting']['remote']['type'])) { 
		// $urls = $_W['SITEROOT'].$_W['config']['upload']['attachdir'].'/'; 
		// } else {
		// $urls = $_W['attachurl'];  
		// }
		
		if (!empty($school['logo'])) {
			$src_file = tomedia($school['logo']);
		} else {
			message('该校LOGO文件为空,请先到校园列表编辑上传学校的LOGO');
		}
		$this->resizeImage($this->imagecreate($qr_file), intval($param['logoqrwidth']), intval($param['logoqrheight']), $target_file);
		list($qrWidth, $qrHeight) = getimagesize($target_file);
		$centerleft = ($qrWidth - intval($param['logowidth'])) / 2;
		$centertop = ($qrHeight - intval($param['logoheight'])) / 2;
		$this->mergeImage($target_file, $src_file, $target_file, array('left' => $centerleft, 'top' => $centertop, 'width' => $param['logowidth'], 'height' => $param['logoheight']));
		return $target_file;
	}
	
	private function mergeImage($bg, $qr, $out, $param)
	{
		list($bgWidth, $bgHeight) = getimagesize($bg);
		list($qrWidth, $qrHeight) = getimagesize($qr);
		$bgImg = $this->imagecreate($bg);
		$qrImg = $this->imagecreate($qr);
		imagecopyresized($bgImg, $qrImg, $param['left'], $param['top'], 0, 0, $param['width'], $param['height'], $qrWidth, $qrHeight);
		ob_start();
		imagejpeg($bgImg, NULL, 100);
		$contents = ob_get_contents();
		ob_end_clean();
		imagedestroy($bgImg);
		imagedestroy($qrImg);
		$fh = fopen($out, "w+");
		fwrite($fh, $contents);
		fclose($fh);
	}	

	function resizeImage($im, $maxwidth, $maxheight, $path)
	{
		$pic_width = imagesx($im);
		$pic_height = imagesy($im);
		if (($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight)) {
			if ($maxwidth && $pic_width > $maxwidth) {
				$widthratio = $maxwidth / $pic_width;
				$resizewidth_tag = true;
			}
			if ($maxheight && $pic_height > $maxheight) {
				$heightratio = $maxheight / $pic_height;
				$resizeheight_tag = true;
			}
			if ($resizewidth_tag && $resizeheight_tag) {
				if ($widthratio < $heightratio) $ratio = $widthratio; else $ratio = $heightratio;
			}
			if ($resizewidth_tag && !$resizeheight_tag) $ratio = $widthratio;
			if ($resizeheight_tag && !$resizewidth_tag) $ratio = $heightratio;
			$newwidth = $pic_width * $ratio;
			$newheight = $pic_height * $ratio;
			if (function_exists('imagecopyresampled')) {
				$newim = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
			} else {
				$newim = imagecreate($newwidth, $newheight);
				imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
			}
			imagejpeg($newim, $path);
			imagedestroy($newim);
		} else {
			imagejpeg($im, $path);
		}
	}

	private function imagecreate($bg)
	{
		$bgImg = @imagecreatefromjpeg($bg);
		if (FALSE == $bgImg) {
			$bgImg = @imagecreatefrompng($bg);
		}
		if (FALSE == $bgImg) {
			$bgImg = @imagecreatefromgif($bg);
		}
		return $bgImg;
	}	
	
	public function doMobilePay() {
		global $_W, $_GPC;
        checkauth();
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];		
		$cose = $_GPC ['cose'];
		$wxpayid = intval($_GPC ['wxpay']);	
        //构造支付请求中的参数
        $params = array(
            'tid' => $wxpayid,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
            'ordersn' => time(),  //收银台中显示的订单号
            'title' => '在线缴费',          //收银台中显示的标题
            'fee' => $cose,
            //'user' => $_W['member']['uid'],     //付款用户, 付款的用户名(选填项)
        );
        //调用pay方法
        include $this->template('students/pay');
	}
    /**
     * 支付后触发这个方法
     * @param $params
     */
	public function payResult($params) {
		
		global $_W, $_GPC;
		
		$orderid = $params['tid'];
        $wxpay = pdo_fetch("SELECT * FROM " . tablename($this->table_wxpay) . " WHERE id = '{$orderid}'");
		$kc1 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = '{$wxpay['od1']}'");
		$kc2 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = '{$wxpay['od2']}'");
        $kc3 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = '{$wxpay['od3']}'");
		$kc4 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = '{$wxpay['od4']}'");
		$kc5 = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = '{$wxpay['od5']}'");
		$kcs1 = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = '{$kc1['kcid']}'");
		$kcs2 = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = '{$kc2['kcid']}'");
        $kcs3 = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = '{$kc3['kcid']}'");
		$kcs4 = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = '{$kc4['kcid']}'");
		$kcs5 = pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " WHERE id = '{$kc5['kcid']}'");
         
		$took1 = $kcs1['yibao']+1;
		$took2 = $kcs2['yibao']+1;
		$took3 = $kcs3['yibao']+1;
		$took4 = $kcs4['yibao']+1;
		$took5 = $kcs5['yibao']+1;
		$too1 = $kcs1['yibao']-1;		
		$too2 = $kcs2['yibao']-1;
		$too3 = $kcs3['yibao']-1;
		$too4 = $kcs4['yibao']-1;
		$too5 = $kcs5['yibao']-1;
				
		if ($params['result'] == 'success' && $params['from'] == 'notify') {
					
			 pdo_update($this->table_wxpay, array('status' => 2), array('id' => $orderid));
			 pdo_update($this->table_order, array('status' => 2), array('id' => $wxpay['od1']));
			 pdo_update($this->table_tcourse, array('yibao' => $took1), array('id' => $kc1['kcid']));
			 if($wxpay['od2'] != 0){
			 pdo_update($this->table_order, array('status' => 2), array('id' => $wxpay['od2']));
			 pdo_update($this->table_tcourse, array('yibao' => $took2), array('id' => $kc2['kcid']));			 
			 }
             if($wxpay['od3'] != 0){
             pdo_update($this->table_order, array('status' => 2), array('id' => $wxpay['od3']));
			 pdo_update($this->table_tcourse, array('yibao' => $took3), array('id' => $kc3['kcid']));			 
			 }
			 if($wxpay['od4'] != 0){
             pdo_update($this->table_order, array('status' => 2), array('id' => $wxpay['od4']));
			 pdo_update($this->table_tcourse, array('yibao' => $took4), array('id' => $kc4['kcid']));
			 }
			 if($wxpay['od5'] != 0){
             pdo_update($this->table_order, array('status' => 2), array('id' => $wxpay['od5']));
			 pdo_update($this->table_tcourse, array('yibao' => $took5), array('id' => $kc5['kcid']));
			 }			
			 if ($params['fee'] != $cose) {
				exit('支付失败');
			 }	
		}
		 if (empty($params['result']) || $params['result'] != 'success') {
			 pdo_update($this->table_wxpay, array('status' => 1), array('id' => $orderid));
			 pdo_update($this->table_order, array('status' => 1), array('id' => $wxpay['od1']));
			 pdo_update($this->table_tcourse, array('yibao' => $too1), array('id' => $kc1['kcid']));
			 if($wxpay['od2'] != 0){
			 pdo_update($this->table_order, array('status' => 1), array('id' => $wxpay['od2']));
			 pdo_update($this->table_tcourse, array('yibao' => $too2), array('id' => $kc2['kcid']));
			 }
             if($wxpay['od3'] != 0){
             pdo_update($this->table_order, array('status' => 1), array('id' => $wxpay['od3']));
			 pdo_update($this->table_tcourse, array('yibao' => $too3), array('id' => $kc3['kcid']));
			 }
			 if($wxpay['od4'] != 0){
             pdo_update($this->table_order, array('status' => 1), array('id' => $wxpay['od4']));
			 pdo_update($this->table_tcourse, array('yibao' => $too4), array('id' => $kc4['kcid']));
			 }
			 if($wxpay['od5'] != 0){
             pdo_update($this->table_order, array('status' => 1), array('id' => $wxpay['od5']));
			 pdo_update($this->table_tcourse, array('yibao' => $too5), array('id' => $kc5['kcid']));
			 }
		 }
		if ($params['from'] == 'return') {
			$url = $this->createMobileUrl('order', array('schoolid' => $wxpay['schoolid']),true);
			if ($params['result'] == 'success') {
            message('支付成功！', $url);
			} else {
            message('支付失败！', $url);
			}
		}
	}	
}
