
//过滤两端空格
function Trim() {
	return this.replace(/\s+$|^\s+/g,"");
}
String.prototype.Trim=Trim;





function getHits(thisElm,info) {
	var $this = $(thisElm);
	var user_name = $.trim( $this.val() );
	$this.val(user_name)
	var $info=$("#"+info);
	if(user_name=='' || user_name.length<6 || user_name.length>20)
	{
		$this.addClass("input_error");
		$info.removeClass("msg_t").removeClass("msg_yes").addClass("msg_warn").html('用户名6-20个字符,由字母、数字组成');
	}else{
		$this.removeClass("input_error");
		$info.removeClass("msg_warn").removeClass("msg_t").addClass("msg_yes").html('此用户名可以注册');
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
$("#login_login").click(function(){
	var  login_name = $("#login_name").val();
	var  login_pwd  = $("#login_pwd").val();
	var  repeat_pwd = $("#repeat_pwd").val();
	if(login_name == ""){
		layer.msg('请输入用户名');
		return false;
	}
	if(login_pwd == ""){
		layer.msg('请输入密码');
		return false;
	}
	if(login_pwd.length < 6 || login_pwd.length >18){
		layer.msg('请控制密码长度在6-18个字符');
		return false;
	}
	if(repeat_pwd == ""){
		layer.msg('请输入确认密码');
		return false;
	}
	if(login_pwd != repeat_pwd){
		layer.msg('确认密码与密码不一致');
		return false;
	}
})