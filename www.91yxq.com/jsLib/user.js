function my_info_sumbit(){
	/*if(gID('email').value.length>0){
		var emailtest = /[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/;	
		if(!emailtest.test(gID('email').value)){
			alert('请填写正确的电子邮箱!');
			gID('email').focus();
			return false;
		}
	}*/
	if($('#qq').val().length>0){
		if($('#qq').val().length<3 || $('#qq').val().length>11){
			alert('请填写正确的QQ帐号,以便我们联系您!');
			$('#qq').focus();
			return false;
		}
	}
	if($('#telephone').val().length>0){
		if(!(/^1[3|4|5|8][0-9]\d{4,8}$/.test($('#telephone').val()))){ 
			alert("请填写正确的手机号,以便我们联系您!");
			$('#telephone').focus();
			return false; 
		} 
	}
	return true;
}


function my_passwd_submit(){
	var oldpwd = $('#oldpwd').val();		
	if(oldpwd.length<6||oldpwd.length>20) {
		$('#o_info').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>密码长度6~12个字符");
		$('#oldpwd').addClass("input_error").focus();
		return false;
	} else {
		$('#o_info').removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>");
		$('#oldpwd').removeClass("input_error")
	}
	var login_pwd = $('#login_pwd').val();
	if(login_pwd.length<6||login_pwd.length>12) {
		$('#p_info').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>密码长度6~12个字符");
		$('#login_pwd').addClass("input_error").focus();
		return false;
	} else {
		$('#p_info').removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>输入正确");
		$('#login_pwd').removeClass("input_error");
	}
	
	var relogin_pwd = $('#relogin_pwd').val();
	if(relogin_pwd.length == 0) {
		$('#p_info2').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>确认密码不能为空");
		$('#relogin_pwd').addClass("input_error").focus();
		return false;
	} else {
		$('#p_info').removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>输入正确");
		$('#relogin_pwd').removeClass("input_error");
	}
	
	if(login_pwd==relogin_pwd){
		$('#p_info2').removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>两次密码输入一致");
		$('#relogin_pwd').removeClass("input_error");
	} else {
		$('#p_info2').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>两次密码输入不一致");
		$('#relogin_pwd').addClass("input_error").focus();
		return false;
	}		
	return true;
}
function my_passwd_1(){
	var oldpwd = $('#oldpwd').val();		
	if(oldpwd.length<6||oldpwd.length>12) {
		$('#o_info').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>密码长度6~12个字符");
		$('#oldpwd').addClass("input_error");
		return false;
	} else {
		$('#o_info').removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>");
		$('#oldpwd').removeClass("input_error");
	}
}
function my_passwd_2(){
	var login_pwd = $('#login_pwd').val();
	if(login_pwd.length<6||login_pwd.length>12) {
		$('#p_info').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>密码长度6~12个字符");
		$('#login_pwd').addClass("input_error");
		return false;
	} else {
		$('#p_info').removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>输入正确");
		$('#login_pwd').removeClass("input_error");
	}
}
function my_passwd_3(){
	var login_pwd = $('#login_pwd').val();
    var relogin_pwd = $('#relogin_pwd').val();
	if(relogin_pwd.length == 0) {
		$('#p_info2').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>确认密码不能为空");
		$('#relogin_pwd').addClass("input_error");
		return false;
	} else {
		$('#p_info').removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>输入正确");
		$('#relogin_pwd').removeClass("input_error");
	}
	
	if(login_pwd==relogin_pwd){
		$('#p_info2').removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>两次密码输入一致");
		$('#relogin_pwd').removeClass("input_error");
	} else {
		$('#p_info2').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>两次密码输入不一致");
		$('#relogin_pwd').addClass("input_error");
		return false;
	}		
}
function my_indulge_sumbit(){
	var truename=$('#truename').val();
	var idcard=$('#idcard').val();
	var tn_chk=$('#tn_chk').val();
	var id_chk=$('#id_chk').val();
	
	if(truename.length == 0 || tn_chk!=1) {
		alert('请正确填写真实姓名！');
		$('#truename').focus();
		return false;
	} else if(idcard.length == 0 ||  id_chk!=1) {
		alert('请正确填写身份证号码！');
		$('#idcard').focus();
		return false;
	} else {
		return true;
	}
}
function my_question_submit(){
		var question = $('#question').val();
		
		if(question.length == 0) {
			alert("请选择密保问题");
			return false;
		}

		var answer = $('#answer').val();
		if(answer.length == 0) {
			alert("请填写密保答案");
			$('#answer').focus();
			return false;
		}
	return true;
}
function my_platform_submit(){
	var truename=$('#truename').val();
	var idcard=$('#idcard').val();
	var tn_chk=$('#tn_chk').val();
	var id_chk=$('#id_chk').val();
	var login_pwd = $('#login_pwd').val();
    var relogin_pwd = $('#relogin_pwd').val();
	var old_pwd = $('#oldpwd');
	if(truename.length == 0 || tn_chk!=1) {
		alert('请正确填写真实姓名！');
		$('#truename').addClass("input_error").focus();
		return false;
	} else if(idcard.length == 0 ||  id_chk!=1) {
		alert('请正确填写身份证号码！');
		$('#idcard').addClass("input_error").focus();
		return false;
	}
	if( old_pwd.length >0 && old_pwd.val().length ==0 ){
		$('#o_info').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>请输入原支付密码");
		$('#oldpwd').addClass("input_error").focus();
		return false;
	}
	if(login_pwd.length<6||login_pwd.length>12) {
		$('#p_info').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>密码长度6~12个字符");
		$('#login_pwd').addClass("input_error").focus();
		return false;
	} else {
		$('#p_info').removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>输入正确");
		$('#login_pwd').removeClass("input_error");
	}
	if(relogin_pwd.length == 0) {
		$('#p_info2').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>确认密码不能为空");
		$('#relogin_pwd').addClass("input_error").focus();
		return false;
	}
	else if( relogin_pwd != login_pwd ){
		$('#p_info2').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>两次密码输入不一致");
		$('#relogin_pwd').addClass("input_error").focus();
		return false;
	}
	else{
		$('#p_info2').removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>两次密码输入一致");
		$('#relogin_pwd').removeClass("input_error");
	}
	
	return true;
}