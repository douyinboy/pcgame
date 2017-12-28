<?php /* Smarty version Smarty-3.1.7, created on 2017-01-02 22:04:41
         compiled from "./templates/register/guildRegPay.html" */ ?>
<?php /*%%SmartyHeaderCode:305109129586a5df95021f2-65165492%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '311922521f64aa6bfec41be665f73e6bc2fa4cfb' => 
    array (
      0 => './templates/register/guildRegPay.html',
      1 => 1456972702,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '305109129586a5df95021f2-65165492',
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
    'data' => 0,
    'vo' => 0,
    'hj' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_586a5df960fcd',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_586a5df960fcd')) {function content_586a5df960fcd($_smarty_tpl) {?><form id="pagerForm" action="" method="post">
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
    <input type="hidden" name="game_id" value="<?php echo $_POST['game_id'];?>
"/>
    <input type="hidden" name="user_role" value="<?php echo $_POST['user_role'];?>
"/>
    <input type="hidden" name="server_id" value="<?php echo $_POST['server_id'];?>
"/>
</form>
<div class="pageHeader">
    <form onsubmit="return navTabSearch(this);" action="" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li><label>公会：</label>
                <select class="combox" name="agentid" id="agentid2" ref="w_combox_hesid221" refUrl="?action=sysmanage&opt=getMembers&agentid={value}">
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
                <input type="text" id="search_key2" size="10" class="" value="输入关键字"/>
                </li> 
                <li>  
                    <label>起始日期：</label>
                    <input type="text" name="start_date" class="date" value="<?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
" readonly="true"/>
				<a class="inputDateButton" href="javascript:;">选择</a></li>
                <li>  
                    <label>结束日期：</label>
                    <input type="text" name="end_date" class="date" value="<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
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
    <table class="table" width="100%"  layoutH="107">
        <thead>
            <tr>
                <th width="80">公会ID</th>
                <th width="120">公会名</th>
                <th width="100">充值金额</th>
                <th width="100">首充金额</th>
                <th width="100">平台垫付金额</th>
                <th width="100">公会赔付金额</th>
                <th width="100">注册人数</th>
                <th width="100">注册IP数</th>
                <th width="200">统计周期</th>
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
            <tr target="sid" rel="1" style="background-color: <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['test']['iteration']%2==0){?> #f6fcfc;<?php }?>">
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['agentname'];?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['pay_total'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['pay_first'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['pay_pt'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['pay_gh'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['reg_count'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['reg_ips'])===null||$tmp==='' ? "0" : $tmp);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['start_date']->value;?>
----<?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="panelBar">
        <div class="pages">
            <table>
                <tr>
                    <td width="200">累计充值：<?php echo $_smarty_tpl->tpl_vars['hj']->value['pay'];?>
元</td>
                    <td width="200">首充共：<?php echo $_smarty_tpl->tpl_vars['hj']->value['first'];?>
元</td>
                    <td width="200">平台垫付共：<?php echo $_smarty_tpl->tpl_vars['hj']->value['innerpay1'];?>
元</td>
                    <td width="200">公会赔付共：<?php echo $_smarty_tpl->tpl_vars['hj']->value['innerpay2'];?>
元</td>
                </tr>
            </table>     
        </div>
        
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
    search_pro('search_key2','agentid2');
</script><?php }} ?>