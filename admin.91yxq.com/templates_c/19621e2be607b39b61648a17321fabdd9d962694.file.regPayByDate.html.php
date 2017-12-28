<?php /* Smarty version Smarty-3.1.7, created on 2017-01-02 22:05:09
         compiled from "./templates/register/regPayByDate.html" */ ?>
<?php /*%%SmartyHeaderCode:1205747019586a5e155396b1-48353890%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '19621e2be607b39b61648a17321fabdd9d962694' => 
    array (
      0 => './templates/register/regPayByDate.html',
      1 => 1456972702,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1205747019586a5e155396b1-48353890',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'start_date' => 0,
    'end_date' => 0,
    'start_date_2' => 0,
    'end_date_2' => 0,
    'guildlist' => 0,
    'v' => 0,
    'gamelist' => 0,
    'serverlist' => 0,
    'data' => 0,
    'vo' => 0,
    'heji2' => 0,
    'heji' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_586a5e156402e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_586a5e156402e')) {function content_586a5e156402e($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
    <input type="hidden" name="access" value="1"/>
    <input type="hidden" name="orderField" value="<?php echo $_POST['orderField'];?>
"/>
    <input type="hidden" name="orderDirection" value="<?php echo $_POST['orderDirection'];?>
"/>
    <input type="hidden" name="agentid" value="<?php echo $_POST['agentid'];?>
"/>
    <input type="hidden" name="game_id" value="<?php echo $_POST['game_id'];?>
"/>
    <input type="hidden" name="server_id" value="<?php echo $_POST['server_id'];?>
"/>
    <input type="hidden" name="start_date" value="<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
"/>
    <input type="hidden" name="end_date" value="<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
"/>
    <input type="hidden" name="start_date_2" value="<?php echo $_smarty_tpl->tpl_vars['start_date_2']->value;?>
"/>
    <input type="hidden" name="end_date_2" value="<?php echo $_smarty_tpl->tpl_vars['end_date_2']->value;?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li><label>公会：</label>
                <select class="combox" name="agentid" id="agentid4444">
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
                <input type="text" id="search_key4444" size="10" class="" value="输入关键字"/>
            </li>
            <li>  
                <label>注册起始：</label>
                <input type="text" name="start_date" class="date" value="<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
" readonly="true"/>
                            <a class="inputDateButton" href="javascript:;">选择</a>
            </li>
            <li>
                <label>注册结束：</label>
                <input type="text" name="end_date" class="date" value="<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
" readonly="true"/>
                            <a class="inputDateButton" href="javascript:;">选择</a>
            </li>
        </ul>
        <ul class="searchContent">
            <li><label>注册游戏：</label>
                     <select class="combox" name="game_id" id="game_id"  ref="server_id_222777wan_443284" refUrl="?action=sysmanage&opt=getServers&game_id={value}">
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
                 </select>  <select class="combox" name="server_id" id="server_id_222777wan_443284">
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
            <li>  
                <label>充值起始：</label>
                <input type="text" name="start_date_2" class="date" value="<?php echo $_smarty_tpl->tpl_vars['start_date_2']->value;?>
" readonly="true"/>
                            <a class="inputDateButton" href="javascript:;">选择</a>
            </li>
            <li>
                <label>充值结束：</label>
                <input type="text" name="end_date_2" class="date" value="<?php echo $_smarty_tpl->tpl_vars['end_date_2']->value;?>
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
    <table class="table" width="100%"  layoutH="107">
        <thead>
            <tr>
                <th width="130">公会ID</th>
                <th width="130">公会名</th>
                <th width="200">游戏</th>
                <th>服区</th>
                <th orderField="total_ip" class="<?php if ($_POST['orderField']==''||$_POST['orderField']=='total_ip'){?><?php echo (($tmp = @$_POST['orderDirection'])===null||$tmp==='' ? 'desc' : $tmp);?>
<?php }?>">注册人数</th>
                <th orderField="total_pay" class="<?php if ($_POST['orderField']=='total_pay'){?><?php echo $_POST['orderDirection'];?>
<?php }?>">充值金额</th>
                
            </tr>
        </thead>
        <tbody>
            <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
            <tr target="sid" rel="1">
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['agent_id'])===null||$tmp==='' ? "--" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['agent'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['game'])===null||$tmp==='' ? "--- ---" : $tmp);?>
</td>
                <td>S<?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['server_id'])===null||$tmp==='' ? "---" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['total_ip'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['total_pay'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
               
            </tr>
            <?php } ?>
            <tr target="sid" rel="1">
                <td>合计：</td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo $_smarty_tpl->tpl_vars['heji2']->value;?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['heji']->value;?>
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
    search_pro('search_key4444','agentid4444');
</script><?php }} ?>