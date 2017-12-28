<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 12:12:20
         compiled from "./templates/sysmanage/leftMenu.html" */ ?>
<?php /*%%SmartyHeaderCode:209336989552e1f997ac3286-07400207%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14275b5e75e1ab1196d4cfce496de97d5fd1d65e' => 
    array (
      0 => './templates/sysmanage/leftMenu.html',
      1 => 1456972710,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '209336989552e1f997ac3286-07400207',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_52e1f997b9d3c',
  'variables' => 
  array (
    'leftMenu' => 0,
    'item' => 0,
    'item2' => 0,
    'item3' => 0,
    'item4' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52e1f997b9d3c')) {function content_52e1f997b9d3c($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("smarty.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<div class="accordion" fillSpace="sidebar"><!-- 菜单容器 -->
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['leftMenu']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
    <div class="accordionHeader">
        <h2><span>Folder</span><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</h2>
    </div>
    <div class="accordionContent">
        <ul class="tree treeFolder">
        <?php  $_smarty_tpl->tpl_vars['item2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item2']->_loop = false;
 $_smarty_tpl->tpl_vars['key2'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value['sondir']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item2']->key => $_smarty_tpl->tpl_vars['item2']->value){
$_smarty_tpl->tpl_vars['item2']->_loop = true;
 $_smarty_tpl->tpl_vars['key2']->value = $_smarty_tpl->tpl_vars['item2']->key;
?>
            <li><a><?php echo $_smarty_tpl->tpl_vars['item2']->value['title'];?>
</a>
                <ul>
                    <?php  $_smarty_tpl->tpl_vars['item3'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item3']->_loop = false;
 $_smarty_tpl->tpl_vars['key3'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item2']->value['sonfunc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item3']->key => $_smarty_tpl->tpl_vars['item3']->value){
$_smarty_tpl->tpl_vars['item3']->_loop = true;
 $_smarty_tpl->tpl_vars['key3']->value = $_smarty_tpl->tpl_vars['item3']->key;
?>
                    <li><a href="?action=<?php echo $_smarty_tpl->tpl_vars['item3']->value['module'];?>
&opt=<?php echo $_smarty_tpl->tpl_vars['item3']->value['option'];?>
<?php if (!empty($_smarty_tpl->tpl_vars['item4']->value['menu'])){?>&menu=<?php echo $_smarty_tpl->tpl_vars['item4']->value['menu'];?>
<?php }?>&navTabId=grant<?php echo $_smarty_tpl->tpl_vars['item3']->value['key'];?>
" target="navTab" rel="grant<?php echo $_smarty_tpl->tpl_vars['item3']->value['key'];?>
"><?php echo $_smarty_tpl->tpl_vars['item3']->value['title'];?>
</a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
       <?php  $_smarty_tpl->tpl_vars['item4'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item4']->_loop = false;
 $_smarty_tpl->tpl_vars['key4'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value['sonfunc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item4']->key => $_smarty_tpl->tpl_vars['item4']->value){
$_smarty_tpl->tpl_vars['item4']->_loop = true;
 $_smarty_tpl->tpl_vars['key4']->value = $_smarty_tpl->tpl_vars['item4']->key;
?>
            
       <li ><a href="?action=<?php echo $_smarty_tpl->tpl_vars['item4']->value['module'];?>
&opt=<?php echo $_smarty_tpl->tpl_vars['item4']->value['option'];?>
<?php if (!empty($_smarty_tpl->tpl_vars['item4']->value['menu'])){?>&menu=<?php echo $_smarty_tpl->tpl_vars['item4']->value['menu'];?>
<?php }?>&navTabId=grant<?php echo $_smarty_tpl->tpl_vars['item4']->value['key'];?>
" target="navTab" rel="grant<?php echo $_smarty_tpl->tpl_vars['item4']->value['key'];?>
"><?php echo $_smarty_tpl->tpl_vars['item4']->value['title'];?>
</a></li>
       <?php } ?>
        </ul>
    </div>
    <?php } ?>
</div><?php }} ?>