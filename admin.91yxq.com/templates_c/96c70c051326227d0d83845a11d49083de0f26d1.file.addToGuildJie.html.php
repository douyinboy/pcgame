<?php /* Smarty version Smarty-3.1.7, created on 2017-02-07 17:46:42
         compiled from "./templates/recharge/addToGuildJie.html" */ ?>
<?php /*%%SmartyHeaderCode:19168047295899978259a741-31700168%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '96c70c051326227d0d83845a11d49083de0f26d1' => 
    array (
      0 => './templates/recharge/addToGuildJie.html',
      1 => 1456972706,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19168047295899978259a741-31700168',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'guildlist' => 0,
    'v' => 0,
    'data' => 0,
    'vo' => 0,
    'hj' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_589997826bd21',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_589997826bd21')) {function content_589997826bd21($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config("smarty.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars("setup", 'local'); ?>
<div class="pageContent">
    <div class="pageHeader">
        <form onsubmit="return dialogSearch(this);" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&navTabId=<?php echo $_GET['navTabId'];?>
" method="post">
    <input type="hidden" name="access" value="1"/>    
    <div class="searchBar">
        <ul class="searchContent">
            <li><label>选择公会：</label>
                <select class="combox" name="agentid" id="agentid7">
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
                <input type="text" id="search_key7" size="10" class="" value="输入关键字"/>
             </li>
             
            <li>  
                <label>起始日期：</label>
                <input type="text" name="start_date" class="date" value="<?php echo $_POST['start_date'];?>
" readonly="true"/>
            </li>
            <li>  
                <label>结束日期：</label>
                <input type="text" name="end_date" class="date" value="<?php echo $_POST['end_date'];?>
" readonly="true"/>
            </li>
        </ul>
        <div class="subBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">开始结算</button></div></div></li>
            </ul>
        </div>
    </div>
    </form>
</div>
    <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
        <input name="sub" type="hidden" value="1" />
        <input name="agentid" type="hidden" value="<?php echo $_POST['agentid'];?>
" />
        <input name="start_date" type="hidden" value="<?php echo $_POST['start_date'];?>
" />
        <input name="end_date" type="hidden" value="<?php echo $_POST['end_date'];?>
" />
        <table class="table" width="100%"  layoutH="137">
            <thead>
                <tr>
                    <th width="100">游戏名称</th>
                    <th width="100">收入（元）</th>
                    <th width="100">内充(元)</th>
                    <th width="100">结算金额</th>
                </tr>
            </thead>
            <tbody>
                    <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
                    <tr target="sid" rel="1">
                    <?php if ($_smarty_tpl->tpl_vars['vo']->value['totalMoney']!=0||$_smarty_tpl->tpl_vars['vo']->value['innerpay']!=0){?>
                        <td><?php echo $_smarty_tpl->tpl_vars['vo']->value['gamename'];?>
</td>
                        <td><input name="paymoney[<?php echo $_smarty_tpl->tpl_vars['vo']->value['game_id'];?>
]" class="required readonly" size="14" type="text" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['totalMoney'])===null||$tmp==='' ? "0" : $tmp);?>
" readonly="true" /> * <?php echo $_smarty_tpl->tpl_vars['vo']->value['fanliv'];?>
% =<?php echo $_smarty_tpl->tpl_vars['vo']->value['fanli'];?>
</td>
                        <td><input name="payinner[<?php echo $_smarty_tpl->tpl_vars['vo']->value['game_id'];?>
]" class="required readonly" size="14" type="text" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['innerpay'])===null||$tmp==='' ? "0" : $tmp);?>
" readonly="true"/>* 35% =<?php echo $_smarty_tpl->tpl_vars['vo']->value['innerpayfl'];?>
</td>
                        <td><input name="payjie[<?php echo $_smarty_tpl->tpl_vars['vo']->value['game_id'];?>
]" class="required" size="14" type="text" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['vo']->value['jie'])===null||$tmp==='' ? "0" : $tmp);?>
" /></td>
                    <?php }?>
                    </tr>
                    <?php } ?>
                    <tr target="sid" rel="1">
                        <td>合计：</td>
                        <td>(流水)<?php echo $_smarty_tpl->tpl_vars['hj']->value['totalMoneyAll'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['hj']->value['innerpay'];?>
</td>
                        <td><?php echo floor($_smarty_tpl->tpl_vars['hj']->value['jie']);?>
</td>
                    </tr>
            </tbody>
        </table>
    <div class="formBar">
        <ul>
            <li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
            <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
        </ul>
    </div>
    </form>
</div>
<script >
var pro_str={ <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?> "<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
":"<?php echo $_smarty_tpl->tpl_vars['v']->value['agentname'];?>
", <?php } ?> };
search_pro('search_key7','agentid7');
</script><?php }} ?>