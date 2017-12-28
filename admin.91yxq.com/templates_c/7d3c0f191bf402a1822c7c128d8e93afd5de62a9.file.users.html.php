<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 12:13:16
         compiled from "./templates/system/users.html" */ ?>
<?php /*%%SmartyHeaderCode:147953190556cff54a000967-24234547%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d3c0f191bf402a1822c7c128d8e93afd5de62a9' => 
    array (
      0 => './templates/system/users.html',
      1 => 1456972708,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '147953190556cff54a000967-24234547',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56cff54a222e5',
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'orderField' => 0,
    'orderDesc' => 0,
    'group' => 0,
    'v' => 0,
    'data' => 0,
    'vo' => 0,
    'totalcount' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56cff54a222e5')) {function content_56cff54a222e5($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/91yxq/admin.91yxq.com/Smarty-3.1.7/plugins/modifier.date_format.php';
?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
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
                <label>用户名/账号：</label>
                <input type="text" name="name" value="<?php echo $_POST['name'];?>
"/>
            </li>
            <li>
                <label>权限组：</label>
                    <select class="combox" name="groupid">
                        <option value="0">请选择</option>
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                             <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['gId'];?>
" <?php if ($_POST['groupid']==$_smarty_tpl->tpl_vars['v']->value['gId']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['gName'];?>
</option>
                             <?php } ?>
                    </select>
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
            <li><a class="add" title="添加管理者" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&navTabId=<?php echo $_GET['navTabId'];?>
" height="370" width="600" target="dialog" mask="true"><span>新增</span></a></li>
            <li><a class="edit" title ="编辑管理者" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&id={uid}&navTabId=<?php echo $_GET['navTabId'];?>
" height="370" target="dialog" mask="true" warn="您尚未选择要编辑的管理者噢！"><span>编辑</span></a></li>
            <li><a class="delete" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=del&id={uid}&navTabId=<?php echo $_GET['navTabId'];?>
" target="ajaxTodo" title="您确定要删除该用户信息吗？" warn="您尚未选择要删除的管理者噢！"><span>删除</span></a></li>
            <li><a title="您确定要删除所选管理者吗?" target="selectedTodo" rel="ids" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=mult_del&navTabId=<?php echo $_GET['navTabId'];?>
" postType="string" warn="您尚未选择要删除的管理者噢！" class="delete"><span>批量删除</span></a></li>
       </ul>
    </div>
    <table class="table" width="100%"  layoutH="137">
        <thead>
        <tr>
            <th width="22"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
            <th style="background:#cde;" onclick="sortBy('uid',this)">用户ID</th>
            <th>登录账号</th>
            <th>用户名</th>
            <th>权限组</th>
            <th style="background:#cde;" onclick="sortBy('uLastLoginTime',this)">最后登录时间</th>
            <th>最后登录地区</th>
            <th>最后登录IP</th>
            <th style="background:#cde;" onclick="sortBy('uLoginCount',this)">登录次数</th>
            <th>电话</th>
            <th>邮箱</th>
            <th>当前状态</th>
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
                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['uid']!=1){?><input name="ids" value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['uid'];?>
" type="checkbox"><?php }?></td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['uid'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['uAccount'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['uName'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['gName'];?>
</td>
                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['uLastLoginTime']>0){?><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vo']->value['uLastLoginTime'],"%Y-%m-%d %H:%I:%S");?>
<?php }else{ ?>--<?php }?></td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['uLoginAddress'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['uLastLoginIp'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['uLoginCount'];?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['uPhone'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['umail'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['uLoginState']==1){?>正常<?php }else{ ?>已停用<?php }?></td>
                <td>
                    <a title="编辑用户" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['uid'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="btnEdit"  height="370" width="600" target="dialog" mask="true">编辑</a>
                    <a title="确定要删除该账号吗？" target="ajaxTodo" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=del&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['uid'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="btnDel">删除</a>
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