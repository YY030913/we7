$(function(){
	var num = $(".show-trans i");
	var money=$("#amount");
	//输入金额
	num.tap(function(){
	var str=$(this).data('str');
		if(str=="del"){
			var money_text = money.html();
			if(money_text.length>0){
				money_text=money_text.substring(0,money_text.length-1);
			}
			money.html(money_text);
		}else if(str=="hide"){//清除内容
			money.html("");
		}else{
			if(money.html().length<10){
				money.html(money.html()+str);
			}
		}
		var a = document.getElementById("amount");
		document.getElementById("qrmoney").value=a.innerHTML;
	});
});