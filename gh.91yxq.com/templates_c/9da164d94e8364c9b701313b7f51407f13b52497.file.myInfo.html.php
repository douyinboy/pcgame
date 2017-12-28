<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 15:47:18
         compiled from "./templates/sysmanage/myInfo.html" */ ?>
<?php /*%%SmartyHeaderCode:172853796656d52ed2a2f731-43735933%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9da164d94e8364c9b701313b7f51407f13b52497' => 
    array (
      0 => './templates/sysmanage/myInfo.html',
      1 => 1456973058,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '172853796656d52ed2a2f731-43735933',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56d52ed2aa18f',
  'variables' => 
  array (
    'info' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56d52ed2aa18f')) {function content_56d52ed2aa18f($_smarty_tpl) {?><div class="pageContent">
    <div class="page unitBox" style="display: block;">

    
    <div layouth="60" class="pageFormContent" style="height: 215px; overflow: auto;">
	<fieldset>
		<legend>公会信息</legend>
                <dl>
			<dt>公会名：</dt>
                        <dd><input type="text" name="furl" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['agentname'];?>
" readonly="true" class="required textInput readonly"></dd>
		</dl>
		<dl>
			<dt>公会登录账号：</dt>
                        <dd><input type="text" name="field1"  value="<?php echo $_smarty_tpl->tpl_vars['info']->value['user_name'];?>
" readonly="true" size="35" class="required textInput readonly"></dd>
		</dl>
		<dl>
			<dt>联系人姓名：</dt>
			<dd><input type="text" name="field2"  value="<?php echo $_smarty_tpl->tpl_vars['info']->value['person'];?>
" readonly="true"  class=" textInput readonly" size="35"></dd>
		</dl>
		<dl>
			<dt>邮箱：</dt>
			<dd><input type="text" name="field3"  value="<?php echo $_smarty_tpl->tpl_vars['info']->value['email'];?>
" readonly="true"  class=" textInput readonly"  size="35"></dd>
		</dl>
		
		<dl>
			<dt>QQ号：</dt>
			<dd><input type="text" name="field6"   value="<?php echo $_smarty_tpl->tpl_vars['info']->value['qq'];?>
" readonly="true"  class="textInput readonly" size="35"></dd>
		</dl>
                <dl>
			<dt>YY号：</dt>
			<dd><input type="text" name="field7"  value="<?php echo $_smarty_tpl->tpl_vars['info']->value['yy'];?>
" readonly="true"  class=" textInput readonly" size="35"></dd>
		</dl>
                <dl>
			<dt>最后登录日期：</dt>
			<dd><input type="text" name="field5"  value="<?php echo $_smarty_tpl->tpl_vars['info']->value['lastdate'];?>
" readonly="true" class="textInput readonly"></dd>
		</dl>
                 <dl>
			<dt>最后登录地区：</dt>
			<dd><input type="text" name="field5"  value="<?php echo $_smarty_tpl->tpl_vars['info']->value['loginaddress'];?>
" readonly="true" class="textInput readonly"></dd>
		</dl>
                
	</fieldset>
	
	<fieldset>
		<legend>打款信息</legend>
                <dl>
			<dt>打款银行：</dt>
			<dd><input type="text" name="field8" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['bank'];?>
-<?php echo $_smarty_tpl->tpl_vars['info']->value['bank_son'];?>
"  readonly="true"  size="35" class="required textInput"></dd>
		</dl>
		<dl class="nowrap">
			<dt>银行账号：</dt>
			<dd><input type="text" name="field9"  value="<?php echo $_smarty_tpl->tpl_vars['info']->value['account'];?>
"  disabled="true" size="50" class="required textInput readonly"></dd>
		</dl>
                <dl>
			<dt>开户人：</dt>
			<dd><input type="text" name="field8" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['account_name'];?>
"  readonly="true"  size="35" class="required textInput"></dd>
		</dl>

		<dl>
			<dt>联系电话：</dt>
			<dd><input type="text" name="field5"  value="<?php echo $_smarty_tpl->tpl_vars['info']->value['mobel'];?>
" readonly="true" class="textInput readonly"></dd>
		</dl>
	</fieldset>
</div>
</div>
</div><?php }} ?>