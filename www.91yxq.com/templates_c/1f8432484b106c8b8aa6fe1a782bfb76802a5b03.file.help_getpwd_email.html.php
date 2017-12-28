<?php /* Smarty version Smarty-3.0.6, created on 2016-01-29 02:36:57
         compiled from "/home/www/www.demo.com/template/help_getpwd_email.html" */ ?>
<?php /*%%SmartyHeaderCode:18836187956aa5fc9a4d659-02876752%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f8432484b106c8b8aa6fe1a782bfb76802a5b03' => 
    array (
      0 => '/home/www/www.demo.com/template/help_getpwd_email.html',
      1 => 1453517567,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18836187956aa5fc9a4d659-02876752',
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
	function pwd_email_submit()
	{
		var u = $.trim($('#username').val());
		$('#username').val(u)
		var e = $.trim($('#email').val());
		$('#email').val(e)
		
		if(u.length<6 || u.length>20){
			$('#u_info').addClass("msg_warn").html('<i class="imgpq icon_on mr10"></i>请正确输入6qwan帐号');
			return false;
		}
		else{
			$('#u_info').removeClass("msg_warn").html('输入你的91yxq账号');
		}
		
		var emailtest = /[_a-zA-Z\d\-\.]+@[_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+$/;	
		if(!emailtest.test(e)){
			$('#e_info').addClass("msg_warn").html('<i class="imgpq icon_on mr10"></i>邮箱格式错误');
			return false;
		}
		else{
			$('#e_info').removeClass("msg_warn").html('输入你注册时填写的邮箱地址');
		}
		
		$('#FormGetPwd').submit();
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
			<span class="red pl20">通过邮箱找回密码</span>
			<a class=" pl20" href="./help.php?act=getpwd_qa">通过密保问题找回密码</a>
		</div>
        <div class="fill_list">
			<FORM id="FormGetPwd" name="FormGetPwd" method="post" action="">
				<input type="hidden" name="stage" value="yes" />
				<ul>
					<li>
						<label>帐号：</label>
						<input name="username" type="text" id="username" value="" class="input_t" style="width:258px" /> <!--input_yes-->
						<span id="u_info" class="msg_text">输入你的91yxq账号</span><!--msg_yes <i class="imgpq icon_yes2 mr10"></i>-->
					</li>
					<li>
						<label>电子邮箱：</label>
						<input name="email" type="text" id="email" value="" class="input_t" style="width:258px" />
						<span id="e_info" class="msg_text">输入你注册时填写的邮箱地址</span>
					</li>
					<li>
						<label>&nbsp;</label>
						<input name="" type="button" value="确认" class="game_btn2" style="width:290px" onclick="pwd_email_submit();" />
					</li>
				</ul>
			</FORM>
        </div>
    </div>
</div>

<!--导入公共页脚文件-->
<?php $_template = new Smarty_Internal_Template('footer.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

</body>
</html>
