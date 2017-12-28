<?php /* Smarty version Smarty-3.1.7, created on 2017-09-05 17:57:58
         compiled from ".\templates\system\payToggle.html" */ ?>
<?php /*%%SmartyHeaderCode:2273259ae66ff52d039-80071572%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb0e47ca703438981848e1f849cb55ca3b6ae7ee' => 
    array (
      0 => '.\\templates\\system\\payToggle.html',
      1 => 1504605472,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2273259ae66ff52d039-80071572',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_59ae66ff94fab',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59ae66ff94fab')) {function content_59ae66ff94fab($_smarty_tpl) {?><div style="margin: 100px auto 0; width: 500px; height: 300px;">
    <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=sub&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
        <select name="rechargeType" id="" style="width: 200px; height: 32px; font-size: 16px; margin-right: 60px;">
            <option value="0" style="font-size: 16px;">直立行走充值系统</option>
            <option value="1" style="font-size: 16px;">畅付云充值系统</option>
        </select>
        <input style="width: 50px; height: 32px; font-size: 16px; cursor: pointer;" type="submit" value="确认">
    </form>
</div><?php }} ?>