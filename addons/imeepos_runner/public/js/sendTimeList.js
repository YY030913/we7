define(['jquery','js/tool'],function($,R){
	
	/**
	 * @fileoverview 给传入的节点绑定期望送达时间scroll列表弹出事件
	 * @author mingrui| mingrui@rrkd.cn
	 * @version 1.0 | 2015-06-15
	 * @example
	 * 	var obj = R.sendTimeList.bind({elem:$('#expectedtime')}); 选择列表中的项后会覆盖节点的value或innerHTML
	 *  obj.gettime(); //如果选择15分钟内送到，则返回15
	 *  obj.show(); //触发给$('#expectedtime')绑定的事件显示弹层
	 */
	R.sendTimeList = (function($) {
	    var tpl = [
	    '<ul id="layer_sendTimeList" style="display:none;">', 
	    '<li data-val="">不限</li>', 
	    '<li data-val="15">15分钟内送到</li>', 
	    '<li data-val="30">30分钟内送到</li>', 
	    '<li data-val="45">45分钟内送到</li>', 
	    '<li data-val="60">1小时内送到</li>', 
	    '<li data-val="75">1小时15分钟内送到</li>', 
	    '<li data-val="90">1小时30分钟内送到</li>', 
	    '<li data-val="105">1小时45分钟内送到</li>', 
	    '<li data-val="120">2小时内送到</li>', 
	    '<li data-val="135">2小时15分钟内送到</li>', 
	    '<li data-val="150">2小时30分钟内送到</li>', 
	    '<li data-val="180">3小时内送到</li>', 
	    '</ul>'
	    ].join('');
	    //获取指定时间值
	    function setSendTime(Min) {
	        if (Min == '') {
	            return '不限';
	        }
	        Min = parseInt(Min);
	        var date = new Date();
	        date.setMinutes(date.getMinutes() + Min);
	        var m = date.getMonth() + 1;
	        m = m < 10 ? "0" + m : m;
	        var d = date.getDate();
	        d = d < 10 ? "0" + d : d;
	        var h = date.getHours();
	        h = h < 10 ? "0" + h : h;
	        var mm = date.getMinutes();
	        mm = mm < 10 ? "0" + mm : mm;
	        var time = h + ":" + mm;
	        return time;
	    }
	    var node = {
	        layer: null ,
	        //期望送达时间列表层
	        curnode: null //当前的节点对象
	    };
	    //送达时间弹层列表初始化
	    function init(callback) {
	        $('body').append(tpl);
	        node.layer = $('#layer_sendTimeList');
	        node.layer.mobiscroll().treelist({
	            theme: 'mobiscroll',
	            lang: 'zh',
	            display: 'bottom',
	            showInput: false,
	            onSelect: function(valueText, inst) {
					callback(valueText);
	                //当列表项被选择了触发，不管当前选择的和上次选择的是否相同
	                if (node.curnode) {
	                    node.curnode.data('time', valueText);
	                    var tagname = node.curnode.get(0).tagName.toLowerCase();
	                    var text = setSendTime(valueText);

	                    if (tagname == 'input' || tagname == 'textarea') {
	                        node.curnode.val(text);
	                    } else {
	                        node.curnode.html(text);
	                    }
	                }

	            }
	        });
	        init = function() {};
	    }
	    ;
	    /**
		 * 时间列表弹层类
	     * @param {Object} args
	     * {
	     * 	 elem*: 绑定弹层的节点对象
	     *   evtname: 触发弹层显示的事件，默认是touchend
	     * }
		 */
	    function caltimelist(args,callback) {
	        $.extend(this, {
	            elem: null ,
	            evtname: 'touchend'
	        }, args);
	        if (this.elem && this.elem.size() > 0) {
	            this.elem.on(this.evtname, function(e) {
	                init(callback);
	                node.curnode = $(this);
	                node.layer.mobiscroll('show');
	                return false;
	            });
	        } 
	        else {
	            throw new Error('caltimelist传入的节点不存在');
	        }
	    }
	    /**
		 * 获取当前选中的时间数据,没有则为''
		 */
	    caltimelist.prototype.gettime = function() {
	        return this.elem.data('time') || '';
	    }
	    ;
	    /**
		 *  显示弹层
		 */
	    caltimelist.prototype.show = function() {
	        this.elem.trigger(this.evtname);
	    }
	    ;
	    return {
	        /**
			 * 给指定input类型的节点绑定期望送达时间选择功能
	         * @param {Object} args
		     * {
		     * 	 elem*: 绑定弹层的节点对象
		     *   evtname: 触发弹层显示的事件，默认是touchend
		     * }
	         * @return {caltimelist类实例对象}
			 */
	        bind: function(args,callback) {
	            return new caltimelist(args,callback);
	        }
	    };
	})(R.$);
});

