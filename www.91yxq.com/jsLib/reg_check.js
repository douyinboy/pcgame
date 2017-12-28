//注册提交
function reg_submit(){
	var $acceptant = $("#acceptant");
	if( $acceptant.is(":checked") )
	{
		var u_chk=$('#u_chk').val();//用户名验证状态值
		var m_chk=$('#m_chk').val();//电子邮件验证状态值
		var c_chk=$('#c_chk').val();//验证码验证状态值
		var tn_chk=$('#tn_chk').val();//真实姓名验证状态值
		var id_chk=$('#id_chk').val();//身份证验证状态值
		
		//验证用户名
		var $login_name = $("#login_name");
		var login_name = $.trim( $login_name.val() );
		if( login_name.length == 0 ){
			$("#u_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>用户名不能为空!");
			$login_name.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		else if( login_name.length < 4 || login_name.length > 20 ) {
			$("#u_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>用户名长度4-20字符!");
			$login_name.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		else if( u_chk != 1 ){
			$("#u_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn");
			$login_name.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		// else{
			// $("#u_info").removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>");;
			// $login_name.removeClass("input_error").addClass("input_yes");
		// }
		
		//验证密码
		var $login_pwd = $("#login_pwd");
		var login_pwd = $.trim( $login_pwd.val() );
		if(login_pwd.length == 0) {
			$("#p_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>密码不能为空!");
			$login_pwd.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		else if(login_pwd.length <6 || login_pwd.length>12) {
			$("#p_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>密码长度不对!密码长度6~12个字符");
			$login_pwd.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		// else {
			// $("#p_info").removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>密码输入正确!");
			// $login_pwd.removeClass("input_error").addClass("input_yes");
		// }
		
		//验证确认密码
		var $relogin_pwd = $("#relogin_pwd");
		var relogin_pwd = $.trim( $relogin_pwd.val() );
		if(relogin_pwd.length == 0) {
			$("#p_info2").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>确认密码不能为空!");
			$relogin_pwd.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		else if( login_pwd != relogin_pwd ){
			$("#p_info2").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>两次密码输入不一致!");
			$relogin_pwd.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		// else{
			// $("#p_info2").removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>两次密码输入一致!");
			// $relogin_pwd.removeClass("input_error").addClass("input_yes");
		// }

		//验证email
		var $email = $("#email");
		var email = $.trim( $email.val() );
		if(email.length == 0) {
			$("#e_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>邮箱不能为空!");
			$email.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		else if( m_chk != 1 ){
			$("#e_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn");
			$email.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		// else{
			// $("#e_info").removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes");
			// $email.removeClass("input_error").addClass("input_yes");
		// }
		
		//真实姓名验证
		var $truename = $("#truename");
		var truename = $.trim( $truename.val() );
		if(truename.length == 0) {
			$("#n_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>姓名不能为空!输入真实姓名,例如: 张三!");
			$truename.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		else if( tn_chk != 1 ){
			$("#n_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn");
			$truename.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		// else{
			// $("#n_info").removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes");
			// $truename.removeClass("input_error").addClass("input_yes");
		// }
		
		//身份证验证
		var $idcard = $("#idcard");
		var idcard = $.trim( $idcard.val() );
		var reg = /(^\d{15}$)|(^\d{17}(\d|X|x)$)/;
		if(idcard.length == 0) {
			$("#id_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>请输入身份证号码,例如: 440106198202020555");
			$idcard.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		else if( reg.test(idcard) === false ){
			$("#id_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>身份证有误,例如: 440106198202020555");
			$idcard.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		else if( id_chk != 1 ){
			$("#id_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>身份证有误,例如: 440106198202020555");
			$idcard.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		// else{
			// $("#id_info").removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes");
			// $idcard.removeClass("input_error").addClass("input_yes");
		// }
		
		
		//验证码验证
		var $chk_code = $("#chk_code");
		var chk_code = $.trim( $chk_code.val() );
		if(chk_code.length == 0) {
			$("#code_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>验证码不能为空!");
			$chk_code.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		else if( c_chk != 1 ){
			$("#code_info").removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn");
			$chk_code.removeClass("input_yes").addClass("input_error").focus();
			return false;
		}
		// else{
			// $("#code_info").removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes");
			// $chk_code.removeClass("input_error").addClass("input_yes");
		// }
		
		if(u_chk ==1 && m_chk==1 && c_chk==1 && tn_chk==1 && id_chk==1 ) { //表单正确提交
			$('#regform').submit();
			return true;
		}
		else{
			alert('请修正红色提示部分!');
			return false;
		}
	}else{
		alert("注册为91yxq用户前，您必须了解并接受91yxq平台用户名使用协议和隐私证策!");
		return false;
	}



}


//reg form check
function reg_check(thisElm,paras,info_id,info){

	if($(thisElm).val().length == 0){
		$(thisElm).removeClass("input_yes").addClass("input_error");
		$("#"+info_id).removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>"+info);
		
		return false;
	} else {
		var url='http://www.demo.com/api/check.php';
		$.ajax(
		{
			type:"POST",
			url:url,
			data:paras,//表单参数    
			success: function(result)
			{  console.log(result);
				if(result!=''){
					var msgg = result.split("a1_ww_1a");
					
					if(msgg[1]!=''){
						$("#"+msgg[1]).val(msgg[2]);
					}
					if( msgg[2] == "1" ){
						$("#"+info_id).removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>"+msgg[0]);
						$(thisElm).removeClass("input_error").addClass("input_yes");
					}
					else{
						$("#"+info_id).removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>"+msgg[0]);
						$(thisElm).removeClass("input_yes").addClass("input_error");
					}
					

				} else {
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


//密码长度及复杂性验证
function pwStrength(thisElm,isBlur){
	pw_check(document.getElementById("relogin_pwd"))
	var val = $(thisElm).val();
	var len = val.length;
	if( isBlur ){
		if(len == 0){
			$(thisElm).removeClass("input_yes").addClass("input_error");
			$('#p_info').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>密码不能为空!");
			return false;
		}
		else if(len < 6 || len>12){
			$(thisElm).removeClass("input_yes").addClass("input_error");
			$('#p_info').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>密码长度不对!密码长度6~12个字符!");
			return false;
		}
		else {
			$(thisElm).removeClass("input_error").addClass("input_yes");
			$('#p_info').removeClass("msg_warn").removeClass("msg_text").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>请牢记您的密码");
		}
	}
	else{
		if(len < 6 || len>12){
			$(thisElm).removeClass("input_yes").addClass("input_error");
			$('#p_info').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>密码长度不对!密码长度6~12个字符!");
			return false;
		}
		else{
			var strength = 0;
			if( /\d/.test(val) ){
				strength++;
			}
			if( /[A-Z]/.test(val) ){
				strength++;
			}
			if( /[a-z]/.test(val) ){
				strength++;
			}
			if( val.replace(/[\dA-Za-z]/g,'').length > 0 ){
				strength++;
			}
			
			if( strength<=2 ){
				$('#p_info').removeClass("msg_warn").removeClass("msg_yes").addClass("msg_text").html("<i class='imgpq icon_yes2 mr10'></i><font color='#ee8822'>弱</font>");
			}
			else if( strength == 3){
				$('#p_info').removeClass("msg_warn").removeClass("msg_yes").addClass("msg_text").html("<i class='imgpq icon_yes2 mr10'></i><font color='#bbcc22'>中</font>");
			}
			else if( strength >= 4){
				$('#p_info').removeClass("msg_warn").removeClass("msg_yes").addClass("msg_text").html("<i class='imgpq icon_yes2 mr10'></i><font color='#2dcc70'>强</font>");
			}
			$(thisElm).removeClass("input_error").addClass("input_yes");
			return true;
		}
	}
	
}


//确认密码验证
function pw_check(thisElm){
	
	if($(thisElm).val().length == 0){
		$(thisElm).removeClass("input_yes").addClass("input_error");
		$('#p_info2').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>确认密码不能为空!");
		return false;
	} 
	if($(thisElm).val() != $('#login_pwd').val()){
		$(thisElm).removeClass("input_yes").addClass("input_error");
		$('#p_info2').removeClass("msg_text").removeClass("msg_yes").addClass("msg_warn").html("<i class='imgpq icon_on mr10'></i>两次密码输入不一致!");
		return false;
	} else {
		$(thisElm).removeClass("input_error").addClass("input_yes");
		$('#p_info2').removeClass("msg_text").removeClass("msg_warn").addClass("msg_yes").html("<i class='imgpq icon_yes2 mr10'></i>两次密码输入一致!");
	}

}










