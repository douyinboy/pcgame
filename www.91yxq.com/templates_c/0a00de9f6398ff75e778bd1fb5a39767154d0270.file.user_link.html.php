<?php /* Smarty version Smarty-3.0.6, created on 2016-01-23 20:41:16
         compiled from "/home/www/www.demo.com/template/user_link.html" */ ?>
<?php /*%%SmartyHeaderCode:29532661656a374ec196ea5-53763533%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a00de9f6398ff75e778bd1fb5a39767154d0270' => 
    array (
      0 => '/home/www/www.demo.com/template/user_link.html',
      1 => 1453517567,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '29532661656a374ec196ea5-53763533',
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
                <!--<li><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
help.php?act=question" <?php if ($_smarty_tpl->getVariable('act')->value=='question'||$_smarty_tpl->getVariable('act')->value=='question_result'){?>class="on"<?php }?>><i class="dot"></i>问题反馈及查询</a></li>-->
            </ul>
        </div>