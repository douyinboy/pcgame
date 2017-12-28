<?php /* Smarty version Smarty-3.1.7, created on 2016-12-16 19:39:09
         compiled from "./templates/finance/companyMonthData.html" */ ?>
<?php /*%%SmartyHeaderCode:61878605056cfef3e3457f5-56412101%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '191de0cbd6662bb314892d515239b72949a18d49' => 
    array (
      0 => './templates/finance/companyMonthData.html',
      1 => 1456972704,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '61878605056cfef3e3457f5-56412101',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56cfef3e403c8',
  'variables' => 
  array (
    'companyname' => 0,
    'v' => 0,
    'maxmonth' => 0,
    'tmonth' => 0,
    'data' => 0,
    'vo' => 0,
    'hj' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56cfef3e403c8')) {function content_56cfef3e403c8($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="game_id" value="<?php echo $_POST['game_id'];?>
"/>
    <input type="hidden" name="start_date" value="<?php echo $_POST['start_date'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li>  
                <label>研发公司：</label>
                    <select class="combox" name="id" id="id" >
                        <option value="0">请选择</option>
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['companyname']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_POST['id']==$_smarty_tpl->tpl_vars['v']->value['id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                        <?php } ?>
                    </select>
            </li>
            <li>  
                    <label>统计月份：</label>
                    <input type="text" name="start_date" class="date" dateFmt="yyyy-MM" minDate="2014-05" maxDate="<?php echo $_smarty_tpl->tpl_vars['maxmonth']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['tmonth']->value;?>
" readonly="true"/>
				<a class="inputDateButton" href="javascript:;">选择</a></li>
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

        </ul>
    </div>
    <table class="table" width="100%"  layoutH="107">
        <thead>
        <tr>
            <th>研发公司</th>
            <th>游戏</th>
            <th>接口订单金额</th>
            <th>充值总流水</th>
            <th>研发分成</th>
        </tr>
        </thead>
        <tbody>
            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
            <tr target="id" rel="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
" style=" <?php if ($_smarty_tpl->tpl_vars['vo']->value['gamename']=='--'){?> color:red; <?php }?>">
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['company'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['gamename'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['api_success_money'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['game_api_money'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['game_pay'];?>
</td>
            </tr>
            <?php } ?>
            <tr target="id" rel="hj" style="color:#F80C11;">
                <td>合计：</td>
                <td>---</td>
                <td><?php echo $_smarty_tpl->tpl_vars['hj']->value['api_success_money'];?>
</td>
                <td ><?php echo $_smarty_tpl->tpl_vars['hj']->value['game_api_money'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['hj']->value['game_pay'];?>
</td>       
            </tr>
        </tbody>
    </table>
</div><?php }} ?>