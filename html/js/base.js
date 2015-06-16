$(document).ready(function(){
	$("input[name=userEmail]").on('blur',function(){
		var	flag			= $.trim($('input[name=flag]').val());
		var loginEmail		= $.trim($(this).val());
		if(loginEmail == ''){
			showMsg("input[name=userEmail]",'请填写邮箱！');
			return false;
		}
		var parten_email	= /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
		if(!parten_email.test(loginEmail)){
			showMsg('input[name=userEmail', '邮箱格式不对！')
			return false;
		}
		$.ajax({
				url:		'index.php?mod=public&act=checkEmail',
				type:		'post',
				async:		false,
				dataType:	'json',
				data:		{'userEmail':loginEmail},
				success:	function(data){
					if(data.errCode == '200'){
						if(data.data > 0){
							if(flag == 'login'){
								showMsg("input[name=userEmail]",'邮箱正确！');
							}
							if(flag == 'addUser'){
								showMsg("input[name=userEmail]",'邮箱已被注册！');
								return false;
							}
						} else if(data.data == 0){
							if(flag == 'login'){
								showMsg("input[name=userEmail]",'邮箱还没注册！');
								return false;
							}
							if(flag == 'addUser'){
								showMsg("input[name=userEmail]",'邮箱可用！');
							}
						}
					} else {
						showMsg("input[name=userEmail]", data.errMsg);
						return false;
					}
				}
		});
	});
	
	$("input[name=search]").click(function(){
		var keywords	= $.trim($("input[name=keyWord]").val());
		if(keywords == ''){
			window.location.reload();
		} else {
			location	= 'index.php?mod=index&act=list&keyword='+keywords;
		}
	});
});

function checkCode(){
	var code	= $.trim($('input[name=code]').val());
	if(code == ''){
		showMsg('input[name=code]','验证码为空！');
		return false;
	}
	$.ajax({
		url:		'index.php?mod=public&act=checkCode',
		type:		'post',
		async:		false,
		dataType:	'json',
		data:		{"code":code},
		success:	function(data){
			if(data.errCode == '200'){
	
			} else {
				showMsg('input[name=code]','验证码错误！');
			}
		}
	});
}

function showMsg(name, msg){
	
	$(name).parent().children('.show_errMsg').text(msg);
	setTimeout(function(){
		$(name).parent().children('.show_errMsg').text('');
	},2000);
}


function checkStartTime(){
	var startTime	=	$("input[name='startTime']").val();
	var nowtime	=	new Date();
	
	if(startTime != ''){
		startTime	=	startTime.split('-');
		var t1		=	new Date(startTime);
		if(nowtime.getTime() < t1.getTime()){
			asyncbox.tips("开始时间不能大于当前时间",'alert',2000);
			$("input[name='startTime']").val('');
			return false;
		}
	}
}

function checkEndTime(){
	var startTime	=	$("input[name='startTime']").val();
	var endTime		=	$("input[name='endTime']").val();
	var nowtime	=	new Date();
	if(endTime != ''){
		endTime		=	endTime.split('-');
		var t2		=	new Date(endTime);
		if(nowtime.getTime() < t2.getTime()){
			asyncbox.tips("结束时间不能大于当前时间",'alert',2000);
			$("input[name='endTime']").val('');
			return false;
		}
	}
	var endTime		=	$("input[name='endTime']").val();
	if(startTime!='' && endTime!=''){
		startTime	=	startTime.split('-');
		endTime		=	endTime.split('-');
		var t1		=	new Date(startTime);
		var t2		=	new Date(endTime);
		if(t2.getTime()<t1.getTime()){
			asyncbox.tips("开始时间不能大于结束时间",'alert',2000);
			return false;
		}
	}
}

function checkTime(){
	if(checkStartTime() === false || checkEndTime() === false){
		return false;
	}
}