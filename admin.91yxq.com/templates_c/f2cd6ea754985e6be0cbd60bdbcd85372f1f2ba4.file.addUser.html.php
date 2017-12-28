<?php /* Smarty version Smarty-3.1.7, created on 2016-12-15 14:54:35
         compiled from "./templates/system/addUser.html" */ ?>
<?php /*%%SmartyHeaderCode:17309943958523e2bd521d9-04696972%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f2cd6ea754985e6be0cbd60bdbcd85372f1f2ba4' => 
    array (
      0 => './templates/system/addUser.html',
      1 => 1456972710,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17309943958523e2bd521d9-04696972',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'uInfo' => 0,
    'grouplist' => 0,
    'vo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58523e2bda72c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58523e2bda72c')) {function content_58523e2bda72c($_smarty_tpl) {?><div class="pageContent">
    <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
        <input name="sub" type="hidden" value="1" />
        <input name="id" type="hidden" value="<?php echo $_GET['id'];?>
" />
        <div class="pageFormContent" layoutH="68">
        <div class="unit">
                <label>用户账号：</label>
                <input type="text" class="required textInput error" value="<?php echo $_smarty_tpl->tpl_vars['uInfo']->value['uAccount'];?>
" name="uAccount">
                <span class="info"></span>
        </div>
            
        <div class="unit">
                <label>密码：</label>
                <input type="password" value="" id="w_validation_pwd" name="uPass" class="alphanumeric" minlength="6" maxlength="20" alt="字母、数字、下划线 6-20位"/>
					<span class="info">字母、数字、下划线6-20位，编辑用户填写则为修改密码</span>
        </div>
        <div class="unit">
                <label>确认密码：</label>
                <input type="password" name="uPassAgain" class="" alt="输入密码不一致" equalto="#w_validation_pwd"/>
<span class="info"></span>
        </div>
        <div class="unit">
                <label>用户姓名：</label>
                <input type="text" class="required textInput error" value="<?php echo $_smarty_tpl->tpl_vars['uInfo']->value['uName'];?>
" name="uName">
                <span class="info"></span>
        </div>
        <div class="unit">
                <label>用户电话：</label>
                <input type="text" class="textInput" value="<?php echo $_smarty_tpl->tpl_vars['uInfo']->value['uPhone'];?>
" name="uPhone">
        </div>
        <div class="unit">
                <label>用户邮箱：</label>
                <input type="text" class="textInput" value="<?php echo $_smarty_tpl->tpl_vars['uInfo']->value['umail'];?>
" name="uMail">
        </div>
        <div class="unit">
            <label>用户权限组：</label>
                    <select  class="combox" name="uGroupId">
                        <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['grouplist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value){
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['gId'];?>
" <?php if ($_smarty_tpl->tpl_vars['uInfo']->value['uGroupId']==$_smarty_tpl->tpl_vars['vo']->value['gId']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['vo']->value['gName'];?>
</option>
                        <?php } ?>
                    </select>                       
        </div>
        <div class="unit">
            <label>账号状态：</label>
                    <select  class="combox" name="uLoginState">
                        <option value="0" >禁止使用</option>
                        <option value="1" <?php if ($_smarty_tpl->tpl_vars['uInfo']->value['uLoginState']==1){?>selected<?php }?>>正常启用</option>
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
</div><?php }} ?>