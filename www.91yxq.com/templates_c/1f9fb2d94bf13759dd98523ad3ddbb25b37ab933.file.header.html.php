<?php /* Smarty version Smarty-3.0.6, created on 2017-09-12 14:06:01
         compiled from "E:\phpStudy\WWW\91yxq\www.91yxq.com\template\header.html" */ ?>
<?php /*%%SmartyHeaderCode:472259b7794967a113-47988205%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f9fb2d94bf13759dd98523ad3ddbb25b37ab933' => 
    array (
      0 => 'E:\\phpStudy\\WWW\\91yxq\\www.91yxq.com\\template\\header.html',
      1 => 1490950975,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '472259b7794967a113-47988205',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!---头部-->
<div class="head">
	<div id="platform_top_div" class="m1200">
        <a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
index.html" class="logo"></a>
        
        <!--导航-->
        <div class="nav">
            <a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
index.html">首页</a>
            <a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
games/index.html">游戏大厅</a>
            <a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php" <?php if ($_smarty_tpl->getVariable('entrance')->value=="user"){?>class="on"<?php }?>>用户中心</a>
            <a href="<?php echo $_smarty_tpl->getVariable('pay_url')->value;?>
">充值中心</a>
            <a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
news/index.html">新闻中心</a>
            <a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
help/index.html" <?php if ($_smarty_tpl->getVariable('entrance')->value=="help"){?>class="on"<?php }?>>客服中心</a>
        </div>
        
        <!--游戏列表;登录注册按钮或登录后用户名js-->
		<script src="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
/public/www_top.js"></script>
    </div>
</div>