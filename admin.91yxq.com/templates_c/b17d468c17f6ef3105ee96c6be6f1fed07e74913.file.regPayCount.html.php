<?php /* Smarty version Smarty-3.1.7, created on 2017-01-02 22:05:24
         compiled from "./templates/register/regPayCount.html" */ ?>
<?php /*%%SmartyHeaderCode:1799664681586a5e24da7b26-57733924%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b17d468c17f6ef3105ee96c6be6f1fed07e74913' => 
    array (
      0 => './templates/register/regPayCount.html',
      1 => 1456972704,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1799664681586a5e24da7b26-57733924',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'data' => 0,
    'vo' => 0,
    'totalcount' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_586a5e24e50e5',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_586a5e24e50e5')) {function content_586a5e24e50e5($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="name" value="<?php echo $_POST['name'];?>
"/>
    <input type="hidden" name="aid" value="<?php echo $_POST['aid'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
         <ul class="searchContent">
            
         </ul>
        <ul class="searchContent">
            <li>  
                <label>起始日期：</label>
                <input type="text" name="start_date" class="date" value="<?php echo $_POST['start_date'];?>
" readonly="true"/>
                <a class="inputDateButton" href="javascript:;">选择</a>
            </li>
            <li>  
                <label>结束日期：</label>
                <input type="text" name="end_date" class="date" value="<?php echo $_POST['end_date'];?>
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
    
    <table class="table" width="100%"  layoutH="137">
        <thead>
        <tr>
            <th width="80">公会ID</th>
            <th width="120">公会名称</th>
            <th width="120">联系QQ</th>
            <th width="150">开户银行</th>
            <th width="150">开户人</th>
            <th width="150">银行账户</th>
            <th width ="80">注册人数</th>
            <th width ="80">充值金额</th>
            <th width="110">入注天数</th>
        </tr>
        </thead>
        <tbody>
            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
            <tr target="id" rel="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
">
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agentname'];?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['qq'])===null||$tmp==='' ? "--- ---" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['bank'])===null||$tmp==='' ? "--- ---" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['account_name'])===null||$tmp==='' ? "--- ---" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['account'])===null||$tmp==='' ? "--- ---" : $tmp);?>
</td>
                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['reg_count']>0){?><?php echo $_smarty_tpl->tpl_vars['vo']->value['reg_count'];?>
<?php }else{ ?>0<?php }?></td>
                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['pay_total']>0){?><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_total'];?>
<?php }else{ ?>0<?php }?></td>
                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['reg_date']>0){?><?php echo $_smarty_tpl->tpl_vars['vo']->value['reg_date'];?>
天<?php }else{ ?>0<?php }?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="panelBar">
        <div class="pages"><span>显示</span>
            <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
                <option <?php if ($_POST['numPerPage']==20){?>selected<?php }?>  value="20">20</option>
                <option <?php if ($_POST['numPerPage']==50){?>selected<?php }?> value="50">50</option>
                <option <?php if ($_POST['numPerPage']==100){?>selected<?php }?> value="100">100</option>
                <option <?php if ($_POST['numPerPage']==200){?>selected<?php }?> value="200">200</option>
            </select><span>条，共<?php echo $_smarty_tpl->tpl_vars['totalcount']->value;?>
条</span>
        </div>
        <div class="pagination" targetType="navTab" totalCount="<?php echo $_smarty_tpl->tpl_vars['totalcount']->value;?>
" numPerPage="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
" pageNumShown="10" currentPage="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"></div>
    </div>
</div><?php }} ?>