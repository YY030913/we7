define(['js/zepto.min','weixin'],function($,wx){
	/**
	 * Created with JetBrains WebStorm.
	 * User: Administrator
	 * Date: 15-5-12
	 * Time: 上午9:57
	 * To change this template use File | Settings | File Templates.
	 */
	var R = {
		$ : window.Zepto
	};

	//全局url路径
	var BaseUrl = "http://" + document.location.host + "/WeChat/";

	/**
	 * 正则验证 规则
	 * **/
	var regexEnum = {
		tell : /^1[3|4|5|7|8][0-9]\d{4,8}$/  //验证手机号
	};

	//返回上一页
	function goBack(){
		window.history.back();
	}

	//URL Encode编码处理
	function UrlEncode(url){
		return encodeURIComponent(url);
	}
	//URL Decode解码处理
	function UrlDecode(str){
	    return decodeURIComponent(str);
	}

	//获取URL参数
	function getQueryString(name) {
	    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	    var r = window.location.search.substr(1).match(reg);
	    if (r != null) return decodeURIComponent(r[2]); return null;
	}

	/**
	 * 获取移动端设备类型 return string
	 * **/
	var browser = {
		versions:function(){
			var u = navigator.userAgent, app = navigator.appVersion;
			return {   //移动终端浏览器版本信息
				ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
				android: u.indexOf("Android") > -1 || u.indexOf("Linux") > -1 //android终端
			};
		}(),
		language:(navigator.browserLanguage || navigator.language).toLowerCase(),
		getDeviceType:function(){
			if(browser.versions.ios){
				return  1;  //ios
			}else if(browser.versions.android){
				return  2;  //android
			}else{
				return  0; //无法获取到相关设备类型
			}
		}
	};
	/**
	 * 计算字符数 
	 */
	R.bLength = function(str){
		if (!str) {
			return 0;
		}
		var aMatch = str.match(/[^\x00-\xff]/g);
		return (str.length + (!aMatch ? 0 : aMatch.length));
	};
	/**
	 * 格式化时间差。返回值对应的规则说明如下
	 * 1. 大于等于1天：n天m小时
	 * 2. 1天内且大于等于1小时：n小时m分
	 * 3. 1小时内且大于等于1分：n分m秒
	 * 4. 1分内：n秒
	 * 如果timedif不是Number,则返回''.如果timedif<=0则返回'0秒'
	 * @param {Number} timedif* 时间差，以秒为单位
	 */
	R.formattimedif = function(timedif){
		if(typeof timedif != 'number'){
			return '';
		}
		if(timedif <= 0){
			return '0秒';
		}
		var difday = timedif/(24*60*60);
		var difhour,difminute;
		if(difday >= 1){ //大于等于1天
			var dayr = Math.floor(difday);
			var hourr = Math.floor((difday-dayr)*24);
			return dayr+'天'+hourr+'小时';
		}
		else if((difhour = timedif/(60*60)) >= 1){ //大于等于1小时
			var hourr = Math.floor(difhour);
			var minuter = Math.floor((difhour-hourr)*60);
			return hourr+'小时'+minuter+'分';
		}
		else if((difminute = timedif/60) >= 1){ //大于等于1分
			var minuter = Math.floor(difminute);
			var secondr = Math.floor((difminute-minuter)*60);
			return minuter+'分'+secondr+'秒';
		}
		else{
			return timedif+'秒';
		}
	};
	/**
	 * 把json数据转换成query格式
	 * @param argsobj {Object} json参数 {name:'aa',sex:'man'}
	 * @param encode {Boolean} 参数值是否编码，默认为true
	 * @returns {String} name=aa&sex=man
	 */
	R.jsonToQuery = function(argsobj,encode){
		if(typeof encode != 'boolean'){
			encode = true;
		}
		var result = [];
		for(var name in argsobj){
			if(encode){
				result.push(name + '=' + encodeURIComponent(argsobj[name]));
			}
			else{
				result.push(name + '=' + argsobj[name]);
			}
		}
		return result.join('&');
	};
	/**
	 * 把query格式的数据转换成json格式
	 * @param querystr {String} query格式参数 name=aa&sex=man
	 * @param decode {Boolean} 参数值是否解码，默认为true
	 * @returns {Object} {name:'aa',sex:'man'}
	 */
	R.queryToJson = function(querystr,decode){
		if(typeof decode != 'boolean'){
			decode = true;
		}
		var result = {};
		var arr = querystr.split("&");
	    for(var i = 0; i < arr.length; i ++) {
	  	   var itemarr = arr[i].split('=');
	  	   if(decode){
	  		  result[itemarr[0]] = decodeURIComponent(itemarr[1]);
	  	   }
	  	   else{
	  		  result[itemarr[0]] = itemarr[1];
	  	   }
	    }
	    return result;
	};
	/**
	 * 获取url中的参数
	 * @returns {Object}
	 * {
	 * 	  has: true|false 当前url是否有参数
	 *    data: {name:'aa'} has为true时，url中query格式的参数转换成json格式
	 * }
	 */
	R.getUrlArgs = function() {
	   var url = location.search.replace(/#.*$/,''); //获取url中"?"符后的字串
	   var result = {
		  has: false, //url中是否有传参数
		  data: {} //如果has是true,则data里有值
	   };
	   if (url.indexOf("?") != -1) {
		  result.has = true;
	      url = url.substr(1);
	      result.data = R.queryToJson(url);
	   }
	   return result;
	};

	(function($){
		/**
		 *  显示消息
		 * @param text
		 * @param type toast|success|error|info
		 * @param duration 持续时间，为0则不自动关闭
		 * @param clickMaskClose  点击遮罩层是否关闭  默认false
		 */
		R.showToast = function(text,type,cancelCall,duration,clickMaskClose,isMask)
		{
			type = type || 1;
			clickMaskClose = clickMaskClose || false;
	        isMask = isMask || false;
			return R.Toast.show(text,type,cancelCall,duration,clickMaskClose,isMask);
		};
		R.hideToast = function()
		{
			R.Toast.hide();
		};

		/**
		 * alert组件
		 * @param title 标题
		 * @param content 内容
		 */
		R.alert = function(title,content,okCall,btnName)
		{
			R.Popup.alert(title,content,okCall,btnName);
		};

		/**
		 * confirm 组件
		 * @param title 标题
		 * @param content 内容
		 * @param okCall 确定按钮handler
		 * @param cancelCall 取消按钮handler
		 * @param cancelName 取消按钮名称
		 * @param okName 确定按钮名称
		 */
		R.confirm = function(title,content,okCall,cancelCall,cancelName,okName){
			R.Popup.confirm(title,content,okCall,cancelCall,cancelName,okName);
		};

		/**
		 * ShowReg  用户注册
		 * @param  cancelCall  回调函数
		 * **/
		R.ShowReg = function(cancelCall,type)
		{
			type = type || 'reg';
			R.LoginReg.show(cancelCall,type);
		};
		/**
		 * ShowReg  用户登陆
		 * @param  cancelCall  回调函数
		 * **/
		R.ShowLogin = function(cancelCall,type)
		{
			type = type || 'login';
			R.LoginReg.show(cancelCall,type);
		};
		R.HideLoginReg = function()
		{
			R.LoginReg.hide();
		};
	    /**
	     * 微信录音提示层
	     * **/
	    R.showVoice = function(text)
	    {
	        R.voiceToast.show(text);
	    };
	    R.hideVoice = function()
	    {
	        R.voiceToast.hide();
	    }

	})(R.$);

	/**
	 * 普通消息框
	 * **/
	R.Toast = (function($){	
		var _toast,_mask,timer,_cancelCall,_clickMaskClose,
	        //定义模板
	        TEMPLATE = {
	            1 : '<span class="toast-icon">{value}</span>',//一般提示
	            2 : '',
	            3 : '{value}',//自定义html内容
	            4 : '<span class="toast-icon error-icon">{value}</span>'
	        };       
	    var _init = function()
	    {
	    	//全局只有一个实例
	        $('body').append('<div class="toast"><div class="toast-wrap"></div></div><div class="toast-mask"></div>');
	        _toast = $('div.toast');
	        _mask  = $('div.toast-mask');
	    }; 
	    var _show = function(text,type,cancelCall,duration,clickMaskClose,isMask)
	    {
	    	_init();
	    	_cancelCall = cancelCall;
	    	_clickMaskClose = clickMaskClose;
	    	var wrap = _toast.find(".toast-wrap");
	    	if(type == 3){
	    		wrap.addClass('toast-wrap-cover')
	    	}
		 	wrap.html(TEMPLATE[type].replace('{value}',text));
			_toast.show();
	        !isMask && _mask.show();
	        if(timer) clearTimeout(timer);
	        //设置居中显示
	        var height = _toast.height();
	        _toast.css({'marginTop': '-' + height/2 + 'px'}).animate('scaleIn',100,'linear',function(){$(this).css({opacity:1})});
			duration !== 0 ? timer = setTimeout(_hide,duration || 2000) : '';//如果不为0  则自动关闭
			_subscribeEvents();
			return _toast;
	    };
	    var _hide = function()
	    {
	    	if(_mask.length > 0 && _toast.length > 0)
	    	{
	    		_toast.animate('scaleOut',100,'linear',function(){$(this).remove()});
	    		_mask.remove();
				typeof _cancelCall === 'function' ? _cancelCall.call(this) : '';
	    	}
	    };
		var _subscribeEvents = function()
		{
			if(_mask.length > 0 && _clickMaskClose)
			{
				_mask.on('touchend',function(e){
	            	_hide();
	            	e.preventDefault();
	        	});
			}
		};
		return {
			show : _show,
			hide : _hide
		}
	})(R.$);


	/**
	 * 弹窗提示  alert  confirm
	 */
	R.Popup = (function($){
		var _popup,_mask,clickMask2close,
			TEMPLATE = {
				alert : '<div class="popup-title" id="POPUPLAYER-TITLE">{title}</div><div id="POPUPLAYER-CONTENT" class="popup-content popup-text-center">{content}</div><div class="popup-btns" id="POPUPLAYER-BTNS"><a data-target="closePopup" class="sure">{ok}</a></div>',
				confirm : '<div class="popup-title" id="POPUPLAYER-TITLE">{title}</div><div id="POPUPLAYER-CONTENT" class="popup-content">{content}</div><div class="popup-btns" id="POPUPLAYER-BTNS"><a class="cancel mr10" data-icon="close">{cancel}</a><a class="sure" data-icon="checkmark">{ok}</a></div>'
			},
		POSITION = {
			'top':{
				top:0,
				left:0,
				right:0
			},
			'center':{
				top:'50%',
				left:'0',
				right:'0',
				background:'#fff',
				'border-radius': '5px',
	            'opacity' : 0,
				 color: '#222'
			},
			'topRight':{
				top:0,
				right:0,
				left: 0
			}
		};
		var _init = function(){
			$('body').append('<div class="popup" id="POPUPLAYER"></div><div class="popup-mask" id="POPUPMASK"></div>');
			_mask = $('#POPUPMASK');
			_popup = $('#POPUPLAYER');
		};
		var _show = function(options){
			//初始化
			_init();
			//参数
			var settings = {
				opacity : 0,//透明度
				html : '',//popup内容
				clickMask2Close : false,// 是否点击外层遮罩关闭popup
				isTitle : false, //是否显示标题
				'pos' : 'center',
				textCenter : false,
				btnadd: false //.popup-btns是否添加.add
			};
			//合并参数
			$.extend(settings,options);
			clickMask2close = settings.clickMask2Close;
			var isTitle = settings.isTitle;
			_popup.css(POSITION[settings.pos]);
			_mask.css('opacity',settings.opacity);
			var html = settings.html;
			_popup.html(html).show();
			_mask.show();
			if( isTitle === false  ){
				$("#POPUPLAYER-TITLE").remove();
			}
			if( settings.pos == 'center' ){
				var height = _popup.height();
	            var width = _popup.width();
				_popup.css({'marginTop':'-'+height/2+'px'}).animate('scaleIn',100,'linear',function(){$(this).css({'opacity':1})});
			}
			if(settings.textCenter === true){
				$("#POPUPLAYER-CONTENT").addClass("popup-text-center");
			}
			if(settings.btnadd === true){
				$("#POPUPLAYER-BTNS").addClass("add");
			}
			_subscribeEvents();
		};
		var _hide = function(){
			if(_mask.length > 0 && _popup.length > 0)
			{
				_mask.remove();
				_popup.animate('scaleOut',100,'linear',function(){$(this).remove()});
			}
		};
		var _subscribeEvents = function(){
			if(_mask.length > 0 && clickMask2close)
			{
				_mask.on('touchend',function(e){
					clickMask2close && _hide();
					e.preventDefault();
				});
			}
		};
		var _alert = function(title,content,okCall,btnName,options){
			var markup = TEMPLATE.alert.replace('{title}',title).replace('{content}',content).replace('{ok}',btnName || '确定');
			_show($.extend({
				html : markup,
				pos  : 'center',
				isTitle : title=='' ? false : true,
				btnadd: true
			},options||{}));
			$('#POPUPLAYER-BTNS [data-target="closePopup"]').on('touchend',function(e){
				_hide();
				typeof okCall === 'function' ? okCall.call(this) : '';
				e.preventDefault();
			});
		};
		var _confirm = function(title,content,okCall,cancelCall,cancelName,okName,options){
			var markup = TEMPLATE.confirm.replace('{title}',title).replace('{content}',content).replace('{cancel}',cancelName || '取消').replace('{ok}',okName || '确定');
			var conf = $.extend({
				html : markup,
				isTitle : title=='' ? false : true,
				pos  : 'center',
				textCenter : content.indexOf('<') == -1 ? true : false
			},options||{});
			if(conf.textCenter){conf.btnadd = true;}
			_show(conf);
			$('#POPUPLAYER-BTNS [data-icon="checkmark"]').on('touchend',function(e){
				_hide();
				okCall.call(this);
				e.preventDefault();
			});
			$('#POPUPLAYER-BTNS [data-icon="close"]').on('touchend',function(e){
				_hide();
				typeof cancelCall === 'function' ? cancelCall.call(this) : '';
				e.preventDefault();
			});
		};
		return {
			show : _show,
			close : _hide,
			alert : _alert,
			confirm : _confirm
		}
	})(R.$);

	/**
	 * 录音层提示
	 * **/
	R.voiceToast = (function($){
	    var _toast,innerText,
	        TEMPLATE = '<img src="../addons/imeepos_runner/public/images/recording.gif" width="100" height="75" /><p style="font-size: 12px;color: #e6e6e6;">{value}</p>'
	        ;
	    var _init = function(){
	        //全局只有一个实例
	        $('body').append('<div class="voiceToast"></div>');
	        _toast = $('div.voiceToast');
	    };
	    var _show = function(text){
	        _init();
	        if(text){
	            innerText = text;
	        }else{
	            innerText = '例：请帮我在XX路买xx东西，大概xx元，谢谢啊。';
	        }
	        _toast.html(TEMPLATE.replace('{value}',innerText)).show();
	        var height = _toast.height();
	        var width = _toast.width();
	        _toast.css({marginLeft: -width/2 + 'px',marginTop: -height/2 + 'px'}).animate('scaleIn',100,'ease-in');
	    };
	    var _hide = function(){
	        if(_toast.length > 0){
	            _toast.animate('scaleOut',100,'ease-out',function(){$(this).remove()});
	        }
	    };
	    return {
	        show : _show,
	        hide : _hide
	    }
	})(R.$);

	/**
	 * 全局登陆框
	 * **/
	R.LoginReg = (function($){
		var _toast,_mask,_cancelCall,type,
			TEMPLATE =
			{
				reg   :   	'<div class="pop-login">'+
							'<h2>请输入本人手机号码</h2>'+
							'<p><input type="number" name="LoginTell" placeholder="请输入手机号码" maxlength="11" /><input type="button" value="获取验证码"></p>' +
							'<p><input type="number" name="LoginCode" placeholder="请输入验证码" /></p>' +
							'<p><a href="javascript:;" id="pop-login-btn">提交</a></p>' +
							'</div>',
				login :     '<div class="pop-login">'+
							'<h2></h2>'+
							'<p><input type="number" name="tell" placeholder="请输入手机号码" maxlength="11" /></p>' +
							'<p><input type="number" name=""code placeholder="请输入验证码" /></p>' +
							'<p><a href="javascript:;" id="pop-login-btn">提交</a></p>' +
							'</div>'
			};
		var _init = function()
		{
			//全局只有一个登陆框
			 $('body').append('<div class="login-toast"><div class="login-toast-wrap"></div></div><div class="login-toast-mask"></div>');
			 _toast = $('div.login-toast');
			 _mask  = $('div.login-toast-mask');
		};
		var _show = function(cancelCall,type)
		{
			_init();
			_cancelCall = cancelCall;
			_toast.find(".login-toast-wrap").html(TEMPLATE[type]);
			_toast.show();_mask.show();
			var height = _toast.height();
			_toast.css({'marginTop': '-' + height/2 + 'px'}).animate('scaleIn',100,'ease-in');
			switch (type){
				/**
				 * 注册
				 * **/
				case 'reg':
					//获取验证码
					_toast.find('input[type="button"]').on('touchend',function(e){
						var tellVal = $('input[name="LoginTell"]').val();
						var time = 60,_this = $(this), autoTime;
						if(_this.attr('disabled') === 'disabled')
						{
							return false;
						}
						if(!new RegExp(regexEnum.tell).test(tellVal))
						{
							R.alert('提示信息','请输入正确的手机号码'); return false;
						}
						autoTime = setInterval(function(){
							time--;
							_this.val(time + '秒重新获取');
							_this.attr('disabled','disabled');
							if(time === 0)
							{
								clearInterval(autoTime);
								_this.val('获取验证码');
								_this.removeAttr('disabled');
							}
						},999);
						//试行ajax请求  发送手机短信验证码
						$.ajax({
	                        type : 'post',
	                        url : BaseUrl + 'index.php?r=main/user/getMobileCode',
	                        data : {'mobile':tellVal,'code_type':2},
	                        dataType : 'json',
	                        success : function(data){
	                            if(data.success == 'true'){
	                            }else{
	                                R.alert('提示信息',data.msg);
	                                clearInterval(autoTime);
	                                _this.val('获取验证码');
	                                _this.removeAttr('disabled');
	                            }
	                        }
						});
						e.preventDefault();
					});
					//提交数据
	                var flag = true;
					if($('#pop-login-btn').length > 0){
						$('#pop-login-btn').on('touchend',function(e){
	                        //登录
	                        if(flag){
	                        	//验证不能为空
		                        var LoginTell = $.trim($('.pop-login').find('input[name="LoginTell"]').val()),
		                            LoginCode =  $.trim($('.pop-login').find('input[name="LoginCode"]').val());
		                        if(!new RegExp(regexEnum.tell).test(LoginTell)){
		                            R.alert('提示信息','请输入正确的手机号码');
		                            return false;
		                        }
		                        if(LoginCode == ''){
		                            R.alert('提示信息','请输入正确的验证码');
		                            return false;
		                        }
	                            flag = false;
	                            var node = $(this);
	                            node.html('正在提交...');
	                            $.ajax({
	                                type : 'post',
	                                url : BaseUrl + 'index.php?r=main/user/wxreglogin',
	                                data : {
	                                    'account' : LoginTell,
	                                    'mobilecode' : LoginCode
	                                },
	                                dataType : 'json',
	                                complete : function(){
	                                    flag = true;
	                                    node.html('提交');
	                                },
	                                success : function(data){
	                                    if(data.success == 'true'){
	                                        R.HideLoginReg();
	                                        typeof _cancelCall == 'function' ? _cancelCall.call(this) : '';
	                                    }else{
	                                        R.alert('提示信息',data.msg);
	                                    }
	                                }
	                            });
	                        }
	                        e.preventDefault();
						});
					}
				break;
				/**
				 * 登陆
				 * **/
				case 'login':
				break;
				default :
					alert('type未定义');
				break;
			}
		};
		var _hide = function()
		{
			if(_mask.length > 0 && _toast.length > 0)
			{
				_toast.animate('scaleOut',100,'ease-out',function(){$(this).remove()});
				_mask.remove();
			}
		};
		return {
			show : _show,
			hide : _hide
		};
	})(R.$);


	/**
	 * 查看禁止发布事项与查看平台服务使用规则
	 * **/
	R.Banned = (function($){
	    var _toast,_mask,_cancelCall,
	        TEMPLATE = {
	            1 : '{value}'
	        };
	    var _init = function(){
	        $('body').append('<div class="checkInfo-toast"></div><div class="info-mask"></div>');
	        _toast = $('div.checkInfo-toast');
	        _mask  = $('div.info-mask');
	    };
	    var _show = function(text,cancelCall){
	        _init();
	        _cancelCall = cancelCall;
	        _toast.html(TEMPLATE[1].replace('{value}',text));
	        _toast.show();_mask.show();
	        _toast.animate('scaleIn',100,'ease-in');
	        _toast.find('[data-icon="sure"]').on('touchend',function(e){
	            typeof _cancelCall === 'function' ? _cancelCall.call(this) : '';
	            _hide();
	            e.preventDefault();
	        });
	    };
	    var _hide = function()
	    {
	        if(_mask.length > 0 && _toast.length > 0)
	        {
	            _toast.animate('scaleOut',100,'ease-out',function(){$(this).remove()});
	            _mask.remove();
	        }
	    };
	    return {
	        show : _show,
	        hide : _hide
	    }
	})(R.$);



	/**
	 * 对cookie进行操作
	 * addCookie  添加 cookie
	 * getCookie  获取 cookie
	 * delCookie  删除 cookie
	 * **/
	R.cookie = (function(){

	    var _addCookie = function(objName, objValue, objHours) {   //添加cookie
	        var str = objName + "=" + escape(objValue);
	        if (objHours > 0) {                                  //为0时不设定过期时间，浏览器关闭时cookie自动消失
	            var date = new Date();
	            var ms = objHours * 3600 * 1000;
	            date.setTime(date.getTime() + ms);
	            str += "; expires=" + date.toGMTString();
	        }
	        document.cookie = str;
	    };
	    var _getCookie = function(objName) { //获取指定名称的cookie的值
	        var arrStr = document.cookie.split("; ");
	        for (var i = 0,len = arrStr.length; i < len; i++) {
	            var temp = arrStr[i].split("=");
	            if (temp[0] == objName) return unescape(temp[1]);
	        }
	        return false;
	    };
	    var _delCookie = function(name) { //为了删除指定名称的cookie，可以将其过期时间设定为一个过去的时间
	        var date = new Date();
	        date.setTime(date.getTime() - 10000);
	        document.cookie = name + "="+name+"; expires=" + date.toGMTString();
	    };
	    return{
	        addCookie : _addCookie,
	        getCookie : _getCookie,
	        delCookie : _delCookie
	    }
	})(R.$);


	/**
	 * 微信JSSDK初始化组件。wxinit.js不单独在页面引入，会放入tool.js中 
	 */
	//要使用的微信api接口列表
	R.wxjsApiList = [
	  //音频接口
		'startRecord',
		'stopRecord',
		'onVoiceRecordEnd',
		'playVoice',
		'pauseVoice',
		'stopVoice',
		'onVoicePlayEnd',
		'uploadVoice',
		'downloadVoice',
		'translateVoice',
		//图像接口
		'chooseImage', 
		'previewImage', 
		'uploadImage',
	    //微信支付接口
	    'chooseWXPay',
	    //地理定位
	    'getLocation'
	];

	R.debug = true;
	/**
	 * @fileoverview 使用微信JSSDK前，自动进行权限验证。如果检测到当前页面没有使用微信JSSDK，则不进行任何操作。
	 * @author mingrui| mingrui@rrkd.cn
	 * @version 1.0 | 2015-05-25
	 * @return null
	 */
	R.wxinit = (function($){
		function init(){
			wx.config(jssdkconfig);
		}
		if(typeof wx != 'undefined'){
			init();
		}
	})(R.$);
	/**
	 * @fileoverview 调用微信接口桥接组件,增加微信api使用透明度。微信官方api:http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
	 *  wxapiBridge.js不单独在页面引入，会放入tool.js中 
	 *  1. 调用此组件接口请在ready中调用，如下：
	 *     wx.ready(function(){//调用R.wxapiBridge的api});
	 * @author mingrui| mingrui@rrkd.cn
	 * @version 1.0 | 2015-05-25
	 * @return 
	 * 	1. 返回方法见R.wxjsApiList里面的方法列表，更多使用见微信官方api.
	 *  2. 调用所有方法传递的参数均为json，共同的参数项见argsconfig。特有的请参加官方文档
	 */
	R.wxapiBridge = (function($){
		var that = {};
		//调用所有音频方法中的默认参数
		var argsconfig = {
			success: function(res,error){}, //接口调用成功回调
			fail: function(res,error){}, //接口调用失败回调
			complete: function(res,error){} //接口调用完成回调，无论成功和失败
		};
		var wxapi = R.wxjsApiList;
		var apichecked = {}; //记录已经检测过的api,true为可用,false为不可用
		//获取格式化后的参数
		function getargs(args){
			return $.extend({},argsconfig,args || {});
		}
		//设置调用音频api的用户自定义函数
		function setapi(name){
			that[name] = function(args){
				wx[name](getargs(args));
			};
		}
		function init(){
			for(var i = 0, len = wxapi.length; i < len; i++){
				setapi(wxapi[i]);
			}
		}
		init();
		return that;
	})(R.$);

	/**
	 * 检测用户是否登录
	 * rutuen false  未登录
	 * return true   已登录
	 * **/
	function checkUserLogin(){
	   return !R.cookie.getCookie('user[userid]') || !R.cookie.getCookie('user[token]') || !R.cookie.getCookie('user[username]') ? false : true;
	}
	/**
	 * 检测登录，如果登录则执行logincallback，未登录则自动跳转到登录页面
	 * @param {Object} logincallback
	 */
	R.loginskip = function(logincallback){
		if(checkUserLogin()){
			if(typeof logincallback == 'function'){
				logincallback();
			}
		}
		else{
			location.href = BaseUrl + 'Authorised.php?go='+encodeURIComponent(location.href);
		}
	};
	/**
	 * 关闭微信浏览器 
	 */
	R.closewindow = function(){
		if(wx != undefined) {wx.closeWindow();}
	};
	
	return R;
});
