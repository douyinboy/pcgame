
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


function getHits(user_name,info) {
	var o;
  o=document.getElementById(info);
	if(user_name=='' || user_name.length<=5 || user_name.length>=21)
	{
		o.innerHTML = '<font color=red>用户名6-20个字符,由字母、数字组成</font>';
	}	
	else{
		
		
	url ='/ajax/check.php?u='+user_name;
	var	xmlHttp = XHR();

 	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState < 4) {
			o.innerHTML="";
		} else {
			response = (xmlHttp.status == 200) ?xmlHttp.responseText:"网络异常，错误代码为：" + xmlHttp.status;
			if (response=='data=2') {
			 o.innerHTML = '<font color=green>此用户名可以注册</font>';
   
			} else if (response=='data=1') {
				o.innerHTML = '<font color=red>此用户名已被注册</font>';
			} else if (response=='data=3') {
				o.innerHTML = '<font color=red>此用户名不合法</font>';
			} else {
				o.innerHTML = '网络异常';
			}
		}
	};
 	xmlHttp.open("GET", url, true);
 	xmlHttp.send(null);
 	
}
}

function  chkpwd()
{
	var bb=document.getElementById("login_pwd").value;
	var a=document.getElementById("relogin_pwd").value;

	if (a!=bb)
	{
		document.getElementById("pw_info").innerHTML="<font color=red>两次输入的密码不一致</font>";
		return false; 
	}
	else
	{
		document.getElementById("pw_info").innerHTML='两次输入的密码一样';
	}
	
}
