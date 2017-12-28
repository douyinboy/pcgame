//reg form submit
function reg_submit()
{
        var isok=gID("is_ok");
        if(isok.checked==true)
        {   
            var login_name = gID('login_name').value;
            if($.trim(login_name).length == 0) {
                    gID('u_info').className="right-sertitle-b";
                    gID('u_info1').className="";
                    gID('u_info').innerHTML="用户名不能为空!";
                    gID('login_name').focus();
                    return false;
            }
            if($.trim(login_name).length < 4 || $.trim(login_name.length) > 20) {
                    gID('u_info').className="right-sertitle-b";
                    gID('u_info1').className="";
                    gID('u_info').innerHTML="用户名长度4-20字符";
                    gID('login_name').focus();
                    return false;
            }	
            gID('u_info').className="right-sertitle-b";
            gID('u_info1').className="";
            var login_pwd = $.trim(gID('login_pwd').value);
            if(login_pwd.length == 0) {
                    gID('p_info1').className="";
                    gID('p_info').className="right-sertitle-b";
                    gID('p_info').innerHTML="密码不能为空!";
                    gID('login_pwd').focus();
                    return false;
            }
            if(login_pwd.length <6 || login_pwd.length>12) {
                gID('p_info1').className="";
                gID('p_info').className="right-sertitle-b";
                gID('p_info').innerHTML="密码长度不对!密码长度6~12个字符";
                gID('login_pwd').focus();
                return false;
            } else {
                gID('p_info1').className="";
                gID('p_info').className="right-sertitle-b";
                gID('p_info').innerHTML="<font color='green'>密码输入正确!</font>";
            }

            var relogin_pwd = $.trim(gID('relogin_pwd').value);
            if(relogin_pwd.length == 0) {
                gID('p_info21').className="";
                    gID('p_info').className="right-sertitle-b";
                    gID('p_info2').innerHTML="确认密码不能为空!";
                    gID('relogin_pwd').focus();
                    return false;
            }

            if(login_pwd==relogin_pwd){
                gID('p_info21').className="";
                    gID('p_info2').className="right-sertitle-b";
                    gID('p_info2').innerHTML="<font color='green'>两次密码输入一致!</font>";
            } else {
                gID('p_info21').className="";
                    gID('p_info2').className="";
                    gID('p_info2').innerHTML="<font color='red'>两次密码输入不一致!</font>";
                    return false;
            }

            var email = $.trim(gID('email').value);
            if(email.length == 0) {
                gID('e_info1').className="";
                    gID('e_info').className="right-sertitle-b";
                    gID('e_info').innerHTML="邮箱不能为空!";
                    gID('email').focus();
                    return false;
            }
            gID('e_info1').className="";
            gID('e_info').className="right-sertitle-b";
            var truename = $.trim(gID('truename').value);
            if(truename.length == 0) {
                    gID('n_info1').className="";
                    gID('n_info').className="right-sertitle-b";
                    gID('n_info').innerHTML="姓名不能为空!输入真实姓名,例如: 张三";
                    gID('truename').focus();
                    return false;
            }		
            gID('n_info').className="right-sertitle-b";
            gID('n_info1').className="";

            var idcard = $.trim(gID('idcard').value);
            if(idcard.length == 0) {
                    gID('id_info1').className="";
                    gID('id_info').className="right-sertitle-b";
                    gID('id_info').innerHTML="请输入身份证号码,例如: 440106198202020555";
                    gID('idcard').focus();
                    return false;
            }
            var reg = /(^\d{15}$)|(^\d{17}(\d|X|x)$)/;
            if(reg.test(idcard) === false)
            {
                    gID('id_info1').className="";
                    gID('id_info').className="right-sertitle-b";
                    gID('id_info').innerHTML="身份证有误,例如: 440106198202020555";
                    gID('idcard').focus();
                    return false;
            }
            gID('id_info1').className="";
            gID('id_info').className="right-sertitle-b";

            var chk_code = $.trim(gID('chk_code').value);
            if(chk_code.length == 0) {
                    gID('code_info1').className="";
                    gID('code_info').className="right-sertitle-b";
                    gID('code_info').innerHTML="验证码不能为空!";
                    gID('chk_code').focus();
                    return false;
            }
            gID('code_info1').className="";
            gID('code_info').className="right-sertitle-b";
            var u_chk=gID('u_chk').value;//用户名验证状态值
            var m_chk=gID('m_chk').value;//电子邮件验证状态值
            var c_chk=gID('c_chk').value;//验证码验证状态值
            var tn_chk=gID('tn_chk').value;//真实姓名验证状态值
            var id_chk=gID('id_chk').value;//身份证验证状态值		
            if(u_chk ==1 && m_chk==1 && c_chk==1 && tn_chk==1 && id_chk==1 ) { //表单正确提交
                $('#regform').submit();
                return true;
            }else{
                alert('请修正红色提示部分!');
                return false;
            }
	}else{
		alert("您必须接受77wan平台用户名使用协议和隐私证策!");
		return false;
	}
}

