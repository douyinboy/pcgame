<?php /* Smarty version Smarty-3.0.6, created on 2016-01-23 20:41:15
         compiled from "/home/www/www.demo.com/template/user_index.html" */ ?>
<?php /*%%SmartyHeaderCode:78609306956a374ebd0b3a6-88962360%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '265fb5751b5e4203f78a9b13ee65ef4109fe823c' => 
    array (
      0 => '/home/www/www.demo.com/template/user_index.html',
      1 => 1453517567,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '78609306956a374ebd0b3a6-88962360',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getVariable('chinese_title')->value;?>
-用户中心</title>
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/base.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/public.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/main_pq.css" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
js/jquery-1.10.2.min.js"></script>
</head>

<body>

<!--导入公共头部文件-->
<?php $_template = new Smarty_Internal_Template('header.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

<!--主内容-->
<div class="m1200">
	<div class="m_box2 mt40 clearfix">
        <!--左侧导航-->
        <?php $_template = new Smarty_Internal_Template('user_link.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

        <!--右侧-->
        <div class="fr w980">
        	<div class="p50">
            	<div class="user_info">
                    <div class="user_avatar">
                    	<div class="pic"><img src="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
images/www/user_avatar.jpg" /></div>
                    </div>
                    <div style="padding-left:130px">
                        <div class="name">尊敬的<?php echo $_smarty_tpl->getVariable('username')->value;?>
，您好~</div>
                        <div class="text">当前游戏币：<span class="red"><?php echo $_smarty_tpl->getVariable('users')->value[30];?>
</span></div>
                        <div><a href="<?php echo $_smarty_tpl->getVariable('pay_url')->value;?>
" class="btn1 btn_on1" target="_blank">游戏充值</a>&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=info" class="btn2 btn_on2">完善资料</a>&nbsp;&nbsp;&nbsp;&nbsp;资料完整度：<span class="progre_slider"><span class="goso" style="width:<?php echo $_smarty_tpl->getVariable('users')->value[28];?>
0%"></span></span>&nbsp;&nbsp;<span class="red"><?php echo $_smarty_tpl->getVariable('users')->value[28];?>
0%</span></div>
                        <div class="time mt10">上次登录：<?php echo $_smarty_tpl->getVariable('users')->value[16];?>
</div>
                    </div>
                </div>
            
                <div class="safe_list">
                    <ul>
                        <li class="clearfix">
                            <div class="fl pic_icon"><i class="imgpq icon_yes"></i></div>
                            <div class="fl name">用户密码</div>
                            <div class="fl text">安全性高的密码可以使账户更安全，建议您定期更换密码。</div>
                            <div class="fr safe_btn"><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=passwd" class="green">修改</a></div>
                        </li>
                        <li class="clearfix">
                            <div class="fl pic_icon"><i class="imgpq icon_<?php if ($_smarty_tpl->getVariable('users')->value[23]==0){?>sigh<?php }else{ ?>yes<?php }?>"></i></div>
                            <div class="fl name">帐号保护<span class="<?php if ($_smarty_tpl->getVariable('users')->value[23]==0){?>red">（未<?php }else{ ?>green">（已<?php }?>设置）</span></div>
                            <div class="fl text">在您遗忘账户密码时，可以通过回答安全保护问题找回。</div>
                            <div class="fr safe_btn"><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=security_question" class="<?php if ($_smarty_tpl->getVariable('users')->value[23]==0){?>btn1">立即设置<?php }else{ ?>green">重置<?php }?></a></div>
                        </li>
                        <!--<li class="clearfix">
                            <div class="fl pic_icon"><i class="imgpq icon_<?php if ($_smarty_tpl->getVariable('users')->value[31]==0){?>sigh<?php }else{ ?>yes<?php }?>"></i></div>
                            <div class="fl name">平台币<span class="<?php if ($_smarty_tpl->getVariable('users')->value[31]==0){?>red">（未<?php }else{ ?>green">（已<?php }?>设置）</span></div>
                            <div class="fl text"><span class="red"><?php echo $_smarty_tpl->getVariable('users')->value[30];?>
</span>&nbsp;&nbsp;平台币</div>
                            <div class="fr safe_btn"><?php if ($_smarty_tpl->getVariable('users')->value[31]==0){?><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=payment_cipher" class="btn1">立即设置</a><?php }?></div>
                        </li>
                        <li class="clearfix">
                            <div class="fl pic_icon"><i <?php if ($_smarty_tpl->getVariable('users')->value[29]==''){?>class="imgpq icon_sigh"<?php }else{ ?>class="imgpq icon_yes"<?php }?>></i></div>
                            <div class="fl name">支付密码<span <?php if ($_smarty_tpl->getVariable('users')->value[29]==''){?>class="red">（未<?php }else{ ?>class="green">（已<?php }?>设置）</span></div>
                            <div class="fl text">您可以设置、修改、找回支付密码，提高支付灵活性。</div>
                            <div class="fr safe_btn"><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=payment_cipher" <?php if ($_smarty_tpl->getVariable('users')->value[29]==''){?>class="btn1">立即设置<?php }else{ ?>class="green">修改<?php }?></a></div>
                        </li>-->
                        <li class="clearfix">
                            <div class="fl pic_icon"><span class="imgpq icon_<?php if ($_smarty_tpl->getVariable('users')->value[26]==0){?>sigh<?php }else{ ?>yes<?php }?>"></span></div>
                            <div class="fl name">证件信息<span class="<?php if ($_smarty_tpl->getVariable('users')->value[26]==0){?>red">（未<?php }else{ ?>green">（已<?php }?>设置）</span></div>
                            <div class="fl text">用于帐号防沉迷认证和密码遗失时重置密码</div>
                            <div class="fr safe_btn"><?php if ($_smarty_tpl->getVariable('users')->value[26]==0){?><a href="<?php echo $_smarty_tpl->getVariable('root_url')->value;?>
user.php?act=indulge" class="btn1">立即设置</a><?php }?></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--导入公共页脚文件-->
<?php $_template = new Smarty_Internal_Template('footer.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
</body>
</html>
