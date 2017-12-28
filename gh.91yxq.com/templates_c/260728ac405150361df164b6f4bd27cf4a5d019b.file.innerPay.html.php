<?php /* Smarty version Smarty-3.1.7, created on 2017-02-28 10:41:36
         compiled from ".\templates\recharge\innerPay.html" */ ?>
<?php /*%%SmartyHeaderCode:1830958b4e36086d370-19463133%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '260728ac405150361df164b6f4bd27cf4a5d019b' => 
    array (
      0 => '.\\templates\\recharge\\innerPay.html',
      1 => 1487134665,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1830958b4e36086d370-19463133',
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
    'totalmoney' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58b4e360a131d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58b4e360a131d')) {function content_58b4e360a131d($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("smarty.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
</form>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
        </ul>
    </div>
    <table class="table" width="100%"  layoutH="75">
        <thead>
        <tr>
            <th >内充订单号</th>
            <th >内充金额</th>
            <th >获得元宝数</th>
            <th>账号</th>
            <th>游戏服区</th>
            <th>角色名</th>
            <th >充值时间</th>
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
            <tr target="sid" rel="1" style="background-color: <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['test']['iteration']%2==0){?> #f8fdfc;<?php }?>">
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['orderid'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['money'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['gold'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['user_name'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['game'];?>
  S<?php echo $_smarty_tpl->tpl_vars['vo']->value['server_id'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['user_role'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['pay_time'];?>
</td>
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
条</span><span style="margin-left: 10px;">共<b style="color: red;"><?php echo $_smarty_tpl->tpl_vars['totalmoney']->value;?>
</b>元</span>
        </div>
        <div class="pagination" targetType="navTab" totalCount="<?php echo $_smarty_tpl->tpl_vars['totalcount']->value;?>
" numPerPage="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
" pageNumShown="10" currentPage="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"></div>
    </div>
</div><?php }} ?>