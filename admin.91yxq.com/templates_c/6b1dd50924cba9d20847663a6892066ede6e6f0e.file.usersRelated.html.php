<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 14:53:55
         compiled from "./templates/platform/usersRelated.html" */ ?>
<?php /*%%SmartyHeaderCode:77597184256cfef480d57e9-11438720%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6b1dd50924cba9d20847663a6892066ede6e6f0e' => 
    array (
      0 => './templates/platform/usersRelated.html',
      1 => 1456972708,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '77597184256cfef480d57e9-11438720',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56cfef482a349',
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'guildlist' => 0,
    'v' => 0,
    'guildmembers' => 0,
    'data' => 0,
    'vo' => 0,
    'totalcount' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56cfef482a349')) {function content_56cfef482a349($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/91yxq/admin.91yxq.com/Smarty-3.1.7/plugins/modifier.date_format.php';
?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    
    <input type="hidden" name="name" value="<?php echo $_POST['name'];?>
"/>
    <input type="hidden" name="agentid" value="<?php echo $_POST['agentid'];?>
"/>
    <input type="hidden" name="placeid" value="<?php echo $_POST['placeid'];?>
"/>
    <input type="hidden" name="start_date" value="<?php echo $_POST['start_date'];?>
"/>
    <input type="hidden" name="end_date" value="<?php echo $_POST['end_date'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li><label>公会：</label>
                       <select class="combox" name="agentid" id="agentid22" ref="w_combox_hesid2143" refUrl="?action=sysmanage&opt=getMembers&agentid={value}">
                           <option value="0">请选择</option>
                           <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_POST['agentid']==$_smarty_tpl->tpl_vars['v']->value['id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['agentname'];?>
</option>
                                <?php } ?>
                            </select>
                <input type="text" id="search_key22" size="10" class="" value="输入关键字"/>
                   
                </li>
                <li>  
                    <label>工会成员：</label>
                     <select class="combox" name="placeid" id="w_combox_hesid2143">
                            <option value ="0" selected>请选择</option>
                             <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildmembers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['site_id'];?>
" <?php if ($_POST['placeid']==$_smarty_tpl->tpl_vars['v']->value['site_id']){?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['sitename'];?>
</option>
                            <?php } ?>
                            </select>
                </li>
                
		</ul>
        <ul class="searchContent">
            <li>  
                    <label>注册起始日期：</label>
                    <input type="text" name="start_date" class="date" value="<?php echo $_POST['state_date'];?>
" readonly="true"/>
				<a class="inputDateButton" href="javascript:;">选择</a></li>
                <li>  
                    <label>注册结束日期：</label>
                    <input type="text" name="end_date" class="date" value="<?php echo $_POST['end_date'];?>
" readonly="true"/>
                </li>
            <li><label>玩家账号：</label>  <input type="text" name="name" value="<?php echo $_POST['name'];?>
">	</li>
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
    <table class="table" width="100%"  layoutH="137">
        <thead>
            <tr>
                <th>用户ID</th>
                <th>玩家账号</th>
                <th>所属公会</th>
                <th>公会成员ID</th>
                <th>注册时间</th>
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
                    <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['uid'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['user_name'];?>
</td>
                    <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['agentname'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['place_id'];?>
</td>
                    <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vo']->value['reg_time'],"%Y-%m-%d %H:%I:%S");?>
</td>
                    <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['agent_id']==100){?><a title="确定要将该用户还原到原来的渠道吗？" target="ajaxTodo" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=jie&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['uid'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="">还原来源</a><?php }else{ ?><a title="确定要将该用户绑定到平台吗？" target="ajaxTodo" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=qie&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['uid'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" class="">绑到平台</a><?php }?></td>
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
</div>
<script>
    var pro_str={ <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?> "<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
":"<?php echo $_smarty_tpl->tpl_vars['v']->value['agentname'];?>
", <?php } ?> };
    search_pro('search_key22','agentid22');
</script><?php }} ?>