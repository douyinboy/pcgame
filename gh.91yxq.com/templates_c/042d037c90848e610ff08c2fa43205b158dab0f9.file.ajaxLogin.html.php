<?php /* Smarty version Smarty-3.1.7, created on 2017-02-28 10:42:55
         compiled from ".\templates\public\ajaxLogin.html" */ ?>
<?php /*%%SmartyHeaderCode:966658b4e3af66f7e0-58534291%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '042d037c90848e610ff08c2fa43205b158dab0f9' => 
    array (
      0 => '.\\templates\\public\\ajaxLogin.html',
      1 => 1487134665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '966658b4e3af66f7e0-58534291',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58b4e3af6b1e7',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58b4e3af6b1e7')) {function content_58b4e3af6b1e7($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("smarty.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
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