<?php /* Smarty version Smarty-3.1.7, created on 2017-02-15 18:19:50
         compiled from ".\templates\sysmanage\bestSeller.html" */ ?>
<?php /*%%SmartyHeaderCode:1201958a42b46092be3-53208793%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '67ff4419954b5a69c0f083b2eb55eec2a2a70261' => 
    array (
      0 => '.\\templates\\sysmanage\\bestSeller.html',
      1 => 1487134654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1201958a42b46092be3-53208793',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'vo' => 0,
    'date' => 0,
    'hj' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58a42b460b5e7',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a42b460b5e7')) {function content_58a42b460b5e7($_smarty_tpl) {?>
<table class="table" width="125%" layoutH="167">
        <thead>
            <tr>
                <th>公会ID</th>
                <th>公会名</th>
                <th>充值金额</th>
                <th>注册人数</th>
                <th>昨天充值金额</th>
                <th>昨天注册人数</th>
                <th>排行日期</th>
            </tr>
        </thead>
        <tbody>
            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
            <tr target="sid" rel="1">
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['agent_id'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['agentname'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['paydata'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['regdata'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['paydatay'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['regdatay'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['date']->value;?>
</td>
            </tr>
            <?php } ?>
            <tr target="sid" rel="1">
                <td>合计：</td>
                <td>--</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['hj']->value['paydata'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['hj']->value['regdata'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['hj']->value['paydatay'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['hj']->value['regdatay'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td>--</td>
            </tr>
        </tbody>
    </table>
<?php }} ?>