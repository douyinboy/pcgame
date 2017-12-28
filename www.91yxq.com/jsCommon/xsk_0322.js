// JavaScript Document
function gID(fid){
	try{
		return document.getElementById(fid);	
	}catch(e){ return false;}
}

function check_get_xsk(aFrm){	
	var game_id = $("#game_id").val();
	var gameNameEn = $("#gameNameEn").val();
	var login_name = $("#login_name_card").val();
	var login_pwd = $("#login_pwd_card").val();
	
	if (login_name==""){
	 	alert("请输入账号！");
		return false;
	}
	
	if (login_pwd==""){
	 	alert("请输入密码！");
		return false;
	}
	
	var type = $("#get_type").val();
	if(type=='radio'){
		var server_id = $("input[name='server_id_card']:checked").val();
	}else if(type=='select'){
		var server_id = $('#server_id_card').val();
	}
	
	if(server_id == ''){
		alert("请选择服务器！");
		return false;
	}

	var paras='?act=1&login_name='+login_name+'&login_pwd='+login_pwd+'&game_id='+game_id+'&server_id='+server_id+'&gameNameEn='+gameNameEn;
	jsonUrl = 'http://www.5399.com/api/xsk.php' + paras;		
	getXskByJson(jsonUrl);
}

function getXskByJson(aJsonUrl){
	$.getJSON(aJsonUrl + '&callback=?',function(data){    //跨域问题解决
		switch(data){
		
			case '00':
				xskCode = '帐号或密码不正确！';
				break;
			case '01':
				xskCode = '帐号为空！';
				break;
			case '02':
				xskCode = '密码为空！';
				break;				
			case '03':
				xskCode = '主要参数错误！';
				break;
			case '04':
				xskCode = '该服新手卡礼包卡已赠送完！';
				break;	
			case '05':
				xskCode = '当前游戏尚未开通新手卡模块！';
				break;					
			default :
				xskCode = data;
			break;				
		}
		
		$("#gotXskCode").html('<span style="font-size:14px">您获得的新手卡是：<br/>'+xskCode+'</span>');		
		$("#gotFrmTab").show();		
		$("#getFrmTab").hide();							
	});
}