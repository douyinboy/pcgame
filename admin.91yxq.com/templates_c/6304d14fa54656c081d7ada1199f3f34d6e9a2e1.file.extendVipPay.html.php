<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 14:54:01
         compiled from "./templates/recharge/extendVipPay.html" */ ?>
<?php /*%%SmartyHeaderCode:91844460756cff2f1c27d16-14936854%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6304d14fa54656c081d7ada1199f3f34d6e9a2e1' => 
    array (
      0 => './templates/recharge/extendVipPay.html',
      1 => 1456972704,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '91844460756cff2f1c27d16-14936854',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56cff2f1e3372',
  'variables' => 
  array (
    'currentpage' => 0,
    'numperpage' => 0,
    'start_date' => 0,
    'end_date' => 0,
    'guildlist' => 0,
    'v' => 0,
    'guildmembers' => 0,
    'gamelist' => 0,
    'serverlist' => 0,
    'data' => 0,
    'vo' => 0,
    'totalcount' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56cff2f1e3372')) {function content_56cff2f1e3372($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/91yxq/admin.91yxq.com/Smarty-3.1.7/plugins/modifier.date_format.php';
?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="agentid" value="<?php echo $_POST['agentid'];?>
"/>
    <input type="hidden" name="placeid" value="<?php echo $_POST['placeid'];?>
"/>
    <input type="hidden" name="start_date" value="<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
"/>
    <input type="hidden" name="end_date" value="<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li><label>公会：</label>
                       <select class="combox" name="agentid" id="agentid" ref="w_cohesid221sdddssfe" refUrl="?action=sysmanage&opt=getMembers&agentid={value}">
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
                    <select class="combox" name="placeid" id="w_cohesid221sdddssfe">
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
                
                <li><label>游戏服区：</label>
            <select class="combox" name="game_id" id="game_id" ref="sd_ssan_44328432244222" refUrl="?action=sysmanage&opt=getServers&game_id={value}">
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
                    
                <select class="combox" name="server_id" id="sd_ssan_44328432244222">
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
               
            </ul>
         <ul class="searchContent">
                <li>  
                    <label>起始日期：</label>
                    <input type="text" name="start_date" class="date" value="<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
" readonly="true"/>
				<a class="inputDateButton" href="javascript:;">选择</a></li>
                <li>  
                    <label>结束日期：</label>
                    <input type="text" name="end_date" class="date" value="<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
" readonly="true"/>
                    <a class="inputDateButton" href="javascript:;">选择</a>
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
            <li>
                <a class="add" title="发放VIP" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&navTabId=<?php echo $_GET['navTabId'];?>
" height="500" target="dialog" mask="true"><span>发放VIP</span></a></li>
        <li>
            <a class="icon" href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=export" target="dwzExport" targetType="navTab" title="实要导出这些记录吗?"><span>导出EXCEL</span></a></li>
       
        </ul>
    </div>
    <table class="table" width="100%"  layoutH="190">
                    <thead>
                        <tr>
                            <th>订单号</th>
                            <th>充值账号</th>
                            <th>充值游戏</th>
                            <th>服区</th>
                            <th>充值金额</th>
                            <th>充值元宝</th>
                            <th>充值公会</th>
                            <th>团长ID</th>
                            <th>添加人</th>
                            <th>充值时间</th>
                            <th>充值结果</th>
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
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['place_id'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['addUser'];?>
</td>
                                <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['vo']->value['pay_time'],"%Y-%m-%d %H:%I:%S");?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['vo']->value['state']==1){?>成功<?php }else{ ?>失败<?php }?></td>
                            </tr>
                            <?php } ?>
                        </volist>
                    </tbody>
    </table>
    <div class="panelBar" style="margin:28px 0 0 0;">
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
    search_pro('search_key30','agentid30');
</script><?php }} ?>