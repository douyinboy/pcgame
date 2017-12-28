<?php /* Smarty version Smarty-3.1.7, created on 2017-01-02 21:39:38
         compiled from "./templates/public/ajaxLogin.html" */ ?>
<?php /*%%SmartyHeaderCode:272032735586a581a62dc25-45642149%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ea12ba12f66e59ebc0089152fb15ba851bd75ac' => 
    array (
      0 => './templates/public/ajaxLogin.html',
      1 => 1456973058,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '272032735586a581a62dc25-45642149',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_586a581a66720',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_586a581a66720')) {function content_586a581a66720($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("smarty.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<div class="pageContent">
	<form method="post" action="?action=public&opt=loginIn&callbackType=closeCurrent" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
		<div class="pageFormContent" layoutH="58">
			<div class="unit">
				<label>用户名：</label>
				<input type="text" name="account" size="30" class="required"/>
			</div>
			<div class="unit">
				<label>密码：</label>
				<input type="password" name="password" size="30" class="required"/>
			</div>
            <div class="unit">
				<label>验证码：</label>
				<input class="code" name="verify" type="text" size="5" /><span><img id="verifyImg" SRC="<?php echo $_smarty_tpl->getConfigVariable('admin_index');?>
?action=public&opt=loadVerify" onClick="fleshVerify()" border="0" alt="点击刷新验证码" style="cursor:pointer" align="absmiddle"></span>
			</div>
		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
			</ul>
		</div>
	</form>
</div><?php }} ?>