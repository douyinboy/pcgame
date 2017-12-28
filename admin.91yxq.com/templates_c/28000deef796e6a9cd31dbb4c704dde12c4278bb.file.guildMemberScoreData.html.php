<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 14:53:58
         compiled from "./templates/platform/guildMemberScoreData.html" */ ?>
<?php /*%%SmartyHeaderCode:26637775458523e0624bde5-39304968%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28000deef796e6a9cd31dbb4c704dde12c4278bb' => 
    array (
      0 => './templates/platform/guildMemberScoreData.html',
      1 => 1456972708,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26637775458523e0624bde5-39304968',
  'function' => 
  array (
  ),
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
    'heji' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58523e06367d7',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58523e06367d7')) {function content_58523e06367d7($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
     <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="pageNum" value="<?php echo $_smarty_tpl->tpl_vars['currentpage']->value;?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="start_date" value="<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
"/>
    <input type="hidden" name="end_date" value="<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
"/>
    <input type="hidden" name="game_id" value="<?php echo $_POST['game_id'];?>
"/>
    <input type="hidden" name="server_id" value="<?php echo $_POST['server_id'];?>
"/>
    <input type="hidden" name="agent_id" value="<?php echo $_POST['agent_id'];?>
"/>
    <input type="hidden" name="placeid" value="<?php echo $_POST['placeid'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li><label>公会：</label>
                <select class="combox" name="agent_id" id="agentid25" ref="w_combox_hesid2201" refUrl="?action=sysmanage&opt=getMembers&agentid={value}">
                    <option value="0">请选择</option>
                    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                         <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_POST['agent_id']==$_smarty_tpl->tpl_vars['v']->value['id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['agentname'];?>
</option>
                         <?php } ?>
                     </select>
                <input type="text" id="search_key255" size="10" class="" value="输入关键字"/>
            </li>
            <li>  
                    <label>公会成员：</label>
                     <select class="combox" name="placeid" id="w_combox_hesid2201">
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
            <select class="combox" name="game_id" id="game_id" ref="server_777wan_212333249981" refUrl="?action=sysmanage&opt=getServers&game_id={value}">
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
                <select class="combox" name="server_id" id="server_777wan_212333249981">
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
                <label>查询起始日期：</label>
                <input type="text" name="start_date" class="date" value="<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
" readonly="true"/>
                            <a class="inputDateButton" href="javascript:;">选择</a></li>
            <li>
                <label>查询结束日期：</label>
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
    <table class="table" width="100%"  layoutH="137">
            <thead>
                <tr>
                    <th>公会ID</th>
                    <th>公会名称</th>
                    <th>成员ID</th>
                    <th>成员名</th>
                    <th>独立注册IP数</th>
                    <th>充值人数</th>
                    <th>充值金额</th>
                </tr>
            </thead>
            <tbody>
                    <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
                    <tr target="sid" rel="1">
                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agentid'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agentname'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['placeid'];?>
</td>
                        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['membername'])===null||$tmp==='' ? "-- --" : $tmp);?>
</td>
                        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['regips'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                        <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['payusers'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                        <td><a style="color: red;"  href="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&detail=1&agent_id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['agentid'];?>
&placeid=<?php echo $_smarty_tpl->tpl_vars['vo']->value['placeid'];?>
&start_date=<?php echo $_POST['start_date'];?>
&end_date=<?php echo $_POST['end_date'];?>
&game_id=<?php echo $_POST['game_id'];?>
&server_id=<?php echo $_POST['server_id'];?>
" width="800" height="520" title="<?php echo $_smarty_tpl->tpl_vars['vo']->value['agentname'];?>
的成员：<?php echo $_smarty_tpl->tpl_vars['vo']->value['membername'];?>
 查询区间的充值明细" target="dialog"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['paymoney'])===null||$tmp==='' ? "0" : $tmp);?>
</a></td>
                    </tr>
                    <?php } ?>
                   <tr target="sid" rel="1">
                        <td>合计：</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['heji']->value['regips'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['heji']->value['payusers'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['heji']->value['paymoney'];?>
</td>
                        </tr>
            </tbody>
    </table>
</div>
<script>
    var pro_str={ <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?> "<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
":"<?php echo $_smarty_tpl->tpl_vars['v']->value['agentname'];?>
", <?php } ?> };
    search_pro('search_key255','agentid25');
</script><?php }} ?>