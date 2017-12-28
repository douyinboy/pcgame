<?php /* Smarty version Smarty-3.1.7, created on 2017-02-16 11:30:17
         compiled from ".\templates\system\guilds.html" */ ?>
<?php /*%%SmartyHeaderCode:3168958a51cc96c8062-42289773%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3dd10bfa5c4edbaba374b4203cbd07ed11267f38' => 
    array (
      0 => '.\\templates\\system\\guilds.html',
      1 => 1487134654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3168958a51cc96c8062-42289773',
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
    'userlist' => 0,
    'totalcount' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58a51cc97c9da',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a51cc97c9da')) {function content_58a51cc97c9da($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="name" value="<?php echo $_POST['name'];?>
"/>
    <input type="hidden" name="aid" value="<?php echo $_POST['aid'];?>
"/>
    <input type="hidden" name="dip" value="<?php echo $_POST['dip'];?>
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
                <label>公会ID：</label>
                <input type="text" name="aid" value="<?php echo $_POST['aid'];?>
"/>
            </li>
            <li>  
                <label>名称/账号：</label>
                <input type="text" name="name" value="<?php echo $_POST['name'];?>
"/>
            </li>
             <li>  
                <label>登录ip：</label>
                <input type="text" name="dip" value="<?php echo $_POST['dip'];?>
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
            <li><a class="add" title="添加公会" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&navTabId=<?php echo $_GET['navTabId'];?>
" height="480" width="700" target="dialog" mask="true"><span>新增</span></a></li>
            <li><a class="edit" title ="编辑公会信息" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&id={id}&navTabId=<?php echo $_GET['navTabId'];?>
" height="450" target="dialog" mask="true" warn="您尚未选择要编辑的公会噢！"><span>编辑</span></a></li>
            <li><a class="delete" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=del&id={id}&navTabId=<?php echo $_GET['navTabId'];?>
" target="ajaxTodo" title="您确定要删除该公会信息吗？" warn="您尚未选择要删除的公会条目噢！"><span>删除</span></a></li>
            <li><a title="您确定要删除所选公会条目吗?" target="selectedTodo" rel="ids" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=mult_del&navTabId=<?php echo $_GET['navTabId'];?>
" postType="string" warn="您尚未选择要删除的公会条目噢！" class="delete"><span>批量删除</span></a></li>
        <li>
            <a class="icon" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=export" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a>
        </li>
        </ul>
    </div>
    <table class="table" width="100%"  layoutH="137">
        <thead>
        <tr>
            <th><input type="checkbox" group="ids" class="checkboxCtrl"></th>
            <th style="background:#cde;" onclick="sortBy('id',this)">公会ID</th>
            <th>公会名称</th>
            <th>公会管理者</th>
            <th>联系QQ</th>
            <th>YY号</th>
            <th style="background:#cde;" onclick="sortBy('lastdate',this)">最后登录时间</th>
            <th>最后登录IP</th>
            <th>最后登录地区</th>
            <th style="background:#cde;" onclick="sortBy('logincount',this)">登录次数</th>
            <th>添加人</th>
            <th>添加时间</th>
            <th>当前状态</th>
            <th>操作</th>
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
            <tr target="sid" rel="1" style="background-color: <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['test']['iteration']%2==0){?> #e2edf4;<?php }?>">
                <td><input name="ids" value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
" type="checkbox"></td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agentname'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['user_name'];?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['qq'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['yy'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['lastdate'])===null||$tmp==='' ? "--- ---" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['lastip'])===null||$tmp==='' ? "--- ---" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['ipaddress'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><span style="color:red"><?php echo $_smarty_tpl->tpl_vars['vo']->value['logincount'];?>
</span></td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['userlist']->value[$_smarty_tpl->tpl_vars['vo']->value['adduid']]['uName'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['add_date'];?>
</td>
                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['state']==1){?>正常<?php }else{ ?>禁止<?php }?></td>
                <td>
                    <a title="编辑公会信息" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
&province=<?php echo $_smarty_tpl->tpl_vars['vo']->value['province'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="btnEdit"  height="480" width="700" target="dialog" mask="true">编辑</a>
                    <a title="确定要删除该公会信息吗？" target="ajaxTodo" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=del&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="btnDel">删除</a>
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
条</span>
        </div>
        <div class="pagination" targetType="navTab" totalCount="<?php echo $_smarty_tpl->tpl_vars['totalcount']->value;?>
" numPerPage="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
" pageNumShown="10" currentPage="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"></div>
    </div>
</div><?php }} ?>