<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 14:53:56
         compiled from "./templates/platform/regCorrect.html" */ ?>
<?php /*%%SmartyHeaderCode:177704504656cfefbec4b0e1-36635145%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '057d6ec52fc87d51afd4b0495fb64b5ab77095cb' => 
    array (
      0 => './templates/platform/regCorrect.html',
      1 => 1456972708,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '177704504656cfefbec4b0e1-36635145',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56cfefbed4b84',
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
<?php if ($_valid && !is_callable('content_56cfefbed4b84')) {function content_56cfefbed4b84($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/91yxq/admin.91yxq.com/Smarty-3.1.7/plugins/modifier.date_format.php';
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
            <li><a class="add" title="关联回源" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&navTabId=<?php echo $_GET['navTabId'];?>
" height="480" target="dialog" mask="true"><span>添加修复账号</span></a></li>
            <li><a class="add" style="color: red;"><span>PS：内充只绑本周数据</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%"  layoutH="75">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>玩家账号</th>
                            <th>关联公会</th>
                            <th>关联游戏</th>
                            <th>操作结果</th>
                            <th>操作人ID</th>
                            <th>操作时间</th>
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
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['user_name'];?>
</td>
                                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['agentname'])===null||$tmp==='' ? "-- --" : $tmp);?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['game'];?>
<?php echo $_smarty_tpl->tpl_vars['vo']->value['server_id'];?>
服</td>
                                <td <?php if ($_smarty_tpl->tpl_vars['vo']->value['result']!=1){?> style="color: red;"<?php }?>><?php if ($_smarty_tpl->tpl_vars['vo']->value['result']==1){?>成功<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['vo']->value['result'];?>
<?php }?></td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['uid'];?>
</td>
                                <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vo']->value['bTime'],"%Y-%m-%d %H:%I:%S");?>
</td>
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