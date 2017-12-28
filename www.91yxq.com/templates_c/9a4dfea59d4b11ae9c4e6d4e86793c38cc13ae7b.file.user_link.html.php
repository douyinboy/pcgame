<?php /* Smarty version Smarty-3.0.6, created on 2017-03-22 23:21:00
         compiled from "/home/91yxq/www.demo.com/template/user_link.html" */ ?>
<?php /*%%SmartyHeaderCode:1038974341589d53d35de945-04540443%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a4dfea59d4b11ae9c4e6d4e86793c38cc13ae7b' => 
    array (
      0 => '/home/91yxq/www.demo.com/template/user_link.html',
      1 => 1490173018,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1038974341589d53d35de945-04540443',
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