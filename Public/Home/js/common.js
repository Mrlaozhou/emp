$(function(){
	$('.nav-center li').eq(1).hover(function(){
		$('.nav-sub-list').eq(0).stop().slideDown(500);
	},function(){
		$('.nav-sub-list').eq(0).stop().slideUp(500);
	})
})