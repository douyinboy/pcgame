//客服中心 提交问题检测
function help_question(){
	if($.trim($('#uname').val()).length<=0){
		alert('请填写玩家帐号!');
		$('#username').focus();
		return false;
	}
	if($.trim($('#rolename').val()).length<=0){
		alert('请填写角色名称!');
		$('#rolename').focus();
		return false;
	}
	if($('#game_id').val()=="0"){
		alert('请选择游戏!');
		return false;
	}
	if($('#server_id').val()=="0"){
		alert('请选择服务器!');
		return false;
	}
	if($.trim($('#title').val()).length<=0){
		alert('请填写问题标题!');
		$('#title').focus();
		return false;
	}
	if($.trim($('#content').val()).length<=0){
		alert('请填写问题内容!');
		$('#content').focus();
		return false;
	}
	$.ajax({
		type:"get",
		url:"api/login_user_status2.php",
		data:{state:1},
		//dataType : 'json',
		dataType:'jsonp',
		jsonp:'callback',				//默认值'callback',服务端用于接收回调函数名的get下标值
		jsonpCallback:'jsonp_get_login_status',	//提交到服务端的回调函数名,不设置默认由jquery随机生成
		success: function(data)
		{
			switch(data.code){
			case 1:
				//已登录
				$('#help_q').submit();
				break;
			default:
				//未登录
				alert("登录超时，请重新登录");
				window.popup_login.open();
				break;
			}
		},
		error:function()
		{
			return false;
		}
	});
}

function getGamSvrLst(gid){
	if(gid<=0){
		$('#server_div').hide().html('');
		return false;
	}
	var url='http://www.demo.com/help.php?act=question';
	var paras='&gslt=getSvrLst&gid='+gid;
	$.ajax({
		type:"POST",
		url:url,
		data:paras,   
        success: function(result){  
			if(result){
				$('#server_div').html('<div><select name="data[server_id]" id="server_id">'+result+'</select></div>').show();
			}else{
				return false;
			}
        },
        error:function(){
            alert('网络故障,获取游戏列表失败!');
            return false;
        }
    });
}