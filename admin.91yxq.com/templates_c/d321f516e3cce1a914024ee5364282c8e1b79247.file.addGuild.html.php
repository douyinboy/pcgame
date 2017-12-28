<?php /* Smarty version Smarty-3.1.7, created on 2017-02-16 11:38:00
         compiled from ".\templates\system\addGuild.html" */ ?>
<?php /*%%SmartyHeaderCode:2430658a51e9851c320-62909597%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd321f516e3cce1a914024ee5364282c8e1b79247' => 
    array (
      0 => '.\\templates\\system\\addGuild.html',
      1 => 1487134654,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2430658a51e9851c320-62909597',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'gInfo' => 0,
    'provices' => 0,
    'k' => 0,
    'v' => 0,
    'cities' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_58a51e98579f3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58a51e98579f3')) {function content_58a51e98579f3($_smarty_tpl) {?><div class="pageContent">
    <form method="post" action="?action=<?php echo $_GET['action'];?>
&opt=<?php echo $_GET['opt'];?>
&api=add&callbackType=closeCurrent&navTabId=<?php echo $_GET['navTabId'];?>
" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
        <input name="sub" type="hidden" value="1" />
        <input name="id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['gInfo']->value['id'];?>
" />
        <div class="pageFormContent" layoutH="68">
        <div class="unit">
                <label>公会名称：</label>
                <input type="text" class="required"  value="<?php echo $_smarty_tpl->tpl_vars['gInfo']->value['agentname'];?>
" name="agentname">
                <span class="info"></span>
        </div>
        <div class="unit">
                <label>管理账号：</label>
                <input type="text" class="required"   value="<?php echo $_smarty_tpl->tpl_vars['gInfo']->value['user_name'];?>
" name="user_name">
                <span class="info"></span>
        </div>
        <div class="unit">
                <label>管理密码：</label>
                <input type="text" class="required"  value="<?php echo $_smarty_tpl->tpl_vars['gInfo']->value['user_pwd'];?>
" name="user_pwd">
                <span class="info"></span>
        </div>
        <div class="unit">
                <label>联系QQ：</label>
                <input type="text" class=""  value="<?php echo $_smarty_tpl->tpl_vars['gInfo']->value['qq'];?>
" name="qq">
                <span class="info"></span>
        </div> 
        <div class="unit">
                <label>公会YY号：</label>
                <input type="text" class=""  value="<?php echo $_smarty_tpl->tpl_vars['gInfo']->value['yy'];?>
" name="yy">
                <span class="info"></span>
        </div>
        <div class="unit">
                <label>联系电话：</label>
                <input type="text" class=""  value="<?php echo $_smarty_tpl->tpl_vars['gInfo']->value['mobel'];?>
" name="mobel">
                <span class="info"></span>
        </div>
        <div class="unit">
                <label>银行账号：</label>
                <input type="text" class=""   value="<?php echo $_smarty_tpl->tpl_vars['gInfo']->value['account'];?>
"  name="account">
                <span class="info"></span>
        </div>
        <div class="unit">
                <label>开户行：</label>
                <textarea rows="1" cols="50" name="bank"   class="textInput readonly"  placeholder="请使用银行标准名称（全称）如：中国农业银行"><?php echo $_smarty_tpl->tpl_vars['gInfo']->value['bank'];?>
</textarea>
                <span class="info"></span>
        </div> 
        <div class="unit">
                <label>支行：</label>
                <textarea rows="1" cols="50" name="bank_son"   class="textInput readonly"  placeholder="银行标准名称+支行名称 如：中国农业银行唐山市丰润支行"><?php echo $_smarty_tpl->tpl_vars['gInfo']->value['bank_son'];?>
</textarea>
                <span class="info"></span>
        </div>
        <div class="unit" >
            <label>选择城市：</label>
            <select  class="combox" name="provice"  ref="city12" refUrl="?action=sysmanage&opt=get_citiess&provice_id={value}">
                <option value ="0">请选择</option>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['provices']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['gInfo']->value['province']==$_smarty_tpl->tpl_vars['v']->value){?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                <?php } ?>
            </select>
            <select  class="combox" name="city" id="city12">
                <option value ="0">请选择</option>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cities']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['gInfo']->value['city']==$_smarty_tpl->tpl_vars['v']->value){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                <?php } ?>
            </select>
        </div>
        <div class="unit">
                <label>开户人：</label>
                <input type="text" class=""  value="<?php echo $_smarty_tpl->tpl_vars['gInfo']->value['account_name'];?>
"  name="account_name">
                <span class="info"></span>
        </div> 
        <div class="unit">
            <label>状态：</label>
            <select  class="combox" name="state">
                <option value="0" >暂不启用</option>
                <option value="1" <?php if ($_smarty_tpl->tpl_vars['gInfo']->value['state']==1){?>selected<?php }?>>正常启用</option>
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
$("#btnEdit1").click(function(){   //修改
    $("#h_city").hide();
    $("#e_city").show();
    $("#type_city").val(1);
 }); 
 $("#btnEdit2").click(function(){ //取消
    $("#h_city").show();
    $("#e_city").hide();
 }); 
</script><?php }} ?>