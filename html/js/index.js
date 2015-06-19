$(function(){
	$('.process_info_ul li a').mouseover(function(){
		var oldPosition = $(this).parent().css('background-position');
		oldPosition = oldPosition.split("px");
		oldPosition[0] = parseInt(oldPosition[0]) - 80 + "";
		var newPosition = oldPosition.join("px");
		$(this).parent().css('background-position', newPosition);
	});
	
	$('.process_info_ul li a').mouseout(function(){
		var oldPosition = $(this).parent().css('background-position');
		oldPosition = oldPosition.split("px");
		oldPosition[0] = parseInt(oldPosition[0]) + 80 + "";
		var newPosition = oldPosition.join("px");
		$(this).parent().css('background-position', newPosition);
	});
});