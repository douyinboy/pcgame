<?php /* Smarty version Smarty-3.0.6, created on 2016-01-23 17:39:41
         compiled from "/home/www/www.demo.com/template/login.html" */ ?>
<?php /*%%SmartyHeaderCode:169554107756a34a5d3abc40-34907171%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9d7a8d8a96732330a8248dc9538ee89ed8560351' => 
    array (
      0 => '/home/www/www.demo.com/template/login.html',
      1 => 1453517567,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '169554107756a34a5d3abc40-34907171',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户登录</title>
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/base.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/public.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/main_pq.css" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
function.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
login_tips.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
Login.js"></script>
</head>

<body>
<!---头部-->
<div class="head2">
	<div class="m1000">
        <a href="index.html" class="logo"></a>
        <div class="fl title">用户登录</div>
    </div>
</div>

<!--主内容-->
<div class="m1000 clearfix">
	<div class="fl"><img src="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
images/www/login_pic.jpg" /></div>
    <div class="fr login_pq">
    	<div class="title"><h2>用户登录</h2></div>
        <div class="login_m">
            <ul>
                <form id="loginform" name="loginform" onSubmit="Login();return false;" action="" method="post">
					<input type="hidden" value="<?php echo $_smarty_tpl->getVariable('forward')->value;?>
" name="forward" id="forward"/>
					<li>
						<div class="input_box">
							<label class="imgpq user"></label>
							<input name="login_user" type="text" id="login_user" value="" placeholder="请输入账号" class="text" />
							<i class="imgpq icon_yes2" style="display:none;"></i>
						</div>
					</li>
					<li>
						<div class="input_box">
							<label class="imgpq cipher"></label>
							<input name="login_pwd" type="password" id="login_pwd" value="" placeholder="请输入密码" class="text" />
							<i class="imgpq icon_on" style="display:none;"></i>
						</div>
					</li>
					<li class="pt10 pb10">
						<a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
help.php?act=getpwd_email" target="_blank" class="fr red">忘记密码</a>
						<span style="padding:0 10px"><input name="SaveLogin" type="checkbox" id="SaveLogin" checked="checked" onclick="SaveLoginFun(this)"></span>记住账号
					</li>
					<li><input name="" type="submit" value="登 录" class="game_btn1" style="width:350px"></li>
					<li class="f14 pt20">还没有账号？&nbsp;<a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
turn.php?act=reg" class="red">立即注册</a></li>
                </form>
            </ul>
        </div>
    </div>
</div>

<!--页脚-->
<div class="foot2 clearfix">
	<div class="m1000">
        <div class="fl foot2_nav">
			<p>
				<a href="./doc/aboutus.html" target="_blank">关于我们</a>
				<span class="line">|</span><a href="./doc/cooperation.html" target="_blank">商务合作</a>
				<span class="line">|</span><a href="./doc/contactus.html" target="_blank">联系我们</a>
				<span class="line">|</span><a href="./fcm/" target="_blank">家长监护</a>
			</p>
		</div>
        <div class="fr foot2_copy">游戏网络有限公司版权所有 ©2015-2016&nbsp;&nbsp;粤ICP备00088888号-1</div>
    </div>
</div>

<script type="text/javascript">CheckInput();</script>

</body>
</html>
