<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 14:54:02
         compiled from "./templates/recharge/examineInnerGuild.html" */ ?>
<?php /*%%SmartyHeaderCode:149972142956cff2f3ee0396-28165536%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '296e75df1b10daeb747f4fe278590f9bffa69825' => 
    array (
      0 => './templates/recharge/examineInnerGuild.html',
      1 => 1456972706,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '149972142956cff2f3ee0396-28165536',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56cff2f41c889',
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'gamelist' => 0,
    'v' => 0,
    'serverlist' => 0,
    'guildlist' => 0,
    'data' => 0,
    'vo' => 0,
    'totalcount' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56cff2f41c889')) {function content_56cff2f41c889($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/91yxq/admin.91yxq.com/Smarty-3.1.7/plugins/modifier.date_format.php';
?><form id="pagerForm" action="" method="post">
     <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="agentid" value="<?php echo $_POST['agentid'];?>
"/>
    <input type="hidden" name="start_date" value="<?php echo $_POST['start_date'];?>
"/>
    <input type="hidden" name="end_date" value="<?php echo $_POST['end_date'];?>
"/>
    <input type="hidden" name="game_id" value="<?php echo $_POST['game_id'];?>
"/>
    <input type="hidden" name="server_id" value="<?php echo $_POST['server_id'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li><label>游戏服区：</label>
                <select class="combox" name="game_id" id="game" ref="sd_ssan_4ddd432841" refUrl="?action=sysmanage&opt=getServers&game_id={value}">
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
                <select class="combox" name="server_id" id="sd_ssan_4ddd432841">
                    <option value="0">请选择</option>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['serverlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['server_id'];?>
" <?php if ($_POST['server_id']==$_smarty_tpl->tpl_vars['v']->value['server_id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                    <?php } ?>
                </select>
            </li>
            <li><label>公会：</label>
                <select class="combox" name="agentid" id="agentid94941">
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
                <input type="text" id="search_key9930" size="10" class="" value="输入关键字"/>
            </li>
        </ul>
        <ul class="searchContent">
            <li>  
                    <label>起始日期：</label>
                    <input type="text" name="start_date" class="date" value="<?php echo $_POST['start_date'];?>
" readonly="true"/>
				<a class="inputDateButton" href="javascript:;">选择</a></li>
                <li>  
                    <label>结束日期：</label>
                    <input type="text" name="end_date" class="date" value="<?php echo $_POST['end_date'];?>
" readonly="true"/>
				<a class="inputDateButton" href="javascript:;">选择</a></li>
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
    <table class="table" width="100%"  layoutH="132">
                    <thead>
                        <tr>
                            <th>订单号</th>
                            <th>充值账号</th>
                            <th>角色名</th>
                            <th>充值游戏</th>
                            <th>服区</th>
                            <th>充值金额</th>
                            <th>充值元宝</th>
                            <th>充值公会</th>
                            <th>充值时间</th>
                            <th>充值类型</th>
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
                            <tr target="sid" rel="1" style="background-color: <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['test']['iteration']%2==0){?> #f6fcfc;<?php }?>">
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['orderid'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['user_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['user_role'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['gamename'];?>
</td>
                                <td>S<?php echo $_smarty_tpl->tpl_vars['vo']->value['server_id'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['money'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['gold'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agentname'];?>
</td> 
                                <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vo']->value['pay_time'],"%Y-%m-%d %H:%I:%S");?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['pay_type']==2){?>公会赔付<?php }elseif($_smarty_tpl->tpl_vars['vo']->value['pay_type']==3){?>申请人买单<?php }else{ ?>平台垫付<?php }?></td>
                                 <td><a class="btnEdit" title="编辑审核" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" height="400" target="dialog" mask="true">审核该订单</a> --------- <a title="拒绝该申请" target="ajaxTodo" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=refuse&id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
">拒绝该申请</a></td>
                            
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
    search_pro('search_key9930','agentid94941');
</script><?php }} ?>