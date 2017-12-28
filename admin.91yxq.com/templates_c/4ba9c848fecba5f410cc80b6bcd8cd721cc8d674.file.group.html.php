<?php /* Smarty version Smarty-3.1.7, created on 2017-02-16 10:20:19
         compiled from ".\templates\system\group.html" */ ?>
<?php /*%%SmartyHeaderCode:3031458a50c63331919-23942324%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4ba9c848fecba5f410cc80b6bcd8cd721cc8d674' => 
    array (
      0 => '.\\templates\\system\\group.html',
      1 => 1487134654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3031458a50c63331919-23942324',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'orderField' => 0,
    'orderDesc' => 0,
    'data' => 0,
    'vo' => 0,
    'username' => 0,
    'totalcount' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58a50c633dd73',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a50c633dd73')) {function content_58a50c633dd73($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'E:\\phpStudy\\WWW\\91yxq\\admin.91yxq.com\\Smarty-3.1.7/plugins\\modifier.date_format.php';
?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="name" value="<?php echo $_POST['name'];?>
"/>
    <input type="hidden" name="orderField" value="<?php echo $_smarty_tpl->tpl_vars['orderField']->value;?>
" class="orderField_input"/>
    <input type="hidden" name="orderDesc" value="<?php echo $_smarty_tpl->tpl_vars['orderDesc']->value;?>
" class="orderDesc_input"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li>  
                <label>组名称：</label>
                <input type="text" name="name" value="<?php echo $_POST['name'];?>
"/>
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
            <li><a class="add" title="添加权限组" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&navTabId=<?php echo $_GET['navTabId'];?>
" height="300" target="dialog" mask="true"><span>新增</span></a></li>
            <li><a class="edit" title ="编辑权限组" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&id={group_id}&navTabId=<?php echo $_GET['navTabId'];?>
" height="300" target="dialog" mask="true" warn="您尚未选择要编辑的权限组噢！"><span>编辑</span></a></li>
            <li><a class="delete" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=del&id={group_id}&navTabId=<?php echo $_GET['navTabId'];?>
" target="ajaxTodo" title="您确定要删除该权限组吗？" warn="您尚未选择要删除的组噢！"><span>删除</span></a></li>
            <li><a title="您确定要删除所选组吗?" target="selectedTodo" rel="ids" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=mult_del&navTabId=<?php echo $_GET['navTabId'];?>
" postType="string" warn="您尚未选择要删除的组噢！" class="delete"><span>批量删除</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%"  layoutH="137">
        <thead>
        <tr>
            <th width="22"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
            <th style="background:#cde;" onclick="sortBy('gId',this)">用户组ID</th>
            <th>组名称</th>
            <th style="background:#cde;" onclick="sortBy('cTime',this)">创建时间</th>
            <th>创建者</th>
            <th style="background:#cde;" onclick="sortBy('updTime',this)">最后修改时间</th>
            <th>修改者</th>
            <th>组&nbsp;状&nbsp;态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <volist id="vo" name="list">
            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['test']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['test']['iteration']++;
?>
            <tr target="sid" rel="1" style="background-color: <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['test']['iteration']%2==0){?> #eceded;<?php }?>">
                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['gId']!=1){?><input name="ids" value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['gId'];?>
" type="checkbox"><?php }?></td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['gId'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['gName'];?>
</td>
                <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vo']->value['cTime'],"%Y-%m-%d %H:%I:%S");?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['username']->value[$_smarty_tpl->tpl_vars['vo']->value['cUser']]['uName'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['updTime']>0){?><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vo']->value['updTime'],"%Y-%m-%d %H:%I:%S");?>
<?php }else{ ?>--<?php }?></td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['username']->value[$_smarty_tpl->tpl_vars['vo']->value['updUser']]['uName'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['gState']==1){?>正常开启<?php }else{ ?>已禁用<?php }?></td>
                <td>
                    <a title="编辑用户组信息" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['gId'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="btnEdit"  height="300" target="dialog" mask="true">编辑</a>
               <?php if ($_smarty_tpl->tpl_vars['vo']->value['gId']!=1){?>
                    <a title="编辑组权限" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=editGroupGrant&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['gId'];?>
" height="470" width="905" target="dialog" mask="true" class="btnView">设置组权限</a>
                    <a title="确定要删除该组吗？" target="ajaxTodo" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=del&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['gId'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="btnDel">删除</a>
                <?php }?>
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