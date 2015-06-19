$(function(){
	$(".nav_li").mouseover(function(){
		$(this).css('background-color', '#0753A3');
	});
	$(".nav_li").mouseout(function(){
		$(this).css('background-color', '');
	});
	$(".spread_li").mouseover(function(){
		$(this).css('background-color', '#7DC804');
	});
	$(".spread_li").mouseout(function(){
		$(this).css('background-color', '#83CE4A');
	});
	$(".loginstatus_ul").mouseover(function(){
		$(this).children('li').css('padding', '0px');
		$(this).children('li').css('border-width', '1px');
		$(this).children('li').css('background-color', '#317CCC');
		$(this).parent('div').css('overflow', 'visible');
	});
	$(".loginstatus_ul").mouseout(function(){
		$(this).children('li').css('padding', '1px');
		$(this).children('li').css('border-width', '0px');
		$(this).children('li').css('background-color', '');
		$(this).parent('div').css('overflow', 'hidden');
	});
	$.each($(".list_title_span a"), function(i){
		if($(this).attr('class') == 'list_current_a'){
			return;
		}
		$(this).mouseover(function(){
			$(this).attr('class', 'list_chosen_a');
		});
		$(this).mouseout(function(){
			$(this).removeAttr('class');
		});
	});
	$.each($(".bar_div a"), function(i){
		if($(this).attr('class') == 'bar_current_a'){
			return;
		}
		$(this).mouseover(function(){
			$(this).attr('class', 'bar_chosen_a');
		});
		$(this).mouseout(function(){
			$(this).removeAttr('class');
		});
	});
});