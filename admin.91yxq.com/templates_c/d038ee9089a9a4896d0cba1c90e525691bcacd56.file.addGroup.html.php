<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 15:17:07
         compiled from "./templates/system/addGroup.html" */ ?>
<?php /*%%SmartyHeaderCode:185852426156cff0c25acc85-79525316%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd038ee9089a9a4896d0cba1c90e525691bcacd56' => 
    array (
      0 => './templates/system/addGroup.html',
      1 => 1456972710,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '185852426156cff0c25acc85-79525316',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56cff0c26065c',
  'variables' => 
  array (
    'gInfo' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56cff0c26065c')) {function content_56cff0c26065c($_smarty_tpl) {?><div class="pageContent">
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