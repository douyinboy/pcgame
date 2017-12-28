<?php /* Smarty version Smarty-3.1.7, created on 2017-02-08 14:48:16
         compiled from "./templates/recharge/addapplyInnerPay.html" */ ?>
<?php /*%%SmartyHeaderCode:1492281135589abf30c034c6-19935447%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '59c5a086ef8a227f0791fa0473af26eca09b2742' => 
    array (
      0 => './templates/recharge/addapplyInnerPay.html',
      1 => 1456972704,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1492281135589abf30c034c6-19935447',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gamelist' => 0,
    'v' => 0,
    'serverlist' => 0,
    'guildlist' => 0,
    'guildmembers' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_589abf30c99de',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_589abf30c99de')) {function content_589abf30c99de($_smarty_tpl) {?><div class="pageContent">
    <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <input name="sub" type="hidden" value="1" />
    <div class="pageFormContent" layoutH="68"> 
        <div class="unit">
                <label>内充账号：</label>
                <input name="account" id="account"  class="required"  type="text" size="30" value=""/>
        </div>
        <div class="unit">
                <label>内充金额：</label>
                <input name="pay_money" type="text" class="required digits" value=""/>
        </div>
        <div class="unit">
                <label>游戏：</label>
            <select class="combox" name="game_id" id="game_id" ref="gameasfassfssddd" refUrl="?action=sysmanage&opt=getServers&game_id={value}">
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
                <select class="combox" name="server_id" id="gameasfassfssddd" onchange="get_user_role()" >
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
        </div>
        <div class="unit" id="gamerole">
                <label>角色名：</label>
                <input name="user_role" id="user_role" type="text" class="required readonly" value=""  readonly=true />
        </div>
        <div class="unit">
                <label>公会团长：</label>
                    <select class="combox" name="agentid" id="agentid9" class="required" ref="w_cohesdsadadafafsid221" refUrl="?action=sysmanage&opt=getMembers&agentid={value}" onchange="get_role()">
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
                <input type="text" id="search_key9" size="10" class="" value="输入关键字"/>
                    <select class="combox" name="placeid" id="w_cohesdsadadafafsid221">
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
        </div>
        <div class="unit">
                <label>充值类型：</label>
                    <select name="pay_type" id="pay_type">
                        <option value="1">平台垫付</option>
                        <option value="2">公会赔付</option>
                    </select>
        </div>
        <div class="unit">
                <label>申请理由：</label>
                    <textarea rows="3" cols="80" name="reason" class="textInput"></textarea>
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
    search_pro('search_key9','agentid9');
    function get_role(){
        var role=$('#user_role').val();
        if(role=='未获取到' || role=='no'){
            alert('没有相应角色名！');
        }
    }
    
</script><?php }} ?>