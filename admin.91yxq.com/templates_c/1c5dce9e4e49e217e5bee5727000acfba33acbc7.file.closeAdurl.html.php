<?php /* Smarty version Smarty-3.1.7, created on 2017-02-16 11:30:23
         compiled from ".\templates\system\closeAdurl.html" */ ?>
<?php /*%%SmartyHeaderCode:409458a51ccf81d3a3-87151295%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c5dce9e4e49e217e5bee5727000acfba33acbc7' => 
    array (
      0 => '.\\templates\\system\\closeAdurl.html',
      1 => 1487134654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '409458a51ccf81d3a3-87151295',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'gamelist' => 0,
    'v' => 0,
    'data' => 0,
    'vo' => 0,
    'totalcount' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58a51ccf8c14d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a51ccf8c14d')) {function content_58a51ccf8c14d($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
     <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="game_id" value="<?php echo $_POST['agent_id'];?>
"/>
    <input type="hidden" name="server_id" value="<?php echo $_POST['server_id'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li>
                <label>游戏：</label>
                <select class="combox" name="game_id" id="game_id18" >
                <option value="0">请选择</option>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gamelist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                     <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_POST['game_id']==$_smarty_tpl->tpl_vars['v']->value['id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                     <?php } ?>
                 </select>
                <input type="text" id="game_id_key30123" size="10" class="" value="输入关键字"/>
            </li>
            <li>  
                <label>公会ID(aid)：</label>
                <input type="text" name="agent_id" class="" value="<?php echo $_POST['agent_id'];?>
"/>
            </li> 
            
            <li>
                <label>区服ID(sid)：</label>
                  <input type="text" name="server_id" class="" value="<?php echo $_POST['server_id'];?>
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
            <li><a class="add" title="添加封禁链接" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&navTabId=<?php echo $_GET['navTabId'];?>
" height="200" target="dialog" mask="true"><span>新增封禁链接</span></a></li>
        </ul>
    </div>
    <table class="table" width="100%"  layoutH="137">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>游戏</th>
                    <th>公会ID(aid)</th>
                    <th>区服ID(sid)</th>
                    <th>操作人</th>
                    <th>操作时间</th>
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
                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['name'];?>
(<?php echo $_smarty_tpl->tpl_vars['vo']->value['game_id'];?>
)</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agent_id'];?>
</td>
                        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['server_id'])===null||$tmp==='' ? "-- --" : $tmp);?>
</td>
                        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['uName'])===null||$tmp==='' ? " " : $tmp);?>
</td>
                        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['atime'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                        <td>
                              <a title="编辑" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="btnEdit"  height="200" target="dialog" mask="true">编辑</a>
                            <a title="确定要解封该链接吗？" target="ajaxTodo" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=jie&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="" style="color: #F00;">解封</a>
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
 $_from = $_smarty_tpl->tpl_vars['gamelist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?> "<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
":"<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
", <?php } ?> };
    search_pro('game_id_key30123','game_id18');
</script><?php }} ?>