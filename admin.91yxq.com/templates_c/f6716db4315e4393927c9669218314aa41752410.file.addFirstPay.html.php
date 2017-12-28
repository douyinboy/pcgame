<?php /* Smarty version Smarty-3.1.7, created on 2017-02-08 14:45:23
         compiled from "./templates/recharge/addFirstPay.html" */ ?>
<?php /*%%SmartyHeaderCode:1528996575589abe83c34cd2-05846929%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f6716db4315e4393927c9669218314aa41752410' => 
    array (
      0 => './templates/recharge/addFirstPay.html',
      1 => 1456972706,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1528996575589abe83c34cd2-05846929',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'str' => 0,
    'gamelist' => 0,
    'v' => 0,
    'serverlist' => 0,
    'guildlist' => 0,
    'guildmembers' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_589abe83cc36c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_589abe83cc36c')) {function content_589abe83cc36c($_smarty_tpl) {?><div class="pageContent">
    <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <input name="sub" type="hidden" value="1" />
    <div class="pageFormContent" layoutH="68"> 
        <div class="unit">
                <label>账号列表：</label>
                <textarea rows="20" cols="25" name="account_list" class="textInput required readonly"><?php echo $_smarty_tpl->tpl_vars['str']->value;?>
</textarea>
        </div>
        <div class="unit">
                <label>游戏：</label>
            <select class="combox" name="game_id" id="game_id" ref="gameasfassfsddd" refUrl="?action=sysmanage&opt=getServers&game_id={value}">
                <option value="0">请选择</option>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['gamelist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                     <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_GET['game_id']==$_smarty_tpl->tpl_vars['v']->value['id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                     <?php } ?>
                 </select> 
                <select class="combox" name="server_id" id="gameasfassfsddd">
                <option value="0">请选择</option>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['serverlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                     <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['server_id'];?>
" <?php if ($_GET['server_id']==$_smarty_tpl->tpl_vars['v']->value['server_id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</option>
                     <?php } ?>
                 </select>  
        </div>
        <div class="unit">
                <label>公会团长：</label>
                    <select class="combox" name="agentid" id="agentid10" ref="w_cohesdsadadafafsid221" refUrl="?action=sysmanage&opt=getMembers&agentid={value}">
                        <option value="0">请选择</option>
                        <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                             <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" <?php if ($_GET['agentid']==$_smarty_tpl->tpl_vars['v']->value['id']){?> selected <?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value['agentname'];?>
</option>
                             <?php } ?>
                         </select>
                <input type="text" id="search_key10" size="10" class="" value="输入关键字"/>
                    <select class="combox" name="placeid" id="w_cohesdsadadafafsid221">
                            <option value ="0" selected>请选择</option>
                            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildmembers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['site_id'];?>
" ><?php echo $_smarty_tpl->tpl_vars['v']->value['sitename'];?>
</option>
                            <?php } ?>
                            </select>
        </div>
    </div>
    <div class="formBar">
        <ul>
            <li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
            <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
        </ul>
    </div>
    </form>
</div>
<script>
    var pro_str={ <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['guildlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?> "<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
":"<?php echo $_smarty_tpl->tpl_vars['v']->value['agentname'];?>
", <?php } ?> };
    search_pro('search_key10','agentid10');
</script><?php }} ?>