<?php /* Smarty version Smarty-3.1.7, created on 2016-03-01 14:50:56
         compiled from "./templates/recharge/addinnerpay.html" */ ?>
<?php /*%%SmartyHeaderCode:58732125656d53bd0e45255-18733998%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db95c268946647381450140028717a651825feea' => 
    array (
      0 => './templates/recharge/addinnerpay.html',
      1 => 1390519870,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '58732125656d53bd0e45255-18733998',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gamelist' => 0,
    'v' => 0,
    'serverlist' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_56d53bd0ed552',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56d53bd0ed552')) {function content_56d53bd0ed552($_smarty_tpl) {?><div class="pageContent">
    <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <input name="sub" type="hidden" value="1" />
    <div class="pageFormContent" layoutH="58"> 
        <div class="unit">
            <label style="width:70px;">账号：</label>
                    <input name="user_name" id="account" type="text"  class="required" value=""/>
                     <span class="info">  请填写玩家账号</span>
        </div>
        <div class="unit">
                <label style="width:70px;">内充金额：</label>
                <input name="pay_money"  type="text" class="required digits" value=""/>
        </div>
        <div class="unit">
                <label style="width:70px;">游戏：</label>
            <select class="combox" name="game_id" id="game_id" ref="gameid123" refUrl="?action=sysmanage&opt=getServers&game_id={value}">
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
                <select class="combox" name="server_id" id="gameid123"  onchange="get_user_role()">
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
         <div class="unit" id="gamerole">
                <label style="width:70px;">角色名：</label>
                <input name="user_role" id="user_role" type="text" class="required readonly" value="12" readonly=true />
        </div>
          <div class="unit">
                <label style="width:70px;"> 充值类型：</label>
                    <select name="pay_type" onchange="get_role()">
                        <option value="0">请选择</option>
                        <option value="2">公会赔付</option>
                    </select>
        </div>
        <div class="unit">
                <label style="width:70px;">申请理由：</label>
                    <textarea rows="3" cols="60" name="reason" class="textInput" ></textarea>
        </div>                                      
    </div>
    <div class="formBar">
        <ul>
            <li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
            <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
        </ul>
    </div>
    </form>
</div><?php }} ?>