//reg form check
function reg_check(fid,paras,info_id,info){
	if(gID(fid).value.length == 0){
		gID(info_id+'1').className="";
		gID(info_id).className="right-sertitle-b";
		gID(info_id).innerHTML=info;
		return false;
	} else {
		var url='/api/check.php';
		$.ajax(
		{
			type:"POST",
			url:url,
			data:paras,//表单参数    
			success: function(result)
			{  
				if(result!=''){
					var msgg = result.split("a1_ww_1a");
					if(msgg[1]!=''){
						gID(msgg[1]).value=msgg[2];
					}
					gID(info_id+'1').className="";
					gID(info_id).className="right-sertitle-b";
					gID(info_id).innerHTML=msgg[0];
				} else {
					gID(info_id).className="right-sertitle-b";
					alert('表单填写不正确，请检查!');
					return false;
				}
			},
			error:function()
			{
				alert('网络故障，验证失败!');
				return false;
			}
		});
	}
}


//password check
function pw_check(){
	if(gID('relogin_pwd').value.length == 0){
		gID('p_info2').className="right-sertitle-b";
		gID('p_info21').className="";
		gID('p_info2').innerHTML="确认密码不能为空!";
		return false;
	} 
	if(gID('relogin_pwd').value != gID('login_pwd').value){
		gID('p_info2').className="right-sertitle-b";
		gID('p_info21').className="";
        gID('p_info2').innerHTML="两次密码输入不一致!";
		  return false;
	} else {
		gID('p_info21').className="";
		gID('p_info2').className="right-sertitle-b";
		gID('p_info2').innerHTML="<font color='green'>两次密码输入一致!</font>";
	}

}


var ref;
try{
    ref = document.referrer;
}catch(e){}


function pwStrength(val,_bool){
	//var pwlevel = gID('pwlevel');
	
	var len = val.length;
	if( _bool){
		if(val.length < 6 || val.length>12){
			//pwlevel.className="Strength0";
			gID('p_info').className="right-sertitle-b";
			gID('p_info1').className="";
			gID('p_info').innerHTML="密码长度不对!密码长度6~12个字符!";
			return false;
		} else {
			gID('p_info').className="right-sertitle-b";
			gID('p_info1').className="";
			gID('p_info').innerHTML="<font color='green'>请牢记您的密码</font>";
		}
	}

	var _NumberCount = len - val.replace(/\d/g,'').length;
	if(len == _NumberCount)
	{
		//pwlevel.className="Strength1";
		return true;
	}
	var _UpperCount = len - val.replace(/[A-Z]/g,'').length;
	if(len == _UpperCount){
		//pwlevel.className="Strength1";
		return true;
	}
	var _LowerCount = len - val.replace(/[a-z]/g,'').length;
	if(len == _LowerCount){
		//pwlevel.className="Strength1";
		return true;
	}
	if(_LowerCount+_UpperCount+_NumberCount == len){
		//pwlevel.className="Strength2";
	} else {
		//pwlevel.className="Strength3";
	}
	return true;
}

