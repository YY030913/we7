define(['jquery','map','core','weixin'],function($,BMap,core,wx){
	
	wx.config(jssdkconfig);
	
	var tool = {};
	
	//经纬度转换为地理位置
	tool.showPosition = function(position,call) {
        var gpsPoint = new BMap.Point(position.coords.longitude,position.coords.latitude);
        BMap.Convertor.translate(gpsPoint, 0, function(point) {
        	var geoc = new BMap.Geocoder();
	        var pt = new BMap.Point(point.lng,point.lat); 
	        geoc.getLocation(pt, function(rs){
	        	 var addComp = rs.addressComponents;
	        	 if(call){
	        		 call(addComp);
	        	 }
	        });
        });
    }
	//根据ip定位
	function location(call) {
        $.ajax({
            url: 'http://api.map.baidu.com/location/ip?ak=F51571495f717ff1194de02366bb8da9',
            dataType: "jsonp",
            jsonp: "callback",
            timeout: 5000,
            success: function(data) {
            	if(call){
  	        		 call(data);
  	        	}
            },
            error: function(msg) {
                core.cancel(msg);
            }
        });
    }
	
	//微信获取地理经纬度
    function wxGetLocation(call) {
        wx.ready(function() {
            wx.getLocation({
                success: function(res) {
                    var lat = res.latitude;
                    // 纬度，浮点数，范围为90 ~ -90
                    var lng = res.longitude;
                    // 经度，浮点数，范围为180 ~ -180。
                    var position = {
                        'coords': {
                            'longitude': lng,
                            'latitude': lat
                        }
                    };
                    if(call){
	   	        		 call(position);
	   	        	}
                },
                fail: function() {
                	core.cancel('请在系统设置里打开微信定位功能');
                }
            });
        });
    }
});