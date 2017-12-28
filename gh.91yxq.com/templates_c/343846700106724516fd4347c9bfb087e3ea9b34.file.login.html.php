<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 14:51:16
         compiled from "./templates/public/login.html" */ ?>
<?php /*%%SmartyHeaderCode:57235602556a1f81f940bc4-92211507%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '343846700106724516fd4347c9bfb087e3ea9b34' => 
    array (
      0 => './templates/public/login.html',
      1 => 1456973056,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '57235602556a1f81f940bc4-92211507',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56a1f81f97650',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a1f81f97650')) {function content_56a1f81f97650($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/91yxq/gh.demo.com/Smarty-3.1.7/plugins/modifier.date_format.php';
?><?php  $_config = new Smarty_Internal_Config("smarty.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_smarty_tpl->getConfigVariable('admin_title');?>
登录界面</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getConfigVariable('root_url_cache');?>
css/pqcms.css" />
<script src="<?php echo $_smarty_tpl->getConfigVariable('root_url_cache');?>
js/jquery.js" type="text/javascript"></script>
<style>
body{background:url(<?php echo $_smarty_tpl->getConfigVariable('root_url_cache');?>
images/login_bg.jpg) no-repeat #dff1ff top center}
/*登录*/
.login_box{width:500px; padding-top:150px; margin:0 auto}
	.login_list{background:#FFF; border-radius:15px; box-shadow:0 2px 4px rgba(0,0,0,0.1); padding:30px}
	.login_list li{padding:10px 0; position:relative}
	.login_list label{float:left; font-size:14px; color:#999; text-align:right; line-height:40px; width:120px; padding-right:10px}
	.login_list .input_t{border:1px solid #e2e2e2; border-radius:3px; font-size:14px; font-family:"微软雅黑"; color:#999; line-height:20px; padding:9px 15px; margin:0; transition:border-color 0.3s linear 0s}
	.login_list .input_error{border-color:#dc5562}.input_yes{border-color:#2dcc70}
	.login_btn{display:inline-block; background:#dc5562; border:none; border-radius:3px; font-size:18px; font-family:"微软雅黑"; color:rgba(255, 255, 255, 0.9)!important; color:#FFF; text-align:center; text-shadow:0 0 2px rgba(0,0,0,0.2); min-width:150px; line-height:45px; height:45px; cursor:pointer; transition:all 0.2s linear}
	.login_btn:hover{background:#d03b44}
	
.foot_copy{font-size:14px; color:#FFF; line-height:40px; text-align:center; padding-top:10px}
.foot_copy a{color:#FFF}
</style>
<script language="JavaScript">
function fleshVerify(){	//重载验证码
	var timenow = new Date().getTime();
    $('#verifyImg').attr("src", '<?php echo $_smarty_tpl->getConfigVariable('admin_index');?>
?action=public&opt=loadVerify&verify_time='+timenow);
}
</script>
</head>

<body>
<!--登录-->
<form method="post" target="_self" action="<?php echo $_smarty_tpl->getConfigVariable('admin_index');?>
?action=public&opt=loginin" >
<div class="login_box">
    <div><img src="<?php echo $_smarty_tpl->getConfigVariable('root_url_cache');?>
images/login_title.png"/></div>
    <div class="login_list">
        <ul>
            <li><label>用户名：</label><input id="account"  name="account" type="text"  class="input_t input_yes" style="width:258px"></li>
            <li><label>密码：</label><input  name="password" type="password" id="password" value="" class="input_t" style="width:258px"></li>
            <li><label>验证码：</label><input name="verify"  type="text" id="textfield" value="" class="input_t" style="width:180px"><img  id="verifyImg" SRC="<?php echo $_smarty_tpl->getConfigVariable('admin_index');?>
?action=public&opt=loadVerify" onClick="fleshVerify()" border="0" alt="点击刷新验证码" style="cursor:pointer" width=80 /></li>
            <li><label>&nbsp;</label><input type="image"  value="登录" class="login_btn" ></li>
        </ul>
    </div>
    <div class="foot_copy">Copyright &copy; <?php echo smarty_modifier_date_format(time(),"%Y");?>
<a href="<?php echo $_smarty_tpl->getConfigVariable('officel_url');?>
" target="_blank"><?php echo $_smarty_tpl->getConfigVariable('officel_title');?>
</a>版权所有</div>
</div>
</form>
</body>
</html>
<?php }} ?>