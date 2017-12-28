<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 15:47:01
         compiled from "./templates/system/guildMembers.html" */ ?>
<?php /*%%SmartyHeaderCode:134701828356a432f908c428-84420412%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5fa2eb1b775b76bde42d97ca22dfe88d76ce0111' => 
    array (
      0 => './templates/system/guildMembers.html',
      1 => 1456973058,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '134701828356a432f908c428-84420412',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56a432f927732',
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'adminInfo' => 0,
    'data' => 0,
    'vo' => 0,
    'totalcount' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56a432f927732')) {function content_56a432f927732($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="name" value="<?php echo $_POST['name'];?>
"/>
    <input type="hidden" name="id" value="<?php echo $_POST['id'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li> 
                <label>成员名：</label>
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
            <li><a class="add" title="添加成员" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&navTabId=<?php echo $_GET['navTabId'];?>
" height="205" target="dialog" mask="true"><span>新增</span></a></li>
            <li><a class="edit" title ="编辑成员信息" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&id={id}&navTabId=<?php echo $_GET['navTabId'];?>
" height="205" target="dialog" mask="true" warn="您尚未选择要编辑的公会成员噢！"><span>编辑</span></a>
       </ul>
    </div>
    <table class="table" width="100%"  layoutH="137">
        <thead>
        <tr>
            <th width="22"><input type="checkbox" group="ids" class="checkboxCtrl"></th>
            <th width="80">成员ID</th>
            <th width="160">成员名</th>
            <th width="130">登录账号</th>
            <th width="160">添加时间</th>
            <th width="160">登录次数</th>
            <th width="160">最后登录地区</th>
            <th width="110">当前状态</th>
            <th width="160" >操作</th>
        </tr>
        </thead>
        
        <tbody>
            <td>--</td>
            <td><?php echo $_smarty_tpl->tpl_vars['adminInfo']->value['uid'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['adminInfo']->value['name'];?>
(会长)</td>
                <td><?php echo $_smarty_tpl->tpl_vars['adminInfo']->value['account'];?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['adminInfo']->value['regdate'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['adminInfo']->value['logincount']+(($tmp = @1)===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['adminInfo']->value['loginaddress'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td>正常</td>
                <td>
                    -----<a title="获取注册链接" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=geturl&id=0&navTabId=get_reg_url"  height="315" width="600" target="dialog" rel="get_reg_url" mask="true">获取链接</a>
                </td>
            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['test']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['test']['iteration']++;
?>
            <tr target="sid" rel="1" style="background-color: <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['test']['iteration']%2!=0){?> #f8fdfc;<?php }?>">
                <td><input name="ids" value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['site_id'];?>
" type="checkbox"></td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['site_id'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['author'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['aAccount'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['addtime'];?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['logincount'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['loginAddress'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['state']==1){?>正常<?php }else{ ?>禁止<?php }?></td>
                <td>
                    <a title="确定要删该成员信息吗？" target="ajaxTodo" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=del&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['site_id'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="btnDel">删除</a>
                    <a title="编辑成员信息" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['site_id'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="btnEdit"  height="205" target="dialog" mask="true">编辑</a>
                    <a title="获取注册链接" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=geturl&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['site_id'];?>
&navTabId=get_reg_url"  height="315" width="600" target="dialog" rel="get_reg_url" mask="true">获取链接</a>
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