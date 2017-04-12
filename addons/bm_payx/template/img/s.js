$(function(){
	if($(".money").length>0){
		var num = $(".num td"),money=$(".money input"),close = $(".close"),btn=$(".comBtn");
		//输入金额
		num.tap(function(){
			if($(this).text()=="←"){
				var money_text = money.val();
				if(money_text.length>0){
					money_text=money_text.substring(0,money_text.length-1);
				}
				money.val(money_text);
			}else if(money.val().length<10){
				money.val(money.val()+$(this).text());
			}
			ifhide();
		});

		//清除内容
		close.tap(function(){
			money.val("");
			ifhide();
		});

		//是否显示
		function ifhide(){
			if(money.val().length>0){
				close.show();
				btn.attr("class","comBtn green");
			}else{
				close.hide();
				btn.attr("class","comBtn disabled");
			}
		}
	}

	//设置与加载幻灯片
	if($("#swipe-wrap").length>0){
		var len = getEle('swipe-wrap').children.length,bullets=getEle("positions");
		creatPoint(len);
		
		var slider =Swipe(document.getElementById('slider'), {
		    auto: 3000,
		    continuous: true,
		    callback: function(pos) {
		        var i = len;
		        while (i--) {
		            bullets.children[i].className = ' ';
		        }
		        bullets.children[pos].className = 'on';
		    }
		});

		function creatPoint(len){
		    var wid = getEle('wrapper').offsetWidth/len,li="";
		    for(var i=0;i<len;i++){
		        bullets.className.indexOf("position-round") ? li = li+"<li style='width:"+wid+"px'></li>" : li = li+"<li></li>" ;
		    }
		    bullets.innerHTML = li;
		    bullets.children[0].className="on";
		}
    }
});

function getEle(obj){
    return document.getElementById(obj);
};
function getTag(obj,i){
    return obj[i].getElementsByTagName('a')[0];
};