//初始化百度地图  以及业务范围
function showMap(obj,addr,city,latlngData,Zoom){
    Zoom = Zoom || 16;
    $('.map').addClass('active');
    $('.map').show();
	// 百度地图API功能
	//启用地图惯性拖拽，默认禁用
    var myIcon = new BMap.Icon("../addons/imeepos_runner/public/images/ic_Locate.png", new BMap.Size(36,62));
	map.addControl(new BMap.NavigationControl());
	// 创建地址解析器实例
	var myGeo = new BMap.Geocoder();
	// 将地址解析结果显示在地图上,并调整地图视野
	myGeo.getPoint(addr, function(point){
		if (point) {
			map.centerAndZoom(point, Zoom);
			map.addOverlay(new BMap.Marker(point,{icon:myIcon}));
		}else{
			//alert("您选择地址没有解析到结果!");
		}
	}, city);
	if(latlngData){
		var lists = latlngData;
		var points=[];
		for (var i = 0; i < lists.length; i++) {
            var lonlat = lists[i].split(",");
            if (lonlat.length == 2) {
                newpoint = new BMap.Point(lonlat[0], lonlat[1]);
                points.push(newpoint);
            }
        }
		if (points.length > 0) {
            var polygon = new BMap.Polygon(points, { fillColor: "red", fillOpacity: 0.1, strokeColor: "red", strokeAlpha: 0.9, strokeThickness: 2 });
            map.addOverlay(polygon);
            IsDbClick = true;
        }
	}
}

//获得地址经纬度
function getAddress(address,city,callback){
	var addrList = document.getElementById('addrList');
    var oFrag = $(document.createDocumentFragment());
	//获得地址
	$.ajax({
		type:"get",
		url:"http://api.map.baidu.com/place/v2/search?query="+address+"&region="+city+"&page_size=10&output=json&ak=F51571495f717ff1194de02366bb8da9",
		dataType:"jsonp",
		success:function(data){
			if(data["status"]==0){
				//清空Li
				//addrList.innerHTML = ' ';
                $(addrList).find('li.citylist').remove();
				var obj=data["results"];
				for(var i= 0,len=obj.length;i<len;i++){
					var name=obj[i]["name"],             //获取下拉列表的地点列表
					    addr=obj[i]["address"] || '',          //获取下拉的具体地址
					    lng=obj[i]["location"]["lng"] || '',   //获取经纬度
					    lat=obj[i]["location"]["lat"] || '',
					    li="<li class='citylist' data-longitude='"+lng+"' data-latitude='"+lat+"' data-text='"+name+"' data-addr='"+addr+"'>" +
                            "<i><img src='../addons/imeepos_runner/public/images/ic_Locate1.png' style='width:1.5rem;height:1.5rem;'/></i>" +
                            "<span><b>"+name+"</b><br />"+addr+"</span></li>";   //创建li
                    oFrag.append(li);
				}
                $(addrList).append(oFrag);
			}
		}
	});
}


