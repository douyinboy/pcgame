<?php /* Smarty version Smarty-3.0.6, created on 2016-01-23 20:41:45
         compiled from "/home/www/www.demo.com/template/user_info.html" */ ?>
<?php /*%%SmartyHeaderCode:10162807156a375097bd291-09458880%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '867a2e0a47eaaa1303c0061d92583cdf6f57ffe6' => 
    array (
      0 => '/home/www/www.demo.com/template/user_info.html',
      1 => 1453517567,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10162807156a375097bd291-09458880',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_truncate')) include '/home/www/www.demo.com/smarty/plugins/modifier.truncate.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getVariable('chinese_title')->value;?>
-用户中心-我的资料</title>
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/base.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/public.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('image_url')->value;?>
css/www/main_pq.css" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
function.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('js_url')->value;?>
user.js"></script>
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
                <div class="user_hd"><h2>我的资料</h2></div>
                <ul class="fill_list">
                    <form id="frm" name="frm" action="" method="post" onsubmit="return my_info_sumbit();">
                    <input type="hidden" name="stage" value="yes">
                    <li><label>昵称：</label><input type="text" name="nickname" id="nickname" class="input_t" style="width:258px" value="<?php echo $_smarty_tpl->getVariable('users')->value[2];?>
" /></li>
                    <li style="line-height:40px"><label>性别：</label><input name="sex" type="radio" id="sex" value="男" <?php if ($_smarty_tpl->getVariable('users')->value[5]=="男"||$_smarty_tpl->getVariable('users')->value[5]=="1"){?>checked<?php }?> class="radio" />&nbsp;男&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="sex" <?php if ($_smarty_tpl->getVariable('users')->value[5]=="女"||$_smarty_tpl->getVariable('users')->value[5]=="0"){?>checked<?php }?> id="sex" value="女" class="radio" />&nbsp;女</li>
                    <li><label>生日：</label><input type="text" name="birthday" id="birthday" class="input_t" style="width:258px" value="<?php echo $_smarty_tpl->getVariable('users')->value[6];?>
" /></li>
                    <li>
                        <?php if ($_smarty_tpl->getVariable('users')->value[25]){?>
                            <label>邮箱</label>
                            <input type="text" disabled class="input_t" style="width:258px" value='<?php echo smarty_modifier_truncate($_smarty_tpl->getVariable('users')->value[1],"8","*****",true);?>
' />
                            <input id="emailt" type="hidden" value="<?php echo $_smarty_tpl->getVariable('users')->value[1];?>
" />
                        <?php }else{ ?>
                            <label>邮箱：</label><input type="text" name="email" id="email" class="input_t" style="width:258px" />
                        <?php }?>
                    </li>
                    <li><label>电话：</label><input type="text" name="telephone" id="telephone" class="input_t" style="width:258px" value="<?php echo $_smarty_tpl->getVariable('users')->value[9];?>
" onKeyUp="value=value.replace(/[^0-9]/g,'')" /></li>
                    <li><label>QQ：</label><input type="text" name="qq" id="qq" maxlength="12" class="input_t" style="width:258px" value="<?php echo $_smarty_tpl->getVariable('users')->value[13];?>
" onKeyUp="value=value.replace(/[^0-9]/g,'')" /></li>
                    <li><label>&nbsp;</label><a href="javascript:void(0)" class="game_btn2" onclick="$('#frm').submit();" style="width:290px">确 认</a></li>
                    <li>
                        <label>&nbsp;</label>
                        <font color="red"><?php echo $_smarty_tpl->getVariable('error')->value;?>
</font>
                    </li>
                    </form>
                </ul>
            </div>
        </div>
    </div>
</div>

<!--导入公共页脚文件-->
<?php $_template = new Smarty_Internal_Template('footer.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
</body>
</html>
