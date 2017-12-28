////加载登录消息框js
var head = document.getElementsByTagName("head")[0],
    script  = document.createElement("script");
script.type = "text/javascript";
script.src = 'http://www.demo.com/jsCommon/login_tips.js';
head.insertBefore(script,head.firstChild);//head.appendChild(css);//后插可能效率差点
////

function CheckInput(){
    if(getCookie('last_name')){
        user = unescape(getCookie('last_name')).replace("+"," ");
        //alert(user);
        $('#login_user').val(unescape(getCookie('last_name')).replace("+"," "));
       // pass = unescape(getCookie('last_pass')).replace("+"," ");
        //alert(pass);
        if(getCookie('last_pass')){
            tbd = getCookie('last_pass');
            $('#login_pwd').val(tbd);
        }
    }else{
		$('#login_user').val('请输入91yxq帐号');		
        $('#login_user').focus(function(){
            if($(this).val() != '请输入91yxq帐号'){
				 return;
			}
            $(this).val('');
			$('#login_pwd').val('');
            $(this).css('color', '#000');
        }).blur(function(){
            if($(this).val() == ''){
                $(this).val('请输入91yxq帐号');
                $(this).css('color', '#666');
            }
        });
	    $('#login_pwd').val('1234');
        $('#login_pwd').focus(function(){
            if($(this).val() != '1234') return;
            $(this).val('');
            $(this).css('color', '#000');
        }).blur(function(){
            if($(this).val() == ''){
                $(this).val('1234');
                $(this).css('color', '#666');
            }
        });
    }
}

function CheckLogined(){
    var login_game_info = unescape(getCookie('login_game_info'));
    var login_name=unescape(getCookie('login_name'));
    var user_info = unescape(getCookie('userinfo'));
    if(login_name){
        var qq_nick=unescape(getCookie('qq_nick'));
        if(qq_nick&&login_name.indexOf('@qq')>0){
            gID('username').innerHTML='您好!'+qq_nick+' - '+login_name.replace("+"," ");
        }else{
            var a = user_info.split('|');
            var userid = a[0];
            gID('username').innerHTML="您好, "+login_name;
            //gID('user_pic').src='http://bbs.demo.com/uc_server/avatar.php?uid='+userid+'&size=middle';
            gID('login_time').innerHTML=unescape(getCookie('login_time')).replace("+"," ");
        }
        if(login_game_info != 0){
			var playedGames='';
			var gameList = login_game_info.split("<a");
			if(gameList.length>0){
				for(var i =0;i < 1;i++){
					gameinfo = gameList[i].split("_");
					key=0;
				//	playedGames += "<a style='color:rgb(48, 100, 59);' href='http://www.demo.com/main.php?act=gamelogin&game_id="+gameinfo[key]+"&server_id="+gameinfo[key+1]+"' target='_blank'><span>"+gameinfo[key+2]+"</span></a> <a style='font-weight: bold;color:rgb(255, 0, 0);' href='http://pay.demo.com/?game_id="+gameinfo[key]+"&server_id="+gameinfo[key+1]+"' class='black' target='_blank'>[充值]</a> | ";
		            playedGames += "玩过的游戏： <a style='color:rgb(48, 100, 59);' href='http://www.demo.com/main.php?act=gamelogin&game_id="+gameinfo[key]+"&server_id="+gameinfo[key+1]+"' target='_blank'><span>"+gameinfo[key+2]+"</span></a> ";
		    
				}
			}
            gID('lastgame').innerHTML=playedGames;
        }
        $('#loginin').show();
        $('#login').hide();
        setCookie('last_name',login_name,86400000*365);
    } else {
        $('#loginin').hide();
        $('#login').show();
        CheckInput();
    }
}

function CheckLoginedSon(){
    var login_game_info = unescape(getCookie('login_game_info'));
    var login_name=unescape(getCookie('login_name'));
    var user_info = unescape(getCookie('userinfo'));
    if(login_name){
        var qq_nick=unescape(getCookie('qq_nick'));
        if(qq_nick&&login_name.indexOf('@qq')>0){
           // gID('username').innerHTML='您好！'+qq_nick+' - '+login_name;
        }else{
            var a = user_info.split('|');
            var userid = a[0];
            //gID('user_pic').innerHTML='<img src="http://bbs.demo.com/uc_server/avatar.php?uid='+userid+'&size=middle" width="" height="44" />';
            gID('logined_username').innerHTML=login_name.replace("+"," ");
        }
        if(login_game_info != 0){
			var playedGames='上次玩过:';
			var gameList = login_game_info.split("<a");
			if(gameList.length>0){
				for(var i =0;i < gameList.length;i++){
					gameinfo = gameList[i].split("_");
					key=0;
					playedGames += "<a class='gre' href='http://www.demo.com/main.php?act=gamelogin&game_id="+gameinfo[key]+"&server_id="+gameinfo[key+1]+"' target='_blank'><span>"+gameinfo[key+2]+"</span></a> <a href='http://pay.demo.com/?game_id="+gameinfo[key]+"&server_id="+gameinfo[key+1]+"' class='black' target='_blank'>[充值]</a> | ";
				}
			}
            gID('last_logined_game').innerHTML=playedGames;
        }
        $('#loginin').show();
        $('#login').hide();
        setCookie('last_name',login_name,86400000*365);
    } else {
        $('#loginin').hide();
        $('#login').show();
        CheckInput();
    }
}

