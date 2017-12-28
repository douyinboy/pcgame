;
//顶部添加收藏夹
function addFavorite(url,title)
{
	if (window.external && ("addFavorite" in window.external)){
		window.external.addFavorite(url,title);
		return false;
	}
	else if(window.sidebar ){
		if("addPanel" in window.sidebar){
			window.sidebar.addPanel(title, url, "customizeURL");
			return false
		}
		else{
			return true;
		}
	}
	else{
		alert("您的浏览器不支持此操作，请用快捷键Ctrl+D添加收藏夹。");
		return false;
	}
}

//登录时，点击保存用户名按钮事件
function SaveLoginFun(thisElm){
	if($(thisElm).is(":checked")){
		setCookie('save_login',1,86400*30);
	}else{
		setCookie('save_login',0,86400*30);
		setCookie('last_name','',0);
	}
}

//未登录或退出时，初始化快速登录表单显示样式
function CheckInput(){
	var save_login = getCookie('save_login')=='1';
	if(getCookie('last_name') && save_login){
		$("#SaveLogin").attr("checked","checked");
		setCookie('save_login',1,86400*30);
        user = unescape(getCookie('last_name')).replace("+"," ");
        $('#login_user').val(unescape(getCookie('last_name')).replace("+"," "));
        //if(getCookie('last_pass')){var tbd = getCookie('last_pass');$('#login_pwd').val(tbd);}
    }else{
		$("#SaveLogin").removeAttr("checked");
		setCookie('save_login',0,86400*30);
		//$('#login_user').val('');
		//$('#login_pwd').val('');
		
		$('#login_user').val('请输入账号');		
        $('#login_user').focus(function(){
            if($(this).val() == '请输入账号'){
				$(this).val('');
			}
            
        }).blur(function(){
            if($(this).val() == ''){
                $(this).val('请输入账号');
				$(this).next().show().removeClass('icon_yes2').addClass('icon_on');
            }
        }).bind('keyup',function(){
			if( $(this).val().length>0 ){
				$(this).next().hide();
			}
			else{
				$(this).next().show().removeClass('icon_yes2').addClass('icon_on');
			}
		});
	    $('#login_pwd').val('')
        $('#login_pwd').bind('blur keyup',function(){
			if( $(this).val().length>0 ){
				$(this).next().hide();
			}
			else{
				$(this).next().show().removeClass('icon_yes2').addClass('icon_on');
			}
		});
    }
}

//快速登录表单 - 检测登录状态
function CheckLogined(){
    var login_game_info = unescape(getCookie('login_game_info'));
    var login_name=unescape(getCookie('login_name'));
    var user_info = unescape(getCookie('userinfo'));
    if(login_name){
		//头像
		//alert(user_info); //981|1|0|1|/media/no_head_pic.gif
		var a = user_info.split('|');
		//var userid = a[0];
		//alert(a[4]); // /media/no_head_pic.gif
		//$('.in_login_info .avatar img').attr('src','http://bbs.demo.com/uc_server/avatar.php?uid='+userid+'&size=middle');
		$('.in_login_info .avatar img').attr('src',a[4]);
		//用户名
        var qq_nick=unescape(getCookie('qq_nick'));
        if(qq_nick&&login_name.indexOf('@qq')>0){
            $(".in_login_info").find('.name').html( '您好!'+qq_nick+' - '+login_name.replace("+"," ") );
        }else{
            $(".in_login_info").find('.name').html( "您好, "+login_name );
        }
		//上次登录时间
		//$('#login_time').html( unescape(getCookie('login_time')).replace("+"," ") );
		
		//玩过的游戏
        if(login_game_info != 0){
			var playedGames='';
			var gameList = login_game_info.split("<a");
			if(gameList.length>0){
				for(var i =0;i < 1;i++){
					gameinfo = gameList[i].split("_");
					key=0;
				//	playedGames += "<a style='color:rgb(48, 100, 59);' href='http://www.demo.com/turn.php?act=gamelogin&game_id="+gameinfo[key]+"&server_id="+gameinfo[key+1]+"' target='_blank'><span>"+gameinfo[key+2]+"</span></a> <a style='font-weight: bold;color:rgb(255, 0, 0);' href='http://pay.demo.com/?game_id="+gameinfo[key]+"&server_id="+gameinfo[key+1]+"' class='black' target='_blank'>[充值]</a> | ";
		            playedGames += "玩过的游戏： <a style='color:rgb(48, 100, 59);' href='http://www.demo.com/turn.php?act=gamelogin&game_id="+gameinfo[key]+"&server_id="+gameinfo[key+1]+"' target='_blank'><span>"+gameinfo[key+2]+"</span></a> ";
		    
				}
			}
            $('#lastgame').html( playedGames );
        }
		
        $('.in_login_info').show();
        $('.in_login').hide();
        setCookie('last_name',login_name,86400*30);
		
		
    } else {
        $('.in_login_info').hide();
        $('.in_login').show();
		
        CheckInput();
    }
}

//快速登录表单提交登录信息
function Login(){
    var forward = self_query('forward') ;
	if( forward ){
		forward = decodeURIComponent( forward );
	}
	else if( $("#forward").length>0 ){
		forward = $("#forward").val();
	}
	else{
		forward = "http://www.demo.com/index.html";
	}
	
    var login_user=$("#login_user").val();
    var login_pwd=$("#login_pwd").val();
    if( login_user == '' || login_user == '请输入账号'){
        login_tips.show_msg('请输入账号！');
        $("#login_user").focus().next().show().removeClass('icon_yes2').addClass('icon_on');
        return false;
    }
    else if(login_pwd == '' || login_pwd == '1234'){
        login_tips.show_msg('请输入密码！');
        $("#login_pwd").focus().next().show().removeClass('icon_yes2').addClass('icon_on');
        return false;
    }

    var url="http://www.demo.com/api/check_login_user.php?act=login";
    var paras={'login_user':login_user,'login_pwd':login_pwd};
    $.ajax(
    {
    type:"POST",
    url:url,
    data:paras,
    dataType : 'json',
    success: function(data)
    {
        switch(data.code){
            case '01':
                login_tips.show_msg(data.msg);
                break;
            case '02':
                login_tips.show_verify();
                break;
            case '11':
                alert('已经登录,请勿重复登录');
                if( forward ){
					window.location.href = forward;
				}
				else{
					window.history.back();
				}
                break;
            case '10':
				var save_login = $('#SaveLogin').is(':checked');
				if( save_login ){
					setCookie('save_login',1,86400*30);
					setCookie('last_name',login_user,86400*30);
				}
				else{
					setCookie('save_login',0,86400*30);
					setCookie('last_name','',86400*30);
				}
				$('#login_user').next().show().removeClass('icon_on').addClass('icon_yes2');
				$('#login_pwd').next().show().removeClass('icon_on').addClass('icon_yes2');
                
				login_tips.show_msg(data.msg);
				setTimeout(function(){
					
					if( forward ){
						window.location.href = forward;
					}
					else{
						window.history.back();
					}
					
				},1000);
                break;
        }
    },
    error:function()
    {
        login_tips.show_msg('网络故障，验证失败！');
        return false;
    }
    });
    return false;
}




