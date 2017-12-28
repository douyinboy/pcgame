//reg form submit
function pwd_email_submit()
{
	var u = $.trim(gID('uname').value);
	var e = $.trim(gID('email').value);
	
	if(u.length<4){
		gID('username1').innerHTML='<font style="color:red">请正确输入5A帐号</font>';
		return false;
	}	
	if(u.length>30){
		gID('username1').innerHTML='<font style="color:red">请正确输入5A帐号</font>';
		return false;
	}	
	gID('username1').innerHTML=' ';
	var emailtest = /[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/;	
	if(!emailtest.test(e)){
		gID('email1').innerHTML='<font style="color:red">邮箱格式错误</font>';
		return false;
	}	
	gID('email').innerHTML='';
	$('#FormgetPwd').submit();
}