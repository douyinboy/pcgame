<?php /* Smarty version Smarty-3.1.7, created on 2017-02-16 13:51:45
         compiled from ".\templates\system\addGuildMember.html" */ ?>
<?php /*%%SmartyHeaderCode:1401258a53df15eb419-81870884%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2d5bb8ba321bd118c711a70d60d8ab729fceab7c' => 
    array (
      0 => '.\\templates\\system\\addGuildMember.html',
      1 => 1487134654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1401258a53df15eb419-81870884',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'guildlist' => 0,
    'v' => 0,
    'mInfo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58a53df166072',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a53df166072')) {function content_58a53df166072($_smarty_tpl) {?><div class="pageContent">
    <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
        <input name="sub" type="hidden" value="1" />
        <input name="id" type="hidden" value="<?php echo $_GET['id'];?>
" />
        <div class="pageFormContent" layoutH="68">
        <div class="unit">
                <label>选择公会：</label>
                <select class="combox" name="agent_id">
                    <option value="0">选择公会</option>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['mInfo']->value['agent_id']==$_smarty_tpl->tpl_vars['v']->value['id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['agentname'];?>
</option>
                    <?php } ?>
                </select>
                <span class="info"></span>
        </div>
        <div class="unit">
                <label>成员名：</label>
                <input type="text" class="required"  value="<?php echo $_smarty_tpl->tpl_vars['mInfo']->value['author'];?>
" name="author">
                <span class="info"></span>
        </div>
        <div class="unit">
                <label>登录账号：</label>
                <input type="text" class="required"  value="<?php echo $_smarty_tpl->tpl_vars['mInfo']->value['aAccount'];?>
" <?php if ($_GET['id']>0){?>readonly="true"<?php }?> name="aAccount">
                <span class="info"></span>
        </div>
        <div class="unit">
                <label>登录密码：</label>
                <input type="text" class="required"  value="<?php echo $_smarty_tpl->tpl_vars['mInfo']->value['aPass'];?>
" name="aPass">
                <span class="info"></span>
        </div> 
        <div class="unit">
            <label>状态：</label>
            <select  class="combox" name="state">
                <option value="0" >暂不启用</option>
                <option value="1" <?php if ($_smarty_tpl->tpl_vars['mInfo']->value['state']==1){?>selected<?php }?>>正常启用</option>
            </select>                       
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