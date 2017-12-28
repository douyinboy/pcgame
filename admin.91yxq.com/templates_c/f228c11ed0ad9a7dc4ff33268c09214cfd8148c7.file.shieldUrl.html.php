<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 14:53:56
         compiled from "./templates/platform/shieldUrl.html" */ ?>
<?php /*%%SmartyHeaderCode:183616041356cfefbe272144-14675129%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f228c11ed0ad9a7dc4ff33268c09214cfd8148c7' => 
    array (
      0 => './templates/platform/shieldUrl.html',
      1 => 1456972708,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '183616041356cfefbe272144-14675129',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56cfefbe3a14a',
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'data' => 0,
    'vo' => 0,
    'totalcount' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56cfefbe3a14a')) {function content_56cfefbe3a14a($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/91yxq/admin.91yxq.com/Smarty-3.1.7/plugins/modifier.date_format.php';
?><form id="pagerForm" action="" method="post">
     <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
</form>
<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <li><a class="add" title="添加屏蔽链接" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&navTabId=<?php echo $_GET['navTabId'];?>
" height="180" target="dialog" mask="true"><span>添加屏蔽链接</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%"  layoutH="75">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>操作公会(成员ID)</th>
                            <th>操作游戏</th>
                            <th>操作人</th>
                            <th>操作时间</th>
                            <th>相差金额</th>
                            <th>操作状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <volist id="vo" name="list">
                            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>                       
                            <tr target="sid" rel="1">
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agentname'];?>
(<?php echo $_smarty_tpl->tpl_vars['vo']->value['placeid'];?>
)</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['game'];?>
<?php echo $_smarty_tpl->tpl_vars['vo']->value['server_id'];?>
服</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['addUser'];?>
</td>
                                <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vo']->value['addTime'],"%Y-%m-%d %H:%I:%S");?>
</td>                                
                                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['last_money']>0){?><?php echo $_smarty_tpl->tpl_vars['vo']->value['last_money'];?>
<?php }else{ ?>0<?php }?></td>                               
                                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['ifback']==1){?>已还原<?php }else{ ?>已切断<?php }?></td>
                                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['ifback']!=1){?><a title="确定要还原该链接并还原期间玩家充值记录吗？" target="ajaxTodo" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=forback&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="">链接还原</a><?php }?></td>
                            </tr>                           
                            <?php } ?>
                        </volist>
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