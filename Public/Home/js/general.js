$(function(){

	//导航鼠标放上效果
	$(".h-b-body > ul li").bind({"mouseover":function(){
		$(this).find('>a').css("color","#C40000");

	},"mouseout":function(){
		$(this).find('>a').css("color","black");
	}});

	//点评下拉效果
	/*
	$(".comment-list").bind({"mouseover":function(){
		// $('.comment-show').css("display","block");
		$(".comment-show").stop().fadeTo("slow",1,function(){
            $(this).css("display", "block");
        })
	},"mouseout":function(){
		// $('.comment-show').css("display","none");
		$(".comment-show").stop().fadeTo("slow",0,function(){
            $(this).css("display", "none");
        })
	}});
	*/
	//云管家下拉效果
	$(".yungj-list").bind({"mouseover":function(){
		$(".yungj-show").stop().fadeTo("slow",1,function(){
            $(this).css("display", "block");
        })
	},"mouseout":function(){
		$(".yungj-show").stop().fadeTo("slow",0,function(){
            $(this).css("display", "none");
        })
	}});
})