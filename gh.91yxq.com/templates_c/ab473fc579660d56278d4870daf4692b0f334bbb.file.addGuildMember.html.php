<?php /* Smarty version Smarty-3.1.7, created on 2016-12-30 20:07:34
         compiled from "./templates/system/addGuildMember.html" */ ?>
<?php /*%%SmartyHeaderCode:6831511056a434d0c86b43-91248402%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab473fc579660d56278d4870daf4692b0f334bbb' => 
    array (
      0 => './templates/system/addGuildMember.html',
      1 => 1456973058,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6831511056a434d0c86b43-91248402',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56a434d0ce423',
  'variables' => 
  array (
    'mInfo' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a434d0ce423')) {function content_56a434d0ce423($_smarty_tpl) {?><div class="pageContent">
    <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
        <input name="sub" type="hidden" value="1" />
        <input name="id" type="hidden" value="<?php echo $_GET['id'];?>
" />
        <div class="pageFormContent" layoutH="68">
        <div class="unit">
                <label>成员名：</label>
                <input type="text" class="required"  value="<?php echo $_smarty_tpl->tpl_vars['mInfo']->value['author'];?>
" name="author">
                <span class="info"></span>
        </div>
        <div class="unit"  style="">
                <label>登录账号：</label>
                <input type="text" class="required"  value="<?php echo $_smarty_tpl->tpl_vars['mInfo']->value['aAccount'];?>
" name="aAccount">
                <span class="info"></span>
        </div>
        <div class="unit"  style="">
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