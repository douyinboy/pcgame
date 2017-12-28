
/* ------------- 准备阶段 ---------->>> */
//过滤两端空格
function Trim() {
	return this.replace(/\s+$|^\s+/g,"");
}
String.prototype.Trim=Trim;

/* <<<---------- 准备阶段 ------------- */


/* ------------- AJAX相关 ---------->>> */
//创建XMLHttpRequest对象
function XHR() {
	var XHR = false;
	try {
		XHR = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			XHR = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (e2) {
			XHR = false;
		}
	}
	if (!XHR && typeof XMLHttpRequest != 'undefined') {
		XHR = new XMLHttpRequest();
	}
	return XHR;
}


function getHits(thisElm,info) {
	var $this = $(thisElm);
	var user_name = $.trim( $this.val() );
	$this.val(user_name)
	var $info=$("#"+info);
	if(user_name=='' || user_name.length<6 || user_name.length>20)
	{
		$this.addClass("input_error");
		$info.removeClass("msg_t").removeClass("msg_yes").addClass("msg_warn").html('用户名6-20个字符,由字母、数字组成');
	}	
	else{
		
		
		url = 'http://www.demo.com' +'/api/check.php?action=chkname&user_name='+encodeURIComponent(user_name);
		var	xmlHttp = XHR();
		
		xmlHttp.onreadystatechange = function() {
			if (xmlHttp.readyState < 4) {
				$this.removeClass("input_error");
				$info.removeClass("msg_warn").removeClass("msg_yes").addClass("msg_t").html("用户名在6-20位之内");
			} else {
				response = (xmlHttp.status == 200) ?xmlHttp.responseText:null;//"网络异常，错误代码为：" + xmlHttp.status;
				if(response){
					response = response.split("a1_ww_1a")
					if(response[2]=="1"){
						$this.removeClass("input_error");
						$info.removeClass("msg_warn").removeClass("msg_t").addClass("msg_yes").html(response[0]);
					}
					else{
						$this.addClass("input_error");
						$info.removeClass("msg_yes").removeClass("msg_t").addClass("msg_warn").html(response[0]);
					}
				}
				else{
					$this.addClass("input_error");
					$info.removeClass("msg_yes").removeClass("msg_t").addClass("msg_warn").html('网络异常');
				}
			}
		};
		xmlHttp.open("GET", url, true);
		xmlHttp.send(null);
		
	}
}

function checkPwd(thisElm,info){
	var $this = $(thisElm);
	var pwd = $this.val();
	var $info=$("#"+info);
	if( pwd.length < 6 || pwd.length > 18 ){
		$this.addClass("input_error");
		$info.removeClass("msg_yes").removeClass("msg_t").addClass("msg_warn").html('请确保密码在6-18个字符');
	}
	else{
		$this.removeClass("input_error");
		$info.removeClass("msg_warn").removeClass("msg_t").addClass("msg_yes").html('密码长度正确');
	}
}

function checkRePwd(thisElm,pwdId,info)
{
	var $this = $(thisElm);
	var rePwd = $this.val();
	var $pwd = $("#"+pwdId);
	var pwd = $pwd.val();
	var $info = $("#"+info);
	if( rePwd == "" ){
		$this.addClass("input_error");
		$info.removeClass("msg_yes").removeClass("msg_t").addClass("msg_warn").html('请再次输入密码');
	}
	else if( rePwd == pwd ){
		$this.removeClass("input_error");
		$info.removeClass("msg_warn").removeClass("msg_t").addClass("msg_yes").html('两次密码一致');
	}
	else{
		$this.addClass("input_error");
		$info.removeClass("msg_yes").removeClass("msg_t").addClass("msg_warn").html('两次密码不一致');
	}
}

function checkFormChangeSelf(theform){
	var usern = $.trim( theform.login_name.value );
	theform.login_name.value = usern;
	var passw = theform.login_pwd.value;
	var repwd = theform.repeat_pwd.value;
	if (usern==""){
		alert("请输入用户名");theform.login_name.focus();return false; 
	}
	if (passw==""){
		alert("请输入密码");theform.login_pwd.focus();return false; 
	}
	if (passw.length < 6 || passw.length >18){
		alert("请控制密码长度在6-18个字符");theform.login_pwd.focus();return false; 
	}
	if (repwd==""){
		alert("请输入确认密码");theform.repeat_pwd.focus();return false; 
	}
	if (passw != repwd){
		alert("确认密码与密码不一致");theform.repeat_pwd.focus();return false; 
	}
}
