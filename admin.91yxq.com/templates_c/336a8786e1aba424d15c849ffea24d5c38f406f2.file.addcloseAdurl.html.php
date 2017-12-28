<?php /* Smarty version Smarty-3.1.7, created on 2016-12-26 22:37:22
         compiled from "./templates/system/addcloseAdurl.html" */ ?>
<?php /*%%SmartyHeaderCode:50852881958612b22528f71-73542417%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '336a8786e1aba424d15c849ffea24d5c38f406f2' => 
    array (
      0 => './templates/system/addcloseAdurl.html',
      1 => 1456972710,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '50852881958612b22528f71-73542417',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'close' => 0,
    'gamelist' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58612b225e151',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58612b225e151')) {function content_58612b225e151($_smarty_tpl) {?><div class="pageContent">
    <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <input name="sub" type="hidden" value="1" />
    <input name="id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['close']->value['id'];?>
" />
    <div class="pageFormContent" layoutH="68">
        <div class="unit">
                <label>游戏：</label>
            <select class="combox" name="game_id" id="game_id11" >
                <option value="0">请选择</option>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gamelist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                     <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['close']->value['game_id']==$_smarty_tpl->tpl_vars['v']->value['id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                     <?php } ?>
                 </select>
                <input type="text" id="search_key3011" size="10" class="" value="输入关键字"/>
         </div>
          <div class="unit">
            <label>公会ID（aid）:</label>
            <input type="text" name="agent_id"  class="required digits"  value="<?php echo $_smarty_tpl->tpl_vars['close']->value['agent_id'];?>
">
         </div>
        <div class="unit">
            <label>区服ID（sid）:</label>
            <input type="text" name="server_id" class="required textInput error" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['close']->value['server_id'])===null||$tmp==='' ? "0" : $tmp);?>
">
            <span class="info"> 0 表示全服</span>
        </div>
                
       
    </div>
    <div class="formBar">
        <ul>
            <li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
            <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
        </ul>
    </div>
    </form>
</div>
<script>
    var pro_str={ <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gamelist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?> "<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
":"<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
", <?php } ?> };
    search_pro('search_key3011','game_id11');
</script><?php }} ?>