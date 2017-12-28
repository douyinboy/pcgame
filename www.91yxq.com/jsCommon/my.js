function my_info_sumbit(){
	/*if(gID('email').value.length>0){
		var emailtest = /[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/;	
		if(!emailtest.test(gID('email').value)){
			alert('请填写正确的电子邮箱!');
			gID('email').focus();
			return false;
		}
	}*/
	if(gID('qq').value.length>0){
		if(gID('qq').value.length<3 || gID('qq').value.length>11){
			alert('请填写正确的QQ帐号,以便我们联系您!');
			gID('qq').focus();
			return false;
		}
	}
	if(gID('telephone').value.length>0){
		if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test(gID('telephone').value))){ 
			alert("请填写正确的手机号,以便我们联系您!");
			gID('telephone').focus();
			return false; 
		} 
	}
	return true;
}


function my_passwd_submit(){
	var oldpwd = gID('oldpwd').value;		
	if(oldpwd.length<6||oldpwd.length>20) {
		gID('o_info').innerHTML="<font color='red'>密码长度6~12个字符</font>";
		gID('oldpwd').focus();
		return false;
	} else {
		gID('o_info').innerHTML="";
	}
	var login_pwd = gID('login_pwd').value;
	if(login_pwd.length<6||login_pwd.length>12) {
		gID('p_info').innerHTML="<font color='red'>密码长度6~12个字符</font>";
		gID('login_pwd').focus();
		return false;
	} else {
		gID('p_info').innerHTML="<font color='green'>输入正确</font>";
	}
	
	var relogin_pwd = gID('relogin_pwd').value;
	if(relogin_pwd.length == 0) {
		gID('p_info2').innerHTML="<font color='red'>确认密码不能为空</font>";
		gID('relogin_pwd').focus();
		return false;
	} else {
		gID('p_info').innerHTML="<font color='green'>输入正确</font>";
	}
	
	if(login_pwd==relogin_pwd){
		gID('p_info2').innerHTML="<font color='green'>两次密码输入一致</font>";
	} else {
		gID('p_info2').innerHTML="<font color='red'>两次密码输入不一致</font>";
		return false;
	}		
	return true;
}
function my_passwd_1(){
	var oldpwd = gID('oldpwd').value;		
	if(oldpwd.length<6||oldpwd.length>12) {
		gID('o_info').innerHTML="<font color='red'>密码长度6~12个字符</font>";
		return false;
	} else {
		gID('o_info').innerHTML="";
	}
}
function my_passwd_2(){
	var login_pwd = gID('login_pwd').value;
	if(login_pwd.length<6||login_pwd.length>12) {
		gID('p_info').innerHTML="<font color='red'>密码长度6~12个字符</font>";
		return false;
	} else {
		gID('p_info').innerHTML="<font color='green'>输入正确</font>";
	}
}
function my_passwd_3(){
	var login_pwd = gID('login_pwd').value;
    var relogin_pwd = gID('relogin_pwd').value;
	if(relogin_pwd.length == 0) {
		gID('p_info2').innerHTML="<font color='red'>确认密码不能为空</font>";
		return false;
	} else {
		gID('p_info').innerHTML="<font color='green'>输入正确</font>";
	}
	
	if(login_pwd==relogin_pwd){
		gID('p_info2').innerHTML="<font color='green'>两次密码输入一致</font>";
	} else {
		gID('p_info2').innerHTML="<font color='red'>两次密码输入不一致</font>";
		return false;
	}		
}
function my_indulge_sumbit(){
	var truename=gID('truename').value;
	var idcard=gID('idcard').value;
	var tn_chk=gID('tn_chk').value;
	var id_chk=gID('id_chk').value;
	
	if(truename.length == 0 || tn_chk!=1) {
		alert('请正确填写真实姓名！');
		gID('truename').focus();
		return false;
	} else if(idcard.length == 0 ||  id_chk!=1) {
		alert('请正确填写身份证号码！');
		gID('idcard').focus();
		return false;
	} else {
		return true;
	}
}
function my_question_submit(){
		var question = gID('question').value;
		
		if(question.length == 0) {
			alert("请选择密保问题");
			return false;
		}

		var answer = gID('answer').value;
		if(answer.length == 0) {
			alert("请填写密保答案");
			gID('answer').focus();
			return false;
		}
	return true;
}