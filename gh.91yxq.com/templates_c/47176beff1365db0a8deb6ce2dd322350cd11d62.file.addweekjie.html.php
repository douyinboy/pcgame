<?php /* Smarty version Smarty-3.1.7, created on 2017-01-02 21:12:49
         compiled from "./templates/payjie/addweekjie.html" */ ?>
<?php /*%%SmartyHeaderCode:913746125586a51d1874eb3-76751389%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '47176beff1365db0a8deb6ce2dd322350cd11d62' => 
    array (
      0 => './templates/payjie/addweekjie.html',
      1 => 1456973056,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '913746125586a51d1874eb3-76751389',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'info' => 0,
    'vo' => 0,
    'heji' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_586a51d19de04',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_586a51d19de04')) {function content_586a51d19de04($_smarty_tpl) {?><form id="pagerForm" action="?action=management&opt=searchActorBringBack" >
	<input type="hidden" name="pageNum" value="1" />
	
</form>
<div class="pageContent">
    <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone)">
	<input name="sub" type="hidden" value="1" />
	<div class="pageFormContent" layoutH="68">
	
            <table class="table" width="100%"  layoutH="150">
                    <thead>
                        <tr>
                            <th width="40">周期</th>
                            <th width="120">起始--截止(日期)</th>
                            <th width="80">公会名称</th>
                            <th width="80">平台充值</th>
                            <th width="80">平台充值流水</th>
                            <th width="50">首充</th>
                            <th width="50">内充</th>
                            <th width="50">V充</th>
                            <th width="80">打款金额</th>
                        </tr>
                    </thead>
                    <tbody>
                        <volist id="vo" name="list">
                            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['info']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
                            <tr target="sid" rel="1">
                                <td>第<?php echo $_smarty_tpl->tpl_vars['vo']->value['weekth'];?>
周</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['starttime'];?>
 --<?php echo $_smarty_tpl->tpl_vars['vo']->value['endtime'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agentname'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_money'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_amount'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_first'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_inner'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_vip'];?>
</td>
                                <td>
                                     <a style="color:red;" href="?action=<?php echo $_GET['action'];?>
&opt=detail&wsdate=<?php echo $_smarty_tpl->tpl_vars['vo']->value['wsdate'];?>
&wedate=<?php echo $_smarty_tpl->tpl_vars['vo']->value['wedate'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
"  target="dialog" lookupGroup="movie" suffix="[]" height="385" width='700'><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_jie'];?>
</a>
                                </td>
                            </tr>
                            <?php } ?>
                             <tr target="sid" rel="1">
                                <td>合计：</td>
                                <td>---</td>
                                <td>---</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['heji']->value['allmoney'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['heji']->value['payaccount'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['heji']->value['payfirst'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['heji']->value['payinner'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['heji']->value['vmoney'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['heji']->value['jiemoney'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                        </volist>
                    </tbody>
    </table>
        <div class="unit">
            <label style="width: 50px;">密码:</label>
            <input type="password" name="pass" size="20" value=""/>
            <span class="info">必需输入密码才可以提交</span>
        </div>
        <div class="unit">
            <span style='color: red;display: block;float: left;line-height: 21px;'>*如信息有误请找运营确认后再操作*</span>
        </div>
    </div>
    <div class="formBar">
        <ul>
           
            <li><div class="buttonActive"><div class="buttonContent"><button type="submit" >提交</button></div></div></li>
            <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
        </ul>
    </div>
    </form>
</div><?php }} ?>