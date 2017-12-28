<?php /* Smarty version Smarty-3.0.6, created on 2017-09-12 15:26:10
         compiled from "E:\phpStudy\WWW\91yxq\www.91yxq.com\template\user_link.html" */ ?>
<?php /*%%SmartyHeaderCode:2365359b78c122829d5-51324736%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ccfe89ececc9f7e274570e776305ae073ede22e9' => 
    array (
      0 => 'E:\\phpStudy\\WWW\\91yxq\\www.91yxq.com\\template\\user_link.html',
      1 => 1505201166,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2365359b78c122829d5-51324736',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="user_nav">
            <div class="imgpq title">用户中心</div>
            <ul>
                <li><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php" <?php if ($_smarty_tpl->getVariable('act')->value=='index'){?>class="on"<?php }?>><i class="dot"></i>个人中心</a></li>
                <li><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=info" <?php if ($_smarty_tpl->getVariable('act')->value=='info'){?>class="on"<?php }?>><i class="dot"></i>我的资料</a></li>
                <li><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=passwd" <?php if ($_smarty_tpl->getVariable('act')->value=='passwd'||$_smarty_tpl->getVariable('act')->value=='security_question'||$_smarty_tpl->getVariable('act')->value=='payment_cipher'){?>class="on"<?php }?>><i class="dot"></i>安全中心</a></li>
                <li><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=indulge" <?php if ($_smarty_tpl->getVariable('act')->value=='indulge'){?>class="on"<?php }?>><i class="dot"></i>防沉迷设置</a></li>
                <li><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
help.php?act=recharge" <?php if ($_smarty_tpl->getVariable('act')->value=='recharge'){?>class="on"<?php }?>><i class="dot"></i>充值列表</a></li>
                <li><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
help.php?act=question" <?php if ($_smarty_tpl->getVariable('act')->value=='question'||$_smarty_tpl->getVariable('act')->value=='question_result'){?>class="on"<?php }?>><i class="dot"></i>问题反馈及查询</a></li>
            </ul>
        </div>