function movediv(url,title,css,cajax,scrolling,top,left,cssid){
	if(!cssid){
		cssid="movediv";
	}
	gID(cssid).style.display='';
	
	if(!scrolling){scrolling='auto';}
	
	var infos='<div class="clear" id=move_div_info style="clear: both;text-align:center;height:100%"><\/div>';
	
	if(!title)
	{
		title='';
	}
	
	gID(cssid).innerHTML = '<div id="movediv_">'+
		'<div class="movediv clear" onmousedown="canmove(document.getElementById(\'movediv_\'),event)">'+
				'<div style="float:left;height:25px;clear: both;margin-top:8px;margin-left:5px;font-size: 12px;font-weight: bold;color: #FF9900;width:75%;text-align:left;">'+title+'<\/div>'+
				'<div style="float: right;cursor:pointer;height:25px;margin-top:5px;margin-right:3px;width:21px;text-align:right;" title="关闭" onClick="logoutdiv();"><img src="http://image.demo.com/index/close.jpg" width="21" height="21" \/><\/div>'+
		'<\/div>'+
		infos+
	'<\/div>';
	
	var mobj=gID("movediv_");
	
	mobj.className=css;
	
	document.documentElement.scrollTop = 0; 

	var yw = document.documentElement.clientWidth; 
	
	var yh = document.documentElement.clientHeight; 
	
	var w = mobj.clientWidth||mobj.offsetWidth;
	
	var h = mobj.clientHeight||mobj.offsetHeight;
		
	if(!top && !left)
	{
	//	mobj.style.top=((yh/2)-(h/2))+"px";
		mobj.style.top="300px";	
		mobj.style.left=((yw/2)-(w/2))+"px";
	}else{
		if(!top)
		{
			//mobj.style.top=((yh/2)-(h/2))+"px";
			mobj.style.top="300px";	
			mobj.style.left=left+"px";
		}else if(!left)
		{
			//mobj.style.top=top+"px";
			mobj.style.top="300px";		
			mobj.style.left=((yw/2)-(w/2))+"px";
		}else{
			//mobj.style.top=top+"px";
			mobj.style.top="300px";		
			mobj.style.left=left+"px";
		}

	}
		gID("move_div_info").innerHTML='<iframe src="'+url+'" hspace="0" vspace="0" frameborder="0" scrolling="'+scrolling+'" height="100%" width="100%"><\/iframe>';
}

function logoutdiv(cssid)
{
	if(!cssid)
	{
		cssid="movediv";
	}
	gID(cssid).style.display='none';
}


function canmove(elementToDrag, event)
{
	var deltaX = event.clientX - parseInt(elementToDrag.style.left);
	var deltaY = event.clientY - parseInt(elementToDrag.style.top);
	
	elementToDrag.style.cursor = "move";
	
	if (document.addEventListener)
	{//2 级 DOM事件模型
		document.addEventListener("mousemove", moveHandler, true);
		document.addEventListener("mouseup", upHandler, true);
	}else if (document.attachEvent){//IE5+事件模型
	
		document.attachEvent("onmousemove", moveHandler);
		document.attachEvent("onmouseup", upHandler);
	}else {//IE4事件模型
		document.onmousemove = moveHandler;
		document.onmouseup = upHandler;
	}
	
	//禁止起泡
	if (event.stopPropagation)//DOM2
	event.stopPropagation();
	else event.cancelBubble = true;//IE
	
	if (event.preventDefault)
	event.preventDefault();
	else event.cancelBubble = true;
	
	function moveHandler(e)
	{
		if (!e)
		e = window.event;
		
		elementToDrag.style.left = (e.clientX - deltaX) + "px";
		elementToDrag.style.top = (e.clientY - deltaY) + "px";
		
		if (e.stopPropagation)
		e.stopPropagation();
		else e.cancelBubble = true;
	}
	
	function upHandler(e)
	{
		if (!e)
		e = window.event;
		
		elementToDrag.style.cursor = "default";
		
		if (document.removeEventListener)
		{ //DOM2
			document.removeEventListener('mousemove', moveHandler, true);
			document.removeEventListener('mouseup', upHandler, true);
			
		}else if (document.detachEvent) 
		{ //IE5+
			document.detachEvent("onmousemove", moveHandler);
			document.detachEvent("onmouseup", upHandler);
			
			
		}else {//IE4
			document.onmousemove = moveHandler;
			document.onmouseup = upHandler;
		}
		
		if (e.stopPropagation)
		e.stopPropagation();
		else e.cancelBubble = true;
	}
}