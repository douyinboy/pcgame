<?php /* Smarty version Smarty-3.1.7, created on 2017-02-16 10:06:56
         compiled from ".\templates\sysmanage\cmdata.html" */ ?>
<?php /*%%SmartyHeaderCode:1699858a509407b2418-00997686%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ebf128a3f9e5ad0401e8c7d2b95bf7e1e56153a0' => 
    array (
      0 => '.\\templates\\sysmanage\\cmdata.html',
      1 => 1487134659,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1699858a509407b2418-00997686',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58a509408620b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a509408620b')) {function content_58a509408620b($_smarty_tpl) {?><div class="pageContent">
	<form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&callbackType=closeCurrent" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
            <div class="pageFormContent" layoutH="68">
			<div class="unit">
				<label>登录账号：</label>
				<input class="required" name="account" type="text" size="30" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['uAccount'];?>
" readonly ="readonly"/>
			</div>
            <div class="unit">
				<label>新密码：</label>
				<input class="required" name="newpass" type="password" size="30" value=""/>
			</div>
            <div class="unit">
				<label>确认新密码：</label>
				<input class="required" name="newpassagain" type="password" size="30" value=""/>
			</div>
			<div class="unit">
				<label>真实姓名：</label>
				<input class="required" name="name" type="text" size="30" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['uName'];?>
"/>
			</div>
            <div class="unit">
				<label>手机号码：</label>
                <input name="mobel" type="text" size="30"  class="digits" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['uPhone'];?>
"/>
			</div>
            <div class="unit">
				<label>邮件地址：</label>
                <input name="email" type="text" size="30"
    class="email" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['uMail'];?>
"/>
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