function CheckLoginedSonDpqk(){
    var login_game_info = unescape(getCookie('login_game_info'));
    var login_name=unescape(getCookie('login_name'));
    var user_info = unescape(getCookie('userinfo'));
    if(login_name){
        var qq_nick=unescape(getCookie('qq_nick'));
        if(qq_nick&&login_name.indexOf('@qq')>0){
           // gID('username').innerHTML='您好！'+qq_nick+' - '+login_name;
        }else{
            var a = user_info.split('|');
            var userid = a[0];
            //gID('user_pic').innerHTML='<img src="http://bbs.demo.com/uc_server/avatar.php?uid='+userid+'&size=middle" width="44" height="44" />';
            gID('logined_username').innerHTML='<span class="fl"><b>尊敬的 <a href="http://www.demo.com/my.php">'+login_name.replace("+"," ")+'</a></b> 你好！</span><span class="fr"><a href="http://www.demo.com/main.php?act=logout&href=/dpqk/">退出</a></span><div class="clearfix"></div>';
        }		

        if(login_game_info != 0){
			var playedGames='<em>最近玩过的游戏:</em>';			
			var gameList = login_game_info.split("<a");
			if(gameList.length>0){
				for(var i =0;i < gameList.length;i++){
					gameinfo = gameList[i].split("_");
					key=0;
					playedGames += "<span><a class='gre' href='http://www.demo.com/main.php?act=gamelogin&game_id="+gameinfo[key]+"&server_id="+gameinfo[key+1]+"' target='_blank'>"+gameinfo[key+2]+"</a> | <a href='http://pay.demo.com/?game_id="+gameinfo[key]+"&server_id="+gameinfo[key+1]+"' class='black' target='_blank'>[充值]</a></span>";
				}
			}
			playedGames += '<div style="margin-bottom:4px; clear:both;"></div>';
            gID('last_logined_game').innerHTML=playedGames;
        }
        $('#loginin').show();
        $('#login').hide();
        setCookie('last_name',login_name,86400000*365);
    } else {
        $('#loginin').hide();
        $('#login').show();
        CheckInput();
    }
}

function CheckTopLogined(){
    var login_name=unescape(getCookie('login_name'));
    if(login_name){
        gID('top_login').innerHTML="欢迎您,<a href='/my.php' style='color:#090909'><strong>"+login_name+"</strong></a>, <a href='/main.php?act=logout'>注销</a>";
    }
}

function Login(){
    var backUrl=$("#ref").val();
    if(backUrl=='' || typeof(backUrl)=='undefined'){
        backUrl= window.location.href;
    }
    var login_user=$("#login_user").val();
    var login_pwd=$("#login_pwd").val();
    if( login_user == '' || login_user == '请输入91yxq帐号'){
        login_tips.show_msg('请输入账号！');
        $("#login_user").focus();
        return false;
    }
    if(login_pwd == '' || login_pwd == '1234'){
        login_tips.show_msg('请输入密码！');
        $("#login_pwd").focus();
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
                location.href= backUrl;
                break;
            case '10':
                /*window.location.reload();*/
                location.href= backUrl;
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
function adLogin(par){   //POP.AD广告登陆
    var backUrl=$("#ref").val();
    if(backUrl=='' || typeof(backUrl)=='undefined'){
        backUrl= window.location.href;
    }
    var login_user=$("#login_user").val();
    var login_pwd=$("#passwd").val();
    if( login_user == '' || login_user == '请输入91yxq帐号'){
        login_tips.show_msg('请输入账号！');
        $("#login_user").focus();
        return false;
    }
    if(login_pwd == '' || login_pwd == '1234'){
        login_tips.show_msg('请输入密码！');
        $("#login_pwd").focus();
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
                location.href= backUrl;
                break;
            case '10':
                /*window.location.reload();*/
                location.href= "http://www.demo.com/"+par+"/list/index.html";
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

function ShowGame(gid,d){
    if(d==1){
        gID('game_'+gid).style.display='block';
    } else {
        gID('game_'+gid).style.display='none';
    }
}


function showAllGameLst(aFlag){
    if (gID("allGameLstDiv")){
        gameLstDiv = gID("allGameLstDiv");
        if(aFlag==1){
            gameLstDiv.style.display ='block';
        }else{
            gameLstDiv.style.display = 'none';
        }
    }
}

function copy_code(){
    ZeroClipboard.setMoviePath( 'http://image.demo.com/images/ZeroClipboard.swf' );
    var clip = new ZeroClipboard.Client();
    clip.setText( '' );
    clip.setHandCursor( true ); 
    clip.setCSSEffects( true ); 
    clip.addEventListener( 'load', function(client) {} );
    clip.addEventListener( 'complete', function(client, text) { 
        clip.hide();
    } );
    clip.addEventListener( 'mouseOver', function(client) {    } );
    clip.addEventListener( 'mouseOut', function(client) {    } );
    clip.addEventListener( 'mouseDown', function(client) {
        clip.setText( document.getElementById('card_id').innerHTML );
    } );
    clip.addEventListener( 'mouseUp', function(client) {
         alert("复制成功,赶快进入游戏去激活吧^-^");
    } );
    clip.glue( 'd_clip_button' );
}

function renqi(){
  var renqi=getCookie('renqi');
  if(renqi==''){
      renqi='265323,657138,359126,159126';
      setCookie('renqi',renqi,8400);
  }
 var renqi=getCookie('renqi');
 renqi=unescape(renqi);
 var renqi_array=renqi.split(',');
 i=0;
 $('.tit_wz_fr span').each(function(){
      var randnum = parseInt(Math.random()*6+1);
      renqi_array[i]=parseInt(renqi_array[i])+randnum;
      $(this).html(renqi_array[i]);
      i++;
  });
 renqi=renqi_array.join();
 setCookie('renqi',renqi,8400);
}