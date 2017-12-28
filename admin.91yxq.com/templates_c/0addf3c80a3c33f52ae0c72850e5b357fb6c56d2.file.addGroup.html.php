<?php /* Smarty version Smarty-3.1.7, created on 2017-02-17 13:39:05
         compiled from ".\templates\system\addGroup.html" */ ?>
<?php /*%%SmartyHeaderCode:1149458a68c79568379-51487629%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0addf3c80a3c33f52ae0c72850e5b357fb6c56d2' => 
    array (
      0 => '.\\templates\\system\\addGroup.html',
      1 => 1487134654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1149458a68c79568379-51487629',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gInfo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58a68c796894b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a68c796894b')) {function content_58a68c796894b($_smarty_tpl) {?><div class="pageContent">
    <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <input name="sub" type="hidden" value="1" />
    <input name="id" type="hidden" value="<?php echo $_GET['id'];?>
" />
    <div class="pageFormContent" layoutH="68">     
        <div class="unit">
                <label>组名称：</label>
                <input type="text" class="required textInput error" value="<?php echo $_smarty_tpl->tpl_vars['gInfo']->value['gName'];?>
" name="gName">
                <span class="info"></span>
        </div>
        <div class="unit">
            <label>组状态：</label>
                    <select  class="combox" name="gState">
                        <option value="0" >禁止使用</option>
                        <option value="1" <?php if ($_smarty_tpl->tpl_vars['gInfo']->value['gState']==1){?>selected<?php }?>>正常启用</option>
                    </select>                       
        </div>
        <div class="unit">
                <label>显示权重：</label>
                <input type="text" class="textInput digits" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['gInfo']->value['px'])===null||$tmp==='' ? 100 : $tmp);?>
" name="px">
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