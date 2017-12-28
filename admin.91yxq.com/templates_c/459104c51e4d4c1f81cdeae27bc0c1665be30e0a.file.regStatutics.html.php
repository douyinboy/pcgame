<?php /* Smarty version Smarty-3.1.7, created on 2017-01-02 22:04:58
         compiled from "./templates/register/regStatutics.html" */ ?>
<?php /*%%SmartyHeaderCode:410083336586a5e0a6398f4-49805570%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '459104c51e4d4c1f81cdeae27bc0c1665be30e0a' => 
    array (
      0 => './templates/register/regStatutics.html',
      1 => 1456972702,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '410083336586a5e0a6398f4-49805570',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'numperpage' => 0,
    'guildlist' => 0,
    'v' => 0,
    'gamelist' => 0,
    'serverlist' => 0,
    'guilds' => 0,
    'g' => 0,
    'data' => 0,
    'vo' => 0,
    'start_date' => 0,
    'end_date' => 0,
    'heji' => 0,
    'totalcount' => 0,
    'currentpage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_586a5e0a7a80e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_586a5e0a7a80e')) {function content_586a5e0a7a80e($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="game_id" value="<?php echo $_POST['game_id'];?>
"/>
    <input type="hidden" name="numPerPage" value="<?php echo $_smarty_tpl->tpl_vars['numperpage']->value;?>
"/>
    <input type="hidden" name="server_id" value="<?php echo $_POST['server_id'];?>
"/>
    <input type="hidden" name="orderField" value="<?php echo $_POST['orderField'];?>
" />
    <input type="hidden" name="orderDirection" value="<?php echo $_POST['orderDirection'];?>
" />
    <input type="hidden" name="agentid" value="<?php echo $_POST['agentid'];?>
"/>
    <input type="hidden" name="guild_name" value="<?php echo $_POST['guild_name'];?>
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
                <select class="combox" name="agent_id" id="agentid4">
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
                <input type="text" id="search_key4" size="10" class="" value="输入关键字"/>
            </li>
            <li><label>游戏：</label>
                     <select class="combox" name="game_id" id="game_id"  ref="server_id_222777wan_4432841" refUrl="?action=sysmanage&opt=getServers&game_id={value}">
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
                 </select>  <select class="combox" name="server_id" id="server_id_222777wan_4432841">
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
                <label>起始时间：</label>
                <input type="text" name="start_date" class="date" value="<?php echo $_POST['start_date'];?>
" readonly="true"/>
                            <a class="inputDateButton" href="javascript:;">选择</a>
            </li>
            <li>
                <label>结束时间：</label>
                <input type="text" name="end_date" class="date" value="<?php echo $_POST['end_date'];?>
" readonly="true"/>
                            <a class="inputDateButton" href="javascript:;">选择</a>
            </li>      
         
                <li><label>公会专员：</label>
                <select class="combox" name="guild_name" id="guild_name">
                <option value="">所有</option>
                 <?php  $_smarty_tpl->tpl_vars['g'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['g']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guilds']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['g']->key => $_smarty_tpl->tpl_vars['g']->value){
$_smarty_tpl->tpl_vars['g']->_loop = true;
?>
                    <?php if ($_smarty_tpl->tpl_vars['g']->value['uid']>0){?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['g']->value['uid'];?>
" <?php if ($_POST['guild_name']==$_smarty_tpl->tpl_vars['g']->value['uid']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['g']->value['addUser'];?>
</option>
                    <?php }?>
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
    <table class="table" width="100%"  layoutH="107">
        <thead>
            <tr>
                <th width="130">公会ID</th>
                <th width="130">公会名</th>
                <th width="200">游戏</th>
                <th>服区</th>
                <th>注册人数</th>
                <th orderField="total_ip" class="<?php if ($_POST['orderField']==''||$_POST['orderField']=='total_ip'){?><?php echo (($tmp = @$_POST['orderDirection'])===null||$tmp==='' ? 'desc' : $tmp);?>
<?php }?>">注册IP数</th>
                <th orderField="total_pay" class="<?php if ($_POST['orderField']=='total_pay'){?><?php echo $_POST['orderDirection'];?>
<?php }?>">充值金额</th>
                <th width="100">添加人</th>
                <th width="240">注册时间</th>
            </tr>
        </thead>
        <tbody>
            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
            <tr target="sid" rel="1">
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agent_id'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agent'];?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['game'])===null||$tmp==='' ? "--- ---" : $tmp);?>
</td>
                <td>S<?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['server_id'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                <td><a title="发放首充" href="?action=pay&opt=firstPay&api=add&agentid=<?php echo $_smarty_tpl->tpl_vars['vo']->value['agent_id'];?>
&game_id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['game_id'];?>
&server_id=<?php echo $_smarty_tpl->tpl_vars['vo']->value['server_id'];?>
&navTabId=<?php echo $_GET['navTabId'];?>
" height="500" target="dialog" mask="true"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['total_reg'])===null||$tmp==='' ? "0" : $tmp);?>
</a></td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['total_ip'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['total_pay'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['adduser'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
----<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
</td>
            </tr>
            <?php } ?>
            <tr target="sid" rel="1">
                <td>合计：</td>
                <td>--</td>
                <td>--</td>
                <td>--</td>
                <td><?php echo $_smarty_tpl->tpl_vars['heji']->value['total_ip'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['heji']->value['total_pay'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['heji']->value['adduser'];?>
</td>
                <td>--</td>
                <td><?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
----<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
</td>
            </tr>
        </tbody>
    </table>
    <div class="panelBar">
        <div class="pages"><span>显示</span>
            <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
                <option <?php if ($_POST['numPerPage']==20){?>selected<?php }?>  value="20">20</option>
                <option <?php if ($_POST['numPerPage']==50){?>selected<?php }?> value="50">50</option>
                <option <?php if ($_POST['numPerPage']==100){?>selected<?php }?> value="100">100</option>
                <option <?php if ($_POST['numPerPage']==200){?>selected<?php }?> value="200">200</option>
            </select>
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
    search_pro('search_key4','agentid4');
</script><?php }} ?>