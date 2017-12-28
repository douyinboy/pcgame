<?php /* Smarty version Smarty-3.1.7, created on 2017-02-28 10:41:34
         compiled from ".\templates\recharge\settleAccounts.html" */ ?>
<?php /*%%SmartyHeaderCode:1273258b4e35ed2bae6-26717418%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '71193f5a655bfe21b3a00f82e4af2f5ff9c46527' => 
    array (
      0 => '.\\templates\\recharge\\settleAccounts.html',
      1 => 1487134665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1273258b4e35ed2bae6-26717418',
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
  'unifunc' => 'content_58b4e35ed9cf8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58b4e35ed9cf8')) {function content_58b4e35ed9cf8($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\phpStudy\\WWW\\91yxq\\gh.91yxq.com\\Smarty-3.1.7/plugins\\modifier.date_format.php';
?><form id="pagerForm" action="" method="post">
     <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="agentid" value="<?php echo $_POST['agentid'];?>
"/>
    <input type="hidden" name="admin_uid" value="<?php echo $_POST['admin_uid'];?>
"/>
    <input type="hidden" name="start_date" value="<?php echo $_POST['start_date'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
        </ul>
    </div>
    </form>
</div>
<div class="pageContent">
    <table class="table" width="100%"  layoutH="85">
        <thead>
        <tr>
            <th width="300">结算周期</th>
            <th >平台充值总额</th>
            <th>内充总额</th>
            <th>结算金额</th>
            <th width="140">结算时间</th>
            <th width="180">操作</th>
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
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['sDate'];?>
 截止至：<?php echo $_smarty_tpl->tpl_vars['vo']->value['eDate'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['payMoney'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['innerMoney'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['jieMoney'];?>
</td>
                <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vo']->value['jieTime'],"%Y-%m-%d %H:%I:%S");?>
</td>
                <td> <a href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=detail&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"  height="360" width="780" target="dialog" >查看明细</a></td>
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