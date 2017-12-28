<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 15:43:11
         compiled from "./templates/system/guildMembers.html" */ ?>
<?php /*%%SmartyHeaderCode:199059868156cff0d919b182-06921686%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5fa2eb1b775b76bde42d97ca22dfe88d76ce0111' => 
    array (
      0 => './templates/system/guildMembers.html',
      1 => 1456972710,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '199059868156cff0d919b182-06921686',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56cff0d93ca1e',
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'orderField' => 0,
    'orderDesc' => 0,
    'guildlist' => 0,
    'v' => 0,
    'data' => 0,
    'vo' => 0,
    'totalcount' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56cff0d93ca1e')) {function content_56cff0d93ca1e($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="name" value="<?php echo $_POST['name'];?>
"/>
    <input type="hidden" name="id" value="<?php echo $_POST['id'];?>
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
                <label>公会：</label>
                <select class="combox" name="id" id="agent_id12">
                    <option value="0">选择公会</option>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_POST['id']==$_smarty_tpl->tpl_vars['v']->value['id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['agentname'];?>
</option>
                <?php } ?>
                </select>
                <input type="text" id="search_key30123" size="10" class="" value="输入关键字"/>
            </li>
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
            <li><a class="add" title="添加公会成员" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&navTabId=<?php echo $_GET['navTabId'];?>
" height="245" target="dialog" mask="true"><span>新增</span></a></li>
            <li><a class="edit" title ="编辑公会成员信息" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&id={id}&navTabId=<?php echo $_GET['navTabId'];?>
" height="245" target="dialog" mask="true" warn="您尚未选择要编辑的公会成员噢！"><span>编辑</span></a></li>
            <li><a class="delete" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=del&id={id}&navTabId=<?php echo $_GET['navTabId'];?>
" target="ajaxTodo" title="您确定要删除该公会信息吗？" warn="您尚未选择要删除的公会成员条目噢！"><span>删除</span></a></li>
            <li><a title="您确定要删除所选公会成员条目吗?" target="selectedTodo" rel="ids" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=mult_del&navTabId=<?php echo $_GET['navTabId'];?>
" postType="string" warn="您尚未选择要删除的公会成员条目噢！" class="delete"><span>批量删除</span></a></li>
       </ul>
    </div>
    <table class="table" width="100%"  layoutH="137">
        <thead>
        <tr>
            <th><input type="checkbox" group="ids" class="checkboxCtrl"></th>
            <th style="background:#cde;" onclick="sortBy('site_id',this)">成员ID</th>
            <th>成员名</th>
            <th style="background:#cde;" onclick="sortBy('agent_id',this)">所属公会（ID）</th>
            <th>登录账号</th>
            <th style="background:#cde;" onclick="sortBy('addtime',this)">添加时间</th>
            <th style="background:#cde;" onclick="sortBy('loginTime',this)">最后登录时间</th>
            <th>最后登录IP</th>
            <th>最后登录地区</th>
            <th style="background:#cde;" onclick="sortBy('logincount',this)">登录次数</th>
            <th style="background:#cde;" onclick="sortBy('state',this)">当前状态</th>
            <th >操作</th>
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
            <tr target="sid" rel="1" style="background-color: <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['test']['iteration']%2==0){?> #e4edf2;<?php }?>">
                <td><input name="ids" value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['site_id'];?>
" type="checkbox"></td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['site_id'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['author'];?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['guildlist']->value[$_smarty_tpl->tpl_vars['vo']->value['agent_id']]['agentname'])===null||$tmp==='' ? "不存在" : $tmp);?>
(<?php echo $_smarty_tpl->tpl_vars['vo']->value['agent_id'];?>
)</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['aAccount'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['addtime'];?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['loginTime'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['loginIp'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['loginAddress'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                <td><span style="color:red"><?php echo $_smarty_tpl->tpl_vars['vo']->value['logincount'];?>
</span></td>
                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['state']==1){?>正常<?php }else{ ?>禁止<?php }?></td>
                <td>
                    <a title="编辑成员信息" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['site_id'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="btnEdit"  height="245" target="dialog" mask="true">编辑</a>
                    <a title="确定要删除该成员信息吗？" target="ajaxTodo" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=del&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['site_id'];?>
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
</div>
<script>
    var pro_str={ <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?> "<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
":"<?php echo $_smarty_tpl->tpl_vars['v']->value['agentname'];?>
", <?php } ?> };
    search_pro('search_key30123','agent_id12');
</script><?php }} ?>