<?php /* Smarty version Smarty-3.1.7, created on 2017-02-23 15:23:19
         compiled from ".\templates\recharge\guildPaySearch.html" */ ?>
<?php /*%%SmartyHeaderCode:1440658ae8de72baaf4-68033796%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0719bbebbcb1ccdaaad35bbb7dcaf40b6f0b1d89' => 
    array (
      0 => '.\\templates\\recharge\\guildPaySearch.html',
      1 => 1487134654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1440658ae8de72baaf4-68033796',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'start_date' => 0,
    'end_date' => 0,
    'data' => 0,
    'vo' => 0,
    'hj' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58ae8de731c58',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58ae8de731c58')) {function content_58ae8de731c58($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input name="start_date" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
" />
    <input name="end_date" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
" />
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <div class="searchBar">
        <ul class="searchContent">
            <li>  
                <label>起始日期：</label>
                    <input type="text" name="start_date" class="date" value="<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
" readonly="true"/>
                    <a class="inputDateButton" href="javascript:;">选择</a>
            </li>
            <li>  
                <label>结束日期：</label>
                    <input type="text" name="end_date" class="date" value="<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
" readonly="true"/>
                    <a class="inputDateButton" href="javascript:;">选择</a>
            </li>
        </ul>
        <div class="subBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">查询</button></div></div></li>
            </ul>
        </div>
    </div>
    </form>
</div>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
        <li><a class="icon" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=export&start_date=<?php echo $_POST['start_date'];?>
&end_date=<?php echo $_POST['end_date'];?>
" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
        <li><a class="icon" href="javascript:$.printBox('w_list_print')"><span>打印</span></a></li>
        </ul>
    </div>
    <div id="w_list_print">
        <table class="table" width="100%"  layoutH="107">
                    <thead>
                        <tr>
                            <th>公会ID</th>
                            <th>公会名称</th>
                            <th>期间充值总额</th>
                            <th>期间内充金额</th>
                            <th>结算金额</th>
                            <th>开户人</th>
                            <th>银行账户</th>
                            <th>开户银行</th> 
                        </tr>
                    </thead>
                    <tbody>
                            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['test']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['test']['iteration']++;
?>
                            <?php if ($_smarty_tpl->tpl_vars['vo']->value['totalMoney']>0||$_smarty_tpl->tpl_vars['vo']->value['totayInner']>0){?>
                            <tr target="sid" rel="1" style="background-color: <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['test']['iteration']%2==0){?> #f6fcfc;<?php }?>">
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agentname'];?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['totalMoney'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['totayInner'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['jieMoney'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['account_name'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['account'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['bank'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                            </tr>
                            <?php }?>
                            <?php } ?>
                            <tr target="sid" rel="1">
                                <td>合计：</td>
                                <td></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['hj']->value['totalMoney'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['hj']->value['totayInner'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['hj']->value['totalJie'];?>
</td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                            </tr>
                    </tbody>
        </table>
   </div>     
</div><?php }} ?>