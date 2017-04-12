define(['jquery','js/tool','core'],function($,R,core){
	/**
	 * 价格滑动块 
	 */
	R.pricerange = (function($) {
	    function range(slider, custom) {
	        if (custom && custom.container && custom.container.size() > 0) {
	            var fun = arguments.callee;
	            fun.num = fun.num ? fun.num++ : fun.num = 1;
	            var sliderconf = {
	                //slider插件默认参数
	                min: 0,
	                //最小值
	                max: 100,
	                //最大值
	                step: 1,
	                //滑动间隔
	                onFinish: function() {}
	            };
	            var customconf = {
	                //用户自定义默认参数
	                container: null //显示滑块的容器dom
	            };
	            $.extend(customconf, custom);
	            $.extend(sliderconf, slider);
	            customconf.id = 'PRICERANGE' + fun.num;
	            customconf.container.html('<input type="text" id="' + customconf.id + '" />');
	            $('#' + customconf.id).ionRangeSlider(sliderconf);
	        }
	    }
	    ;
	    /**
	    * 获取价格配置信息 
	    */
	    function priceconfig(callback) {
	        if (priceconfig.data) {
	            callback(data);
	        } 
	        else {
	        	core.post('night_data_config',{},function(data){
	        		if (data.success == 'true') {
                        priceconfig.data = data;
                        callback(data);
                    }
	        	});
	        }
	    }
	    /**
	     * @param {Object} slideropt 滑块配置参数 
	     */
	    return function(slideropt, pricecal) {
	        slideropt = slideropt || {};
	        var curprice = 0;
	        var customkey = {
	            buy: 'dgnightconfig',
	            send: 'fastaddmoneyconfig'
	        };
	        priceconfig(function(result) {
	            var sliderconf = {
	                //slider插件默认参数
	                customtype: 'buy',
	                //价格类型，是帮我买buy还是帮我送send
	                min: curprice,
	                //最小值
	                max: 100,
	                //最大值
	                from: curprice,
	                from_min: curprice,
	                step: 1,
	                grid: true,
	                //滑块下面显示栅格
	                hide_min_max: true,
	                //隐藏最大最小值
	                grid_num: 4,
	                grid_margin: true,
	                postfix: '元'
	            };
	            $.extend(sliderconf, slideropt);
	            var pricetype = customkey[sliderconf.customtype];
	            if (pricetype) {
	                var customconf = {
	                    //用户自定义默认参数
	                    container: $('#pricecon')//显示滑块的容器dom
	                };
	                result = result[pricetype] || {};

	                $.extend(sliderconf, {
						min: result.start,
						max: result.max,
						from: result.start,
						from_min: result.start
	                });
					
	                curprice = sliderconf.from;
	                sliderconf.onFinish = function(data) {
	                    curprice = data.from;
	                    if (typeof slideropt.onFinish == 'function') {
	                        slideropt.onFinish(data);
	                    }
	                }
	                ;
	                delete sliderconf.customtype;
	                range(sliderconf, customconf);
	                if (typeof pricecal == 'function') {
	                    pricecal(result);
	                }
	            }
	        });
	        return {
	            getprice: function() {
	                return curprice;
	            }
	        };
	    }
	    ;
	})(jQuery);
});

