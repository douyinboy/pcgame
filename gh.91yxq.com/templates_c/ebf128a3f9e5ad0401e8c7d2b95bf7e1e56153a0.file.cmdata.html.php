<?php /* Smarty version Smarty-3.1.7, created on 2017-02-28 10:42:44
         compiled from ".\templates\sysmanage\cmdata.html" */ ?>
<?php /*%%SmartyHeaderCode:926958b4e3a4592454-26518241%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ebf128a3f9e5ad0401e8c7d2b95bf7e1e56153a0' => 
    array (
      0 => '.\\templates\\sysmanage\\cmdata.html',
      1 => 1487134665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '926958b4e3a4592454-26518241',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58b4e3a45e44f',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58b4e3a45e44f')) {function content_58b4e3a45e44f($_smarty_tpl) {?><div class="pageContent">
        <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone)">
        <input name="sub" type="hidden" value="1" />
        <div class="pageFormContent" layoutH="68">
			<div class="unit">
				<label>登录账号：</label>
				<input class="required" name="account" type="text" size="30" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['user_name'];?>
" readonly ="readonly"/>
			</div>
                        <div class="unit">
				<label>原密码：</label>
                                <input name="oldpass" type="text" size="30" value="" class="required"/>
			</div>
                        <div class="unit">
				<label>新密码：</label>
				<input name="newpass" type="password" size="30" value="" class="required"/>
			</div>
                        <div class="unit">
				<label>确认新密码：</label>
				<input name="newpassagain" type="password" size="30" value="" class="required"/>
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