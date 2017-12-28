<?php /* Smarty version Smarty-3.0.6, created on 2016-12-28 22:26:10
         compiled from "/home/91yxq/www.demo.com/template/help_getpwd_qa.html" */ ?>
<?php /*%%SmartyHeaderCode:2711723725863cb8218bec8-79196371%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8379926b06b528f5f33b2df4a04151fea33a7780' => 
    array (
      0 => '/home/91yxq/www.demo.com/template/help_getpwd_qa.html',
      1 => 1482896440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2711723725863cb8218bec8-79196371',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>找回密码</title>
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
/css/www/base.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
/css/www/public.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
/css/www/main_pq.css" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
jquery-1.11.1.min.js"></script>
<script type="text/javascript">
	function qa_pwd_submit()
	{
		var u = $.trim($('#username').val());
		$('#username').val(u)
		
		if(u.length<6 || u.length>20){
			$('#u_info').addClass("msg_warn").html('<i class="imgpq icon_on mr10"></i>请正确输入6qwan帐号');
			return false;
		}
		else{
			$('#u_info').removeClass("msg_warn").html('输入你的91yxq账号');
		}
		
		$('#FormGetQA').submit();
	}
	
	
	function qa_new_pwd_submit()
	{
		if(chk_answer() && chk_new_pwd() && chk_re_pwd())
		$('#FormSetPwd').submit();
	}
	
	function chk_new_pwd(){
		var $new_pwd = $("#new_pwd");
		var new_pwd = $.trim($new_pwd.val());
		$new_pwd.val(new_pwd);
		
		var $new_info = $("#new_info");
		if( new_pwd.length<6 || new_pwd.length>18 ){
			$new_pwd.addClass("input_error").focus();
			$new_info.removeClass("msg_text").addClass("msg_warn").html('<i class="imgpq icon_on mr10"></i>确保新密码长度为6-18个字符');
			return false;
		}
		else{
			$new_pwd.removeClass("input_error");
			$new_info.removeClass("msg_warn").addClass("msg_text").html('<i class="imgpq icon_yes2 mr10"></i>新密码长度正确');
			return true;
		}
		
	}
	
	function chk_re_pwd(){
		var $new_pwd = $("#new_pwd");
		var new_pwd = $.trim($new_pwd.val());
		$new_pwd.val(new_pwd);
		
		var $re_pwd = $("#re_pwd");
		var re_pwd = $.trim($re_pwd.val());
		$re_pwd.val(re_pwd);
		
		var $re_info = $("#re_info");
		if( !re_pwd ){
			$re_pwd.addClass("input_error").focus();
			$re_info.removeClass("msg_text").addClass("msg_warn").html('<i class="imgpq icon_on mr10"></i>确认密码不能为空');
			return false;
		}
		else if( new_pwd != re_pwd ){
			$re_pwd.addClass("input_error").focus();
			$re_info.removeClass("msg_text").addClass("msg_warn").html('<i class="imgpq icon_on mr10"></i>确认密码与新密码不一致');
			return false;
		}
		else{
			$re_pwd.removeClass("input_error");
			$re_info.removeClass("msg_warn").addClass("msg_text").html('<i class="imgpq icon_yes2 mr10"></i>确认密码与新密码一致');
			return true;
		}
		
	}
	
	function chk_answer(){
		var $answer = $("#answer");
		var answer = $.trim($answer.val());
		$answer.val(answer);
		
		var $a_info = $("#a_info");
		
		if( !answer ){
			$answer.addClass("input_error").focus();
			$a_info.removeClass("msg_text").addClass("msg_warn").html('<i class="imgpq icon_on mr10"></i>密保答案不能为空');
			return false;
		}
		else{
			$answer.removeClass("input_error");
			$a_info.removeClass("msg_warn").addClass("msg_text").html('<i class="imgpq icon_yes2 mr10"></i>');
			return true;
		}
		
	}
	
	
</script>
</head>

<body>

<!--导入公共头部文件-->
<?php $_template = new Smarty_Internal_Template('header.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<!--主内容-->
<div class="m1200">
	<div class="m_box2 p40 mt40 clearfix" style="min-height:450px">
        <div class="inner_title">
			找回密码
			<a class=" pl20" href="./help.php?act=getpwd_email">通过邮箱找回密码</a>
			<span class="red pl20" >通过密保问题找回密码</span>
		</div>
        <div class="fill_list">
			<?php if (empty($_smarty_tpl->getVariable('question',null,true,false)->value)){?>
			
				<FORM id="FormGetQA" name="FormGetQA" method="post" action="">
					<input type="hidden" name="stage" value="getqa" />
					<ul>
						<li>
							<label>帐号：</label>
							<input name="username" type="text" id="username" value="" class="input_t" style="width:258px" /> <!--input_yes-->
							<span id="u_info" class="msg_text">输入你的91yxq账号</span><!--msg_yes <i class="imgpq icon_yes2 mr10"></i>-->
						</li>
						<li>
							<label>&nbsp;</label>
							<input name="" type="button" value="提交" class="game_btn2" style="width:290px" onclick="qa_pwd_submit();" />
						</li>
					</ul>
				</FORM>
			
			<?php }else{ ?>
			
				<FORM id="FormSetPwd" name="FormSetPwd" method="post" action="">
					<input type="hidden" name="stage" value="setpw" />
					<ul>
						<li>
							<label>帐号：</label>
							<input name="username" type="text" id="username" value="<?php echo $_smarty_tpl->getVariable('username')->value;?>
" class="input_t" style="width:258px" readonly /> 
							<span id="u_info" class="msg_text"></span>
						</li>
						<li>
							<label>密保问题：</label>
							<input name="question" type="text" id="question" value="<?php echo $_smarty_tpl->getVariable('question')->value;?>
" class="input_t" style="width:258px" readonly />
							<span id="q_info" class="msg_text"></span>
						</li>
						<li>
							<label>密保答案：</label>
							<input name="answer" type="text" id="answer" value="" class="input_t" style="width:258px" onblur="chk_answer()" />
							<span id="a_info" class="msg_text">输入你密保问题的答案</span>
						</li>
						<li>
							<label>新密码：</label>
							<input name="new_pwd" type="text" id="new_pwd" value="" class="input_t" style="width:258px" onblur="chk_new_pwd()" />
							<span id="new_info" class="msg_text">设置你的新密码</span>
						</li>
						<li>
							<label>确认新密码：</label>
							<input name="re_pwd" type="text" id="re_pwd" value="" class="input_t" style="width:258px" onblur="chk_re_pwd()" />
							<span id="re_info" class="msg_text">再次输入你的新密码</span>
						</li>
						<li>
							<label>&nbsp;</label>
							<input name="" type="button" value="确认" class="game_btn2" style="width:290px" onclick="qa_new_pwd_submit();" />
						</li>
					</ul>
				</FORM>
			
			<?php }?>
        </div>
    </div>
</div>

<!--导入公共页脚文件-->
<?php $_template = new Smarty_Internal_Template('footer.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</body>
</html>
